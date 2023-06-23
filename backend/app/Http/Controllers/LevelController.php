<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Programadores;
use App\Models\Niveis;
use Illuminate\Database\QueryException;

/**
 * @OA\Schema(
 *     schema="Nivel",
 *     required={"id", "nivel"},
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="nivel", type="string")
 * )
 *
 * @OA\Schema(
 *     schema="NivelInput",
 *     required={"nivel"},
 *     @OA\Property(property="nivel", type="string")
 * )
 */


class LevelController extends Controller
{

    /**
     *
     * @OA\Get(
     *     path="/api/niveis",
     *     summary="Obter todos os níveis",
     *     tags={"Níveis"},
     *     @OA\Response(
     *         response=200,
     *         description="Retorna a lista de níveis",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Nivel")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Não autorizado"),
     *     security={{"bearerAuth":{}}}
     * )
     */
    //Retorna uma lista de todos os niveis
    public function index(Request $request)
    {
        $search = $request->query('search');

        $query = Niveis::query();

        // Adicione a cláusula de busca, se o parâmetro de busca estiver presente
        if ($search) {
            $query->where('nivel', 'like', '%' . $search . '%');
        }

        $niveis = $query->paginate(10);

        return response()->json($niveis);
    }

    /**
     *
     * @OA\Post(
     *     path="/api/niveis",
     *     summary="Criar um novo nível",
     *     tags={"Níveis"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Dados do nível",
     *         @OA\JsonContent(ref="#/components/schemas/NivelInput")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Nível criado com sucesso"
     *     ),
     *     @OA\Response(response=400, description="Requisição inválida")
     * )
     */
    //recebe requisição post para criar registro no banco
    public function store(Request $request)
    {
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

    /**
     *
     * @OA\Get(
     *     path="/api/niveis/{id}",
     *     summary="Obter um nível pelo ID",
     *     tags={"Níveis"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do nível",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Retorna o nível encontrado",
     *         @OA\JsonContent(ref="#/components/schemas/Nivel")
     *     ),
     *     @OA\Response(response=404, description="Nível não encontrado")
     * )
     */
    //retorna um registro do banco de dados que for igual a um id
    public function show($id)
    {

        $nivel = Niveis::find($id);

        if (!$nivel) {
            return response()->json(['message' => 'Nível não encontrado'], 404);
        }

        return Niveis::findOrfail($id);
    }


    /**
     *
     * @OA\Put(
     *     path="/api/niveis/{id}",
     *     summary="Editar um nível",
     *     tags={"Níveis"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do nível",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Dados atualizados do nível",
     *         @OA\JsonContent(ref="#/components/schemas/NivelInput")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Nível atualizado com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Nivel")
     *     ),
     *     @OA\Response(response=404, description="Nível não encontrado"),
     *     @OA\Response(response=400, description="Requisição inválida")
     * )
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nivel' => 'required|string',
        ]);

        $nivel = Niveis::findOrFail($id);

        $nivel->update($request->only('nivel'));

        return response()->json($nivel);
    }

    /**
     *
     * @OA\Delete(
     *     path="/api/niveis/{id}",
     *     summary="Excluir um nível",
     *     tags={"Níveis"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do nível",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Nível removido com sucesso"),
     *     @OA\Response(response=400, description="Não é possível excluir o nível. Existem desenvolvedores associados a ele."),
     *     @OA\Response(response=500, description="Erro ao excluir o nível")
     * )
     */

    // Remove um nível, impedindo a exclusão se houver desenvolvedores associados
    public function destroy($id)
    {
        try {
            // Encontra o nível pelo ID ou lança uma exceção caso não seja encontrado
            $nivel = Niveis::findOrFail($id);

            // Deleta o nível
            $nivel->delete();
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                // Verifica se a exceção é de violação de chave estrangeira
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
