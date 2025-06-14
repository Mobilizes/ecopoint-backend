<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penukaran extends Model
{
    use HasUuids, HasFactory;

    public function hadiah()
    {
        return $this->belongsTo(Hadiah::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
