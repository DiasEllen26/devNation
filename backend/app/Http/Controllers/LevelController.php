<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Programadores;
use App\Models\Niveis;

class LevelController extends Controller 
{
    //lista todos 
    public function index() {
        $niveis = Niveis::paginate(10);

        return response()->json($niveis);
    }

    //recebe requisição post para criar registro no banco
    public function store(Request $request) {
        $body = $request->all();

        $validator = Validator::make($body, [
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

        $nivel = $Niveis::find($id);
        
        if (!$nivel) {
            return response()->json(['message' => 'Nível não encontrado'], 404);
        }

        return Niveis::findOffail($id);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nivel' => 'required|string',
        ]);
    
        $nivel = Niveis::findOrFail($id);
    
        $nivel->update($request->only('nivel'));
    
        return response()->json($nivel);
    }
    
    public function destroy($id)
    {
        $nivel = Niveis::find($id);
    
        if (!$nivel) {
            return response()->json(['message' => 'Nível não encontrado'], 404);
        }
    
        $nivel->delete();
    
        return response()->json(null, 204); 
    }
    
}
