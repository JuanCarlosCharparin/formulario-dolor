<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Crear Formulario') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form method="POST" action="{{ route('formulario.store') }}" class="space-y-4">
                    @csrf

                    <!-- Formulario de Búsqueda de Paciente -->
                    <div class="mb-4">
                        <label for="search-input" class="block text-gray-700 dark:text-gray-300">DNI:</label>
                        <div class="flex items-center">
                            <input type="text" id="search-input" name="documento" class="form-input rounded-md shadow-sm" placeholder="DNI del paciente">
                            <button type="button" class="btn btn-primary ms-4" id="search-button">
                                Buscar
                            </button>
                        </div>
                    </div>
                    
                    <!-- Resultados de la Búsqueda -->
                    <div id="results" class="mb-4"></div>

                    <!-- Campo para mostrar el nombre del paciente seleccionado -->
                    <div class="mb-4">
                        <input type="text" id="selected-person" name="paciente" class="form-input rounded-md shadow-sm" placeholder="Nombre del paciente seleccionado" readonly>
                        <input type="hidden" name="paciente_salutte_id" id="paciente_salutte_id">
                    </div>

                    <!-- Campo de Fecha de Carga -->
                    <div class="mb-4">
                        <label for="fecha_carga" class="form-label">Fecha de Carga</label>
                        <input type="date" class="form-input rounded-md shadow-sm @error('fecha_carga') is-invalid @enderror" id="fecha_carga" name="fecha_carga" value="{{ old('fecha_carga') }}">
                        @error('fecha_carga')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Campo de Intensidad -->
                    <div class="mb-4">
                        <label for="intensidad_id" class="form-label">Intensidad</label>
                        <select class="form-select rounded-md shadow-sm @error('intensidad_id') is-invalid @enderror" id="intensidad_id" name="intensidad_id">
                            @foreach($intensidades as $intensidad)
                                <option value="{{ $intensidad->id }}">{{ $intensidad->nombre }}</option>
                            @endforeach
                        </select>
                        @error('intensidad_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Campo de Tipo de Dolor -->
                    <div class="mb-4">
                        <label for="tipo_dolor_id" class="form-label">Tipo de Dolor</label>
                        <select class="form-select rounded-md shadow-sm @error('tipo_dolor_id') is-invalid @enderror" id="tipo_dolor_id" name="tipo_dolor_id">
                            @foreach($tiposDolor as $tipoDolor)
                                <option value="{{ $tipoDolor->id }}" {{ old('tipo_dolor_id') == $tipoDolor->id ? 'selected' : '' }}>
                                    {{ $tipoDolor->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('tipo_dolor_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Campo de Dolor -->
                    <div class="mb-4">
                        <label for="dolor_id" class="form-label">Dolor</label>
                        <select class="form-select rounded-md shadow-sm @error('dolor_id') is-invalid @enderror" id="dolor_id" name="dolor_id">
                            @foreach($dolores as $dolor)
                                <option value="{{ $dolor->id }}" {{ old('dolor_id') == $dolor->id ? 'selected' : '' }}>
                                    {{ $dolor->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('dolor_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Campo de Derivador Por -->
                    <div class="mb-4">
                        <label for="derivador_por" class="form-label">Derivador por: </label>
                        <input type="text" id="derivado_por" name="derivado_por" class="form-input rounded-md shadow-sm @error('derivado_por') is-invalid @enderror" value="{{ old('derivado_por') }}" placeholder="Profesional solicitante">
                        @error('derivador_por')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Campo de Duración -->
                    <div class="mb-4">
                        <label for="duracion" class="form-label">Duración</label>
                        <input type="text" id="duracion" name="duracion" class="form-input rounded-md shadow-sm @error('duracion') is-invalid @enderror" value="{{ old('duracion') }}" placeholder="Ingrese la duración">
                        @error('duracion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Campo de Inicio -->
                    <div class="mb-4">
                        <label for="inicio" class="form-label">Inicio: </label>
                        <input type="date" id="inicio" name="inicio" class="form-input rounded-md shadow-sm @error('inicio') is-invalid @enderror" value="{{ old('inicio') }}">
                        @error('inicio')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Campo de Factores Atenuantes del Dolor -->
                    <div class="mb-4">
                        <label for="factores_atenuantes" class="form-label">Factores Atenuantes del Dolor</label>
                        <input type="text" id="factores_atenuantes" name="factores_atenuantes" class="form-input rounded-md shadow-sm @error('factores_atenuantes') is-invalid @enderror" value="{{ old('factores_atenuantes') }}" placeholder="Ingrese los factores atenuantes del dolor">
                        @error('factores_atenuantes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Campo de Factores Agravantes del Dolor -->
                    <div class="mb-4">
                        <label for="factores_agravantes" class="form-label">Factores Agravantes del Dolor</label>
                        <input type="text" id="factores_agravantes" name="factores_agravantes" class="form-input rounded-md shadow-sm @error('factores_agravantes') is-invalid @enderror" value="{{ old('factores_agravantes') }}" placeholder="Ingrese los factores agravantes del dolor">
                        @error('factores_agravantes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Campo de Descripción -->
                    <div class="mb-4">
                        <label for="descripcion" class="form-label">Descripción del dolor: </label>
                        <textarea id="descripcion" name="descripcion" rows="4" class="form-input rounded-md shadow-sm @error('descripcion') is-invalid @enderror" placeholder="Ingrese la descripción">{{ old('descripcion') }}</textarea>
                        @error('descripcion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    <!-- Campo de Puntuación ECN -->
                    <div class="mb-4">
                        <label for="puntuacion_ecn" class="form-label">Puntuación ECN</label>
                        <input type="number" step="0.01" id="puntuacion_ecn" name="puntuacion_ecn" class="form-input rounded-md shadow-sm @error('puntuacion_ecn') is-invalid @enderror" value="{{ old('puntuacion_ecn') }}" placeholder="Ingrese la puntuación ECN">
                        @error('puntuacion_ecn')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Botón de Crear -->
                    <button type="submit" class="btn btn-primary">Crear</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#search-button').click(function(e) {
                e.preventDefault();

                var searchTerm = $('#search-input').val().trim();
                if (!searchTerm) {
                    $('#results').html('<p>Por favor, ingrese un término de búsqueda.</p>');
                    return;
                }

                $.ajax({
                    url: '{{ route('formulario.searchPatient') }}',
                    method: 'GET',
                    data: { search: searchTerm },
                    success: function(data) {
                        var resultHtml = '';
                        if (data.length > 0) {
                            data.forEach(function(patient) {
                                resultHtml += '<div>';
                                resultHtml += '<p><strong>HC Electrónica:</strong> ' + patient.id + '</p>';
                                resultHtml += '<p><strong>Nombre:</strong> ' + patient.nombres + ' ' + patient.apellidos + '</p>';
                                resultHtml += '<p><strong>DNI:</strong> ' + patient.documento + '</p>';
                                resultHtml += '<p><strong>Fecha de Nacimiento:</strong> ' + patient.fecha_nacimiento + '</p>';
                                resultHtml += '<p><strong>Edad:</strong> ' + patient.edad + '</p>';
                                resultHtml += '<p><strong>Genero:</strong> ' + patient.genero + '</p>';
                                resultHtml += '<p><strong>Obra Social:</strong> ' + patient.obra_social + '</p>';
                                resultHtml += '<p><strong>Correo:</strong> ' + patient.email + '</p>';
                                resultHtml += '<p><strong>Teléfono:</strong> ' + patient.contacto_telefono + '</p>';
                                resultHtml += '<p><strong>Domicilio:</strong> ' + patient.domicilio + '</p>';
                                resultHtml += '<button type="button" class="btn btn-primary select-button" data-id="' + patient.id + '" data-name="' + patient.nombres + ' ' + patient.apellidos + '">Seleccionar</button>';
                                resultHtml += '</div><hr>';
                            });
                        } else {
                            resultHtml = '<p>No se encontraron resultados.</p>';
                        }
                        $('#results').html(resultHtml);
                    },
                    error: function(xhr, status, error) {
                        var errorMessage = 'Error al buscar datos.';
                        if (xhr.status === 404) {
                            errorMessage = 'La ruta no fue encontrada.';
                        } else if (xhr.status === 500) {
                            errorMessage = 'Error interno del servidor.';
                        }
                        $('#results').html('<p>' + errorMessage + '</p>');
                    }
                });
            });

            $('#results').on('click', '.select-button', function(e) {
                e.preventDefault();

                var selectedId = $(this).data('id');
                var selectedName = $(this).data('name');
                $('#selected-person').val(selectedName);
                $('#paciente_salutte_id').val(selectedId);
            });
        });
    </script>
</x-app-layout>