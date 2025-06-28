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
        Schema::create('coa', function (Blueprint $table) {
            $table->id();
            $table->integer('status_aktif')->default(1)->comment('1=aktif, 0=tidak aktif');
            $table->integer('parent_coa')->nullable();
            $table->string('tipe_coa', 255)->comment('tipe coa statis, contoh : akun piutang, akun hutang, hpp, kasbank, dll');
            $table->string('kode', 255);
            $table->string('nama', 255);
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coa');
    }
};
