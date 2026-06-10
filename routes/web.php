<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\ProyekController;
use App\Http\Controllers\ArsitekController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ProfilArsitekController;
use App\Http\Controllers\PortofolioController;
use App\Models\LandingPageContent;
use App\Models\Proyek;
use App\Models\ProyekTask;
use App\Models\Proposal;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $landingContents = LandingPageContent::query()
        ->where('is_active', true)
        ->orderBy('sort_order')
        ->get()
        ->groupBy('section')
        ->map(fn ($items) => $items->keyBy('key'));

    return view('welcome', compact('landingContents'));
});

Route::get('/dashboard', function () {
    $user = auth()->user();

    // 1. JIKA YANG LOGIN ADALAH ADMIN
    if ($user->role === 'admin') {
        $totalProyekPlatform = \App\Models\Proyek::count();
        $unmoderatedProjects = \App\Models\Proyek::with('client')
            ->whereNull('moderated_at') 
            ->latest()
            ->get();
        $proyekPendingModerasi = $unmoderatedProjects->count();
        
        $totalProposalSistem = \App\Models\Proposal::count();
        $recentProposals = \App\Models\Proposal::with(['arsitek', 'proyek'])
            ->latest()
            ->limit(5)
            ->get();

        // Mereder dashboard khusus admin
        return view('dashboard', compact(
            'user', 'totalProyekPlatform', 'unmoderatedProjects', 
            'proyekPendingModerasi', 'totalProposalSistem', 'recentProposals'
        ));
    }

    // 2. JIKA YANG LOGIN ADALAH ARSITEK
    if ($user->role === 'arsitek') {
        // Mengambil data proposal khusus arsitek yang sedang login
        $proposals = \App\Models\Proposal::where('arsitek_id', $user->id)
            ->with('proyek')
            ->latest()
            ->get();

        // LANGSUNG DIALIKHAN KE VIEW MY-PROJECTS (WORKSPACE ARSITEK)
        return view('arsitek.my-projects', compact('user', 'proposals'));
    }

    // 3. JIKA YANG LOGIN KLIEN (DEFAULT)
    $projectsInProgress = \App\Models\Proyek::with(['arsitekTerpilih', 'tasks'])
        ->where('client_id', $user->id)
        ->where('status', 'progress')
        ->orderBy('updated_at', 'desc')
        ->get();

    $totalProyek = \App\Models\Proyek::where('client_id', $user->id)->count();
    $proyekAktif = $projectsInProgress->count();
    $proposalMasuk = \App\Models\Proposal::whereHas('proyek', fn ($query) => $query->where('client_id', $user->id))
        ->where('status', 'pending')
        ->count();
    $totalAnggaran = \App\Models\Proyek::where('client_id', $user->id)->sum('budget');

    $recentTasks = \App\Models\ProyekTask::whereIn('proyek_id', $projectsInProgress->pluck('id'))
        ->orderByDesc('updated_at')
        ->limit(8)
        ->get();

    return view('dashboard', compact(
        'user', 'projectsInProgress', 'totalProyek', 'proyekAktif', 
        'proposalMasuk', 'totalAnggaran', 'recentTasks'
    ));
})->middleware(['auth', 'account.verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Proyek - public listing and detail (Milestone 1)
Route::get('/proyek', [ProyekController::class, 'index'])->middleware(['auth', 'account.verified'])->name('proyek.index');
Route::get('/proyek/{proyek}', [ProyekController::class, 'show'])->middleware(['auth', 'account.verified'])->name('proyek.show');

Route::middleware(['auth', 'account.verified', 'role:client'])->group(function () {
    Route::get('/client/proyek', [ProyekController::class, 'myProjects'])->name('proyek.my');
    Route::get('/client/proyek/create', [ProyekController::class, 'create'])->name('proyek.create');
    Route::post('/client/proyek', [ProyekController::class, 'store'])->name('proyek.store');
    Route::delete('/client/proyek/{proyek}', [ProyekController::class, 'destroy'])->name('proyek.destroy');
    Route::get('/proyek/{proyek}/rating/create', [RatingController::class, 'create'])->name('rating.create');
    Route::post('/proyek/{proyek}/rating', [RatingController::class, 'store'])->name('rating.store');
    Route::patch('/proposal/{proposal}/terima', [ProposalController::class, 'terima'])->name('proposal.terima');
    Route::patch('/proposal/{proposal}/tolak', [ProposalController::class, 'tolak'])->name('proposal.tolak');
});

Route::middleware(['auth', 'account.verified', 'role:client,arsitek'])->group(function () {
    Route::patch('/proyek/{proyek}/status', [ProyekController::class, 'updateStatus'])->name('proyek.updateStatus');
    Route::patch('/proyek/{proyek}/tasks/{task}', [ProyekController::class, 'toggleTask'])->name('proyek.tasks.toggle');
});

Route::middleware(['auth', 'account.verified', 'role:client'])->group(function () {
    Route::post('/proyek/{proyek}/tasks', [ProyekController::class, 'storeTask'])->name('proyek.tasks.store');
});

Route::middleware(['auth', 'account.verified', 'role:arsitek'])->group(function () {
    Route::get('/arsitek/proyek', [ArsitekController::class, 'myProjects'])->name('arsitek.proyek');
    Route::get('/proyek/{proyek}/proposal/create', [ProposalController::class, 'create'])->name('proposal.create');
    Route::post('/proyek/{proyek}/proposal', [ProposalController::class, 'store'])->name('proposal.store');

    Route::get('/arsitek/profile/edit', [ProfilArsitekController::class, 'edit'])->name('arsitek.profile.edit');
    Route::patch('/arsitek/profile', [ProfilArsitekController::class, 'update'])->name('arsitek.profile.update');

    Route::get('/arsitek/portofolio', [PortofolioController::class, 'index'])->name('portofolio.index');
    Route::get('/arsitek/portofolio/create', [PortofolioController::class, 'create'])->name('portofolio.create');
    Route::post('/arsitek/portofolio', [PortofolioController::class, 'store'])->name('portofolio.store');
    Route::get('/arsitek/portofolio/{portofolio}/edit', [PortofolioController::class, 'edit'])->name('portofolio.edit');
    Route::patch('/arsitek/portofolio/{portofolio}', [PortofolioController::class, 'update'])->name('portofolio.update');
    Route::delete('/arsitek/portofolio/{portofolio}', [PortofolioController::class, 'destroy'])->name('portofolio.destroy');
});

Route::middleware(['auth', 'account.verified', 'role:client,arsitek,admin'])->group(function () {
    Route::get('/proposals', [ProposalController::class, 'index'])->name('proposal.index');
    Route::get('/proposal/{proposal}', [ProposalController::class, 'show'])->name('proposal.show');
});

// Profil arsitek (placed after arsitek-specific fixed routes to avoid catching '/arsitek/portofolio')
Route::get('/arsitek/{user}', [ArsitekController::class, 'show'])->name('arsitek.show')->middleware('auth');

require __DIR__ . '/auth.php';
