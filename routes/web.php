<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\Ativo\ListarAtivosController;
use App\Http\Controllers\Admin\Operacao\ListarOperacoesController;
use App\Http\Controllers\Admin\Provento\ListarProventosController;
use App\Http\Controllers\Admin\Rebalanceamento\ListarRebalanceamentoController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->prefix('admin')->group(function () {
    Route::prefix('ativos')->group(function () {
        Route::get('/', ListarAtivosController::class)->name('ativos.index');
    });

    Route::prefix('operacoes')->group(function () {
        Route::get('/', ListarOperacoesController::class)->name('operacoes.index');
    });

    Route::prefix('proventos')->group(function () {
        Route::get('/', ListarProventosController::class)->name('proventos.index');
    });

    Route::prefix('rebalanceamento')->group(function () {
        Route::get('/', ListarRebalanceamentoController::class)->name('rebalanceamento.index');
    });
});

require __DIR__.'/auth.php';
