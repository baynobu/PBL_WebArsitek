<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    protected $table = 'proposal';

    const UPDATED_AT = null;

    protected $fillable = [
        'proyek_id',
        'arsitek_id',
        'harga_tawaran',
        'estimasi_waktu',
        'deskripsi',
        'status',
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
}