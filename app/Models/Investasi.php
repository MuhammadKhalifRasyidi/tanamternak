<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investasi extends Model
{
    use HasFactory;

    protected $table = 'Investasi';

    protected $fillable = [
        'investor_id',
        'ternak_id',
        'jumlah_unit',
        'total_dana',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
    ];

    public function ternak()
    {
        return $this->belongsTo(Ternak::class);
    }

    public function investor()
    {
        return $this->belongsTo(Investor::class);
    }
}
