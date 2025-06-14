<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Permintaan;

class Sampah extends Model
{
    protected $fillable = [
        'user_id',
        'kategori_sampah',
        'poin',
    ];

    public function penukar()
    {
        return $this->belongsTo(User::class);
    }

    public function permintaan()
    {
        return $this->belongsTo(Permintaan::class);
    }
}
