<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    // display login form
    public function login(): View {

        // echo 'admin : <input value="'. \Illuminate\Support\Facades\Hash::make('guest'). '">';

        return view(
            'auth.login', 
            [
                'title' => 'Log in'
            ]
        );
    }

    // authentificate user
    public function authenticate(Request $request): RedirectResponse {
        $credentials = $request->only('name', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // pāradresācijas url, vēlāk nomainīsim uz /bands
            return redirect('/artists');
        }

        return back()->withErrors([
            'name' => 'Log in failed',
        ]);
    }
    
    // end user session
    public function logout(Request $request): RedirectResponse {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    } 
}