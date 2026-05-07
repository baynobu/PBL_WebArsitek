<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portofolio extends Model
{
    protected $table = 'portofolio';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
