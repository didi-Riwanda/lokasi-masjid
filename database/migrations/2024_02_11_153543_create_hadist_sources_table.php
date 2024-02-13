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
        Schema::create('hadist_sources', function (Blueprint $table) {
            $table->id();
            $table->char('uuid', 36)->unique()->index();
            $table->string('name');
            $table->string('cover')->nullable();
            $table->string('author');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hadist_sources');
    }
};