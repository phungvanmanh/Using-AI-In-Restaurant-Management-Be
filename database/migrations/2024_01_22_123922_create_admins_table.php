<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('ho_va_ten');
            $table->string('email');
            $table->string('so_dien_thoai');
            $table->date('ngay_sinh');
            $table->string('password');
            $table->integer('tinh_trang');
            $table->integer('id_quyen')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('admins');
    }
};
