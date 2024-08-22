<?php

namespace App\Http\Controllers;

use App\Models\Daily;
use App\Models\TypeOfRoom;
use Illuminate\Http\Request;
use App\Repositories\DailyRepository;

class DailyController extends Controller
{
    
    public function __construct(Daily $daily)
    {
        $this->daily = $daily;
    }

    /**
     * @OA\Get(
     *     path="/api/v1/dailies",
     *     summary="Listar os preços da diárias",
     *     tags={"Diária"},
     *     @OA\Parameter(
     *         name="Authorization",
     *         in="header",
     *         required=true,
     *         description="Token JWT gerado durante a autenticação. Deve ser enviado no formato: Bearer {token}",
     *         @OA\Schema(
     *             type="string",
     *             example="Bearer jwt_token_aqui"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Exibe uma lista paginada dos preços da diárias, com a possibilidade de carregar atributos relacionados e aplicar filtros."
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Token ausente ou inválido",
     *         @OA\JsonContent(
     *             @OA\Property(property="erro", type="string", example="Token inválido ou ausente.")
     *         )
     *     ),
     *      @OA\Response(
     *         response=422,
     *         description="Missing Data"
     *     ),
     *      security={
     *         {"bearerAuth": {}}
     *     }
     * )
     */
    public function index(Request $request)
    {
        $dailyRepository = new DailyRepository( $this->daily );

        if($request->has('atributos_typeOfRoom')) {
            $atributos_daily = 'type_of_rooms:id,'.$request->$atributos_daily;
            $dailyRepository->selectAtributosRegistrosRelacionados($atributos_daily);
        } else {
            $dailyRepository->selectAtributosRegistrosRelacionados('typeOfRoom');
        }

        if($request->has('filtro')) {
            $dailyRepository->filtro($request->filtro);
        }

        return response()->json($dailyRepository->getResultadoPaginado(5), 200); 
    }


