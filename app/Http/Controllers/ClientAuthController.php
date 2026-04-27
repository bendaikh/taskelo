<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ClientAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('client.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('client')->attempt($request->only('email', 'password'), $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('client.dashboard'));
        }

        throw ValidationException::withMessages([
            'email' => __('These credentials do not match our records.'),
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('client')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('client.login');
    }
}
