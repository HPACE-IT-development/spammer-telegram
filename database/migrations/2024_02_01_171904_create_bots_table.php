<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->unsignedBigInteger('group_id')->nullable();
            $table->unsignedTinyInteger('status_id');
            $table->string('phone')->unique();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('status_id')->references('id')->on('bot_statuses');
            $table->foreign('group_id')->references('id')->on('bot_groups');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bots');
    }
};
