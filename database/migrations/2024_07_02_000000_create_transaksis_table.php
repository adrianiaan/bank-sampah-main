<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksisTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penjemputan_id')->nullable()->constrained('penjemputan')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('jenis_sampah_id')->constrained('jenis_sampahs')->onDelete('cascade');
            $table->decimal('berat_kg', 8, 2);
            $table->decimal('harga_per_kilo_saat_transaksi', 8, 2);
            $table->decimal('nilai_saldo', 8, 2);
            $table->dateTime('tanggal_transaksi');
            $table->foreignId('dicatat_oleh_user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->enum('status_verifikasi', ['terverifikasi', 'ditolak'])->nullable();
            $table->text('catatan_verifikasi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
}
