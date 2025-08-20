<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Taxista;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PerfilController extends Controller
{
    public function show()
    {
        $taxista = Auth::user(); // si tu login es con taxistas
        return view('perfil.show', compact('taxista'));
    }

    public function edit()
    {
        $taxista = Auth::user();
        return view('perfil.edit', compact('taxista'));
    }

    public function update(Request $request)
    {
        $taxista = Auth::user();

        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'num_telefono' => 'required|string|max:20',
            'contrasena' => 'nullable|min:6'
        ]);

        $data = $request->all();

        if ($request->filled('contrasena')) {
            $data['contrasena'] = Hash::make($request->contrasena);
        } else {
            unset($data['contrasena']);
        }

        $taxista->update($data);

        return redirect()->route('perfil.show')->with('success', 'Perfil actualizado correctamente.');
    }
}
