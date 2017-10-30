<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller {
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';


    /**
     * Create a new controller instance.
     *
     */
    public function __construct() {
        $this->middleware('guest')->except(['logout', 'getLogout', 'cerrarSesion']);
        //$this->middleware('guest', ['except' => ['logout', 'getLogout']]);
    }


    public function username() {
        return 'nombre';
    }



    /**
     * Carga la página para que el usuario ingrese su nombre y contraseña
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function mostrarLogin() {
        return View('login');
    }



    public function loginPost() {
        $usuario = Input::get('nombre_usuario');
        $contrasena = Input::get('contrasena');

        if (!empty($usuario) && !empty($contrasena)) {
            //Verifica los datos de autenticación del usuario
            //if (Auth::attempt(['nombre' => $usuario, 'password' => $contrasena], true)) {
            if (self::iniciaSesion($usuario, $contrasena)) {
                if (Request::wantsJson()) {
                    return response()->json([
                        'ok' => 1,
                        'token' => Auth::user()->remember_token,
                        'url' => Session::get('url.intended', 'dashboard')
                    ]);
                }
                else {
                    return redirect()->intended('dashboard');
                }
            }
        }

        if (Request::wantsJson()) {
            return response()->json([
                'ok' => 0
            ]);
        }
        else {
            return redirect('/');
        }
    }


    private static function iniciaSesion($nombre, $contrasena) {
        $usuario = User::where('nombre', '=', $nombre)->first();
        if ($usuario) {
            if (Hash::check($contrasena, $usuario->contrasena)) {
                return $usuario->iniciarSesion();
            }
        }
        return false;
    }


    public static function cerrarSesion($redireccionar = true) {
        Auth::logout();
        Session::flush();
        if ($redireccionar) {
            return redirect('/');
        }
        return true;
    }
}
