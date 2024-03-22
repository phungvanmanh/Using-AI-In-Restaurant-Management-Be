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
        Schema::create('khach_hangs', function (Blueprint $table) {
            $table->id();
            $table->string('ten_khach_hang');
            $table->string('email_khach_hang')->nullable();
            $table->integer('so_dien_thoai')->nullable();
            $table->date('DateofBirth')->nullable();
            $table->integer('rank_khach_hang')->nullable();
            $table->string('history_khach_hang')->nullable();
            $table->integer('score_khach_hang')->nullable();
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
        Schema::dropIfExists('khach_hangs');
    }
};
