<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewtonRaphsonController;
use App\Http\Controllers\EulerController;
use App\Http\Controllers\RungeKuttaController;

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

Route::get('/', [NewtonRaphsonController::class, 'index'])->name('newton');
Route::post('/', [NewtonRaphsonController::class, 'calculate'])->name('newton.calculate');
Route::get('/euler', [EulerController::class, 'index'])->name('euler');
Route::post('/euler', [EulerController::class, 'calculate'])->name('euler.calculate');
Route::get('runge-kutta', [RungeKuttaController::class, 'index'])->name('runge-kutta');
Route::post('runge-kutta/calculate', [RungeKuttaController::class, 'calculate'])->name('runge-kutta.calculate');

