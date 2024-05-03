<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('first_last_name');
            $table->string('email');
            $table->string('phone_number');
            $table->date('date_birth');
            $table->string('password');
            $table->integer('status');
            $table->integer('id_permission')->nullable();
            $table->string('hash_reset');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('admins');
    }
};
