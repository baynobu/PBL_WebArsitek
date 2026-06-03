<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProyekTask extends Model
{
    protected $fillable = [
        'proyek_id',
        'title',
        'description',
        'weight',
        'is_done',
        'done_at',
        'done_by',
    ];

    protected $casts = [
        'is_done' => 'boolean',
        'done_at' => 'datetime',
    ];

    public function proyek()
    {
        return $this->belongsTo(Proyek::class, 'proyek_id');
    }

    public function doneBy()
    {
        return $this->belongsTo(User::class, 'done_by');
    }
}
