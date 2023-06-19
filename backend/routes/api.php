<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProgrammerController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//rota principal
Route::get('/programadores', [ProgrammerController::class, 'index']);
//Enviar para o banco de dados
Route::post('/programador', [ProgrammerController::class, 'store']);
//Trás informações do banco de dados
Route::get('/programadores/{id}', [ProgrammerController::class], 'show');
