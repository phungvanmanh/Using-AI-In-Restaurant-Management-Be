<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("admins") -> insert([
            "ho_va_ten" => "staff",
            "email" => "huykd36@gmail.com",
            "so_dien_thoai" => "012345",
            "password" => Hash::make("12345"),
            "tinh_trang" => "2",
        ]);
    }
}
