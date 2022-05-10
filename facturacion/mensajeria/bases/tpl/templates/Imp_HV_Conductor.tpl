<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

   <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />   
    <link type="text/css" rel="stylesheet" href="/velotax/framework/css/printer.css" /> 
	<script language="javascript" type="text/javascript" src="/velotax/framework/js/printer.js"></script>
    <title>Hoja de Vida - Conductor</title>
   </head>
  
  <body>
  
<table class="seccion"  align="center" border="0" cellpadding="0" cellspacing="0">

  <tbody>
    <tr>
      <td align="center" ><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="8%" rowspan="4" align="center" class="cellLeft" style="border-top:1px solid" ><img src="{$FOTO}" width="80" height="100" /></td>
          <td width="29%" rowspan="4" align="center" class="cellRight" style="border-top:1px solid"><span style="font-size:9px">Documento confidencial propiedad de COMPAÑÍA
TRANSPORTADORA velotax / Elaborado por
SQHSE velotax /Bajo LA Norma BASC
Versión 4 de 2012 / Funza 2012</span></td>
          <td width="18%" rowspan="4" align="center" class="cellRight" style="border-top:1px solid">HOJA DE VIDA CONDUCTOR</td>
          <td width="30%" rowspan="4" align="center" class="cellRight" style="border-top:1px solid"><img src="{$DATOSVEHICULO.logo}" width="180" height="80" /></td>
          <td width="15%" class="cellRight" style="border-top:1px solid">Código: FT 1-1</td>
        </tr>
        <tr>
          <td class="cellRight">Versión: 4</td>
        </tr>
        <tr>
          <td class="cellRight">Vigencia:</td>
        </tr>
        <tr>
          <td align="center" class="cellRight">Pág 1 de 2</td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td rowspan="1" >
      <table  border="0" cellpadding="0" cellspacing="0" width="100%">
        <tbody>
          <tr>
            <td width="56%" class="cellLeft" >CIUDAD : {$CIUDAD}</td>
            <td width="44%" colspan="1" rowspan="1" class="cellRight" >&nbsp;&nbsp;FECHA : {$FECHA}            </td>
          </tr>
        </tbody>
      </table>      </td>
    </tr>
    <tr >
      <td  class="cellTitle" >INFORMACION DEL CONDUCTOR</td>
    </tr>
    <tr>
      <td rowspan="1" >
      <table  border="0" cellpadding="0" cellspacing="0" width="100%">
        <tbody>
          <tr>
            <td width="322" class="cellLeft" ><label>NOMBRE : </label><div>{$NOMBRE1}</div></td>
            <td width="141" class="cellRight" ><label>NOMBRE : </label><div>{$NOMBRE2}</div></td>
            <td width="280" class="cellRight" ><label>APELLIDO : </label><div>{$APELLIDO1}</div></td>
            <td width="393" class="cellRight" ><label>APELLIDO : </label><div>{$APELLIDO2}</div></td>
          </tr>
          <tr>
            <td class="cellLeft" ><label>TIPO DOCUMENTO :</label><div>{$TIPOID}</div></td>
            <td class="cellRight" ><label>EXPEDIDA EN :</label><div>{$EXPEDIDAEN}</div></td>
            <td colspan="1" rowspan="1" class="cellRight" ><label>FECHA NACIMIENTO (DD/MM/AA):</label><div>{$FECHANAC}</div></td>
            <td class="cellRight" ><label>EDAD :</label><div>{$EDAD}</div></td>
          </tr>
          <tr>
            <td class="cellLeft" ><label>ESTATURA :</label><div>{$ESTATURA}</div></td>
            <td class="cellRight" ><label>TIPO SANGRE :</label><div>{$TIPOSANGRE}</div></td>
            <td colspan="2" rowspan="1" class="cellRight" ><label>SEÑALES PARTICULARES :</label><div>{$SENALES}</div></td>
          </tr>
          <tr>
            <td colspan="2" rowspan="1" class="cellLeft" ><label>ANTECEDENTES JUDICIALES :</label><div>{$ANTECEDENTES}</div></td>
            <td class="cellRight" ><label>LIBRETA MILITAR :</label><div>{$LIBRETA}</div></td>
            <td class="cellRight" ><label>EPS :</label><div>{$EPS}</div></td>
          </tr>
          <tr>
            <td class="cellLeft" ><label>ARP :</label><div>{$ARP}</div></td>
            <td colspan="2" rowspan="1" class="cellRight" ><label>LICENCIA DE CONDUCCION N° :</label><div>{$LICENCIA}</div></td>
            <td class="cellRight" ><label>CATEGORIA :</label><div>{$CATEGORIA}</div></td>
          </tr>
          <tr>
            <td class="cellLeft" ><label>FECHA VENCIMIENTO :</label><div>{$VENLICEN}</div></td>
            <td colspan="2" rowspan="1" class="cellRight" ><label>CIUDAD RESIDENCIA :</label><div>{$UBICACION}</div></td>
            <td class="cellRight" >{if $TIPOVIV eq 'P'}<div>PROPIA</div>{/if}{if $TIPOVIV eq 'A'}<div>ARRIENDO</div>{/if}</td>
          </tr>
          <tr>
            <td colspan="2" rowspan="1" class="cellLeft" ><label>BARRIO :</label><div>{$BARRIO}</div></td>
            <td class="cellRight" ><label>TELEFONO RESIDENCIA :</label><div>{$TELEFONO}</div></td>
            <td class="cellRight" ><label>CELULAR :</label><div>{$MOVIL}</div></td>
          </tr>
          <tr>
            <td colspan="2" rowspan="1" class="cellLeft" ><label>HACE CUANTO VIVE EN ESTE LUGAR:</label><div>{$ANTIGUEDAD}</div></td>
            <td class="cellRight" ><label>ESTADO CIVIL :</label><div>{$ESTADOCIVIL}</div></td>
            <td class="cellRight" ><label>NOMBRE DE LA ESPOSA, COMPAÑERA PERMANENTE :</label><div>{$CONTACTOCOND}</div></td>
          </tr>
          <tr>
            <td class="cellLeft" ><label>PERSONAS A CARGO :</label><div>{$PERSONASCARGO}</div></td>
            <td class="cellRight" ><label>N° HIJOS :</label><div>{$NUMEROHIJOS}</div></td>
            <td class="cellRight" ><label>NOMBRE ARRENDATARIO :</label><div>{$ARENDATARIO}</div></td>
            <td class="cellRight" ><label>TELEFONO :</label><div>{$TELEFONO}</div></td>
          </tr>
        </tbody>
      </table>      	  
	  </td>
    </tr>
    <tr>
      <td  rowspan="1" class="cellTitle" >AUTORIZACIÓN VERIFICACION DE DATOS</td>
    </tr>
    <tr>
      <td rowspan="1" class="infogeneral" style="text-align:justify" >
        1. AUTORIZO a la empresa COMPAÑÍA TRANSPORTADORA application SAS. para consultar, verificar, reportar, suministrar y analizar la información a partir de mi hoja de vida, a las centrales de información debidamente constituidas y autorizadas para tal fin. 
        2. AUTORIZO de igual manera para dicha información pueda ser utilizada para efectos de remitir los resultados a terceros, todo ello respetando las limitaciones impuestas por las normas legales, la constitución y por las autoridades competentes.
        3. DECLARO que conozco y acepto  las condiciones establecidas en la carta de compromiso y en la cartilla de instrucción para contratistas para el transporte de mercancías y que la información consignada en mi hoja vida es verídica.
      4. DILIGENCIO esta hoja de vida libre de todo apremio y coacción, en pleno uso de mis facultades mentales, así mismo manifiesto que toda la información suministrada en este documento es real y autorizo a la empresa para comprobarla y ratificarla por cualquier medio, y que se haga un estudio técnico y legal de la misma.      </td>
    </tr>
    <tr >
      <td rowspan="1" class="cellTitle" >SEÑOR CONDUCTOR: No se autorizaran viajes a
