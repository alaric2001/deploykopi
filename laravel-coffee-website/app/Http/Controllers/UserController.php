<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $data_user = User::all();
        // dd($data_user);
        return view('admin.user_seteguk.index', compact('data_user'));
    }
}
