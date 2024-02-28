<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('quyens', function (Blueprint $table) {
            $table->id();
            $table->string('ten_quyen');
            $table->integer('tinh_trang');
            $table->string('list_id_chuc_nang')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('quyens');
    }
};
