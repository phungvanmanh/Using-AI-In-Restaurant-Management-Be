<?php

namespace App\Http\Controllers;

use App\Exports\KhachHangExport;
use App\Http\Requests\CreateKhachHangRequest;
use App\Http\Requests\UpdateKhachHangRequest;
use App\Mail\SendMaiOTP;
use App\Models\HoaDonBanHang;
use App\Models\KhachHang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class KhachHangController extends Controller
{

    public function store(CreateKhachHangRequest $request)
    {
        $validated = $request->validate([
            'ten_khach_hang'    => 'required|string|max:255',
            'email'  => 'required|email|max:255',
            'so_dien_thoai'     => 'required|max:10',
            'id_hoa_don'        => 'required|exists:hoa_don_ban_hangs,id',
        ]);

        $khach_hang = KhachHang::firstOrCreate(
            [
                'email' => $validated['email'],
            ],
            [
                'ten_khach_hang'   => $validated['ten_khach_hang'],
                'so_dien_thoai'    => $validated['so_dien_thoai'],
            ]
        );

        $hoa_don = HoaDonBanHang::find($request->id_hoa_don);

        if (!$hoa_don) {
            return response()->json(['error' => 'HoaDonBanHang not found'], 404);
        }

        $hoa_don->id_khach_hang = $khach_hang->id;
        $hoa_don->save();

        return response()->json([
            'status'=>1,
            'message' => 'Operation successful']);
    }

    public function getData()
    {
        $data = KhachHang::get();
        return response()->json([
            'status'    => true,
            'data'   => $data,
        ]);
    }

    public function updateKh(UpdateKhachHangRequest $request)
    {
        return $this->changeStatusOrUpdateModel($request, KhachHang::class, 'update');
    }

    public function deleteKh(Request $request)
    {
        return $this->deleteModel($request, KhachHang::class, 'ten_khach_hang');
    }

    public function export()
    {
        $data = KhachHang::get();
        Log::info('Exporting data:', $data->toArray());
        return Excel::download(new KhachHangExport($data), 'khachhang.xlsx');
    }

    public function sendMailOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = KhachHang::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $otp = rand(1000, 9999); // Generate a 6-digit OTP

        // Save OTP to the user model or another storage system you prefer
        $user->otp = $otp;
        $user->password = bcrypt($otp);
        $user->save();

        // Send OTP via email or other means
        $data['email'] = $user->email;
        $data['otp']   = $user->otp;

        Mail::to($user->email)->queue(new SendMaiOTP($data));

        return response()->json(['status'       => 1,'message' => 'OTP sent to your email!']);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = Auth::guard('khach_hang')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'status' => 1,
            'message' => 'Logged in successfully!',
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::guard('khach_hang')->factory()->getTTL() * 60
        ]);
    }

    public function logout()
    {
        Auth::logout();

        return response()->json([
            'status'  => 1,
            'message' => 'Logout successful'
        ]);
    }
    public function searchKhachHang(Request $request)
    {
        {

            $key = '%' . $request->abc . '%';

            $data   = KhachHang::where('ten_khach_hang', 'like', $key)
                ->get();

            return response()->json([
                'data'  =>  $data,
            ]);
        }
    }
}
