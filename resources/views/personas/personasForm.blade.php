<x-mi-layout>
    <h1>Formulario para {{ isset($persona) ? "Editar" : "Crear" }} Personas</h1>
    @if(isset($persona))
        <form action="{{ route("persona.update",$persona) }}" method="POST">
        @method("PATCH")
    @else
        <form action="{{route("persona.store")}}" method="POST" enctype="multipart/form-data">
    @endif
        @csrf
        <label for="nombre">Nombre</label><br>
        <input type="text" name="nombre" required value="{{ $persona->nombre ?? "" }}">
        <br>
        <label for="apellido_paterno">Apellido Paterno</label><br>
        <input type="text" name="apellido_paterno" required value="{{ $persona->apellido_paterno ?? "" }}">
        <br>
        <label for="apellido_materno">Apellido Materno</label><br>
        <input type="text" name="apellido_materno" value="{{ $persona->apellido_materno ?? "" }}">
        <br>
        <label for="identificador">Identificador</label><br>
        <input type="text" name="identificador" required value="{{ $persona->identificador ?? "" }}">
        <br>
        <label for="telefono">Telefono</label><br>
        <input type="text" name="telefono" id="telefono" value="{{ $persona->telefono ?? "" }}">
        <br>
        <label for="correo">Correo</label><br>
        <input type="text" name="correo" id="correo" required value="{{ $persona->correo ?? "" }}">
        <br>
        <label for="area_id">Area:</label>
        <select name="area_id[]" id="area_id" multiple>
            @foreach ($areas as $area)
                <option value="{{ $area->id }}" {{ isset($persona) && array_search($area->id,$persona->areas->pluck('id')->toArray())== false ? 'selected': ''}}>
                    {{ $area->nombre_area }}
                </option>
            @endforeach
        </select>
        <br>
        <input type="file" name="archivo">
        <br>
        <input type="submit" value="Enviar">
    </form>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
</x-mi-layout>
