<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
//use Illuminate\Foundation\Auth\AuthenticatesUsers; // eliminar



// adjuntar estas librerias
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
   
    // retorna la vista que esta en resource/views/auth/login.blde.php
    public function showLoginForm(){
        return view('auth.login');
    }

    public function login(Request $request){
        $this->validateLogin($request);   // le envia el request a la funcion de abajo   

        // si mi propiedad usuario es igual a lo que vien 
        if (Auth::attempt([
        'usuario' => $request->usuario,
        'password' => $request->password,
        'estado'=>1])){
            // si existe pues que entre 
            return redirect()->route('main');
        }
       
       
        //regresar atras
        return back()
        ->withErrors(['usuario' => trans('auth.failed')])
        ->withInput(request(['usuario'])); // regresamos lo que se a escrito en ese input



    }


    protected function validateLogin(Request $request){
         //  valido la peticion de inicio de session del usuario   
         $this->validate($request,[
            'usuario' => 'required|string',
            'password' => 'required|string'
        ]);
    }


    // para cerrar la session
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        return redirect('/');
    }




}


















