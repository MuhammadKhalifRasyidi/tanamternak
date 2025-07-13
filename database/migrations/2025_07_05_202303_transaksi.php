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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('investor_id')->references('id')->on('investor')->onDelete('cascade');
            $table->enum('jenis', ['investasi', 'deposit', 'withdraw']);
            $table->decimal('jumlah', 15, 2);
            $table->enum('status', ['pending', 'selesai', 'gagal']);
            $table->timestamp('tanggal')->useCurrent();
            $table->string('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
