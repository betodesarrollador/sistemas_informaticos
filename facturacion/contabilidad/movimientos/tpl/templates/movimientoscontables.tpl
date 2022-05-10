<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="../../../framework/css/bootstrap1.css"> 
  {$JAVASCRIPT}
  {$CSSSYSTEM} 
  {$TITLETAB}      
  </head>
  <body>
	{$FORM1}
    <fieldset>
    <legend>{$TITLEFORM}</legend>
        <div id="table_find">
        	<table align="center">
            	<tr>
              <td><label>Documento :</label></td>
                    <td>{$TIPOSDOCUMENTOID2}</td>
                	<td><label>Busqueda : </label></td>
                    <td>{$BUSQUEDA}</td>
                </tr>
            </table>
        </div>
    </fieldset>
    {$FECHAREGISTROSTATIC}{$MODIFICASTATIC}{$USUARIOIDSTATIC}
    <fieldset class="section">
      <table align="center">
          <tr>
            <td><label>Fecha Reg :</label></td>
            <td>{$FECHAREG}{$FECHAREGISTRO}</td>
            <td><label>Usuario : </label></td>
            <td>{$MODIF}{$MODIFICA}{$USUARIOID}</td>
            <td><label>Empresa : </label></td>
            <td>{$EMPRESASID}</td>
          </tr>        
          <tr>
            <td><label>N&deg; : </label></td>
            <td>{$CONSECUTIVO}{$ENCABEZADOID}</td>
            <td><label>Documento :</label></td>
            <td>{$TIPOSDOCUMENTOID}</td>
            <td><label>Sucursal : </label></td>
            <td>{$OFICINASID}</td>
          </tr>
          <tr>
            <td><label>Fecha :</label></td>
            <td>{$FECHA}</td>
            <td><label>F. pago :</label></td><td>{$FPAGO}</td>
            <td><label>Cuenta Pago :</label></td>
            <td><span>{$PUCID}</span></td>
          </tr>
          <tr>
            <td><label>Valor :</label></td>
            <td>{$VALOR}</td>
            <td>{$TEXTOSOPORTE}</td>
            <td>{$NUMEROSOPORTE}</td>
            <td><label>Cpto : </label></td>
            <td>{$CONCEPTO}</td>
          </tr> 
          <tr>
            <td>{$TEXTOTERCERO}</td>
            <td colspan="3">{$TERCERO}{$TERCEROID}</td>
            <td><label>Scan : </label></td>
            <td>{$SCAN}</td>
          </tr> 
          <tr>
            <td><label>Estado :</label></td>
            <td colspan="3">{$ESTADO}{$ANULADO}{$MSJ_ANULADO}</td>
            <td><label style="color:green">Modulo de procedencia</label></td>
            <td><label>{$MODULO}</label></td>
          </tr>                                                                      
    </table>
    <fieldset>
        <table width="100%">
		  <tr><td colspan="3"><table width="100%">
            <tr>
              <td width="11%" id="loading">&nbsp;</td>
              <td width="60%" align="center">{$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$ANULAR}&nbsp;{$IMPRIMIR}&nbsp;{$EXCEL}&nbsp;{$LIMPIAR}</td>
              <td width="30%" align="right" ><input name="button" type="button" class="buttonDetalle btn btn-dark" id="saveImputacionesContables" value="Guardar Detalles" />
                  <input name="button2" type="button" class="buttonDetalle btn btn-dark" id="deleteImputacionesContables" value="Borrar Detalles" />
              </td>
            </tr>
          </table></td></tr>
          <tr><td colspan="3"><iframe id="movimientosContables" frameborder="0" marginheight="0" marginwidth="0"></iframe></td></tr>
          <tr>
            <td align="left" width="30%">{$CONTABILIZAR}</td>
            <td align="center"><b>Ctrl+t = Tercero Ctrl+c=Concepto</b></td>
            <td align="right" width="30%"><table>
              <tr>
                <td><label>DEBITO :</label></td>
                <td><span id="totalDebito">0</span></td>
                <td><label>CREDITO:</label></td>
                <td><span id="totalCredito">0</span></td>
                <td><label>DIFERENCIA:</label></td>
                <td><span id="totalDiferencia">0</span></td>                
              </tr>
            </table></td>
          </tr>
        </table>        
      {$FORM1END}
    </fieldset>
    
    <div id="divAnulacion">
      <form>
        <table>       
          <tr>
            <td><label>Fecha / Hora :</label></td>
            <td>{$FECHALOG}</td>
          </tr>          
          <tr>
            <td><label>Causal :</label></td>
            <td>{$CAUSALESID}</td>
          </tr>
          <tr>
            <td><label>Descripcion :</label></td>
            <td>{$OBSERVACIONES}</td>
          </tr> 
          <tr>
            <td colspan="2" align="center">{$ANULAR}</td>
          </tr>                    
        </table>
      </form>
    </div>
       
  </body>
</html>