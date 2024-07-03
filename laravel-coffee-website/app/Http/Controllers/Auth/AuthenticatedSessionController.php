<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // return redirect()->intended(RouteServiceProvider::HOME);
        // Periksa peran pengguna setelah login
        $role = Auth::user()->role;

        // Redirect ke rute yang sesuai berdasarkan peran pengguna
        if ($role === 'user') {
            // return redirect('/'); // Redirect ke dashboard admin jika peran adalah admin
            // return redirect()->intended('/');
            return redirect()->back();
        } else if($role === 'admin'){
            return redirect('/admin-dashboard');
        }else{
            return redirect()->back();
        }
        // else {
        //     return redirect()->intended('/index'); // Redirect ke halaman index jika peran adalah user
        // }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
