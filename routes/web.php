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

use Illuminate\Support\Facades\Route;


Route::get('/welcome', function () {
    return view('welcome');
});

/**
 * Lista los iconos disponibles en el CSS para referencia (quitar en producción)
 */
Route::get('/iconos', function() {
    return view('lista-iconos');
});


#El usuario no ha iniciado sesión

Route::group(['middleware' => 'guest'], function() {

    //Formulario para iniciar sesión
    Route::get('/', ['as' => 'login', 'uses' => 'Auth\LoginController@mostrarLogin']);

    //Procesa datos de inicio de sesión
    Route::post('/inicio-post', ['as' => 'inicio_post', 'uses' => 'Auth\LoginController@loginPost']);

});


#El usuario ya ha iniciado sesión

Route::group(['middleware' => 'auth'], function() {

    //General
    Route::post('/post', ['as' => 'post', 'uses' => 'Controlador@post']);
    Route::get('/get', ['as' => 'get', 'uses' => 'Controlador@get']);
    Route::get('/listado', ['as' => 'listado', 'uses' => 'Controlador@listadoGet']);
    Route::get('/total', ['as' => 'total', 'uses' => 'Controlador@totalGet']);

    //Dashboard
    Route::get('/dashboard', ['as' => 'dashboard', 'uses' => 'DashboardController@index']);

    //Decanatura
    Route::get('/decanatura', ['as' => 'decanatura_admin', 'uses' => 'DecanaturaController@admin']);
    Route::get('/decanatura-index', ['as' => 'decanatura_index', 'uses' => 'DecanaturaController@index']);

    //Facultad
    Route::get('/facultad', ['as' => 'facultad_admin', 'uses' => 'FacultadController@admin']);
    Route::get('/facultad-index', ['as' => 'facultad_index', 'uses' => 'FacultadController@index']);

    //Tipo de Carrera
    Route::get('/tipo-carrera', ['as' => 'tipo_carrera_admin', 'uses' => 'TipoCarreraController@admin']);
    Route::get('/tipo-carrera-index', ['as' => 'tipo_carrera_index', 'uses' => 'TipoCarreraController@index']);

    //Carrera
    Route::get('/carrera', ['as' => 'carrera_admin', 'uses' => 'CarreraController@admin']);
    Route::get('/carrera-index', ['as' => 'carrera_index', 'uses' => 'CarreraController@index']);

    //Materia
    Route::get('/materia', ['as' => 'materia_admin', 'uses' => 'MateriaController@admin']);
    Route::get('/materia-index', ['as' => 'materia_index', 'uses' => 'MateriaController@index']);

    //Año Académico
    Route::get('/anualidad', ['as' => 'anualidad_admin', 'uses' => 'AnualidadController@admin']);
    Route::get('/anualidad-index', ['as' => 'anualidad_index', 'uses' => 'AnualidadController@index']);

    //Modalidad
    Route::get('/modalidad', ['as' => 'modalidad_admin', 'uses' => 'ModalidadController@admin']);
    Route::get('/modalidad-index', ['as' => 'modalidad_index', 'uses' => 'ModalidadController@index']);

    //Plan Estudio
    Route::get('/plan-estudio', ['as' => 'plan_estudio_admin', 'uses' => 'PlanEstudioController@admin']);
    Route::get('/plan-estudio-index', ['as' => 'plan_estudio_index', 'uses' => 'PlanEstudioController@index']);

    //Estudiante
    Route::get('/estudiante', ['as' => 'estudiante_admin', 'uses' => 'EstudianteController@admin']);
    Route::get('/estudiante-index', ['as' => 'estudiante_index', 'uses' => 'EstudianteController@index']);

    //Profesor
    Route::get('/profesor', ['as' => 'profesor_admin', 'uses' => 'ProfesorController@admin']);
    Route::get('/profesor-index', ['as' => 'profesor_index', 'uses' => 'ProfesorController@index']);

});


Route::get('/cerrar-sesion', ['as' => 'cerrar_sesion', 'uses' => 'Auth\LoginController@cerrarSesion']);