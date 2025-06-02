<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Login do usuário
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        // Verifica se o usuário existe e se a senha está correta
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json(['error' => 'Email ou senha inválidos'], 401);
        }

        // Gera o token
        $token = $user->createToken('YourAppName')->plainTextToken;

        // Retorna token e dados úteis (como role)
        return response()->json([
            'token' => $token,
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ],
        ]);
    }

    /**
     * Cadastro de um novo usuário
     */
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed', // `password_confirmation` deve ser enviado
            'role' => 'in:admin,usuario', // proteção adicional
        ]);

        // Criação do usuário
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role' => $request->input('role', 'usuario'), // default: usuario
        ]);

        // Gera o token
        $token = $user->createToken('YourAppName')->plainTextToken;

        // Retorna dados
        return response()->json([
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ],
            'token' => $token,
        ], 201);
    }
}

