<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Api\User\CreateUserRequest;
use App\Http\Requests\Api\User\UpdateUserRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UsersController extends Controller
{
    public function show($userId)
    {
        $user = User::find($userId);
        if (empty($user)) {
            return response()->json(['error' => 'Usuário não encontrado.'], Response::HTTP_NOT_FOUND);
        }
        return new UserResource($user);
    }

    public function create(CreateUserRequest $request)
    {
        try {
            $user = DB::transaction(function () use ($request) {
                $user = User::create([
                    'name'     => $request->name,
                    'email'    => mb_strtolower(trim($request->email)),
                    'password' => $request->password,
                ]);

                $user->favoritesProducts()->firstOrCreate([]);
                $user->assignRole('client');

                return $user;
            });
            $status = true;
        } catch (\Throwable $e) {
            Log::error('Erro ao criar usuário', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ]);
            $status = false;
        }

        if (!$status) {
            return response()->json(['error' => 'Erro ao criar usuário.'], Response::HTTP_BAD_REQUEST);
        }
        return (new UserResource($user))
            ->additional(['message' => 'Usuário criado com sucesso.'])
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function update(UpdateUserRequest $request)
    {
        $user = User::find($request->userId);
        if (empty($user)) {
            return response()->json(['error' => 'Usuário não encontrado.'], Response::HTTP_NOT_FOUND);
        }

        $updateData = [
            'name'  =>  $request->name,
            'email' =>  mb_strtolower(trim($request->email)),
        ];
        if (!empty($request->password)) {
            $updateData['password'] = $request->password;
        }

        try {
            DB::transaction(function () use ($user, $updateData) {
                $user->update($updateData);
            });
            $status = true;
        } catch (\Throwable $e) {
            Log::error('Erro ao atualizar usuário', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ]);
            $status = false;
        }

        if (!$status) {
            return response()->json(['error' => 'Erro ao atualizar usuário.'], Response::HTTP_BAD_REQUEST);
        }
        return (new UserResource($user))
            ->additional(['message' => 'Usuário atualizado com sucesso.'])
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    public function destroy($userId)
    {
        $user = User::find($userId);
        if (empty($user)) {
            return response()->json(['error' => 'Usuário não encontrado.'], Response::HTTP_NOT_FOUND);
        }
        if (!!$user->is_master) {
            return response()->json(['error' => 'Tipo de usuário não pode ser excluído.'], Response::HTTP_FORBIDDEN);
        }

        try {
            DB::transaction(function () use ($user) {
                $user->delete();
            });
            $status = true;
        } catch (\Throwable $e) {
            Log::error('Erro ao excluir usuário', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ]);
            $status = false;
        }

        if (!$status) {
            return response()->json(['error' => 'Erro ao excluir usuário.'], Response::HTTP_BAD_REQUEST);
        }
        return response()->json(['message' => 'Usuário excluído com sucesso.'], Response::HTTP_OK);
    }
}
