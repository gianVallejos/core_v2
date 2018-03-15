<?php

namespace App\Http\Controllers;

// use Alert;
use App\Paciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PacienteController extends Controller
{
    private $path = 'paciente';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
      try{
        // $data = Paciente::all();
        $data = DB::table('pacientes')
                    ->orderBy('id', 'desc')
                    ->get();
        $numPacientes = Paciente::get()->count();

        $empresas = DB::table('empresas')
                      ->select('id', 'nombre')
                      ->get();

        // Alert::success('Success', 'Se han guardado los datos correctamente');
        // Alert::error('Ha ocurrido un error: ');

        return view($this->path.'.index', compact('data', 'numPacientes', 'empresas'));

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
        //Revisar que el DNI no sea duplicado
        $pac = DB::select('call getNumeroDniPaciente('. $request->dni .')');
        if( !empty($pac) ){
          alert()->error('El paciente ya existe. DNI Repetido', 'Error');
        }else{
          try{
              $paciente = new Paciente();
              $paciente->nombres = $request->nombres;
              $paciente->apellidos = $request->apellidos;
              $paciente->dni = $request->dni;
              $paciente->email = $request->email;
              $paciente->direccion = $request->direccion;
              $paciente->fechanacimiento = $request->fechanacimiento;
              $paciente->genero = $request->genero;
              $paciente->estado = $request->estado;
              $paciente->telefono = $request->telefono;
              $paciente->fax = $request->fax;
              $paciente->celular = $request->celular;
              $paciente->celular_aux = $request->celular_aux;
              $paciente->empresa_id = $request->empresa_id;
              $paciente->seguro_ind = $request->seguro_ind;
              $paciente->nombre_apoderado = $request->nombre_apoderado;
              $paciente->celular_apoderado = $request->celular_apoderado;
              $paciente->save();

              alert()->success('Paciente agregado correctamente', 'Agregado' );
          }catch(Exception $e){
              return "Fatal error - " . $e->getMessage();
          }
        }
        return redirect()->route('pacienteindex');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Paciente  $paciente
     * @return \Illuminate\Http\Response
     */
    public function show(Paciente $paciente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Paciente  $paciente
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $paciente = Paciente::findOrFail($id);

        $empresas = DB::table('empresas')
                      ->select('id', 'nombre')
                      ->get();

        return view($this->path.'.edit', compact('paciente', 'empresas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Paciente  $paciente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      if( !empty($pac) ){
        alert()->error('El paciente ya existe. DNI Repetido', 'Error');
      }else{
        $paciente = Paciente::findOrFail($id);
        $paciente->nombres = $request->nombres;
        $paciente->apellidos = $request->apellidos;
        $paciente->dni = $request->dni;
        $paciente->email = $request->email;
        $paciente->direccion = $request->direccion;
        $paciente->fechanacimiento = $request->fechanacimiento;
        $paciente->genero = $request->genero;
        $paciente->estado = $request->estado;
        $paciente->telefono = $request->telefono;
        $paciente->fax = $request->fax;
        $paciente->celular = $request->celular;
        $paciente->celular_aux = $request->celular_aux;
        $paciente->empresa_id = $request->empresa_id;
        $paciente->seguro_ind = $request->seguro_ind;
        $paciente->nombre_apoderado = $request->nombre_apoderado;
        $paciente->celular_apoderado = $request->celular_apoderado;
        $paciente->save();

        alert()->success('Paciente modificado correctamente', 'Modificado' );
      }
      return redirect()->route('pacienteindex');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Paciente  $paciente
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      try{
        $paciente = Paciente::findOrFail($id);
        $paciente->delete();
        $res = DB::select('ALTER TABLE pacientes auto_increment = 1');

        alert()->error('Paciente eliminado correctamente', 'Eliminado' );

        return redirect()->route('pacienteindex');
      }catch(Exception $e){
        return "Fatal error - ". $e->getMessage();
      }

    }
}
