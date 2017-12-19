<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WsCoreController extends Controller
{
    private $path = 'wscore';

    public function index(){

    }

    public function updatePrecios($idEmpresa, $idTratamiento, $monto, $token){
        $estado = DB::select('CALL updatePrecios('.$idEmpresa.', '.$idTratamiento.', '. $monto .', "'. $token .'")');
        $json = json_encode($estado);
        return response()->json(['estado' => $json]);
    }

    public function getMontoByEmpresaTratamiento($idEmpresa, $idTratamiento){
        $monto = DB::select('CALL getMontoByEmpresaTratamiento('.$idEmpresa.', '.$idTratamiento.')');
        $json = json_encode($monto);
        // return (['monto' => $json]);
        return response()->json(['monto' => $json]);
    }

    public function saveNuevoPresupuesto(Request $request){
        $estado = 0;

        $fechahora = $request->input('fechahora');
        $idPaciente = $request->input('idPaciente');
        $idDoctor = $request->input('idDoctor');
        $nroPresupuesto = $request->input('nroPresupuesto');
        $descuento = $request->input('descuento');
        $tratamientos = json_decode($request->input('tratamientos'));

        // Add Presupuesto General
        if( $nroPresupuesto == 0 ){ $nroPresupuesto++; }

        $epg = DB::select('call agregarPresupuestoGeneral('. $nroPresupuesto .', "' . $fechahora .'", '. $idPaciente .', ' . $idDoctor .', ' . $descuento . ')');

        foreach( $tratamientos as $rt ){
            $sec1 = ( isset($rt[2]) ) ? $rt[2] : '0';
            $sec2 = ( isset($rt[3]) ) ? $rt[3] : '0';
            $epd = DB::select('call agregarPresupuestosDetalles('. $nroPresupuesto .', ' . $rt[0] . ', ' . $rt[1] . ', ' . $sec1 . ', ' . $sec2 .', '. $rt[4] .')');
        }


        return response()->json(['epg' => $epg, 'epd' => $epd]);
    }

    public function agregarCita(Request $request){
        $hc = $request->input('hc');
        $paciente = $request->input('paciente');
        $celular = $request->input('celular');
        $doctor = $request->input('doctor');
        $tratamiento = $request->input('tratamiento');
        $dia = $request->input('dia');
        $desde = $request->input('desde');
        $hasta = $request->input('hasta');

        $fecha = $dia;
        // echo $fecha; die();
        //
        // $fecha = substr($dia, 6, 4) . '-' . substr($dia, 0, 2) . '-' . substr($dia, 3, 2);

        $from = $fecha . 'T' . $desde;
        $to = $fecha . 'T' . $hasta;

        $ac = DB::select('call agregarCita("'. $hc .'", "'. $paciente .'", "'. $from . '", "'. $to .'", "' . $celular . '", '. $doctor .', "'. $tratamiento .'")');

        // alert()->error('Ha ocurrido un error al clonar. Avisar al webmaster', 'ERROR' );

        print(json_encode($ac));
        // return response()->json(['ac' => $ac]);
    }

    public function obtenerCitasById($idUser){
        $agendas = DB::select('call obtenerCitas(' . $idUser .')');
        print(json_encode($agendas));
    }

    public function obtenerDetalleProveedor($idProveedor){
        $detalleProveedor = DB::select('call getDetalleProveedor('. $idProveedor .')');
        print(json_encode($detalleProveedor));
    }

    public function agregarDetalleProveedor(Request $request){
        $idProveedor = $request->input('id');
        $detalles = $request->input('detalles');
        $monto = $request->input('monto');

        $res = DB::select('call agregarDetalleProveedor('. $idProveedor. ', "'. $detalles .'", '. $monto .')');

        print(json_encode($res));
    }

    public function eliminarDetalleProveedor($idDProveedor){
        $res = DB::select('call eliminarDetalleProveedor('. $idDProveedor .')');

        print(json_encode($res));
    }

    public function buscarIngresos(Request $request){
        $date_inicio = $request->input('date_inicio');
        $date_fin = $request->input('date_fin');
        $doctor_id = $request->input('doctor_id');

        if( $doctor_id != -1 ){
          $res = DB::select('call getSearchIngresoById("'. $date_inicio .'", "'. $date_fin . '", ' . $doctor_id .')');
        }else{
          $res = DB::select('call getSearchIngresoAll("'. $date_inicio .'", "'. $date_fin .'")');
        }

        print(json_encode($res));
    }

    public function editarCita(Request $request){
        $idAgenda = $request->input('idAgenda');
        $hc = $request->input('hc');
        $paciente = $request->input('paciente');
        $celular = $request->input('celular');
        $fecha = $request->input('dia');
        $desde = $request->input('desde');
        $hasta = $request->input('hasta');
        $idDoctor = $request->input('idDoctor');
        $tratamiento = $request->input('tratamiento');

        $from = $fecha . 'T' . $desde;
        $to = $fecha . 'T' . $hasta;

        $sql = 'call editarCitaById('. $idAgenda .', '. $hc .', "'. $paciente .'", "'. $celular . '", "'. $from .'", "' . $to . '", '. $idDoctor .', "'. $tratamiento .'")';

        $ac = DB::select($sql);

        print(json_encode($ac));
    }

    public function obtenerTodasCitas(Request $request){
      $agendas = DB::select('call obtenerTodasCitas()');
      print(json_encode($agendas));
    }
}
