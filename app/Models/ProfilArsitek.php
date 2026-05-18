<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilArsitek extends Model
{
    protected $table = 'profil_arsitek';

    protected $fillable = [
        'user_id',
        'foto',
        'deskripsi',
        'skill',
        'pengalaman',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
