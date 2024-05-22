<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NhaCungCapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('nha_cung_caps')->delete();
        DB::table('nha_cung_caps')->truncate();
        DB::table('nha_cung_caps')->insert([
            ['id' => 1, 'ma_so_thue' => '1234567891', 'ten_cong_ty' => 'CTTNHH HÀNG HOÁ', 'ten_nguoi_dai_dien' => 'Nhuyễn Thị Lan', 'so_dien_thoai' => '397757012', 'email' => 'hoanghoa@gmail.com', 'dia_chi' => 'Đà Nẵng', 'ten_goi_nho' => 'Hoàng Hoá', 'tinh_trang' => 1],
            ['id' => 2, 'ma_so_thue' => '1234567892', 'ten_cong_ty' => 'CTTNHH NƯỚC UỐNG', 'ten_nguoi_dai_dien' => 'Hồ Văn Tùng', 'so_dien_thoai' => '397757013', 'email' => 'nuocuong@gmail.com', 'dia_chi' => 'Hồ Chí Minh', 'ten_goi_nho' => 'Nước Giải Khát', 'tinh_trang' => 1],
            ['id' => 3, 'ma_so_thue' => '1234567893', 'ten_cong_ty' => 'CTTNHH RAUSACH', 'ten_nguoi_dai_dien' => 'Lê Thị Hoa', 'so_dien_thoai' => '397757777', 'email' => 'rausach@gmail.com', 'dia_chi' => 'Hải Phòng', 'ten_goi_nho' => 'Rau Sạch', 'tinh_trang' => 1],
            ['id' => 4, 'ma_so_thue' => '1234567894', 'ten_cong_ty' => 'CTTNHH HẢI SẢN', 'ten_nguoi_dai_dien' => 'Lê Văn An', 'so_dien_thoai' => '397755555', 'email' => 'haisan@gmail.com', 'dia_chi' => 'Đà Nẵng', 'ten_goi_nho' => 'Hải Sản', 'tinh_trang' => 1],
            ['id' => 5, 'ma_so_thue' => '1234567895', 'ten_cong_ty' => 'CTTNHH NGUYÊN LIỆU CHẾ BIẾN', 'ten_nguoi_dai_dien' => 'Nguyễn Văn Cảnh', 'so_dien_thoai' => '397757019', 'email' => 'ngcb@gmail.com', 'dia_chi' => 'Đà Nẵng', 'ten_goi_nho' => 'Nguyên Liệu', 'tinh_trang' => 1],
            ['id' => 6, 'ma_so_thue' => '1234567896', 'ten_cong_ty' => 'CTTNHH DỊCH VỤ TRÁI CÂY', 'ten_nguoi_dai_dien' => 'Lương Văn Linh', 'so_dien_thoai' => '394444444', 'email' => 'traicay@gmail.com', 'dia_chi' => 'Đà Nẵng', 'ten_goi_nho' => 'Trái Cây', 'tinh_trang' => 1],
        ]);
    }
}
