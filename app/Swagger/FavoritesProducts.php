<?php

namespace App\Swagger;

use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/users/favorites-products/{productId}",
 *     summary="Listar detalhes do produto favorito do usuário",
 *     tags={"Usuários - Produtos Favoritos"},
 *     security={{"sanctum":{}}},
 *     @OA\Parameter(
 *         name="productId",
 *         in="path",
 *         required=true,
 *         description="ID do produto",
 *         @OA\Schema(type="integer", example=15)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Produto favorito encontrado",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="id", type="integer", example=15),
 *             @OA\Property(property="title", type="string", example="Produto Exemplo"),
 *             @OA\Property(property="image", type="string", example="https://example.com/image.jpg"),
 *             @OA\Property(property="price", type="number", format="float", example=29.99),
 *             @OA\Property(
 *                 property="rating",
 *                 type="object",
 *                 @OA\Property(property="rate", type="number", format="float", example=4.5),
 *                 @OA\Property(property="count", type="integer", example=120)
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Produto não está nos favoritos",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="error", type="string", example="Produto não está nos favoritos.")
 *         )
 *     )
 * )
 * 
 * @OA\Post(
 *     path="/users/favorites-products",
 *     summary="Adicionar produto aos favoritos do usuário",
 *     tags={"Usuários - Produtos Favoritos"},
 *     security={{"sanctum":{}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"product_id"},
 *             @OA\Property(property="product_id", type="integer", example=10)
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Produto adicionado aos favoritos",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Produto adicionado aos favoritos com sucesso.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=409,
 *         description="Produto já está nos favoritos",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="error", type="string", example="Produto já está nos favoritos.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Produto não encontrado",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="error", type="string", example="Produto não encontrado na base de dados externa.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Erro ao adicionar produto aos favoritos",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="error", type="string", example="Erro ao adicionar produto aos favoritos.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Erro de validação",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="O campo product_id é obrigatório."),
 *             @OA\Property(property="errors", type="object", example={"product_id": {"O campo product_id é obrigatório."}})
 *         )
 *     )
 * )
 * 
 * @OA\Delete(
 *     path="/users/favorites-products/{productId}",
 *     summary="Remover produto dos favoritos do usuário",
 *     tags={"Usuários - Produtos Favoritos"},
 *     security={{"sanctum":{}}},
 *     @OA\Parameter(
 *         name="productId",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer", example=10)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Produto removido com sucesso",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Produto removido dos favoritos com sucesso.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Produto não está nos favoritos",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="error", type="string", example="Produto não está nos favoritos.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Erro ao remover produto dos favoritos",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="error", type="string", example="Erro ao remover produto dos favoritos.")
 *         )
 *     )
 * )
 */
class FavoritesProducts {}
