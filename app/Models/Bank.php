<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    protected $table = 'bank';

    protected $fillable = [
        'name',
        'code',
        'no_rekening',
    ];

    public function investor()
    {
        return $this->hasMany(Investor::class);
    }
}
