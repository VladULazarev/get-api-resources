<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\TaskController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

# Clear all for debugging
Route::get('/clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('route:clear');

    return "Cache cleared";
});

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('api.auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::get('/dashboard', function () { return view('dashboard'); })->name('dashboard');
    Route::get('/api-message', function () { return view('tasks.api-message'); })->name('api-message');

    # Show all records
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');

    # Show records by 'search' data (typing in the 'Search' field)
    Route::post('/tasks/search', [TaskController::class, 'indexBySelectedParams']);

    # Show records by a current page number
    Route::post('/tasks-by-page-number', [TaskController::class, 'indexByPageNumber']);

    # Store a new record
    Route::post('/tasks', [TaskController::class, 'store']);

    # Show the view to create a new record
    Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');

    # Show a record
    Route::get('/tasks/{id}', [TaskController::class, 'show'])->name('tasks.show');

    # Show the view to edit a record
    Route::get('/tasks/{id}/edit', [TaskController::class, 'edit'])->name('tasks.edit');

    # Update a record
    Route::patch('/tasks/{id}', [TaskController::class, 'update']);

    # Show the view to delete a record
    Route::get('/tasks/{id}/destroy', [TaskController::class, 'destroy'])->name('tasks.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
