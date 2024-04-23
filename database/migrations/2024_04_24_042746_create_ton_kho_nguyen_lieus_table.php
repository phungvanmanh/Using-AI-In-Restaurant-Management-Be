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
        Schema::create('ton_kho_nguyen_lieus', function (Blueprint $table) {
            $table->id();
            $table->integer('id_nguyen_lieu');
            $table->integer('so_luong');
            $table->integer('so_luong_ton')->default(0);
            $table->date('ngay')->default(0);
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
        Schema::dropIfExists('ton_kho_nguyen_lieus');
    }
};
