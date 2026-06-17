<?php

namespace App\Http\Controllers;

use App\Models\Proyek;
use App\Models\ProyekTask;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ProyekController extends Controller
{
    /**
     * Display a listing of the resource with simple search.
     */
    public function index(Request $request)
    {
        $query = Proyek::published()->where('is_hidden', false);

        $search = trim((string) $request->input('q', ''));

        if ($search !== '') {
            $query->where(function ($qBuilder) use ($search) {
                $qBuilder->where('judul', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%")
                    ->orWhere('lokasi', 'like', "%{$search}%");
            });
        }

        $proyeks = $query->orderByRaw("CASE WHEN status = 'open' THEN 0 WHEN status = 'progress' THEN 1 ELSE 2 END")
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('proyek.index', compact('proyeks'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Proyek $proyek)
    {
        $proyek->load(['proposal.arsitek.profilArsitek', 'moderatedBy', 'tasks.doneBy']);

        return view('proyek.show', compact('proyek'));
    }

    /**
     * Client: listing proyek milik sendiri.
     */
    public function myProjects()
    {
        $user = Auth::user();
        if ($user->role !== 'client') {
            abort(403);
        }

        $proyeks = Proyek::where('client_id', $user->id)
            ->withCount('proposal')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('proyek.my', compact('proyeks'));
    }

    /**
     * Client: form posting proyek.
     */
    public function create()
    {
        $user = Auth::user();
        if ($user->role !== 'client') {
            abort(403);
        }

        return view('proyek.create');
    }

    /**
     * Client: simpan posting proyek.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->role !== 'client') {
            abort(403);
        }

        $data = $request->validate([
            'judul' => 'required|string|max:100',
            'deskripsi' => 'required|string',
            'budget' => 'required|numeric|min:0',
            'deadline' => 'required|date|after_or_equal:today',
            'lokasi' => 'nullable|string|max:100',
            'open_duration_days' => 'required|integer|min:3|max:90',
            'action' => 'required|in:draft,schedule,publish',
            'scheduled_at' => 'required_if:action,schedule|nullable|date|after:now',
        ]);

        $action = $data['action'];
        $status = 'open';
        $scheduledAt = null;
        $openAt = null;
        $openUntil = null;

        if ($action === 'draft') {
            $status = 'draft';
        } elseif ($action === 'schedule') {
            $status = 'scheduled';
            $scheduledAt = Carbon::parse($data['scheduled_at']);
        } else {
            $openAt = now();
            $openUntil = Carbon::parse($openAt)->addDays((int) $data['open_duration_days']);
        }

        $proyek = Proyek::create([
            'client_id' => $user->id,
            'judul' => $data['judul'],
            'deskripsi' => $data['deskripsi'],
            'budget' => $data['budget'],
            'deadline' => $data['deadline'],
            'lokasi' => $data['lokasi'] ?? null,
            'status' => $status,
            'scheduled_at' => $scheduledAt,
            'open_at' => $openAt,
            'open_until' => $openUntil,
            'open_duration_days' => $data['open_duration_days'],
            'progress_percent' => 0,
            'progress_note' => $status === 'open' ? 'Menunggu arsitek mengajukan proposal.' : 'Proyek belum dipublikasikan.',
            'progress_updated_at' => now(),
            'is_featured' => false,
            'is_hidden' => false,
        ]);

        $msg = 'Proyek berhasil diposting.';
        if ($status === 'draft') {
            $msg = 'Proyek berhasil disimpan sebagai draft.';
        } elseif ($status === 'scheduled') {
            $msg = 'Proyek berhasil dijadwalkan untuk diposting.';
        }

        return redirect()->route('proyek.show', $proyek)->with('success', $msg);
    }

    /**
     * Client: edit proyek.
     */
    public function edit(Proyek $proyek)
    {
        $this->ensureClientOwnsProject($proyek);

        if (!in_array($proyek->status, ['draft', 'scheduled', 'open'])) {
            return redirect()->route('proyek.my')->with('error', 'Proyek yang sedang berjalan atau sudah selesai tidak dapat diubah.');
        }

        return view('proyek.edit', compact('proyek'));
    }

    /**
     * Client: update proyek.
     */
    public function update(Request $request, Proyek $proyek)
    {
        $this->ensureClientOwnsProject($proyek);

        if (!in_array($proyek->status, ['draft', 'scheduled', 'open'])) {
            return redirect()->route('proyek.my')->with('error', 'Proyek yang sedang berjalan atau sudah selesai tidak dapat diubah.');
        }

        $data = $request->validate([
            'judul' => 'required|string|max:100',
            'deskripsi' => 'required|string',
            'budget' => 'required|numeric|min:0',
            'deadline' => 'required|date|after_or_equal:today',
            'lokasi' => 'nullable|string|max:100',
            'open_duration_days' => 'required|integer|min:3|max:90',
            'action' => 'required|in:draft,schedule,publish',
            'scheduled_at' => 'required_if:action,schedule|nullable|date|after:now',
        ]);

        $action = $data['action'];
        $status = 'open';
        $scheduledAt = null;
        $openAt = null;
        $openUntil = null;

        if ($action === 'draft') {
            $status = 'draft';
        } elseif ($action === 'schedule') {
            $status = 'scheduled';
            $scheduledAt = Carbon::parse($data['scheduled_at']);
        } else {
            $openAt = now();
            $openUntil = Carbon::parse($openAt)->addDays((int) $data['open_duration_days']);
        }

        $proyek->update([
            'judul' => $data['judul'],
            'deskripsi' => $data['deskripsi'],
            'budget' => $data['budget'],
            'deadline' => $data['deadline'],
            'lokasi' => $data['lokasi'] ?? null,
            'status' => $status,
            'scheduled_at' => $scheduledAt,
            'open_at' => $openAt,
            'open_until' => $openUntil,
            'open_duration_days' => $data['open_duration_days'],
            'progress_note' => $status === 'open' ? 'Menunggu arsitek mengajukan proposal.' : 'Proyek belum dipublikasikan.',
            'progress_updated_at' => now(),
        ]);

        $msg = 'Proyek berhasil diperbarui.';
        if ($status === 'draft') {
            $msg = 'Draft proyek berhasil diperbarui.';
        } elseif ($status === 'scheduled') {
            $msg = 'Proyek berhasil dijadwalkan untuk diposting.';
        }

        return redirect()->route('proyek.show', $proyek)->with('success', $msg);
    }

    /**
     * Update proyek status.
     */
    public function updateStatus(Request $request, Proyek $proyek)
    {
        $user = Auth::user();
        $isClient = $user->id === $proyek->client_id;
        $isSelectedArchitect = $user->id === $proyek->arsitek_terpilih_id;

        if (! $isClient && ! $isSelectedArchitect) {
            abort(403);
        }

        $newStatus = $request->input('status');
        $validStatuses = ['open', 'progress', 'done'];

        if (! in_array($newStatus, $validStatuses)) {
            return redirect()->route('proyek.show', $proyek)->with('error', 'Status tidak valid.');
        }

        if ($newStatus === 'done') {
            $has100PercentProgress = (int) ($proyek->progress_percent ?? 0) >= 100;

            if (! $has100PercentProgress) {
                return redirect()->route('proyek.show', $proyek)->with('error', 'Proyek baru bisa ditandai selesai saat progress sudah 100%.');
            }

            $proyek->update(['status' => 'done']);
            return redirect()->route('rating.create', $proyek)->with('success', 'Proyek berhasil ditandai selesai. Silakan beri rating arsitek.');
        }

        return redirect()->route('proyek.show', $proyek)->with('error', 'Tidak bisa ubah status pada tahap ini.');
    }

    /**
     * Client: hapus proyek milik sendiri.
     */
    public function destroy(Proyek $proyek)
    {
        $user = Auth::user();

        if ($user->role !== 'client' || $user->id !== $proyek->client_id) {
            abort(403);
        }

        if (!in_array($proyek->status, ['open', 'draft', 'scheduled'])) {
            return redirect()->route('proyek.my')->with('error', 'Proyek yang sedang berjalan atau sudah selesai tidak dapat dihapus.');
        }

        $proyek->delete();

        return redirect()->route('proyek.my')->with('success', 'Proyek berhasil dihapus.');
    }
    /**
     * Add a checklist task to the project.
     */
    public function storeTask(Request $request, Proyek $proyek)
    {
        $this->ensureClientOwnsProject($proyek);

        if ($proyek->status === 'done') {
            return redirect()->route('proyek.show', $proyek)->with('error', 'Proyek selesai tidak dapat menambah tugas lagi.');
        }

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'weight' => ['nullable', 'integer', 'min:1', 'max:100'],
        ]);

        $proyek->tasks()->create([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'weight' => $data['weight'] ?? 1,
            'is_done' => false,
        ]);

        $proyek->recalculateProgress();

        return redirect()->route('proyek.show', $proyek)->with('success', 'Task checklist berhasil ditambahkan.');
    }

    /**
     * Toggle a checklist task.
     */
    public function toggleTask(Proyek $proyek, ProyekTask $task)
    {
        $this->ensureClientOrAssignedArchitect($proyek);

        if ($task->proyek_id !== $proyek->id) {
            abort(404);
        }

        $task->is_done = ! $task->is_done;
        $task->done_at = $task->is_done ? now() : null;
        $task->done_by = $task->is_done ? Auth::id() : null;
        $task->save();

        $proyek->recalculateProgress();

        return redirect()->route('proyek.show', $proyek)->with('success', 'Status task berhasil diperbarui.');
    }

    protected function ensureClientOwnsProject(Proyek $proyek): void
    {
        $user = Auth::user();

        if (! $user) {
            abort(403);
        }

        if ($user->role !== 'client' || $user->id !== $proyek->client_id) {
            abort(403);
        }
    }

    protected function ensureClientOrAssignedArchitect(Proyek $proyek): void
    {
        $user = Auth::user();

        if (! $user) {
            abort(403);
        }

        $isClient = $user->role === 'client' && $user->id === $proyek->client_id;
        $isAssignedArchitect = $user->role === 'arsitek' && $user->id === $proyek->arsitek_terpilih_id;

        if (! $isClient && ! $isAssignedArchitect) {
            abort(403);
        }
    }
}
