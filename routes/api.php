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
Route::get('murid', [MuridController::class, 'index']);
Route::get('murid/{id}', [MuridController::class, 'show']);

// USER
Route::get('user', [UserController::class, 'index']);
Route::get('user/{id}', [UserController::class, 'show']);

// ALOKASI KELAS
Route::get('alokasikelas', [AlokasiKelasController::class, 'index']);

// GURU

Route::get('guru', [GuruController::class, 'index']);

// KELAS

Route::get('kelas', [KelasController::class, 'index']);

// MATA PELAJARAN

Route::get('matapelajaran', [MataPelajaranController::class, 'index']);

// NOTIFICATION

Route::get('notification', [NotificationController::class, 'index']);

// ROLE

Route::get('role', [RoleController::class, 'index']);