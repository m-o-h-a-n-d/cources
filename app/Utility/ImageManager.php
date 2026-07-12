<?php  

namespace App\Utility;
class ImageManager{

    public static function uploadImage($image , $folder)
    {
        $imageName = time() . rand() . '_' . $image['name'];
        $imagePath = __DIR__ . '/../../public/images/' . $folder . '/' . $imageName;
        move_uploaded_file($image['tmp_name'], $imagePath);
        return $imageName;
    }


    public static function deleteImage($imageName)
    {
        $imagePath = __DIR__ . '/../../public/images/' . $imageName;

        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

    }



}