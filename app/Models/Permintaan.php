<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permintaan extends Model
{
    protected $fillable = [
        'kode_permintaan',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if (isset($model->kode_permintaan) && strlen($model->kode_permintaan) !== 5) {
                throw new \InvalidArgumentException('kode_permintaan harus sepanjang 5 karakter.');
            }
        });
    }

    public function sampahs()
    {
        return $this->hasMany(Sampah::class);
    }
}
