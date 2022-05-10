<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    {$JAVASCRIPT} {$CSSSYSTEM}
</head>

<body onLoad="javascript:window.print()">
    <div align="center">
        <img src="{$DETALLES[0].logo}" align="left" width="200" height="100" />

        <b>EJECUCION PRESUPUESTAL</b><br />

        <b>SISTEMAS INFORMATICOS & SOLUCIONES INTEGRALES SAS</b><br />

        <b>Nit. 900608466 - 4</b><br />

        <b>{$ANO}</b><br />

        <b>(Valores Expresados en pesos Colombianos)</b><br />

        <b>Centros : BOGOTA PRINCIPAL - IBAGUE - IBAGUE CENTRO</b><br />
    </div>

    <table id="tablePresupuesto" width="100%">
        <thead>
            <tr>
                <td colspan="44" align="center">&nbsp;</td>
            </tr>
            <tr>
                <th rowspan="2">CODIGO</th>
                <th rowspan="2">CUENTA</th>
                {if $ENERO eq "true" or $ENERO eq 1}
                <th colspan="4">ENERO</th>
                {/if} {if $FEBRERO eq "true" or $FEBRERO eq 1}
                <th colspan="4">FEBRERO</th>
                {/if} {if $MARZO eq "true" or $MARZO eq 1}
                <th colspan="4">MARZO</th>
                {/if} {if $ABRIL eq "true" or $ABRIL eq 1}
                <th colspan="4">ABRIL</th>
                {/if} {if $MAYO eq "true" or $MAYO eq 1}
                <th colspan="4">MAYO</th>
                {/if} {if $JUNIO eq "true" or $JUNIO eq 1}
                <th colspan="4">JUNIO</th>
                {/if} {if $JULIO eq "true" or $JULIO eq 1}
                <th colspan="4">JULIO</th>
                {/if} {if $AGOSTO eq "true" or $AGOSTO eq 1}
                <th colspan="4">AGOSTO</th>
                {/if} {if $SEPTIEMBRE eq "true" or $SEPTIEMBRE eq 1}
                <th colspan="4">SEPTIEMBRE</th>
                {/if} {if $OCTUBRE eq "true" or $OCTUBRE eq 1}
                <th colspan="4">OCTUBRE</th>
                {/if} {if $NOVIEMBRE eq "true" or $NOVIEMBRE eq 1}
                <th colspan="4">NOVIEMBRE</th>
                {/if} {if $DICIEMBRE eq "true" or $DICIEMBRE eq 1}
                <th colspan="4">DICIEMBRE</th>
                {/if}
            </tr>
            <tr>
                {if $ENERO eq "true" or $ENERO eq 1}
                <th>Presupuesto</th>
                <th>Movimiento</th>
                <th>Diferencia</th>
                <th>%</th>
                {/if} {if $FEBRERO eq "true" or $FEBRERO eq 1}
                <th>Presupuesto</th>
                <th>Movimiento</th>
                <th>Diferencia</th>
                <th>%</th>
                {/if} {if $MARZO eq "true" or $MARZO eq 1}
                <th>Presupuesto</th>
                <th>Movimiento</th>
                <th>Diferencia</th>
                <th>%</th>
                {/if} {if $ABRIL eq "true" or $ABRIL eq 1}
                <th>Presupuesto</th>
                <th>Movimiento</th>
                <th>Diferencia</th>
                <th>%</th>
                {/if} {if $MAYO eq "true" or $MAYO eq 1}
                <th>Presupuesto</th>
                <th>Movimiento</th>
                <th>Diferencia</th>
                <th>%</th>
                {/if} {if $JUNIO eq "true" or $JUNIO eq 1}
                <th>Presupuesto</th>
                <th>Movimiento</th>
                <th>Diferencia</th>
                <th>%</th>
                {/if} {if $JULIO eq "true" or $JULIO eq 1}
                <th>Presupuesto</th>
                <th>Movimiento</th>
                <th>Diferencia</th>
                <th>%</th>
                {/if} {if $AGOSTO eq "true" or $AGOSTO eq 1}
                <th>Presupuesto</th>
                <th>Movimiento</th>
                <th>Diferencia</th>
                <th>%</th>
                {/if} {if $SEPTIEMBRE eq "true" or $SEPTIEMBRE eq 1}
                <th>Presupuesto</th>
                <th>Movimiento</th>
                <th>Diferencia</th>
                <th>%</th>
                {/if} {if $OCTUBRE eq "true" or $OCTUBRE eq 1}
                <th>Presupuesto</th>
                <th>Movimiento</th>
                <th>Diferencia</th>
                <th>%</th>
                {/if} {if $NOVIEMBRE eq "true" or $NOVIEMBRE eq 1}
                <th>Presupuesto</th>
                <th>Movimiento</th>
                <th>Diferencia</th>
                <th>%</th>
                {/if} {if $DICIEMBRE eq "true" or $DICIEMBRE eq 1}
                <th>Presupuesto</th>
                <th>Movimiento</th>
                <th>Diferencia</th>
                <th>%</th>
                {/if}
            </tr>
        </thead>

        {assign var="total_p_enero" value="0"} {assign var="total_m_enero" value="0"} {assign var="total_dif_enero" value="0"} {assign var="total_pr_enero" value="0"} {assign var="total_p_enero" value="0"} {assign var="total_m_enero"
        value="0"} {assign var="total_dif_enero" value="0"} {assign var="total_pr_enero" value="0"}
        <tbody>
            {assign var="utilidadP_enero" value='0'}
			{assign var="utilidadP_febrero" value='0'} 
			{assign var="utilidadP_marzo" value='0'}
			{assign var="utilidadP_abril" value='0'} P
			{assign var="utilidadP_mayo" value='0'} 
			{assign var="utilidadP_junio" value='0'} 
			{assign var="utilidadP_julio" value='0'} 
			{assign var="utilidadP_agosto" value='0'} 
			{assign var="utilidadP_septiembre" value='0'} 
			{assign var="utilidadP_octubre" value='0'} 
			{assign var="utilidadP_noviembre" value='0'} 
			{assign var="utilidadP_diciembre" value='0'} 

            {assign var="utilidadM_enero" value='0'}
			{assign var="utilidadM_febrero" value='0'} 
			{assign var="utilidadM_marzo" value='0'}
			{assign var="utilidadM_abril" value='0'} 
			{assign var="utilidadM_mayo" value='0'} 
			{assign var="utilidadM_junio" value='0'} 
			{assign var="utilidadM_julio" value='0'} 
			{assign var="utilidadM_agosto" value='0'} 
			{assign var="utilidadM_septiembre" value='0'} 
			{assign var="utilidadM_octubre" value='0'} 
			{assign var="utilidadM_noviembre" value='0'} 
			{assign var="utilidadM_diciembre" value='0'} 

			{foreach name=presupuesto from=$DETALLES item=p key=i} 
			
			{assign var="pos_titulo_total" value="`$i-1`"} 
			
			{if $i+1 != $DETALLES|@count} 

				{if $p.codigo_puc eq ""}

					<tr style="background-color: #daeaf6; height: 40px;">

						<td colspan="2"><b>SUBTOTAL {$DETALLES[$pos_titulo_total].titulo_total}</b></td>

						{math assign="utilidadP_enero"      equation="abs(x)-abs(y)" x=$utilidadP_enero y=$p.p_enero|replace:'.':''} 
						{math assign="utilidadP_febrero"    equation="abs(x)-abs(y)" x=$utilidadP_febrero y=$p.p_febrero|replace:'.':''} 
						{math assign="utilidadP_marzo"      equation="abs(x)-abs(y)" x=$utilidadP_marzo y=$p.p_marzo|replace:'.':''} 
						{math assign="utilidadP_abril"      equation="abs(x)-abs(y)" x=$utilidadP_abril y=$p.p_abril|replace:'.':''} 
						{math assign="utilidadP_mayo"       equation="abs(x)-abs(y)" x=$utilidadP_mayo y=$p.p_mayo|replace:'.':''} 
						{math assign="utilidadP_junio"      equation="abs(x)-abs(y)" x=$utilidadP_junio y=$p.p_junio|replace:'.':''}
						{math assign="utilidadP_julio"      equation="abs(x)-abs(y)" x=$utilidadP_julio y=$p.p_julio|replace:'.':''} 
						{math assign="utilidadP_agosto"     equation="abs(x)-abs(y)" x=$utilidadP_agosto y=$p.p_agosto|replace:'.':''} 
						{math assign="utilidadP_septiembre" equation="abs(x)-abs(y)" x=$utilidadP_septiembre y=$p.p_septiembre|replace:'.':''} 
						{math assign="utilidadP_octubre"    equation="abs(x)-abs(y)" x=$utilidadP_octubre y=$p.p_octubre|replace:'.':''}
						{math assign="utilidadP_noviembre"  equation="abs(x)-abs(y)" x=$utilidadP_noviembre y=$$p.p_noviembre|replace:'.':''} 
						{math assign="utilidadP_diciembre"  equation="abs(x)-abs(y)" x=$utilidadP_diciembre y=$p.p_diciembre|replace:'.':''} 

						{math assign="utilidadM_enero"      equation="abs(x)-abs(y)" x=$utilidadM_enero y=$p.m_enero|replace:'.':''} 
						{math assign="utilidadM_febrero"    equation="abs(x)-abs(y)" x=$utilidadM_febrero y=$p.m_febrero|replace:'.':''} 
						{math assign="utilidadM_marzo"      equation="abs(x)-abs(y)" x=$utilidadM_marzo y=$p.m_marzo|replace:'.':''} 
						{math assign="utilidadM_abril"      equation="abs(x)-abs(y)" x=$utilidadM_abril y=$p.m_abril|replace:'.':''} 
						{math assign="utilidadM_mayo"       equation="abs(x)-abs(y)" x=$utilidadM_mayo y=$p.m_mayo|replace:'.':''} 
						{math assign="utilidadM_junio"      equation="abs(x)-abs(y)" x=$utilidadM_junio y=$p.m_junio|replace:'.':''}
						{math assign="utilidadM_julio"      equation="abs(x)-abs(y)" x=$utilidadM_julio y=$p.m_julio|replace:'.':''} 
						{math assign="utilidadM_agosto"     equation="abs(x)-abs(y)" x=$utilidadM_agosto y=$p.m_agosto|replace:'.':''} 
						{math assign="utilidadM_septiembre" equation="abs(x)-abs(y)" x=$utilidadM_septiembre y=$p.m_septiembre|replace:'.':''} 
						{math assign="utilidadM_octubre"    equation="abs(x)-abs(y)" x=$utilidadM_octubre y=$p.m_octubre|replace:'.':''}
						{math assign="utilidadM_noviembre"  equation="abs(x)-abs(y)" x=$utilidadM_noviembre y=$$p.m_noviembre|replace:'.':''} 
						{math assign="utilidadM_diciembre"  equation="abs(x)-abs(y)" x=$utilidadM_diciembre y=$p.m_diciembre|replace:'.':''} 
					
				{else}

				</tr>

				<tr>
					<td>{$p.codigo_puc}</td>
					<td align="left">{$p.cuenta}</td>
				{/if} 

			{else if}

            </tr>

            <tr style="background-color: #bbf7a7; height: 40px;">

                <td colspan="2"><b>TOTALES</b></td>

                {/if} {if $ENERO eq "true" or $ENERO eq 1}
                <td align="right">{$p.p_enero|number_format:0:",":"."}</td>
                <td align="right">{$p.m_enero|number_format:0:",":"."}</td>
                <td align="right">{$p.dif_enero|number_format:0:",":"."}</td>
                <td align="right">{$p.pr_enero|number_format:0:",":"."}</td>
                {/if} {if $FEBRERO eq "true" or $FEBRERO eq 1}
                <td align="right">{$p.p_febrero|number_format:0:",":"."}</td>
                <td align="right">{$p.m_febrero|number_format:0:",":"."}</td>
                <td align="right">{$p.dif_febrero|number_format:0:",":"."}</td>
                <td align="right">{$p.pr_febrero|number_format:0:",":"."}</td>
                {/if} {if $MARZO eq "true" or $MARZO eq 1}
                <td align="right">{$p.p_marzo|number_format:0:",":"."}</td>
                <td align="right">{$p.m_marzo|number_format:0:",":"."}</td>
                <td align="right">{$p.dif_marzo|number_format:0:",":"."}</td>
                <td align="right">{$p.pr_marzo|number_format:0:",":"."}</td>
                {/if} {if $ABRIL eq "true" or $ABRIL eq 1}
                <td align="right">{$p.p_abril|number_format:0:",":"."}</td>
                <td align="right">{$p.m_abril|number_format:0:",":"."}</td>
                <td align="right">{$p.dif_abril|number_format:0:",":"."}</td>
                <td align="right">{$p.pr_abril|number_format:0:",":"."}</td>
                {/if} {if $MAYO eq "true" or $MAYO eq 1}
                <td align="right">{$p.p_mayo|number_format:0:",":"."}</td>
                <td align="right">{$p.m_mayo|number_format:0:",":"."}</td>
                <td align="right">{$p.dif_mayo|number_format:0:",":"."}</td>
                <td align="right">{$p.pr_mayo|number_format:0:",":"."}</td>
                {/if} {if $JUNIO eq "true" or $JUNIO eq 1}
                <td align="right">{$p.p_junio|number_format:0:",":"."}</td>
                <td align="right">{$p.m_junio|number_format:0:",":"."}</td>
                <td align="right">{$p.dif_junio|number_format:0:",":"."}</td>
                <td align="right">{$p.pr_junio|number_format:0:",":"."}</td>
                {/if} {if $JULIO eq "true" or $JULIO eq 1}
                <td align="right">{$p.p_julio|number_format:0:",":"."}</td>
                <td align="right">{$p.m_julio|number_format:0:",":"."}</td>
                <td align="right">{$p.dif_julio|number_format:0:",":"."}</td>
                <td align="right">{$p.pr_julio|number_format:0:",":"."}</td>
                {/if} {if $AGOSTO eq "true" or $AGOSTO eq 1}
                <td align="right">{$p.p_agosto|number_format:0:",":"."}</td>
                <td align="right">{$p.m_agosto|number_format:0:",":"."}</td>
                <td align="right">{$p.dif_agosto|number_format:0:",":"."}</td>
                <td align="right">{$p.pr_agosto|number_format:0:",":"."}</td>
                {/if} {if $SEPTIEMBRE eq "true" or $SEPTIEMBRE eq 1}
                <td align="right">{$p.p_septiembre|number_format:0:",":"."}</td>
                <td align="right">{$p.m_septiembre|number_format:0:",":"."}</td>
                <td align="right">{$p.dif_septiembre|number_format:0:",":"."}</td>
                <td align="right">{$p.pr_septiembre|number_format:0:",":"."}</td>
                {/if} {if $OCTUBRE eq "true" or $OCTUBRE eq 1}
                <td align="right">{$p.p_octubre|number_format:0:",":"."}</td>
                <td align="right">{$p.m_octubre|number_format:0:",":"."}</td>
                <td align="right">{$p.dif_octubre|number_format:0:",":"."}</td>
                <td align="right">{$p.pr_octubre|number_format:0:",":"."}</td>
                {/if} {if $NOVIEMBRE eq "true" or $NOVIEMBRE eq 1}
                <td align="right">{$p.p_noviembre|number_format:0:",":"."}</td>
                <td align="right">{$p.m_noviembre|number_format:0:",":"."}</td>
                <td align="right">{$p.dif_noviembre|number_format:0:",":"."}</td>
                <td align="right">{$p.pr_noviembre|number_format:0:",":"."}</td>
                {/if} {if $DICIEMBRE eq "true" or $DICIEMBRE eq 1}
                <td align="right">{$p.p_diciembre|number_format:0:",":"."}</td>
                <td align="right">{$p.m_diciembre|number_format:0:",":"."}</td>
                <td align="right">{$p.dif_diciembre|number_format:0:",":"."}</td>
                <td align="right">{$p.pr_diciembre|number_format:0:",":"."}</td>
                {/if}
            </tr>

            {/foreach}
        </tbody>

        <tbody>
            <tr style="background-color: #87b6d9; height: 40px;">
                <td colspan="2"><b>UTILIDAD O PERDIDA</b></td>
                {if $ENERO eq "true" or $ENERO eq 1}
                <td align="right">{$utilidadP_enero|number_format:0:",":"."}</td>
                <td align="right">{$utilidadM_enero|number_format:0:",":"."}</td>
                <td align="right" colspan="2"></td>
                {*
                <td align="right">{$p.m_enero|number_format:0:",":"."}</td>
                <td align="right">{$p.dif_enero|number_format:0:",":"."}</td>
                <td align="right">{$p.pr_enero|number_format:0:",":"."}</td>
                *} {/if} {if $FEBRERO eq "true" or $FEBRERO eq 1}
                <td align="right">{$utilidadP_febrero|number_format:0:",":"."}</td>
                <td align="right">{$utilidadM_febrero|number_format:0:",":"."}</td>
                <td align="right" colspan="2"></td>
                {*
                <td align="right">{$p.m_febrero|number_format:0:",":"."}</td>
                <td align="right">{$p.dif_febrero|number_format:0:",":"."}</td>
                <td align="right">{$p.pr_febrero|number_format:0:",":"."}</td>
                *}{/if} {if $MARZO eq "true" or $MARZO eq 1}
                <td align="right">{$utilidadP_marzo|number_format:0:",":"."}</td>
                <td align="right">{$utilidadM_marzo|number_format:0:",":"."}</td>
                <td align="right" colspan="2"></td>
                {*
                <td align="right">{$p.m_marzo|number_format:0:",":"."}</td>
                <td align="right">{$p.dif_marzo|number_format:0:",":"."}</td>
                <td align="right">{$p.pr_marzo|number_format:0:",":"."}</td>
                *}{/if} {if $ABRIL eq "true" or $ABRIL eq 1}
                <td align="right">{$utilidadP_abril|number_format:0:",":"."}</td>
                <td align="right">{$utilidadM_abril|number_format:0:",":"."}</td>
                <td align="right" colspan="2"></td>
                {*
                <td align="right">{$p.m_abril|number_format:0:",":"."}</td>
                <td align="right">{$p.dif_abril|number_format:0:",":"."}</td>
                <td align="right">{$p.pr_abril|number_format:0:",":"."}</td>
                *}{/if} {if $MAYO eq "true" or $MAYO eq 1}
                <td align="right">{$utilidadP_mayo|number_format:0:",":"."}</td>
                <td align="right">{$utilidadM_mayo|number_format:0:",":"."}</td>
                <td align="right" colspan="2"></td>
                {*
                <td align="right">{$p.m_mayo|number_format:0:",":"."}</td>
                <td align="right">{$p.dif_mayo|number_format:0:",":"."}</td>
                <td align="right">{$p.pr_mayo|number_format:0:",":"."}</td>
                *}{/if} {if $JUNIO eq "true" or $JUNIO eq 1}
                <td align="right">{$utilidadP_junio|number_format:0:",":"."}</td>
                <td align="right">{$utilidadM_junio|number_format:0:",":"."}</td>
                <td align="right" colspan="2"></td>
                {*
                <td align="right">{$p.m_junio|number_format:0:",":"."}</td>
                <td align="right">{$p.dif_junio|number_format:0:",":"."}</td>
                <td align="right">{$p.pr_junio|number_format:0:",":"."}</td>
                *}{/if} {if $JULIO eq "true" or $JULIO eq 1}
                <td align="right">{$utilidadP_julio|number_format:0:",":"."}</td>
                <td align="right">{$utilidadM_julio|number_format:0:",":"."}</td>
                <td align="right" colspan="2"></td>
                {*
                <td align="right">{$p.m_julio|number_format:0:",":"."}</td>
                <td align="right">{$p.dif_julio|number_format:0:",":"."}</td>
                <td align="right">{$p.pr_julio|number_format:0:",":"."}</td>
                *}{/if} {if $AGOSTO eq "true" or $AGOSTO eq 1}
                <td align="right">{$utilidadP_agosto|number_format:0:",":"."}</td>
                <td align="right">{$utilidadM_agosto|number_format:0:",":"."}</td>
                <td align="right" colspan="2"></td>
                {*
                <td align="right">{$p.m_agosto|number_format:0:",":"."}</td>
                <td align="right">{$p.dif_agosto|number_format:0:",":"."}</td>
                <td align="right">{$p.pr_agosto|number_format:0:",":"."}</td>
                *}{/if} {if $SEPTIEMBRE eq "true" or $SEPTIEMBRE eq 1}
                <td align="right">{$utilidadP_septiembre|number_format:0:",":"."}</td>
                <td align="right">{$utilidadM_septiembre|number_format:0:",":"."}</td>
                <td align="right" colspan="2"></td>
                {*
                <td align="right">{$p.m_septiembre|number_format:0:",":"."}</td>
                <td align="right">{$p.dif_septiembre|number_format:0:",":"."}</td>
                <td align="right">{$p.pr_septiembre|number_format:0:",":"."}</td>
                *}{/if} {if $OCTUBRE eq "true" or $OCTUBRE eq 1}
                <td align="right">{$utilidadP_octubre|number_format:0:",":"."}</td>
                <td align="right">{$utilidadM_octubre|number_format:0:",":"."}</td>
                <td align="right" colspan="2"></td>
                {*
                <td align="right">{$p.m_octubre|number_format:0:",":"."}</td>
                <td align="right">{$p.dif_octubre|number_format:0:",":"."}</td>
                <td align="right">{$p.pr_octubre|number_format:0:",":"."}</td>
                *}{/if} {if $NOVIEMBRE eq "true" or $NOVIEMBRE eq 1}
                <td align="right">{$utilidadP_noviembre|number_format:0:",":"."}</td>
                <td align="right">{$utilidadM_noviembre|number_format:0:",":"."}</td>
                <td align="right" colspan="2"></td>
                {*
                <td align="right">{$p.m_noviembre|number_format:0:",":"."}</td>
                <td align="right">{$p.dif_noviembre|number_format:0:",":"."}</td>
                <td align="right">{$p.pr_noviembre|number_format:0:",":"."}</td>
                *}{/if} {if $DICIEMBRE eq "true" or $DICIEMBRE eq 1}
                <td align="right">{$utilidadP_diciembre|number_format:0:",":"."}</td>
                <td align="right">{$utilidadM_diciembre|number_format:0:",":"."}</td>
                <td align="right" colspan="2"></td>
                {*
                <td align="right">{$p.m_diciembre|number_format:0:",":"."}</td>
                <td align="right">{$p.dif_diciembre|number_format:0:",":"."}</td>
                <td align="right">{$p.pr_diciembre|number_format:0:",":"."}</td>
                *}{/if}
            </tr>
        </tbody>
    </table>
</body>
