<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ArsitekController extends Controller
{
    public function show(User $user)
    {
        if ($user->role !== 'arsitek') {
            abort(404);
        }

        $user->load(['profilArsitek', 'portofolio']);

        return view('arsitek.show', [
            'arsitek' => $user,
        ]);
    }

    public function myProjects()
    {
        $user = Auth::user();

        if ($user->role !== 'arsitek') {
            abort(403);
        }

        $proposals = Proposal::where('arsitek_id', $user->id)
            ->with(['proyek.client', 'proyek.arsitekTerpilih'])
            ->orderByDesc('created_at')
            ->get();

        return view('arsitek.my-projects', compact('proposals'));
    }
}
