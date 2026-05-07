<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogAktivitasAdmin extends Model
{
    protected $table = 'log_aktivitas_admin';

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
