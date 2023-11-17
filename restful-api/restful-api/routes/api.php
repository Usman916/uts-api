<?php

use Illuminate\Support\Facades\Route;

//posts
Route::apiResource('/posts', App\Http\Controllers\Api\PostController::class);
Route::apiResource('/employeest', App\Http\Controllers\Api\EmployeesController::class);