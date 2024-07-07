<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    public function login(Request $request): JsonResponse{
        //Validar o e-mail e a senha
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){

            // Recuperar os dados do usuário
            $user = Auth::user();

            $token = $request->user()->createToken('api-token')->plainTextToken;

            return response()->json([
                'status' => true,
                'token' => $token,
                'user' => $user,
            ], 201);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Login ou senha incorreta',
            ], 404);
        }
    }

    public function logout(User $user): JsonResponse{
        try{
            $user->tokens()->delete();

            return response()->json([
                'status' => true,
                'message' => 'Usuário deslogado com sucesso',
            ], 200);

        }catch(Exception $e){
            return response()->json([
                'status' => false,
                'message' => 'Não deslogado',
            ], 400);
        }
    }
}
