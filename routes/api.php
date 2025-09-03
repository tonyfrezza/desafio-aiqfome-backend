<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'as'            =>  'api.',
], function () {
    Route::group([
        'as'            =>  'login.',
    ], function () {
        Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login'])->name('login');
    });


    Route::group([
        'as'            =>  'system.',
        'middleware'    =>  ['auth:sanctum']
    ], function () {

        Route::group([
            'as'            =>  'admin.',
            'middleware'    =>  ['can:manage-users']
        ], function () {
            Route::group([
                'as'            =>  'users.',
            ], function () {
                Route::get('/users/{userId}', [\App\Http\Controllers\Api\Users\UsersController::class, 'show'])
                    ->where('userId', '[0-9]+')
                    ->name('show');

                Route::post('/users', [\App\Http\Controllers\Api\Users\UsersController::class, 'create'])->name('create');

                Route::put('/users/{userId}', [\App\Http\Controllers\Api\Users\UsersController::class, 'update'])
                    ->where('userId', '[0-9]+')
                    ->name('update');

                Route::delete('/users/{userId}', [\App\Http\Controllers\Api\Users\UsersController::class, 'destroy'])
                    ->where('userId', '[0-9]+')
                    ->name('destroy');
            });
        });

        Route::group([
            'as'            =>  'client.',
            'middleware'    =>  ['auth:sanctum', 'can:add-favorites-products']
        ], function () {

            Route::get('/users/favorites-products/{productId}', [\App\Http\Controllers\Api\Users\UsersFavoritesProductsController::class, 'show'])
                ->where('productId', '[0-9]+')
                ->name('show');

            Route::post('/users/favorites-products', [\App\Http\Controllers\Api\Users\UsersFavoritesProductsController::class, 'create'])->name('create');

            Route::delete('/users/favorites-products/{productId}', [\App\Http\Controllers\Api\Users\UsersFavoritesProductsController::class, 'destroy'])
                ->where('productId', '[0-9]+')
                ->name('destroy');
        });
    });
});
