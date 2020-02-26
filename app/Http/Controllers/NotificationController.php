<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notification;
use Auth;

class NotificationController extends Controller
{



    public function get(){
       // return Notification::all(); //1
       // unicamente se le van a mostrar las notificciones de ese dia en especifico
        $unreadNotifications = Auth::user()->unreadNotifications; // notificaciones no leidas por el usuario
        $fechaActual= date('Y-m-d'); // variable da formato a la fecha
        foreach ($unreadNotifications as $notification) {  // recorro las notificaciones no leidas
          // si la fecha actual es diferente a la fecha de creacion de la notificacion
          if ($fechaActual != $notification->created_at->toDateString()) { // si la notificacion no coincide con el dia actual
                  $notification->markAsRead(); // marcarla como leida 
           }  
           
          }
        
       return Auth::user()->unreadNotifications; // muestra las notificaciones del usuario logeado y no leidas


       }    
       
       



       
}
