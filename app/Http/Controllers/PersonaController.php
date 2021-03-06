<?php

namespace App\Http\Controllers;

use App\Mail\Notificacion;
use App\Models\Area;
use App\Models\Persona;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class PersonaController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth")->except('index','show');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$personas = Persona::where("user_id",Auth::id())->get();
        //$personas = Auth::user()->personas;
        //$personas = Persona::all();
        $personas = Persona::with("areas")->get();
        return view("personas.personasIndex",compact("personas"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create',Persona::class);
        $areas = Area::all();
        return view("personas.personasForm",compact("areas"));
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

        //$archivo = $request ->file('archivo');

        $ruta = $request->archivo->store("imagenes");
        $mime = $request->archivo->getClientMimeType();
        $nombre_original = $request->archivo->getClientOriginalName();

        /*$request->merge([
            "apellido_materno" => $request->apellido_materno ?? "",
            "telefono" => $request->telefono ?? ""
        ]);
        $persona = new Persona($request->all());
        Auth::user()->personas()->save($persona);
        */
        $request->merge([
            "archivo_original" => $nombre_original,
            "archivo_ruta" => $ruta,
            "mime" => $mime,
            "user_id" => Auth::id(),
            "apellido_materno" => $request->apellido_materno ?? "",
            "telefono" => $request->telefono ?? ""
        ]);
        $persona = Persona::create($request->all());
        $persona->areas()->attach($request->area_id);
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
        $areas = Area::all();
        return view("personas.personasForm",compact("persona","areas"));
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
        Persona::where("id",$persona ->id)->update($request->except("_token","_method","area_id"));
        $persona->areas()->sync($request->area_id);
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
        if (Gate::denies('eliminar-persona',$persona)){
            abort(403);
        }

        $persona->delete();
        return redirect()->route("persona.index");
    }

    public function notificar(){
        Mail::to(\Auth::user()->email)->send(new Notificacion());
        return redirect()->back();
    }

    public function descargarArchivo(Persona $persona){
        $headers = ['Content-Type' => $persona->mime];
        return Storage::download($persona->archivo_ruta, $persona->archivo_original, $headers);
    }
}
