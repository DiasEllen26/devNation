<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProgrammerController;
use App\Http\Controllers\LevelController;


//Lista programadores
Route::get('/programadores', [ProgrammerController::class, 'index']);

//Cria um novo programador
Route::post('/programador', [ProgrammerController::class, 'store']);

//Lista programador especifico
Route::get('/programadores/{id}', [ProgrammerController::class], 'show');

//Atualiza programador
Route::put('/programadores/{id}', [ProgrammerController::class, 'update']);

//Deleta programador
Route::delete('/programadores/{id}', [ProgrammerController::class, 'destroy']);

Route::get('/api/documentacao/', function () { return view('swagger'); });

//Lista niveis
Route::get('/niveis', [LevelController::class, 'index']);

//Cria novo nivel
Route::post('/nivel', [LevelController::class, 'store']);

//Lista nivel especifico
Route::get('/niveis/{id}', [LevelController::class], 'show');

//Atualiza nível
Route::put('/niveis/{id}', [LevelController::class, 'update']);

//Deleta nivel
Route::delete('/niveis/{id}', [LevelController::class, 'destroy']);
