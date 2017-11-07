<?php

namespace App\Http\Controllers;

use App\Presupuesto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Medico;
use App\Paciente;

class PresupuestoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $path = 'presupuesto';
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $medicos = DB::table('medicos')
                       ->select('id', 'nombres', 'apellidos')
                       ->get();

        $pacientes = DB::table('pacientes')
                        ->select('id', 'nombres', 'apellidos')
                        ->get();

        $presupuestos = DB::table('presupuestos')
                          ->join('pacientes', 'presupuestos.idPaciente', '=', 'pacientes.id')
                          ->join('medicos', 'presupuestos.idMedico', '=', 'medicos.id')
                          // ->select('presupuestos.id', 'fechahora', 'idPaciente', 'idMedico', 'descuento')
                          ->select('presupuestos.*', 'pacientes.id as hc', 'pacientes.nombres as pnombres', 
                                   'pacientes.apellidos as papellidos',
                                   'medicos.nombres as mnombres', 'medicos.apellidos as mapellidos')
                          ->orderBy('presupuestos.id', 'desc')
                          ->get();

        return view($this->path . '.index', ['medicos' => $medicos, 'pacientes' => $pacientes, 'presupuestos' => $presupuestos]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($idDoctor, $idPaciente, $nroPresupuesto = null)
    {
        try{
            $doctor = DB::table('medicos')
                        ->select('id as mid', 'nombres as mnombres', 'apellidos as mapellidos', 'margen_ganancia')
                        ->where('id', '=', $idDoctor)
                        ->get();

            $paciente = DB::table('pacientes')
                        ->join('empresas', 'pacientes.empresa_id', '=', 'empresas.id')
                        ->select('pacientes.id as did', 'nombres as pnombres', 'apellidos as papellidos', 'empresas.nombre as enombre', 'pacientes.empresa_id as idEmpresa')
                        ->where('pacientes.id', '=', $idPaciente)
                        ->get();



            $idEmpresa = $paciente[0]->idEmpresa;
            // $precios = DB::select('call getPreciosByIdEmpresa('. $idEmpresa . ')');
            $precios = DB::select('select * from precios as emprc
                                   inner join empresas as emp on emp.id = emprc.idEmpresa
                                   inner join tratamientos as tratamientos on tratamientos.id = emprc.idTratamiento
                                   where emp.id = ' . $idEmpresa . ' order by (idTratamiento)');

              if( !isset($nroPresupuesto) ){
                  $nroPresupuesto = DB::select('call getLastNroPresupuesto()');

                  if( isset($nroPresupuesto) ){
                    $nroPresupuesto = $nroPresupuesto[0]->NRO_PRESUPUESTO + 1;
                  }
                  $modificar = 0;

                  return view($this->path . '.create', [ 'doctor' => $doctor, 'paciente' => $paciente,
                                                         'nroPresupuesto' => $nroPresupuesto,
                                                         'precios' => $precios, 'modificar' => $modificar ]);

              }else{
                  $pres = DB::table('presupuestos')
                             ->where('id', '=', $nroPresupuesto)
                             ->get();

                  $fechahora = $pres[0]->fechahora;
                  $descuento = $pres[0]->descuento;

                  $detalle_presupuesto = DB::select('call getDetallePresupuesto('. $nroPresupuesto .')');

                  // print_r($detalle_presupuesto);
                  $nroTratamientos = 0;
                  $tratamientos = array();
                  foreach( $detalle_presupuesto as $dp ){
                      $tratamientos[$nroTratamientos][0] = $dp->pieza;
                      $tratamientos[$nroTratamientos][1] = $dp->seccion;
                      if( $dp->secUno != '0' ){
                          $tratamientos[$nroTratamientos][2] = $dp->secUno;
                      }
                      if( $dp->secDos != '0' ){
                          $tratamientos[$nroTratamientos][3] = $dp->secDos;
                      }
                      $tratamientos[$nroTratamientos][4] = $dp->opcion;
                      $nroTratamientos++;
                  }



                  $modificar = 1;

                  return view( $this->path . '.create', ['doctor' => $doctor, 'paciente' => $paciente,
                                                         'nroPresupuesto' => $nroPresupuesto, 'precios' => $precios,
                                                         'precios' => $precios, 'modificar' => $modificar,
                                                         'fechahora' => $fechahora, 'descuento' => $descuento,
                                                         'tratamientos' => $tratamientos, 'nroTratamientos' => $nroTratamientos
                                                       ]);
              }
        }catch(Exception $e){
            alert()->error('Ha ocurrido un error: ' . $e->getMessage(), 'Error' );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Presupuesto  $presupuesto
     * @return \Illuminate\Http\Response
     */
    public function show(Presupuesto $presupuesto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Presupuesto  $presupuesto
     * @return \Illuminate\Http\Response
     */
    public function edit(Presupuesto $presupuesto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Presupuesto  $presupuesto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Presupuesto $presupuesto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Presupuesto  $presupuesto
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{

          DB::select('call deletePresupuestoById('. $id .')');

          alert()->error('Presupuesto eliminado correctamente', 'Eliminado' );

          return redirect()->route('presupuestoindex');
        }catch(Exception $e){
          return "Fatal error - ". $e->getMessage();
        }
    }
}
