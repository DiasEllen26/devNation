<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Programadores;

class ProgrammerController extends Controller 
{
    //função principal
    public function index() {
        return Programadores::all();
    }

    //recebe requisição post para criar registro no banco
    public function store(Request $request) {
        $body = $request->all();

        $request->validate([
            'nivel' => 'required',
            'nome' => 'required',
            'sexo' => 'required',
            'datanascimento' => 'required',
            'idade' => 'required',
            'hobby' => 'required',
        ]);

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
