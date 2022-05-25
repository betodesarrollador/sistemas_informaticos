 {literal}
<style>
/* CSS Document */
   .tipoDocumento{
    font-family:Arial, Helvetica, sans-serif;
	font-size:10px;
	font-weight:bold;
	text-align:center
   }
   
   .numeroDocumento{
     font-family:Arial, Helvetica, sans-serif;
	 font-size:18px;
	 font-weight:bold;
	 text-align:center;
   }
   
   .subtitulos{
     font-family:Arial, Helvetica, sans-serif;
	 font-size:12px;
	 font-weight:bold;
   }
   
   .contenido{
     font-family:Arial, Helvetica, sans-serif;
	 font-size:12px;
   }
   .borderTop{
     border-top:1px solid;
   }
   table tr td{
      font-size:12px;
   }
     
   .title{
     background-color:#EAEAEA;
	 font-weight:bold;
	 text-align:center;
   }
   
   .fontBig{
     font-size:10px;
   }
   
   .infoGeneral{
	 border-left:1px solid;   
	 border-right:1px solid;   	 
	 border-bottom:1px solid;   	 	 
	 text-align:center;
   }
   
   .cellTitle{
     background-color:#E6E6E6;
	 font-weight:bold;
	 border-left:1px solid;   
	 border-right:1px solid;   	 
	 border-bottom:1px solid;   	 	 
   }
   
   .cellRight{
     border-right:1px solid;
	 border-bottom:1px solid;
 	 padding: 3px;
	 
   }
   .cellRightRed{
   	 border-left:1px solid;
     border-right:1px solid;
	 border-bottom:1px solid;	
 	 padding: 3px;
	 color:#F00;
	 
   }
   
   .cellLeft{
     border-left:1px solid;
     border-right:1px solid;
	 border-bottom:1px solid;
	 padding: 3px;
   }
   .cellCenter{
     border-left:1px solid;
     border-right:1px solid;
	 border-bottom:1px solid;
   }
   .cellTitleLeft{
     border-left:1px solid;
     border-right:1px solid;
	 border-bottom:1px solid; 
	 border-top:1px solid;
     background-color:#E6E6E6;
	 font-weight:bold;
   }   
   
   .cellTitleRight{
     border-right:1px solid;
	 border-bottom:1px solid;   
	 border-top:1px solid;	 
     background-color:#E6E6E6;
	 font-weight:bold;
   }
   
   body{
    padding:0px;
   }
   
   .content{
    font-weight:bold;
	font-size:12px;
	text-transform:uppercase;
   }
   .table_firmas{
    font-weight:bold;
	font-size:14px;
	margin-top:1px;
   }
   .anulado{
	   width:500px;
	   margin-top:180px;
	   margin-left:230px;
	   position:absolute;
	   font-weight:bold;
	   color:#FBCDBF;
	   font-size:60px;
	   opacity:0.1;
	   filter:alpha(opacity=40);
   }
   .anulado1{
	   width:500px;
	   margin-top:400px;
	   margin-left:230px;
	   position:absolute;
	   font-weight:bold;
	   color:#FBCDBF;
	   font-size:60px;
	   opacity:0.1;
	   filter:alpha(opacity=40);
   }
   .realizado{
	   width:500px;
	   margin-top:180px;
	   margin-left:230px;
	   position:absolute;
	   font-weight:bold;
	   color:#A0F5AB;
	   font-size:60px;
	   opacity:0.1;
	   filter:alpha(opacity=40);
   }
   .realizado1{
	   width:500px;
	   margin-top:400px;
	   margin-left:230px;
	   position:absolute;
	   font-weight:bold;
	   color:#A0F5AB;
	   font-size:60px;
	   opacity:0.1;
	   filter:alpha(opacity=40);
   }
   .normal{
	   height:30px;
   }
</style>
{/literal}

    <page orientation="portrait" >   

<table style="margin-left:15px; margin-top:30px;"  cellpadding="0" cellspacing="0" width="100%" align="center">
    <tr align="center">
        <td width="90" align="left" valign="top">LOGO</td>
        <td>
            <strong>&nbsp;SISTEMAS INFORMATICOS & SOLUCIONES INTEGRALES SAS</strong><br />
            AGENCIA &nbsp;PRINCIPAL<br />
        </td>
		<td width="150" valign="top" align="right">
            RANGO DE FECHAS
        </td>
    </tr>
</table>
<br />

<br />

<table cellspacing="0" cellpadding="0" width="100%" border="0" align="center">
    <tr align="center">
    <td  width="50" class="cellTitleRight">TAREA</td>
       <td  width="130" class="cellTitleRight">DESARROLLADOR</td>
        <td  width="130" class="cellTitleRight">FECHA INICIAL</td>
        <td  width="130" class="cellTitleRight">FECHA FINAL</td>
   </tr>
    {foreach name=detalles from=$DETALLES item=i}                 
    <tr>
    <td class="cellLeft contenido">&nbsp;{$i.nombre}</td>
         <td class="cellLeft contenido">&nbsp;{$i.primer_nombre}  {$i.primer_apellido}</td>
         <td class="cellRight contenido">&nbsp;{$i.fecha_inicial}</td>
        <td class="cellRight contenido">&nbsp;{$i.fecha_cierre_real}</td>
    </tr>
    {/foreach}
</table>
</page>

  
  

    
    
