<?php

namespace App\Http\Controllers;

use App\Egreso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class EgresoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
       $this->middleware('auth');
    }

    private $path = 'egreso';
    public function index()
    {
        if(Auth::user()->rolid != 1){
            return view('home');
        }

        $egresos = DB::select('call getAllEgresos()');
        $numEgresos = Egreso::get()->count();

        return view($this->path . '.index', compact('egresos', 'numEgresos'));
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
            $egreso = new Egreso();
            $egreso->fecha = $request->fecha;
            $egreso->cantidad = $request->cantidad;
            $egreso->concepto = $request->concepto;
            $egreso->observacion = $request->observacion;
            $egreso->precio_unitario = $request->precio_unitario;
            $egreso->save();

            alert()->success('Egreso agregado correctamente', 'Agregado');

            return redirect()->route('egresoindex');
        }catch(Exception $e){
            return "Fatal error - " . $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Egreso  $egreso
     * @return \Illuminate\Http\Response
     */
    public function show(Egreso $egreso)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Egreso  $egreso
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $egresos = Egreso::findOrFail($id);

        return view($this->path.'.edit', compact('egresos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Egreso  $egreso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $egreso = Egreso::findOrFail($id);
      $egreso->fecha = $request->fecha;
      $egreso->cantidad = $request->cantidad;
      $egreso->concepto = $request->concepto;
      $egreso->observacion = $request->observacion;
      $egreso->precio_unitario = $request->precio_unitario;
      $egreso->save();

      alert()->success('Egreso modificando correctamente', 'Modificado');

      return redirect()->route('egresoindex');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Egreso  $egreso
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      try{
        $egreso = Egreso::findOrFail($id);
        $egreso->delete();

        alert()->error('Egreso eliminado correctamente', 'Eliminado' );

        return redirect()->route('egresoindex');
      }catch(Exception $e){
        return "Fatal error - ". $e->getMessage();
      }
    }
}
