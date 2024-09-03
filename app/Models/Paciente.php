<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Paciente extends Model
{

    protected $connection = 'db2'; 
    protected $table = 'persona'; 


    protected $fillable = [
        'id',
        'documento',
        'apellidos',
        'nombres',
        'fecha_nacimiento',
        'genero',
    ];

    //Obtener Pacientes

    public static function search($searchTerm)
    {
        return self::select(
                            'persona.id as id',
                            'persona.documento as documento',
                            'persona.nombres as nombres',
                            'persona.apellidos as apellidos',
                            DB::raw("
                                CASE 
                                    WHEN persona.genero = 'm' THEN 'Masculino'
                                    WHEN persona.genero = 'f' THEN 'Femenino'
                                    ELSE 'Desconocido'
                                END AS genero
                            "),
                            'persona.fecha_nacimiento as fecha_nacimiento',
                            DB::raw('TIMESTAMPDIFF(YEAR, persona.fecha_nacimiento, CURDATE()) AS edad'),
                            'obra_social.nombre as obra_social',
                            'persona.contacto_email_direccion as email',
                            DB::raw("
                                CASE 
                                    WHEN COALESCE(persona.contacto_telefono_codigo, '') = '' AND COALESCE(persona.contacto_telefono_numero, '') = '' 
                                    THEN 'No proporcionado'
                                    ELSE CONCAT(COALESCE(persona.contacto_telefono_codigo, ''), ' ', COALESCE(persona.contacto_telefono_numero, ''))
                                END AS contacto_telefono
                            "),
                            DB::raw("
                                CONCAT(
                                    COALESCE(d.calle, ''), ', ',
                                    COALESCE(d.nro, ''), ', ',
                                    COALESCE(c.nombre, ''), ', ',
                                    COALESCE(prov.nombre, ''), ', ',
                                    COALESCE(pai.nombre, '')
                                ) AS domicilio
                            ")
        )
        ->join('persona_plan as pp', 'persona.id', '=', 'pp.persona_id')
        ->join('plan as pl', 'pp.plan_id', '=', 'pl.id')
        ->join('obra_social as obra_social', 'pl.obra_social_id', '=', 'obra_social.id')
        ->join('persona_plan_por_defecto as pppd', 'pp.id', '=', 'pppd.persona_plan_id')
        ->leftJoin('direccion as d', 'persona.direccion_id', '=', 'd.id')
        ->leftJoin('ciudad as c', 'd.ciudad_id', '=', 'c.id')
        ->leftJoin('provincia as prov', 'd.provincia_id', '=', 'prov.id')
        ->leftJoin('pais as pai', 'persona.pais_id', '=', 'pai.id')
        ->where('persona.documento', $searchTerm)
        ->get();
    }

    public static function findByDni($dni)
    {
        return self::select(
                'persona.id as id',
                'persona.documento as documento',
                'persona.nombres as nombres',
                'persona.apellidos as apellidos',
                'persona.fecha_nacimiento as fecha_nacimiento',
                'persona.genero as genero',
                'obra_social.nombre as obra_social')
            ->join('persona_plan as pp', 'persona.id', '=', 'pp.persona_id')
            ->join('plan as pl', 'pp.plan_id', '=', 'pl.id')
            ->join('obra_social as obra_social', 'pl.obra_social_id', '=', 'obra_social.id')
            ->join('persona_plan_por_defecto as pppd', 'pp.id', '=', 'pppd.persona_plan_id')
            ->where('persona.documento', $dni) 
            ->first(); 
    }


    public static function getNamePatient($ids)
    {
        return self::select('id', 'nombres', 'apellidos', 'documento')
                    ->whereIn('id', $ids)
                    ->get();
    }

}