<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            // 'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'password' => ['required', 'confirmed', 'string'],
            'user_foto' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            ],
            [
                'user_foto.image' => 'File harus jpg/jpeg/png',
                'user_foto.mimes' => 'File harus jpg/jpeg/png',
                'user_foto.max' => 'Ukuran file harus < 2MB'
        ]);

        if ($request->hasFile('user_foto')) {
            $image = $request->file('user_foto');
            // get the extension
            $extension = $image->getClientOriginalExtension();
            // create a new file name
            $new_name = $request->name.'_'.time().'.'.$extension;
            // move file to public/images/new and use $new_name
            $image->move(public_path('images'), $new_name);
    
            $user = User::create([
                'name_user' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role ?? 'user', // Default role is user
                'user_jenis_kelamin' => $request->jk,
                'user_foto' => $new_name,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
            ]);
        }

        

        event(new Registered($user));

        Auth::login($user);

        // return redirect(RouteServiceProvider::HOME);
        // Periksa peran pengguna setelah login
        $role = Auth::user()->role;

        // Redirect ke rute yang sesuai berdasarkan peran pengguna
        if ($role === 'admin') {
            return redirect()->intended('/admin-dashboard'); // Redirect ke dashboard admin jika peran adalah admin
        } else {
            // return redirect()->intended('/home'); // Redirect ke halaman index jika peran adalah user
            return redirect('/home'); 
        }
    }
}
