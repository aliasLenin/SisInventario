@extends('principal')
<!-- indica que hereda de la vista llamada principal-->
 

 <!-- Inicia este contenido-->
   @section('contenido')


        @if(Auth::check())
             @if (Auth::user()->idrol == 1)

                    <template v-if="menu==0">
                    <!-- llama a la vista que se decea mostrar-->
                      <!--  <h1> CONTENIDO MENU 0 GRAFICOS ESCRITORIO</h1> -->
                      <escritorio></escritorio> 
                    </template>

                    <template v-if="menu==1">     
                        <!-- llama a la vista que se decea mostrar
                        <h1> REGISTRAR ARCHIVOS </h1>   -->
                        <archivo></archivo> 
                    </template>

                    <template v-if="menu==2">     
                        <!-- llama a la vista que se decea mostrar-->
                        <!-- <h1> REGISTRAR ARCHIVOS EXCEll </h1>  -->
                        <!--  <excel></excel>  -->

                        <inventario></inventario>
                    </template>

                    <template v-if="menu==3">     
                        <!-- llama a la vista que se decea mostrar 
                        <h1> CONSULTA DE ARCHIVOS </h1>  -->
                        <consultararchivo></consultararchivo> 
                        
                    </template>

                    <template v-if="menu==4">     
                        <!-- llama a la vista que se decea mostrar-->
                        <!-- <h1> GESTION DOCUMENTALES </h1>  -->
                        <documental></documental> 
                    </template>

                    <template v-if="menu==5">     
                        <!-- llama a la vista que se decea mostrar-->
                        <!-- <h1> GESTION DE CAJAS </h1>   -->
                        <caja></caja> 
                    </template>

                    <template v-if="menu==6">     
                        <!-- llama a la vista que se decea mostrar
                        <h1> GESTION DE BOLETAS </h1>  -->
                        <boleta></boleta>
                    </template>

                    <template v-if="menu==7">     
                        <!-- llama a la vista que se decea mostrar-->
                        <!-- <h1> BITACORA DE MOVIMIENTOS </h1> -->
                        <bitacora></bitacora>
                    </template>

                    <template v-if="menu==8">
                        <!-- llama a la vista que se decea mostrar-->
                        <departamento></departamento>
                    </template>

                    <template v-if="menu==9">     
                        <!-- llama a la vista que se decea mostrar
                        <h1> GESTION DE PERSONAS </h1>  -->
                        <persona></persona>
                    </template>

                    <template v-if="menu==10">     
                        <!-- llama a la vista que se decea mostrar
                        <h1> GESTION DE USUARIOS </h1>  -->
                        <user></user>
                    </template>

                    <template v-if="menu==11">     
                        <!-- llama a la vista que se decea mostrar
                        <h1> GESTION DE ROLES </h1> -->
                        <rol></rol> 
                    </template>

                    <template v-if="menu==12">     
                        <!-- llama a la vista que se decea mostrar-->
                        <h1> REPORTES DE ENTRADA </h1>  
                    </template>

                    <template v-if="menu==13">     
                        <!-- llama a la vista que se decea mostrar-->
                        <h1> REPORTES DE SALIDA </h1>  
                    </template>

                    <template v-if="menu==14">     
                        <!-- llama a la vista que se decea mostrar-->
                        <h1> SERVICIOS DE AYUDA </h1>  
                    </template>

                    <template v-if="menu==15">     
                        <!-- llama a la vista que se decea mostrar-->
                        <h1> ACERCA DE </h1>  
                    </template>

            @elseif (Auth::user()->idrol == 2)

                        <template v-if="menu==0">
                        <!-- llama a la vista que se decea mostrar-->
                             <!--  <h1> CONTENIDO MENU 0 GRAFICOS ESCRITORIO</h1> -->
                         <escritorio></escritorio> 
                        </template>

                        <template v-if="menu==1">     
                            <!-- llama a la vista que se decea mostrar
                            <h1> REGISTRAR ARCHIVOS </h1>  -->
                            <archivo></archivo> 

                        </template>

                        <template v-if="menu==2">     
                            <!-- llama a la vista que se decea mostrar-->
                            <!-- <h1> REGISTRAR ARCHIVOS EXCEll </h1>  -->
                            <!--   <excel></excel>  -->
                            <inventario></inventario>
                        </template>

                        <template v-if="menu==3">     
                            <!-- llama a la vista que se decea mostrar
                        <h1> CONSULTA DE ARCHIVOS </h1> --> 
                        <consultararchivo></consultararchivo> 

                        </template>

                        <template v-if="menu==4">     
                            <!-- llama a la vista que se decea mostrar-->
                            <!-- <h1> GESTION DOCUMENTALES </h1>  -->
                            <documental></documental> 
                        </template>

                        <template v-if="menu==5">     
                            <!-- llama a la vista que se decea mostrar-->
                            <!-- <h1> GESTION DE CAJAS </h1>   -->
                            <caja></caja> 
                        </template>

                        <template v-if="menu==6">     
                            <!-- llama a la vista que se decea mostrar
                            <h1> GESTION DE BOLETAS </h1>  -->
                            <boleta></boleta>
                        </template>

                        <template v-if="menu==7">     
                            <!-- <h1> BITACORA DE MOVIMIENTOS </h1> -->
                            <bitacora></bitacora>
                        </template>

                        <template v-if="menu==8">
                            <!-- llama a la vista que se decea mostrar-->
                            <departamento></departamento>
                        </template>

                        <template v-if="menu==9">     
                            <!-- llama a la vista que se decea mostrar
                            <h1> GESTION DE PERSONAS </h1>  -->
                            <persona></persona>
                        </template>

                        <template v-if="menu==10">     
                            <!-- llama a la vista que se decea mostrar
                            <h1> GESTION DE USUARIOS </h1>  -->
                            <user></user>
                        </template>

                        <template v-if="menu==11">     
                            <!-- llama a la vista que se decea mostrar
                            <h1> GESTION DE ROLES </h1> -->
                            <rol></rol> 
                        </template>

                        <template v-if="menu==12">     
                            <!-- llama a la vista que se decea mostrar-->
                            <h1> REPORTES DE ENTRADA </h1>  
                        </template>

                        <template v-if="menu==13">     
                            <!-- llama a la vista que se decea mostrar-->
                            <h1> REPORTES DE SALIDA </h1>  
                        </template>

                        <template v-if="menu==14">     
                            <!-- llama a la vista que se decea mostrar-->
                            <h1> SERVICIOS DE AYUDA </h1>  
                        </template>


            @elseif (Auth::user()->idrol == 3)

                         <template v-if="menu==0">
                        <!--  <h1> CONTENIDO MENU 0 GRAFICOS ESCRITORIO</h1> -->
                        <escritoriofuncionario></escritoriofuncionario> 
                        </template>

                        <template v-if="menu==3">     
                             <!-- llama a la vista que se decea mostrar
                        <h1> CONSULTA DE ARCHIVOS </h1>  -->
                        <consultararchivo></consultararchivo> 
                        </template>

                        <template v-if="menu==11">     
                            <!-- llama a la vista que se decea mostrar
                            <h1> GESTION DE ROLES </h1> -->
                            <rol></rol> 
                        </template>
                  
                        <template v-if="menu==14">     
                            <!-- llama a la vista que se decea mostrar-->
                            <h1> SERVICIOS DE AYUDA </h1>  
                        </template>




                    @else

                    @endif

            @endif
           

  <!-- cierra aqui el contenido-->     
        @endsection


























