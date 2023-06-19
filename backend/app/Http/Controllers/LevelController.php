<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Niveis;

class LevelController extends Controller 
{
    //função principal
    public function index() {
        return Niveis::all();
    }

    //recebe requisição post para criar registro no banco
    public function store(Request $request) {
        $body = $request->all();

        $validator = Validator::make($request->all(), [
            'nivel' => 'required|string|max:255'
        ]);
        
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json(['error' => $errors], 400);
        }

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
