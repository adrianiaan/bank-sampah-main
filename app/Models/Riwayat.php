<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Riwayat extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function jenis_sampah()
    {
        return $this->belongsTo(Jenis_sampah::class);
    }
}
