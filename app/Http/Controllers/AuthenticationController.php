<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthenticationController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // biasanya sih pake Auth kyk gini sih
        // if (!Auth::attempt($request->only('email', 'password'))) {
        //     return response()
        //         ->json(['message' => 'Unauthorized'], 401);
        // }

        $token = $user->createToken('token')->plainTextToken;

        return ['token' => $token,];
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        // ini temennya kalo pake auth, aku gk tau pake yg auth() atau Auth::
        // kyknya sama aja, mari kita coba di CommentOwner
        // auth()->user()->tokens()->delete();
    }

    public function me(Request $request)
    {
        return response()->json(Auth::user());
    }
}
