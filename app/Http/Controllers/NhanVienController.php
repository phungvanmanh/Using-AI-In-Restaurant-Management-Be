<?php

namespace App\Http\Controllers;

use App\Http\Requests\NhanVien\CheckIdStaffRequest;
use App\Http\Requests\NhanVien\CreateStaffRequest;
use App\Http\Requests\NhanVien\UpdateStaffRequest;
use App\Models\NhanVien;
use Illuminate\Http\Request;


class NhanVienController extends Controller
{
    //LoadDb Staff
    public function getDataStaff()
    {
        $data = NhanVien::get();
        return response()->json([
            'data'   => $data,
        ]);
    }//LoadDb Staff

    //Create Staff
    public function createNhanVien(CreateStaffRequest $request)
    {
        $data = $request->all();
        NhanVien::create($data);

        return response()->json([
            'status'    => 1,
            'message'   => 'New staff added successfully!',
        ]);
    }//Create Staff

    //Change Staff Status
    public function changeStatus(CheckIdStaffRequest $request)
    {
        $nhan_vien = NhanVien::find($request->id);
        $nhan_vien->status = !$nhan_vien->status;
        $nhan_vien->save();

        return response()->json([
            'status'    => 1,
            'message'   => 'Status changed successfully!',
        ]);
    }//Change Staff Status

    //Update Staff
    public function updateNhanVien(UpdateStaffRequest $request)
    {
        $data = $request->all();
        $nhan_vien = NhanVien::where('id', $request->id)->first();

        $nhan_vien->update($data);

        return response()->json([
            'status'    => 1,
            'message'   => 'Updated successfully!',
        ]);
    }//Update Staff
    
}
