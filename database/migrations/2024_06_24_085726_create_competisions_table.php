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
        Schema::create('competisions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('number')->unique();
            $table->string('name');
            $table->integer('count_session')->default(0);
            $table->integer('count_korwil')->nullable();
            $table->integer('count_gantangan')->default(300);
            $table->integer('count_korwil_per_session')->nullable();
            $table->integer('count_more_per_session')->nullable();
            $table->integer('status')->default(0);
            $table->date('tgl')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('competisions');
    }
};
