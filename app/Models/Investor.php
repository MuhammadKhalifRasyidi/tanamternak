<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Investor extends Model
{
    protected $table = 'investor';

    protected $fillable = [
        'user_id',
        'nama',
        'nik',
        'alamat',
        'no_hp',
        'saldo',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }

    public function investasi()
    {
        return $this->hasMany(Investasi::class);
    }
}
