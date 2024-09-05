<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Crear Formulario') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                <style>
                    .area {
                        position: absolute;
                        border: 2px solid transparent;
                        background-color: rgba(255, 0, 0, 0.3);
                        cursor: pointer;
                    }
                    .selected {
                        border-color: red;
                    }
                </style>

                <form method="POST" id="areas-form" action="{{ route('formulario.store') }}" class="space-y-4">
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
                    <p></p>
                    <hr>


                    

                    <div style="position: relative; width: 700px;">
                        <img src="{{ asset('img/cuerpo-humano.jpg') }}" style="width: 100%;">
                        <!-- Cabeza Frente -->
                        <div class="area" style="top: 8px; left: 485px; width: 25px; height: 25px;" data-zone="cabeza-anterior-izquierda" onclick="selectArea(event, 'cabeza-anterior-izquierda')"></div>
                        <div class="area" style="top: 8px; left: 450px; width: 25px; height: 25px;" data-zone="cabeza-anterior-derecha" onclick="selectArea(event, 'cabeza-anterior-derecha')"></div>
                        <div class="area" style="top: 42px; left: 444px; width: 25px; height: 25px;" data-zone="pomulo-anterior-derecho" onclick="selectArea(event, 'pomulo-anterior-derecho')"></div>
                        <div class="area" style="top: 42px; left: 490px; width: 25px; height: 25px;" data-zone="pomulo-anterior-izquierdo" onclick="selectArea(event, 'pomulo-anterior-izquierdo')"></div>

                        <!-- Cabeza Posterior -->
                        <div class="area" style="top: 8px; left: 275px; width: 25px; height: 25px;" data-zone="cabeza-posterior-derecha" onclick="selectArea(event, 'cabeza-posterior-derecha')"></div>
                        <div class="area" style="top: 8px; left: 240px; width: 25px; height: 25px;" data-zone="cabeza-posterior-izquierda" onclick="selectArea(event, 'cabeza-posterior-izquierda')"></div>

                        <!-- Hombro Anterior -->
                        <div class="area" style="top: 70px; left: 515px; width: 25px; height: 25px;" data-zone="hombro-anterior-izquierdo" onclick="selectArea(event, 'hombro-anterior-izquierdo')"></div>
                        <div class="area" style="top: 70px; left: 420px; width: 25px; height: 25px;" data-zone="hombro-anterior-derecho" onclick="selectArea(event, 'hombro-anterior-derecho')"></div>

                        <!-- Hombro Posterior -->
                        <div class="area" style="top: 68px; left: 305px; width: 25px; height: 25px;" data-zone="hombro-posterior-derecho" onclick="selectArea(event, 'hombro-posterior-derecho')"></div>
                        <div class="area" style="top: 68px; left: 210px; width: 25px; height: 25px;" data-zone="hombro-posterior-izquierdo" onclick="selectArea(event, 'hombro-posterior-izquierdo')"></div>

                        <!-- Trapecio Posterior -->
                        <div class="area" style="top: 60px; left: 275px; width: 25px; height: 25px;" data-zone="trapecio-posterior-derecho" onclick="selectArea(event, 'trapecio-posterior-derecho')"></div>
                        <div class="area" style="top: 60px; left: 240px; width: 25px; height: 25px;" data-zone="trapecio-posterior-izquierdo" onclick="selectArea(event, 'trapecio-posterior-izquierdo')"></div>

                        <!-- Espalda -->
                        <div class="area" style="top: 120px; left: 275px; width: 25px; height: 25px;" data-zone="espalda-derecha" onclick="selectArea(event, 'espalda-derecha')"></div>
                        <div class="area" style="top: 120px; left: 240px; width: 25px; height: 25px;" data-zone="espalda-izquierda" onclick="selectArea(event, 'espalda-izquierda')"></div>

                        <!-- Pectoral -->
                        <div class="area" style="top: 100px; left: 490px; width: 25px; height: 25px;" data-zone="pectoral-izquierdo" onclick="selectArea(event, 'pectoral-izquierdo')"></div>
                        <div class="area" style="top: 100px; left: 447px; width: 25px; height: 25px;" data-zone="pectoral-derecho" onclick="selectArea(event, 'pectoral-derecho')"></div>

                        <!-- Abdominal -->
                        <div class="area" style="top: 160px; left: 485px; width: 25px; height: 25px;" data-zone="abdominal-izquierda" onclick="selectArea(event, 'abdominal-izquierda')"></div>
                        <div class="area" style="top: 160px; left: 450px; width: 25px; height: 25px;" data-zone="abdominal-derecha" onclick="selectArea(event, 'abdominal-derecha')"></div>

                        <!-- Codo Anterior -->
                        <div class="area" style="top: 140px; left: 515px; width: 25px; height: 25px;" data-zone="codo-anterior-izquierdo" onclick="selectArea(event, 'codo-anterior-izquierdo')"></div>
                        <div class="area" style="top: 140px; left: 410px; width: 25px; height: 25px;" data-zone="codo-anterior-derecho" onclick="selectArea(event, 'codo-anterior-derecho')"></div>

                        <!-- Codo Posterior -->
                        <div class="area" style="top: 140px; left: 315px; width: 25px; height: 25px;" data-zone="codo-posterior-derecho" onclick="selectArea(event, 'codo-posterior-derecho')"></div>
                        <div class="area" style="top: 140px; left: 205px; width: 25px; height: 25px;" data-zone="codo-posterior-izquierdo" onclick="selectArea(event, 'codo-posterior-izquierdo')"></div>
                        
                        <!-- Lumbar -->
                        <div class="area" style="top: 160px; left: 275px; width: 25px; height: 25px;" data-zone="lumbar-derecha" onclick="selectArea(event, 'lumbar-derecha')"></div>
                        <div class="area" style="top: 160px; left: 240px; width: 25px; height: 25px;" data-zone="lumbar-izquierda" onclick="selectArea(event, 'lumbar-izquierda')"></div>

                        <!-- Gluteo -->
                        <div class="area" style="top: 200px; left: 280px; width: 25px; height: 25px;" data-zone="gluteo-derecho" onclick="selectArea(event, 'gluteo-derecho')"></div>
                        <div class="area" style="top: 200px; left: 240px; width: 25px; height: 25px;" data-zone="gluteo-izquierdo" onclick="selectArea(event, 'gluteo-izquierdo')"></div>

                        <!-- Ingle -->
                        <div class="area" style="top: 205px; left: 485px; width: 25px; height: 25px;" data-zone="ingle-izquierda" onclick="selectArea(event, 'ingle-izquierda')"></div>
                        <div class="area" style="top: 205px; left: 445px; width: 25px; height: 25px;" data-zone="ingle-derecha" onclick="selectArea(event, 'ingle-derecha')"></div>

                        <!-- Muñeca Posterior -->
                        <div class="area" style="top: 200px; left: 330px; width: 25px; height: 25px;" data-zone="muñeca-posterior-derecha" onclick="selectArea(event, 'muñeca-posterior-derecha')"></div>
                        <div class="area" style="top: 200px; left: 195px; width: 25px; height: 25px;" data-zone="muñeca-posterior-izquierda" onclick="selectArea(event, 'muñeca-posterior-izquierda')"></div>

                        <!-- Muñeca Anterior -->
                        <div class="area" style="top: 200px; left: 525px; width: 25px; height: 25px;" data-zone="muñeca-anterior-izquierda" onclick="selectArea(event, 'muñeca-anterior-izquierda')"></div>
                        <div class="area" style="top: 200px; left: 395px; width: 25px; height: 25px;" data-zone="muñeca-anterior-derecha" onclick="selectArea(event, 'muñeca-anterior-derecha')"></div>

                        <!-- Posterior -->
                        <div class="area" style="top: 255px; left: 280px; width: 25px; height: 25px;" data-zone="posterior-derecho" onclick="selectArea(event, 'posterior-derecho')"></div>
                        <div class="area" style="top: 255px; left: 240px; width: 25px; height: 25px;" data-zone="posterior-izquierdo" onclick="selectArea(event, 'posterior-izquierdo')"></div>

                        <!-- Rodilla -->
                        <div class="area" style="top: 310px; left: 485px; width: 25px; height: 25px;" data-zone="rodilla-izquierda" onclick="selectArea(event, 'rodilla-izquierda')"></div>
                        <div class="area" style="top: 310px; left: 445px; width: 25px; height: 25px;" data-zone="rodilla-derecha" onclick="selectArea(event, 'rodilla-derecha')"></div>

                        <!-- Gemelo -->
                        <div class="area" style="top: 350px; left: 280px; width: 25px; height: 25px;" data-zone="gemelo-derecho" onclick="selectArea(event, 'gemelo-derecho')"></div>
                        <div class="area" style="top: 350px; left: 235px; width: 25px; height: 25px;" data-zone="gemelo-izquierdo" onclick="selectArea(event, 'gemelo-izquierdo')"></div>

                        <!-- Tobillo Posterior -->
                        <div class="area" style="top: 415px; left: 270px; width: 25px; height: 25px;" data-zone="tobillo-posterior-derecho" onclick="selectArea(event, 'tobillo-posterior-derecho')"></div>
                        <div class="area" style="top: 415px; left: 240px; width: 25px; height: 25px;" data-zone="tobillo-posterior-izquierdo" onclick="selectArea(event, 'tobillo-posterior-izquierdo')"></div>

                        <!-- Tobillo Frente -->
                        <div class="area" style="top: 405px; left: 485px; width: 25px; height: 25px;" data-zone="tobillo-anterior-izquierdo" onclick="selectArea(event, 'tobillo-anterior-izquierdo')"></div>
                        <div class="area" style="top: 405px; left: 450px; width: 25px; height: 25px;" data-zone="tobillo-anterior-derecho" onclick="selectArea(event, 'tobillo-anterior-derecho')"></div>


                        <div id="selected-zone-container" style="margin-top: 20px; display: none;">
                            <h3>Zona seleccionada: <span id="selected-zone"></span></h3>
                            <div id="zone-options">
                                <!-- Aquí se mostrarán las opciones específicas para la zona seleccionada -->
                                <label><input type="radio" name="zone-option" value="Interno">Dolor interno</label><br>
                                <label><input type="radio" name="zone-option" value="Externo">Dolor externo</label><br>
                                <label><input type="radio" name="zone-option" value="Ambos">Ambos</label>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="selectedAreas" id="selected-areas-input">
                    
                    <!-- Campo oculto para enviar las zonas seleccionadas al controlador -->
                    <div id="options-container"></div>

                    <!-- Botón de Crear -->
                    <button type="submit" onclick="submitForm()" class="btn btn-primary">Crear</button>
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

        let selectedAreas = [];
        console.log(selectedAreas);

        function selectArea(event, area) {
            event.preventDefault();
            const element = event.target;
            const index = selectedAreas.indexOf(area);

            if (index > -1) {
                // Eliminar el área del arreglo
                selectedAreas.splice(index, 1);
                element.classList.remove('selected');
                // Eliminar las opciones de Interno, Externo, Ambos correspondientes a esta zona
                document.getElementById(`${area}-options`).remove();
            } else {
                // Agregar el área al arreglo
                selectedAreas.push(area);
                element.classList.add('selected');
                // Crear y agregar las opciones de Interno, Externo, Ambos
                createOptions(area);
            }

            // Imprimir el arreglo actualizado en la consola
            console.log(selectedAreas);
        }

        function createOptions(area) {
            const optionsContainer = document.createElement('div');
            optionsContainer.id = `${area}-options`;
            optionsContainer.className = 'zone-options';

            optionsContainer.innerHTML = `
                <label>${area} - Selecciona opción:</label><br>
                <input type="radio" name="${area}-option" value="interno"> Interno<br>
                <input type="radio" name="${area}-option" value="externo"> Externo<br>
                <input type="radio" name="${area}-option" value="ambos"> Ambos<br>
            `;

            document.getElementById('options-container').appendChild(optionsContainer);
        }

        function submitForm() {
            // Convierte el arreglo en una cadena JSON
            const selectedAreasJson = JSON.stringify(selectedAreas);

            // Actualiza el campo oculto con la cadena JSON
            document.getElementById('selected-areas-input').value = selectedAreasJson;

            // Envía el formulario
            document.getElementById('areas-form').submit();
        }
    </script>
</x-app-layout>