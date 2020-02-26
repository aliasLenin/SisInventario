<!DOCTYPE>
<html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de boleta</title>
    <style>
        body {
        /*position: relative;*/
        /*width: 16cm;  */
        /*height: 29.7cm; */
        /*margin: 0 auto; */
        /*color: #555555;*/
        /*background: #FFFFFF; */
        font-family: Arial, sans-serif; 
        font-size: 14px;
        /*font-family: SourceSansPro;*/
        }

        #logo{
        float: left;
        margin-top: 1%;
        margin-left: 2%;
        margin-right: 2%;
        }

        #imagen{
        width: 100px;
        }

        #datos{
        float: left;
        margin-top: 0%;
        margin-left: 2%;
        margin-right: 2%;
        /*text-align: justify;*/
        }

        #encabezado{
        text-align: center;
        margin-left: 10%;
        margin-right: 35%;
        font-size: 15px;
        }

        #fact{
        /*position: relative;*/
        float: right;
        margin-top: 2%;
        margin-left: 2%;
        margin-right: 2%;
        font-size: 20px;
        }

        section{
        clear: left;
        }

        #cliente{
        text-align: left;
        }

        #facliente{
        width: 40%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 15px;
        }

        #fac, #fv, #fa{
        color: #FFFFFF;
        font-size: 15px;
        }

        #facliente thead{
        padding: 20px;
        background: #2183E3;
        text-align: left;
        border-bottom: 1px solid #FFFFFF;  
        }

        #facvendedor{
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 15px;
        }

        #facvendedor thead{
        padding: 20px;
        background: #2183E3;
        text-align: center;
        border-bottom: 1px solid #FFFFFF;  
        }

        #facarticulo{
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 15px;
        }

        #facarticulo thead{
        padding: 20px;
        background: #2183E3;
        text-align: center;
        border-bottom: 1px solid #FFFFFF;  
        }

        #gracias{
        text-align: center; 
        }
    </style>
    <body>

     <!-- resive por parametro -->
      @foreach ($boleta as $b)
        <header>
            <div id="logo">
                <img src="img/escudoMunicipal.PNG" alt="incanatoIT" id="imagen">
            </div>
            <div id="datos">
                <p id="encabezado">
                
                    <b>MUNICIPALIDAD DE CARRILLO GUANACASTE</b>
                    <br>Universidad Nacional De Costa Rica
                    <br>José lenin ulloa anchia, Jean carlos navarrete, Edwin calipto 
                    <br>Telefono:(+506)84633772
                    <br>Email: joseleninu@gmail.com
                   
                </p>
            </div>
            <div id="fact">
                <p>{{$b->tipo_comprobante}}<br>
                {{$b->num_boleta}}</p>
            </div>
        </header>
        <br>
        <section>
            <div>
                <table id="facvendedor">
                    <thead>                        
                        <tr id="fac">
                            <th>Responsable de la documentacion:</th>
                            <th>Depedencia solicito:</th>
                            <th>Fecha limite:</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><p id="cliente">Sr(a).{{$b->nombre}}<br>
                            {{$b->tipo_identificacion}}:  {{$b->num_identificacion}} <br>
                            Dirección: {{$b->direccion}}<br>
                            Teléfono: {{$b->telefono}}<br>
                            Email: {{$b->email}}</p></td>

                            <td>{{$b->nombre_departamento}}</td>
                            <td>{{$b->fecha_limite}}</td>

                        </tr>

                      
                    </tbody>
                </table>
            </div>
        </section>
        <br>
        <section>
            <div>
                <table id="facvendedor">
                    <thead>
                        <tr id="fv">
                            <th>USUARIO GESTOR:</th>
                            <th>FECHA</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$b->usuario}}</td>
                            <td>{{$b->created_at}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
        @endforeach



        <br>
        <section>
            <div>
                <table id="facarticulo">
                    <thead>
                        <tr id="fa">
                            <th>NUMERO EXPEDIENTE</th>
                            <th>TIPO DOCUMENTAL</th>
                            <th>FECHA EXTREMA</th>
                            <th>UBICACION</th>
                            <th>ESTADO</th>
                        </tr>
                    </thead>
                    <tbody>

                    @foreach ($detalles as $det)
                        <tr>
                            <td> {{ $det->viejo_num_expediente }} </td>
                            <td> {{ $det->nombre_documental }}  </td>
                            <td> {{ $det->fecha_extrema  }}  </td>
                            <td> {{ $det->ubicacion  }}  </td>
                            <td> {{ $det->estado?'Prestado':'Prestado'}}</td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </section>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <footer>
            
                <table id="facvendedor">
                 
                    <br>
                    <br>
                    <tbody>
                        <tr>

                            <td>
                                <div id="gracias">
                                    <p><b> _____________________________________ </b></p>
                                </div>
                            </td>
                            <br>
                            <br>
                            <td>
                                <div id="gracias">
                                    <p><b> _____________________________________ </b></p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                    <br>
                    <br>
                    <thead>
                        <tr id="fv">
                            <th>FIRMA RESPONSABLE DE LA DOCUMENTACION:</th>
                            <th>FIRMA DEL USUARIO GESTOR:</th>
                        </tr>
                    </thead>
                </table>

            <div id="gracias">
                <p><b> Universidad nacional de costa rica, estamos para servirles!!! </b></p>
            </div>
        </footer>
    </body>
</html>