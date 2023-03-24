<?php

namespace App\Traits;

trait ImageUpload
{

    public function uploadImage($file)
    {

        try {

            $imageName = uuid_create() . '.' . $file->extension();
            //  $imageName = $file->getClientOriginalName();
            // Public Folder
            $file->move(public_path('images'), $imageName);
            //Store in Storage Folder
            // $request->logo->storeAs('images', $imageName);
            return $imageName;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function uploadFile($file)
    {

        try {

            $docName =uuid_create() . '.' . $file->extension();
            //  $docName = $file->getClientOriginalName();
            // Public Folder
            $file->move(public_path('docs'), $docName);
            //Store in Storage Folder
            // $request->logo->storeAs('images', $docName);
            return $docName;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function unlinkImage($file_name)
    {

        try {

            $path = public_path().'/images/';
            if ($file_name && file_exists($path.$file_name)) {
                unlink($path.$file_name);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
