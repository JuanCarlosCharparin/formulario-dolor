<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Intensidad extends Model
{
    protected $table = 'intensidad';

    protected $fillable = [
        'nombre',
    ];

    public function formularios()
    {
        return $this->hasMany(Formulario::class);
    }
}