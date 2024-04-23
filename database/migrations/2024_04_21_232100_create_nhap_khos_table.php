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
        Schema::create('nhap_khos', function (Blueprint $table) {
            $table->id();
            $table->integer('id_nguyen_lieu');
            $table->integer('id_hoa_don_nhap_kho');
            $table->integer('so_luong')->default(1);
            $table->integer('don_gia')->default(0);
            $table->integer('thanh_tien')->default(0);
            $table->integer('id_nhan_vien');
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
        Schema::dropIfExists('nhap_khos');
    }
};
