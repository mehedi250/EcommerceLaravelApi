<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'bail|required|max:191',
            'email' => 'bail|required|email|max:191|unique:users',
            'password' => 'bail|required|confirmed|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'status' => 'validation-error'
            ]);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        $token = $user->createToken('ecommarceToken')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Registered successfully',
            'username' => $user->name,
            'token' => $token
        ]);


    }
}
