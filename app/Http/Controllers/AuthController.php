<?php

namespace App\Http\Controllers;

use App\Http\Requests\Login\CheckLogin;
use App\Models\Admin;
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
            return response()->json(['message' => 'Tài khoản mật khẩu không chính xác!'], 401);
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
            return response()->json(['message' => 'Không tìm thấy thông tin người dùng'], 404);
        }

        return response()->json($user, 200);
    }

    public function generateQRCode($id_ban)
    {
        $token = Str::random(40); // Tạo một token ngẫu nhiên
        $a = Token::where('id_ban', $id_ban)
                    ->first();
        if(!$a) {
            // Lưu token và id_ban vào database
            $tokenModel = Token::create([
                'token' => $token,
                'id_ban' => $id_ban
            ]);
        }
        $url = "/mon-an/{$id_ban}?token={$a->token}";
        return response()->json(['url' => $url]);
    }

    public function checkQRCode(Request $request)
    {
        $token = $request->token;
        $status = Cache::get($token)['status'] ?? 'expired';
        return response()->json(['status' => $status]);
    }
}
