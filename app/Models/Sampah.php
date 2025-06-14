<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Permintaan;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sampah extends Model
{
    use hasUuids, HasFactory;

    protected $fillable = [
        'user_id',
        'kategori_sampah',
        'poin',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function permintaan()
    {
        return $this->belongsTo(Permintaan::class);
    }
}
