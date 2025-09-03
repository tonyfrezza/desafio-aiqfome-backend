<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Api\User\FavoriteProductUserRequest;
use App\Http\Resources\Product\ProductDetailResource;
use App\Services\Api\ProductApiService;
use App\Services\UserFavoriteProductService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UsersFavoritesProductsController extends Controller
{
    public function show($productId)
    {
        $user = auth()->user();
        $userFavoriteProductService = new UserFavoriteProductService();
        if (!$userFavoriteProductService->isProductFavorite($user, $productId)) {
            return response()->json(['error' => 'Produto não está nos favoritos.'], Response::HTTP_NOT_FOUND);
        }

        $productApiService = new ProductApiService();
        $responseApiProductDetails = $productApiService->getProductDetails($productId);

        if (!$responseApiProductDetails->status) {
            return response()->json([
                'error' =>  $responseApiProductDetails->message ?? 'Produto não encontrado na base de dados externa.',
            ], Response::HTTP_NOT_FOUND);
        }
        return (new ProductDetailResource($responseApiProductDetails));
    }

    public function create(FavoriteProductUserRequest $request)
    {
        $productApiService = new ProductApiService();
        $responseApiCheckIfProductExists = $productApiService->getProductDetails($request->product_id);

        if (!$responseApiCheckIfProductExists->status) {
            return response()->json([
                'error' =>  $responseApiCheckIfProductExists->message ?? 'Produto não encontrado na base de dados externa.',
            ], Response::HTTP_NOT_FOUND);
        }

        $user = auth()->user();
        $userFavoriteProductService = new UserFavoriteProductService();
        if ($userFavoriteProductService->isProductFavorite($user, $request->product_id)) {
            return response()->json(['error' => 'Produto já está nos favoritos.'], Response::HTTP_CONFLICT);
        }

        $userFavoritesProducts = $user->favoritesProducts()->lockForUpdate()->first();

        try {
            $userFavoritesProducts->products = array_merge($userFavoritesProducts->products, [(int)$request->product_id]);

            DB::transaction(function () use ($userFavoritesProducts) {
                $userFavoritesProducts->save();
            });

            $status = true;
        } catch (\Throwable $e) {
            Log::error('Erro ao adicionar produto aos favoritos', [
                'message'   =>   $e->getMessage(),
                'product_id'    =>  $request->product_id,
                'user_id'   =>  $user->id,
                'line'  =>  $e->getLine(),
                'file'  =>  $e->getFile(),
            ]);
            $status = false;
        }

        if (!$status) {
            return response()->json(['error' => 'Erro ao adicionar produto aos favoritos.'], Response::HTTP_BAD_REQUEST);
        }
        return response()->json(['message' => 'Produto adicionado aos favoritos com sucesso.',], Response::HTTP_CREATED);
    }

    public function destroy($productId)
    {
        $user = auth()->user();
        $userFavoriteProductService = new UserFavoriteProductService();

        if (!$userFavoriteProductService->isProductFavorite($user, $productId)) {
            return response()->json(['message' => 'Produto não está nos favoritos.'], Response::HTTP_NOT_FOUND);
        }

        $userFavoritesProducts = $user->favoritesProducts()->lockForUpdate()->first();

        try {
            $userFavoritesProducts->products = array_values(array_filter($userFavoritesProducts->products, function ($favoriteProductId) use ($productId) {
                return $favoriteProductId != $productId;
            }));
            DB::transaction(function () use ($userFavoritesProducts) {
                $userFavoritesProducts->save();
            });
            $status = true;
        } catch (\Throwable $e) {
            Log::error('Erro ao remover produto dos favoritos', [
                'message'   =>  $e->getMessage(),
                'product_id'    =>  $productId,
                'user_id'   =>  $user->id,
                'line'  =>  $e->getLine(),
                'file'  =>  $e->getFile(),
            ]);
            $status = false;
        }

        if (!$status) {
            return response()->json(['error' => 'Erro ao remover produto dos favoritos.'], Response::HTTP_BAD_REQUEST);
        }
        return response()->json(['message' => 'Produto removido dos favoritos com sucesso.'], Response::HTTP_OK);
    }
}
