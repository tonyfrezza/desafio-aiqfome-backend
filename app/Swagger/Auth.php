<?php

namespace App\Swagger;

use OpenApi\Annotations as OA;

/**
 * @OA\Post(
 *     path="/login",
 *     summary="Fazer login na API",
 *     tags={"Autenticação"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"email","password"},
 *             @OA\Property(property="email", type="string", example="admin@email.com"),
 *             @OA\Property(property="password", type="string", example="senha123")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Login bem-sucedido",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="token", type="string", example="xyz123abc...")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Credenciais inválidas",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Credenciais inválidas")
 *         )
 *     ),
 *     @OA\Response(
 *         response=429,
 *         description="Muitas tentativas de login",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Muitas tentativas de login. Tente novamente mais tarde.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Erro de validação",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="O campo email é obrigatório."),
 *             @OA\Property(property="errors", type="object", example={"email": {"O campo email é obrigatório."}})
 *         )
 *     )
 * )
 */
class Auth {}
