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
        Schema::create('task_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->references('id')->on('tasks')->cascadeOnDelete();
            $table->foreignId('developer_id')->references('id')->on('users')->cascadeOnDelete();
            $table->enum('status', ['candidate', 'rejected', 'in_progress', 'expired', 'done'])
                ->default('candidate');
            $table->text('reject_reason')->nullable();
            $table->unique(['task_id', 'developer_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_assignments');
    }
};
