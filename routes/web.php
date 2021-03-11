<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ParserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ParserController::class, 'index'])->name('parser.index');

Route::post('/parse', [ParserController::class, 'parse'])->name('parser.parse');

Route::post('/limpiar', [ParserController::class, 'limpiar'])->name('parser.limpiar');
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

// require __DIR__.'/auth.php';
