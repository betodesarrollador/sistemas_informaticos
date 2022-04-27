<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" /> 
    {$JAVASCRIPT}
    {$CSSSYSTEM}
    {$TITLETAB} 
</head>
<body style = "background: #F7F4F4">   

<div class = "container-fluid">

    <div class = "row">
        <div class = "col-xs-4">
            <div class = "valor_facturado">
                <table>
                <tr>
                    <td class="cuadro">
                      <i class="fa fa-usd"></i>
                    </td>
                    <td>
                       <div class="div_center">
                       {$FACTURADO}
                       <br><br>
                       VALOR FACTURADO ULTIMO MES
                       <div>
                    </td>
                </tr>
                </table>
            </div>
        </div>

        <div class = "col-xs-4">
             <div class = "valor_facturado">
                <table>
                <tr>
                    <td class="cuadro1">
                      <i class="fa fa-tasks"></i>
                    </td>
                    <td>
                       <div class="div_center">
                       {$SALDO}
                       <br><br>
                       VALOR SALDO ULTIMO MES
                       <div>
                    </td>
                </tr>
                </table>
            </div>
        </div>

        <div class = "col-xs-4">
             <div class = "valor_facturado">
              <table>
                <tr>
                    <td class="cuadro2">
                     <i class="fa fa-money"></i>
                    </td>
                    <td>
                       <div class="div_center">
                       {$PAGADO}
                       <br><br>
                       VALOR PAGADO ULTIMOS DOS MESES
                       <div>
                    </td>
                </tr>
                </table>
            </div>
        </div>


        <div class = "col-xs-6">
             <div class = "tablas_facturas">
              
                        <div class="center_cabecera">
                            <i class="fa fa-tasks"></i>&nbsp;&nbsp;CLIENTES CON MAYOR SALDO
                        </div>
  
                   
                        <table id="mayor_saldo" class="table table-stripped table-bordered">
                                <thead class="table-primary">
                                    <tr>
                                        <th style="text-align: left" scope="col">CLIENTE</th>
                                        <th style="text-align: left" scope="col">SALDO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                        </table>
                    
                   
            </div>
        </div>

                <div class = "col-xs-6">
             <div class = "tablas_facturas">
              <table>
                    <tr>
                        <div class="center_cabecera">
                            <i class="fa fa-tasks"></i>&nbsp;&nbsp;VALORES ANUAL
                        </div>
                    </tr>
                    <tr>
                   
                        <table id="valor_anual" class="table table-stripped table-bordered">
                                <thead class="table-primary">
                                    <tr>
                                        <th style="text-align: left" scope="col">VALOR FACTURADO</th>
                                        <th style="text-align: left" scope="col">VALOR SALDO</th>
                                        <th style="text-align: left" scope="col">VALOR PAGADO</th>         
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                        </table>
                    
                    </tr>
               
             </table>
            </div>
        </div>
    </div>

</div>        

</body>  
</html>