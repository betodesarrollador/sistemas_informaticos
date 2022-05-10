<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    {$JAVASCRIPT}
    {$CSSSYSTEM}
</head>

<body>


    {if $formato_exogena_id neq ''}

    {$FORM1}
    
    <input type="hidden" id="formato_exogena_id" value="{$formato_exogena_id}" />
    <input type="hidden" id="puc_id" value="{$puc_id}" />
    {$ARCHIVOSOLICITUD}
    
    {$FORM1END}

    <table align="center" id="tableDetalles" width="98%">
        <thead>
            <tr>

                <th>CTA. PUC</th>
                <th>CATEGORIA EXOGENA</th>
                <th>BASE CATEGORIA EXOGENA</th>
                <th>CONCEPTO EXOGENA</th>
                <th>TIPO SUMATORIA</th>
                <th>CENTRO COSTO</th>
                <th>ESTADO</th>
                <th id="titleSave">&nbsp;</th>
                <th><input type="checkbox" id="checkedAll"></th>
            </tr>
        </thead>

        <tbody>

            {foreach name=detalles from=$DETALLES item=i}

            <tr>

                <td>
                    <input type="text" name="codigo_puc" value="{$i.codigo_puc}" class="required" />
                    <input type="hidden" name="puc_id" value="{$i.puc_id}" />
                    <input type="hidden" name="cuenta_exogena_id" value="{$i.cuenta_exogena_id}" />
                </td>

                <td>
                    <input type="text" name="categoria_exogena" value="{$i.categoria_exogena}" class="required" />
                    <input type="hidden" name="categoria_exogena_id" value="{$i.categoria_exogena_id}" class="required"/>
                </td>
                
                <td>
                    <input type="text" name="base_categoria_exogena" value="{$i.base_categoria_exogena}"  />
                    <input type="hidden" name="base_categoria_exogena_id" value="{$i.base_categoria_exogena_id}" />
                </td>

                <td>
                    <input type="text" name="concepto_exogena" value="{$i.concepto_exogena}" class="required" />
                    <input type="hidden" name="concepto_exogena_id" value="{$i.concepto_exogena_id}" class="required"/>
                </td>

                <td>
                    <select style="width:200px;" name="tipo_sumatoria" class="required">
                        <option value="SDP" {if $i.tipo_sumatoria eq 'SDP' } selected {/if}>SDP - SUMA DEBITO PERIODO</option>
                        <option value="SCP" {if $i.tipo_sumatoria eq 'SCP' } selected {/if}>SCP - SUMA CREDITO PERIODO</option>
                        <option value="DCP" {if $i.tipo_sumatoria eq 'DCP' } selected {/if}>DCP - DEBITO/CREDITO PERIODO</option>
                        <option value="CDP" {if $i.tipo_sumatoria eq 'CDP' } selected {/if}>CDP - CREDITO/DEBITO PERIODO</option>
                        <option value="SCC" {if $i.tipo_sumatoria eq 'SCC' } selected {/if}>SCC - SUMA CREDITO AL CORTE</option>
                        <option value="DCC" {if $i.tipo_sumatoria eq 'DCC' } selected {/if}>DCC - DEBITO/CREDITO AL CORTE</option>
                        <option value="CDC" {if $i.tipo_sumatoria eq 'CDC' } selected {/if}>CDC - CREDITO/DEBITO AL CORTE</option>
                    </select>
                </td>

                <td>
                    <select style="width:100px;" name="centro_de_costo_id">
                        <option value="NULL">NINGUNA</option>
                        {foreach name=causal from=$CCOSTO item=x}
                        <option value="{$x.value}" {if $i.centro_de_costo_id eq $x.value} selected="selected" {/if}>{$x.text}</option>
                        {/foreach}
                    </select>

                </td>

                <td>
                    <select name="estado">
                        <option value="A" {if $i.estado eq 'A' } selected {/if}>ACTIVO</option>
                        <option value="I" {if $i.estado eq 'I' } selected {/if}>INACTIVO</option>
                    </select>
                </td>

                <td><a name="saveDetalles"><img src="../../../framework/media/images/grid/add.png" alt="Adicionar" /></a></td>
                <td><input type="checkbox" name="procesar" /></td>

            </tr>

            {/foreach}

            <tr>

                <td>
                    <input type="text" name="codigo_puc" value="" class="required" />
                    <input type="hidden" name="puc_id" value="" class="required"/>
                    <input type="hidden" name="cuenta_exogena_id" value="" />
                </td>

                <td>
                    <input type="text" name="categoria_exogena" value="" class="required" />
                    <input type="hidden" name="categoria_exogena_id" value="" class="required" />
                </td>
                
                <td>
                    <input type="text"  name="base_categoria_exogena" value=""  />
                    <input type="hidden" name="base_categoria_exogena_id" value="" />
               </td>

                <td>
                    <input type="text" name="concepto_exogena" value="" class="required" />
                    <input type="hidden" name="concepto_exogena_id" value="" class="required" />
                </td>

                <td>
                    <select style="width:200px;" name="tipo_sumatoria" class="required">
                        <option value="SDP">SDP - SUMA DEBITO PERIODO</option>
                        <option value="SCP">SCP - SUMA CREDITO PERIODO</option>
                        <option value="DCP">DCP - DEBITO/CREDITO PERIODO</option>
                        <option value="CDP">CDP - CREDITO/DEBITO PERIODO</option>
                        <option value="SCC">SCC - SUMA CREDITO AL CORTE</option>
                        <option value="DCC">DCC - DEBITO/CREDITO AL CORTE</option>
                        <option value="CDC">CDC - CREDITO/DEBITO AL CORTE</option>
                    </select>
                </td>

                <td>
                    <select style="width:100px;" name="centro_de_costo_id">
                        <option value="NULL">NINGUNA</option>
                        {foreach name=causal from=$CCOSTO item=x}
                        <option value="{$x.value}">{$x.text}</option>
                        {/foreach}
                    </select>

                </td>

                <td>
                    <select name="estado">
                        <option value="A">ACTIVO</option>
                        <option value="I">INACTIVO</option>
                    </select>
                </td>

                <td><a name="saveDetalles"><img src="../../../framework/media/images/grid/add.png" alt="Adicionar" /></a></td>
                <td><input type="checkbox" name="procesar" /></td>

            </tr>

        </tbody>
    </table>

    <table width="98%" align="center">

        <tr id="clon">

            <td>
                <input type="text" name="codigo_puc" value="" class="required" />
                <input type="hidden" name="puc_id" value="" class="required"/>
                <input type="hidden" name="cuenta_exogena_id" value="" />
            </td>

            <td>
                <input type="text" name="categoria_exogena" value="" class="required" />
                <input type="hidden" name="categoria_exogena_id" value="" class="required" />
            </td>
            
            <td>
                <input type="text" name="base_categoria_exogena" value=""  />
                <input type="hidden" name="base_categoria_exogena_id" value="" />
            </td>

            <td>
                <input type="text" name="concepto_exogena" value="" class="required" />
                <input type="hidden" name="concepto_exogena_id" value="" class="required" />
            </td>

            <td>
                <select style="width:200px;" name="tipo_sumatoria" class="required">
                    <option value="SDP">SDP - SUMA DEBITO PERIODO</option>
                    <option value="SCP">SCP - SUMA CREDITO PERIODO</option>
                    <option value="DCP">DCP - DEBITO/CREDITO PERIODO</option>
                    <option value="CDP">CDP - CREDITO/DEBITO PERIODO</option>
                    <option value="SCC">SCC - SUMA CREDITO AL CORTE</option>
                    <option value="DCC">DCC - DEBITO/CREDITO AL CORTE</option>
                    <option value="CDC">CDC - CREDITO/DEBITO AL CORTE</option>
                </select>
            </td>

            <td>
                <select style="width:100px;" name="centro_de_costo_id">
                    <option value="NULL">NINGUNA</option>
                    {foreach name=causal from=$CCOSTO item=x}
                    <option value="{$x.value}">{$x.text}</option>
                    {/foreach}
                </select>

            </td>

            <td>
                <select name="estado">
                    <option value="A">ACTIVO</option>
                    <option value="I">INACTIVO</option>
                </select>
            </td>

            <td><a name="saveDetalles"><img src="../../../framework/media/images/grid/add.png" alt="Adicionar" /></a></td>
            <td><input type="checkbox" name="procesar" /></td>

        </tr>

    </table>
    {/if}

    {if $puc_id neq ''}

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-10">
        {$FORM1}
            <input type="hidden" id="formato_exogena_id" value="{$formato_exogena_id}" />
            <input type="hidden" id="puc_id" value="{$puc_id}" />
            {$ARCHIVOSOLICITUD}
        {$FORM1END}
        </div>
        <div class="col-sm-2" style="padding:10px">
            <button class="btn btn-success" id="generar" name="generar">Generar Excel</button>
        </div>
      </div>
    </div>

    <table align="center" id="tableDetalles" width="98%">
        <thead>
            <tr>

                <th>FORMATO</th>
                <th>CATEGORIA EXOGENA</th>
                <th>BASE CATEGORIA EXOGENA</th>
                <th>CONCEPTO EXOGENA</th>
                <th>TIPO SUMATORIA</th>
                <th>CENTRO COSTO</th>
                <th>ESTADO</th>
                <th id="titleSave">&nbsp;</th>
                <th id="titleDelete">&nbsp;</th>
                <th><input type="checkbox" id="checkedAll"></th>
            </tr>
        </thead>

        <tbody>

            {foreach name=detalles from=$DETALLES item=i}

            <tr>

                <td>
                    <input type="text" name="formato" value="{$i.formato}" class="required" />
                    <input type="hidden" name="formato_exogena_id" value="{$i.formato_exogena_id}" />
                    <input type="hidden" name="cuenta_exogena_id" value="{$i.cuenta_exogena_id}" />
                </td>

                <td>
                    <input type="text" name="categoria_exogena" value="{$i.categoria_exogena}" class="required" />
                    <input type="hidden" name="categoria_exogena_id" value="{$i.categoria_exogena_id}" class="required"/>
                </td>
                
                <td>
                    <input type="text" name="base_categoria_exogena" value="{$i.base_categoria_exogena}"  />
                    <input type="hidden" name="base_categoria_exogena_id" value="{$i.base_categoria_exogena_id}" />
                </td>

                <td>
                    <input type="text" name="concepto_exogena" value="{$i.concepto_exogena}" class="required" />
                    <input type="hidden" name="concepto_exogena_id" value="{$i.concepto_exogena_id}" class="required"/>
                </td>

                <td>
                    <select style="width:200px;" name="tipo_sumatoria" class="required">
                        <option value="SDP" {if $i.tipo_sumatoria eq 'SDP' } selected {/if}>SDP - SUMA DEBITO PERIODO</option>
                        <option value="SCP" {if $i.tipo_sumatoria eq 'SCP' } selected {/if}>SCP - SUMA CREDITO PERIODO</option>
                        <option value="DCP" {if $i.tipo_sumatoria eq 'DCP' } selected {/if}>DCP - DEBITO/CREDITO PERIODO</option>
                        <option value="CDP" {if $i.tipo_sumatoria eq 'CDP' } selected {/if}>CDP - CREDITO/DEBITO PERIODO</option>
                        <option value="SCC" {if $i.tipo_sumatoria eq 'SCC' } selected {/if}>SCC - SUMA CREDITO AL CORTE</option>
                        <option value="DCC" {if $i.tipo_sumatoria eq 'DCC' } selected {/if}>DCC - DEBITO/CREDITO AL CORTE</option>
                        <option value="CDC" {if $i.tipo_sumatoria eq 'CDC' } selected {/if}>CDC - CREDITO/DEBITO AL CORTE</option>
                    </select>
                </td>
            

                <td>
                    <select style="width:100px;" name="centro_de_costo_id">
                        <option value="NULL">NINGUNA</option>
                        {foreach name=causal from=$CCOSTO item=x}
                        <option value="{$x.value}" {if $i.centro_de_costo_id eq $x.value} selected="selected" {/if}>{$x.text}</option>
                        {/foreach}
                    </select>

                </td>

                <td>
                    <select name="estado">
                        <option value="A" {if $i.estado eq 'A' } selected {/if}>ACTIVO</option>
                        <option value="I" {if $i.estado eq 'I' } selected {/if}>INACTIVO</option>
                    </select>
                </td>

                <td><a name="saveDetalles"><img src="../../../framework/media/images/grid/add.png" alt="Adicionar" /></a></td>
                <td><a name="deleteDetalles"><img src="../../../framework/media/images/grid/close.png" alt="Borrar" /></a></td>
                <td><input type="checkbox" name="procesar" /></td>

            </tr>

            {/foreach}

            <tr>

                <td>
                    <input type="text" name="formato" value="" class="required" />
                    <input type="hidden" name="formato_exogena_id" value="" class="required"/>
                    <input type="hidden" name="cuenta_exogena_id" value="" />
                </td>

                <td>
                    <input type="text" name="categoria_exogena" value="" class="required" />
                    <input type="hidden" name="categoria_exogena_id" value="" class="required" />
                </td>
                
                <td>
                    <input type="text" name="base_categoria_exogena" value=""  />
                    <input type="hidden" name="base_categoria_exogena_id" value="" />
                </td>

                <td>
                    <input type="text" name="concepto_exogena" value="" class="required" />
                    <input type="hidden" name="concepto_exogena_id" value="" class="required" />
                </td>

                <td>
                    <select style="width:200px;" name="tipo_sumatoria" class="required">
                        <option value="SDP">SDP - SUMA DEBITO PERIODO</option>
                        <option value="SCP">SCP - SUMA CREDITO PERIODO</option>
                        <option value="DCP">DCP - DEBITO/CREDITO PERIODO</option>
                        <option value="CDP">CDP - CREDITO/DEBITO PERIODO</option>
                        <option value="SCC">SCC - SUMA CREDITO AL CORTE</option>
                        <option value="DCC">DCC - DEBITO/CREDITO AL CORTE</option>
                        <option value="CDC">CDC - CREDITO/DEBITO AL CORTE</option>
                    </select>
                </td>

                <td>
                    <select style="width:100px;" name="centro_de_costo_id">
                        <option value="NULL">NINGUNA</option>
                        {foreach name=causal from=$CCOSTO item=x}
                        <option value="{$x.value}">{$x.text}</option>
                        {/foreach}
                    </select>

                </td>

                <td>
                    <select name="estado">
                        <option value="A">ACTIVO</option>
                        <option value="I">INACTIVO</option>
                    </select>
                </td>

                <td><a name="saveDetalles"><img src="../../../framework/media/images/grid/add.png" alt="Adicionar" /></a></td>
                <td><a name="deleteDetalles"><img src="../../../framework/media/images/grid/close.png" alt="Borrar" /></a></td>
                <td><input type="checkbox" name="procesar" /></td>

            </tr>

        </tbody>
    </table>

    <table width="98%" align="center">

        <tr id="clon">

            <td>
                <input type="text" name="formato" value="" class="required" />
                <input type="hidden" name="formato_exogena_id" value="" class="required"/>
                <input type="hidden" name="cuenta_exogena_id" value="" />
            </td>

            <td>
                <input type="text" name="categoria_exogena" value="" class="required" />
                <input type="hidden" name="categoria_exogena_id" value="" class="required" />
            </td>
            
            <td>
                <input type="text" name="base_categoria_exogena" value="" />
                <input type="hidden" name="base_categoria_exogena_id" value="" />
            </td>

            <td>
                <input type="text" name="concepto_exogena" value="" class="required" />
                <input type="hidden" name="concepto_exogena_id" value="" class="required" />
            </td>

            <td>
                <select style="width:200px;" name="tipo_sumatoria" class="required">
                    <option value="SDP">SDP - SUMA DEBITO PERIODO</option>
                    <option value="SCP">SCP - SUMA CREDITO PERIODO</option>
                    <option value="DCP">DCP - DEBITO/CREDITO PERIODO</option>
                    <option value="CDP">CDP - CREDITO/DEBITO PERIODO</option>
                    <option value="SCC">SCC - SUMA CREDITO AL CORTE</option>
                    <option value="DCC">DCC - DEBITO/CREDITO AL CORTE</option>
                    <option value="CDC">CDC - CREDITO/DEBITO AL CORTE</option>
                </select>
            </td>

            <td>
                <select style="width:100px;" name="centro_de_costo_id">
                    <option value="NULL">NINGUNA</option>
                    {foreach name=causal from=$CCOSTO item=x}
                    <option value="{$x.value}">{$x.text}</option>
                    {/foreach}
                </select>

            </td>

            <td>
                <select name="estado">
                    <option value="A">ACTIVO</option>
                    <option value="I">INACTIVO</option>
                </select>
            </td>

            <td><a name="saveDetalles"><img src="../../../framework/media/images/grid/add.png" alt="Adicionar" /></a></td>
            <td><a name="deleteDetalles"><img src="../../../framework/media/images/grid/close.png" alt="Borrar" /></a></td>
            <td><input type="checkbox" name="procesar" /></td>

        </tr>

    </table>
    
    {/if}
</body>

</html>