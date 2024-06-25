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
        Schema::create('register_competisions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('number')->unique();
            $table->uuid('competision_id')->nullable();
            $table->integer('no_session')->default(1);
            $table->string('name');
            $table->string('phone');
            $table->string('address');
            $table->string('photo')->nullable();
            $table->uuid('korwil_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('register_competisions');
    }
};
