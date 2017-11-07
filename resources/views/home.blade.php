@extends('layouts.default')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1" style="margin-top: 25px;">
            <div class="panel panel-default">
                <div class="panel-heading text-center title">NAVEGACIÓN</div>

                <div class="panel-body text-center">

                      <div class="home-block">
                        <a href="{{ 'presupuestos' }}">
                          <button class="btn-core-navegation">
                            <img src="{{ asset('images/Navegacion/presupuesto.png')}}" alt="presupuesto-core" width="130">
                            <br>PROFORMAS
                          </button>
                        </a>
                      </div>
                      <div class="home-block">
                        <a href="{{ 'precios' }}">
                          <button class="btn-core-navegation">
                            <img src="{{ asset('images/Navegacion/montos.png')}}" alt="montos-core" width="130">
                            <br>PRECIOS
                          </button>
                        </a>
                      </div>
                      <div class="home-block">
                        <a href="{{ 'tratamientos' }}">
                        <button class="btn-core-navegation">
                          <img src="{{ asset('images/Navegacion/tratamientos.png')}}" alt="tratamientos-core" width="130">
                          <br>TRATAMIENTOS
                        </button>
                        </a>
                      </div>
                      <div class="home-block">
                        <a href="{{ 'empresas' }}">
                        <button class="btn-core-navegation">
                          <img src="{{ asset('images/Navegacion/logistica.png')}}" alt="empresas-core" width="130">
                          <br>EMPRESAS
                        </button>
                        </a>
                      </div>

                      <div class="home-block">
                        <a href="{{ 'medicos' }}">
                          <button class="btn-core-navegation">
                            <img src="{{ asset('images/Navegacion/colaboradores.png')}}" alt="doctores-core" width="130">
                            <br>DOCTORES
                          </button>
                        </a>
                      </div>
                      <div class="home-block">
                        <a href="{{ 'pacientes' }}">
                        <button class="btn-core-navegation">
                          <img src="{{ asset('images/Navegacion/pacientes.png')}}" alt="pacientes-core" width="130">
                          <br>PACIENTES
                        </button>
                        </a>
                      </div>
                      <div class="home-block">
                        <a href="{{ 'proveedors' }}">
                          <button class="btn-core-navegation">
                            <img src="{{ asset('images/Navegacion/proveedores.png')}}" alt="provedores-core" width="130">
                            <br>PROV - LABS
                          </button>
                        </a>
                      </div>
                      <div class="home-block">
                        <a href="{{ 'agendas' }}">
                        <button class="btn-core-navegation">
                          <img src="{{ asset('images/Navegacion/asistencias.png')}}" alt="asistencias-core" width="130">
                          <br>AGENDAS
                        </button>
                        </a>
                    </div



                </div>
            </div>
        </div>
    </div>
</div>

@endsection
