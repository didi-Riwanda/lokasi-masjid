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
        Schema::create('mosquee_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mosquee_id');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->string('day')->nullable();
            $table->integer('duration');
            $table->string('title')->nullable();
            $table->text('speakers')->nullable();
            $table->string('type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mosquee_schedules');
    }
};
