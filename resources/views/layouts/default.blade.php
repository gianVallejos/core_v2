<!---------------------------------------------------------------------->
<!--                    Proyecto CORE v.2.0.                          -->
<!--                    Laravel 5.4.                                  -->
<!--                    Author: Gian P. Vallejos                      -->
<!--                    Jul. 2017                                     -->
<!---------------------------------------------------------------------->

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>CORE: Centro Odontologico de Rehabilitación y Estética</title>

    <link rel="icon" href="/core_v2/images/favicon.ico">

    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/css/bootstrap.min.css"> -->

    <!-- Styles -->
    <link href="{{ asset('css/app.css?v=1.0.0') }}" rel="stylesheet">
    <link href="{{ asset('css/core.css?v=2.0.27') }}" rel="stylesheet">
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
    <link href="{{ asset('css/table.css?v=1.0.1') }}" rel="stylesheet">
    <link href="{{ asset('sweetalert/sweetalert.css') }}" rel="stylesheet">

    <link rel="stylesheet" type="text/css" media="print" href="{{ asset('css/print.css?v=1.0.3') }}">

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <!-- Full Calendar -->
    <link href="{{ asset('css/fullcalendar/fullcalendar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fullcalendar/fullcalendar.print.css') }}" rel="print">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato|Poppins" rel="stylesheet">
</head>
<body>
<div id="app">

  <div id="loader" class="loader">
    <div class="loader-img"></div>
  </div>

    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">
            @if ( !Auth::guest() )
                <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                            data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
            @endif
            <!-- Branding Image -->
                <a class="navbar-brand" href="/core_v2/home">
                    <img src="{{ asset('images/logo-core-01.png')}}">
                </a>
            </div>
            @if( !Auth::guest() )
                <ul class="nav navbar-nav">
                    <li><a href="/core_v2/home">Principal</a></li>
                </ul>

                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Presupuestos
                            <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="/core_v2/{{ 'presupuestos' }}">Proforma</a></li>
                            <li><a href="/core_v2/{{ 'precios' }}">Precios</a></li>
                            <li><a href="/core_v2/{{ 'tratamientos' }}">Tratamientos</a></li>
                            <li><a href="/core_v2/{{ 'empresas' }}">Empresas</a></li>
                        </ul>
                    </li>
                </ul>

                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">RRHH
                            <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="/core_v2/{{ 'medicos' }}">Doctores</a></li>
                            <li><a href="/core_v2/{{ 'pacientes' }}">Pacientes</a></li>
                        <!-- <li><a href="/{{ 'users' }}">Usuarios</a></li> -->
                        </ul>
                    </li>
                </ul>
                @if(Auth::user()->rolid == 1)
                    <ul class="nav navbar-nav">
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Pagos
                                <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="/core_v2/{{ 'ingresos' }}">Ingresos</a></li>
                            </ul>

                        </li>
                    </ul>
                @endif

                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Operaciones
                            <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="/core_v2/{{ 'proveedors' }}">Proveedores/Laboratorios</a></li>
                            <li><a href="/core_v2/{{ 'agendas' }}">Agenda</a></li>
                            <!-- <li><a href="#">Asistencia</a></li> -->
                        </ul>
                    </li>
                </ul>

            @endif

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    &nbsp;
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ route('login') }}">Ingresar</a></li>
                    @else
                    <li>
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                            <img src="{{ asset('images/icons/logout.svg')}}" width="25" style="margin-right: 7px;" />Cerrar Sesión
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                              style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>


    @yield('content')
</div>

<footer>
    <div class="container no-print">
        <div class="row">
            <div class="col-md-6 col-xs-6 text-left texto">
                Developed by <a href="http://www.gvallejos.com" class="link" target="_blank" style="color: #87B0FF;">gVallejos.com</a>
            </div>
            <div class="col-md-6 col-xs-6 text-right texto">
                © 2017 CORE v.2.0.7.
            </div>
        </div>
    </div>
</footer>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/printThis.js?v=1.0.3') }}"></script>
<script src="{{ asset('js/presupuesto.js?v=1.0.6') }}"></script>
<script src="{{ asset('js/precios.js?v=1') }}"></script>
<script src="{{ asset('js/proveedores.js?v=1.0.1') }}"></script>
<script src="{{ asset('js/pacientes.js?v=1.0.2') }}"></script>
<script src="{{ asset('js/medicos.js?v=1.0.2') }}"></script>
<script src="{{ asset('js/ingresos.js?v=1.0.5') }}"></script>
<script src="{{ asset('js/citas.js?v=1.0.24') }}"></script>
<script src="{{ asset('sweetalert/sweetalert.min.js') }}"></script>

<!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script> -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
  $( function() {
      var date = new Date();
      var currentMonth = date.getMonth();
      var currentDate = date.getDate();
      var currentYear = date.getFullYear();

      $("#dia").datepicker({
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        minDate: new Date(currentYear, currentMonth, currentDate)
      });

      $("#dia-modal").datepicker({
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        minDate: new Date(currentYear, currentMonth, currentDate)
      });

  } );
</script>


<!-- Full calendar -->
<script src="{{ asset('js/fullcalendar/lib/moment.min.js') }}"></script>
<script src="{{ asset('js/fullcalendar/fullcalendar.js') }}"></script>

@include('sweet::alert')
</body>
</html>
