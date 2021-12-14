<?php

use App\Http\Controllers\TodoController;
use App\Http\Middleware\Admin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
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

// Public routes
Route::post('/register', [AuthController::class, 'Register']);
Route::post('/login', [AuthController::class, 'Login']);

Route::group(['middleware' => ['auth:sanctum']], function (){

    // User routes
    Route::get('/tasks', [UserController::class, 'index']);
    Route::post('/update/{id}', [TodoController::class, 'updateStatus']);
    Route::get('/user', [AuthController::class, 'GetUser']);
    Route::post('/logout', [AuthController::class, 'Logout']);

    // Administrator routes
    Route::middleware([Admin::class])->group(function () {

        Route::get('/admin/users', [AdminController::class, 'index']);
        Route::get('/admin/user/{id}', [TodoController::class, 'show']);
        Route::put('/admin/store', [AdminController::class, 'store']);
        Route::post('/admin/update/{id}', [AdminController::class, 'update']);
        Route::delete('/admin/delete/{id}', [AdminController::class, 'delete']);
        Route::post('/admin/create/{id}', [TodoController::class, 'createTodo']);
    });
});

