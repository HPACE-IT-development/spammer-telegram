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
            $table->string('name', 32);
            $table->string('description', 32);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bot_statuses');
    }
};
