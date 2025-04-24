<?php

namespace App\Http\Controllers;
use App\Models\Predio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PredioController extends Controller
{
    public function geojson($id)
    {
        $predio = Predio::selectRaw('id, nombre, ST_AsGeoJSON(geom) as geom')->findOrFail($id);

        if (!$predio->geom) {
            return response()->json(['error' => 'No hay geometría disponible.'], 404);
        }

        return response()->json([
            'type' => 'Feature',
            'geometry' => json_decode($predio->geom), // Asegúrate que geom ya sea GeoJSON
            'properties' => [
                'id' => $predio->id,
                'nombre' => $predio->nombre ?? null // Puedes ajustar los campos
            ]
        ]);
    }
}
