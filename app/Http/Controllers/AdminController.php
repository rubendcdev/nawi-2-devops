<?php

namespace App\Http\Controllers;

use App\Models\Matricula;
use App\Models\Licencia;
use App\Models\Taxista;
use App\Models\EstatusDocumento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Panel principal de administración
     */
    public function dashboard()
    {
        $matriculasPendientes = Matricula::with(['estatus', 'taxistas.usuario'])
            ->where('id_estatus', '1') // pendiente
            ->get();

        $licenciasPendientes = Licencia::with(['estatus', 'taxistas.usuario'])
            ->where('id_estatus', '1') // pendiente
            ->get();

        $estadisticas = [
            'matriculas_pendientes' => Matricula::where('id_estatus', '1')->count(),
            'licencias_pendientes' => Licencia::where('id_estatus', '1')->count(),
            'matriculas_aprobadas' => Matricula::where('id_estatus', '2')->count(),
            'licencias_aprobadas' => Licencia::where('id_estatus', '2')->count(),
            'total_taxistas' => Taxista::count(),
        ];

        return view('admin.dashboard', compact('matriculasPendientes', 'licenciasPendientes', 'estadisticas'));
    }

    /**
     * Lista de documentos pendientes
     */
    public function documentos()
    {
        $matriculas = Matricula::with(['estatus', 'taxistas.usuario'])
            ->orderBy('created_at', 'desc')
            ->get();

        $licencias = Licencia::with(['estatus', 'taxistas.usuario'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.documentos', compact('matriculas', 'licencias'));
    }

    /**
     * Aprobar documento
     */
    public function aprobarDocumento(Request $request)
    {
        $request->validate([
            'tipo' => 'required|in:matricula,licencia',
            'id' => 'required|string'
        ]);

        if ($request->tipo === 'matricula') {
            $documento = Matricula::find($request->id);
        } else {
            $documento = Licencia::find($request->id);
        }

        if (!$documento) {
            return back()->with('error', 'Documento no encontrado');
        }

        $documento->update(['id_estatus' => '2']); // aprobado

        return back()->with('success', 'Documento aprobado exitosamente');
    }

    /**
     * Rechazar documento
     */
    public function rechazarDocumento(Request $request)
    {
        $request->validate([
            'tipo' => 'required|in:matricula,licencia',
            'id' => 'required|string',
            'motivo' => 'required|string|max:255'
        ]);

        if ($request->tipo === 'matricula') {
            $documento = Matricula::find($request->id);
        } else {
            $documento = Licencia::find($request->id);
        }

        if (!$documento) {
            return back()->with('error', 'Documento no encontrado');
        }

        $documento->update(['id_estatus' => '3']); // rechazado

        return back()->with('success', 'Documento rechazado exitosamente');
    }

    /**
     * Ver documento
     */
    public function verDocumento($tipo, $id)
    {
        if ($tipo === 'matricula') {
            $documento = Matricula::find($id);
        } else {
            $documento = Licencia::find($id);
        }

        if (!$documento) {
            abort(404);
        }

        $rutaArchivo = public_path('uploads/' . $tipo . 's/' . $documento->url);

        if (!file_exists($rutaArchivo)) {
            abort(404, 'Archivo no encontrado');
        }

        return response()->file($rutaArchivo);
    }

    /**
     * Descargar documento
     */
    public function descargarDocumento($tipo, $id)
    {
        if ($tipo === 'matricula') {
            $documento = Matricula::find($id);
        } else {
            $documento = Licencia::find($id);
        }

        if (!$documento) {
            abort(404);
        }

        $rutaArchivo = public_path('uploads/' . $tipo . 's/' . $documento->url);

        if (!file_exists($rutaArchivo)) {
            abort(404, 'Archivo no encontrado');
        }

        return response()->download($rutaArchivo);
    }
}
