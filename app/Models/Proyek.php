<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proyek extends Model
{
    protected $table = 'proyek';

    protected $fillable = [
        'client_id',
        'judul',
        'deskripsi',
        'budget',
        'deadline',
        'lokasi',
        'status',
        'arsitek_terpilih_id',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function arsitekTerpilih()
    {
        return $this->belongsTo(User::class, 'arsitek_terpilih_id');
    }

    public function proposal()
    {
        return $this->hasMany(Proposal::class, 'proyek_id');
    }

    public function rating()
    {
        return $this->hasOne(Rating::class, 'proyek_id');
    }
}