        /**
     * @OA\Post(
     *     path="/api/v1/dailies",
     *     summary="Criar preço da diária",
     *     tags={"Diária"},
     *     @OA\Parameter(
     *         name="Authorization",
     *         in="header",
     *         required=true,
     *         description="Token JWT gerado durante a autenticação. Deve ser enviado no formato: Bearer {token}",
     *         @OA\Schema(
     *             type="string",
     *             example="Bearer jwt_token_aqui"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Dados para criação de um preço da diária",
     *         @OA\JsonContent(
     *             required={"price", "type_of_room_id"},
     *             @OA\Property(
     *                 property="price", 
     *                 type="number", 
     *                 description="O preço da diária",
     *                 example="55.25"
     *             ),
     *             @OA\Property(
     *                 property="type_of_room_id", 
     *                 type="number", 
     *                 description="Id do tipo do quarto",
     *                 example="15"
     *             )
     *         ),
     *         @OA\Link(
    *             link="GetTypeRoomById",
    *             operationId="getTypeRoomById",
    *             parameters={
    *                 "id": "$response.body#/id"
    *             },
    *             description="Link para visualizar o preço da diária recém-criado"
    *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Tipos de quarto criado com sucesso."
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Token ausente ou inválido",
     *         @OA\JsonContent(
     *             @OA\Property(property="erro", type="string", example="Token inválido ou ausente.")
     *         )
     *     ),
     *      @OA\Response(
     *         response=422,
     *         description="Missing Data"
     *      ),
     *      @OA\Response(
     *         response=500,
     *         description="Ocorreu um erro ao tentar recuperar os tipos de quarto.",
     *         @OA\JsonContent(
     *             @OA\Property(property="erro", type="string", example="Ocorreu um erro ao tentar recuperar os tipos de quarto..")
     *         )
     *      ),
     *      security={
     *         {"bearerAuth": {}}
     *     }
     * )
     */
    public function store(Request $request)
    {
        
        // Valida os dados da requisição com as regras e feedbacks definidos no modelo Daily
        try {
            $validatedData = $request->validate($this->daily->rules(), $this->daily->feedback());

            // Cria um novo registro de diária com os dados validados
            $daily = $this->daily->create([
                'price' => $validatedData['price'],
                'type_of_room_id' => $validatedData['type_of_room_id']
            ]);

            // Retorna uma resposta de sucesso com os dados da diária criada
            return response()->json([
                'success' => 'Diária cadastrada com sucesso!'], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Retorna uma resposta de erro com os detalhes da validação
            return response()->json([
                'error' => 'Erro na validação dos dados',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            // Retorna uma resposta de erro genérica para qualquer outra exceção
            return response()->json([
                'error' => 'Erro ao cadastrar a diária',
                'errors' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/v1/dailies/{id}",
     *     summary="Obter o preço da diária pelo ID",
     *     tags={"Diária"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do preço da diária ser recuperado",
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="Authorization",
     *         in="header",
     *         required=true,
     *         description="Token JWT gerado durante a autenticação. Deve ser enviado no formato: Bearer {token}",
     *         @OA\Schema(
     *             type="string",
     *             example="Bearer jwt_token_aqui"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Retorna o preço da diária especificado, incluindo os relacionamentos com quartos.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="id",
     *                 type="integer",
     *                 example=1
     *             ),
     *             @OA\Property(
     *                 property="price", 
     *                 type="number", 
     *                 example="55.25"
     *             ),
     *             @OA\Property(
     *                 property="type_of_room_id", 
     *                 type="integer", 
     *                 example="15"
     *             ),
     *             @OA\Property(property="rooms", type="array", @OA\Items(type="object")),
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Preço da diária não encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Recurso pesquisado não existe!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Token ausente ou inválido",
     *         @OA\JsonContent(
     *             @OA\Property(property="erro", type="string", example="Token inválido ou ausente.")
     *         )
     *     ),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     */
    public function show($id)
    {
        
        $daily = $this->daily->with('rooms')->find($id);
        if($daily === null) {
            return response()->json(['error' => 'Recurso pesquisado não existe!'], 404);
        }
        return response()->json($daily, 200);
    }
    
    /**
     * @OA\Put(
     *     path="/api/v1/dailies/{id}",
     *     summary="Atualizar o preço da diária",
     *     tags={"Diária"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do preço da diária a ser atualizado",
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="Authorization",
     *         in="header",
     *         required=true,
     *         description="Token JWT gerado durante a autenticação. Deve ser enviado no formato: Bearer {token}",
     *         @OA\Schema(
     *             type="string",
     *             example="Bearer jwt_token_aqui"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"price", "type_of_room_id"},
     *             @OA\Property(
     *                 property="price", 
     *                 type="number", 
     *                 description="O preço da diária",
     *                 example="55.25"
     *             ),
     *             @OA\Property(
     *                 property="type_of_room_id", 
     *                 type="number", 
     *                 description="Id do tipo do quarto",
     *                 example="15"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Preço da diária atualizado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="string", example="Preço da diária atualizado com sucesso!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Preço da diária não encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Preço da diária não encontrado.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro ao atualizar o preço da diária",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Erro ao atualizar o preço da diária."),
     *             @OA\Property(property="message", type="string", example="Detalhes do erro...")
     *         )
     *     ),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     */
    public function update(Request $request, $id)
    {
       
       // Encontra o registro pelo ID
        $daily = $this->daily->find($id);

        // Verifica se o registro foi encontrado
        if ($daily === null) {
            return response()->json(['error' => 'Preço de diária não encontrado.'], 404);
        }

        // Valida o request, passando o ID para a função de regras
        $request->validate($this->daily->rules($id), $this->daily->feedback());

        // Tenta atualizar o registro
        $daily->fill($request->all());

        if ($daily->save()) {
            // Se for bem-sucedido, retorna uma mensagem de sucesso
            return response()->json(['success' => 'Preço da diária atualizado com sucesso!'], 200);
        } else {
            // Se houver falha, retorna uma mensagem de erro
            return response()->json(['error' => 'Falha ao atualizar a diária. Por favor, tente novamente.'], 500);
        }
    }
    
    /**
     * @OA\Delete(
     *     path="/api/v1/dailies/{id}",
     *     summary="Excluir o preço da diária",
     *     tags={"Diária"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do preço da diária ser excluído",
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="Authorization",
     *         in="header",
     *         required=true,
     *         description="Token JWT gerado durante a autenticação. Deve ser enviado no formato: Bearer {token}",
     *         @OA\Schema(
     *             type="string",
     *             example="Bearer jwt_token_aqui"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Preço da diáriaremovido com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="string", example="O registro foi removido com sucesso!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro ao remover o preço da diária devido a relacionamentos existentes",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Impossível excluir. Existem relacionamentos associados a este preço da diária.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Preço da diária não encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Impossível realizar a exclusão. O recurso não foi encontrado.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro ao remover o preço da diária",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Falha ao remover o preço da diária. Por favor, tente novamente."),
     *             @OA\Property(property="message", type="string", example="Detalhes do erro...")
     *         )
     *     ),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     */
    public function destroy($id)
    {
        
        //Encontra o pre;co de uma diária por id
        $daily = $this->daily->find($id);

        //Verifica se o preço da diária foi encontrada
        if ($daily === null) {
            return response()->json(['error' => 'Preço de diária não encontada.'], 404);
        }

        // Verifica se o preço da diária tem relacionamentos
        $relationsMessages = $daily->getRelations();
    
        if (!empty($relationsMessages)) {
            return response()->json(['error' => 'Impossível excluir. ' . implode(' ', $relationsMessages)], 400);
        }
    
        try {
            // Tenta excluir o registro
            $daily->delete();
    
            // Redireciona com uma mensagem de sucesso
            return response()->json(['success' => 'Diária removida com sucesso!'], 200);
        } catch (\Exception $e) {
            // Captura e trata exceções possíveis
            return responset()->json(['error' => 'Falha ao remover a diária. Por favor, tente novamente.'], 500);
        }
    }
    
}
