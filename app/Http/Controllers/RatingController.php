<?php

namespace App\Http\Controllers;

use App\Models\Proyek;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function create(Proyek $proyek)
    {
        $user = Auth::user();

        if ($user->id !== $proyek->client_id) {
            abort(403);
        }

        if ($proyek->status !== 'done') {
            return redirect()->route('proyek.show', $proyek)->with('error', 'Hanya proyek yang selesai dapat diberi rating.');
        }

        if ($proyek->rating()->exists()) {
            return redirect()->route('proyek.show', $proyek)->with('info', 'Proyek sudah diberi rating.');
        }

        return view('rating.create', compact('proyek'));
    }

    public function store(Request $request, Proyek $proyek)
    {
        $user = Auth::user();

        if ($user->id !== $proyek->client_id) {
            abort(403);
        }

        if ($proyek->status !== 'done') {
            return redirect()->route('proyek.show', $proyek)->with('error', 'Hanya proyek yang selesai dapat diberi rating.');
        }

        if ($proyek->rating()->exists()) {
            return redirect()->route('proyek.show', $proyek)->with('info', 'Proyek sudah diberi rating.');
        }

        $data = $request->validate([
            'nilai' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string',
        ]);

        Rating::create([
            'proyek_id' => $proyek->id,
            'arsitek_id' => $proyek->arsitek_terpilih_id,
            'client_id' => $user->id,
            'nilai' => $data['nilai'],
            'komentar' => $data['komentar'] ?? null,
        ]);

        return redirect()->route('proyek.show', $proyek)->with('success', 'Terima kasih, rating berhasil disimpan.');
    }
}
