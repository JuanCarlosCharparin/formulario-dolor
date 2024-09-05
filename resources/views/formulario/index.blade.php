<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Formulario') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Container for the form and table -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <!-- Formulario de búsqueda -->
                <form method="GET" action=" /*route('formularios.index') */" class="mb-4">
                    <input type="hidden" name="page" value="{{ request()->input('page') }}">

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                        <input type="text" name="search_id" value="{{ request()->input('search_id') }}" class="form-input rounded-md shadow-sm" placeholder="Buscar ID">

                        <input type="text" name="search_paciente_salutte_id" value="{{ request()->input('search_paciente_salutte_id') }}" class="form-input rounded-md shadow-sm" placeholder="Buscar Paciente ID">

                        <input type="date" name="search_fecha_carga" value="{{ request()->input('search_fecha_carga') }}" class="form-input rounded-md shadow-sm" placeholder="Buscar Fecha de Carga">
                    </div>

                    <div class="flex items-center mt-4">
                        <button class="btn btn-primary rounded" type="submit">Buscar</button>

                        <!-- Botón de Crear -->
                        <a href="{{ route('formulario.create') }}" class="btn btn-secondary ms-4">Crear Nuevo Formulario</a>
                    </div>
                </form>

                <!-- Mensajes de éxito y error -->
                @if (session('success'))
                    <div class="alert alert-success mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                <p class="text-gray-900 dark:text-gray-100 mb-4">Total de registros: {{ $formularios->count() }}</p>

                <!-- Tabla de formularios -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-700">
                                <th>ID</th>
                                <th>Paciente</th>
                                <th>Fecha Carga</th>
                                <th>Derivado Por</th>
                                <th>Inicio</th>
                                <th>Duración</th>
                                <th>Puntuación ECN</th>
                                <th>Intensidad</th>
                                <th>Dolor</th>
                                <th>Tipo Dolor</th>
                                <th>Localizaciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($formularios as $formulario)
                                @php
                                    // Obtener el paciente correspondiente usando el ID del formulario
                                    $paciente = $pacientesMap->get($formulario->paciente_salutte_id);
                                @endphp

                                <tr class="bg-white dark:bg-gray-800">
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $formulario->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($paciente)
                                            {{ $paciente->nombres . ' ' . $paciente->apellidos }}
                                        @else
                                            Paciente no encontrado
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $formulario->fecha_carga }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $formulario->derivado_por }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $formulario->inicio }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $formulario->duracion }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $formulario->puntuacion_ecn }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $formulario->intensidad->nombre ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $formulario->dolor->nombre ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $formulario->tipoDolor->nombre ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @foreach($formulario->localizaciones as $localizacion)
                                            <div>{{ $localizacion->zona }} - {{ $localizacion->localizacion }}</div>
                                        @endforeach
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>