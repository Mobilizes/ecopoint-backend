<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permintaan extends Model
{
    use HasUuids, HasFactory;

    protected $fillable = [
        'mesin_id',
        'kode_verifikasi',
        'status',
        'daftar_sampah',
    ];

    protected $casts = [
        'daftar_sampah' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if (isset($model->kode_verifikasi) && strlen($model->kode_verifikasi) !== 5) {
                throw new \InvalidArgumentException('kode_verifikasi harus sepanjang 5 karakter.');
            }
        });
    }

    public function sampahs()
    {
        return $this->hasMany(Sampah::class);
    }

    public function mesin()
    {
        return $this->belongsTo(Mesin::class);
    }
}
