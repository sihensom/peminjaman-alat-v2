<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alat extends Model
{
    protected $fillable = [
        'nama_alat',
        'kategori_id',
        'stok',
        'kondisi',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}
