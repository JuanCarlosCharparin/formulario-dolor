<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoDolor extends Model
{
    protected $table = 'tipo_dolor';

    protected $fillable = [
        'nombre',
    ];

    // Relación uno a muchos con Formulario
    public function formularios()
    {
        return $this->hasMany(Formulario::class);
    }
}