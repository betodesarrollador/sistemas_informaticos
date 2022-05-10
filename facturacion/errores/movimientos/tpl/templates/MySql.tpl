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
    <fieldset>
        <legend>{$TITLEFORM}</legend>
        <div id="table_find" align="center">
            <table>
                <tr>
                    <td><label>Query :&emsp;</label></td>
                    <td>{$QUERY}&emsp;&emsp;</td>
                    <td><a href="#" onclick="limpiar();"><img src="../../../framework/media/images/forms/suggest.png" width="90%"></a></td>
                </tr>
                <tr>
                    <td>&emsp;&emsp;&emsp;</td>
                    <td colspan="2"><label>CTRL + ENTER</label></td>
                </tr>
               
            </table>
             <input type="checkbox" onclick="check_all(this)"/>&emsp;<span style="font-size: 11pt; font-weight: bold; color:red;">Aplicar para todas las bases de datos</span>
        </div>
    </fieldset>
    {$FORM1}
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
      <td id="loading" width="100%">&nbsp;</td>
      </tr>

      <tr>

       {section name=j start=0 loop=$num_columnas step=1}

       {math assign="contador" equation="x + y" x=$contador y=1}

      
          <td><img src="{$DATABASES[$contador].logo}" width="10%" >&emsp;<input type="checkbox" name="procesar" value="{$DATABASES[$contador].db}" />&emsp;{$DATABASES[$contador].db}</td>

      
       
       {/section} 
         
      </tr> 	  
         
        {/section} 

        

            <tr>
                <td><br><br></td>
            </tr>
            <tr>
                <td align="center" colspan="6">{$EJECUTAR}</td>
                <td align="center"><span>Nota. Cantidad de empresas ACTIVAS : {$DATABASES|@count}</span></td>
            </tr>
        </table>
    </fieldset>  
   
</body>
</html>