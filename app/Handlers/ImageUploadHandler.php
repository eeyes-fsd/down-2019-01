<?php

namespace App\Handlers;

class ImageUploadHandler
{
    // 只允许以下后缀名的图片文件上传
    protected $allowed_ext = ["png", "jpg", "gif", 'jpeg', 'ico'];

    public function save($file,  $file_prefix)
    {
        $folder_name = "storage/icon";

        $upload_path = public_path() . '/' . $folder_name;

        $extension = strtolower($file->getClientOriginalExtension()) ?: 'png';

        $filename = $file_prefix . '_' . time() . '_' . str_random(10) . '.' . $extension;

        if ( ! in_array($extension, $this->allowed_ext)) {
            return false;
        }

        $file->move($upload_path, $filename);

        return [
            'path' => config('app.url') . "/$folder_name/$filename"
        ];
    }
}