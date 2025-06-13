<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hadiah extends Model
{
    protected $fillable = [
        'nama_hadiah',
        'poin',
        'rating',
        'jumlah_penukaran',
    ];
}
