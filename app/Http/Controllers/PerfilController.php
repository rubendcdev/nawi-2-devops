<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'apellidos' => 'nullable|string|max:100',
            'edad' => 'nullable|integer',
            'ine' => 'nullable|string|max:255',
            'permiso' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'estado' => 'in:activo,inactivo',
            'turno' => 'nullable|in:mañana,tarde,noche',
            'licencia' => 'nullable|file|mimes:pdf,jpg,png,jpeg|max:2048',
            'foto_conductor' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'foto_taxi' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'password' => 'nullable|min:6',
        ]);

        // Campos generales
        $user->apellidos = $request->apellidos;
        $user->edad = $request->edad;
        $user->ine = $request->ine;
        $user->permiso = $request->permiso;
        $user->telefono = $request->telefono;
        $user->direccion = $request->direccion;
        $user->estado = $request->estado ?? $user->estado;
        $user->turno = $request->turno;

        // Guardar archivos
        if ($request->hasFile('licencia')) {
            $user->licencia = $request->file('licencia')->store('licencias', 'public');
        }
        if ($request->hasFile('foto_conductor')) {
            $user->foto_conductor = $request->file('foto_conductor')->store('fotos', 'public');
        }
        if ($request->hasFile('foto_taxi')) {
            $user->foto_taxi = $request->file('foto_taxi')->store('fotos', 'public');
        }

        // Contraseña
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->route('perfil.show')->with('success', 'Perfil actualizado correctamente');
    }
}
