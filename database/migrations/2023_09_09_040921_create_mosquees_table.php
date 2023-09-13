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
        Schema::create('mosquees', function (Blueprint $table) {
            $table->id();
            $table->char('uuid');
            $table->string('name');
            $table->text('addrees');
            $table->string('street');
            $table->string('subdistrict');
            $table->string('city');
            $table->string('province');
            $table->double('latitude', 4, 2)->nullable();
            $table->double('longtitude', 4, 2)->nullable();
            $table->integer('followers');
            $table->integer('shareds');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mosquees');
    }
};
