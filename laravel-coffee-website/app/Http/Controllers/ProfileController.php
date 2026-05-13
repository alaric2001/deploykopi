<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();
        // $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function editemailnama(Request $request)
    {
        $user = User::findOrFail(Auth::id());
        // dd($user);
        // Update name_user and email
        $user->name_user = $request->input('namauser');
        $user->email = $request->input('email');

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }
        $user->save();
        return redirect()->back();
    }

    public function edit_pp(Request $request)
    {
        $request->validate([
            'foto_pp' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ],
        [
            'foto_pp.image' => 'Format file harus jpg/jpeg/png',
            'foto_pp.mimes' => 'Format file harus jpg/jpeg/png',
            'foto_pp.max' => 'Ukuran file harus < 2MB'
        ]);

        $image = $request->file('foto_pp');
        // get the extension
        $extension = $image->getClientOriginalExtension();
        // create a new file name
        $new_name = 'pp_'.time().'.'.$extension;
        // move file to public/images and use $new_name
        $image->move(public_path('images'), $new_name);

        $pp = User::findOrFail(Auth::id());
        $pp->user_foto = $new_name;
        $pp->save();
        return redirect()->back();
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
