<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\StudentResource;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        $result = $this->authService->register($request->validated());

        $student = new StudentResource($result['student']);
        $token = $result['token'];

        return response()->json([
            'student' => $student,
            'token' => $token,
        ]);
    }

    public function login(LoginRequest $request)
    {
        $token = $this->authService->login($request->validated());

        return response()->json([
            'message' => 'Logged in successfully.',
            'token' => $token
        ]);
    }

    public function logout(Request $request)
    {
        try {
            $request->Student()->tokens()->delete();
            return response()->json(['message' => 'Logged out successfully.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Logout failed.'], 500);
        }
    }
}
