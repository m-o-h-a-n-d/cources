<?php  

namespace App\Utility;

use InvalidArgumentException;
use RuntimeException;

class ImageManager
{
    /**
     * Allowed MIME types for image uploads.
     */
    protected static array $allowedMimeTypes = [
        'image/jpeg',
        'image/png',
        'image/webp',
        'image/gif',
    ];

    /**
     * Allowed file extensions.
     */
    protected static array $allowedExtensions = [
        'jpg',
        'jpeg',
        'png',
        'webp',
        'gif',
    ];

    /**
     * Max size 2MB.
     */
    protected static int $maxSizeBytes = 2097152;

    public static function uploadImage(array $image, string $folder): string
    {
        if (!isset($image['tmp_name']) || empty($image['tmp_name']) || !is_uploaded_file($image['tmp_name'])) {
            throw new InvalidArgumentException("No valid image file uploaded.");
        }

        if (isset($image['error']) && $image['error'] !== UPLOAD_ERR_OK) {
            throw new RuntimeException("Image upload error code: {$image['error']}");
        }

        if (isset($image['size']) && $image['size'] > static::$maxSizeBytes) {
            throw new InvalidArgumentException("Image file size exceeds maximum limit of 2MB.");
        }

        // Validate MIME type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $image['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mimeType, static::$allowedMimeTypes, true)) {
            throw new InvalidArgumentException("Invalid image MIME type: {$mimeType}");
        }

        // Validate file extension
        $originalName = basename($image['name']);
        $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

        if (!in_array($extension, static::$allowedExtensions, true)) {
            throw new InvalidArgumentException("Disallowed file extension: {$extension}");
        }

        // Sanitize folder name against path traversal
        $folder = preg_replace('/[^a-zA-Z0-9_-]/', '', $folder);
        $targetDir = base_path('public/images/' . $folder);

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        // Generate safe unique filename
        $safeFileName = time() . '_' . bin2hex(random_bytes(8)) . '.' . $extension;
        $destinationPath = $targetDir . '/' . $safeFileName;

        if (!move_uploaded_file($image['tmp_name'], $destinationPath)) {
            throw new RuntimeException("Failed to move uploaded file.");
        }

        return $safeFileName;
    }

    public static function deleteImage(string $imagePathRelative): void
    {
        // Sanitize path against path traversal attacks
        $parts = array_map(fn($part) => basename($part), explode('/', str_replace('\\', '/', $imagePathRelative)));
        $cleanRelativePath = implode('/', array_filter($parts));

        $fullPath = base_path('public/images/' . $cleanRelativePath);

        if (file_exists($fullPath) && is_file($fullPath)) {
            unlink($fullPath);
        }
    }
}