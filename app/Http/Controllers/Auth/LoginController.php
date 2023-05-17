<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function proccessingLoginRequest(Request $request)
    {

        $safe = $request->validate([
            'username' => ['required', 'string', 'exists:users,username'],
            'password' => ['required'],
            'remember' => ['nullable', 'in:on']
        ]);

        if (Auth::attempt([
            'username' => $safe['username'],
            'password' => $safe['password']
        ], $safe['remember'] ?? false)) {
            $request->session()->regenerate(true);
            $request->session()->regenerateToken();
            return redirect()->route('home');
        } else {
            return back()->withErrors([
                'error' => "These info doesn't match any of our records"
            ]);
        }
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
