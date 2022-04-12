<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">

    {$JAVASCRIPT}
    {$TABLEGRIDJS}
    {$CSSSYSTEM}
    {$TABLEGRIDCSS}
    {$TITLETAB}
</head>

<body>
    
    <legend>{$TITLEFORM}</legend>

    {$FORM1}
    <div class="row">
        <div class="block">
            <table>
                <tbody>
                    {foreach from=$modulos item=m name=modulos}
                        <!-- CUANDO ES MODULO PADRE -->
                        <tr>
                            <!-- COLLAPSIBLE -->
                                {if $m.modulo eq 1}
                                    <button type="button" class="collapsible">
                                        <label><i class="arrow right" id="arrow"></i><img src="{$m.path_imagen}" width="25" height="25">&nbsp;&nbsp;{$m.descripcion}</label>
                                        <label class="switch">
                                            <input type="checkbox" onclick="moduleOnOff({$m.consecutivo});" value="{$m.estado}"><span class="slider round"></span>
                                        </label>
                                    </button>
                                    <div class="content">
                                        
                                        {foreach from=$modulos item=c name=child}
                                            <!-- CUANDO ES MODULO HIJO DE SEGUNDO NIVEL -->
                                            {if $c.modulo eq 0 && $c.es_formulario eq 1 && $c.nivel_superior eq $m.consecutivo}
                                                
                                                <p>
                                                    <img src="{$c.path_imagen}" width="25" height="25">&nbsp;&nbsp;{$c.descripcion}
                                                    <label class="switch">
                                                        <input type="checkbox" onclick="moduleOnOff({$c.consecutivo});" value="{$c.estado}"><span class="slider round"></span>
                                                    </label>
                                                </p>

                                            {elseif $c.modulo eq 0 && $c.es_formulario eq 0 && $c.nivel_superior eq $m.consecutivo}

                                                <button type="button" class="collapsible">
                                                    <label><i class="arrow right" id="arrow"></i><img src="{$c.path_imagen}" width="25" height="25">&nbsp;&nbsp;{$c.descripcion}</label>
                                                    <label class="switch">
                                                        <input type="checkbox" onclick="moduleOnOff({$c.consecutivo});" value="{$c.estado}"><span class="slider round"></span>
                                                    </label>
                                                </button>
                                                <div class="content">

                                                    {foreach from=$modulos item=sc name=sub_child}
                                                        <!-- CUANDO ES MODULO HIJO DE TERCER NIVEL -->
                                                        {if $sc.modulo eq 0 && $sc.es_formulario eq 1 && $sc.nivel_superior eq $c.consecutivo}

                                                            <p><img src="{$sc.path_imagen}" width="25" height="25">&nbsp;&nbsp;{$sc.descripcion}
                                                            <label class="switch">
                                                                <input type="checkbox" onclick="moduleOnOff({$sc.consecutivo});" value="{$sc.estado}"><span class="slider round"></span>
                                                            </label></p>

                                                        {elseif $sc.modulo eq 0 && $sc.es_formulario eq 0 && $sc.nivel_superior eq $c.consecutivo}
                                                            
                                                            <button type="button" class="collapsible">
                                                                <label><i class="arrow right" id="arrow"></i><img src="{$sc.path_imagen}" width="25" height="25">&nbsp;&nbsp;{$sc.descripcion}</label>
                                                                <label class="switch">
                                                                    <input type="checkbox" onclick="moduleOnOff({$sc.consecutivo});" value="{$sc.estado}"><span class="slider round"></span>
                                                                </label>
                                                            </button>
                                                            <div class="content">
                                                                
                                                            {foreach from=$modulos item=ssc name=sub_sub_child}
                                                                <!-- CUANDO ES MODULO HIJO DE CUARTO NIVEL -->
                                                                {if $ssc.modulo eq 0 && $ssc.es_formulario eq 1 && $ssc.nivel_superior eq $sc.consecutivo}

                                                                    <p><img src="{$ssc.path_imagen}" width="25" height="25">&nbsp;&nbsp;{$ssc.descripcion}
                                                                    <label class="switch">
                                                                        <input type="checkbox" onclick="moduleOnOff({$ssc.consecutivo});" value="{$ssc.estado}"><span class="slider round"></span>
                                                                    </label></p>

                                                                {/if}

                                                            {/foreach}

                                                            </div>

                                                        {/if}

                                                    {/foreach}

                                                </div>

                                            {/if}

                                        {/foreach}

                                    </div>
                                {/if}
                                
                            <!-- COLLAPSIBLE -->
                        </tr>
                    {/foreach}
                </tbody>
            </table>
        </div>
    </div>
    {$FORM1END}
</body>

</html>