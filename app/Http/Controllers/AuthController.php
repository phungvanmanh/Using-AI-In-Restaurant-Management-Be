<?php

namespace App\Http\Controllers;

use App\Http\Requests\Login\CheckLogin;
use App\Models\Admin;
use App\Models\HoaDonBanHang;
use App\Models\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(CheckLogin $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = Auth::guard('admin')->attempt($credentials)) {
            return response()->json(['message' => 'Account password incorrect!'], 401);
        }

        return $this->respondWithToken($token);
    }


    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::guard('admin')->factory()->getTTL() * 60
        ]);
    }

    public function logout()
    {
        // Đăng xuất người dùng
        Auth::logout();

        return response()->json([
            'status'  => 1,
            'message' => 'Logout successful'
        ]);
    }

    public function getUser()
    {
        $userId = Auth::guard('admin')->user()->id; // Lấy ID của người dùng đang đăng nhập
        $user = Admin::join('quyens', 'admins.id_permission', '=', 'quyens.id')
            ->where('admins.id', $userId)
            ->select('admins.id', 'admins.first_last_name', 'quyens.name_permission')
            ->first();

        if (!$user) {
            return response()->json(['message' => 'User information not found'], 404);
        }

        return response()->json($user, 200);
    }

    public function generateQRCode($id_ban)
    {
        // Sử dụng firstOrCreate để tìm Token hoặc tạo mới nếu không tồn tại
        $tokenModel = Token::firstOrCreate(
            ['id_ban' => $id_ban],
            ['token' => Str::random(40)]
        );
        $id_hoa_don = HoaDonBanHang::where('id_ban', $id_ban)->where('is_done', 0)->first();
        // Xây dựng URL với token tìm được hoặc token mới tạo
        $url = "/mon-an/{$id_ban}/{$id_hoa_don->id}?token={$tokenModel->token}";

        return response()->json(['url' => $url]);
    }

    public function checkQRCode(Request $request)
    {
        $token = $request->token;
        $status = Cache::get($token)['status'] ?? 'expired';
        return response()->json(['status' => $status]);
    }
}
