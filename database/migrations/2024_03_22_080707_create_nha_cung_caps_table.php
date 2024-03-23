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
        Schema::create('nha_cung_caps', function (Blueprint $table) {
            $table->id();
            $table->string('ma_so_thue');
            $table->string('ten_cong_ty');
            $table->string('ten_nguoi_dai_dien');
            $table->integer('so_dien_thoai');
            $table->string('email');
            $table->string('dia_chi');
            $table->string('ten_goi_nho');
            $table->integer('tinh_trang');
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
        Schema::dropIfExists('nha_cung_caps');
    }
};
