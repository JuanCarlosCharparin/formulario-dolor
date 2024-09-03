<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Localizacion extends Model
{
    protected $table = 'localizacion';

    protected $fillable = [
        'formulario_id',
        'zona',
        'localizacion',
    ];

    // Relación inversa muchos a uno con Formulario
    public function formulario()
    {
        return $this->belongsTo(Formulario::class);
    }
}