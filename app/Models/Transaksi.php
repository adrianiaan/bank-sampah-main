<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksis';

    protected $fillable = [
        'penjemputan_id',
        'user_id',
        'jenis_sampah_id',
        'berat_kg',
        'harga_per_kilo_saat_transaksi',
        'nilai_saldo',
        'tanggal_transaksi',
        'dicatat_oleh_user_id',
        'status_verifikasi',
        'catatan_verifikasi',
    ];

    // Relationship to Penjemputan
    public function penjemputan()
    {
        return $this->belongsTo(Penjemputan::class);
    }

    // Relationship to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship to JenisSampah
    public function jenisSampah()
    {
        return $this->belongsTo(Jenis_sampah::class, 'jenis_sampah_id');
    }

    // Relationship to User (dicatat oleh)
    public function dicatatOleh()
    {
        return $this->belongsTo(User::class, 'dicatat_oleh_user_id');
    }
}
