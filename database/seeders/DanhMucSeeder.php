<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DanhMucSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('danh_mucs')->delete();
        DB::table('danh_mucs')->truncate();
        DB::table('danh_mucs')->insert([
            ['id' => 1, 'name_category' => 'Cá mú', 'slug_category' => 'ca-mu', 'status' => 1],
            ['id' => 2, 'name_category' => 'Thịt bò', 'slug_category' => 'thit-bo', 'status' => 1],
            ['id' => 3, 'name_category' => 'Tôm hùm', 'slug_category' => 'tom-hum', 'status' => 1],
            ['id' => 4, 'name_category' => 'Cua hoàng đế', 'slug_category' => 'cua-hoang-de', 'status' => 1],
            ['id' => 5, 'name_category' => 'Ốc biển', 'slug_category' => 'oc-bien', 'status' => 1],
            ['id' => 6, 'name_category' => 'Thịt heo', 'slug_category' => 'thit-heo', 'status' => 1],
            ['id' => 7, 'name_category' => 'Nước Uống', 'slug_category' => 'nuoc-uong', 'status' => 1],
            ['id' => 8, 'name_category' => 'Trái Cây', 'slug_category' => 'trai-cay', 'status' => 1],
        ]);
    }
}
