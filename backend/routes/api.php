<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProgrammerController;

//rota principal programadores
Route::get('/programadores', [ProgrammerController::class, 'index']);

//Enviar para o banco de dados
Route::post('/programador', [ProgrammerController::class, 'store']);

//Trás informações do banco de dados
Route::get('/programadores/{id}', [ProgrammerController::class], 'show');

//rota principal niveis
Route::get('/niveis', [ProgrammerController::class, 'index']);

//Enviar para o banco de dados
Route::post('/nivel', [ProgrammerController::class, 'store']);

//Trás informações do banco de dados
Route::get('/niveis/{id}', [ProgrammerController::class], 'show');

