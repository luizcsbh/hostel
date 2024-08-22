<?php

namespace App\Http\Controllers;

use App\Models\TypeOfRoom;
use Illuminate\Http\Request;
use App\Repositories\TypeOfRoomRepository;

/**
 * Classe responsável por gerenciar os tipos de quartos.
 * 
 * @package App\Http\Controllers
 */
class TypeOfRoomController extends Controller
{
   /**
     * Construtor do controlador de Tipo de Quartos.
     *
     * Este construtor recebe uma instância do modelo TypeOfRoom, que será usada para
     * realizar operações relacionadas aos tipos de quartos no banco de dados.
     * 
     * @param \App\Models\TypeOfRoom $typeOfRoom Instância do modelo TypeOfRoom.
     */
    public function __construct(TypeOfRoom $typeOfRoom )
    {
        $this->typeOfRoom = $typeOfRoom;
    }
    
    /**
     * @OA\Get(
     *     path="/api/v1/type-rooms",
     *     summary="Listar Tipos de Quarto",
     *     tags={"Tipo de Quarto"},
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
     *         description="Exibe uma lista paginada de Tipos de Quarto, com a possibilidade de carregar atributos relacionados e aplicar filtros."
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
        
        $typeOfRoomRepository = new TypeOfRoomRepository( $this->typeOfRoom );

        if($request->has('atributos_dailies')) {
            $atributos_dailies = 'dailies:id,'.$request->$atributos_dailies;
            $typeOfRoomRepository->selectAtributosRegistrosRelacionados($atributos_dailies);
        } else {
            $typeOfRoomRepository->selectAtributosRegistrosRelacionados('dailies');
        }

        if($request->has('filtro')) {
            $typeOfRoomRepository->filtro($request->filtro);
        }

        return response()->json($typeOfRoomRepository->getResultadoPaginado(5), 200); 
    }

    /**
     * @OA\Get(
     *     path="/api/v1/all-type-rooms",
     *     summary="Listar toods os tipos de quarto sem paginação",
     *     tags={"Tipo de Quarto"},
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
     *         description="Exibe uma lista com todos os tipos de quarto sem paginação."
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Token ausente ou inválido",
     *         @OA\JsonContent(
     *             @OA\Property(property="erro", type="string", example="Token inválido ou ausente.")
     *         )
     *     ),
     *      @OA\Response(
     *         response=404,
     *         description="Nenhum tipo de quarto encontrado.",
     *         @OA\JsonContent(
     *             @OA\Property(property="erro", type="string", example="Nenhum tipo de quarto encontrado.")
     *         )
     *      ),
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
    public function allTypeRooms()
    {
        try {
            // Tenta recuperar todos os tipos de quartos
            $typeOfRooms = $this->typeOfRoom->all();

            // Verifica se a lista está vazia
            if ($typeOfRooms->isEmpty()) {
                return response()->json(['error' => 'Nenhum tipo de quarto encontrado.'], 404);
            }

            // Retorna a lista de tipos de quartos com sucesso
            return response()->json($typeOfRooms, 200);
            
        } catch (\Exception $e) {
            // Captura qualquer exceção que ocorrer e retorna uma resposta de erro
            return response()->json(['error' => 'Ocorreu um erro ao tentar recuperar os tipos de quarto.'], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/v1/type-rooms",
     *     summary="Criar um tipo de quarto",
     *     tags={"Tipo de Quarto"},
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
     *         description="Dados para criação de um tipo de quarto",
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(
     *                 property="name", 
     *                 type="string", 
     *                 description="O nome do tipo de quarto",
     *                 example="Standarth"
     *             )
     *         ),
     *         @OA\Link(
    *             link="GetTypeRoomById",
    *             operationId="getTypeRoomById",
    *             parameters={
    *                 "id": "$response.body#/id"
    *             },
    *             description="Link para visualizar o Tipo de Quarto recém-criado"
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
        try {
            // Valida os dados recebidos conforme as regras definidas
            $request->validate($this->typeOfRoom->rules(), $this->typeOfRoom->feedback());

            // Cria um novo tipo de quarto
            $typeOfRoom = $this->typeOfRoom->create([
                'name' => $request->name,
            ]);

            // Retorna uma resposta de sucesso com o tipo de quarto criado
            return response()->json($typeOfRoom, 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Captura erros de validação e retorna uma resposta adequada
            return response()->json(['error' => 'Erro de validação'], 422);

        } catch (\Exception $e) {
            // Captura qualquer outra exceção e retorna uma resposta de erro
            return response()->json(['error' => 'Ocorreu um erro ao tentar criar o tipo de quarto.'], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/v1/type-rooms/{id}",
     *     summary="Obter um Tipo de Quarto pelo ID",
     *     tags={"Tipo de Quarto"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do Tipo de Quarto a ser recuperado",
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
     *         description="Retorna o Tipo de Quarto especificado, incluindo os relacionamentos com quartos e diárias.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Quarto Deluxe"),
     *             @OA\Property(property="rooms", type="array", @OA\Items(type="object")),
     *             @OA\Property(property="dailies", type="array", @OA\Items(type="object"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tipo de Quarto não encontrado",
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
        $typeOfRoom = $this->typeOfRoom->with('rooms','dailies')->find($id);
        if($typeOfRoom === null) {
            return response()->json(['error' => 'Recurso pesquisado não existe!'], 404);
        }
        return response()->json($typeOfRoom, 200);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/type-rooms/{id}",
     *     summary="Atualizar Tipo de Quarto",
     *     tags={"Tipo de Quarto"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do Tipo de Quarto a ser atualizado",
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
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="Quarto Deluxe"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tipo de Quarto atualizado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="string", example="Tipo de Quarto atualizado com sucesso!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tipo de Quarto não encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Tipo de Quarto não encontrado.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro ao atualizar o Tipo de Quarto",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Erro ao atualizar o Tipo de Quarto."),
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
        
        // Encontra o Tipo de Quarto pelo ID
        $typeOfRoom = $this->typeOfRoom->find($id);

        // Verifica se o Tipo de Quarto foi encontrado
        if ($typeOfRoom === null) {
            return response()->json(['error' => 'Tipo de Quarto não encontrado.'], 404);
        }

        if($request->method() === 'PATCH') {
            $regrasDinamicas = array();
            foreach($typeOfRoom->rules() as $input => $regra) {
                if(array_key_exists($input, $request->all())) {
                    $regrasDinamicas[$input] = $regra;
                }
            }
            $request->validate($regrasDinamicas, $typeOfRoom->feedback());
        
        } else{
            $request->validate($typeOfRoom->rules(), $typeOfRoom->feedback());
        }

        // Tenta atualizar o registro
        $typeOfRoom->fill($request->all());
        
        if ($typeOfRoom->save()) {
            // Se for bem-sucedido, redireciona com uma mensagem de sucesso
            return response()->json(['success' => 'Tipo de Quarto atualizado com sucesso!'], 200);
        } else {
            // Se houver falha, redireciona de volta com uma mensagem de erro
            return response()->json(['error' => 'Falha ao atualizar o Tipo de Quarto. Por favor, tente novamente.'], 404);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/type-rooms/{id}",
     *     summary="Excluir Tipo de Quarto",
     *     tags={"Tipo de Quarto"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do Tipo de Quarto a ser excluído",
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
     *         description="Tipo de Quarto removido com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="string", example="O registro foi removido com sucesso!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro ao remover o Tipo de Quarto devido a relacionamentos existentes",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Impossível excluir. Existem relacionamentos associados a este Tipo de Quarto.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tipo de Quarto não encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Impossível realizar a exclusão. O recurso não foi encontrado.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro ao remover o Tipo de Quarto",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Falha ao remover o Tipo de Quarto. Por favor, tente novamente."),
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
        // Busca o Tipo de Quarto pelo ID
        $typeOfRoom = $this->typeOfRoom->find($id);
    
        // Verifica se o registro foi encontrado
        if ($typeOfRoom === null) {
            return response()->json(['error' => 'Impossível realizar a exclusão. O recurso não foi encontrado.'], 404);
        }
       
        // Verifica se o Tipo de Quarto tem relacionamentos
        $relationsMessages = $typeOfRoom->getRelations();
    
        if (!empty($relationsMessages)) {
            return response()->json(['error' => 'Impossível excluir. ' . implode(' ', $relationsMessages)], 400);
        }
       
        try {
            // Tenta excluir o registro
            $typeOfRoom->delete();
            return response()->json(['success' => 'O registro foi removido com sucesso!'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Falha ao remover o Tipo de Quarto. Por favor, tente novamente.'], 500);
        }
    }    
}
