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
        Schema::create('hist_jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username');
            $table->string('job', 1000);
            $table->dateTime('inittime');
            $table->dateTime('endtime');
            $table->integer('totalmin');
            $table->string('clientname');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hist_jobs');
    }
};
