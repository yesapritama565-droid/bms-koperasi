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
        Schema::table('tasks', function (Blueprint $table) {

           

            // progress task
            $table->integer('progress')->default(0);

            // waktu kerja
            $table->datetime('start_date')->nullable();
            $table->datetime('end_date')->nullable();

            // tracking start stop
            $table->datetime('started_at')->nullable();
            $table->datetime('stopped_at')->nullable();

            // total waktu pengerjaan
            $table->integer('total_minutes')->default(0);

            // hasil kerja
            $table->text('result')->nullable();

            // next step
            $table->text('next_step')->nullable();

            // attachment
            $table->string('attachment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {

            $table->dropColumn([
                'progress',
                'start_date',
                'end_date',
                'started_at',
                'stopped_at',
                'total_minutes',
                'result',
                'next_step',
                'attachment'
            ]);
        });
    }
};