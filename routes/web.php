<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\Ativo\NovoAtivoController;
use App\Http\Controllers\Admin\Ativo\UpdateAtivoController;
use App\Http\Controllers\Admin\Ativo\ListarAtivosController;
use App\Http\Controllers\Admin\Ativo\RemoverAtivoController;
use App\Http\Controllers\Admin\Dashboard\DashboardController;
use App\Http\Controllers\Admin\Operacao\NovaOperacaoController;
use App\Http\Controllers\Admin\Provento\NovoProventoController;
use App\Http\Controllers\Admin\Operacao\UpdateOperacaoController;
use App\Http\Controllers\Admin\Provento\UpdateProventoController;
use App\Http\Controllers\Admin\Operacao\ListarOperacoesController;
use App\Http\Controllers\Admin\Operacao\RemoverOperacaoController;
use App\Http\Controllers\Admin\Provento\ListarProventosController;
use App\Http\Controllers\Admin\Provento\RemoverProventoController;
use App\Http\Controllers\Admin\Portfolio\ListarPortfolioController;
use App\Http\Controllers\Admin\ClasseAtivo\NovaClasseAtivoController;
use App\Http\Controllers\Admin\ClasseAtivo\UpdateClasseAtivoController;
use App\Http\Controllers\Admin\ClasseAtivo\RemoverClasseAtivoController;
use App\Http\Controllers\Admin\ClasseAtivo\ListarClassesAtivosController;
use App\Http\Controllers\Admin\Rebalanceamento\ListarRebalanceamentoController;
use App\Http\Controllers\Admin\Rebalanceamento\NovoRebalanceamentoAtivoController;
use App\Http\Controllers\Admin\Rebalanceamento\NovoRebalanceamentoClasseController;
use App\Http\Controllers\Admin\Rebalanceamento\ListarConfigRebalanceamentoController;
use App\Http\Controllers\Admin\Rebalanceamento\RemoverRebalanceamentoAtivoController;
use App\Http\Controllers\Admin\Rebalanceamento\RemoverRebalanceamentoClasseController;
use App\Http\Controllers\Admin\Rebalanceamento\AtualizarRebalanceamentoAtivoController;
use App\Http\Controllers\Admin\Rebalanceamento\AtualizarRebalanceamentoClasseController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->prefix('admin')->group(function () {

    Route::prefix('dashboard')->group(function () {
        Route::get('/', DashboardController::class)->name('dashboard');
    });

    Route::prefix('classes-ativos')->group(function () {
        Route::get('/', ListarClassesAtivosController::class)->name('classes-ativos.index');
        Route::post('/', NovaClasseAtivoController::class)->name('classes-ativos.store');
        Route::put('/{uid}', UpdateClasseAtivoController::class)->name('classes-ativos.update');
        Route::delete('/{uid}', RemoverClasseAtivoController::class)->name('classes-ativos.delete');
    });

    Route::prefix('ativos')->group(function () {
        Route::get('/', ListarAtivosController::class)->name('ativos.index');
        Route::post('/', NovoAtivoController::class)->name('ativos.novo');
        Route::put('/{uid}', UpdateAtivoController::class)->name('ativos.update');
        Route::delete('/{uid}', RemoverAtivoController::class)->name('ativos.delete');
    });

    Route::prefix('operacoes')->group(function () {
        Route::get('/', ListarOperacoesController::class)->name('operacoes.index');
        Route::post('/', NovaOperacaoController::class)->name('operacoes.store');
        Route::put('/{uid}', UpdateOperacaoController::class)->name('operacoes.update');
        Route::delete('/{uid}', RemoverOperacaoController::class)->name('operacoes.delete');
    });

    Route::prefix('proventos')->group(function () {
        Route::get('/', ListarProventosController::class)->name('proventos.index');
        Route::post('/', NovoProventoController::class)->name('proventos.store');
        Route::put('/{uid}', UpdateProventoController::class)->name('proventos.update');
        Route::delete('/{uid}', RemoverProventoController::class)->name('proventos.delete');
    });

    Route::prefix('rebalanceamento')->group(function () {
        Route::get('/', ListarRebalanceamentoController::class)->name('rebalanceamento.index');
        Route::get('/config', ListarConfigRebalanceamentoController::class)->name('rebalanceamento.config');
        Route::post('/ativo', NovoRebalanceamentoAtivoController::class)->name('rebalanceamento-ativo.store');
        Route::put('/ativo/{uid}', AtualizarRebalanceamentoAtivoController::class)->name('rebalanceamento-ativo.update');
        Route::delete('/ativo/{uid}', RemoverRebalanceamentoAtivoController::class)->name('rebalanceamento-ativo.delete');
        Route::post('/classe', NovoRebalanceamentoClasseController::class)->name('rebalanceamento-classe.store');
        Route::put('/classe/{uid}', AtualizarRebalanceamentoClasseController::class)->name('rebalanceamento-classe.update');
        Route::delete('/classe/{uid}', RemoverRebalanceamentoClasseController::class)->name('rebalanceamento-classe.delete');
    });

    Route::prefix('portfolio')->group(function () {
        Route::get('/', ListarPortfolioController::class)->name('portfolio.index');
    });
});

require __DIR__ . '/auth.php';
