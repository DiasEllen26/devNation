<?php

namespace App\Http\Controllers;

use OpenApi\Annotations as OA;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Programadores;


/**
 * @OA\Schema(
 *     schema="Programador",
 *     required={"nivel", "nome", "sexo", "datanascimento", "idade", "hobby"},
 *     @OA\Property(property="nivel", type="string", example="Junior"),
 *     @OA\Property(property="nome", type="string", example="João"),
 *     @OA\Property(property="sexo", type="string", example="M"),
 *     @OA\Property(property="datanascimento", type="string", format="date", example="2000-01-01"),
 *     @OA\Property(property="idade", type="integer", example=21),
 *     @OA\Property(property="hobby", type="string", example="Programação"),
 * )
 * @OA\Schema(
 *     schema="ProgramadorInput",
 *     required={"nivel", "nome", "sexo", "datanascimento", "idade", "hobby"},
 *     @OA\Property(property="nivel", type="string"),
 *     @OA\Property(property="nome", type="string"),
 *     @OA\Property(property="sexo", type="string"),
 *     @OA\Property(property="datanascimento", type="string", format="date"),
 *     @OA\Property(property="idade", type="integer"),
 *     @OA\Property(property="hobby", type="string"),
 * )
 */

class ProgrammerController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/programadores",
     *     summary="Obter todos os programadores",
     *     tags={"Programadores"},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Parâmetro de busca para filtrar os programadores por nome, sexo ou hobby",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Retorna a lista de programadores",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Programador")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Não autorizado"),
     *     security={{"bearerAuth":{}}}
     * )
     */

    // Retorna uma lista de todos os programadores
    public function index(Request $request)
    {

        // Obtenha o valor do parâmetro de busca da query string
        $search = $request->query('search');

        // Construa a consulta inicial com os relacionamentos
        $query = Programadores::with('niveis');

        // Verifique se o parâmetro de busca está presente
        if ($search) {
            // Adicione a cláusula de busca na consulta
            $query->where(function ($q) use ($search) {
                $q->where('nome', 'like', '%' . $search . '%')
                    ->orWhere('sexo', 'like', '%' . $search . '%')
                    ->orWhere('hobby', 'like', '%' . $search . '%');
            });
        }

        // Execute a consulta e obtenha os resultados
        $programadores = $query->get();

        // Retorne os resultados em formato JSON
        return response()->json($programadores);
    }

    /**
     * @OA\Post(
     *     path="/api/programador",
     *     summary="Criar um novo programador",
     *     tags={"Programadores"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ProgramadorInput")
     *     ),
     *     @OA\Response(response=201, description="Programador criado com sucesso"),
     *     @OA\Response(response=400, description="Erro de validação"),
     *     security={{"bearerAuth":{}}}
     * )
     */

    // Cria um novo registro de programador
    public function store(Request $request)
    {
        $body = $request->all();

        // Validação dos campos
        $validator = Validator::make($body, [
            'nivel' => 'required|exists:niveis,id',
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
        $programadores = Programadores::create($body);

        // Verifica se o registro foi criado com sucesso
        if (!$programadores) {
            return response()->json(['message' => 'Erro ao registrar programador'], 400);
        }

        // Retorna a resposta de sucesso
        return response()->json(['message' => 'Sucesso ao cadastrar desenvolvedor'], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/programadores/{id}",
     *     summary="Obter um programador específico",
     *     tags={"Programadores"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do programador",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Retorna o programador encontrado",
     *         @OA\JsonContent(ref="#/components/schemas/Programador")
     *     ),
     *     @OA\Response(response=401, description="Não autorizado"),
     *     @OA\Response(response=404, description="Programador não encontrado"),
     *     security={{"bearerAuth":{}}}
     * )
     */

    //Retorna um registro do banco de dados com base no ID
    public function show($id)
    {
        // Busca o programador com o relacionamento "nivel"
        $programadores = Programadores::with('niveis')->find($id);

        // Verifica se o programador foi encontrado
        if (!$programadores) {
            return response()->json(['message' => 'Programador não encontrado'], 404);
        }

        // Retorna o programador encontrado
        return response()->json($programadores);
    }

    /**
     * @OA\Patch(
     *     path="/api/programadores/{id}",
     *     summary="Atualizar um programador específico",
     *     tags={"Programadores"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do programador",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ProgramadorInput")
     *     ),
     *     @OA\Response(response=200, description="Programador atualizado com sucesso"),
     *     @OA\Response(response=400, description="Erro de validação"),
     *     @OA\Response(response=401, description="Não autorizado"),
     *     @OA\Response(response=404, description="Programador não encontrado"),
     *     security={{"bearerAuth":{}}}
     * )
     */

    // Edita um programador específico pelo ID.
    public function update(Request $request, $id)
    {
        // Encontra o programador pelo ID
        $programadores = Programadores::find($id);

        // Verifica se o programador foi encontrado
        if (!$programadores) {
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
        $programadores->fill($request->all());
        $programadores->save();

        // Retorna a resposta de sucesso com o programador atualizado
        return response()->json(['message' => 'Programador atualizado com sucesso', 'programador' => $programadores]);
    }

    /**
     * @OA\Delete(
     *     path="/api/programadores/{id}",
     *     summary="Excluir um programador específico",
     *     tags={"Programadores"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do programador",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Programador removido com sucesso"),
     *     @OA\Response(response=401, description="Não autorizado"),
     *     @OA\Response(response=404, description="Programador não encontrado"),
     *     security={{"bearerAuth":{}}}
     * )
     */

    //Deleta um programador específico
    public function destroy($id)
    {
        // Encontra o programador pelo ID
        $programadores = Programadores::find($id);

        // Verifica se o programador foi encontrado
        if (!$programadores) {
            return response()->json(['message' => 'Programador não encontrado'], 404);
        }

        // Deleta o programador
        $programadores->delete();

        // Retorna a mensagem de sucesso
        return response()->json(['message' => 'Programador removido com sucesso'], 204);
    }
}
