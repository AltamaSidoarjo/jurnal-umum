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
        Schema::create('jurnal_umum_rinci', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jurnal_umum_id');
            $table->unsignedBigInteger('coa_id');
            $table->decimal('debit', 50, 2);
            $table->decimal('kredit', 50, 2);
            $table->unsignedBigInteger('pelanggan')->nullable();
            $table->unsignedBigInteger('supplier')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->foreign('jurnal_umum_id')->references('id')->on('jurnal_umum')->onDelete('cascade');
            $table->foreign('coa_id')->references('id')->on('coa')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurnal_umum_rinci');
    }
};
