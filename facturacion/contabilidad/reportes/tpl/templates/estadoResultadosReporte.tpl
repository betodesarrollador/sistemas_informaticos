<html>
  <head>
    <title>Balance General</title>
	{$JAVASCRIPT}		
    {$CSSSYSTEM} 	
  </head>
  
  <body>
  
    <table width="80%" align="center" id="encabezado" border="0">
	  <tr><td align="center" colspan="3" class="header">{$EMPRESA} </td></tr>
	  <tr><td colspan="3" align="center" class="header">Nit. {$NIT}</td></tr>
	  <tr><td colspan="3">&nbsp;</td></tr>	  
	  <tr><td align="center" colspan="3" class="header">ESTADO DE RESULTADOS</td></tr>	 	 	   
	  <tr><td align="center" colspan="3" class="header">DESDE: {$DESDE} - HASTA: {$HASTA}</td></tr>	 	   
	  <tr><td align="center" colspan="3" class="header">(Valores Expresados en pesos Colombianos)</td></tr>	 	   	  
	  <tr><td align="center" colspan="3" class="header">Centros : {$CENTROS}</td></tr>	 	   	  	  	  
	</table>  
	<br><br>
	{if $AGRUPAR eq 'F'}
    {assign var="columnas"             value="1"}
    	<table width="80%" align="center" cellpadding="3" class="table_general" >
            <thead>
              <tr align="center" class="title" >
                
                <th   align="center">CODIGO</th>
                <th   align="center">CUENTA</th>
                <th  align="center">SALDO ANTERIOR</th>			
                {if $MESINICIO lte 1 AND 1 lte $MESFIN}<th   align="center">ENERO</th>{math assign="columnas" equation="x + y" x=$columnas y=1}{/if}			
                {if $MESINICIO lte 2 AND 2 lte $MESFIN}<th  align="center">FEBRERO</th>{math assign="columnas" equation="x + y" x=$columnas y=1}{/if}			
                {if $MESINICIO lte 3 AND 3 lte $MESFIN}<th  align="center">MARZO</th>{math assign="columnas" equation="x + y" x=$columnas y=1}{/if}				
                {if $MESINICIO lte 4 AND 4 lte $MESFIN}<th  align="center">ABRIL</th>{math assign="columnas" equation="x + y" x=$columnas y=1}{/if}			
                {if $MESINICIO lte 5 AND 5 lte $MESFIN}<th   align="center">MAYO</th>{math assign="columnas" equation="x + y" x=$columnas y=1}{/if}
                {if $MESINICIO lte 6 AND 6 lte $MESFIN}<th align="center">JUNIO</th>{math assign="columnas" equation="x + y" x=$columnas y=1}{/if}
                {if $MESINICIO lte 7 AND 7 lte $MESFIN}<th align="center">JULIO</th>{math assign="columnas" equation="x + y" x=$columnas y=1}{/if}
                {if $MESINICIO lte 8 AND 8 lte $MESFIN}<th  align="center">AGOSTO</th>{math assign="columnas" equation="x + y" x=$columnas y=1}{/if}
                {if $MESINICIO lte 9 AND 9 lte $MESFIN}<th align="center">SEPTIEMBRE</th>{math assign="columnas" equation="x + y" x=$columnas y=1}{/if}
                {if $MESINICIO lte 10 AND 10 lte $MESFIN}<th  align="center">OCTUBRE</th>{math assign="columnas" equation="x + y" x=$columnas y=1}{/if}
                {if $MESINICIO lte 11 AND 11 lte $MESFIN}<th align="center">NOVIEMBRE</th>{math assign="columnas" equation="x + y" x=$columnas y=1}{/if}
                {if $MESINICIO lte 12 AND 12 lte $MESFIN}<th  align="center">DICIEMBRE</th>{math assign="columnas" equation="x + y" x=$columnas y=1}{/if}
                
                 <th  align="center">TOTAL</th>	
                 <th  align="center">PROMEDIO</th>	
                 	
                
                											
              </tr>
            </thead>
            <tbody>
            
            {assign var="total_4"             value="0"}
            {assign var="total_5"             value="0"}
            {assign var="total_6"             value="0"}
            {assign var="total_7"             value="0"}

			{assign var="total_saldo_4"  value="0"}
            {assign var="promedio"  value="0"}
            {assign var="promedio_total"  value="0"}
            
            {assign var="total_ene_4"             value="0"}
            {assign var="total_feb_4"             value="0"}
            {assign var="total_mar_4"             value="0"}
            {assign var="total_abr_4"             value="0"}
            {assign var="total_may_4"             value="0"}
            {assign var="total_jun_4"             value="0"}
            {assign var="total_jul_4"             value="0"}
            {assign var="total_ago_4"             value="0"}
            {assign var="total_sep_4"             value="0"}
            {assign var="total_oct_4"             value="0"}
            {assign var="total_nov_4"             value="0"}
            {assign var="total_dic_4"             value="0"}
            
            
            <!--Clase 4-->
             {foreach name=detalles from=$DETALLES4 item=i}
             {if $i.total neq 0}
             <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">
             <td align="left" >{$i.codigo}</td>
             <td align="left" >{$i.cuenta}</td>
             <td align="right" >{$i.saldo|number_format:0:",":"."} {math assign="total_saldo_4" equation="x + y" x=$total_saldo_4 y=$i.saldo}</td>
             {if $MESINICIO lte 1 AND 1 lte $MESFIN}<td align="right" >{$i.enero|number_format:0:",":"."}</td>{math assign="total_ene_4" equation="x + y" x=$total_ene_4 y=$i.enero}{/if}
             {if $MESINICIO lte 2 AND 2 lte $MESFIN}<td align="right" >{$i.febrero|number_format:0:",":"."}</td>{math assign="total_feb_4" equation="x + y" x=$total_feb_4 y=$i.febrero}{/if}
             {if $MESINICIO lte 3 AND 3 lte $MESFIN}<td align="right" >{$i.marzo|number_format:0:",":"."}</td>{math assign="total_mar_4" equation="x + y" x=$total_mar_4 y=$i.marzo}{/if}
             {if $MESINICIO lte 4 AND 4 lte $MESFIN}<td align="right" >{$i.abril|number_format:0:",":"."}</td>{math assign="total_abr_4" equation="x + y" x=$total_abr_4 y=$i.abril}{/if}
             {if $MESINICIO lte 5 AND 5 lte $MESFIN}<td align="right" >{$i.mayo|number_format:0:",":"."}</td>{math assign="total_may_4" equation="x + y" x=$total_may_4 y=$i.mayo}{/if}
             {if $MESINICIO lte 6 AND 6 lte $MESFIN}<td align="right" >{$i.junio|number_format:0:",":"."}</td>{math assign="total_jun_4" equation="x + y" x=$total_jun_4 y=$i.junio}{/if}
             {if $MESINICIO lte 7 AND 7 lte $MESFIN}<td align="right" >{$i.julio|number_format:0:",":"."}</td>{math assign="total_jul_4" equation="x + y" x=$total_jul_4 y=$i.julio}{/if}
             {if $MESINICIO lte 8 AND 8 lte $MESFIN}<td align="right" >{$i.agosto|number_format:0:",":"."}</td>{math assign="total_ago_4" equation="x + y" x=$total_ago_4 y=$i.agosto}{/if}
             {if $MESINICIO lte 9 AND 9 lte $MESFIN}<td align="right" >{$i.septiembre|number_format:0:",":"."}</td>{math assign="total_sep_4" equation="x + y" x=$total_sep_4 y=$i.septiembre}{/if}
             {if $MESINICIO lte 10 AND 10 lte $MESFIN}<td align="right" >{$i.octubre|number_format:0:",":"."}</td>{math assign="total_oct_4" equation="x + y" x=$total_oct_4 y=$i.octubre}{/if}
             {if $MESINICIO lte 11 AND 11 lte $MESFIN}<td align="right" >{$i.noviembre|number_format:0:",":"."}</td>{math assign="total_nov_4" equation="x + y" x=$total_nov_4 y=$i.noviembre}{/if}
             {if $MESINICIO lte 12 AND 12 lte $MESFIN}<td align="right" >{$i.diciembre|number_format:0:",":"."}</td>{math assign="total_dic_4" equation="x + y" x=$total_dic_4 y=$i.diciembre}{/if}
             <td align="right" >{$i.total|number_format:0:",":"."} </td>
             {math assign="promedio" equation="x / y" x=$i.total y=$columnas}
             <td align="right" >{$promedio|number_format:0:",":"."} </td>
             	{math assign="total_4" equation="x + y" x=$total_4 y=$i.total}
             </tr>
             {/if}
             {/foreach}
             
             <tr class="total">
               <td align="left" colspan="2">TOTAL INGRESOS </td>
               <td   align="right">{$total_saldo_4|number_format:0:",":"."}</td>
                    {if $MESINICIO lte 1 AND 1 lte $MESFIN}<td   align="right">{$total_ene_4|number_format:0:",":"."}</td>{/if}			
                    {if $MESINICIO lte 2 AND 2 lte $MESFIN}<td  align="right">{$total_feb_4|number_format:0:",":"."}</td>{/if}			
                    {if $MESINICIO lte 3 AND 3 lte $MESFIN}<td  align="right">{$total_mar_4|number_format:0:",":"."}</td>{/if}				
                    {if $MESINICIO lte 4 AND 4 lte $MESFIN}<td  align="right">{$total_abr_4|number_format:0:",":"."}</td>{/if}			
                    {if $MESINICIO lte 5 AND 5 lte $MESFIN}<td   align="right">{$total_may_4|number_format:0:",":"."}</td>{/if}		
                    {if $MESINICIO lte 6 AND 6 lte $MESFIN}<td align="right">{$total_jun_4|number_format:0:",":"."}</td>{/if}		
                    {if $MESINICIO lte 7 AND 7 lte $MESFIN}<td align="right">{$total_jul_4|number_format:0:",":"."}</td>{/if}		
                    {if $MESINICIO lte 8 AND 8 lte $MESFIN}<td  align="right">{$total_ago_4|number_format:0:",":"."}</td>{/if}		
                    {if $MESINICIO lte 9 AND 9 lte $MESFIN}<td align="right">{$total_sep_4|number_format:0:",":"."}</td>{/if}		
                    {if $MESINICIO lte 10 AND 10 lte $MESFIN}<td  align="right">{$total_oct_4|number_format:0:",":"."}</td>{/if}		
                    {if $MESINICIO lte 11 AND 11 lte $MESFIN}<td align="right">{$total_nov_4|number_format:0:",":"."}</td>{/if}		
                    {if $MESINICIO lte 12 AND 12 lte $MESFIN}<td  align="right">{$total_dic_4|number_format:0:",":"."}</td>{/if}		
             		<td align="right">{$total_4|number_format:0:",":"."}</td>
                    {math assign="promedio_total" equation="x / y" x=$total_4 y=$columnas}
             		<td align="right" >{$promedio_total|number_format:0:",":"."} </td>
               
             </tr>
             
             {assign var="total_ene_5"             value="0"}
            {assign var="total_feb_5"             value="0"}
            {assign var="total_mar_5"             value="0"}
            {assign var="total_abr_5"             value="0"}
            {assign var="total_may_5"             value="0"}
            {assign var="total_jun_5"             value="0"}
            {assign var="total_jul_5"             value="0"}
            {assign var="total_ago_5"             value="0"}
            {assign var="total_sep_5"             value="0"}
            {assign var="total_oct_5"             value="0"}
            {assign var="total_nov_5"             value="0"}
            {assign var="total_dic_5"             value="0"}
            
            {assign var="promedio"  value="0"}
            {assign var="promedio_total"  value="0"}
            
            
            {assign var="total_saldo_5"  value="0"}
            
             <!--Clase 5-->
             {foreach name=detalles from=$DETALLES5 item=i}
             {if $i.total neq 0}
             <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">
             <td align="left" >{$i.codigo}</td>
             <td align="left" >{$i.cuenta}</td>
             <td align="right" >{$i.saldo|number_format:0:",":"."}{math assign="total_saldo_5" equation="x + y" x=$total_saldo_5 y=$i.saldo} </td>
             {if $MESINICIO lte 1 AND 1 lte $MESFIN}<td align="right" >{$i.enero|number_format:0:",":"."}</td>{math assign="total_ene_5" equation="x + y" x=$total_ene_5 y=$i.enero}{/if}
             {if $MESINICIO lte 2 AND 2 lte $MESFIN}<td align="right" >{$i.febrero|number_format:0:",":"."}</td>{math assign="total_feb_5" equation="x + y" x=$total_feb_5 y=$i.febrero}{/if}
             {if $MESINICIO lte 3 AND 3 lte $MESFIN}<td align="right" >{$i.marzo|number_format:0:",":"."}</td>{math assign="total_mar_5" equation="x + y" x=$total_mar_5 y=$i.marzo}{/if}
             {if $MESINICIO lte 4 AND 4 lte $MESFIN}<td align="right" >{$i.abril|number_format:0:",":"."}</td>{math assign="total_abr_5" equation="x + y" x=$total_abr_5 y=$i.abril}{/if}
             {if $MESINICIO lte 5 AND 5 lte $MESFIN}<td align="right" >{$i.mayo|number_format:0:",":"."}</td>{math assign="total_may_5" equation="x + y" x=$total_may_5 y=$i.mayo}{/if}
             {if $MESINICIO lte 6 AND 6 lte $MESFIN}<td align="right" >{$i.junio|number_format:0:",":"."}</td>{math assign="total_jun_5" equation="x + y" x=$total_jun_5 y=$i.junio}{/if}
             {if $MESINICIO lte 7 AND 7 lte $MESFIN}<td align="right" >{$i.julio|number_format:0:",":"."}</td>{math assign="total_jul_5" equation="x + y" x=$total_jul_5 y=$i.julio}{/if}
             {if $MESINICIO lte 8 AND 8 lte $MESFIN}<td align="right" >{$i.agosto|number_format:0:",":"."}</td>{math assign="total_ago_5" equation="x + y" x=$total_ago_5 y=$i.agosto}{/if}
             {if $MESINICIO lte 9 AND 9 lte $MESFIN}<td align="right" >{$i.septiembre|number_format:0:",":"."}</td>{math assign="total_sep_5" equation="x + y" x=$total_sep_5 y=$i.septiembre}{/if}
             {if $MESINICIO lte 10 AND 10 lte $MESFIN}<td align="right" >{$i.octubre|number_format:0:",":"."}</td>{math assign="total_oct_5" equation="x + y" x=$total_oct_5 y=$i.octubre}{/if}
             {if $MESINICIO lte 11 AND 11 lte $MESFIN}<td align="right" >{$i.noviembre|number_format:0:",":"."}</td>{math assign="total_nov_5" equation="x + y" x=$total_nov_5 y=$i.noviembre}{/if}
             {if $MESINICIO lte 12 AND 12 lte $MESFIN}<td align="right" >{$i.diciembre|number_format:0:",":"."}</td>{math assign="total_dic_5" equation="x + y" x=$total_dic_5 y=$i.diciembre}{/if}
              <td align="right" >{$i.total|number_format:0:",":"."} </td>
             	{math assign="total_5" equation="x + y" x=$total_5 y=$i.total}
                {math assign="promedio" equation="x / y" x=$i.total y=$columnas}
             	<td align="right" >{$promedio|number_format:0:",":"."} </td>
             </tr>
             {/if}
             {/foreach}
             
             <tr class="total">
                 <td align="left" colspan="2">TOTAL GASTOS </td>
                     <td   align="right">{$total_saldo_5|number_format:0:",":"."}</td>
                    {if $MESINICIO lte 1 AND 1 lte $MESFIN}<td   align="right">{$total_ene_5|number_format:0:",":"."}</td>{/if}			
                    {if $MESINICIO lte 2 AND 2 lte $MESFIN}<td  align="right">{$total_feb_5|number_format:0:",":"."}</td>{/if}			
                    {if $MESINICIO lte 3 AND 3 lte $MESFIN}<td  align="right">{$total_mar_5|number_format:0:",":"."}</td>{/if}				
                    {if $MESINICIO lte 4 AND 4 lte $MESFIN}<td  align="right">{$total_abr_5|number_format:0:",":"."}</td>{/if}			
                    {if $MESINICIO lte 5 AND 5 lte $MESFIN}<td   align="right">{$total_may_5|number_format:0:",":"."}</td>{/if}		
                    {if $MESINICIO lte 6 AND 6 lte $MESFIN}<td align="right">{$total_jun_5|number_format:0:",":"."}</td>{/if}		
                    {if $MESINICIO lte 7 AND 7 lte $MESFIN}<td align="right">{$total_jul_5|number_format:0:",":"."}</td>{/if}		
                    {if $MESINICIO lte 8 AND 8 lte $MESFIN}<td  align="right">{$total_ago_5|number_format:0:",":"."}</td>{/if}		
                    {if $MESINICIO lte 9 AND 9 lte $MESFIN}<td align="right">{$total_sep_5|number_format:0:",":"."}</td>{/if}		
                    {if $MESINICIO lte 10 AND 10 lte $MESFIN}<td  align="right">{$total_oct_5|number_format:0:",":"."}</td>{/if}		
                    {if $MESINICIO lte 11 AND 11 lte $MESFIN}<td align="right">{$total_nov_5|number_format:0:",":"."}</td>{/if}		
                    {if $MESINICIO lte 12 AND 12 lte $MESFIN}<td  align="right">{$total_dic_5|number_format:0:",":"."}</td>{/if}
                     <td align="right">{$total_5|number_format:0:",":"."}</td>
                      {math assign="promedio_total" equation="x / y" x=$total_5 y=$columnas}
             		<td align="right" >{$promedio_total|number_format:0:",":"."} </td>
                  
             </tr>
             
             
             {assign var="total_ene_6"             value="0"}
            {assign var="total_feb_6"             value="0"}
            {assign var="total_mar_6"             value="0"}
            {assign var="total_abr_6"             value="0"}
            {assign var="total_may_6"             value="0"}
            {assign var="total_jun_6"             value="0"}
            {assign var="total_jul_6"             value="0"}
            {assign var="total_ago_6"             value="0"}
            {assign var="total_sep_6"             value="0"}
            {assign var="total_oct_6"             value="0"}
            {assign var="total_nov_6"             value="0"}
            {assign var="total_dic_6"             value="0"}
            
            {assign var="promedio"  value="0"}
            {assign var="promedio_total"  value="0"}
            
            
            {assign var="total_saldo_6"  value="0"}
            
             <!--Clase 6-->
             {foreach name=detalles from=$DETALLES6 item=i}
             {if $i.total neq 0}
             <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">
             <td align="left" >{$i.codigo}</td>
             <td align="left" >{$i.cuenta}</td>
             <td align="right" >{$i.saldo|number_format:0:",":"."}{math assign="total_saldo_6" equation="x + y" x=$total_saldo_6 y=$i.saldo} </td>
             {if $MESINICIO lte 1 AND 1 lte $MESFIN}<td align="right" >{$i.enero|number_format:0:",":"."}</td>{math assign="total_ene_6" equation="x + y" x=$total_ene_6 y=$i.enero}{/if}
             {if $MESINICIO lte 2 AND 2 lte $MESFIN}<td align="right" >{$i.febrero|number_format:0:",":"."}</td>{math assign="total_feb_6" equation="x + y" x=$total_feb_6 y=$i.febrero}{/if}
             {if $MESINICIO lte 3 AND 3 lte $MESFIN}<td align="right" >{$i.marzo|number_format:0:",":"."}</td>{math assign="total_mar_6" equation="x + y" x=$total_mar_6 y=$i.marzo}{/if}
             {if $MESINICIO lte 4 AND 4 lte $MESFIN}<td align="right" >{$i.abril|number_format:0:",":"."}</td>{math assign="total_abr_6" equation="x + y" x=$total_abr_6 y=$i.abril}{/if}
             {if $MESINICIO lte 5 AND 5 lte $MESFIN}<td align="right" >{$i.mayo|number_format:0:",":"."}</td>{math assign="total_may_6" equation="x + y" x=$total_may_6 y=$i.mayo}{/if}
             {if $MESINICIO lte 6 AND 6 lte $MESFIN}<td align="right" >{$i.junio|number_format:0:",":"."}</td>{math assign="total_jun_6" equation="x + y" x=$total_jun_6 y=$i.junio}{/if}
             {if $MESINICIO lte 7 AND 7 lte $MESFIN}<td align="right" >{$i.julio|number_format:0:",":"."}</td>{math assign="total_jul_6" equation="x + y" x=$total_jul_6 y=$i.julio}{/if}
             {if $MESINICIO lte 8 AND 8 lte $MESFIN}<td align="right" >{$i.agosto|number_format:0:",":"."}</td>{math assign="total_ago_6" equation="x + y" x=$total_ago_6 y=$i.agosto}{/if}
             {if $MESINICIO lte 9 AND 9 lte $MESFIN}<td align="right" >{$i.septiembre|number_format:0:",":"."}</td>{math assign="total_sep_6" equation="x + y" x=$total_sep_6 y=$i.septiembre}{/if}
             {if $MESINICIO lte 10 AND 10 lte $MESFIN}<td align="right" >{$i.octubre|number_format:0:",":"."}</td>{math assign="total_oct_6" equation="x + y" x=$total_oct_6 y=$i.octubre}{/if}
             {if $MESINICIO lte 11 AND 11 lte $MESFIN}<td align="right" >{$i.noviembre|number_format:0:",":"."}</td>{math assign="total_nov_6" equation="x + y" x=$total_nov_6 y=$i.noviembre}{/if}
             {if $MESINICIO lte 12 AND 12 lte $MESFIN}<td align="right" >{$i.diciembre|number_format:0:",":"."}</td>{math assign="total_dic_6" equation="x + y" x=$total_dic_6 y=$i.diciembre}{/if}
             <td align="right" >{$i.total|number_format:0:",":"."} </td>
             	{math assign="total_6" equation="x + y" x=$total_6 y=$i.total}
                {math assign="promedio" equation="x / y" x=$i.total y=$columnas}
             	<td align="right" >{$promedio|number_format:0:",":"."} </td>
             </tr>
             {/if}
             {/foreach}
             
             <tr class="total">
             	<td align="left" colspan="2">TOTAL COSTOS DE VENTAS </td>
                 <td   align="right">{$total_saldo_6|number_format:0:",":"."}</td>
                    {if $MESINICIO lte 1 AND 1 lte $MESFIN}<td   align="right">{$total_ene_6|number_format:0:",":"."}</td>{/if}			
                    {if $MESINICIO lte 2 AND 2 lte $MESFIN}<td  align="right">{$total_feb_6|number_format:0:",":"."}</td>{/if}			
                    {if $MESINICIO lte 3 AND 3 lte $MESFIN}<td  align="right">{$total_mar_6|number_format:0:",":"."}</td>{/if}				
                    {if $MESINICIO lte 4 AND 4 lte $MESFIN}<td  align="right">{$total_abr_6|number_format:0:",":"."}</td>{/if}			
                    {if $MESINICIO lte 5 AND 5 lte $MESFIN}<td   align="right">{$total_may_6|number_format:0:",":"."}</td>{/if}		
                    {if $MESINICIO lte 6 AND 6 lte $MESFIN}<td align="right">{$total_jun_6|number_format:0:",":"."}</td>{/if}		
                    {if $MESINICIO lte 7 AND 7 lte $MESFIN}<td align="right">{$total_jul_6|number_format:0:",":"."}</td>{/if}		
                    {if $MESINICIO lte 8 AND 8 lte $MESFIN}<td  align="right">{$total_ago_6|number_format:0:",":"."}</td>{/if}		
                    {if $MESINICIO lte 9 AND 9 lte $MESFIN}<td align="right">{$total_sep_6|number_format:0:",":"."}</td>{/if}		
                    {if $MESINICIO lte 10 AND 10 lte $MESFIN}<td  align="right">{$total_oct_6|number_format:0:",":"."}</td>{/if}		
                    {if $MESINICIO lte 11 AND 11 lte $MESFIN}<td align="right">{$total_nov_6|number_format:0:",":"."}</td>{/if}		
                    {if $MESINICIO lte 12 AND 12 lte $MESFIN}<td  align="right">{$total_dic_6|number_format:0:",":"."}</td>{/if}
             	 	<td align="right">{$total_6|number_format:0:",":"."}</td>
                     {math assign="promedio_total" equation="x / y" x=$total_6 y=$columnas}
             		<td align="right" >{$promedio_total|number_format:0:",":"."} </td>
                 
             </tr>
             
             
             {assign var="total_ene_7"             value="0"}
            {assign var="total_feb_7"             value="0"}
            {assign var="total_mar_7"             value="0"}
            {assign var="total_abr_7"             value="0"}
            {assign var="total_may_7"             value="0"}
            {assign var="total_jun_7"             value="0"}
            {assign var="total_jul_7"             value="0"}
            {assign var="total_ago_7"             value="0"}
            {assign var="total_sep_7"             value="0"}
            {assign var="total_oct_7"             value="0"}
            {assign var="total_nov_7"             value="0"}
            {assign var="total_dic_7"             value="0"}
            
            {assign var="promedio"  value="0"}
            {assign var="promedio_total"  value="0"}
            
            
            {assign var="total_saldo_7"  value="0"}
            
            
             <!--Clase 7-->
             {foreach name=detalles from=$DETALLES7 item=i}
             {if $i.total neq 0}
             <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">
             <td align="left" >{$i.codigo}</td>
             <td align="left" >{$i.cuenta}</td>
             <td align="right" >{$i.saldo|number_format:0:",":"."}{math assign="total_saldo_7" equation="x + y" x=$total_saldo_7 y=$i.saldo} </td>
             {if $MESINICIO lte 1 AND 1 lte $MESFIN}<td align="right" >{$i.enero|number_format:0:",":"."}</td>{math assign="total_ene_7" equation="x + y" x=$total_ene_7 y=$i.enero}{/if}
             {if $MESINICIO lte 2 AND 2 lte $MESFIN}<td align="right" >{$i.febrero|number_format:0:",":"."}</td>{math assign="total_feb_7" equation="x + y" x=$total_feb_7 y=$i.febrero}{/if}
             {if $MESINICIO lte 3 AND 3 lte $MESFIN}<td align="right" >{$i.marzo|number_format:0:",":"."}</td>{math assign="total_mar_7" equation="x + y" x=$total_mar_7 y=$i.marzo}{/if}
             {if $MESINICIO lte 4 AND 4 lte $MESFIN}<td align="right" >{$i.abril|number_format:0:",":"."}</td>{math assign="total_abr_7" equation="x + y" x=$total_abr_7 y=$i.abril}{/if}
             {if $MESINICIO lte 5 AND 5 lte $MESFIN}<td align="right" >{$i.mayo|number_format:0:",":"."}</td>{math assign="total_may_7" equation="x + y" x=$total_may_7 y=$i.mayo}{/if}
             {if $MESINICIO lte 6 AND 6 lte $MESFIN}<td align="right" >{$i.junio|number_format:0:",":"."}</td>{math assign="total_jun_7" equation="x + y" x=$total_jun_7 y=$i.junio}{/if}
             {if $MESINICIO lte 7 AND 7 lte $MESFIN}<td align="right" >{$i.julio|number_format:0:",":"."}</td>{math assign="total_jul_7" equation="x + y" x=$total_jul_7 y=$i.julio}{/if}
             {if $MESINICIO lte 8 AND 8 lte $MESFIN}<td align="right" >{$i.agosto|number_format:0:",":"."}</td>{math assign="total_ago_7" equation="x + y" x=$total_ago_7 y=$i.agosto}{/if}
             {if $MESINICIO lte 9 AND 9 lte $MESFIN}<td align="right" >{$i.septiembre|number_format:0:",":"."}</td>{math assign="total_sep_7" equation="x + y" x=$total_sep_7 y=$i.septiembre}{/if}
             {if $MESINICIO lte 10 AND 10 lte $MESFIN}<td align="right" >{$i.octubre|number_format:0:",":"."}</td>{math assign="total_oct_7" equation="x + y" x=$total_oct_7 y=$i.octubre}{/if}
             {if $MESINICIO lte 11 AND 11 lte $MESFIN}<td align="right" >{$i.noviembre|number_format:0:",":"."}</td>{math assign="total_nov_7" equation="x + y" x=$total_nov_7 y=$i.noviembre}{/if}
             {if $MESINICIO lte 12 AND 12 lte $MESFIN}<td align="right" >{$i.diciembre|number_format:0:",":"."}</td>{math assign="total_dic_7" equation="x + y" x=$total_dic_7 y=$i.diciembre}{/if}
             <td align="right" >{$i.total|number_format:0:",":"."} </td>
             	{math assign="total_7" equation="x + y" x=$total_7 y=$i.total}
                {math assign="promedio" equation="x / y" x=$i.total y=$columnas}
             <td align="right" >{$promedio|number_format:0:",":"."} </td>
             </tr>
             {/if}
             {/foreach}
             
             <tr class="total">
                  <td  colspan="2" align="left"> TOTAL COSTOS DE PRODUCCION </td>
                     <td   align="right">{$total_saldo_7|number_format:0:",":"."}</td>
                    {if $MESINICIO lte 1 AND 1 lte $MESFIN}<td   align="right">{$total_ene_7|number_format:0:",":"."}</td>{/if}			
                    {if $MESINICIO lte 2 AND 2 lte $MESFIN}<td  align="right">{$total_feb_7|number_format:0:",":"."}</td>{/if}			
                    {if $MESINICIO lte 3 AND 3 lte $MESFIN}<td  align="right">{$total_mar_7|number_format:0:",":"."}</td>{/if}				
                    {if $MESINICIO lte 4 AND 4 lte $MESFIN}<td  align="right">{$total_abr_7|number_format:0:",":"."}</td>{/if}			
                    {if $MESINICIO lte 5 AND 5 lte $MESFIN}<td   align="right">{$total_may_7|number_format:0:",":"."}</td>{/if}		
                    {if $MESINICIO lte 6 AND 6 lte $MESFIN}<td align="right">{$total_jun_7|number_format:0:",":"."}</td>{/if}		
                    {if $MESINICIO lte 7 AND 7 lte $MESFIN}<td align="right">{$total_jul_7|number_format:0:",":"."}</td>{/if}		
                    {if $MESINICIO lte 8 AND 8 lte $MESFIN}<td  align="right">{$total_ago_7|number_format:0:",":"."}</td>{/if}		
                    {if $MESINICIO lte 9 AND 9 lte $MESFIN}<td align="right">{$total_sep_7|number_format:0:",":"."}</td>{/if}		
                    {if $MESINICIO lte 10 AND 10 lte $MESFIN}<td  align="right">{$total_oct_7|number_format:0:",":"."}</td>{/if}		
                    {if $MESINICIO lte 11 AND 11 lte $MESFIN}<td align="right">{$total_nov_7|number_format:0:",":"."}</td>{/if}		
                    {if $MESINICIO lte 12 AND 12 lte $MESFIN}<td  align="right">{$total_dic_7|number_format:0:",":"."}</td>{/if}
                    <td align="right">{$total_7|number_format:0:",":"."}</td>
                     {math assign="promedio_total" equation="x / y" x=$total_7 y=$columnas}
             		<td align="right" >{$promedio_total|number_format:0:",":"."} </td>
                 
             </tr>
             <tr><td>&nbsp;</td></tr>
              {math assign="total_final" equation="x -(y+w+z)" x=$total_4 y=$total_5 w=$total_6 z=$total_7}
              
              {math assign="total_final_ene" equation="x -(y+w+z)" x=$total_ene_4 y=$total_ene_5 w=$total_ene_6 z=$total_ene_7}
              {math assign="total_final_feb" equation="x -(y+w+z)" x=$total_feb_4 y=$total_feb_5 w=$total_feb_6 z=$total_feb_7}
              {math assign="total_final_mar" equation="x -(y+w+z)" x=$total_mar_4 y=$total_mar_5 w=$total_mar_6 z=$total_mar_7}
              {math assign="total_final_abr" equation="x -(y+w+z)" x=$total_abr_4 y=$total_abr_5 w=$total_abr_6 z=$total_abr_7}
              {math assign="total_final_may" equation="x -(y+w+z)" x=$total_may_4 y=$total_may_5 w=$total_may_6 z=$total_may_7}
              {math assign="total_final_jun" equation="x -(y+w+z)" x=$total_jun_4 y=$total_jun_5 w=$total_jun_6 z=$total_jun_7}
              {math assign="total_final_jul" equation="x -(y+w+z)" x=$total_jul_4 y=$total_jul_5 w=$total_jul_6 z=$total_jul_7}
              {math assign="total_final_ago" equation="x -(y+w+z)" x=$total_ago_4 y=$total_ago_5 w=$total_ago_6 z=$total_ago_7}
              {math assign="total_final_sep" equation="x -(y+w+z)" x=$total_sep_4 y=$total_sep_5 w=$total_sep_6 z=$total_sep_7}
              {math assign="total_final_oct" equation="x -(y+w+z)" x=$total_oct_4 y=$total_oct_5 w=$total_oct_6 z=$total_oct_7}
              {math assign="total_final_nov" equation="x -(y+w+z)" x=$total_nov_4 y=$total_nov_5 w=$total_nov_6 z=$total_nov_7}
              {math assign="total_final_dic" equation="x -(y+w+z)" x=$total_dic_4 y=$total_dic_5 w=$total_dic_6 z=$total_dic_7}
              
              {math assign="total_final_saldo" equation="x -(y+w+z)" x=$total_saldo_4 y=$total_saldo_5 w=$total_saldo_6 z=$total_saldo_7}
              
             <tr align="center" >
                
                <th colspan="2"  align="center">&nbsp;</th>
                <th  align="center">SALDO ANTERIOR</th>	
                {if $MESINICIO lte 1 AND 1 lte $MESFIN}<th   align="center">ENERO</th>{math assign="columnas" equation="x + y" x=$columnas y=1}{/if}			
                {if $MESINICIO lte 2 AND 2 lte $MESFIN}<th  align="center">FEBRERO</th>{math assign="columnas" equation="x + y" x=$columnas y=1}{/if}			
                {if $MESINICIO lte 3 AND 3 lte $MESFIN}<th  align="center">MARZO</th>{math assign="columnas" equation="x + y" x=$columnas y=1}{/if}				
                {if $MESINICIO lte 4 AND 4 lte $MESFIN}<th  align="center">ABRIL</th>{math assign="columnas" equation="x + y" x=$columnas y=1}{/if}			
                {if $MESINICIO lte 5 AND 5 lte $MESFIN}<th   align="center">MAYO</th>{math assign="columnas" equation="x + y" x=$columnas y=1}{/if}
                {if $MESINICIO lte 6 AND 6 lte $MESFIN}<th align="center">JUNIO</th>{math assign="columnas" equation="x + y" x=$columnas y=1}{/if}
                {if $MESINICIO lte 7 AND 7 lte $MESFIN}<th align="center">JULIO</th>{math assign="columnas" equation="x + y" x=$columnas y=1}{/if}
                {if $MESINICIO lte 8 AND 8 lte $MESFIN}<th  align="center">AGOSTO</th>{math assign="columnas" equation="x + y" x=$columnas y=1}{/if}
                {if $MESINICIO lte 9 AND 9 lte $MESFIN}<th align="center">SEPTIEMBRE</th>{math assign="columnas" equation="x + y" x=$columnas y=1}{/if}
                {if $MESINICIO lte 10 AND 10 lte $MESFIN}<th  align="center">OCTUBRE</th>{math assign="columnas" equation="x + y" x=$columnas y=1}{/if}
                {if $MESINICIO lte 11 AND 11 lte $MESFIN}<th align="center">NOVIEMBRE</th>{math assign="columnas" equation="x + y" x=$columnas y=1}{/if}
                {if $MESINICIO lte 12 AND 12 lte $MESFIN}<th  align="center">DICIEMBRE</th>{math assign="columnas" equation="x + y" x=$columnas y=1}{/if}
                
                 <th  align="center">TOTAL</th>	
                 <th  align="center">&nbsp;</th>	
                											
              </tr>
             <tr class="total">
              <td align="left"> TOTAL {if $total_final gt 0} UTILIDAD {else} PERDIDA {/if} DEL EJERCICIO</td>
              <td   align="right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
              <td   align="right">{$total_final_saldo|number_format:0:",":"."}</td>
            {if $MESINICIO lte 1 AND 1 lte $MESFIN}<td   align="right">{$total_final_ene|number_format:0:",":"."}</td>{/if}			
            {if $MESINICIO lte 2 AND 2 lte $MESFIN}<td  align="right">{$total_final_feb|number_format:0:",":"."}</td>{/if}			
            {if $MESINICIO lte 3 AND 3 lte $MESFIN}<td  align="right">{$total_final_mar|number_format:0:",":"."}</td>{/if}				
            {if $MESINICIO lte 4 AND 4 lte $MESFIN}<td  align="right">{$total_final_abr|number_format:0:",":"."}</td>{/if}			
            {if $MESINICIO lte 5 AND 5 lte $MESFIN}<td   align="right">{$total_final_may|number_format:0:",":"."}</td>{/if}		
            {if $MESINICIO lte 6 AND 6 lte $MESFIN}<td align="right">{$total_final_jun|number_format:0:",":"."}</td>{/if}		
            {if $MESINICIO lte 7 AND 7 lte $MESFIN}<td align="right">{$total_final_jul|number_format:0:",":"."}</td>{/if}		
            {if $MESINICIO lte 8 AND 8 lte $MESFIN}<td  align="right">{$total_final_ago|number_format:0:",":"."}</td>{/if}		
            {if $MESINICIO lte 9 AND 9 lte $MESFIN}<td align="right">{$total_final_sep|number_format:0:",":"."}</td>{/if}		
            {if $MESINICIO lte 10 AND 10 lte $MESFIN}<td  align="right">{$total_final_oct|number_format:0:",":"."}</td>{/if}		
            {if $MESINICIO lte 11 AND 11 lte $MESFIN}<td align="right">{$total_final_nov|number_format:0:",":"."}</td>{/if}		
            {if $MESINICIO lte 12 AND 12 lte $MESFIN}<td  align="right">{$total_final_dic|number_format:0:",":"."}</td>{/if}
              <td  align="right"> {$total_final|number_format:0:",":"."}</td>
             </tr>
             
  			</tbody>
            
             </table>
             
      <!--   REPORTE CONSOLIDADO    -->
  	{else}
          {assign var="ingresos"             value="0"}
          {assign var="gastos"               value="0"}
          {assign var="costos_de_ventas"     value="0"}  
          {assign var="gastos_de_produccion" value="0"}    
          <table width="80%" align="center" cellpadding="3" class="table_general">
            <thead>
              <tr align="center" class="title" >
                <th width="10%" >CODIGO</th>
                <th width="40%"  align="center">CUENTA</th>
                <th width="10%"  align="center">PARCIAL</th>			
                <th width="10%"  align="center">AUX</th>			
                <th width="10%"  align="center">SUBCUENTA</th>			
                <th width="10%"  align="center">CUENTA</th>			
                <th width="10%"  align="center">GRUPO</th>			
                <th width="10%"  align="center">CLASE</th>											
              </tr>
            </thead>
            
            <tbody>
             {section name=reporte loop=$arrayResult}
             
              {assign var="codigo_puc" value=$arrayResult[reporte].codigo}	 
              
              {if $codigo_puc eq 4}{assign var="ingresos"             value=$arrayResult[reporte].saldo}{/if}
              {if $codigo_puc eq 5}{assign var="gastos"               value=$arrayResult[reporte].saldo}{/if}	  
              {if $codigo_puc eq 6}{assign var="costos_de_ventas"     value=$arrayResult[reporte].saldo}{/if}
              {if $codigo_puc eq 7}{assign var="gastos_de_produccion" value=$arrayResult[reporte].saldo}{/if}	  
             
              <tr align="left" bgcolor="{cycle values="#eeeeee,#d0d0d0"}">
                <td class="codigo_puc" >
                  {$codigo_puc}
                </td>
                
                {if $arrayResult[reporte].tipo eq 'AUX'}
                  <td class="cuentas_movimiento" >{$arrayResult[reporte].cuenta}</td>
                {else}  
                  <td class="cuentas_mayores" >{$arrayResult[reporte].cuenta}</td>		
                {/if}
                
                <td >&nbsp;</td>
                <td align="right" >{if $arrayResult[reporte].tipo eq 'AUX'}{$arrayResult[reporte].saldo|number_format:0:",":"."}{else}&nbsp;{/if}</td>								
                <td align="right" >{if $arrayResult[reporte].tipo eq 'SUBCUENTA'}{$arrayResult[reporte].saldo|number_format:0:",":"."}{else}&nbsp;{/if}</td>			
                <td align="right" >{if $arrayResult[reporte].tipo eq 'CUENTA'}{$arrayResult[reporte].saldo|number_format:0:",":"."}{else}&nbsp;{/if}</td>			
                <td align="right" >{if $arrayResult[reporte].tipo eq 'GRUPO'}{$arrayResult[reporte].saldo|number_format:0:",":"."}{else}&nbsp;{/if}</td>
                <td align="right" >{if $arrayResult[reporte].tipo eq 'CLASE'}{$arrayResult[reporte].saldo|number_format:0:",":"."}{else}&nbsp;{/if}</td>		
              </tr>		  
              
              {if is_array($arrayResult[reporte].terceros)}	  
                {foreach name=terceros from=$arrayResult[reporte].terceros item=t}
                <tr bgcolor="{cycle values="#F8F8F8,#FFFFFF"}">
                 <td >&nbsp;</td>
                 <td align="left" class="terceros"  >&nbsp;&nbsp;{$t.tercero}</td>
                 <td align="right" ><a href="javascript:void(0)" onClick="popPup('LibrosAuxiliaresClass.php?ACTIONCONTROLER=onclickGenerarAuxiliar&reporte=C&opciones_tercero=U&tercero_id={$t.tercero_id}&opciones_centros={$opciones_centros}&centro_de_costo_id={$centro_de_costo_id}&opciones_documentos=T&documentos={$documentos}&cuenta_desde_id={$t.puc_id}&cuenta_hasta_id={$t.puc_id}&desde={$DESDE}&hasta={$HASTA}&agrupar=defecto',10,900,600)">{$t.saldo|number_format:0:",":"."}</a></td>
                 <td >&nbsp;</td>	  
                 <td >&nbsp;</td>	  
                 <td >&nbsp;</td>	  
                 <td >&nbsp;</td>	  
                 <td >&nbsp;</td>	  		 		 		 		 
                </tr>
               {/foreach}
              {/if}
              
        
              {if is_array($arrayResult[reporte].subtotal)}	  
                <tr>
                 <td colspan="8"  class="total">
                   <table width="100%">
                     <tr>
                       <td width="50%" align="left">{$arrayResult[reporte].subtotal.texto}</td>
                       <td width="50%" align="right">{$arrayResult[reporte].subtotal.total|number_format:0:",":"."}</td>
                     </tr>
                    </table>
                 </td>
                </tr>		
              {/if}
              
             {/section}	
             
                <tr>
                 <td colspan="8" class="total">
                   <table width="100%">
                     <tr>
                       <td align="left" >UTILIDAD O PERDIDA DEL EJERCICIO </td>
                       <td align="right" >
                         {math assign="total" equation="(W-X-Y-Z)" W=$ingresos X=$gastos Y=$costos_de_ventas Z=$gastos_de_produccion}
                         {$total|number_format:0:",":"."}
                       </td>
                     </tr>
                   </table>
                 </td>
                </tr>
                <tr><td colspan="8">&nbsp;</td></tr>	
                <tr><td colspan="8">&nbsp;</td></tr>	 
                
                <tr>
                  <td colspan="8" align="center">
                    <table width="80%" align="center">
                      <tr>
                        <td>
                          <table>
                            <tr><td align="left" >&nbsp;</td></tr>				  				  
                            <tr><td align="left" class="footer">{$parametros[0].representante_nombres}</td></tr>
                            <tr><td align="left" class="footer">{$parametros[0].representante_cargo}</td></tr>
                            <tr><td align="left" class="footer">C.C&nbsp;{$parametros[0].cedula}</td></tr>										
                          </table>
                        </td>
                        <td>
                          <table>
                            <tr><td align="left" >&nbsp;</td></tr>				  				  
                            <tr><td align="left" class="footer">{$parametros[0].revisor_nombres}</td></tr>
                            <tr>
                              <td align="left" class="footer">{$parametros[0].revisor_cargo}&nbsp;T:P&nbsp;{$parametros[0].revisor_tarjeta_profesional}</td>
                            </tr>
                            <tr><td align="left" class="footer">C.C&nbsp;{$parametros[0].revisor_cedula}</td></tr>										
                          </table>				
                        </td>
                        <td>
                          <table>
                            <tr><td align="left" >&nbsp;</td></tr>				  
                            <tr><td align="left" class="footer">{$parametros[0].contador_nombres}</td></tr>
                            <tr>
                              <td align="left" class="footer">{$parametros[0].contador_cargo}&nbsp;T:P&nbsp;{$parametros[0].contador_tarjeta_profesional}</td>
                            </tr>
                            <tr><td align="left" class="footer">C.C&nbsp;{$parametros[0].contador_cedula}</td></tr>										
                          </table>				
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>			
                     
            </tbody>
            
          </table>
     {/if}
  </body>
</html>  