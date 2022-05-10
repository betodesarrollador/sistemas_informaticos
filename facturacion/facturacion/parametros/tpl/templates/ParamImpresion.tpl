<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
   <link rel="stylesheet" href="../../../framework/css/bootstrap1.css">
   <script src="../../../framework/clases/tinymce_4.4.1_dev/tinymce/js/tinymce/tinymce.min.js"></script>
  {$JAVASCRIPT}
  {$TABLEGRIDJS}
  {$CSSSYSTEM} 
  {$TABLEGRIDCSS}
  {$TITLETAB}
</head>

<body>
    <div class="col">
    <fieldset>
        <legend>{$TITLEFORM}</legend> 
        {$FORM1}
        <fieldset class="section">
           <legend>DETALLES REMESA</legend> 
           <table align="center" id="tableParamDetImpresion" width="98%">
            <thead>
            <tr>
                <th>REMESA</th>		
                <th>FECHA</th>		
                <th>PESO</th>
                <th>PLACA</th> 
                <th>DESCRIPCION</th>
                <th>ORIGEN</th>   
                <th>PASADOR VIAL</th> 
                <th>DESTINO</th> 
                <th>DOC CLIENTE</th>
                <th>MANIFIESTO</th>        
                <th>V/TONELADA</th> 
                <th>DESCRIPCION PRODUCTO</th> 
                <th>OBSERVACION UNO</th>  
                <th>OBSERVACION DOS</th> 
                <th>VALOR DECLARADO</th> 
                <th>CANTIDAD CARGADA</th>
                <th>CANTIDAD</th> 
                <th>VALOR UNITARIO</th> 
                <th>VALOR TOTAL</th> 
                
            </tr>
            </thead>
            <tbody>	
            <tr>
                <td>       
                <input type="hidden" name="parametro_impresion_id" value="" class="required" />        	
                <input type="checkbox" name="remesa">
                <td>
                <input type="checkbox" name="fecha_remesa">
                </td>        		                
                <td>
                    <input type="checkbox" name="peso">       
                </td>
                <td>
                    <input type="checkbox" name="placa">
                </td>
                <td>
                    <input type="checkbox" name="descripcion_remesa">
                </td>
                <td>
                    <input type="checkbox" name="origen">
                </td>
                <td>
                    <input type="checkbox" name="pasador_vial">
                </td>
                <td>
                    <input type="checkbox" name="destino">
                </td>
                <td>
                    <input type="checkbox" name="doc_cliente">
                </td>
                <td>
                    <input type="checkbox" name="manifiesto">
                </td>
                <td>
                    <input type="checkbox" name="valor_tonelada">
                </td>
                <td>
                    <input type="checkbox" name="descripcion_producto">
                </td>
                <td>
                    <input type="checkbox" name="observacion_uno">
                </td>
                <td>
                    <input type="checkbox" name="observacion_dos">
                </td>
                <td>
                    <input type="checkbox" name="valor_declarado">
                </td>
                <td>
                    <input type="checkbox" name="cantidad_cargada">
                </td>
                <td>
                    <input type="checkbox" name="cantidad_producto">
                </td>
                <td>
                    <input type="checkbox" name="valor_unitario_remesa">
                </td>
                <td>
                    <input type="checkbox" name="valor_total" checked disabled>
                </td>
                
            </tr> 
            </tbody>
        </table>
        </fieldset>

         <fieldset class="section">
           <legend>DETALLES ORDEN</legend> 
           <table align="center" id="tableParamDetImpresion" width="98%">
            <thead>
            <tr>
                
                <th>ORDEN</th>		
                <th>FECHA</th>		
                <th>DESCRIPCION</th>
                <th>CANTIDAD</th> 
                <th>VALOR UNITARIO</th> 
                <th>VALOR TOTAL</th> 
               
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>       
                <input type="checkbox" name="orden">
                <input type="hidden" name="parametro_impresion_id" value="" class="required" />        		
                <td>
                <input type="checkbox" name="fecha_orden">
                </td>        		                
                <td>
                    <input type="checkbox" name="descripcion_orden">
                </td>
                <td>
                    <input type="checkbox" name="cantidad" checked disabled>
                </td>
                <td>
                    <input type="checkbox" name="valor_unitario" checked disabled>
                </td>
                <td>
                    <input type="checkbox" name="valor_total" checked disabled>
                </td>
                
            </tr> 
            </tbody>
        </table>
        </fieldset>

         <fieldset class="section">
         <div class="row">
            <div class="col-md-3">
                <label>Aplica formato impresi&oacute;n con detalles como anexos : </label>
                <div style="width:250px">{$FORMATOIMP}</div>
            </div>  
            <div class="col-md-3">
                <label>Impuestos visibles en impresi&oacute;n : </label>
                <div style="width:250px">{$IMPUESTOSVISIBLES}</div>
            </div> 
            <div class="col">
                <label>Detalles factura visibles en impresi&oacute;n : </label>
                <div style="width:250px">{$DETALLESVISIBLES}</div>
            </div>  
            <div class="col">
                <label>Aplica cabecera por cada p&aacute;gina : </label>
                <div style="width:250px">{$CABECERAPAGINA}</div>
            </div>     
        </div>
           
         </fieldset>

        <fieldset class="section">
        <div align="center" width="60%">
            <div>
                <label>Observacion Encabezado : </label>
            </div>
            <br><br>
            <div>
                {$OBSENCABEZADO}
            </div>
            <br>
             <div>
                <label>Pie de Pagina : </label>
            </div>
            <br><br>
            <div>
                {$PIEPAGINA}
            </div>
            <br>
            <div>
                <label>logo Adjunto max (4 MB):</label>
                <div id="adjuntover">&nbsp;</div>  
                <div id="fileUpload">{$PARAMETROID}{$LOGO}</div>
            </div>
            <br>
            <div>
                  {$ACTUALIZAR}
            </div>
        </div>
        
        </fieldset> 

		
	</fieldset> 
    </div>
</body>
</html>