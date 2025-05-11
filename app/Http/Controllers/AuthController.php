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
        try {
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
                session()->put('error', $data['msg'] ?? 'Something went wrong');
                return redirect()->route('login')->withInput();
            }

            if ($response->successful() && isset($data['refreshToken'])) {
                session([
                    'refreshToken' => $data['refreshToken'],
                    'user_email' => $request->email,
                ]);
                
                return redirect()->route('tutorials.index');
            }

            session()->put('error', 'Invalid response from server');
            return redirect()->route('login')->withInput();
            
        } catch (\Exception $e) {
            session()->put('error', 'An unexpected error occurred');
            return redirect()->route('login')->withInput();
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
