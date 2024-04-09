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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('action_id');
            $table->unsignedTinyInteger('report_status_id')->nullable()->default(null);
            $table->json('sessions_errors')->nullable()->default(null);
            $table->json('info_about_recipients')->nullable()->default(null);
            $table->unsignedInteger('total_recipients_amount')->default(0);
            $table->unsignedInteger('completed_recipients_amount')->default(0);
            $table->timestamps();

            $table->foreign('action_id')
                ->references('id')
                ->on('actions')
                ->onDelete('cascade');
            $table->foreign('report_status_id')
                ->references('id')
                ->on('report_statuses')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
