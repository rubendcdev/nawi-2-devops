<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use App\Models\User;

class PerfilController extends Controller
{
        public function show()
    {
        $user = Auth::user();
        return view('perfil.show', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user(); 
        return view('perfil.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'licencia' => 'nullable|file|mimes:pdf,jpg,png,jpeg',
            'password' => 'nullable|min:6',
        ]);

        $user->name = $request->name;
        $user->telefono = $request->telefono;
        $user->direccion = $request->direccion;
        $user->activo = $request->activo;

        
        if ($request->hasFile('licencia')) {
            $path = $request->file('licencia')->store('licencias', 'public');
            $user->licencia = $path;
        }

        
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->route('perfil.show')->with('success', 'Perfil actualizado correctamente');
    }
}
