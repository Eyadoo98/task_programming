<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodoListController;

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
Route::controller(AuthController::class)->group(function () {
    Route::post('register','register');
    Route::post('login','login');
    Route::post('logout','logout')->middleware('auth:sanctum');
});
Route::controller(TodoListController::class)->middleware('auth:sanctum')->group(function () {
    Route::get('getAllTodolist','getAll');
    Route::get('getMyTodolist','getMyTodolist');
    Route::get('searchList/{search}','searchList');
    Route::delete('deleteMyTodolist/{list}','deleteMyTodolist');
    Route::post('addTolist','addTolist');
    Route::post('UpdateTolist/{id}','UpdateTolist');
});

Route::get('/',function (){
    return 'Hello World';
});

