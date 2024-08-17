<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\CallController;
use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth/login');
});

//----------------------------------------------------------------------------------------------USERS

Route::get('/users', function () {
    return view('users.index');
})->name('users.index');

//----------------------------------------------------------------------------------------------JOBS

Route::get('/trabajos', [JobController::class, 'index'])
    ->name('jobs.index');

Route::get('/trabajos/nuevo', [JobController::class, 'create'])
    ->name('jobs.create');

Route::post('/trabajos', [JobController::class, 'store']);

Route::post('/trabajos/{job}', [JobController::class, 'jobfromcall']);

Route::get('/trabajos/historico', [JobController::class, 'histjob'])
    ->name('jobs.histjobs');

Route::get('/trabajos/historico2', [JobController::class, 'histjob2'])
    ->name('jobs.histjobs2');

Route::get('/trabajos/{job}/editar', [JobController::class, 'edit'])
    ->where('job', '\d+')
    ->name('jobs.edit');

Route::put('/trabajos/{job}', [JobController::class, 'update']);

Route::get('/trabajos/contador', [JobController::class, 'count'])
    ->name('jobs.count');

Route::delete('/trabajos/{job}', [JobController::class, 'destroy'])
    ->name('jobs.destroy');

Route::delete('/trabajos/historico/{histjob}', [JobController::class, 'histdestroy'])
    ->name('jobs.histdestroy');


//----------------------------------------------------------------------------------------------CALLS

//Route::get('/dashboard', [HomeController::class, 'index'])
//    ->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', [HomeController::class, 'index'])
    ->middleware(['auth'])->name('dashboard');

Route::get('/llamadas/nuevo', [CallController::class, 'create'])
    ->name('calls.create');

Route::post('/llamadas', [CallController::class, 'store']);

Route::get('/llamadas/{call}', [CallController::class, 'jobfromcall'])
    ->name('calls.jobfromcall');

Route::get('/llamadas/{call}/editar', [CallController::class, 'edit'])
    ->where('call', '\d+')
    ->name('calls.edit');

Route::put('/llamadas/{call}', [CallController::class, 'update']);

Route::delete('/llamadas/{call}', [CallController::class, 'destroy'])
    ->name('calls.destroy');



//----------------------------------------------------------------------------------------------CLIENTS


Route::get('/clientes', [ClientController::class, 'index'])
    ->name('clients.index');

Route::get('/clientes/nuevo', [ClientController::class, 'create'])
    ->name('clients.create');

Route::post('/clientes', [ClientController::class, 'store']);

Route::get('/clientes/{client}/editar', [ClientController::class, 'edit'])
    ->where('client', '\d+')
    ->name('clients.edit');

Route::put('/clientes/{client}', [ClientController::class, 'update']);

Route::delete('/clientes/{client}', [ClientController::class, 'destroy'])
    ->name('clients.destroy');

Route::get('/clientes/importacion', [ClientController::class, 'showimport'])
    ->name('clients.import');

Route::post('/clientes/importacion', [ClientController::class, 'import']);



//----------------------------------------------------------------------------------------------SETTINGS

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
