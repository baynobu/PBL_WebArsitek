<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\ProyekController;
use App\Http\Controllers\ArsitekController;
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

// Profil arsitek
Route::get('/arsitek/{user}', [ArsitekController::class, 'show'])->name('arsitek.show')->middleware('auth');

require __DIR__ . '/auth.php';
