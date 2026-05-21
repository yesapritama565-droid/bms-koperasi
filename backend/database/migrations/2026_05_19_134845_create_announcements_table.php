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
        Schema::create('announcements', function (Blueprint $table) {

            $table->id();

            // judul pengumuman
            $table->string('title');

            // isi pengumuman
            $table->longText('message');

            // pembuat pengumuman
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            // aktif/tidak
            $table->boolean('is_active')
                ->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};