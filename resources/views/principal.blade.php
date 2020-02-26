<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sistema Inventario documental">
    <meta name="author" content="joseleninu@gmail.com">
    <meta name="keyword" content="Sistema Invenatrio Documental">
    <link rel="shortcut icon" href="img/favicon.png"> <!-- icono de la aplicacion-->

      <!-- Id for Channel Notification si se a autenticado un usuario enviare el id del usario esto en conjunto con el metodo created del archivo app.js -->   
      <meta name="userId" content="{{ Auth::check() ? Auth::user()->id : ''}}">  

    <title>Sistema Inventario</title>

        
    <!-- para proteger la aplicacion de ataques CSRF-->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!--       Para los graficos estadisticos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.min.js">

     <!-- direcciona a los estilos css intalados por npm run dev xq todos esta aqui-->
    <link href="css/plantilla.css" rel="stylesheet">
 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.12.1/dist/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/css/bootstrap-select.css">

   

</head>


<!-- clase propia de la plantilla-->
<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">
    
  <div id="app">

    <header class="app-header navbar">
        
        <button class="navbar-toggler mobile-sidebar-toggler d-lg-none mr-auto" type="button">
          <span class="navbar-toggler-icon"></span>
        </button>

       <!-- <a class="navbar-brand" href="#"></a> imagen -->
        <a class="nav-link" href="#">INVENTARIO DOCUMENTAL</a>

        <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button">
          <span class="navbar-toggler-icon"></span>
        </button>

        <ul class="nav navbar-nav d-md-down-none">
            <li class="nav-item px-3">
            <span><a href="#">Gmail</a></span>
            </li>
            <li class="nav-item px-3">
            <span><a href="#">Hotmail</a></span>
            </li>
        </ul>

        <ul class="nav navbar-nav ml-auto">
            
            <!-- refrencia a las notificaciones pasa el arreglo que viene de la base de datos probiene del archivo app.js-->
            <notification :notifications='notifications'></notification>




            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <img src="img/avatars/6.jpg" class="img-avatar" alt="admin@bootstrapmaster.com">
                    <span class="d-md-down-none"> {{Auth::user()->usuario}}  </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-header text-center">
                        <strong>Cuenta</strong>
                    </div>
                 <!--   <a class="dropdown-item" href="#"><i class="fa fa-user"></i> Perfil</a> -->
                 <a class="dropdown-item" href="{{ route('logout') }}" 
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa fa-lock"></i> Cerrar sesión</a>

                    
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>



                </div>
            </li>
            
        </ul>

    </header>

    <div class="app-body">
       
<!-- en caso de que el usuario este autenticado con su rol y dependiendo de este accedera a estos archivos 70 -->
    @if(Auth::check())
            @if (Auth::user()->idrol == 1)

                @include('plantilla.sidebarsuperadministrador')

             @elseif (Auth::user()->idrol == 2)

                @include('plantilla.sidebaradministrador')

             @elseif (Auth::user()->idrol == 3)

                @include('plantilla.sidebarfuncionario')

             @else

            @endif

    @endif

      
       <!-- Contenido Principal -->
      
        @yield('contenido')   <!-- lamma a la vista del archivo llamado contenido-->

         <!-- /Fin del contenido principal -->
       </div>
    </div>
    

    <footer class="app-footer">
        <span><a href="https://www.municarrillo.go.cr/">Municipalidad De Carrillo</a> &copy; 2019</span>
        <span class="ml-auto">Desarrollado por: <a href="https://www.una.ac.cr/">UNIVERSIDAD NACIONAL DE COSTA RICA</a></span>
    </footer>

     
<!-- hacemos referencia al archivo app.js-->
    <script src="js/app.js"></script>
 <!-- direcciona a los estilos javascript intalados pos npm run dev xq todos esta aqui-->   
    <script src="js/plantilla.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.12.1/dist/js/bootstrap-select.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.min.js"></script>


</body>

</html>

























