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
        Schema::create('lich_lam_viecs', function (Blueprint $table) {
            $table->id();
            $table->integer('id_nhan_vien');
            $table->integer('buoi_lam_viec');
            $table->date('ngay_lam_viec');
            $table->time('gio_bat_dau');
            $table->time('gio_ket_thuc');
            $table->integer('is_done')->default(0)->comment('0: chưa điểm danh, 1: đã điểm danh');
            $table->integer('check_lich')->default(0);
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
        Schema::dropIfExists('lich_lam_viecs');
    }
};
