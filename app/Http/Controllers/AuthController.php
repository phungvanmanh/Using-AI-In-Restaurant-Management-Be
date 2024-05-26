<?php

namespace App\Http\Controllers;

use App\Http\Requests\Login\CheckLogin;
use App\Models\Admin;
use App\Models\HoaDonBanHang;
use App\Models\KhuVuc;
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

        // Fetch the admin record
        $admin = \App\Models\Admin::where('email', $credentials['email'])->first();

        // Check if admin exists and status is 1
        if (!$admin || $admin->status != 1) {
            return response()->json(['message' => 'Account is inactive or does not exist!'], 401);
        }

        // Attempt to generate a token
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
        $userId = Auth::guard('admin')->user()->id; // Get the ID of the logged-in user
        $user = Admin::join('quyens', 'admins.id_permission', '=', 'quyens.id')
            ->where('admins.id', $userId)
            ->select('admins.id', 'admins.first_last_name', 'quyens.name_permission')
            ->first();

        if (!$user) {
            return response()->json(['message' => 'User information not found'], 404);
        }

        $dataKhu = KhuVuc::get();
        $str_khu = "";

        foreach ($dataKhu as $key => $value) {
            if (strpos($value->list_admin, (string)$user->id) !== false) {
                $str_khu .= $value->id . ",";
            }
        }

        // Remove trailing comma
        $str_khu = rtrim($str_khu, ',');

        $user->list_khu = $str_khu; // Add the list of khu to the user object

        return response()->json($user, 200);
    }


    public function generateQRCode($id_ban)
    {
        $x = $this->checkRule(8);
        if($x)  {
            return response()->json([
                'status'    => 0,
                'message'   => 'You are not authorized!',
            ]);
        }
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

    public function checkAvailability(Request $request)
    {
        $token = Token::where('token', $request->token)->first();

        if ($token) {
            return response()->json(['isActive' => true]);
        } else {
            return response()->json(['isActive' => false]);
        }
    }
}
