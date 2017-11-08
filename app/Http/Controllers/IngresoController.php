<?php

namespace App\Http\Controllers;

use App\Ingreso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class IngresoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->middleware('auth');
    }

    private $path = 'ingreso';
    public function index()
    {
        if(Auth::user()->rolid != 1){
            return view('home');
        }

        $ingresos = DB::select('call getAllIngresos()');
        $numIngresos = Ingreso::get()->count();

        $pacientes = DB::table('pacientes')
                              ->orderBy('id', 'desc')
                              ->get();
        $medicos = DB::table('medicos')
                        ->get();

        return view($this->path . '.index', compact('pacientes', 'medicos', 'ingresos', 'numIngresos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $ingreso = new Ingreso();
            $ingreso->idPaciente = $request->paciente_id;
            $ingreso->idMedico = $request->doctor_id;
            $ingreso->fecha = $request->fecha;
            $ingreso->tratamiento = $request->tratamiento;
            $ingreso->cantidad = $request->cantidad;
            $ingreso->monto = $request->monto;
            $ingreso->save();

            alert()->success('Ingreso agregado correctamente', 'Agregado');

            return redirect()->route('ingresoindex');
        }catch(Exception $e){
            return "Fatal error - " . $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ingreso  $ingreso
     * @return \Illuminate\Http\Response
     */
    public function show(Ingreso $ingreso)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ingreso  $ingreso
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ingresos = Ingreso::findOrFail($id);

        $pacientes = DB::table('pacientes')
                        ->select('id', 'nombres', 'apellidos')
                        ->get();

        $medicos = DB::table('medicos')
                        ->select('id', 'nombres', 'apellidos')
                        ->get();

        return view($this->path.'.edit', compact('ingresos', 'pacientes', 'medicos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ingreso  $ingreso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $ingreso = Ingreso::findOrFail($id);
        $ingreso->idPaciente = $request->paciente_id;
        $ingreso->idMedico = $request->doctor_id;
        $ingreso->descripcion = $request->descripcion;
        $ingreso->monto = $request->monto;
        $ingreso->save();

        alert()->success('Ingreso modificando correctamente', 'Modificado');

        return redirect()->route('ingresoindex');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ingreso  $ingreso
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ingreso $id)
    {
        try{
          $ingreso = Ingreso::findOrFail($id);
          $ingreso->delete();

          alert()->error('Ingreso eliminado correctamente', 'Eliminado' );

          return redirect()->route('ingresoindex');
        }catch(Exception $e){
          return "Fatal error - ". $e->getMessage();
        }
    }
}
