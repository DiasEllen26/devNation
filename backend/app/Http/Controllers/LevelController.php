<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\Niveis;

class LevelController extends Controller 
{
    //função principal
    public function index() {
        return Niveis::all();
    }

    //recebe requisição post para criar registro no banco
    public function store(Request $request) {
        $body = $request->all();

        $request->validate([
            'nome' => 'required'
        ]);

        $register = Niveis::create($body);

        if (!$register) {
            return response()->json(['message' => 'Erro ao registrar nível'], 400);
        }
            return response()->json(['message' => 'Sucesso ao cadastrar nível'], 201);
    }

    //retorna um registro do banco de dados que for igual a um id
    public function show($id) {
        return Niveis::findOffail($id);
    }
}
