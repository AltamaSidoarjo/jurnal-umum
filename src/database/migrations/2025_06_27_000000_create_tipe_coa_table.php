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
        Schema::create('tipe_coa', function (Blueprint $table) {
            $table->id();
            $table->boolean('status_aktif');
            $table->string('nama', 255)->nullable();
            $table->string('jenis_tipe_coa', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipe_coa');
    }
};
