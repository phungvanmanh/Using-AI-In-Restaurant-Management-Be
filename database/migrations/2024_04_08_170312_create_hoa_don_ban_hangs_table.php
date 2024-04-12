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
        Schema::create('hoa_don_ban_hangs', function (Blueprint $table) {
            $table->id();
            $table->integer('tong_tien_truoc_giam')->default(0);
            $table->integer('phan_tram_giam')->default(0);
            $table->integer('tien_thuc_nhan')->default(0);
            $table->string('ghi_chu')->nullable();
            $table->integer('id_ban');
            $table->integer('id_nhan_vien');
            $table->integer('is_done')->default(0);
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
        Schema::dropIfExists('hoa_don_ban_hangs');
    }
};
