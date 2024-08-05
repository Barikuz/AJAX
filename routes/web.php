<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('my.home');
});

Route::get('/taskGet',[TaskController::class,"get"]);

Route::delete('taskDelete/{id}',[TaskController::class,"delete"]);

Route::get('/categoryGet',[CategoryController::class,"get"]);

Route::post("taskPost",[TaskController::class,"send"]);

Route::post("taskUpdate",[TaskController::class,"update"]);

Route::delete("taskDelete",[TaskController::class,"delete"]);

Route::post("categoryPost",[CategoryController::class,"send"]);

Route::post("categoryUpdate",[CategoryController::class,"update"]);

Route::delete("categoryDelete",[CategoryController::class,"delete"]);



