<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penukaran extends Model
{
    public function hadiah()
    {
        return $this->belongsTo(Hadiah::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
