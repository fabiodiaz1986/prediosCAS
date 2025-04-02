<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Predio extends Model
{
    use HasFactory;

    protected $table = 'predios_conserv_cas'; // Nombre exacto de la tabla en PostgreSQL
    protected $primaryKey = 'id'; // Asegúrate de que coincida con la clave primaria de la BD
    public $timestamps = false; // Si la tabla no tiene created_at y updated_at, usa false
    
    protected $fillable = [
        'id', 
        'geom', 
        'objectid', 
        'nombre', 
        'matricula', 
        'regional', 
        'municipio_',
        'ha_sig',
        'ha_compra',
        'vallas',
        'estado_ref',
        'ha_refores',
        'aisla_mts',
        'regen_natu',
        'observacio',
        'shape_leng',
        'shape_area', // <-- Ajusta los campos reales de la BD
    ];
}
