<?php

namespace App\Http\Controllers;

use App\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $path = 'proveedor';
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $proveedor = DB::table('proveedors')
                        ->get();
        $numProveedores = Proveedor::get()->count();
        $insumos = array('Materiales', 'Equipos', 'Instrumentos', 'Otros');
        $tipo = array('Proveedor', 'Laboratorio', 'Otros'); //0: Proveedor, 1: Laboratorio

        return view($this->path . '.index', compact('proveedor', 'numProveedores', 'insumos', 'tipo'));
    }

    public function insumos(){
      
        return view($this->path . '.insumos');
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
          $proveedor = new Proveedor();
          $proveedor->nombres = $request->nombres;
          $proveedor->email = $request->email;
          $proveedor->direccion = $request->direccion;
          $proveedor->dni = $request->dni;
          $proveedor->ruc = $request->ruc;
          $proveedor->telefono = $request->telefono;
          $proveedor->celular = $request->celular;
          $proveedor->insumo_id = $request->insumo_id;
          $proveedor->tipo_id = $request->tipo_id;
          $proveedor->banco = $request->banco;
          $proveedor->nrocuenta = $request->nrocuenta;
          $proveedor->save();

          alert()->success('Proveedor agregado correctamente', 'Agregado' );
          return redirect()->route('proveedorindex');
      }catch(Exception $e){
          return "Fatal error - " . $e->getMessage();
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function show(Proveedor $proveedor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $proveedor = Proveedor::findOrFail($id);

        return view($this->path.'.edit', compact('proveedor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $proveedor = Proveedor::findOrFail($id);
        $proveedor->nombres = $request->nombres;
        $proveedor->email = $request->email;
        $proveedor->direccion = $request->direccion;
        $proveedor->dni = $request->dni;
        $proveedor->ruc = $request->ruc;
        $proveedor->telefono = $request->telefono;
        $proveedor->celular = $request->celular;
        $proveedor->insumo_id = $request->insumo_id;
        $proveedor->tipo_id = $request->tipo_id;
        $proveedor->banco = $request->banco;
        $proveedor->nrocuenta = $request->nrocuenta;
        $proveedor->save();

        alert()->success('Proveedor modificado correctamente', 'Modificado' );

        return redirect()->route('proveedorindex');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
          $proveedor = Proveedor::findOrFail($id);
          $proveedor->delete();

          alert()->error('Proveedor eliminado correctamente', 'Eliminado' );

          return redirect()->route('proveedorindex');
        }catch(Exception $e){
          return "Fatal error - ". $e->getMessage();
        }
    }
}
