<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bot_statuses', function (Blueprint $table) {
            $table->unsignedTinyInteger('id')->autoIncrement();
            $table->string('title', 32);
            $table->unsignedTinyInteger('importance');
            $table->string('desc_ru', 32);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bot_statuses');
    }
};
