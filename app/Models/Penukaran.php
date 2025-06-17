<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penukaran extends Model
{
    use HasUuids, HasFactory;

    protected $fillable = [
        'user_id',
        'alamat',
        'status',
        'latitude',
        'longitude',
    ];

    public function hadiahs()
    {
        return $this->belongsToMany(Hadiah::class, 'penukaran_hadiah')
            ->withPivot('kuantitas')
            ->withTimestamps();
    }

    public function totalPoin()
    {
        return $this->hadiahs->sum(function ($hadiah) {
            return $hadiah->pivot->kuantitas * $hadiah->poin;
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
