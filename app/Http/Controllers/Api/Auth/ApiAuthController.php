<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ApiLoginRequest;
use App\Http\Requests\ApiRegisterRequest;
use Laravel\Sanctum\PersonalAccessToken;

class ApiAuthController extends Controller
{
    use ApiResponser;

    public function register(ApiRegisterRequest $request)
    {
        $payload = $request->all();
        
        $payload['password'] = Hash::make($payload['password']);
      
        $newUser = User::create($payload);
        $token = $newUser->createToken($payload['token_name'] ?? 'default_token');

        return $this->successResponse([
            'user' => $newUser,
            'token' => $token->plainTextToken,
        ], 'User created!', 201);

    }

    public function login(ApiLoginRequest $request)
    {
        $payload = $request->all();

        if (!Auth::attempt($payload)) {
            return $this->errorResponse('The provided credentials are incorrect.', 401);
        }

        $user = auth()->user();

        $token = getNewToken($request);

        return $this->successResponse([
            'user' => $user,
            'token' => $token,
        ], 'User logged in!');
    }

    public function logout(Request $request, PersonalAccessToken $personalAccessToken)
    {
        $requestToken = $request->bearerToken();
        $token = $personalAccessToken->findToken($requestToken);

        if (!$token) {
            return $this->errorResponse('Invalid token or the provided credentials are incorrect.', 401);
        }

        $token->delete();

        return $this->successResponse([], 'Tokens Revoked');
    }

    public function currentUser()
    {
        return $this->successResponse(auth()->user());
    }
}
