<?php

use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Api\AuthController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('auth')->group(function () {
    Route::post('/login', action: [AuthController::class, 'login']);
    Route::post('/register', action: [AuthController::class, 'register']);
    Route::get('/users', action: [AuthController::class, 'indexBySoftDelete']);
    Route::delete(uri: '/users/{id}', action: [AuthController::class, 'destroy']);
    Route::delete(uri: '/users/rest/{id}', action: [AuthController::class, 'restore']);

});


/*Role*/
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/roles', [RoleController::class, 'index']);
    Route::post('/roles', [RoleController::class, 'store']);
    Route::get('/roles/{id}', [RoleController::class, 'show']);
    Route::put('/roles/{id}', [RoleController::class, 'update']);
    Route::delete('/roles/{id}', [RoleController::class, 'destroy']);
});
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);





// logout

Route::delete('/auth/logout', [AuthController::class, 'logout'])
    ->middleware(['auth:sanctum']);
