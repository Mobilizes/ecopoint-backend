<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mesin extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'nama_mesin',
    ];

    public function permintaan()
    {
        return $this->hasMany(Permintaan::class);
    }
}
