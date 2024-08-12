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
        Schema::create('jumlah_santris', function (Blueprint $table) {
            $table->id();
            $table->string('qism_id', 10)->nullable();
            $table->string('kelas_id', 10)->nullable();
            $table->decimal('putra', 5)->nullable();
            $table->decimal('putri', 5)->nullable();
            $table->decimal('total', 5)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jumlah_santris');
    }
};
