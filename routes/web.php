<?php
use App\Http\Middleware\ViewPreferenceMiddleware;
use App\Http\Controllers\{UserController, JobController, CallController, ClientController, ViewPreferenceController};
use Illuminate\Support\Facades\Route;

// ----------------------------------------------------------------------------------------------AUTH
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('calls.index');
    }
    return view('auth/login');
});

// ----------------------------------------------------------------------------------------------USERS
Route::middleware(['auth'])->group(function () {
    Route::resource('users', UserController::class)->except(['show']);
    Route::get('/profile', [UserController::class, 'edit'])->name('users.profile.edit');
});

// ----------------------------------------------------------------------------------------------JOBS
Route::middleware(['auth'])->group(function () {

    // Rutas adicionales de Jobs
    Route::get('/jobs/{call}', [JobController::class, 'jobfromcallform'])->name('jobs.jobfromcallform');
    Route::post('/jobs/{job}', [JobController::class, 'jobfromcall'])->name('jobs.jobfromcall');

    Route::resource('jobs', JobController::class);
    Route::get('/jobs/histjobs', [JobController::class, 'histjob'])->name('jobs.histjobs');
    Route::get('/jobs/histjobs2', [JobController::class, 'histjob2'])->name('jobs.histjobs2');
    Route::get('/jobs/counter', [JobController::class, 'count'])->name('jobs.count');
    Route::delete('/jobs/histjobs/{histjob}', [JobController::class, 'histdestroy'])->name('jobs.histdestroy');
});

// ----------------------------------------------------------------------------------------------CALLS
Route::middleware(['auth'])->group(function () {
    Route::resource('calls', CallController::class)->except(['show']);
});

// ----------------------------------------------------------------------------------------------CLIENTS
Route::middleware(['auth'])->group(function () {
    Route::resource('clients', ClientController::class)->except(['show']);
    Route::get('/clients/import', [ClientController::class, 'showimport'])->name('clients.import');
    Route::post('/clients/import', [ClientController::class, 'import']);
});

// ----------------------------------------------------------------------------------------------VIEW PREFERENCES
Route::middleware(['auth'])->post('/change-view-preference', [ViewPreferenceController::class, 'changeViewPreference'])->name('changeViewPreference');

// ----------------------------------------------------------------------------------------------MIDDLEWARE VIEW PREFERENCE
Route::middleware(['auth', ViewPreferenceMiddleware::class])->group(function () {
    Route::get('/calls', [CallController::class, 'index'])->name('calls.index');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
    Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
});

require __DIR__.'/auth.php';



