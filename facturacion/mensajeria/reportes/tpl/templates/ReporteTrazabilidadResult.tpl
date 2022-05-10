<html>
  <head>
  {$JAVASCRIPT}
  {$CSSSYSTEM} 
  {$TITLETAB}        
  </head>
  
  <body>
    
    <table border="1" width="90%" align="center">
	  <td colspan="8" align="center"> DATOS DEL DESPACHO </td>
      <td colspan="8" align="center"> DATOS DEL FLETE </td>
      <td colspan="9" align="center"> LIQUIDACION DEL FLETE </td>
      <td colspan="2" align="center"> PAGO FLETE </td>
      <td colspan="6" align="center"> FACTURA FLETE </td>
      <td colspan="6" align="center"> RENTABILIDAD FLETE </td>
    <tr align="center"> 
      <td colspan="8" align="center">.</td>
      <td colspan="1" align="center">.</td>  
      <td colspan="2" align="center"> ANTICIPO 1 </td>
      <td colspan="2" align="center"> ANTICIPO 2 </td>
      <td colspan="3" align="center">.</td> 
      <td colspan="9" align="center">.</td>
      <td colspan="2" align="center">.</td>
      <td colspan="6" align="center">.</td>
      <td colspan="2" align="center">.</td>
     <tr align="center">      
      <td align="center"> NUMERO DESPACHO </td>
	  <td align="center"> FECHA </td>
	  <td align="center"> NUMERO REMESA </td>	  
	  <td align="center"> CLIENTE </td>		  
	  <td align="center"> CIUDAD ORIGEN </td>		  	  
	  <td align="center"> CIUDAD DESTINO </td>	  	  	  	  	  
	  <td align="center"> PLACA VEHICULO </td>		  	  	  	  	  	  
	  <td align="center"> TENEDOR </td>        
      <td align="center"> FLETE PACTADO </td> 
      <td align="center"> VALOR </td>
      <td align="center"> NUMERO EGRESO </td>
      <td align="center"> VALOR </td>
      <td align="center"> NUMERO EGRESO </td>
      <td align="center"> VALOR RETEFUENTE </td>
      <td align="center"> VALOR ICA </td> 
      <td align="center"> SALDO POR PAGAR </td>
      <td align="center"> MAYOR VALOR FLETE </td>        
      <td align="center"> DCTO. PAPELERIA </td> 
      <td align="center"> DCTO. SEGURO </td>
      <td align="center"> DCTO. ASISCAR </td>
      <td align="center"> DCTO. AVERIAS </td>
      <td align="center"> DCTO. NO REPORTES </td>
      <td align="center"> DCTO. MORA CUMP. </td>
      <td align="center"> DCTO. TRANSF. </td> 
      <td align="center"> DCTO. CARGUE </td>
      <td align="center"> SALDO A PAGAR. </td> 
      <td align="center"> NUMERO EGRESO PAGO </td>
      <td align="center"> NUMERO FACTURA </td>
      <td align="center"> FECHA FACTURA </td>
      <td align="center"> VALOR FACTURA </td> 
      <td align="center"> NUMERO RECIBO </td>
      <td align="center"> FECHA PAGO </td> 
      <td align="center"> VALOR PAGADO </td>
      <td align="center"> VALOR UTILIDAD </td> 
      <td align="center"> % RENTABILIDAD </td>
	 </tr>	

     {assign var="total_rtefuente" value="0"}
     {assign var="total_rteica" value="0"}
     {assign var="total_anticipo1" value="0"}
     {assign var="total_dtopapel" value="0"}
     {assign var="total_dtoseguro" value="0"}
     {assign var="total_dtoaveria" value="0"}
     {assign var="total_dtonoreporte" value="0"}
     {assign var="total_dtomora" value="0"}
     {assign var="total_dtoasiscar" value="0"}
     {assign var="total_dtotransfe" value="0"}
     {assign var="total_dtocargue" value="0"}
     {assign var="saldo_pagar" value="0"}
                          
     {counter start=0 skip=1 assign=i} 
     {foreach name=remesas from=$DATA item=r}
     
     {assign var="anticipo" value=','|explode:$r.VR_ANTICIPO}
     {assign var="negreso" value=','|explode:$r.N_EGRESO}     
     {assign var="dtopapel" value=','|explode:$r.DCTO_PAPELERIA}     
     {assign var="dtoseguro" value=','|explode:$r.DCTO_SEGURO}  
     {assign var="dtoaveria" value=','|explode:$r.DCTO_AVERIAS}  
     {assign var="dtonoreporte" value=','|explode:$r.DCTO_NOREPORTES}    
     {assign var="dtomora" value=','|explode:$r.DCTO_MORA}
     {assign var="nepago" value=','|explode:$r.NE_PAGO}

       
     {math assign="saldo_pagar"  equation="(X+A+B-D-E-F-G)"  X=$saldo_pagar  A=$r.VR_SOBREFLETE  B=$r.SALDO_PAGAR C=$dtopapel[0] D=$dtoseguro[0]
       E=$dtoaveria[0] F=$dtonoreporte[0] G=$dtomora[0]}
             
     <tr>	 
	  <td>{$N_DESPACHO}</td>
	  <td align="center"> {$r.FECHA_REMESA} </td>
	  <td align="center"> {$r.N_REMESA} </td>
	  <td>{$r.CLIENTE} </td>
	  <td align="center"> {$r.CIUDAD_ORIGEN} </td>           
	  <td align="center"> {$r.CIUDAD_DESTINO} </td>
	  <td align="center"> {$r.PLACA_VEHICULO} </td>	  
	  <td> {$r.TENEDOR} </td>	
      <td align="center"> ${$r.VR_FLETE} </td> 
      <td align="center"> ${$anticipo[$i]} </td>
      <td align="center"> {$negreso[$i]} </td>
      <td align="center"> 0 </td>
      <td align="center"> - </td>
      <td align="center"> ${$r.VR_RETEFUENTE} </td>
      <td align="center"> 0 </td>
      <td align="center"> ${$r.SALDO_PAGAR} </td> 
      <td align="center"> ${$r.VR_SOBREFLETE} </td>
      <td align="center"> ${$dtopapel[0]} </td>
      <td align="center"> ${$dtoseguro[0]} </td>
      <td align="center"> 0 </td>
      <td align="center"> ${$dtoaveria[0]} </td>
      <td align="center"> ${$dtonoreporte[0]} </td>
      <td align="center"> ${$dtomora[0]} </td>
      <td align="center"> 0 </td> 
      <td align="center"> 0 </td> 
      <td align="center"> ${$saldo_pagar} </td> 
      <td align="center"> {$nepago[$i]} </td>
      <td align="center"> 0 </td>
      <td align="center"> 0 </td>
      <td align="center"> 0 </td> 
      <td align="center"> 0 </td> 
      <td align="center"> 0 </td> 
      <td align="center"> 0 </td>
      <td align="center"> 0 </td> 
      <td align="center"> 0 </td>
	 </tr>
               
      {assign var="saldo_pagar" value="0"}
      {math assign="total_rtefuente"     equation="(X+Y)"   X=$total_rtefuente       Y=$r.VR_RETEFUENTE}	 
      {math assign="total_rteica"        equation="(X+Y)"   X=$total_rteica          Y=0} 
      {math assign="total_anticipo1"     equation="(X+Y)"   X=$total_anticipo1       Y=$valor[0]}      
      {math assign="total_dtopapel"  	 equation="(X+Y)" 	X=$total_dtopapel        Y=$dtopapel[0]}
      {math assign="total_dtoseguro"  	 equation="(X+Y)" 	X=$total_dtoseguro       Y=$dtoseguro[0]}
      {math assign="total_dtoasiscar"    equation="(X+Y)" 	X=$total_dtoasiscar      Y=0}
      {math assign="total_dtoaveria"     equation="(X+Y)" 	X=$total_dtoaveria       Y=$dtoaveria[0]}
      {math assign="total_dtonoreporte"  equation="(X+Y)" 	X=$total_dtonoreporte    Y=$dtonoreporte[0]}
      {math assign="total_dtomora"       equation="(X+Y)" 	X=$total_dtomora         Y=$dtomora[0]}      
      {math assign="total_dtotransfe"    equation="(X+Y)" 	X=$total_dtotransfe      Y=0}
      {math assign="total_dtocargue"     equation="(X+Y)" 	X=$total_dtocargue       Y=0}
               
      {counter}{/foreach}
 
	 <tr>
	  <td align="right">TOTALES :</td>
      <td align="center"> - </td>
      <td align="center"> - </td>
      <td align="center"> - </td>
      <td align="center"> - </td>
      <td align="center"> - </td>
      <td align="center"> - </td>
      <td align="center"> - </td>
	  <td align="center"> - </td>
	  <td align="center"> ${$total_anticipo1} </td>
      <td align="center"> - </td>
	  <td align="center"> $0 </td>	  
	  <td align="center"> - </td>
      <td align="center"> ${$total_rtefuente} </td>
      <td align="center"> ${$total_rteica} </td>	
      <td align="center"> - </td>
      <td align="center"> - </td>
      <td align="center"> ${$total_dtopapel} </td>
      <td align="center"> ${$total_dtoseguro} </td>
      <td align="center"> ${$total_dtoasiscar} </td>
      <td align="center"> ${$total_dtonoaveria} </td>
      <td align="center"> ${$total_dtoreporte} </td>
      <td align="center"> ${$total_dtomora} </td>  
      <td align="center"> ${$total_dtotransfe} </td>
      <td align="center"> ${$total_dtocargue} </td>	
      <td align="center"> $0 </td>
      <td align="center"> -  </td>
      <td align="center"> - </td>
      <td align="center"> - </td>
      <td align="center"> $0 </td>
      <td align="center"> - </td>
      <td align="center"> - </td> 
      <td align="center"> $0 </td>
      <td align="center"> $0 </td>
      <td align="center"> % </td> 
	 </tr>		 
	 
	</table>
  
  </body>
</html>