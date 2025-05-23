<?php

use App\Http\Controllers\Api\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('posts')->name('posts.')->group(function(){
    Route::get('/',[PostController::class,'index'])->name('index');
    Route::get('/{post}',[PostController::class,'show'])->name('show');
    Route::post('/',[PostController::class,'store'])->name('store');
    Route::put('/{post}',[PostController::class,'update'])->name('update');
    Route::delete('/{post}',[PostController::class,'destroy'])->name('destroy');
 });
