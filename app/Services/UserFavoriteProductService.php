<?php

namespace App\Services;

use App\Models\User;
use Facades\App\Models\UserFavoriteProduct;
use App\Services\Api\ProductApiService;
use Illuminate\Support\Facades\DB;

class UserFavoriteProductService
{
    public function isProductFavorite(User $user, int $productId)
    {
        return DB::table(UserFavoriteProduct::getTable())
            ->where('users_id', $user->id)
            ->whereRaw("products @> ?", "[{$productId}]")
            ->exists();
    }

    public function getUserFavoritesProductsDetails(User $user)
    {
        $productApiService = new ProductApiService();

        $favoriteProductsDetails = [];
        foreach ($user->favoritesProducts->products as $productId) {
            $productDetails = $productApiService->getProductDetails($productId);
            if ($productDetails->status) {
                $favoriteProductsDetails[] = [
                    'id'    =>  $productDetails->data->id,
                    'title' =>  $productDetails->data->title,
                    'image' =>  $productDetails->data->image,
                    'price' =>  $productDetails->data->price,
                    'rating'    =>  $productDetails->data->rating ?? null,
                ];
            } else {
                return (object)[
                    'status'    =>  false,
                    'message'   =>  "Erro ao obter detalhes do produto de ID {$productId}.",
                ];
            }
        }
        return (object)[
            'status'    =>  true,
            'products'  =>  $favoriteProductsDetails,
        ];
    }
}
