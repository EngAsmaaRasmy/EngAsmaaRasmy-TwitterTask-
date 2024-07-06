<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImageController;
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

Route::get('/', [AuthController::class, 'showLoginForm']);
Route::post('/verify-token', [AuthController::class, 'verifyToken']);
// Route::get('/dashboard', 'DashboardController@index')->middleware('auth');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

//upload routes
Route::get('/upload-image', [ImageController::class, 'index'])->name('upload.image');
Route::post('/store-image', [ImageController::class, 'store'])->name('image.store');
Route::get('/images', [ImageController::class, 'getImages']);
Route::post('/approve-image/{id}', [ImageController::class, 'approveImage']);
Route::post('/reject-image/{id}', [ImageController::class, 'rejectImage']);


Route::get('/categories', [CategoryController::class, 'index'])->name('categories');

Route::get('/accounts', [AccountController::class, 'index'])->name('accounts');
Route::get('/tasks-under-price', [AccountController::class, 'viewTasksUnderPrice'])->name('tasks.under-price');