<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->text('cv');
                $table->text('cover_letter');
                $table->unsignedBigInteger('job_id');
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('receiver_id'); 
                $table->timestamps();
            
                // Define foreign key constraint
                $table->foreign('user_id')->references('id')->on('users');
                $table->foreign('receiver_id')->references('id')->on('users');
                $table->foreign('job_id')->references('id')->on('jobs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};