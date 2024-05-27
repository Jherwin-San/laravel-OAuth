<?php

use App\Http\Controllers\TasksController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckSeeUsersPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers', 'middleware' => ['auth:api']], function () {
    Route::apiResource('tasks', TasksController::class);
    Route::apiResource('users', UserController::class);
    Route::get('/users', [UserController::class, 'index'])->middleware([CheckSeeUsersPermission::class]);
    Route::post('/tasks/create', [TasksController::class, 'store']);
});
