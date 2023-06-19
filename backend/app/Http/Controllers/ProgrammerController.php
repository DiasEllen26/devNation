<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Programadores;
use Illuminate\Support\Facades\Validator;

class ProgrammerController extends Controller 
{
    //função principal
    public function index() {
        return Programadores::all();
    }

    //recebe requisição post para criar registro no banco
    public function store(Request $request) 
    {
        $body = $request->all();

        $validator = Validator::make($request->all(), [
            'nivel' => 'required|exists:niveis,id',
            'nome' => 'required|string|max:255',
            'sexo' => 'required|string|max:255',
            'datanascimento' => 'required|date',
            'idade' => 'required|integer',
            'hobby' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json(['error' => $errors], 400);
        }

        $register = Programadores::create($body);

        if (!$register) {
            return response()->json(['message' => 'Erro ao registrar programador'], 400);
        }

        return response()->json(['message' => 'Sucesso ao cadastrar desenvolvedor'], 201);
    }

    //retorna um registro do banco de dados que for igual a um id
    public function show($id) {
        return Programadores::findOffail($id);
    }
}
