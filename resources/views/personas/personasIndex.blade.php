@extends("layouts.mi-layout")
@section("contenido")
    <h1>Listado de Personas</h1>
    <p>
        <a href="{{ route('notificar')}}">Enviar Notificacion</a>
    </p>
    <p>
        @can('create',App\Models\Persona::class)
            <a href="{{ route('persona.create') }}">Crear Persona</a>
        @elsecan('create',App\Models\Persona::class)
            No puede crear persona
        @endcan
    </p>
    <table border ="1">
        <thead>
            <tr>
                <th>Area</th>
                <th>ID</th>
                <th>Usuario Creado</th>
                <th>Nombre</th>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
                <th>Código</th>
                <th>Correo</th>
                <th>Telefono</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($personas as $persona)
                <tr>
                    <td>
                        <ul>
                            @foreach ($persona->areas as $area)
                                <li>{{ $area->nombre_area }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                       <a href="{{ route("persona.show",$persona->id) }}">{{ $persona->id}}</a>
                    </td>
                    <td>{{ $persona->user->name }}({{ $persona->user->email }})</td>
                    <td>{{ $persona->nombre}}</td>
                    <td>{{ $persona->apellido_paterno}}</td>
                    <td>{{ $persona->apellido_materno}}</td>
                    <td>{{ $persona->identificador}}</td>
                    <td>{{ $persona->correo}}</td>
                    <td>{{ $persona->telefono}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
