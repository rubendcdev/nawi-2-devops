<?php

namespace App\Http\Controllers;

use App\Models\Taxi;
use App\Models\Taxista;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TaxiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Mostrar formulario para agregar taxi
     */
    public function create()
    {
        $user = auth()->user();
        $taxista = Taxista::where('id_usuario', $user->id)->first();

        if (!$taxista) {
            return redirect()->route('taxista.dashboard')->with('error', 'Taxista no encontrado');
        }

        return view('taxista.taxi.create', compact('taxista'));
    }

    /**
     * Guardar nuevo taxi
     */
    public function store(Request $request)
    {
        $request->validate([
            'marca' => 'required|string|max:45',
            'modelo' => 'required|string|max:45',
            'numero_taxi' => 'required|string|max:10|unique:taxis,numero_taxi',
        ]);

        $user = auth()->user();
        $taxista = Taxista::where('id_usuario', $user->id)->first();

        if (!$taxista) {
            return back()->with('error', 'Taxista no encontrado');
        }

        // Crear taxi
        $taxi = Taxi::create([
            'id' => Str::uuid(),
            'marca' => $request->marca,
            'modelo' => $request->modelo,
            'numero_taxi' => $request->numero_taxi,
            'id_taxista' => $taxista->id
        ]);

        return redirect()->route('taxista.dashboard')->with('success', 'Taxi registrado exitosamente');
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit($id)
    {
        $user = auth()->user();
        $taxista = Taxista::where('id_usuario', $user->id)->first();

        if (!$taxista) {
            return redirect()->route('taxista.dashboard')->with('error', 'Taxista no encontrado');
        }

        $taxi = Taxi::where('id', $id)->where('id_taxista', $taxista->id)->first();

        if (!$taxi) {
            return redirect()->route('taxista.dashboard')->with('error', 'Taxi no encontrado');
        }

        return view('taxista.taxi.edit', compact('taxi'));
    }

    /**
     * Actualizar taxi
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'marca' => 'required|string|max:45',
            'modelo' => 'required|string|max:45',
            'numero_taxi' => 'required|string|max:10|unique:taxis,numero_taxi,' . $id,
        ]);

        $user = auth()->user();
        $taxista = Taxista::where('id_usuario', $user->id)->first();

        if (!$taxista) {
            return back()->with('error', 'Taxista no encontrado');
        }

        $taxi = Taxi::where('id', $id)->where('id_taxista', $taxista->id)->first();

        if (!$taxi) {
            return back()->with('error', 'Taxi no encontrado');
        }

        $taxi->update([
            'marca' => $request->marca,
            'modelo' => $request->modelo,
            'numero_taxi' => $request->numero_taxi,
        ]);

        return redirect()->route('taxista.dashboard')->with('success', 'Taxi actualizado exitosamente');
    }

}
