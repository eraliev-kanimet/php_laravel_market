<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email:rfc|unique:users,email',
            'name' => 'required|string|min:2',
            'password' => 'required|min:6|confirmed'
        ]);

        $user = User::create([
            'email' => $request->input('email'),
            'name' => $request->input('name'),
            'password' => Hash::make($request->input('password'))
        ]);

        $token = $user->createToken('Kanimet')->accessToken;
        return response()->json(['token' => $token], 201);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email:rfc',
            'password' => 'required|min:6'
        ]);

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
