<?php

namespace App\Http\Controllers;

use App\Medico;
use Illuminate\Http\Request;

class MedicoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $path = 'medico';

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        try{
          $data = Medico::all();
          $numMedicos = Medico::get()->count();

          // Alert::success('Success', 'Se han guardado los datos correctamente');
          // Alert::error('Ha ocurrido un error: ');

          return view($this->path.'.index', compact('data', 'numMedicos'));

        }catch(Exception $e){
            alert()->error('Ha ocurrido un error: ' . $e->getMessage(), 'Error' );
        }
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
            $medico = new Medico();
            $medico->nombres = $request->nombres;
            $medico->apellidos = $request->apellidos;
            $medico->dni = $request->dni;
            $medico->email = $request->email;
            $medico->direccion = $request->direccion;
            $medico->fechanacimiento = $request->fechanacimiento;
            $medico->genero = $request->genero;
            $medico->estado = $request->estado;
            $medico->margen_ganancia = $request->margen_ganancia;
            $medico->telefono = $request->telefono;
            $medico->celular = $request->celular;
            $medico->celular_aux = $request->celular_aux;
            $medico->save();

            alert()->success('Doctor agregado correctamente', 'Agregado' );
            return redirect()->route('medicoindex');
        }catch(Exception $e){
            return "Fatal error - " . $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Medico  $medico
     * @return \Illuminate\Http\Response
     */
    public function show(Medico $medico)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Medico  $medico
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $medico = Medico::findOrFail($id);
        return view($this->path.'.edit', compact('medico'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Medico  $medico
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $medico = Medico::findOrFail($id);
        $medico->nombres = $request->nombres;
        $medico->apellidos = $request->apellidos;
        $medico->dni = $request->dni;
        $medico->email = $request->email;
        $medico->direccion = $request->direccion;
        $medico->fechanacimiento = $request->fechanacimiento;
        $medico->genero = $request->genero;
        $medico->estado = $request->estado;
        $medico->margen_ganancia = $request->margen_ganancia;
        $medico->telefono = $request->telefono;
        $medico->celular = $request->celular;
        $medico->celular_aux = $request->celular_aux;
        $medico->save();

        alert()->success('Doctor modificado correctamente', 'Modificado' );

        return redirect()->route('medicoindex');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Medico  $medico
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
          $medico = Medico::findOrFail($id);
          $medico->delete();

          alert()->error('Doctor eliminado correctamente', 'Eliminado' );

          return redirect()->route('medicoindex');
        }catch(Exception $e){
          return "Fatal error - ". $e->getMessage();
        }
    }
}
