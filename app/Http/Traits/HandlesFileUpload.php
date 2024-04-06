<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;

trait HandlesFileUpload
{
    public function saveFiles(Request $request, $inputName = 'files', $storagePath = '/files/')
    {
        $paths = []; // Mảng để lưu trữ đường dẫn của các file đã lưu

        if ($request->hasfile($inputName)) {
            foreach ($request->file($inputName) as $file) {
                $name = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path() . $storagePath, $name); // Lưu file
                $paths[] = $storagePath. $name; // Thêm đường dẫn của file vào mảng
            }
        }

        $str = implode(',', $paths);

        return $str;
    }
}
