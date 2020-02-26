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




// creo mi primer middleware en este caso para los invitados las personas que no han
// autenticadas y dentro le indico a que rutas van a haceder
Route::group(['middleware'=>['guest']],function(){
  
    // cuando se haga referencia a este / llamamos a esta funcion del controlador login
    Route::get('/','Auth\LoginController@showLoginForm');
    // hago referencia a la funcion login del controlador
    Route::post('/login', 'Auth\LoginController@login')->name('login'); // y un alias

});


// middleware para los usuarios que ya estan autenticados
Route::group(['middleware'=>['auth']],function(){

    // solo los usuarios que se autenticaron va a poder cerrar la session
    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

    //Notificaciones CAMBIAR A UNA RUTA DONDE SOLO LOS ADMINISTRADORES PUEDAN VERLA
    Route::post('/notification/get', 'NotificationController@get'); 


    Route::get('/main', function () {
        return view('contenido/contenido');
    })->name('main'); // indico un alias
    

        Route::group(['middleware' => ['Funcionario']], function () {

            // meter las rutas aqui 


             //url + la funciion
             Route::get('/archivo', 'ArchivoController@index'); // xq el debe de entrar a conultar archivos y lo realizara por medio de esta ruta
             Route::put('/archivo/actualizar', 'ArchivoController@update'); // por si acaso 
             Route::get('/archivo/selectNumExpediente', 'ArchivoController@selectNumExpediente');
             Route::get('/archivo/selectArchivo', 'ArchivoController@selectArchivo'); // nuevo para el cbx del modulo consultar archivos

             //url + la funcion
             Route::get('/rol', 'RolController@index');
             Route::get('/rol/selectRol', 'RolController@selectRol');
             
             Route::get('/departamento/selectDepartamento', 'DepartamentoController@selectDepartamento'); //combobox modulo archivo y consulta de archivo
             Route::get('/persona/selectPersona', 'PersonaController@selectPersona'); //combobox modulo archivo  y consulta de archivo
             Route::get('/documental/seleccionarDocumentales', 'DocumentalController@seleccionarDocumentales'); //combobox modulo archivo  y consulta de archivo
             Route::get('/caja/seleccionarCajas', 'CajaController@seleccionarCajas'); //combobox modulo archivo  y consulta de archivo
             Route::get('/caja/seleccionarCajasRegistrar', 'CajaController@seleccionarCajasRegistrar'); //combobox modulo archivo
             Route::get('/caja/obtenerUbicacionCaja', 'CajaController@obtenerUbicacionCaja'); //modulo archivo   
            



        });



        Route::group(['middleware' => ['Administrador']], function () {
    
                 //url + la funcion ARCHIVO
                Route::get('/archivo', 'ArchivoController@index');
                Route::post('/archivo/registrar', 'ArchivoController@store');
                Route::put('/archivo/actualizar', 'ArchivoController@update');
                Route::put('/archivo/desactivar', 'ArchivoController@desactivar');
                Route::put('/archivo/activar', 'ArchivoController@activar');
                Route::get('/archivo/selectNumExpediente', 'ArchivoController@selectNumExpediente');
                Route::put('/archivo/eliminar', 'ArchivoController@destroy');
                Route::get('/archivo/selectArchivo', 'ArchivoController@selectArchivo'); // nuevo para el cbx del modulo consultar archivos
                Route::get('/archivo/buscarArchivo', 'ArchivoController@buscarArchivo'); // del modulo boletas
                Route::get('/archivo/listarArchivosModalBoleta', 'ArchivoController@listarArchivosModalBoleta');// para el modulo boletas exactamente para el modal de los tres puntitos...
                Route::get('/archivo/expiraciones', 'ArchivoController@expiraciones');


                //url + la funcion DOCUMENTAL
                Route::get('/documental', 'DocumentalController@index'); // con la palabra predeterminada get xq se van a optener datos de la base de datos
                Route::post('/documental/registrar', 'DocumentalController@store');
                Route::put('/documental/actualizar', 'DocumentalController@update');
                Route::put('/documental/desactivar', 'DocumentalController@desactivar');
                Route::put('/documental/activar', 'DocumentalController@activar');
                Route::get('/documental/seleccionarDocumentales', 'DocumentalController@seleccionarDocumentales'); //combobox modulo archivo
                Route::get('/documental/selectCodigoDiminutivo', 'DocumentalController@selectCodigoDiminutivo'); //para dar formato al nuevo numero archivo
                
                //url + la funcion CAJA
                Route::get('/caja', 'CajaController@index'); // con la palabra predeterminada get xq se van a optener datos de la base de datos
                Route::post('/caja/registrar', 'CajaController@store');
                Route::put('/caja/actualizar', 'CajaController@update');
                Route::put('/caja/desactivar', 'CajaController@desactivar');
                Route::put('/caja/activar', 'CajaController@activar');
                Route::get('/caja/selectNumCaja', 'CajaController@selectNumCaja'); //combobox
                Route::get('/caja/seleccionarCajas', 'CajaController@seleccionarCajas'); //combobox modulo archivo
                Route::get('/caja/seleccionarCajasRegistrar', 'CajaController@seleccionarCajasRegistrar'); //combobox modulo archivo
                Route::get('/caja/obtenerUbicacionCaja', 'CajaController@obtenerUbicacionCaja'); //modulo archivo
                
                //url + la funcion DEPARTAMENTO
                Route::get('/departamento', 'DepartamentoController@index'); // con la palabra predeterminada get xq se van a optener datos de la base de datos
                Route::post('/departamento/registrar', 'DepartamentoController@store');
                Route::put('/departamento/actualizar', 'DepartamentoController@update');
                Route::put('/departamento/desactivar', 'DepartamentoController@desactivar');
                Route::put('/departamento/activar', 'DepartamentoController@activar');
                Route::get('/departamento/selectDepartamento', 'DepartamentoController@selectDepartamento'); //combobox
                Route::get('/departamento/selectDiminutivoDepartamento', 'DepartamentoController@selectDiminutivoDepartamento'); //combobox
                Route::get('/departamento/validarExistencia', 'DepartamentoController@validarExistencia');

                //url + la funcion PERSONA
                Route::get('/persona', 'PersonaController@index');
                Route::post('/persona/registrar', 'PersonaController@store');
                Route::put('/persona/actualizar', 'PersonaController@update');
                Route::put('/persona/desactivar', 'PersonaController@desactivar');
                Route::put('/persona/activar', 'PersonaController@activar');
                Route::get('/persona/selectPersona', 'PersonaController@selectPersona');
                Route::get('/persona/llenarCampos', 'PersonaController@llenarCampos');
                Route::get('/persona/seleccionarPersona', 'PersonaController@seleccionarPersona');// para el cbx boletas
                
                //url + la funcion USER
                Route::get('/user', 'UserController@index');
                Route::post('/user/registrar', 'UserController@store');
                Route::put('/user/actualizar', 'UserController@update');
                Route::put('/user/desactivar', 'UserController@desactivar');
                Route::put('/user/activar', 'UserController@activar');
                

                //url + la funcion ROL
                Route::get('/rol', 'RolController@index');
                Route::get('/rol/selectRol', 'RolController@selectRol');

                 //url + la funcion BITACORA
                 Route::get('/bitacora', 'BitacoraController@index'); // con la palabra predeterminada get xq se van a optener datos de la base de datos
                
                  //url + la funcion BOLETA
                Route::get('/boleta', 'BoletaController@index');
                Route::put('/boleta/boletaPendiente', 'BoletaController@boletaPendiente');
                Route::put('/boleta/boletaDevuelta', 'BoletaController@boletaDevuelta');
                Route::post('/boleta/registrar', 'BoletaController@store');// para registrar una boleta
                Route::get('/boleta/obtenerCabecera', 'BoletaController@obtenerCabecera');
                Route::get('/boleta/obtenerDetalles', 'BoletaController@obtenerDetalles');
                Route::get('/boleta/obtenerUltimoNumeroBoleta', 'BoletaController@obtenerUltimoNumeroBoleta'); // para obtener el ultimo numero de boleta
                Route::get('/boleta/buscarNumBoleta', 'BoletaController@buscarNumBoleta'); //para comprobar la existencia del numero de la boleta NO SE ESTA UTILIZANDO
                Route::get('/boleta/pdf/{id}','BoletaController@pdf')->name('boleta_pdf');




                Route::post('/inventario/importExcel', 'InventarioController@importExcel');//Bueno

                //escritorio
                Route::get('/escritorio', 'EscritorioController@__invoke');



        });




        
        Route::group(['middleware' => ['SuperAdministrador']], function () {


                 //url + la funcion ARCHIVO
                Route::get('/archivo', 'ArchivoController@index');
                Route::post('/archivo/registrar', 'ArchivoController@store');
                Route::put('/archivo/actualizar', 'ArchivoController@update');
                Route::put('/archivo/desactivar', 'ArchivoController@desactivar');
                Route::put('/archivo/activar', 'ArchivoController@activar');
                Route::get('/archivo/selectNumExpediente', 'ArchivoController@selectNumExpediente');
                Route::put('/archivo/eliminar', 'ArchivoController@destroy');
                Route::get('/archivo/selectArchivo', 'ArchivoController@selectArchivo'); // nuevo para el cbx del modulo consultar archivos
                Route::get('/archivo/buscarArchivo', 'ArchivoController@buscarArchivo'); // del modulo boletas
                Route::get('/archivo/listarArchivosModalBoleta', 'ArchivoController@listarArchivosModalBoleta');// para el modulo boletas exactamente para el modal de los tres puntitos...
                Route::get('/archivo/expiraciones', 'ArchivoController@expiraciones');

                //url + la funcion DOCUMENTAL
                Route::get('/documental', 'DocumentalController@index'); // con la palabra predeterminada get xq se van a optener datos de la base de datos
                Route::post('/documental/registrar', 'DocumentalController@store');
                Route::put('/documental/actualizar', 'DocumentalController@update');
                Route::put('/documental/desactivar', 'DocumentalController@desactivar');
                Route::put('/documental/activar', 'DocumentalController@activar');
                Route::get('/documental/seleccionarDocumentales', 'DocumentalController@seleccionarDocumentales'); //combobox modulo archivo
                Route::get('/documental/selectCodigoDiminutivo', 'DocumentalController@selectCodigoDiminutivo'); //para dar formato al nuevo numero archivo
                
                //url + la funcion CAJA
                Route::get('/caja', 'CajaController@index'); // con la palabra predeterminada get xq se van a optener datos de la base de datos
                Route::post('/caja/registrar', 'CajaController@store');
                Route::put('/caja/actualizar', 'CajaController@update');
                Route::put('/caja/desactivar', 'CajaController@desactivar');
                Route::put('/caja/activar', 'CajaController@activar');
                Route::get('/caja/selectNumCaja', 'CajaController@selectNumCaja'); //combobox
                Route::get('/caja/seleccionarCajas', 'CajaController@seleccionarCajas'); //combobox modulo archivo
                Route::get('/caja/seleccionarCajasRegistrar', 'CajaController@seleccionarCajasRegistrar'); //combobox modulo archivo
                Route::get('/caja/obtenerUbicacionCaja', 'CajaController@obtenerUbicacionCaja'); //modulo archivo


                //url + la funcion DEPARTAMENTO
                Route::get('/departamento', 'DepartamentoController@index'); // con la palabra predeterminada get xq se van a optener datos de la base de datos
                Route::post('/departamento/registrar', 'DepartamentoController@store');
                Route::put('/departamento/actualizar', 'DepartamentoController@update');
                Route::put('/departamento/desactivar', 'DepartamentoController@desactivar');
                Route::put('/departamento/activar', 'DepartamentoController@activar');
                Route::get('/departamento/selectDepartamento', 'DepartamentoController@selectDepartamento'); //combobox
                Route::get('/departamento/selectDiminutivoDepartamento', 'DepartamentoController@selectDiminutivoDepartamento'); //combobox
                Route::get('/departamento/validarExistencia', 'DepartamentoController@validarExistencia');

                //url + la funcion PERSONA
                Route::get('/persona', 'PersonaController@index');
                Route::post('/persona/registrar', 'PersonaController@store');
                Route::put('/persona/actualizar', 'PersonaController@update');
                Route::put('/persona/desactivar', 'PersonaController@desactivar');
                Route::put('/persona/activar', 'PersonaController@activar');
                Route::get('/persona/selectPersona', 'PersonaController@selectPersona');
                Route::get('/persona/llenarCampos', 'PersonaController@llenarCampos');
                Route::get('/persona/seleccionarPersona', 'PersonaController@seleccionarPersona');// para el cbx boletas
                
                //url + la funcion USUARIO
                Route::get('/user', 'UserController@index');
                Route::post('/user/registrar', 'UserController@store');
                Route::put('/user/actualizar', 'UserController@update');
                Route::put('/user/desactivar', 'UserController@desactivar');
                Route::put('/user/activar', 'UserController@activar');
                

                //url + la funcion ROL
                Route::get('/rol', 'RolController@index');
                Route::get('/rol/selectRol', 'RolController@selectRol');

                  //url + la funcion BITACORA
                Route::get('/bitacora', 'BitacoraController@index'); // con la palabra predeterminada get xq se van a optener datos de la base de datos
                
                //url + la funcion BOLETAS
                Route::get('/boleta', 'BoletaController@index');
                Route::put('/boleta/boletaPendiente', 'BoletaController@boletaPendiente');
                Route::put('/boleta/boletaDevuelta', 'BoletaController@boletaDevuelta');
                Route::post('/boleta/registrar', 'BoletaController@store');// para registrar una boleta
                Route::get('/boleta/obtenerCabecera', 'BoletaController@obtenerCabecera');
                Route::get('/boleta/obtenerDetalles', 'BoletaController@obtenerDetalles');
                Route::get('/boleta/obtenerUltimoNumeroBoleta', 'BoletaController@obtenerUltimoNumeroBoleta'); // para obtener el ultimo numero de boleta
                Route::get('/boleta/buscarNumBoleta', 'boletaController@buscarNumBoleta'); //para comprobar la existencia del numero de la boleta NO SE ESTA UTILIZANDO
                Route::get('/boleta/pdf/{id}','BoletaController@pdf')->name('boleta_pdf');



                
                Route::post('/inventario/importExcel', 'InventarioController@importExcel');//Bueno


                 //escritorio
                 Route::get('/escritorio', 'EscritorioController@__invoke');
        

        });




    

});



 // Route::get('/home', 'HomeController@index')->name('home');












