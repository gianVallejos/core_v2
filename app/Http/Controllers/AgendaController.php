<?php

namespace App\Http\Controllers;

use App\Agenda;
use App\Paciente;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AgendaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $path = 'agenda';
    public function index()
    {
        $doctores = DB::select('call obtenerTodosMedicos()');
        $data = Paciente::all();
        $idUser = Auth::user()->id;
        $agendas = json_encode(DB::select('call obtenerCitas(' . $idUser .')'));

        $citas = DB::table('agendas')
                      ->join('medicos', 'medicos.id', '=', 'agendas.idDoctor')
                      ->select('agendas.*', 'medicos.nombres', 'medicos.apellidos')
                      ->orderby('agendas.desde', 'desc')
                      ->get();

        return view($this->path . '.index', compact('doctores', 'agendas', 'data', 'citas'));
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
     * @param  \App\Agenda  $agenda
     * @return \Illuminate\Http\Response
     */
    public function show(Agenda $agenda)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Agenda  $agenda
     * @return \Illuminate\Http\Response
     */
    public function edit(Agenda $agenda)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Agenda  $agenda
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Agenda $agenda)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Agenda  $agenda
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $citas = Agenda::findOrFail($id);
            $citas->delete();

            alert()->error('Cita eliminada correctamente', 'Eliminado');

            return redirect()->route('agendaindex');

        }catch(Exception $e){
            return "Fatal error - " . $e->getMessage();
        }
    }
}
