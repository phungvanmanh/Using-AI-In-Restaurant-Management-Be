<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\LichLamViec;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function getGivenName($fullName) {
        $parts = explode(' ', $fullName);
        return end($parts);
    }

    public function getDays($type){
        $type = 7 * $type;
        $user = Auth::guard('admin')->user()->id;
        $now  = Carbon::today()->addDays($type);
        $thu  = $now->dayOfWeek == 0 ? 8 : $now->dayOfWeek + 1;
        $weekStartDate = Carbon::today()->addDays(9 + $type - $thu);
        $weekEndDate   = Carbon::today()->addDays(15 + $type - $thu);
        $days = [];
        // dd($weekStartDate->format('Y-m-d'), $weekEndDate);
        $lichLamViecAll  = LichLamViec::whereDate('ngay_lam_viec', '>=', $weekStartDate->format('Y-m-d'))
                                        ->whereDate('ngay_lam_viec', '<=', $weekEndDate->format('Y-m-d'))
                                        ->get();

        $lichLamViecUser = LichLamViec::where('id_nhan_vien', $user)/*user->id*/
                            ->whereDate('ngay_lam_viec', '>=', $weekStartDate)
                            ->whereDate('ngay_lam_viec', '<=', $weekEndDate)
                            ->get();

        array_push($days, $weekStartDate->format('Y-m-d'));
        for ($i = 1; $i < 7; $i++) {
            array_push($days, $weekStartDate->addDay()->format('Y-m-d'));
        }

        $weekStartDate = Carbon::today()->addDays(9 + $type - $thu);

        $data = [];
        for ($i = $weekStartDate; $i <= $weekEndDate; $i->addDay()) {
            for ($j = 0; $j < 2; $j++) {
                $id = 0;
                $data[$i->format('Y-m-d')][$j] = 0;
                $arr_info = [];
                foreach ($lichLamViecUser as $key => $value) {
                    if ($value->ngay_lam_viec == $i->format('Y-m-d') && $j == $value->buoi_lam_viec) {
                        // dd($value);
                        $id  = $value->id;
                        break;
                    }
                }

                foreach ($lichLamViecAll as $key => $value) {
                    if ($value->ngay_lam_viec == $i->format('Y-m-d') && $j == $value->buoi_lam_viec) {
                        $nhanVien = Admin::find($value->id_nhan_vien);
                        array_push($arr_info, $this->getGivenName($nhanVien->first_last_name));
                    }
                }

                $info = collect([
                    'id'            => $id,
                    'list'          => $arr_info,
                    // 'ids'           => $ids,
                ]);
                $data[$i->format('Y-m-d')][$j] = $info;
            }
        }



        return response()->json([
            'days'  => $days,
            'data'  => $data,
        ]);
    }

    function createModel($request, $modelClassName, $responseData = []) {
        $data = $request->all();

        // Tạo mới model
        $modelClassName::create($data);

        // Trả về response
        $defaultResponseData = [
            'status'    => 1,
            'message'   => 'Added successfully!',
        ];

        $responseData = array_merge($defaultResponseData, $responseData);

        return response()->json($responseData);
    }

    function changeStatusOrUpdateModel($request, $modelClassName, $action = 'changeStatus', $responseData = []) {
        $data = $request->all();
        $id = $request->id;

        $model = $modelClassName::find($id);

        if ($action === 'changeStatus') {
            $model->status = !$model->status;
            $model->save();
            $message = 'Status changed successfully!';
        } elseif ($action === 'update') {
            $model->update($data);
            $message = 'Updated successfully!';
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Invalid action!',
            ]);
        }

        $defaultResponseData = [
            'status'    => 1,
            'message'   => $message,
        ];

        $responseData = array_merge($defaultResponseData, $responseData);

        return response()->json($responseData);
    }

    function deleteModel($request, $modelClassName, $fieldName = '', $responseData = []) {
        $id = $request->id;

        $model = $modelClassName::find($id);

        if (!$model) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Record not found!',
            ]);
        }

        // Lấy giá trị của trường từ request
        $fieldNameValue = $request->$fieldName;

        // Nếu không tìm thấy giá trị hoặc trường không tồn tại trong request
        if (!$fieldNameValue) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Invalid field value!',
            ]);
        }

        $model->delete();

        $defaultResponseData = [
            'status'    => 1,
            'message'   => $fieldNameValue . ' removed successfully!',
        ];

        $responseData = array_merge($defaultResponseData, $responseData);

        return response()->json($responseData);
    }
}
