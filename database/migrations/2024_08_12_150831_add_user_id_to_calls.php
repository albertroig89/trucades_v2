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
        Schema::table('calls', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->unsigned()->after('id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedInteger('user_id2')->unsigned()->after('user_id');
            $table->foreign('user_id2')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('calls', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            $table->dropForeign(['user_id2']);
            $table->dropColumn('user_id2');
        });
    }
};
