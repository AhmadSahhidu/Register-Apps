<?php

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CompetisionController;
use App\Http\Controllers\KordaController;
use App\Http\Controllers\KorwilController;
use App\Http\Controllers\RegisterCompetisionController;
use App\Http\Controllers\RegisterCompetisionUmumController;
use App\Http\Controllers\RequestRegisterCompetisionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Models\Competision;
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
        Route::get('anggota/{korwilId}', [KorwilController::class, 'anggotaKorwil'])->name('anggota');
        Route::get('create', [KorwilController::class, 'create'])->name('create');
        Route::post('create', [KorwilController::class, 'store'])->name('store');
        Route::get('edit/{korwilId}', [KorwilController::class, 'show'])->name('show');
        Route::put('update/{korwilId}', [KorwilController::class, 'update'])->name('update');
        Route::get('delete', [KorwilController::class, 'delete'])->name('delete');
    });

    Route::prefix('korda')->name('korda.')->group(function () {
        Route::get('/', [KordaController::class, 'index'])->name('index');
        Route::get('anggota/{kordaId}', [KordaController::class, 'anggotaKorda'])->name('anggota');
        Route::get('create', [KordaController::class, 'create'])->name('create');
        Route::post('create', [KordaController::class, 'store'])->name('store');
        Route::get('edit/{korwilId}', [KordaController::class, 'show'])->name('show');
        Route::put('update/{korwilId}', [KordaController::class, 'update'])->name('update');
        Route::get('delete', [KordaController::class, 'delete'])->name('delete');
    });

    Route::prefix('anggota')->name('anggota.')->group(function () {
        Route::get('/', [AnggotaController::class, 'index'])->name('index');
        Route::get('create', [AnggotaController::class, 'create'])->name('create');
        Route::post('store', [AnggotaController::class, 'store'])->name('store');
        Route::get('edit/{anggotaId}', [AnggotaController::class, 'edit'])->name('edit');
        Route::put('update/{anggotaId}', [AnggotaController::class, 'update'])->name('update');
        Route::get('delete', [AnggotaController::class, 'delete'])->name('delete');
    });

    Route::prefix('competision')->name('competision.')->group(function () {
        Route::get('/', [CompetisionController::class, 'index'])->name('index');
        Route::get('create', [CompetisionController::class, 'create'])->name('create');
        Route::post('store', [CompetisionController::class, 'store'])->name('store');
        Route::get('edit/{competisionId}', [CompetisionController::class, 'edit'])->name('show');
        Route::put('update/{competisionId}', [CompetisionController::class, 'update'])->name('update');
        Route::get('delete', [CompetisionController::class, 'delete'])->name('delete');
        Route::get('peserta/{competisionId}', [CompetisionController::class, 'peserta'])->name('list-peserta');
        Route::get('set-session/{competisionId}', [CompetisionController::class, 'setSessionPeserta'])->name('set_session');
        Route::get('peserta-tambahan/{competisionId}', [CompetisionController::class, 'pesertaTambahan'])->name('peserta_tambahan');
        Route::get('import-peserta-gelombang-one/{pesertaId}', [CompetisionController::class, 'importGelombangOne'])->name('import_gelombang_one');
        Route::get('import-Allpeserta-next-gelombang/{pesertaId}', [CompetisionController::class, 'importAllPesertaTambahan'])->name('import_next_gelombang');
        Route::get('delete-peserta-tambahan', [CompetisionController::class, 'deletePesertaTambahan'])->name('delete_peserta_tambahan');
        Route::get('close-register/{competisionId}', [CompetisionController::class, 'closeRegister'])->name('close_register');
    });

    Route::prefix('register')->name('register.')->group(function () {
        Route::get('/', [RegisterCompetisionController::class, 'index'])->name('index');
        Route::get('session/{competisionId}', [RegisterCompetisionController::class, 'sessionRegister'])->name('session-register');
        Route::post('session/{competisionId}', [RegisterCompetisionController::class, 'process'])->name('process-register');
        Route::get('list-peserta/{competisionId}', [RegisterCompetisionController::class, 'listPeserta'])->name('list-peserta');
        Route::get('peserta-tambahan/{competisionId}', [RequestRegisterCompetisionController::class, 'formRequest'])->name('request-peserta');
        Route::post('proses-peserta-tambahan/{competisionId}', [RequestRegisterCompetisionController::class, 'prosesRegisterAdd'])->name('proses-peserta-tambahan');

        Route::get('register-umum', [RegisterCompetisionUmumController::class, 'index'])->name('register_umum');
        Route::get('form-register-umum/{competisionId}', [RegisterCompetisionUmumController::class, 'create'])->name('form_register_umum');
        Route::post('store-register-umum/{competisionId}', [RegisterCompetisionUmumController::class, 'store'])->name('store_register_umum');
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
        Route::get('edit/{userId}', [UserController::class, 'edit'])->name('edit');
        Route::put('update/{userId}', [UserController::class, 'update'])->name('update');
        Route::get('delete', [UserController::class, 'usersDelete'])->name('delete');
    });
});
