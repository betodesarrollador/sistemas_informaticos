<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
 <meta http-equiv="content-type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="sistemas_informaticos/framework/css/bootstrap1.css">
 {$JAVASCRIPT}
 {$TABLEGRIDJS}
 {$CSSSYSTEM}{$TABLEGRIDCSS}{$TITLETAB} 
</head>


<body>
	<fieldset>
    <legend>{$TITLEFORM}</legend>
    <div id="table_find" align="center">
      <table>
        <tr>
          <td><label>Busqueda : </label></td>
        </tr>
        <tr>
          <td>{$BUSQUEDA}</td>
        </tr>
      </table>
    </div>
   {$FORM1}
   <fieldset class="section">
    <table align="center">
      {$USUARIOID}
      {$FECHAREGISTRO}
      {$USUARIOACTUALIZAID}
      {$FECHAACTUALIZA}
      
      <tr>
        <td><label>Código Entrada : </label></td>
        <td>{$ENTRADAID}</td>
      </tr>
      <tr>
        <td><label>Fecha: </label></td>
        <td>{$FECHA}</td>
      </tr>
      <tr>
         <td><label>Recepcion: </label></td>
        <td>{$RECEPCION}{$RECEPCIONID}</td>
      </tr>
       <tr>
        <td><label>Estado : </label></td>
        <td>{$ESTADO}</td>
      </tr>
          <tr>
           <td colspan="10"><br><br><br><br>{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$ANULAR}&nbsp;{$BORRAR}&nbsp;{$LIMPIAR}</td>
         </tr>
       </table>
       <br>
        <table width="100%">
            <tr>
                <td align="right" > 
                     <!--<input type="button" id="saveDetalleInventario" class="btn btn-dark" value="Ingresar a Inventario" title="Ingresar a inventario">-->
                     <input type="button" id="saveDetalle" class="btn btn-dark" value="Ingresar Seleccionados a Inventario" title="Ingresar Seleccionados">
                </td>
           </tr>
        </table>
       <div  align="center" ><iframe id="DetalleEntrada" frameborder="0" height="250px"></iframe></div>

     </fieldset>
     <fieldset>{$GRIDENTRADA}</fieldset>
   </fieldset>
   <div id="divAnulacion">
            <fieldset class="section">
                <form onSubmit="return false">
                    <table>
                        <tr>
                            <td><label>Fecha Anulacion :</label></td>
                            <td><label>{$FECHAANULACION}</label></td>
                        </tr>
                        <tr>
                            <td><label>Observacion:</label></td>
                            <td><label>{$OBSERVACIONANULACION}{$USUARIOANULA}</label></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center">{$ANULAR}</td>
                        </tr>
                    </table>
                </form>
            </fieldset>
        </div> 

   {$FORM1END}

 </body>
 </html>