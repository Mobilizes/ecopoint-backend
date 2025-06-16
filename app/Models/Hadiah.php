<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hadiah extends Model
{
    use HasUuids, HasFactory;

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

    public function carts()
    {
        return $this->belongsToMany(Cart::class, 'cart_hadiah')
            ->withPivot('kuantitas')
            ->withTimestamps();
    }
}
