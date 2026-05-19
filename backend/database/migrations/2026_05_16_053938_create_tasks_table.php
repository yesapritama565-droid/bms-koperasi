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
        Schema::create('tasks', function (Blueprint $table) {

            $table->id();

            $table->foreignId('project_id')
                  ->constrained()
                  ->onDelete('cascade');

            $table->foreignId('assigned_to')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            $table->string('title');

            $table->text('description')->nullable();

            $table->enum('priority', [
                'low',
                'medium',
                'high'
            ])->default('medium');

            $table->enum('status', [
                'todo',
                'progress',
                'done'
            ])->default('todo');

            // TAMBAHAN BARU
            $table->integer('progress')->default(0);

            $table->date('deadline')->nullable();

            // TIMER TASK
            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();

            // UPLOAD FILE
            $table->string('attachment')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};