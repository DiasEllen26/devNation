<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Programadores;
use App\Models\Nives;
use Illuminate\Support\Facades\Validator;

class ProgrammerController extends Controller 
{
   // Retorna uma lista de todos os programadores.
    public function index() 
    {
        $programadores = Programadores::with('niveis')->get();

        return response()->json($programadores);
    }

    // Cria um novo registro de programador.
    public function store(Request $request) 
    {
        $body = $request->all();

        // Validação dos campos
        $validator = Validator::make($body, [
            'nivel_id' => 'required|exists:niveis,id',
            'nome' => 'required|string|max:255',
            'sexo' => 'required|string|max:255',
            'datanascimento' => 'required|date',
            'idade' => 'required|integer',
            'hobby' => 'required|string|max:255',
        ]);

        // Verifica se houve falhas na validação
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json(['error' => $errors], 400);
        }

        // Cria o registro do programador
        $programador = Programadores::create($body);

        // Verifica se o registro foi criado com sucesso
        if (!$programador) {
            return response()->json(['message' => 'Erro ao registrar programador'], 400);
        }

        // Retorna a resposta de sucesso
        return response()->json(['message' => 'Sucesso ao cadastrar desenvolvedor'], 201);
    }

    //Retorna um registro do banco de dados com base no ID.
    public function show($id) 
    {
        // Busca o programador com o relacionamento "nivel"
        $programador = Programadores::with('nivel')->find($id);
        
        // Verifica se o programador foi encontrado
        if (!$programador) {
            return response()->json(['message' => 'Programador não encontrado'], 404);
        }

        // Retorna o programador encontrado
        return response()->json($programador);
    }

    /**
     * Edita um programador específico pelo ID.
     */
    public function update(Request $request, $id)
    {
        // Encontra o programador pelo ID
        $programador = Programador::find($id);

        // Verifica se o programador foi encontrado
        if (!$programador) { 
            return response()->json(['message' => 'Programador não encontrado'], 404);
        }

        // Valida os dados recebidos
        $validator = Validator::make($request->all(), [
            'nivel_id' => 'exists:niveis,id',
            'nome' => 'string|max:255',
            'sexo' => 'string|max:255',
            'datanascimento' => 'date',
            'idade' => 'integer',
            'hobby' => 'string|max:255',
        ]);

        // Verifica se houve erros na validação
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Atualiza os dados do programador
        $programador->fill($request->all());
        $programador->save();

        // Retorna a resposta de sucesso com o programador atualizado
        return response()->json(['message' => 'Programador atualizado com sucesso', 'programador' => $programador]);
    }

    //Deleta um programador específico
    public function destroy($id)
    {
        // Encontra o programador pelo ID
        $programador = Programadores::find($id);

        // Verifica se o programador foi encontrado
        if (!$programador) {
            return response()->json(['message' => 'Programador não encontrado'], 404);
        }

        // Deleta o programador
        $programador->delete();

        // Retorna a mensagem de sucesso
        return response()->json(['message' => 'Programador removido com sucesso'], 204);
    }
}
