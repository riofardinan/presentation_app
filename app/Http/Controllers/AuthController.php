<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login')->with('title', 'Login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $response = Http::post('https://jwt-auth-eight-neon.vercel.app/login', [
            'email' => $request->email,
            'password' => $request->password
        ]);
        
        $data = $response->json();
        
        if ($response->failed()) {
            // dd($data);
            return back()->withErrors(['msg' => 'Something went wrong'])->withInput();
        }

        if ($response->successful() && isset($data['refreshToken'])) {
            // Simpan token dan email di session
            session([
                'refreshToken' => $data['refreshToken'],
                'user_email' => $request->email,
            ]);
            
            return redirect()->route('tutorials.index');
        }

    }

    public function logout()
    {
        if (session()->has('refreshToken')) {
            // $refreshToken = session('refreshToken');

            // $response = Http::get('https://jwt-auth-eight-neon.vercel.app/logout', [
            //     'refreshToken' => $refreshToken
            // ]);

            session()->forget('refreshToken');
            
        }

        return redirect()->route('login')->with('success', 'Logout berhasil!');
    }
}
