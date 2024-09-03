<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Formulario extends Model
{
    
    protected $table = 'formulario';

    protected $fillable = [
        'paciente_salutte_id',
        'fecha_carga',
        'derivado_por',
        'inicio',
        'duracion',
        'factores_atenuantes',
        'factores_agravantes',
        'puntuacion_ecn',
        'descripcion',
        'intensidad_id',
        'dolor_id',
        'tipo_dolor_id',
    ];

    
    public function localizaciones()
    {
        return $this->hasMany(Localizacion::class);
    }

    
    public function intensidad()
    {
        return $this->belongsTo(Intensidad::class);
    }

    
    public function dolor()
    {
        return $this->belongsTo(Dolor::class);
    }

    
    public function tipoDolor()
    {
        return $this->belongsTo(TipoDolor::class);
    }

    public static function getPacienteSalutteIds()
    {
        return self::pluck('paciente_salutte_id');
    }
}