<?php

namespace App\Swagger;

use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/users/{userId}",
 *     summary="Obter informações de um usuário",
 *     description="⚠️ Requer nível elevado (somente administradores podem acessar).",
 *     tags={"Usuários"},
 *     security={{"sanctum":{}}},
 *     @OA\Parameter(
 *         name="userId",
 *         in="path",
 *         required=true,
 *         description="ID do usuário",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Usuário encontrado",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="name", type="string", example="João da Silva"),
 *             @OA\Property(property="email", type="string", example="joao@email.com"),
 *             @OA\Property(
 *                 property="favorites_products",
 *                 type="array",
 *                 @OA\Items(type="integer", example=10)
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Acesso negado",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="error", type="string", example="Credenciais inválidas")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Usuário não encontrado",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="error", type="string", example="Usuário não encontrado.")
 *         )
 *     )
 * )
 * 
 * @OA\Post(
 *     path="/users",
 *     summary="Criar novo usuário",
 *     description="⚠️ Requer nível elevado (somente administradores podem acessar).",
 *     tags={"Usuários"},
 *     security={{"sanctum":{}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name","email","password","password_confirmation"},
 *             @OA\Property(property="name", type="string", example="Maria Souza"),
 *             @OA\Property(property="email", type="string", example="maria@email.com"),
 *             @OA\Property(property="password", type="string", example="123456"),
 *             @OA\Property(property="password_confirmation", type="string", example="123456")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Usuário criado",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Usuário criado com sucesso."),
 *             @OA\Property(property="id", type="integer", example=1)
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Erro ao criar usuário",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="error", type="string", example="Erro ao criar usuário.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Erro de validação",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="O campo email já está em uso."),
 *             @OA\Property(property="errors", type="object", example={"email": {"O campo email já está em uso."}})
 *         )
 *     )
 * )
 * 
 * @OA\Put(
 *     path="/users/{userId}",
 *     summary="Atualizar informações de um usuário",
 *     description="⚠️ Requer nível elevado (somente administradores podem acessar).",
 *     tags={"Usuários"},
 *     security={{"sanctum":{}}},
 *     @OA\Parameter(
 *         name="userId",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name","email"},
 *             @OA\Property(property="name", type="string", example="Novo Nome"),
 *             @OA\Property(property="email", type="string", example="novo@email.com"),
 *             @OA\Property(property="password", type="string", example="novaSenha123", nullable=true),
 *             @OA\Property(property="password_confirmation", type="string", example="novaSenha123", nullable=true)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Usuário atualizado",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Usuário atualizado com sucesso."),
 *             @OA\Property(property="id", type="integer", example=1)
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Erro ao atualizar usuário",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="error", type="string", example="Erro ao atualizar usuário.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Usuário não encontrado",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="error", type="string", example="Usuário não encontrado.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Erro de validação",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="O campo email já está em uso."),
 *             @OA\Property(property="errors", type="object", example={"email": {"O campo email já está em uso."}})
 *         )
 *     )
 * )
 * 
 * @OA\Delete(
 *     path="/users/{userId}",
 *     summary="Excluir usuário",
 *     description="⚠️ Requer nível elevado (somente administradores podem acessar).",
 *     tags={"Usuários"},
 *     security={{"sanctum":{}}},
 *     @OA\Parameter(
 *         name="userId",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Usuário removido com sucesso",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Usuário excluído com sucesso.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Tipo de usuário não pode ser excluído",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="error", type="string", example="Tipo de usuário não pode ser excluído.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Usuário não encontrado",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="error", type="string", example="Usuário não encontrado.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Erro ao excluir usuário",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="error", type="string", example="Erro ao excluir usuário.")
 *         )
 *     )
 * )
 */
class Users {}
