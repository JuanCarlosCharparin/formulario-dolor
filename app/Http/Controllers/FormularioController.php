<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Formulario;
use App\Models\Localizacion;
use App\Models\Intensidad;
use App\Models\Dolor;
use App\Models\TipoDolor;
use App\Models\Paciente;



class FormularioController extends Controller {
    
    public function index(Request $request)
    {
        // Obtener todos los IDs de pacientes desde los formularios
        $pacienteIds = Formulario::pluck('paciente_salutte_id')->unique(); // Obtener IDs únicos

        // Obtener el nombre y apellido de los pacientes
        $pacientes = Paciente::getNamePatient($pacienteIds);

        // Crear un array asociativo para facilitar el acceso en la vista
        $pacientesMap = $pacientes->keyBy('id');

        // Obtener los formularios con las relaciones necesarias
        $formularios = Formulario::with(['localizaciones', 'intensidad', 'dolor', 'tipoDolor'])->get();

        return view('formulario.index', compact('formularios', 'pacientesMap'));
    }


    public function create()
    {
        // Obtener datos para llenar los campos select
        $localizaciones = Localizacion::all();
        $intensidades = Intensidad::all();
        $dolores = Dolor::all();
        $tiposDolor = TipoDolor::all();

        return view('formulario.create', compact('localizaciones', 'intensidades', 'dolores', 'tiposDolor'));
    }


    public function store(Request $request)
    {
        // Validar y guardar datos del formulario
        $request->validate([
            'documento' => [
                'required',
                function ($attribute, $value, $fail) {
                    // Verificar existencia en db2
                    $paciente = Paciente::findByDni($value);
                    if (!$paciente) {
                        $fail('El paciente no existe en la base de datos.');
                    }
                }
            ],
            'fecha_carga' => 'required|date',
            'derivado_por' => 'required|string',
            'inicio' => 'nullable|string',
            'duracion' => 'nullable|string',
            'inicio' => 'required|string',
            'factores_atenuantes' => 'nullable|string',
            'factores_agravantes' => 'nullable|string',
            'puntuacion_ecn' => 'nullable|numeric',
            'descripcion' => 'nullable|string',
            'intensidad_id' => 'required|exists:intensidad,id',
            'dolor_id' => 'required|exists:dolor,id',
            'tipo_dolor_id' => 'required|exists:tipo_dolor,id',
            'descripcion' => 'nullable|string',
        ]);

        //Obtener el id del ultimo formulario en la db 
        $lastForm = Formulario::latest('id')->first();
        
        //Sumarle 1
        $newFormId = $lastForm ? $lastForm->id + 1 : 1;
        
        //Traer zonas de la vista 
        $selectedAreas = json_decode($request->input('selectedAreas'), true);

        //Borrar anteriores registros con el mismo id
        Localizacion::where('formulario_id', $newFormId)->delete();

        //Crear el formulario con las validaciones
        $formulario = Formulario::create($request->all());

        //Iterar las areas cargadas en la vista y crear las localizaciones
        foreach ($selectedAreas as $area) {
            Localizacion::create([
                'formulario_id' => $newFormId,
                'zona' => $area, 
            ]);
        }
        return redirect()->route('formulario.index')->with('success', 'Formulario creado exitosamente.');
    }

    // Función para buscar paciente
    public function searchPatient(Request $request)
    {
        $searchTerm = $request->input('search');

        // Llama al método search del modelo Paciente
        $patients = Paciente::search($searchTerm);

        return response()->json($patients);
    }

}