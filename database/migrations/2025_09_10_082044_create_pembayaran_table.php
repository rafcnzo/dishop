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
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('transaksi_id');
            $table->string('bukti_transfer')->nullable();
            $table->enum('status_pembayaran', ['T', 'F'])->nullable()->comment('T=Disetujui, F=Ditolak');
            $table->string('metode')->nullable();
            $table->string('keterangan')->nullable();
            $table->dateTime('waktu')->nullable()->comment('Waktu pembayaran');
            $table->dateTime('dtmodi')->nullable();

            $table->foreign('transaksi_id')->references('id')->on('transaksi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
