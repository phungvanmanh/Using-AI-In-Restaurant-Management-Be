<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuyenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('quyens')->delete();
        DB::table('quyens')->truncate();

        DB::table('quyens')->insert([
            [
                'name_permission'       => 'Admin',
                'status'                => 1,
                'amount'                => 0,
                'list_id_function'      => '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100,101,102,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,124,125,126,127,128',
            ],
            [
                'name_permission'       => 'Nhân Viên',
                'status'                => 1,
                'amount'                => 150000,
                'list_id_function'      => '8,14,15,16,24,34,58,59,60,61,62,63,64,117,128',
            ],
            [
                'name_permission'       => 'Quản Lý Sự Kiện',
                'status'                => 1,
                'amount'                => 150000,
                'list_id_function'      => '14,15,16,47,48,49,50,51,52,53,54,55,56,57,115,116,117',
            ],
            [
                'name_permission'       => 'Quản Lý Nhân Sự',
                'status'                => 1,
                'amount'                => 150000,
                'list_id_function'      => '1,2,3,4,5,6,7,8,14,15,16,24,34,58,59,60,61,62,63,64,107,117,128',
            ],
        ]);
    }
}
