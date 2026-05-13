<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RawIngredient;
use Illuminate\Support\Facades\Auth;

class RawIngredientController extends Controller
{
    public function index()
    {
        $raw_ingredient = RawIngredient::all();
        return view('admin.ingredient_kopi.raw_ingredient', compact('raw_ingredient'));
    }

    public function add(Request $request)
    {
        RawIngredient::create([
            'nama' => $request->nama,
            'stok' => $request->stok,
        ]);
        return redirect()->back()->with('success', 'Berhasil tambah data');
    }

    // Method untuk mengupdate data rasa kopi
    public function update(Request $request, $id)
    {
        $raw_ingredient = RawIngredient::findOrFail($id);
        $raw_ingredient->nama = $request->nama;
        $raw_ingredient->stok = $request->stok;
        $raw_ingredient->save();

        return redirect()->back()->with('success', 'Data Ingredient berhasil diupdate.');
    }

    public function destroy($id)
    {
        $raw_ingredient = RawIngredient::find($id);
        $raw_ingredient->delete();
        return redirect()->back();
    }
}
