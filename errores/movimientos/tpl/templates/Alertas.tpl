<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
    {$JAVASCRIPT}
    {$TABLEGRIDJS}
    {$CSSSYSTEM}
    {$TABLEGRIDCSS}
    {$TITLETAB}
    <link rel="stylesheet" href="sistemas_informaticos/bodega/bases/css/bootstrap1.css">
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
</head>

<body>
   {$FORM1}
    <fieldset>
    
        <legend>{$TITLEFORM}</legend>
        <div id="table_find" align="center">
        <fieldset class="section">
            <table>
            <tr>
             <td><label>MENSAJE</label></td>
             <td><label>&emsp;</label></td>
             <td><label>MODULOS</label></td>
             
            </tr>
                <tr>
                    
                    <td>{$MENSAJE}&emsp;&emsp;</td>
                    <td><a href="#" onclick="limpiar();"><img src="../../../framework/media/images/forms/suggest.png"></a></td>
                   
                    <td>{$ALLMODULOS}<br>{$SELECTMODULOS}{$MODULOS}&emsp;&emsp;</td>    
                               
                </tr>
                <tr>
                   <td><a href="../../../framework/ayudas/archivoBase.docx" download="ArchivoBase"><img src="../../../framework/media/images/general/word.png" width="25" height="25"/></a>&nbsp;&nbsp;&nbsp;&nbsp;{$ARCHIVO}</td>
                </tr>
                <tr>
                
                <table align="left">
                       
                <tr>
                
                    <td><label>FECHA INICIO</label>&emsp;{$FECHAINICIO}&emsp;&emsp;&emsp;&emsp;</td>
                    <td><label>FECHA FIN</label>&emsp;{$FECHAFIN}&emsp;&emsp;&emsp;&emsp;</td>
                    <td><label>LINK VIDEO</label>&emsp;{$LINKVIDEO}</td>
                
                </tr>
                </table>
                
                </tr>
               
               
            </table>
             <input type="checkbox" onclick="check_all(this)"/>&emsp;<span style="font-size: 11pt; font-weight: bold; color:red;">Aplicar para todas las empresas</span>
        </fieldset>
        </div>
    </fieldset>
 
    <fieldset class="section">  
        <table align="center">       

       {section name=k  loop=7 step=-1}

            {assign var="num_columnas" value=$smarty.section.k.index}

            {math assign="multiplo" equation="x / y" x=$DATABASES|@count y=$num_columnas}

            {if is_int($multiplo)}{php}break;{/php}{/if}
       
       {/section} 



      {assign var="contador" value=-1}

      {math assign="array" equation="x / y" x=$DATABASES|@count y=$num_columnas}

      {section name=i start=0 loop=$array step=1}
      
      <tr> 
      <td id="loading">&nbsp;</td>
      </tr>

      <tr>

       {section name=j start=0 loop=$num_columnas step=1}

       {math assign="contador" equation="x + y" x=$contador y=1}

       {if $DATABASES[$contador].logo neq ''}

          <td>
            <img src="{$DATABASES[$contador].logo}" width="10%" >&emsp;<input type="checkbox" name="procesar" value="{$DATABASES[$contador].db}" onclick="getEmpresas()"/>&emsp;{$DATABASES[$contador].empresa}
          </td>

       {/if}
       
       {/section} 
         
      </tr> 	  
         
        {/section} 

        

            <tr>
                <td><br><br></td>
            </tr>
            <tr>
                <td align="center" colspan="6">{$GUARDAR}{$EMPRESAS}</td>
            </tr>
            <tr>
               <td align="center" colspan="6"><span>Nota. Cantidad de empresas ACTIVAS : {$DATABASES|@count}</span></td>
            </tr>
        </table>
    </fieldset>  
   {$FORM1END}
</body>
</html>