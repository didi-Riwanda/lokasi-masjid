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
            $table->char('uuid', 36)->unique()->index();
            $table->string('name');
            $table->string('address', 350);
            $table->string('street');
            $table->string('district');
            $table->string('city');
            $table->string('province');
            $table->double('latitude');
            $table->double('longitude');
            $table->integer('followers')->default(0);
            $table->integer('shareds')->default(0);
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
