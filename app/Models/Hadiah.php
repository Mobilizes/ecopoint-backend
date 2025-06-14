<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hadiah extends Model
{
    use hasUuids, HasFactory;

    protected $fillable = [
        'nama_hadiah',
        'poin',
        'rating',
        'jumlah_penukaran',
        'link_foto',
    ];

    public function penukarans()
    {
        return $this->hasMany(Penukaran::class);
    }
}
