<?php declare(strict_types=1);

namespace App\Features\Auth\Controllers;

use App\Features\User\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class UserAuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $userRegisterData = $request->only(['name', 'email', 'password']);

        $validator = Validator::make($userRegisterData, [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error(
                'Validation failed',
                $validator->errors()->toArray(),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $user = User::create([
            'name' => $userRegisterData['name'],
            'email' => $userRegisterData['email'],
            'password' => Hash::make($userRegisterData['password']),
        ]);

        return ApiResponse::success(
            'User registered successfully!',
            [
                'user' => $user,
                'access_token' => $this->createUserToken($user),
            ],
            Response::HTTP_CREATED
        );
    }

    public function login(Request $request): JsonResponse
    {
        $userLoginData = $request->only(['email', 'password']);

        $validator = Validator::make($userLoginData, [
            'email' => 'required|string|email',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error(
                'Validation failed',
                $validator->errors()->toArray(),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $user = User::where('email', $userLoginData['email'])->first();

        if (!$user || !Hash::check($userLoginData['password'], $user->password)) {
            return ApiResponse::error(
                'Invalid credentials',
                null,
                Response::HTTP_UNAUTHORIZED
            );
        }

        $token = $this->createUserToken($user);

        return ApiResponse::success(
            'User logged in successfully!',
            [
                'user' => $user,
                'access_token' => $token,
            ]
        );
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();

        return ApiResponse::success(
            'User logged out successfully!',
            null
        );
    }

    private function createUserToken(User $user): string
    {
        return $user->createToken($user->name)->plainTextToken;
    }
}
