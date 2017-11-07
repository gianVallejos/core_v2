<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Empresa;
use App\Tratamiento;
use App\Precio;

class PrecioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $path = 'precio';

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {

        $empresas = DB::table('empresas')
                      ->select('id', 'nombre')
                      ->get();

        $montos = DB::table('precios')
                     ->join('tratamientos', 'tratamientos.id', '=', 'precios.idTratamiento')
                     ->join('empresas', 'empresas.id', '=', 'precios.idEmpresa')
                     ->select('precios.*', 'tratamientos.id as tid', 'tratamientos.detalle as tdetalle',
                              'empresas.id as eid', 'empresas.nombre as enombre'
                              )
                     ->where('precios.idEmpresa', '=', '1')
                     ->get();

        return view($this->path . '.index', ['empresas' => $empresas, 'montos' => $montos]);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
