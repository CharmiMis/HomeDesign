<?php

use App\Http\Controllers\PrecisionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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
});


Route::get('/precision', function () {
    return view('precision.index');
})->name('precision.index');

Route::get('user/get-projects', [PrecisionController::class, 'getProjects'])->name('user.get-projects');
Route::get('user/get-subprojects', [PrecisionController::class, 'getSubProjects'])->name('user.get-subprojects');

Route::post('failed_response_data', [PrecisionController::class, 'failedResponseData'])->name('failed_response.data');
Route::post('runpod/precision', [PrecisionController::class, 'runpodPrecion'])->name('runpod.precision');

Route::get('in-painting-designs', [PrecisionController::class, 'getInPaintingDesigns'])->name('inpainting.designs');


require __DIR__.'/auth.php';
