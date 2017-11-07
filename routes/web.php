<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth/login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// RR.HH
Route::resource('pacientes', 'PacienteController');
Route::get('paciente', 'PacienteController@index')->name('pacienteindex');

Route::resource('medicos', 'MedicoController');
Route::get('medico', 'MedicoController@index')->name('medicoindex');

// Presupuestos
Route::resource('presupuestos', 'PresupuestoController');
Route::get('/presupuestos/create/{idMedico}/{idPaciente}', ['uses' => 'PresupuestoController@create'])->name('crearPresupuesto');
Route::get('/presupuestos/create/{idMedico}/{idPaciente}/{nroPresupuesto}', ['uses' => 'PresupuestoController@create'])->name('detallePresupuesto');
Route::get('/presupuestos/destroy/{id}', ['uses' => 'PresupuestoController@destroy']);
Route::get('presupuesto', 'PresupuestoController@index')->name('presupuestoindex');

//Proveedor
Route::resource('proveedors', 'ProveedorController');
Route::get('proveedor', 'ProveedorController@index')->name('proveedorindex');

// Empresas - Precios - Tratamientos
Route::resource('empresas', 'EmpresaController');
Route::get('empresa', 'EmpresaController@index')->name('empresaindex');

Route::resource('precios', 'PrecioController');
Route::get('precio', 'PrecioController@index')->name('precioindex');

Route::resource('tratamientos', 'TratamientoController');
Route::get('tratamiento', 'TratamientoController@index')->name('tratamientoindex');

// Agenda - Rutas
Route::resource('agendas', 'AgendaController');

// Pagos (Ingreso)
Route::resource('ingresos', 'IngresoController');
Route::get('ingreso', 'IngresoController@index')->name('ingresoindex');

// Ws Routes
Route::get('api-v1/update-precios/{idEmpresa}/{idTratamiento}/{monto}/{token}', 'WsCoreController@updatePrecios')->name('updatePrecios');

Route::get('api-v1/get-monto/{idEmpresa}/{idTratamiento}', 'WsCoreController@getMontoByEmpresaTratamiento')->name('getMonto');

Route::get('api-v1/save-presupuesto/', 'WsCoreController@saveNuevoPresupuesto')->name('savePresupuesto');

Route::get('api-v1/agregar-cita/', 'WsCoreController@agregarCita')->name('agregarCita');

Route::get('api-v1/obtener-cita/{idUser}', 'WsCoreController@obtenerCitasById')->name('obtenerCitaById');

Route::get('api-v1/get-detalle-proveedor/{idProveedor}', 'WsCoreController@obtenerDetalleProveedor')->name('obtenerDetalleProveedor');

Route::get('api-v1/agregar-detalle-proveedor/', 'WsCoreController@agregarDetalleProveedor')->name('agregarDetalleProveedor');

Route::get('api-v1/eliminar-detalle-proveedor/{idDProveedor}', 'WsCoreController@eliminarDetalleProveedor')->name('eliminarDetalleProveedor');

Route::get('api-v1/buscar-ingresos/', 'WsCoreController@buscarIngresos')->name('agregarIngresos');
