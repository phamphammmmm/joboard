<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255)->unique();
            $table->string('password');
            $table->date('birthday');
            $table->string('email', 255)->unique();
            $table->text('fullname');
            $table->text('path');
            $table->text('major');
            $table->text('description')->nullable();
            $table->string('location')->nullable();
            $table->string('social_network')->nullable();
            $table->enum('type', ['recruiter', 'seeker', 'admin', 'moderator'])->default('seeker');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}