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
        Schema::create('hadists', function (Blueprint $table) {
            $table->id();
            $table->char('uuid', 36)->index();
            $table->char('title');
            $table->char('source');
            $table->longText('text');
            $table->longText('translation');
            $table->char('category');
            $table->longText('noted');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hadists');
    }
};
