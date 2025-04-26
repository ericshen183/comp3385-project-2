<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Get a JWT via given credentials.
     *
     * @return JsonResponse
     */
    public function login(): JsonResponse
    {
        $credentials = request(['email', 'password']);

        if ( ! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json([
            'message'      => 'Login Successful!',
            'access_token' => $token,
            'user_id'      => Auth::id(),
        ]);
    }

    public function register(Request $request): JsonResponse
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users',
            'password'  => 'required|string|min:8',
            'location'  => 'string|max:255',
            'biography' => 'nullable|string',
            'photo'     => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        // Handle file upload (if a photo is provided)
        $photoPath = $request->file('photo')->storeAs('photos', $request->file('photo')->getClientOriginalName(),
            'public');

        // Create and save the user
        $user = new User([
            'name'      => $validatedData['name'],
            'email'     => $validatedData['email'],
            'password'  => $validatedData['password'],
            'location'  => $validatedData['location'],
            'biography' => $validatedData['biography'],
            'photo'     => $photoPath,
        ]);
        $user->save();

        return response()->json(['message' => 'User registered successfully', 'user' => $user], 201);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
}



