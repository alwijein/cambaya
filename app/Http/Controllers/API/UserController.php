<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(Request $request)
    {
        try {
            $request->validate(
                [
                    'email' => 'required',
                    'password' => 'required'
                ]
            );

            $credentials = request([
                'email',
                'password'
            ]);

            if (!Auth::attempt($credentials)) {
                return ResponseFormatter::error([
                    'massage' => 'Unauthorized'
                ], 'Authentication Failed', 500);
            }

            $user = User::where('email', $request->email)->first();

            if (!Hash::check($request->password, $user->password, [])) {
                throw new \Exception('Invalid Credentials');
            }

            $tokenResult = $user->createToken('authToken')->plainTextToken;

            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'tokenType' => 'Bearer',
                'user' => $user
            ], 'Authenticated');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'massage' => 'Something went wrong',
                'error' => $error,
            ], 'Authentication Failed', 500);
        }
    }

    public function fetch(Request $request)
    {
        return ResponseFormatter::success($request->user(), 'Data user berhasil diambil');
    }



    public function logout(Request $request)
    {
        $token = $request->user()->currentAccessToken()->delete();

        return ResponseFormatter::success($token, 'Token Revoked');
    }

    public function getAll(Request $request)
    {
        $id = $request->input('id');
        $role = $request->input('role');
        $limit = $request->input('limit');

        if ($id) {
            $user = User::find($id)->first();
            if ($user) {
                return ResponseFormatter::success($user, 'Data User Berhasil Diambil');
            } else {
                return ResponseFormatter::error(null, 'Data User Tidak Ada', 404);
            }
        }

        if ($role) {
            $user = User::where('role', $role)->get();
        }

        return ResponseFormatter::success(
            $user,
            'Data berhasil diambil'
        );
    }
}
