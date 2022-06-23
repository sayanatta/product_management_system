<?php


namespace App\Traits;


trait ImageUpload
{
    public function saveImage($path,$newImage)
    {
        $file_name = '';
        if(!empty($newImage)) {
            $file_name =time() . '.' . $newImage->getClientOriginalExtension();
            $destinationPath = public_path($path);
            $newImage->move($destinationPath, $file_name);
        }
        return $file_name;
    }
}
