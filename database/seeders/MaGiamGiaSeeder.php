<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaGiamGiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ma_giam_gias')->delete();
        DB::table('ma_giam_gias')->truncate();
        DB::table('ma_giam_gias')->insert([
            ['id' => 1, 'ma_giam_gia' => 'AG123', 'id_mon' => 1, 'phan_tram_giam' => 10, 'ngay_bat_dau' => '2024-05-20', 'ngay_ket_thuc' => '2024-05-30', 'status' => 1],
            ['id' => 2, 'ma_giam_gia' => 'AG124', 'id_mon' => 2, 'phan_tram_giam' => 20, 'ngay_bat_dau' => '2024-05-20', 'ngay_ket_thuc' => '2024-05-30', 'status' => 1],
            ['id' => 3, 'ma_giam_gia' => 'AG125', 'id_mon' => 3, 'phan_tram_giam' => 15, 'ngay_bat_dau' => '2024-05-20', 'ngay_ket_thuc' => '2024-05-30', 'status' => 1],
            ['id' => 4, 'ma_giam_gia' => 'AG126', 'id_mon' => 4, 'phan_tram_giam' => 5, 'ngay_bat_dau' => '2024-05-20', 'ngay_ket_thuc' => '2024-05-30', 'status' => 1],
            ['id' => 5, 'ma_giam_gia' => 'AG127', 'id_mon' => 5, 'phan_tram_giam' => 5, 'ngay_bat_dau' => '2024-05-20', 'ngay_ket_thuc' => '2024-05-30', 'status' => 1],
            ['id' => 6, 'ma_giam_gia' => 'AG128', 'id_mon' => 10, 'phan_tram_giam' => 10, 'ngay_bat_dau' => '2024-05-20', 'ngay_ket_thuc' => '2024-05-30', 'status' => 1],
            ['id' => 7, 'ma_giam_gia' => 'AG129', 'id_mon' => 11, 'phan_tram_giam' => 20, 'ngay_bat_dau' => '2024-05-20', 'ngay_ket_thuc' => '2024-05-30', 'status' => 1],
            ['id' => 8, 'ma_giam_gia' => 'AG130', 'id_mon' => 12, 'phan_tram_giam' => 10, 'ngay_bat_dau' => '2024-05-20', 'ngay_ket_thuc' => '2024-05-30', 'status' => 1],
            ['id' => 9, 'ma_giam_gia' => 'AG131', 'id_mon' => 13, 'phan_tram_giam' => 10, 'ngay_bat_dau' => '2024-05-20', 'ngay_ket_thuc' => '2024-05-30', 'status' => 1],
            ['id' => 10, 'ma_giam_gia' => 'AG132', 'id_mon' => 14, 'phan_tram_giam' => 10, 'ngay_bat_dau' => '2024-05-20', 'ngay_ket_thuc' => '2024-05-30', 'status' => 1],
        ]);
    }
}
