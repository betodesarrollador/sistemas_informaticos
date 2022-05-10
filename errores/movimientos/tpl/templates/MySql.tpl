<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    {$JAVASCRIPT} {$TABLEGRIDJS} {$CSSSYSTEM} {$TABLEGRIDCSS} {$TITLETAB}
</head>

<body>
    <legend>{$TITLEFORM}</legend>


    <fieldset class="section">
    {* ==================================== CREAR LINEA ========================================== *}
        <div class="pos-f-t">
            <nav class="alert alert-primary" style="margin-top: 15px; padding: 0;">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar1" aria-controls="navbar1" aria-label="Toggle navigation">
                    <i class="fa fa-list"></i>&emsp;Crear linea
                </button>
            </nav>

            <div class="collapse detalle_actividad" id="navbar1">
                <br />
                {include file="soportes/crear_linea.tpl"}
            </div>
        </div>


        {* ==================================== ELIMINAR NOTA CREDITO ========================================== *}

        <div class="pos-f-t">
            <nav class="alert alert-primary" style="margin-top: 15px; padding: 0;">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar2" aria-controls="navbar2" aria-label="Toggle navigation">
                    <i class="fa fa-list"></i>&emsp;Eliminar nota credito
                </button>
            </nav>

            <div class="collapse detalle_actividad" id="navbar2">
                <br />
                {include file="soportes/eliminar_nota_credito.tpl"}
            </div>
        </div>

        {* ==================================== ELIMINAR TRAFICO ========================================== *}

        <div class="pos-f-t">
            <nav class="alert alert-primary" style="margin-top: 15px; padding: 0;">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar3" aria-controls="navbar3" aria-label="Toggle navigation">
                    <i class="fa fa-list"></i>&emsp;Eliminar trafico
                </button>
            </nav>

            <div class="collapse detalle_actividad" id="navbar3">
                <br />
                {include file="soportes/eliminar_trafico.tpl"}
            </div>
        </div>

        {* ==================================== ELIMINAR FACTURA ========================================== *}

        <div class="pos-f-t">
            <nav class="alert alert-primary" style="margin-top: 15px; padding: 0;">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar4" aria-controls="navbar4" aria-label="Toggle navigation">
                    <i class="fa fa-list"></i>&emsp;Eliminar factura
                </button>
            </nav>

            <div class="collapse detalle_actividad" id="navbar4">
                <br />
                {include file="soportes/eliminar_factura.tpl"}
            </div>
        </div>

        {* ==================================== RECLASIFICAR CUENTAS ========================================== *}

        <div class="pos-f-t">
            <nav class="alert alert-primary" style="margin-top: 15px; padding: 0;">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar5" aria-controls="navbar5" aria-label="Toggle navigation">
                    <i class="fa fa-list"></i>&emsp;Reclasificar cuentas contables
                </button>
            </nav>

            <div class="collapse detalle_actividad" id="navbar5">
                <br />
                {include file="soportes/reclasificar_cuentas.tpl"}
            </div>
        </div>

    </fieldset>

    <fieldset>
        <div id="table_find" align="center">
            <table>
                <tr>
                    <td><label>Query :&emsp;</label></td>

                    <td>{$QUERY}&emsp;&emsp;</td>

                    <td>
                        <a href="#" onclick="limpiar();"><img src="../../../framework/media/images/forms/suggest.png" width="90%" /></a>
                    </td>
                </tr>

                <tr>
                    <td>&emsp;&emsp;&emsp;</td>

                    <td colspan="2"><label>CTRL + ENTER</label></td>
                </tr>
            </table>

            <input type="checkbox" onclick="check_all(this)" />&emsp;<span style="font-size: 11pt; font-weight: bold; color: red;">Aplicar para todas las bases de datos</span>
        </div>
    </fieldset>

    {$FORM1}

    <fieldset class="section">
        <table id="detalles" class="table table-hover" align="center" style="max-width: 100%;">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Empresa</th>
                    <th scope="col">Aplica</th>
                </tr>
            </thead>
            <tbody>
                {foreach name=detalles key=arrayIndex from=$DATABASES item=i}
                <tr>
                    <th scope="row">{$arrayIndex+1}</th>
                    <td>{$i.db}</td>
                    <td><input type="checkbox" name="procesar" value="{$i.db}" /></td>
                </tr>
                {/foreach}
            </tbody>
        </table>
    </fieldset>

     <div align="center" colspan="6">{$EJECUTAR}</div>
</body>
