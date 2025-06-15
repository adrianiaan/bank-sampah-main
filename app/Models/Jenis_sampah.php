<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jenis_sampah extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function riwayat()
    {
        return $this->hasMany(Riwayat::class);
    }

    // Accessor untuk mendapatkan URL lengkap foto
    public function getFotoUrlAttribute()
    {
        if ($this->foto) {
            return asset('storage/' . $this->foto);
        }
        return asset('images/default-foto.png'); // Ganti dengan path default jika perlu
    }
}
