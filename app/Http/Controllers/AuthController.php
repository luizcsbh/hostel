<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Realiza a autenticação do usuário",
     *     description="Autentica um usuário com base em suas credenciais de email e senha e retorna um token JWT.",
     *     tags={"Autenticação"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Dados de login necessários para autenticação",
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(
     *                 property="email", 
     *                 type="string", 
     *                 description="O email registrado do usuário",
     *                 example="luizcsdev@gmail.com"
     *             ),
     *             @OA\Property(
     *                 property="password", 
     *                 type="string", 
     *                 description="A senha correspondente ao email do usuário",
     *                 example="luiz1979"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuário autenticado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string", description="JWT gerado após a autenticação", example="jwt_token_aqui")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Usuário ou senha inválido",
     *         @OA\JsonContent(
     *             @OA\Property(property="erro", type="string", description="Mensagem de erro indicando que as credenciais são inválidas", example="Usuário ou senha inválido!")
     *         )
     *     )
     * )
     */
    public function login(Request $request) {
        
        $credenciais = $request->all(['email', 'password']); //[]

        //autenticaзгo (email e senha)
        $token = auth('api')->attempt($credenciais);
        
        if($token) { //usuбrio autenticado com sucesso
            return response()->json(['token' => $token]);

        } else { //erro de usuбrio ou senha
            return response()->json(['erro' => 'Usuбrio ou senha invбlido!'], 403);

            //401 = Unauthorized -> nгo autorizado
            //403 = forbidden -> proibido (login invбlido)
        }

        //retornar um Json Web Token
        return 'login';
    }

    public function logout() {
        auth('api')->logout();
        return response()->json(['msg' => 'Logout foi realizado com sucesso!']);
    }

    /**
     * Refresh the JWT Token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        $token = auth('api')->refresh(); //cliente encaminhe um jwt vбlido
        return response()->json(['token' => $token]);
    }

    public function me() {
        return response()->json(auth()->user());
    }
}
