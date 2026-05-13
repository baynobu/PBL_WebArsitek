<?php

namespace App\Http\Controllers;

use App\Models\Proyek;
use Illuminate\Http\Request;

class ProyekController extends Controller
{
    /**
     * Display a listing of the resource with simple search.
     */
    public function index(Request $request)
    {
        $query = Proyek::query()->where('status', 'open');

        if ($q = $request->query('q')) {
            $query->where(function ($qBuilder) use ($q) {
                $qBuilder->where('judul', 'like', "%{$q}%")
                    ->orWhere('deskripsi', 'like', "%{$q}%")
                    ->orWhere('lokasi', 'like', "%{$q}%");
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
        return view('proyek.show', compact('proyek'));
    }
}
