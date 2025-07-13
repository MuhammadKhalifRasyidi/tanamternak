<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peternak extends Model
{
    protected $fillable = [
        'user_id',
        'nama',  
        'nik',
        'alamat', 
        'no_hp'
    ];

    protected $table = 'peternak';
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ternak()
    {
        return $this->hasMany(Ternak::class);
    }
}
