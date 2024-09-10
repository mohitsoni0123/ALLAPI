<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::POST('/loginServe', [App\Http\Controllers\ServicesController::class, 'index'])->name('login');
Route::POST('/Register', [App\Http\Controllers\ServicesController::class, 'Register'])->name('Register');
Route::get('/Example', [App\Http\Controllers\ServicesController::class, 'Example'])->name('Example');
Route::PATCH('/deleteUser', [App\Http\Controllers\ServicesController::class,'deleteUser'])->name('deleteUser');
Route::PUT('/updateUserPassword', [App\Http\Controllers\ServicesController::class,'updateUserPassword'])->name('updateUserPassword');
Route::get('/GetUserListing', [App\Http\Controllers\ServicesController::class, 'GetUserListing'])->name('GetUserListing');
Route::get('/Get_Distance', [App\Http\Controllers\ServicesController::class, 'Get_Distance'])->name('Get_Distance');

Route::POST('/changeStatus', [App\Http\Controllers\ServicesController::class, 'changeStatus'])->name('changeStatus');

