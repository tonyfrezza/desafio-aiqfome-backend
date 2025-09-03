<?php

namespace App\Services\Api;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ProductApiService
{
    private $baseUrl;

    public function __construct()
    {
        $this->baseUrl = 'https://fakestoreapi.com/products';
    }

    public function getProductDetails(int $productId)
    {
        try {
            $response = Http::timeout(5)->get("{$this->baseUrl}/{$productId}");
            if ($response->successful()) {
                $productData = $response->object();
            }
            return (object)[
                'status'    =>  !empty($response->body()),
                'data' => (object)[
                    'id'    =>  $productData->id,
                    'title' =>  $productData->title,
                    'image' =>  $productData->image,
                    'price' =>  $productData->price,
                    'rating'    =>  $productData->rating ?? null,
                ],
            ];
        } catch (\Exception $e) {
            Log::error('Erro ao buscar produto na API', [
                'url' => "{$this->baseUrl}/{$productId}",
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ]);
            return (object)[
                'status'    =>  false,
                'data' => ['message' => 'Erro ao conectar na API de produtos.'],
            ];
        }
    }
}
