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
                'email'                => 'admin@master.com',
                'first_last_name'      => 'Admin',
                'password'             => bcrypt(123456),
                'phone_number'         => '0551850395 ',
                'id_permission'        => '1',
                'date_birth'           => '2023-01-01',
                'status'               => 1,
            ],
            [
                'email'                => 'luongtronglinh@gmail.com',
                'first_last_name'      => 'Lương Trọng Linh',
                'password'             => bcrypt(123456),
                'phone_number'         => '0711073043',
                'id_permission'        => '3',
                'date_birth'           => '2023-01-01',
                'status'               => 1,
            ],
            [
                'email'                => 'vuthihoailinh@gmail.com',
                'first_last_name'      => 'Lương Trọng Linh',
                'password'             => bcrypt(123456),
                'phone_number'         => '0952832452',
                'id_permission'        => '3',
                'date_birth'           => '2023-01-01',
                'status'               => 1,
            ],
            [
                'email'                => 'huynhvanthien@gmail.com',
                'first_last_name'      => 'Lương Trọng Linh',
                'password'             => bcrypt(123456),
                'phone_number'         => '0951825039',
                'id_permission'        => '2',
                'date_birth'           => '2023-01-01',
                'status'               => 1,
            ],
            [
                'email'                => 'dangdinhhuy@gmail.com',
                'first_last_name'      => 'Lương Trọng Linh',
                'password'             => bcrypt(123456),
                'phone_number'         => '0399882085',
                'id_permission'        => '4',
                'date_birth'           => '2023-01-01',
                'status'               => 1,
            ],
        ]);
    }
}
