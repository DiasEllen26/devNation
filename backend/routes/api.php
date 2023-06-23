<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProgrammerController;
use App\Http\Controllers\LevelController;
use OpenApi\Annotations as OA;

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

/**
 * @OA\Info(
 *     title="API de Exemplo",
 *     version="1.0.0",
 *     description="Descrição da API de Exemplo"
 * )
 */


Route::group(['middleware' => 'api'], function () {
    /**
     * Lista programadores
     */
    Route::get('/programadores', [ProgrammerController::class, 'index']);

    /**
     * Cria um novo programador
     */
    Route::post('/programador', [ProgrammerController::class, 'store']);

    /**
     * Lista programador especifico
     */
    Route::get('/programadores/{id}', [ProgrammerController::class, 'show']);

    /**
     * Atualiza programador
     */
    Route::put('/programadores/{id}', [ProgrammerController::class, 'update']);

    /**
     * Deleta programador
     */
    Route::delete('/programadores/{id}', [ProgrammerController::class, 'destroy']);

    /**
     * Lista niveis
     */
    Route::get('/niveis', [LevelController::class, 'index']);

    /**
     * Cria novo nivel
     */
    Route::post('/nivel', [LevelController::class, 'store']);

    /**
     * Lista nivel especifico
     */
    Route::get('/niveis/{id}', [LevelController::class, 'show']);

    /**
     * Atualiza nível
     */
    Route::put('/niveis/{id}', [LevelController::class, 'update']);

    /**
     * Deleta nivel
     */
    Route::delete('/niveis/{id}', [LevelController::class, 'destroy']);
});
