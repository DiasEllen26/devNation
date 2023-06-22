<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Programadores;
use App\Models\Niveis;
use OpenApi\Annotations as OA;


class LevelController extends Controller 
{ 
    //Retorna uma lista de todos os niveis
    public function index(Request $request) {
        $search = $request->query('search');
        $query = Niveis::query();
    
        // Adicione a cláusula de busca, se o parâmetro de busca estiver presente
        if ($search) {
            $query->where('nivel', 'like', '%' . $search . '%');
        }
    
        $niveis = $query->paginate(10);
        return response()->json($niveis);
    }

    //recebe requisição post para criar registro no banco
    public function store(Request $request) {
        $body = $request->all();
        $validator = Validator::make($body, ['nivel' => 'required|string|max:255']);
        
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

    public function update(Request $request, $id){
        $request->validate(['nivel' => 'required|string',]);
        $nivel = Niveis::findOrFail($id);
        $nivel->update($request->only('nivel'));
    
        return response()->json($nivel);
    }
   
    // Remove um nível, impedindo a exclusão se houver desenvolvedores associados
    public function destroy($id){
        try {
            // Encontra o nível pelo ID ou lança uma exceção caso não seja encontrado
            $nivel = Nivel::findOrFail($id);
            
            // Deleta o nível
            $nivel->delete();
        } catch (QueryException $e) {
            // Verifica se a exceção é de violação de chave estrangeira
            if ($e->getCode() === '23000') {
                // e retorna uma resposta informando que a exclusão não é possível devido à associação de desenvolvedores
                return response()->json(['message' => 'Não é possível excluir o nível. Existem desenvolvedores associados a ele.'], 400);
            }
            
            // Caso ocorra outra exceção, como um erro no banco de dados, retorna uma resposta com status 500 (Internal Server Error)
            return response()->json(['message' => 'Erro ao excluir o nível'], 500);
        }

        // Retorna uma resposta com indicando que a exclusão foi bem sucedida
        return response()->json(null, 204);
    }
}