<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasUuids, HasFactory;

    protected $fillable = [
        'mesin_id',
        'user_id',
    ];

    public function mesin()
    {
        return $this->belongsTo(Mesin::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sampahs()
    {
        return $this->hasMany(Sampah::class);
    }

    public function totalPoin()
    {
        return $this->sampahs->sum('poin');
    }
}
