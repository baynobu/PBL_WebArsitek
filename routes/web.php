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

    // 1. JIKA YANG LOGIN ADALAH ADMIN
    if ($user->role === 'admin') {
        return app(App\Http\Controllers\AdminController::class)->index(request());
    }

    // 2. JIKA YANG LOGIN ADALAH ARSITEK
    if ($user->role === 'arsitek') {
        $proyeks = \App\Models\Proyek::where('is_hidden', false)
            ->where('status', 'open')
            ->latest()
            ->paginate(10);

        return view('dashboard', compact('user', 'proyeks'));
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

// Arsitek and Portofolio routes
Route::middleware(['auth', 'account.verified', 'role:arsitek'])->group(function () {
    Route::get('/arsitek/proyek', [ArsitekController::class, 'myProjects'])->name('arsitek.proyek');
    Route::get('/arsitek/profile/edit', [ProfilArsitekController::class, 'edit'])->name('arsitek.profile.edit');
    Route::match(['post', 'patch'], '/arsitek/profile/edit', [ProfilArsitekController::class, 'update'])->name('arsitek.profile.update');
    Route::resource('portofolio', PortofolioController::class)->except(['show']);

    // Proposal submission
    Route::get('/proyek/{proyek}/proposal/create', [ProposalController::class, 'create'])->name('proposal.create');
    Route::post('/proyek/{proyek}/proposal', [ProposalController::class, 'store'])->name('proposal.store');
});

// Arsitek public profile
Route::get('/arsitek/{user}', [ArsitekController::class, 'show'])->name('arsitek.show');

// Admin panel actions routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::post('/admin/users/{user}/approve', [App\Http\Controllers\AdminController::class, 'approveUser'])->name('admin.users.approve');
    Route::post('/admin/users/{user}/reject', [App\Http\Controllers\AdminController::class, 'rejectUser'])->name('admin.users.reject');
    Route::post('/admin/proyek/{proyek}/toggle-featured', [App\Http\Controllers\AdminController::class, 'toggleProjectFeatured'])->name('admin.proyek.toggle-featured');
    Route::post('/admin/proyek/{proyek}/toggle-hidden', [App\Http\Controllers\AdminController::class, 'toggleProjectHidden'])->name('admin.proyek.toggle-hidden');
    Route::post('/admin/landing-content', [App\Http\Controllers\AdminController::class, 'storeLandingContent'])->name('admin.landing-content.store');
    Route::put('/admin/landing-content/{content}', [App\Http\Controllers\AdminController::class, 'updateLandingContent'])->name('admin.landing-content.update');
    Route::delete('/admin/landing-content/{content}', [App\Http\Controllers\AdminController::class, 'destroyLandingContent'])->name('admin.landing-content.destroy');
});

require __DIR__ . '/auth.php';
