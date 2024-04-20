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
            $table->string('name_permission');
            $table->integer('status');
            $table->integer('amount')->nullable();
            $table->string('list_id_function')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('quyens');
    }
};
