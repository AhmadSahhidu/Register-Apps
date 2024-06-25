<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CompetisionController;
use App\Http\Controllers\KorwilController;
use App\Http\Controllers\RegisterCompetisionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
})->name('login');

Route::post('actionLogin', [AuthController::class, 'actionLogin'])->name('action-login');
Route::get('actionlogut', [AuthController::class, 'logout'])->name('logout');
Route::get('create-user-super-admin', [AuthController::class, 'createUserSuperAdmin'])->name('super_admin_create');

Route::get('dashboard', function () {
    return view('pages.dashboard');
})->name('dashboard')->middleware('auth');


Route::group(['middleware' => ['auth']], static function () {

    Route::prefix('korwil')->name('korwil.')->group(function () {
        Route::get('/', [KorwilController::class, 'index'])->name('index');
        Route::get('create', [KorwilController::class, 'create'])->name('create');
        Route::post('create', [KorwilController::class, 'store'])->name('store');
        Route::get('edit/{korwilId}', [KorwilController::class, 'show'])->name('show');
        Route::put('update/{korwilId}', [KorwilController::class, 'update'])->name('update');
        Route::get('delete', [KorwilController::class, 'delete'])->name('delete');
    });

    Route::prefix('competision')->name('competision.')->group(function () {
        Route::get('/', [CompetisionController::class, 'index'])->name('index');
        Route::get('create', [CompetisionController::class, 'create'])->name('create');
        Route::post('store', [CompetisionController::class, 'store'])->name('store');
        Route::get('edit/{competisionId}', [CompetisionController::class, 'edit'])->name('show');
        Route::put('update/{competisionId}', [CompetisionController::class, 'update'])->name('update');
        // Route::get('delete', [KorwilController::class, 'delete'])->name('delete');
    });

    Route::prefix('register')->name('register.')->group(function () {
        Route::get('/', [RegisterCompetisionController::class, 'index'])->name('index');
        Route::get('session/{competisionId}', [RegisterCompetisionController::class, 'sessionRegister'])->name('session-register');
        Route::post('session/{competisionId}', [RegisterCompetisionController::class, 'process'])->name('process-register');
        Route::get('list-peserta/{competisionId}', [RegisterCompetisionController::class, 'listPeserta'])->name('list-peserta');
    });
    Route::prefix('roles')->name('roles.')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('index');
        Route::get('create', [RoleController::class, 'create'])->name('create');
        Route::post('store', [RoleController::class, 'store'])->name('store');
        Route::get('edit/{roleId}', [RoleController::class, 'edit'])->name('edit');
        Route::put('update/{roleId}', [RoleController::class, 'update'])->name('update');
        Route::get('delete', [RoleController::class, 'delete'])->name('delete');
    });

    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('create', [UserController::class, 'create'])->name('create');
        Route::post('store', [UserController::class, 'store'])->name('store');
        // Route::get('edit/{roleId}', [RoleController::class, 'edit'])->name('edit');
        // Route::put('update/{roleId}', [RoleController::class, 'update'])->name('update');
        // Route::get('delete', [RoleController::class, 'delete'])->name('delete');
    });
});
