let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */


// fue tomado de la documentacion de laravel que dice como adjuntar todas las hojas de estilos tanto css como js en un unico archivo


mix.styles([ // todas las hojas de estilo css
      'resources/assets/plantilla/css/font-awesome.min.css',
      'resources/assets/plantilla/css/simple-line-icons.min.css',
      'resources/assets/plantilla/css/style.css',
      'resources/assets/plantilla/css/jquery.dataTables.css',
      'resources/assets/plantilla/css/sweetalert2MsjConfirmacion.css',
      'resources/assets/plantilla/css/sweetalert2MsjError.css',  
      'resources/assets/plantilla/css/bootstrap-select.min.css'
  ], 'public/css/plantilla.css')// el archivo resultante es este que esta en esta direccion
  .scripts([ // todas la hojas de estilo js
    'resources/assets/plantilla/js/jquery.min.js',
    'resources/assets/plantilla/js/popper.min.js',
    'resources/assets/plantilla/js/bootstrap.min.js',
    'resources/assets/plantilla/js/Chart.min.js',
    'resources/assets/plantilla/js/pace.min.js',
    'resources/assets/plantilla/js/template.js',
    'resources/assets/plantilla/js/jquery.dataTables.js',
    'resources/assets/plantilla/js/jquery.dataTables.min.js',
    'resources/assets/plantilla/js/bootstrap-select.min.js',
    'resources/assets/plantilla/js/sweetalertMsjConfirmacion.all.js',
    'resources/assets/plantilla/js/sweetalert2.all.js',
    'resources/assets/plantilla/js/mayusculas.js',
  
], 'public/js/plantilla.js')// el archivo resultante es este que esta en esta direccion
.js(['resources/assets/js/app.js'],'public/js/app.js'); // el archivo resultante es este que esta en esta direccion





























