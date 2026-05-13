<?php

namespace App\Http\Controllers;

use App\Models\Proyek;
use App\Models\Proposal;
use App\Models\VerifikasiUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProposalController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->role === 'arsitek') {
            $proposals = Proposal::where('arsitek_id', $user->id)->with('proyek')->orderBy('created_at', 'desc')->get();
        } else {
            $proposals = Proposal::whereHas('proyek', function ($q) use ($user) {
                $q->where('client_id', $user->id);
            })->with('proyek')->orderBy('created_at', 'desc')->get();
        }

        return view('proposal.index', compact('proposals'));
    }

    public function create(Proyek $proyek)
    {
        $user = Auth::user();
        if ($user->role !== 'arsitek') {
            return redirect()->route('proyek.show', $proyek)->with('error', 'Hanya arsitek yang dapat mengirim proposal.');
        }

        $ver = VerifikasiUser::where('user_id', $user->id)->first();
        if (! $ver || $ver->status !== 'verified') {
            return redirect()->route('proyek.show', $proyek)->with('error', 'Akun arsitek belum terverifikasi.');
        }

        return view('proposal.create', compact('proyek'));
    }

    public function store(Request $request, Proyek $proyek)
    {
        $user = Auth::user();
        if ($user->role !== 'arsitek') {
            return redirect()->route('proyek.show', $proyek)->with('error', 'Hanya arsitek yang dapat mengirim proposal.');
        }

        $ver = VerifikasiUser::where('user_id', $user->id)->first();
        if (! $ver || $ver->status !== 'verified') {
            return redirect()->route('proyek.show', $proyek)->with('error', 'Akun arsitek belum terverifikasi.');
        }

        $data = $request->validate([
            'harga_tawaran' => 'required|numeric|min:0',
            'estimasi_waktu' => 'required|integer|min:1',
            'deskripsi' => 'required|string',
        ]);

        $proposal = Proposal::create([
            'proyek_id' => $proyek->id,
            'arsitek_id' => $user->id,
            'harga_tawaran' => $data['harga_tawaran'],
            'estimasi_waktu' => $data['estimasi_waktu'],
            'deskripsi' => $data['deskripsi'],
            'status' => 'pending',
        ]);

        return redirect()->route('proposal.show', $proposal)->with('success', 'Proposal berhasil dikirim.');
    }

    public function show(Proposal $proposal)
    {
        $user = Auth::user();
        // allow if arsitek owner or client owner of proyek
        if ($user) {
            if ($user->id !== $proposal->arsitek_id && $user->id !== $proposal->proyek->client_id && $user->role !== 'admin') {
                abort(403);
            }
        }

        return view('proposal.show', compact('proposal'));
    }
}
