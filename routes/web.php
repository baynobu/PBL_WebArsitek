<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\ProyekController;
use App\Http\Controllers\ArsitekController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ProfilArsitekController;
use App\Http\Controllers\PortofolioController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::get('/admin', function () {
            return '/admin';
        });
    });
});

// Proyek - public listing and detail (Milestone 1)
Route::get('/proyek', [ProyekController::class, 'index'])->name('proyek.index');
Route::get('/proyek/{proyek}', [ProyekController::class, 'show'])->name('proyek.show');
Route::get('/client/proyek', [ProyekController::class, 'myProjects'])->name('proyek.my')->middleware('auth');
Route::get('/client/proyek/create', [ProyekController::class, 'create'])->name('proyek.create')->middleware('auth');
Route::post('/client/proyek', [ProyekController::class, 'store'])->name('proyek.store')->middleware('auth');
Route::patch('/proyek/{proyek}/status', [ProyekController::class, 'updateStatus'])->name('proyek.updateStatus')->middleware('auth');

// Proposal routes
Route::get('/proyek/{proyek}/proposal/create', [ProposalController::class, 'create'])->name('proposal.create')->middleware('auth');
Route::post('/proyek/{proyek}/proposal', [ProposalController::class, 'store'])->name('proposal.store')->middleware('auth');
Route::get('/proposals', [ProposalController::class, 'index'])->name('proposal.index')->middleware('auth');
Route::get('/proposal/{proposal}', [ProposalController::class, 'show'])->name('proposal.show')->middleware('auth');
Route::patch('/proposal/{proposal}/terima', [ProposalController::class, 'terima'])->name('proposal.terima')->middleware('auth');
Route::patch('/proposal/{proposal}/tolak', [ProposalController::class, 'tolak'])->name('proposal.tolak')->middleware('auth');

// Rating routes (Milestone 5)
Route::get('/proyek/{proyek}/rating/create', [RatingController::class, 'create'])->name('rating.create')->middleware('auth');
Route::post('/proyek/{proyek}/rating', [RatingController::class, 'store'])->name('rating.store')->middleware('auth');

// Arsitek manage profile and portofolio
Route::middleware('auth')->group(function () {
    Route::get('/arsitek/profile/edit', [ProfilArsitekController::class, 'edit'])->name('arsitek.profile.edit');
    Route::patch('/arsitek/profile', [ProfilArsitekController::class, 'update'])->name('arsitek.profile.update');

    Route::get('/arsitek/portofolio', [PortofolioController::class, 'index'])->name('portofolio.index');
    Route::get('/arsitek/portofolio/create', [PortofolioController::class, 'create'])->name('portofolio.create');
    Route::post('/arsitek/portofolio', [PortofolioController::class, 'store'])->name('portofolio.store');
    Route::get('/arsitek/portofolio/{portofolio}/edit', [PortofolioController::class, 'edit'])->name('portofolio.edit');
    Route::patch('/arsitek/portofolio/{portofolio}', [PortofolioController::class, 'update'])->name('portofolio.update');
    Route::delete('/arsitek/portofolio/{portofolio}', [PortofolioController::class, 'destroy'])->name('portofolio.destroy');
});

// Profil arsitek (placed after arsitek-specific fixed routes to avoid catching '/arsitek/portofolio')
Route::get('/arsitek/{user}', [ArsitekController::class, 'show'])->name('arsitek.show')->middleware('auth');

require __DIR__ . '/auth.php';
