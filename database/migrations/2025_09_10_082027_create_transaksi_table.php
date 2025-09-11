<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('pelanggan_id');
            $table->dateTime('waktu_transaksi');
            $table->integer('total');
            $table->string('keterangan')->nullable();
            $table->dateTime('dtcrea')->nullable();
            $table->dateTime('dtmodi')->nullable();

            $table->foreign('pelanggan_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
