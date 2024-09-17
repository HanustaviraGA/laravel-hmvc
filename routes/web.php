<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [DashboardController::class, 'index'])->name('index');
Route::get('/{any}', [DashboardController::class, 'index_spec'])->name('index_spec');
Route::post('login_aksi', [LoginController::class, 'login_aksi'])->name('login_aksi');
Route::post('logout_aksi', [LoginController::class, 'logout_aksi'])->name('logout_aksi');

Route::middleware('auth')->group(function () {
    Route::post('loadpage', function(Request $request){
        $destination = $request->destination; // Get the destination from the request
        return redirect(url('backoffice/'.$destination)); // Redirect to the module route
    })->name('loadpage');
});
