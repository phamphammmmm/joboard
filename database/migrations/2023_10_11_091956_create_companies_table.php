<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateCompaniesTable extends Migration
{
    public function up()
{
    Schema::create('companies', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->string('name', 255)->unique();
        $table->string('email', 255)->unique();
        $table->text('description')->nullable();
        $table->string('path')->nullable();
        $table->timestamps();
    });
}


    public function down()
    {
        Schema::dropIfExists('companies');
    }
}