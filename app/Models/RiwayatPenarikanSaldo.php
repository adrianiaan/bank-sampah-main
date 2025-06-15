<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPenarikanSaldo extends Model
{
    use HasFactory;

    protected $table = 'riwayat_penarikan_saldos';

    protected $fillable = [
        'user_id',
        'saldo_sebelum',
        'jumlah_penarikan',
        'saldo_setelah',
        'tanggal_penarikan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
