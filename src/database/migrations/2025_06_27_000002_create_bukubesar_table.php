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
        Schema::create('bukubesar', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('coa_id');
            $table->foreign('coa_id')->references('id')->on('coa')->onDelete('cascade');
            $table->unsignedBigInteger('sumber_id');
            $table->date('tanggal');
            $table->string('nomer', 255);
            $table->string('sumber_transaksi', 255);
            $table->decimal('nominal', 50, 2);
            $table->string('tipe_mutasi', 255);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukubesar');
    }
};
