<?php

namespace App\Http\Controllers;

use App\Models\Foto;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FotoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Subir foto de perfil
     */
    public function uploadPerfil(Request $request)
    {
        $request->validate([
            'foto' => 'required|file|mimes:jpg,jpeg,png|max:2048', // 2MB max
        ]);

        $user = auth()->user();

        // Subir archivo
        $archivo = $request->file('foto');
        $nombreArchivo = time() . '_' . Str::random(10) . '.' . $archivo->getClientOriginalExtension();
        $archivo->move(public_path('uploads/fotos'), $nombreArchivo);

        // Eliminar foto anterior si existe
        $fotoAnterior = Foto::where('id_usuario', $user->id)->first();
        if ($fotoAnterior) {
            // Eliminar archivo físico
            $rutaAnterior = public_path('uploads/fotos/' . $fotoAnterior->url);
            if (file_exists($rutaAnterior)) {
                unlink($rutaAnterior);
            }
            // Eliminar registro de BD
            $fotoAnterior->delete();
        }

        // Crear nueva foto
        $foto = Foto::create([
            'id' => Str::uuid(),
            'url' => $nombreArchivo,
            'fecha_subida' => now(),
            'id_usuario' => $user->id
        ]);

        return back()->with('success', 'Foto de perfil actualizada exitosamente');
    }

    /**
     * Eliminar foto de perfil
     */
    public function eliminarPerfil()
    {
        $user = auth()->user();
        $foto = Foto::where('id_usuario', $user->id)->first();

        if ($foto) {
            // Eliminar archivo físico
            $rutaArchivo = public_path('uploads/fotos/' . $foto->url);
            if (file_exists($rutaArchivo)) {
                unlink($rutaArchivo);
            }
            // Eliminar registro de BD
            $foto->delete();

            return back()->with('success', 'Foto de perfil eliminada exitosamente');
        }

        return back()->with('error', 'No se encontró foto de perfil');
    }

    /**
     * Ver foto de perfil
     */
    public function verFoto($id)
    {
        $foto = Foto::find($id);

        if (!$foto) {
            abort(404);
        }

        $rutaArchivo = public_path('uploads/fotos/' . $foto->url);

        if (!file_exists($rutaArchivo)) {
            abort(404, 'Archivo no encontrado');
        }

        return response()->file($rutaArchivo);
    }
}
