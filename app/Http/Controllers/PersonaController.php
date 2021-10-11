<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PersonaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $personas = Persona::all();
        return view("personas.personasIndex",compact("personas"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("personas.personasForm");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "nombre" => "required|string",
            "apellido_paterno" => "required|string",
            "apellido_materno" => "string|nullable",
            "identificador" => "required|alpha_num|unique:personas",
            "telefono" => "digits_between:8,10|nullable",
            "correo" => "required|email",
        ]);
        $request->merge([
            "user_id" => Auth::id(),
            "apellido_materno" => $request->apellido_materno ?? "",
            "telefono" => $request->telefono ?? ""
        ]);
        Persona::create($request->all());
        /*$persona = new Persona();
        $persona ->nombre = $request->nombre;
        $persona->apellido_paterno = $request->apellido_paterno;
        $persona->apellido_materno = $request->apellido_materno ?? "";
        $persona ->identificador = $request->identificador;
        $persona ->telefono = $request->telefono ?? "";
        $persona ->correo = $request->correo;
        $persona->save();*/
        return redirect()->route("persona.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Persona  $persona
     * @return \Illuminate\Http\Response
     */
    public function show(Persona $persona)
    {
        return view("personas.personasShow",compact("persona"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Persona  $persona
     * @return \Illuminate\Http\Response
     */
    public function edit(Persona $persona)
    {
        return view("personas.personasForm",compact("persona"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Persona  $persona
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Persona $persona)
    {
        $request->validate([
            "nombre" => "required|string",
            "apellido_paterno" => "required|string",
            "apellido_materno" => "string|nullable",
            "identificador" => [
                "required",
                "alpha_num",
                Rule::unique("personas")->ignore($persona->id),
            ],
            "telefono" => "digits_between:8,10|nullable",
            "correo" => "required|email",
        ]);
        $request->merge([
            "apellido_materno" => $request->apellido_materno ?? "",
            "telefono" => $request->telefono ?? ""
        ]);
        Persona::where("id",$persona ->id)->update($request->except("_token","_method"));
        /*
        $persona ->nombre = $request->nombre;
        $persona ->apellido_paterno = $request->apellido_paterno;
        $persona ->apellido_materno = $request->apellido_materno ?? "";
        $persona ->identificador = $request->identificador;
        $persona ->telefono = $request->telefono ?? "";
        $persona ->correo = $request->correo;
        $persona->save();*/
        return redirect()->route("persona.show",$persona);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Persona  $persona
     * @return \Illuminate\Http\Response
     */
    public function destroy(Persona $persona)
    {
        $persona->delete();
        return redirect()->route("persona.index");
    }
}
