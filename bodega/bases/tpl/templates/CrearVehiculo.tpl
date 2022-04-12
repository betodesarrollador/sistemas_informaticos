<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="sistemas_informaticos/framework/css/bootstrap1.css">
    <title>Crear Vehiculo</title>
    {$JAVASCRIPT}
    {$TABLEGRIDJS}
    {$CSSSYSTEM}
    {$TABLEGRIDCSS}
    {$TITLETAB}
</head>
  
<body>

    <fieldset>
    <legend>{$TITLEFORM}</legend>
        <div id="table_find">
            <table align="center">
                <tr>
                    <td><label>Busqueda :</label></td>
                </tr>
                <tr>
                    <td>{$BUSQUEDA}</td>
                </tr>
            </table>
        </div>
    </fieldset>
    {$FORM1}
    <fieldset class="section">
        <!--<table align="center">
            <tr>
                <td><label>Placa: </label></td>
                <td>{$PLACA}{$VEHICULOID}{$USUARIO_ID}{$USUARIO_ACTUALIZA_ID}{$FECHA_ACTUALIZA}{$FECHA_REGISTRO}</td>
                <td><label>Marca: </label></td>
                <td>{$MARCA}{$MARCAID}</td>
                <td><label>Tipo Vehiculo: </label></td>
                <td>{$TIPOVEHICULOID}</td>                
            </tr>
           <tr>
                <td><label>Color: </label></td>
                <td>{$COLOR}{$COLORID}</td>
                <td><label>Nombre Conductor :</label></td>
                <td>{$NOMBRECONDUCTOR}</td>
                <td><label>Cedula Conductor :</label></td>
                <td>{$CEDULACONDUCTOR}</td>               
            </tr>
            <tr>
                <td><label>Telefono Conductor: </label></td>
                <td>{$TELCONDUCTOR}</td>
                <td><label>Telefono Ayudante:</label></td>
                <td>{$TELAYUDANTE}</td>
                <td><label>Soat:</label></td>
                <td>{$SOAT}</td>               
            </tr>  
            <tr>
                <td><label>Tecnomecanica: </label></td>
                <td>{$TECNOMECANICA}</td> 
                <td><label>Estado: </label></td>
                <td>{$ESTADO}</td>           
            </tr>                           
            <tr>
                <td colspan="4">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="6" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
            </tr>
        </table> -->
        <div class="container">
            <div class="row">
                <div class="col-sm-7">
                    <div class="row">
                        <div class=col-sm-6>
                            <td><label>Placa: </label></td>
                            <td>{$PLACA}{$VEHICULOID}{$USUARIO_ID}{$USUARIO_ACTUALIZA_ID}{$FECHA_ACTUALIZA}{$FECHA_REGISTRO}</td>              
                        </div>
                        <div class="col-sm-6">
                            <td><label>Marca: </label></td>
                            <td>{$MARCA}{$MARCAID}</td>
                        </div>
                        <div class=col-sm-6>
                            <td><label>Tipo Vehiculo: </label></td>
                            <td>{$TIPOVEHICULOID}</td>               
                        </div>
                        <div class="col-sm-6">
                            <td><label>Color: </label></td>
                            <td>{$COLOR}{$COLORID}</td>
                        </div>
                        <div class="col-sm-6">
                            <td><label>Nombre Conductor :</label></td>
                            <td>{$NOMBRECONDUCTOR}</td>
                        </div>
                        <div class="col-sm-6">
                            <td><label>Cedula Conductor :</label></td>
                            <td>{$CEDULACONDUCTOR}</td>              
                        </div>
                        
                        <div class="col-sm-6">
                           <td><label>Telefono Conductor: </label></td>
                           <td>{$TELCONDUCTOR}</td>  
                        </div>
                        
                        <div class="col-sm-6">
                           <td><label>Telefono Ayudante:</label></td>
                           <td>{$TELAYUDANTE}</td>
                        </div>
                        <div class="col-sm-6">
                            <td><label>Seguro Soat:</label></td>
                            <td>{$SOAT}</td>
                        </div>
                        <div class="col-sm-6">
                            <td><label>Tecnomecanica: </label></td>
                            <td>{$TECNOMECANICA}</td> 
                        </div>
                        <div class="col-sm-6">
                            <td><label>Estado: </label></td>
                            <td>{$ESTADO}</td>
                        </div>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="col-sm-5">
                        <label>Imagen :</label><br>
                    </div>
    				<div class="col-sm-5" id="cuadro_imagen_vehiculo" style="max-height: 400px; max-width: 400px;">
                        <div class="img">
    					<img src="" class="img-thumbnail zoomIt" id="imagen_preview" height="300px" width="360px">
                        </div>
    				</div>
    				<div class="col-sm-5">
                         {$IMAGEN}
    				</div>
    			</div>
    			<div class="col-sm-12" style="text-align: center">
    				{$GUARDAR}&nbsp;&nbsp;{$ACTUALIZAR}&nbsp;&nbsp;{$BORRAR}&nbsp;&nbsp;{$LIMPIAR}
    			</div>
            <div>
        </div>
    </fieldset>
    <fieldset>{$GRIDCrearVehiculo}</fieldset>
    {$FORM1END}
</body>
</html>