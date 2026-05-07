<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerifikasiUser extends Model
{
    protected $table = 'verifikasi_user';

    const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'status',
        'created_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
