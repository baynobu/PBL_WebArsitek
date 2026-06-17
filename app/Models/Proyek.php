<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proyek extends Model
{
    use SoftDeletes;

    protected $table = 'proyek';

    protected $fillable = [
        'client_id',
        'judul',
        'deskripsi',
        'budget',
        'deadline',
        'lokasi',
        'status',
        'scheduled_at',
        'arsitek_terpilih_id',
        'open_at',
        'open_until',
        'open_duration_days',
        'progress_percent',
        'progress_note',
        'progress_updated_at',
        'is_featured',
        'is_hidden',
        'moderated_by',
        'moderated_at',
        'moderation_note',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'deadline' => 'date',
        'open_at' => 'datetime',
        'open_until' => 'datetime',
        'progress_updated_at' => 'datetime',
        'moderated_at' => 'datetime',
        'is_featured' => 'boolean',
        'is_hidden' => 'boolean',
    ];

    public function scopePublished($query)
    {
        return $query->where('status', 'open')
            ->where(function ($q) {
                $q->whereNull('scheduled_at')
                  ->orWhere('scheduled_at', '<=', now());
            });
    }

    public function scopeDraftsOrScheduled($query)
    {
        return $query->whereIn('status', ['draft', 'scheduled']);
    }

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

    public function tasks()
    {
        return $this->hasMany(ProyekTask::class, 'proyek_id');
    }

    public function moderatedBy()
    {
        return $this->belongsTo(User::class, 'moderated_by');
    }

    public function recalculateProgress(): void
    {
        $tasks = $this->tasks()->get();

        if ($tasks->isEmpty()) {
            return;
        }

        $totalWeight = (int) $tasks->sum('weight');
        $completedWeight = (int) $tasks->where('is_done', true)->sum('weight');

        $progress = $totalWeight > 0
            ? (int) round(($completedWeight / $totalWeight) * 100)
            : 0;

        $this->forceFill([
            'progress_percent' => min(100, max(0, $progress)),
            'progress_note' => $tasks->where('is_done', false)->isNotEmpty()
                ? 'Checklist proyek masih berjalan.'
                : 'Seluruh checklist proyek sudah selesai.',
            'progress_updated_at' => now(),
        ])->saveQuietly();
    }
}
