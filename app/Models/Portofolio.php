<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portofolio extends Model
{
    protected $table = 'portofolio';

    protected $fillable = [
        'user_id',
        'judul',
        'deskripsi',
        'gambar',
        'kategori',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