conductores que tengan comparendos por infracciones de tráfico
pendientes de pago, por un valor superior a Dos Millones de Pesos
($2,000,000,oo)      </td>
    </tr>
    <tr>
      <td rowspan="1" class="infogeneral">
      <table  border="0" cellpadding="0" cellspacing="0" width="100%">
        <tbody>
          <tr>
            <td>
            <table border="0" cellpadding="0" cellspacing="0" width="80%" style="margin-top:5px;margin-bottom:15px">
              <tbody>
                <tr>
                  <td align="left"><label>NOMBRE DEL CONDUCTOR :</label></td>
                  <td ><div>{$CONDUCTOR}</div></td>
                  <td align="left"><label>CEDULA :</label></td>
                  <td ><div>{$CEDULA}</div></td>
                </tr>
                <tr>
                  <td align="left"><label>FIRMA :</label></td>
                  <td ><div>{$FIRMA}</div></td>
                  <td >                  </td>
                  <td >                  </td>
                </tr>
              </tbody>
            </table>
                        </td>
          </tr>
          <tr>
            <td  align="center">
            <table  align="center" border="0" cellpadding="0" cellspacing="3" style="margin-bottom:10px">
              <tbody>
                <tr>
                  <td colspan="1" rowspan="1" >
                  <table width="132"  border="1" cellpadding="0" cellspacing="0" >
                    <tbody>
                      <tr>
                        <td width="128" height="97"  >
						  <img src="{$HUELLA1}" width="85" height="82" />						</td>
                      </tr>
                      <tr>
                        <td ><div>HUELLA ÍNDICE IZQ</div></td>
                      </tr>
                    </tbody>
                  </table>
                                    </td>
                  <td colspan="1" rowspan="1" ><table width="126"  border="1" cellpadding="0" cellspacing="0" >
                    <tbody>
                      <tr>
                        <td width="122" height="97"  ><img src="{$HUELLA2}" width="85" height="82" /> </td>
                      </tr>
                      <tr>
                        <td ><div>HUELLA PULGAR IZQ</div></td>
                      </tr>
                    </tbody>
                  </table>
                                      </td>
                  <td colspan="1" rowspan="1" ><table width="126"  border="1" cellpadding="0" cellspacing="0" >
                    <tbody>
                      <tr>
                        <td width="122" height="97"  ><img src="{$HUELLA3}" width="85" height="82" /> </td>
                      </tr>
                      <tr>
                        <td ><div>HUELLA PULGAR DER</div></td>
                      </tr>
                    </tbody>
                  </table>
                                      </td>
                  <td colspan="1" rowspan="1" >
				  <table width="126"  border="1" cellpadding="0" cellspacing="0" >
                    <tbody>
                      <tr>
                        <td width="122" height="97"  ><img src="{$HUELLA4}" width="85" height="82" /> </td>
                      </tr>
                      <tr>
                        <td ><div>HUELLA ÍNDICE DER</div></td>
                      </tr>
                    </tbody>
                  </table>                  </td>
                </tr>
                <tr>                </tr>
              </tbody>
            </table>            </td>
          </tr>
        </tbody>
      </table>      
      </td>
    </tr>
    <tr >
      <td rowspan="1" class="cellTitle" > (AÑOS 2009 EN ADELANTE) RELACIONE LAS
