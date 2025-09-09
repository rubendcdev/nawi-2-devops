<?php

namespace App\Http\Controllers;

use App\Models\Carro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarroController extends Controller
{
    /**
     * Mostrar todos los carros.
     */
    public function index()
    {
        $carros = Carro::all();
        return view('carros.index', compact('carros'));
    }

    /**
     * Mostrar formulario para crear un nuevo carro.
     */
    public function create()
    {
        return view('carros.create');
    }

    /**
     * Guardar un nuevo carro en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'placa' => 'required|string|max:45',
            'modelo' => 'required|string|max:100',
            'num_serie' => 'required|string|max:400',
            'anio' => 'required|integer',
            'marca' => 'required|string|max:45',
            'num_taxi' => 'nullable|integer',
            'foto_taxi' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto_taxi')) {
            $data['foto_taxi'] = $request->file('foto_taxi')->store('fotos_taxis', 'public');
        }

        Carro::create($data);

        return redirect()->route('carros.index')->with('success', 'Carro registrado correctamente');
    }

    /**
     * Mostrar un carro específico.
     */
    public function show($id_carro)
    {
        $carro = Carro::findOrFail($id_carro);
        return view('carros.show', compact('carro'));
    }

    /**
     * Mostrar formulario para editar un carro.
     */
    public function edit($id_carro)
    {
        $carro = Carro::findOrFail($id_carro);
        return view('carros.edit', compact('carro'));
    }

    /**
     * Actualizar un carro en la base de datos.
     */
    public function update(Request $request, $id_carro)
    {
        $request->validate([
            'placa' => 'required|string|max:45',
            'modelo' => 'required|string|max:100',
            'num_serie' => 'required|string|max:400',
            'anio' => 'required|integer',
            'marca' => 'required|string|max:45',
            'num_taxi' => 'nullable|integer',
            'foto_taxi' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $carro = Carro::findOrFail($id_carro);
        $data = $request->all();

        if ($request->hasFile('foto_taxi')) {
            // eliminar la foto anterior si existe
            if ($carro->foto_taxi && Storage::disk('public')->exists($carro->foto_taxi)) {
                Storage::disk('public')->delete($carro->foto_taxi);
            }

            $data['foto_taxi'] = $request->file('foto_taxi')->store('fotos_taxis', 'public');
        }

        $carro->update($data);

        return redirect()->route('carros.index')->with('success', 'Carro actualizado correctamente');
    }

    /**
     * Eliminar un carro de la base de datos.
     */
    public function destroy($id_carro)
    {
        $carro = Carro::findOrFail($id_carro);

        if ($carro->foto_taxi && Storage::disk('public')->exists($carro->foto_taxi)) {
            Storage::disk('public')->delete($carro->foto_taxi);
        }

        $carro->delete();

        return redirect()->route('carros.index')->with('success', 'Carro eliminado correctamente');
    }
}
