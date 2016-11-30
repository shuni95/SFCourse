<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Models\Incidente;

use App\Services\CountryCatcher;

class IncidenteController extends Controller
{
    public function index()
    {
        $incidentes = Incidente::all();
        $paises = CountryCatcher::fetch();

        $fecha_inicio = date('Y-m-d');
        $fecha_fin    = date('Y-m-d');

        $data = [
            'incidentes' => $incidentes,
            'paises' => $paises,
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin,
        ];

        return view('admin.incidente.index', $data);
    }

    public function show($incidente)
    {
        $data = [
            'incidente' => $incidente,
        ];

        return view('admin.incidente.show', $data);
    }

    public function filter(Request $request)
    {
        $incidentes = new Incidente;
        $paises = CountryCatcher::fetch();

        if ($request->has('pais')) {
            $incidentes->where('pais_nombre', $request->input('pais'));
        }

        $fecha_inicio = $request->input('fecha_inicio');
        if ($fecha_inicio) {
            $incidentes->where('created_at' , '>=', $fecha_inicio);
        } else {
            $fecha_inicio = date('Y-m-d');
        }

        $fecha_fin = $request->input('fecha_fin');
        if ($fecha_fin) {
            $incidentes->where('created_at' , '<=', $fecha_fin);
        } else {
            $fecha_fin = date('Y-m-d');
        }

        $incidentes = $incidentes->get();

        $data = [
            'incidentes' => $incidentes,
            'paises' => $paises,
            'pais_nombre' => $request->input('pais'),
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin,
        ];

        return view('admin.incidente.index', $data);
    }
}
