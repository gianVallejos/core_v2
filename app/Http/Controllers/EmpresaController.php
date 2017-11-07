<?php

namespace App\Http\Controllers;

use App\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $path = 'empresa';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
      $data = Empresa::all();
      $numEmpresas = Empresa::get()->count();

      return view($this->path . '.index', ['data' => $data, 'numEmpresas' => $numEmpresas]);
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
            $empresas = new Empresa();
            $empresas->nombre = $request->nombre;
            $empresas->ruc = $request->ruc;
            $empresas->save();

            DB::beginTransaction();
            $idEmpresa = DB::select('call obtenerUltimoIdEmpresa()');
            $default_precios = DB::table('precios')
                                  ->where('idEmpresa', '=', '1')
                                  ->select('idTratamiento', 'monto')
                                  ->get();

            if( $this->clonarTratamientosEmpresa($default_precios, $idEmpresa[0]->ID_EMPRESA) ){
                alert()->success('Empresa agregada correctamente', 'Agregado' );
                DB::commit();
                return redirect()->route('empresaindex');
            }else{
                DB::rollback();
                alert()->error('Ha ocurrido un error al clonar. Avisar al webmaster', 'ERROR' );
                return "Fatal Error - Avisar al Webmaster";
            }
        }catch(Exception $e){
            return "Fatal error - " . $e->getMessage();
        }
    }

    private function clonarTratamientosEmpresa($default_precios, $idEmpresa){
        foreach( $default_precios as $trat ){
            $estado = DB::select('call clonarTratamientosPorEmpresas('. $idEmpresa.', '. $trat->idTratamiento .', '. $trat->monto .')');
            if( $estado == 0 ) return false;
        }
        return true;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function show(Empresa $empresa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $empresa = Empresa::findOrFail($id);

        return view($this->path.'.edit', ['empresa' => $empresa]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $empresa = Empresa::findOrFail($id);
        $empresa->nombre = $request->nombre;
        $empresa->ruc = $request->ruc;
        $empresa->save();

        alert()->success('Empresa modificada correctamente', 'Modificado' );

        return redirect()->route('empresaindex');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
          $empresa = Empresa::findOrFail($id);
          $empresa->delete();

          DB::select('call deletePrecioByEmpresaId('. $id .')');

          alert()->error('Empresa eliminado correctamente', 'Eliminado' );

          return redirect()->route('empresaindex');
        }catch(Exception $e){
          return "Fatal error - ". $e->getMessage();
        }
    }
}
