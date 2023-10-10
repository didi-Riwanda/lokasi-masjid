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
        Schema::create('dzikirs', function (Blueprint $table) {
            $table->id();
            $table->char('uuid', 36)->unique()->index();
            $table->bigInteger('category_id');
            $table->string('title');
            $table->text('arabic');
            $table->text('latin')->nullable();
            $table->text('translation')->nullable();
            $table->string('notes')->nullable();
            $table->text('fawaid');
            $table->string('source');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dzikirs');
    }
};
