<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('mon_ans', function (Blueprint $table) {
            $table->id();
            $table->string('food_name');
            $table->string('image');
            $table->float('price');
            $table->integer('status');
            $table->float('total_input')->nullable();
            $table->float('total_ouput')->nullable();
            $table->integer('id_category')->nullable();

            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('mon_ans');
    }
};
