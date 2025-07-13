<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ternak extends Model
{
    use HasFactory;

    protected $table = 'ternak';

    protected $fillable = [
        'peternak_id',
        'nama',
        'jenis',
        'berat',
        'harga',
        'status',
        'alamat',
        'latitude',
        'longitude',
        'foto',
        'tanggal_masuk',
    ];

    /**
     * Relasi ke Peternak
     */
    public function peternak()
    {
        return $this->belongsTo(Peternak::class);
    }

    public function investasi()
    {
        return $this->hasMany(Investasi::class);
    }
}
