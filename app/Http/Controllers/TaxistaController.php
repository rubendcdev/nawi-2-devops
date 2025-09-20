<?php

namespace App\Http\Controllers;

use App\Models\Taxista;
use Illuminate\Http\Request;

class TaxistaController extends Controller
{
    public function index()
    {
        $taxistas = Taxista::with('taxi')->get();
        return view('taxistas.index', compact('taxistas'));
    }
}
