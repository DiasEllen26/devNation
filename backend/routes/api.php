<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProgrammerController;
use App\Http\Controllers\LevelController;


//rota principal programadores
Route::get('/programadores', [ProgrammerController::class, 'index']);

//Enviar para o banco de dados
Route::post('/programador', [ProgrammerController::class, 'store']);

//Trás informações do banco de dados
Route::get('/programadores/{id}', [ProgrammerController::class], 'show');

//rota principal niveis
Route::get('/niveis', [LevelController::class, 'index']);

//Enviar para o banco de dados
Route::post('/nivel', [LevelController::class, 'store']);

//Trás informações do banco de dados
Route::get('/niveis/{id}', [LevelController::class], 'show');

