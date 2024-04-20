<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('luongs', function (Blueprint $table) {
            $table->id();
            $table->integer('id_nhan_vien');
            $table->integer('so_buoi_lam');
            $table->integer('hoa_hong')->default(0);
            $table->integer('tong_luong')->default(0);
            $table->dateTime('ngay_nhan_luong')->nullable();
            $table->integer('is_nhan')->default(0)->comment("0: Chưa Nhận, 1: Đã Nhận");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('luongs');
    }
};
