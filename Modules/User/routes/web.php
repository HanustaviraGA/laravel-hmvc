<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\UserController;

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

Route::prefix('backoffice/user')->group(function() {
    Route::get('/', [UserController::class, 'index'])->name('user.index');
    Route::post('create', [UserController::class, 'create'])->name('user.create');
    Route::post('read', [UserController::class, 'read'])->name('user.read');
    Route::put('update', [UserController::class, 'update'])->name('user.update');
    Route::delete('delete', [UserController::class, 'delete'])->name('user.delete');
    // Custom
    Route::post('init_table', [UserController::class, 'init_table'])->name('user.init_table');
    Route::post('role_list', [UserController::class, 'role_list'])->name('user.role_list');
});
