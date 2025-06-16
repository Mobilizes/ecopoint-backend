<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    /** @use HasFactory<\Database\Factories\CartFactory> */
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id'
    ];

    public function hadiahs()
    {
        return $this->belongsToMany(Hadiah::class, 'cart_hadiah')
            ->withPivot('kuantitas')
            ->withTimestamps();
    }

    public function totalPoin()
    {
        return $this->hadiahs->sum('poin');
    }
}
