<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebController;

Route::get('/', [WebController::class, 'home']);
Route::get('/tours', [WebController::class, 'tours']);
Route::get('/tours/create', [WebController::class, 'createTour']);
Route::get('/tours/{id}', [WebController::class, 'showTour']);
Route::get('/tours/{id}/edit', [WebController::class, 'editTour']);
Route::post('/tours', [WebController::class, 'storeTour']);
Route::put('/tours/{id}', [WebController::class, 'updateTour']);
Route::delete('/tours/{id}', [WebController::class, 'deleteTour']);
Route::get('/categories', [WebController::class, 'categories']);
