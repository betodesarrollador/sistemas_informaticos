<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="sistemas_informaticos/bodega/bases/css/bootstrap1.css">
    <link rel="stylesheet" href="sistemas_informaticos/bodega/bases/css/detalles.css">
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
            <table style="width: 720px; margin: 0 auto;">
                <tr>
                    <td><label>Busqueda : </label></td>
                </tr>
                <tr>
                    <td>{$BUSQUEDA}</td>
                </tr>
            </table>
        </div>
    </fieldset>
    {$FORM1}
    <fieldset class="section">

    	<div class="container-fluid">
    		<div class="row">
    			<div class="col-sm-8">
    				<div class="row">
	    				<div class="col-sm-6">
	    					<label>Nombre  : </label>
	                        {$NOMBRE}{$PRODUCTOID}
	    				</div>
	    				<div class="col-sm-6">
	    					<label>Codigo Int  : </label>
	                        {$CODIGO}
	    				</div>
	    				<div class="col-sm-6">
	    					<label>Ref. proveedor : </label>
                            {$REFERENCIA}
	    				</div>
	    				<!--<div class="col-sm-6">
	    					<label>Linea Producto  : </label>
                            {$LINEAPRODUCTO}{$LINEAPRODUCTOID}
	    				</div>-->
	    				<div class="col-sm-6">
	    					<label>C&oacute;digo Barra  : </label>
                            {$CODIGOBARRA}
	    				</div>
	    				<div class="col-sm-6">
	    					<label>Descripci&oacute;n  : </label>
                            {$DESCRIPCION}{$FECHAINICIO}{$FECHAFINAL}
	    				</div>
	    				<div class="col-sm-6">
	    					<label>Tipo Empaque : </label>
                            {$EMPAQUE}
	    				</div>
	    				<div class="col-sm-6">
	    					<label>Unidad de Medida : </label>
                            {$MEDIDA}
	    				</div>
	    				<div class="col-sm-6" style="display: none;">
	    					 <label>Proveedor  : </label>
                             {$PROVEEDOR}{$PROVEEDORID}
	    				</div>
	    				<div class="col-sm-6">
	    					<br><label>Stock M&iacute;nimo  : </label>
                            {$STOCKMIN}
	    				</div>
	    			    <div class="col-sm-6">
	    			    	<br><label>Stock M&aacute;ximo : </label>
                            {$STOCKMAX}
	    				</div>
	    				<div class="col-sm-6">
	    					<label>Tipo Venta  : </label>
                            {$TIPOVENTA}
	    				</div>
	    				<div class="col-sm-6">
	    					<label>Estado  : </label>
                            {$ESTADO}</td>
	    				</div>
                        <div class="col-sm-6">
                            <label>Impuestos : </label>
                            {$IVA}
                        </div>
                        <div class="col-sm-6" id="impuesto" style="display:none">
                            <label>Impuesto : </label>
                            {$IMPUESTO}
                        </div>
    			    </div>
    			</div>
    			<div class="col-sm-4">
                    <div class="col-sm-4">
                        <label>Imagen :</label><br>
                    </div>
    				<div class="col-sm-4" id="cuadro_imagen_producto" style="max-height: 400px; max-width: 400px;">
                        <div class="img">
    					<img src="" class="img-thumbnail zoomIt" id="imagen_preview" height="300px" width="360px">
                        </div>
    				</div>
    				<div class="col-sm-4">
                         {$IMAGEN}
    				</div>
    			</div>
    			<div class="col-sm-12" style="text-align: center">
    				{$GUARDAR}&nbsp;&nbsp;{$ACTUALIZAR}&nbsp;&nbsp;{$BORRAR}&nbsp;&nbsp;{$LIMPIAR}
    			</div>
    		</div>
    	</div>
        
        <table id="toolbar">
            <tbody>
                <tr>
                    <td id="messages"><div>&nbsp;</div></td>
                    <td id="detailToolbar">
                    <img src="../../../framework/media/images/grid/save.png" id="saveDetalles" title="Guardar Seleccionados">
                    <img src="../../../framework/media/images/grid/no.gif" id="deleteDetalles" title="Borrar Seleccionados">
                    </td>
                    <td id="fileUpload">{$ARCHIVOSOLICITUD}</td>
                </tr>               
            </tbody>
        </table>
        <div><iframe name="detalleProducto" id="detalleProducto" src="about:blank" class="detallePrecios"></iframe></div>
        <div><iframe name="detalleProcesado" id="detalleProcesado" src="about:blank"></iframe></div>
        <div><iframe name="kardexrapido" id="kardexrapido" src="about:blank" class="kardexrapido"></iframe></div>
     </fieldset>
    <fieldset>{$GRIDPARAMETROS}</fieldset>

    {$FORM1END}
   
</body>
</html>