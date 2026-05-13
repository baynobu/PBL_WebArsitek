<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProyekController;
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

// Proposal routes
use App\Http\Controllers\ProposalController;
Route::get('/proyek/{proyek}/proposal/create', [ProposalController::class, 'create'])->name('proposal.create')->middleware('auth');
Route::post('/proyek/{proyek}/proposal', [ProposalController::class, 'store'])->name('proposal.store')->middleware('auth');
Route::get('/proposals', [ProposalController::class, 'index'])->name('proposal.index')->middleware('auth');
Route::get('/proposal/{proposal}', [ProposalController::class, 'show'])->name('proposal.show');

require __DIR__ . '/auth.php';
