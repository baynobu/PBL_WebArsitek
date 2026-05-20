<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogAktivitasAdmin extends Model
{
    protected $table = 'log_aktivitas_admin';

    protected $fillable = [
        'admin_id',
        'aktivitas',
        'ip_address',
        'user_agent',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
