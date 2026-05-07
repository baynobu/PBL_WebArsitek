<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $table = 'rating';

    const UPDATED_AT = null;

    protected $fillable = [
        'proyek_id',
        'arsitek_id',
        'client_id',
        'nilai',
        'komentar',
        'created_at',
    ];

    public function proyek()
    {
        return $this->belongsTo(Proyek::class, 'proyek_id');
    }

    public function arsitek()
    {
        return $this->belongsTo(User::class, 'arsitek_id');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
}
