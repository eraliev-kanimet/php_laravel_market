<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::create([
            'email' => $request->input('email'),
            'name' => $request->input('name'),
            'password' => Hash::make($request->input('password'))
        ]);
        $token = $user->createToken('Kanimet')->accessToken;
        return response()->json(['token' => $token], 201);
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $data = [
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ];
        if (Auth::attempt($data)) {
            $token = auth()->user()->createToken('authKanimetToken')->accessToken;
            $response = ['token' => $token];
            if (auth()->user()->roles->contains(1)) {
                $response['admin'] = 'kanimet_key';
            }
            return response()->json($response, 201);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }
}
