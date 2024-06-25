<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\FlashData;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function actionLogin(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required|string',
                'password' => 'required|string'
            ]);
            $credentials = $request->only('username', 'password');

            $token = Auth::attempt($credentials);
            if (!$token) {
                FlashData::danger_alert('User tidak ditemukan');
                return redirect()->back();
            }

            Auth::user();
            return redirect()->route('dashboard');
        } catch (\Throwable $th) {
            FlashData::danger_alert($th->getMessage());
            return redirect()->back();
        }
    }

    public function createUserSuperAdmin()
    {
        // try {
        $input['name'] = 'Developer';
        $input['username'] = 'dev';
        $input['password'] = bcrypt('123123');
        $user = User::create($input);

        return response()->json($user, 201);
        // } catch (\Throwable $th) {
        //     return response()->json(['message' => $th->getMessage(), 'status' => 'error'], 501);
        // }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
