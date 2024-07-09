<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
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


Route::get('/precisionold', function () {
    return view('precision.index');
})->middleware(['auth', 'verified'])->name('precision.index');

// Route::get('user/get-projects', [PrecisionController::class, 'getProjects'])->name('user.get-projects');
// Route::get('user/get-subprojects', [PrecisionController::class, 'getSubProjects'])->name('user.get-subprojects');

Route::post('failed_response_data', [PrecisionController::class, 'failedResponseData'])->name('failed_response.data');
Route::post('runpod/precision', [PrecisionController::class, 'runpodPrecion'])->name('runpod.precision');

Route::get('in-painting-designs', [PrecisionController::class, 'getInPaintingDesigns'])->name('inpainting.designs');
Route::get('get-base64', [PrecisionController::class, 'downloadFile'])->name('file.download');
Route::post('getBase64ImageUrl', [PrecisionController::class, 'getBase64ImageUrl'])->name('getBase64Image.Url');

//New design Routes
Route::post('runpod/getMasking', [PrecisionController::class, 'runpodGetMasking'])->name('runpod.getmasking');
Route::get('redesign', [PrecisionController::class, 'redesign'])->middleware(['auth', 'verified'])->name('user.redesign');
Route::get('precision', [PrecisionController::class, 'inPainting'])->middleware(['auth', 'verified'])->name('user.in-painting');
Route::get('fill-spaces',[PrecisionController::class,'fillSpaces'])->middleware(['auth', 'verified'])->name('user.fill-spaces');
Route::post('getFullHd', [PrecisionController::class, 'getFullHdData'])->name('getHdImages');
Route::post('imageDelete', [PrecisionController::class, 'imageDelete'])->name('image.delete');
Route::post('get_next_runpod', [PrecisionController::class, 'runpodHostName'])->name('nextrunpod.name');
Route::post('decorCount', [PrecisionController::class, 'decorCount'])->name('decor.clickCount');
Route::post('runpod/fullHD', [PrecisionController::class, 'runpodFullHD'])->name('runpod.fullHD');
Route::post('runpod/fill_space', [PrecisionController::class, 'runpodFillSpace'])->name('runpod.fill_space');
Route::get('get-designs', [PrecisionController::class, 'getDesigns'])->name('web.designs');
Route::post('runpod/beautiful_redesign', [PrecisionController::class, 'runpodBeautifulRedesign'])->name('runpod.beautiful_redesign');

Route::post('runpod/paint-visualizer', [PrecisionController::class, 'runpodColorSwapTransfer'])->name('runpod.color_swap');
Route::get('/paint-visualizer', [PrecisionController::class, 'paintVisulizerIndex'])->name('colorSwap.Index');

require __DIR__.'/auth.php';
