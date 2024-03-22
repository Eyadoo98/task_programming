<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Route::get('/', function () {
//
//    $user = \App\Models\User::query()->findOrFail(10);
//    $user->notify(new \App\Notifications\TestPusherNotification($user->id , 'someone comment on your post'));
//
////    dd('notification sent');
//});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('AdminPage',[AdminController::class ,'admin'])->middleware('admin','auth:sanctum')->name('admin');