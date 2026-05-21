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
        Schema::create('meeting_notes', function (Blueprint $table) {

            $table->id();

            // judul meeting
            $table->string('title');

            // isi notulensi
            $table->longText('notes');

            // attachment optional
            $table->string('attachment')->nullable();

            // tanggal meeting
            $table->date('meeting_date')->nullable();

            // pembuat
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meeting_notes');
    }
};