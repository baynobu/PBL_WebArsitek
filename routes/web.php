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

// Route::get('/', function () {
//     $landingContents = LandingPageContent::query()
//         ->where('is_active', true)
//         ->orderBy('sort_order')
//         ->get()
//         ->groupBy('section')
//         ->map(fn ($items) => $items->keyBy('key'));

//     return view('welcome', compact('landingContents'));
// });

Route::get('/', function () {
    $landingContents = LandingPageContent::query()
        ->where('is_active', true)
        ->orderBy('sort_order')
        ->get()
        ->groupBy('section')
        ->map(fn ($items) => $items->keyBy('key'));

    $projects = Proyek::where('is_hidden', false)
        ->where('is_featured', true)
        ->latest()
        ->take(10)
        ->get();

    return view('welcome', compact(
        'landingContents',
        'projects'
    ));
});

Route::get('/dashboard', function () {
    $user = auth()->user();

    // LOGIKA UNTUK ADMIN DASHBOARD
    if ($user->role === 'admin') { 
        // atau $user->role_id == 1 (kalau kamu pakai angka) {
        $totalProyekPlatform = Proyek::count();
        $unmoderatedProjects = Proyek::with('client')
            ->whereNull('moderated_at') // Proyek yang belum dimoderasi
            ->latest()
            ->get();
        $proyekPendingModerasi = $unmoderatedProjects->count();
        
        $totalProposalSistem = Proposal::count();
        $recentProposals = Proposal::with(['arsitek', 'proyek'])
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'user',
            'totalProyekPlatform',
            'unmoderatedProjects',
            'proyekPendingModerasi',
            'totalProposalSistem',
            'recentProposals'
        ));
    }

    // LOGIKA UNTUK KLIEN DASHBOARD (Tetap dipertahankan kalau yang login klien)
    $projectsInProgress = Proyek::with(['arsitekTerpilih', 'tasks'])
        ->where('client_id', $user->id)
        ->where('status', 'progress')
        ->orderBy('updated_at', 'desc')
        ->get();

    $totalProyek = Proyek::where('client_id', $user->id)->count();
    $proyekAktif = $projectsInProgress->count();
    $proposalMasuk = Proposal::whereHas('proyek', fn ($query) => $query->where('client_id', $user->id))
        ->where('status', 'pending')
        ->count();
    $totalAnggaran = Proyek::where('client_id', $user->id)->sum('budget');

    $recentTasks = ProyekTask::whereIn('proyek_id', $projectsInProgress->pluck('id'))
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

Route::get('/proyek', [ProyekController::class, 'index'])->middleware(['auth', 'account.verified'])->name('proyek.index');
Route::get('/proyek/{proyek}', [ProyekController::class, 'show'])->middleware(['auth', 'account.verified'])->name('proyek.show');

// ... (Sisa route Klien dan Arsitek sama seperti sebelumnya, tidak ada perubahan) ...
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

Route::middleware(['auth', 'account.verified'])->group(function () {

    Route::get('/proyek', [ProyekController::class, 'index'])
        ->name('proyek.index');

    Route::get('/proyek/{proyek}', [ProyekController::class, 'show'])
        ->name('proyek.show');

    Route::patch('/proyek/{proyek}/status',
        [ProyekController::class, 'updateStatus'])
        ->name('proyek.updateStatus');

    Route::patch('/proyek/{proyek}/tasks/{task}/toggle',
        [ProyekController::class, 'toggleTask'])
        ->name('proyek.tasks.toggle');
});

Route::middleware(['auth', 'account.verified', 'role:client'])->group(function () {

    Route::get('/client/proyek', [ProyekController::class, 'myProjects'])
        ->name('proyek.my');

    Route::get('/client/proyek/create', [ProyekController::class, 'create'])
        ->name('proyek.create');

    Route::post('/client/proyek', [ProyekController::class, 'store'])
        ->name('proyek.store');

    Route::delete('/client/proyek/{proyek}', [ProyekController::class, 'destroy'])
        ->name('proyek.destroy');

    Route::post('/proyek/{proyek}/tasks',
        [ProyekController::class, 'storeTask'])
        ->name('proyek.tasks.store');
});

Route::middleware(['auth', 'account.verified'])->group(function () {

    Route::get('/proposal', [ProposalController::class, 'index'])
        ->name('proposal.index');

    Route::get('/proposal/{proposal}', [ProposalController::class, 'show'])
        ->name('proposal.show');
});


require __DIR__ . '/auth.php';