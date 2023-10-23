<?php

use App\Http\Controllers\Api\CardController;
use App\Http\Controllers\Api\DeskController;
use App\Http\Controllers\Api\ListDeskController;
use App\Http\Controllers\Api\TaskController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/desks', [DeskController::class, 'index']);
Route::post('/desks', [DeskController::class, 'store']);
Route::get('/desks/{desk}', [DeskController::class, 'show']);
Route::patch('/desks/{desk}', [DeskController::class, 'update']);
Route::delete('/desks/{desk}', [DeskController::class, 'delete']);

Route::get('/list_desks', [ListDeskController::class, 'index']);
Route::post('/list_desks', [ListDeskController::class, 'store']);
Route::patch('/list_desks/{list_Desk}', [ListDeskController::class, 'update']);
Route::delete('/list_desks/{list_Desk}', [ListDeskController::class, 'delete']);

Route::get('/cards/{card}', [CardController::class, 'show']);
Route::post('/cards', [CardController::class, 'store']);
Route::patch('/cards/{card}', [CardController::class, 'update']);
Route::delete('/cards/{card}', [CardController::class, 'delete']);

Route::post('/tasks', [TaskController::class, 'store']);
Route::patch('/tasks/{task}', [TaskController::class, 'update']);
Route::delete('/tasks/{task}', [TaskController::class, 'delete']);
