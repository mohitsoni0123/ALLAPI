<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/logIn', [App\Http\Controllers\LogInAndregisterController::class,'index'])->name('logIn');
Route::POST('/logInPost', [App\Http\Controllers\LogInAndregisterController::class,'logIn'])->name('logInPost');
Route::POST('/RegisterUser', [App\Http\Controllers\LogInAndregisterController::class,'RegisterUser'])->name('RegisterUser');
Route::POST('/PutPatchDataCurl', [App\Http\Controllers\LogInAndregisterController::class,'PutPatchDataCurl'])->name('PutPatchDataCurl');
// Route::POST('/updatePassword', [App\Http\Controllers\LogInAndregisterController::class,'updatePassword'])->name('updatePassword');




