<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Traits\HandlesFileUpload;
use App\Models\TestUpload;

class FileController extends Controller
{
    use HandlesFileUpload;
    public function uploadFile(Request $request) {
        $result = $this->saveFiles($request, 'files', '/files/');
        TestUpload::create([
            'image' => $result
        ]);
        return response()->json($result);
    }

    public function getData()
    {
        $data = TestUpload::get();
        return response()->json([
            'status'    => 1,
            'data'      => $data,
        ]);
    }
}
