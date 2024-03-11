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
        Schema::create('actions', function (Blueprint $table) {
            $table->id();
            $table->json('recipients');
            $table->string('text', 4096);
            $table->unsignedBigInteger('user_id');
            $table->nullableMorphs('actionable');
            $table->unsignedTinyInteger('action_type_id');
            $table->unsignedTinyInteger('action_status_id')->default(1);
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->foreign('action_type_id')
                ->references('id')
                ->on('action_types')
                ->onDelete('cascade');
            $table->foreign('action_status_id')
                ->references('id')
                ->on('action_statuses')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actions');
    }
};