EMPRESAS POR LAS CUALES A HA CARGADO      </td>
    </tr>
    <tr>
      <td rowspan="1" >
	  <table width="100%" border="0"  cellpadding="0" cellspacing="0">
        <tr>
          <td width="41%" class="cellLeft" ><label>1.EMPRESA.</label><div>{$TIPOMERCANCIACARGO1}</div></td>
          <td width="27%" class="cellRight" ><label>CIUDAD:</label><div>{$CIUDADEMPRESACARGO1}</div></td>
          <td width="32%" class="cellRight" ><label>TELEFONO:</label><div>{$TELEFONOCARGO1}</div></td>
        </tr>
        <tr>
          <td class="cellLeft" ><label>NOMBRE PERSONA QUE ATENDIO </label><div>{$PERSONACARGO1}</div></td>
          <td class="cellRight" ><label>CARGO </label><div>{$CARGOCARGO1}</div></td>
          <td class="cellRight" ><label>CUANTO TIEMPO LLEVA CARANDO </label><div>{$TIEMPOCARGO1}</div></td>
        </tr>
        <tr>
          <td class="cellLeft" ><label>EN QUE RUTAS </label><div>{$RUTASCARGO1}</div></td>
          <td class="cellRight" ><label>QUE TIPO DE MERCANCIA </label><div>{$TIPOMERCANCIACARGO1}</div></td>
          <td class="cellRight" ><label>CUANTOS VIAJES A REALIZADO </label><div>{$VIAJESREALIZADOSCARGO1}</div></td>
        </tr>
		
		        <tr>
          <td width="41%" class="cellLeft" ><label>2.EMPRESA. </label><div>{$TIPOMERCANCIACARGO2}</div></td>
          <td width="27%" class="cellRight" ><label>CIUDAD: </label><div>{$CIUDADEMPRESACARGO2}</div></td>
          <td width="32%" class="cellRight" ><label>TELEFONO: </label><div>{$TELEFONOCARGO2}</div></td>
        </tr>
        <tr>
          <td class="cellLeft" ><label>NOMBRE PERSONA QUE ATENDIO</label> <div>{$PERSONACARGO2}</div></td>
          <td class="cellRight" ><label>CARGO </label><div>{$CARGOCARGO2}</div></td>
          <td class="cellRight" ><label>CUANTO TIEMPO LLEVA CARANDO</label> <div>{$TIEMPOCARGO2}</div></td>
        </tr>
        <tr>
          <td class="cellLeft" ><label>EN QUE RUTAS </label><div>{$RUTASCARGO2}</div></td>
          <td class="cellRight" ><label>QUE TIPO DE MERCANCIA</label> <div> {$TIPOMERCANCIACARGO2}</div></td>
          <td class="cellRight" ><label>CUANTOS VIAJES A REALIZADO </label><div>{$VIAJESREALIZADOSCARGO2}</div></td>
        </tr>
		
		        <tr>
          <td width="41%" class="cellLeft" ><label>3.EMPRESA.</label> <div>{$TIPOMERCANCIACARGO3}</div></td>
          <td width="27%" class="cellRight" ><label>CIUDAD: </label><div>{$CIUDADEMPRESACARGO3}</div></td>
          <td width="32%" class="cellRight" ><label>TELEFONO: </label><div>{$TELEFONOCARGO3}</div></td>
        </tr>
        <tr>
          <td class="cellLeft" ><label>NOMBRE PERSONA QUE ATENDIO</label> <div>{$PERSONACARGO3}</div></td>
          <td class="cellRight" ><label>CARGO </label><div>{$CARGOCARGO3}</div></td>
          <td class="cellRight" ><label>CUANTO TIEMPO LLEVA CARANDO</label> <div>{$TIEMPOCARGO3}</div></td>
        </tr>
        <tr>
          <td class="cellLeft" ><label>EN QUE RUTAS</label> <div>{$RUTASCARGO3}</div></td>
          <td class="cellRight" ><label>QUE TIPO DE MERCANCIA </label><div>{$TIPOMERCANCIACARGO3}</div></td>
          <td class="cellRight" ><label>CUANTOS VIAJES A REALIZADO </label><div>{$VIAJESREALIZADOSCARGO3}</div></td>
        </tr>		
      </table></td>
    </tr>
    <tr >
      <td  align="center" class="cellTitle"><label>REFERENCIAS FAMILIARES </label></td>
    </tr>
    <tr>
      <td rowspan="1" ><table width="100%" border="0"  cellpadding="0" cellspacing="0">
        <tr>
          <td class="cellLeft" ><label>1.PERSONA</label> <div>{$REFERENCIA1}</div></td>
          <td class="cellRight" ><label>CIUDAD:</label> <div>{$CIUDADREFERENCIA1}</div></td>
          <td class="cellRight" ><label>TELÉFONO: </label><div>{$TELEFONOREFERENCIA1}</div></td>
        </tr>
        <tr>
          <td class="cellLeft" ><label>1.PERSONA </label><div>{$REFERENCIA2}</div></td>
          <td class="cellRight" ><label>CIUDAD: </label><div>{$CIUDADREFERENCIA2}</div></td>
          <td class="cellRight" ><label>TELÉFONO: </label><div>{$TELEFONOREFERENCIA2}</div></td>
        </tr>
		<tr>
          <td class="cellLeft" ><label>1.PERSONA </label> <div>{$REFERENCIA3}</div></td>
          <td class="cellRight" ><label>CIUDAD: </label><div>{$CIUDADREFERENCIA3}</div></td>
          <td class="cellRight" ><label>TELÉFONO:</label><div>{$TELEFONOREFERENCIA3}</div></td>
        </tr>
      </table></td>
    </tr>
  </tbody>
</table>
</body>
</html>