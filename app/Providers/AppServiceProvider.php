<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        //View::share('usuario', Auth::user());

        //Este procedimiento pre-carga la información del usuario y sus datos
        //de persona a las vistas, de manera que sean accesibles con las
        //variables $usuario y $persona
        View::composer('*', function($view) {

            //usuario
            $usuario = Auth::user();
            $view->with('usuario', $usuario);

            //persona
            if ($usuario) {
                $persona = $usuario->traerPersona();
            }
            else {
                $persona = false;
            }

            if (!$persona) {
                $persona = new \stdClass([
                    'nombre' => '-',
                    'apellido' => '-',
                    'dni' => '-',
                    'foto' => URL::asset('img/avatar_defecto.png')
                ]);
            }

            $view->with('persona', $persona);

        });
    }


    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }
}
