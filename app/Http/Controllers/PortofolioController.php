<?php

namespace App\Http\Controllers;

use App\Models\Portofolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PortofolioController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->role !== 'arsitek') abort(403);

        $items = Portofolio::where('user_id', $user->id)->latest()->paginate(10);
        return view('portofolio.index', compact('items'));
    }

    public function create()
    {
        $user = Auth::user();
        if ($user->role !== 'arsitek') abort(403);

        return view('portofolio.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->role !== 'arsitek') abort(403);

        $data = $request->validate([
            'judul' => 'required|string|max:100',
            'deskripsi' => 'required|string',
            'kategori' => 'required|string|max:50',
            'gambar' => 'required|image|max:4096',
        ]);

        $path = $request->file('gambar')->store('portofolio', 'public');

        Portofolio::create([
            'user_id' => $user->id,
            'judul' => $data['judul'],
            'deskripsi' => $data['deskripsi'],
            'kategori' => $data['kategori'],
            'gambar' => $path,
        ]);

        return redirect()->route('portofolio.index')->with('success', 'Portofolio berhasil ditambahkan.');
    }

    public function edit(Portofolio $portofolio)
    {
        $user = Auth::user();
        if ($user->role !== 'arsitek' || $portofolio->user_id !== $user->id) abort(403);

        return view('portofolio.edit', compact('portofolio'));
    }

    public function update(Request $request, Portofolio $portofolio)
    {
        $user = Auth::user();
        if ($user->role !== 'arsitek' || $portofolio->user_id !== $user->id) abort(403);

        $data = $request->validate([
            'judul' => 'required|string|max:100',
            'deskripsi' => 'required|string',
            'kategori' => 'required|string|max:50',
            'gambar' => 'nullable|image|max:4096',
        ]);

        if ($request->hasFile('gambar')) {
            if ($portofolio->gambar) {
                Storage::disk('public')->delete($portofolio->gambar);
            }
            $path = $request->file('gambar')->store('portofolio', 'public');
            $portofolio->gambar = $path;
        }

        $portofolio->judul = $data['judul'];
        $portofolio->deskripsi = $data['deskripsi'];
        $portofolio->kategori = $data['kategori'];
        $portofolio->save();

        return redirect()->route('portofolio.index')->with('success', 'Portofolio diperbarui.');
    }

    public function destroy(Portofolio $portofolio)
    {
        $user = Auth::user();
        if ($user->role !== 'arsitek' || $portofolio->user_id !== $user->id) abort(403);

        if ($portofolio->gambar) {
            Storage::disk('public')->delete($portofolio->gambar);
        }
        $portofolio->delete();

        return redirect()->route('portofolio.index')->with('success', 'Portofolio dihapus.');
    }
}
