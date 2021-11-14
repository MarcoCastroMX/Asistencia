@extends("layouts.mi-layout")
@section("contenido")
    <h1>Informacion de {{ $persona ->nombre }}</h1>
    <a href="{{ route("persona.index") }}">Listado de Personas</a>
    <ul>
        <ul>
            <li>{{ $persona->apellido_paterno }}</li>
            <li>{{ $persona->apellido_materno }}</li>
            <li>{{ $persona->identificador }}</li>
            <li>{{ $persona->telefono }}</li>
            <li>{{ $persona->correo }}</li>
        </ul>
    </ul>
    <hr>
    {{ $persona->user()->first()->name}}
    <hr>
    <a href="{{ route("persona.edit",$persona)}}">Editar</a>
    <hr>
    <form action="{{ route("persona.destroy",$persona) }}" method="POST">
        @csrf
        @method("DELETE")
        <input type="submit" value="Borrar">
    </form>
    <hr>
    <h3>Archivo:</h3>
    <h5>
        <a href="{{ route("descargar",$persona) }}">{{ $persona->archivo_original }}</a>
    </h5>
    
@endsection
