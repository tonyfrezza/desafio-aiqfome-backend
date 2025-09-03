<?php

namespace App\Swagger;

use OpenApi\Annotations as OA;

define('API_HOST', env('APP_URL') . '/api');

/**
 * @OA\OpenApi(
 *   @OA\Info(
 *     title="API do Sistema",
 *     version="1.0.0",
 *     description="Documentação da API com Laravel + Swagger"
 *   ),
 *   @OA\Server(
 *     url=API_HOST,
 *     description="Servidor local"
 *   ),
 *   @OA\Components(
 *     @OA\SecurityScheme(
 *         securityScheme="sanctum",
 *         type="http",
 *         scheme="bearer",
 *         bearerFormat="JWT"
 *     )
 *   )
 * )
 */
class OpenApi {}
