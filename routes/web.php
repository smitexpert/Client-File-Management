<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('dashboard', function(){
    return view('admin.users.index');
});

Route::prefix('admin')->name('admin.')->group(function(){
    Route::get('login', [App\Http\Controllers\Admin\AuthController::class, 'index'])->name('login');
    Route::post('login', [App\Http\Controllers\Admin\AuthController::class, 'attempt'])->name('login.attempt');
    Route::get('logout', [App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('logout');

    Route::middleware('auth')->group(function(){
        // Client Users
        Route::get('users', [\App\Http\Controllers\Admin\ClientController::class, 'index'])->name('users');
        Route::get('users/create', [\App\Http\Controllers\Admin\ClientController::class, 'create'])->name('users.create');
        Route::post('users/create', [\App\Http\Controllers\Admin\ClientController::class, 'store'])->name('users.store');
        Route::get('users/{id}', [\App\Http\Controllers\Admin\ClientController::class, 'edit'])->name('users.edit');
        Route::post('users/{id}', [\App\Http\Controllers\Admin\ClientController::class, 'update'])->name('users.update');

        Route::get('users/{id}/files', [\App\Http\Controllers\Admin\ClientController::class, 'files'])->name('users.files');

        Route::post('users/{id}/files', [\App\Http\Controllers\Admin\ClientController::class, 'upload'])->name('users.files.upload');

        Route::get('files/{id}', [\App\Http\Controllers\Admin\FileController::class, 'index'])->name('file');
        Route::get('files/{id}/send/user/{customer}', [\App\Http\Controllers\Admin\FileController::class, 'send'])->name('file.send');

        Route::post('files/{customer}/send/user/', [\App\Http\Controllers\Admin\FileController::class, 'multiple'])->name('file.multiple');

        // Profile
        Route::get('profile', [\App\Http\Controllers\Admin\ProfileController::class, 'index'])->name('profile');
        Route::post('profile', [\App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');
    });
});
