<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dolor extends Model
{
    protected $table = 'dolor';

    protected $fillable = [
        'nombre',
    ];

    public function formularios()
    {
        return $this->hasMany(Formulario::class);
    }
}