<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sampah extends Model
{
    protected $fillable = [
        'penukar_id',
        'kategori_sampah',
        'poin',
        'link_foto',
    ];
}
