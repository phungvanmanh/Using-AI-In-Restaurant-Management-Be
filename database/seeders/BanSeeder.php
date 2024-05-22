<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BanSeeder extends Seeder
{
    public function run()
    {
        DB::table('bans')->delete();
        DB::table('bans')->truncate();
        DB::table('bans')->insert([
            [
                'name_table'    => 'A01',
                'slug_table'    => 'a01',
                'id_area'       =>  1,
                'status'        => random_int(0, 1),
                'is_open_table' => 0
            ],
            [
                'name_table'    => 'A02',
                'slug_table'    => 'a02',
                'id_area'       =>  1,
                'status'        => random_int(0, 1),
                'is_open_table' => 0
            ],
            [
                'name_table'    => 'A03',
                'slug_table'    => 'a03',
                'id_area'       =>  1,
                'status'        => random_int(0, 1),
                'is_open_table' => 0
            ],
            [
                'name_table'    => 'A04',
                'slug_table'    => 'a04',
                'id_area'       =>  1,
                'status'        => random_int(0, 1),
                'is_open_table' => 0
            ],
            [
                'name_table'    => 'A05',
                'slug_table'    => 'a05',
                'id_area'       =>  1,
                'status'        => random_int(0, 1),
                'is_open_table' => 0
            ],
            [
                'name_table'    => 'A06',
                'slug_table'    => 'a06',
                'id_area'       =>  1,
                'status'        => random_int(0, 1),
                'is_open_table' => 0
            ],
            [
                'name_table'    => 'A07',
                'slug_table'    => 'a07',
                'id_area'       =>  1,
                'status'        => random_int(0, 1),
                'is_open_table' => 0
            ],
            [
                'name_table'    => 'B02',
                'slug_table'    => 'b02',
                'id_area'       =>  2,
                'status'        => random_int(0, 1),
                'is_open_table' => 0
            ],
            [
                'name_table'    => 'B03',
                'slug_table'    => 'b03',
                'id_area'       =>  2,
                'status'        => random_int(0, 1),
                'is_open_table' => 0
            ],
            [
                'name_table'    => 'B04',
                'slug_table'    => 'b04',
                'id_area'       =>  2,
                'status'        => random_int(0, 1),
                'is_open_table' => 0
            ],
            [
                'name_table'    => 'B05',
                'slug_table'    => 'b05',
                'id_area'       =>  2,
                'status'        => random_int(0, 1),
                'is_open_table' => 0
            ],
            [
                'name_table'    => 'B06',
                'slug_table'    => 'b07',
                'id_area'       =>  2,
                'status'        => random_int(0, 1),
                'is_open_table' => 0
            ],
            [
                'name_table'    => 'C01',
                'slug_table'    => 'c01',
                'id_area'       =>  3,
                'status'        => random_int(0, 1),
                'is_open_table' => 0
            ],
            [
                'name_table'    => 'C02',
                'slug_table'    => 'c02',
                'id_area'       =>  3,
                'status'        => random_int(0, 1),
                'is_open_table' => 0
            ],
            [
                'name_table'    => 'C03',
                'slug_table'    => 'c03',
                'id_area'       =>  3,
                'status'        => random_int(0, 1),
                'is_open_table' => 0
            ],
            [
                'name_table'    => 'C04',
                'slug_table'    => 'c04',
                'id_area'       =>  3,
                'status'        => random_int(0, 1),
                'is_open_table' => 0
            ],
            [
                'name_table'    => 'C05',
                'slug_table'    => 'c05',
                'id_area'       =>  3,
                'status'        => random_int(0, 1),
                'is_open_table' => 0
            ],
            [
                'name_table'    => 'C06',
                'slug_table'    => 'c06',
                'id_area'       =>  3,
                'status'        => random_int(0, 1),
                'is_open_table' => 0
            ],
            [
                'name_table'    => 'C07',
                'slug_table'    => 'c07',
                'id_area'       =>  3,
                'status'        => random_int(0, 1),
                'is_open_table' => 0
            ],
            [
                'name_table'    => 'D01',
                'slug_table'    => 'd01',
                'id_area'       =>  4,
                'status'        => random_int(0, 1),
                'is_open_table' => 0
            ],
            [
                'name_table'    => 'D02',
                'slug_table'    => 'd02',
                'id_area'       =>  4,
                'status'        => random_int(0, 1),
                'is_open_table' => 0
            ],
            [
                'name_table'    => 'D03',
                'slug_table'    => 'd03',
                'id_area'       =>  4,
                'status'        => random_int(0, 1),
                'is_open_table' => 0
            ],
            [
                'name_table'    => 'D04',
                'slug_table'    => 'd04',
                'id_area'       =>  4,
                'status'        => random_int(0, 1),
                'is_open_table' => 0
            ],
            [
                'name_table'    => 'D05',
                'slug_table'    => 'd05',
                'id_area'       =>  4,
                'status'        => random_int(0, 1),
                'is_open_table' => 0
            ],
            [
                'name_table'    => 'D06',
                'slug_table'    => 'd06',
                'id_area'       =>  4,
                'status'        => random_int(0, 1),
                'is_open_table' => 0
            ],
            [
                'name_table'    => 'D07',
                'slug_table'    => 'd07',
                'id_area'       =>  4,
                'status'        => random_int(0, 1),
                'is_open_table' => 0
            ],
            [
                'name_table'    => 'E01',
                'slug_table'    => 'e01',
                'id_area'       =>  5,
                'status'        => random_int(0, 1),
                'is_open_table' => 0
            ],
            [
                'name_table'    => 'E02',
                'slug_table'    => 'e02',
                'id_area'       =>  5,
                'status'        => random_int(0, 1),
                'is_open_table' => 0
            ],
            [
                'name_table'    => 'E03',
                'slug_table'    => 'e03',
                'id_area'       =>  5,
                'status'        => random_int(0, 1),
                'is_open_table' => 0
            ],
            [
                'name_table'    => 'E04',
                'slug_table'    => 'e04',
                'id_area'       =>  5,
                'status'        => random_int(0, 1),
                'is_open_table' => 0
            ],
            [
                'name_table'    => 'E05',
                'slug_table'    => 'e05',
                'id_area'       =>  5,
                'status'        => random_int(0, 1),
                'is_open_table' => 0
            ],
            [
                'name_table'    => 'E06',
                'slug_table'    => 'e06',
                'id_area'       =>  5,
                'status'        => random_int(0, 1),
                'is_open_table' => 0
            ],
            [
                'name_table'    => 'E07',
                'slug_table'    => 'e07',
                'id_area'       =>  5,
                'status'        => random_int(0, 1),
                'is_open_table' => 0
            ],
            [
                'name_table'    => 'F01',
                'slug_table'    => 'f01',
                'id_area'       =>  6,
                'status'        => random_int(0, 1),
                'is_open_table' => 0
            ],
            [
                'name_table'    => 'F02',
                'slug_table'    => 'f02',
                'id_area'       =>  6,
                'status'        => random_int(0, 1),
                'is_open_table' => 0
            ],
            [
                'name_table'    => 'F03',
                'slug_table'    => 'f03',
                'id_area'       =>  6,
                'status'        => random_int(0, 1),
                'is_open_table' => 0
            ],
            [
                'name_table'    => 'F04',
                'slug_table'    => 'f04',
                'id_area'       =>  6,
                'status'        => random_int(0, 1),
                'is_open_table' => 0
            ],
            [
                'name_table'    => 'F05',
                'slug_table'    => 'f05',
                'id_area'       =>  6,
                'status'        => random_int(0, 1),
                'is_open_table' => 0
            ],
            [
                'name_table'    => 'F06',
                'slug_table'    => 'f06',
                'id_area'       =>  6,
                'status'        => random_int(0, 1),
                'is_open_table' => 0
            ],
            [
                'name_table'    => 'F07',
                'slug_table'    => 'f07',
                'id_area'       =>  6,
                'status'        => random_int(0, 1),
                'is_open_table' => 0
            ],
        ]);
    }
}
