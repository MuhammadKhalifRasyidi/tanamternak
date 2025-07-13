<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $fillable = [
        'investor_id',
        'jenis',
        'jumlah',
        'status',
        'catatan',
    ];

    public function investor()
    {
        return $this->belongsTo(Investor::class);
    }
}
