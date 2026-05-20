<?php

namespace App\Http\Controllers;

use App\Models\Proyek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProyekController extends Controller
{
    /**
     * Display a listing of the resource with simple search.
     */
    public function index(Request $request)
    {
        $query = Proyek::query()->where('status', 'open');

        $search = trim((string) $request->input('q', ''));

        if ($search !== '') {
            $query->where(function ($qBuilder) use ($search) {
                $qBuilder->where('judul', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%")
                    ->orWhere('lokasi', 'like', "%{$search}%");
            });
        }

        $proyeks = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('proyek.index', compact('proyeks'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Proyek $proyek)
    {
        $proyek->load(['proposal.arsitek.profilArsitek']);

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
        ]);

        $proyek = Proyek::create([
            'client_id' => $user->id,
            'judul' => $data['judul'],
            'deskripsi' => $data['deskripsi'],
            'budget' => $data['budget'],
            'deadline' => $data['deadline'],
            'lokasi' => $data['lokasi'] ?? null,
            'status' => 'open',
        ]);

        return redirect()->route('proyek.show', $proyek)->with('success', 'Proyek berhasil diposting.');
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

        if ($proyek->status === 'progress' && $newStatus === 'done') {
            $proyek->update(['status' => 'done']);
            return redirect()->route('proyek.show', $proyek)->with('success', 'Proyek berhasil ditandai selesai.');
        }

        return redirect()->route('proyek.show', $proyek)->with('error', 'Tidak bisa ubah status pada tahap ini.');
    }
}
