<?php

namespace Core\Environment;

class EnvLoader
{
    public function load(string $filePath): void
    {
        // .env is optional.
        // In production, environment variables may be provided
        // directly by the hosting platform.
        if (! file_exists($filePath)) {
            return;
        }

        $lines = file(
            $filePath,
            FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES
        );

        foreach ($lines as $line) {
            $line = trim($line);

            // Skip empty lines and comments
            if (
                $line === '' ||
                str_starts_with($line, '#')
            ) {
                continue;
            }

            // Split only on the first "="
            $parts = explode('=', $line, 2);

            // Skip invalid environment variables
            if (count($parts) !== 2) {
                continue;
            }

            [$key, $value] = $parts;

            $key = trim($key);
            $value = trim($value);

            // Skip invalid keys
            if ($key === '') {
                continue;
            }

            // Remove surrounding quotes
            $value = trim($value, "\"'");

            // Don't overwrite environment variables
            // already provided by the server/platform.
            if (! isset($_ENV[$key])) {
                $_ENV[$key] = $value;
            }
        }
    }
}