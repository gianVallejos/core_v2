<?php

namespace App\Http\Controllers;

use App\Tratamiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TratamientoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $path = 'tratamiento';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = Tratamiento::all();
        $numTratamientos = Tratamiento::get()->count();

        return view($this->path . '.index', ['data' => $data, 'numTratamientos' => $numTratamientos]);
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
            $tratamientos = new Tratamiento();
            $tratamientos->detalle = $request->detalle;
            $tratamientos->save();

            $monto = $request->monto;

            DB::beginTransaction();
            $idTratamiento = DB::select('call obtenerUltimoIdTratamiento()');
            $empresas = DB::table('empresas')
                            ->select('id')
                            ->get();

            if( $this->clonarEmpresaTratamientos($empresas, $idTratamiento[0]->ID_TRATAMIENTO, $monto) ){
                alert()->success('Tratamiento agregado correctamente', 'Agregado' );
                DB::commit();
                return redirect()->route('tratamientoindex');
            }else{
                DB::rollback();
                alert()->error('Ha ocurrido un error al clonar. Avisar al webmaster', 'ERROR' );
                return "Fatal Error - Avisar al Webmaster";
            }

        }catch(Exception $e){
            return "Fatal error - " . $e->getMessage();
        }
    }

    private function clonarEmpresaTratamientos($empresas, $idTratamiento, $monto){
        // print_r($empresas); die();
        foreach( $empresas as $emp ){
            $estado = DB::select('call clonarTratamientosPorEmpresas('. $emp->id.', '. $idTratamiento .', '. $monto . ')');
            if( $estado == 0 ) return false;
        }
        return true;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tratamiento  $tratamiento
     * @return \Illuminate\Http\Response
     */
    public function show(Tratamiento $tratamiento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tratamiento  $tratamiento
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tratamiento = Tratamiento::findOrFail($id);

        return view($this->path.'.edit', ['tratamiento' => $tratamiento]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tratamiento  $tratamiento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tratamiento = Tratamiento::findOrFail($id);
        $tratamiento->detalle = $request->detalle;
        $tratamiento->save();

        alert()->success('Tratamiento modificado correctamente', 'Modificado' );

        return redirect()->route('tratamientoindex');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tratamiento  $tratamiento
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
          $tratamiento = Tratamiento::findOrFail($id);
          $tratamiento->delete();

          DB::select('call deletePrecioByTratamientoId('. $id .')');

          alert()->error('Tratamiento eliminado correctamente', 'Eliminado' );

          return redirect()->route('tratamientoindex');
        }catch(Exception $e){
          return "Fatal error - ". $e->getMessage();
        }
    }
}
