<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sampah extends Model
{
    use HasUuids, HasFactory;

    protected $fillable = [
        'transaksi_id',
        'kategori_sampah',
        'berat_sampah',
        'poin',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }
}
