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
        Schema::create('chi_tiet_hoa_don_nhaps', function (Blueprint $table) {
            $table->id();
            $table->integer('id_nguyen_lieu');
            $table->string('id_hoa_don_nhap')->nullable();
            $table->integer('so_luong')->default(1);
            $table->integer('don_gia');
            $table->integer('thanh_tien');
            // $table->string('ghi_chu')->nullable();
            $table->integer('is_done')->default(0)->comment("0: Chưa nhập, 1: Đã nhập");
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
        Schema::dropIfExists('chi_tiet_hoa_don_nhaps');
    }
};
