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
        Schema::create('documents', function (Blueprint $table) {

            $table->id();

            // user upload
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            // project terkait
            $table->foreignId('project_id')
                ->nullable()
                ->constrained()
                ->onDelete('cascade');

            // task terkait
            $table->foreignId('task_id')
                ->nullable()
                ->constrained()
                ->onDelete('cascade');

            // nama file
            $table->string('file');

            // nama asli file
            $table->string('original_name');

            // deskripsi
            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};