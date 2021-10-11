<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Informacion de {{ $persona ->nombre }}</title>
</head>
<body>
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
</body>
</html>
