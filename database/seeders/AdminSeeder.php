<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->delete();

        DB::table('admins')->truncate();

        DB::table('admins')->insert([
            [
                'email'                 => 'admin@master.com',
                'first_last_name'             => 'Admin',
                'password'              => bcrypt(123456),
                'phone_number'         => '0905523543',
                'id_permission'              => '1',
                'date_birth'             => '2023-01-01',
                'status'               => 1,
            ],
        ]);
    }
}
