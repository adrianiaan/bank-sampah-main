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
        Schema::create('riwayats', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('jenis_sampah_id');
            $table->string('no_telepon');
            $table->string('jumlah_kg');
            $table->double('total_harga');
            $table->string('lama_penyimpanan');
            $table->enum('status', ['Disetor', 'Belum Disetor']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayats');
    }
};
