<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $data_user = User::all();
        return view('admin.user_seteguk.index', compact('data_user'));
    }

    public function update(Request $request, $id)
    {
        $edit_user = User::findOrFail($id);
        $edit_user->role = $request->role;
        $edit_user->save();

        return redirect()->back()->with('success', 'Data rasa kopi berhasil diupdate.');
    }

    public function destroy($id)
    {
        $user_kopi = User::find($id);
        $user_kopi->delete();
        return redirect()->back();
    }
}
