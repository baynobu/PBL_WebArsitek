<?php

namespace App\Http\Controllers;

use App\Models\User;

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
}
