<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\CallController;
use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;

//----------------------------------------------------------------------------------------------AUTH

Route::get('/', function () {
    return view('auth/login');
});

//----------------------------------------------------------------------------------------------USERS

Route::get('/users', [UserController::class, 'index'])
    ->middleware(['auth'])
    ->name('users.index');

Route::get('/users/new', [UserController::class, 'create'])
    ->middleware(['auth'])
    ->name('users.create');

Route::post('/users', [UserController::class, 'store'])
    ->middleware('auth')
    ->name('users.store');

Route::get('/users/{user}/edit', [UserController::class, 'edit'])
    ->where('user', '\d+')
    ->middleware(['auth'])
    ->name('users.edit');

Route::get('/profile', [UserController::class, 'edit'])
    ->middleware(['auth'])
    ->name('users.profile.edit');

Route::put('/users/{user}', [UserController::class, 'update'])
    ->middleware(['auth'])
    ->name('users.update');

Route::delete('/users/{user}', [UserController::class, 'destroy'])
    ->middleware(['auth'])
    ->name('users.destroy');

//----------------------------------------------------------------------------------------------JOBS

Route::get('/jobs', [JobController::class, 'index'])
    ->middleware(['auth'])
    ->name('jobs.index');

Route::get('/jobs/new', [JobController::class, 'create'])
    ->middleware(['auth'])
    ->name('jobs.create');

Route::get('/jobs/{call}', [JobController::class, 'jobfromcallindex'])
    ->middleware(['auth'])
    ->name('jobs.jobfromcallindex');

Route::post('/jobs', [JobController::class, 'store'])
    ->middleware('auth')
    ->name('jobs.store');

Route::post('/jobs/{job}', [JobController::class, 'jobfromcall'])
    ->middleware(['auth'])
    ->name('jobs.jobfromcall');

Route::get('/jobs/histjobs', [JobController::class, 'histjob'])
    ->middleware(['auth'])
    ->name('jobs.histjobs');

Route::get('/jobs/histjobs2', [JobController::class, 'histjob2'])
    ->middleware(['auth'])
    ->name('jobs.histjobs2');

Route::get('/jobs/{job}/edit', [JobController::class, 'edit'])
    ->where('job', '\d+')
    ->middleware(['auth'])
    ->name('jobs.edit');

Route::put('/jobs/{job}', [JobController::class, 'update'])
    ->middleware(['auth'])
    ->name('jobs.update');

Route::get('/jobs/counter', [JobController::class, 'count'])
    ->middleware(['auth'])
    ->name('jobs.count');

Route::delete('/jobs/{job}', [JobController::class, 'destroy'])
    ->middleware(['auth'])
    ->name('jobs.destroy');

Route::delete('/jobs/histjobs/{histjob}', [JobController::class, 'histdestroy'])
    ->middleware(['auth'])
    ->name('jobs.histdestroy');


//----------------------------------------------------------------------------------------------CALLS

//Route::get('/dashboard', [HomeController::class, 'index'])
//    ->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/', [CallController::class, 'index'])
    ->middleware(['auth'])
    ->name('calls.index');

route::post('/change-view-preference', [CallController::class, 'changeViewPreference'])->name('changeViewPreference');

Route::get('/calls/new', [CallController::class, 'create'])
    ->middleware(['auth'])
    ->name('calls.create');

Route::post('/calls', [CallController::class, 'store'])
    ->middleware(['auth'])
    ->name('calls.store');

Route::get('/calls/{call}/edit', [CallController::class, 'edit'])
    ->where('call', '\d+')
    ->middleware(['auth'])
    ->name('calls.edit');

Route::put('/calls/{call}', [CallController::class, 'update'])
    ->middleware(['auth'])
    ->name('calls.update');

Route::delete('/calls/{call}', [CallController::class, 'destroy'])
    ->middleware(['auth'])
    ->name('calls.destroy');



//----------------------------------------------------------------------------------------------CLIENTS


Route::get('/clients', [ClientController::class, 'index'])
    ->middleware(['auth'])
    ->name('clients.index');

Route::get('/clients/new', [ClientController::class, 'create'])
    ->middleware(['auth'])
    ->name('clients.create');

Route::post('/clients', [ClientController::class, 'store'])
    ->middleware('auth')
    ->name('clients.store');

Route::get('/clients/{client}/edit', [ClientController::class, 'edit'])
    ->where('client', '\d+')
    ->middleware(['auth'])
    ->name('clients.edit');

Route::put('/clients/{client}', [ClientController::class, 'update'])
    ->middleware(['auth'])
    ->name('clients.update');

Route::delete('/clients/{client}', [ClientController::class, 'destroy'])
    ->middleware(['auth'])
    ->name('clients.destroy');

Route::get('/clients/import', [ClientController::class, 'showimport'])
    ->middleware(['auth'])
    ->name('clients.import');

Route::post('/clients/import', [ClientController::class, 'import']);



//----------------------------------------------------------------------------------------------SETTINGS

Route::middleware('auth')->group(function () {
//    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
