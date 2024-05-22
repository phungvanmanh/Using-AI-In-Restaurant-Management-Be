<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KhuVucSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('khu_vucs')->delete();

        DB::table('khu_vucs')->truncate();

        DB::table('khu_vucs')->insert([
            [
                'name_area'     => "Khu Vực A",
                'slug_area'     => "khu-vuc-a",
                'status'        => "1",
                'list_admin'    => "4",
            ],
            [
                'name_area'     => "Khu Vực B",
                'slug_area'     => "khu-vuc-b",
                'status'        => "1",
                'list_admin'    => "4",
            ],
            [
                'name_area'     => "Khu Vực C",
                'slug_area'     => "khu-vuc-c",
                'status'        => "1",
                'list_admin'    => "4",
            ],
            [
                'name_area'     => "Khu Vực D",
                'slug_area'     => "khu-vuc-d",
                'status'        => "1",
                'list_admin'    => "4",
            ],
            [
                'name_area'     => "Khu Vực E",
                'slug_area'     => "khu-vuc-e",
                'status'        => "1",
                'list_admin'    => "4",
            ],
            [
                'name_area'     => "Khu Vực F",
                'slug_area'     => "khu-vuc-f",
                'status'        => "1",
                'list_admin'    => "4",
            ],
        ]);
    }
}
