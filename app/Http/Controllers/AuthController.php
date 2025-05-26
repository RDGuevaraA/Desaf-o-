<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\ControllerMiddlewareOptions as Middleware;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.home');
            } else {
                return redirect()->route('tutor.home');
            }
        }

        return back()->withErrors([
            'email' => 'Las credenciales ingresadas son incorrectas.',
        ]);
    }

    #[Middleware('auth')]
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}