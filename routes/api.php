<?php

use App\Http\Controllers\AlokasiKelasController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MataPelajaranController;
use App\Http\Controllers\MuridController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// MURID
Route::get('murid/index', [MuridController::class, 'index']);
Route::get('murid/{id}', [MuridController::class, 'show']);

// USER
Route::get('user/index', [UserController::class, 'index']);
Route::get('user/show/{id}', [UserController::class, 'show']);
Route::post('user/store', [UserController::class, 'store']);
Route::post('user/update/{id}', [UserController::class, 'update']);
Route::delete('user/delete/{id}', [UserController::class, 'destroy']);

// ALOKASI KELAS
Route::get('alokasikelas/index', [AlokasiKelasController::class, 'index']);
Route::get('alokasikelas/show/{id}', [AlokasiKelasController::class, 'show']);
Route::post('alokasikelas/store', [AlokasiKelasController::class, 'store']);
Route::post('alokasikelas/update/{id}', [AlokasiKelasController::class, 'update']);
Route::delete('alokasikelas/delete/{id}', [AlokasiKelasController::class, 'destroy']);

// GURU

Route::get('guru/index', [GuruController::class, 'index']);
Route::get('guru/show/{id}', [GuruController::class, 'show']);

// KELAS

Route::get('kelas/index', [KelasController::class, 'index']);

// MATA PELAJARAN

Route::get('matapelajaran/index', [MataPelajaranController::class, 'index']);
Route::get('matapelajaran/show/{id}', [MataPelajaranController::class, 'show']);
Route::post('matapelajaran/store', [MataPelajaranController::class, 'store']);
Route::post('matapelajaran/update/{id}', [MataPelajaranController::class, 'update']);
Route::delete('matapelajaran/delete/{id}', [MataPelajaranController::class, 'destroy']);

// NOTIFICATION

Route::get('notification/index', [NotificationController::class, 'index']);
Route::get('notification/show/{id}', [NotificationController::class, 'show']);
Route::post('notification/store', [NotificationController::class, 'store']);
Route::post('notification/update/{id}', [NotificationController::class, 'update']);

// ROLE

Route::get('role/index', [RoleController::class, 'index']);
Route::get('role/show/{id}', [RoleController::class, 'show']);
Route::post('role/store', [RoleController::class, 'store']);
Route::post('role/update/{id}', [RoleController::class, 'update']);
Route::delete('role/delete/{id}', [RoleController::class, 'destroy']);