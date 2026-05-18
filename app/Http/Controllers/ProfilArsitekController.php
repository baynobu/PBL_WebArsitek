<?php

namespace App\Http\Controllers;

use App\Models\ProfilArsitek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfilArsitekController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        if ($user->role !== 'arsitek') {
            abort(403);
        }

        $profil = $user->profilArsitek ?? new ProfilArsitek(['user_id' => $user->id]);
        return view('arsitek.edit', compact('profil'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        if ($user->role !== 'arsitek') {
            abort(403);
        }

        $data = $request->validate([
            'deskripsi' => 'required|string',
            'skill' => 'required|string|max:255',
            'pengalaman' => 'nullable|string',
            'foto' => 'nullable|image|max:2048',
        ]);

        $profil = $user->profilArsitek;
        if (! $profil) {
            $profil = new ProfilArsitek();
            $profil->user_id = $user->id;
        }

        if ($request->hasFile('foto')) {
            if ($profil->foto) {
                Storage::disk('public')->delete($profil->foto);
            }
            $path = $request->file('foto')->store('profil', 'public');
            $profil->foto = $path;
        }

        $profil->deskripsi = $data['deskripsi'];
        $profil->skill = $data['skill'];
        $profil->pengalaman = $data['pengalaman'] ?? null;
        $profil->save();

        return redirect()->route('arsitek.show', $user)->with('success', 'Profil diperbarui.');
    }
}
