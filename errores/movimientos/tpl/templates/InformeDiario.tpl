<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<head>
   
    {$JAVASCRIPT}
    {$CSSSYSTEM}
    {$TITLETAB}
<link rel="stylesheet" href="../../../framework/css/bootstrap1.css">
</head>

<body>
    <fieldset>
        <legend>{$TITLEFORM}</legend>
        <div id="table_find" align="center">
            <table>
                <tr>
                    <td><label>Busqueda : </label></td>
                    <td>{$BUSQUEDA}</td>
                </tr>
            </table>
        </div>
    </fieldset>
{$FORM1}
    <div class="container">
        <div class="row">
            <div class="col">

            <div class="form-group row">
                <div class="col-2 col-md-2 mb-2">
                    <label>Informe No.</label>
                    {$INFORMEDIARIO}
                </div>
                <div class="col-6 col-md-6 mb-2">
                    <label>Usuario:&emsp;&emsp;&emsp;&emsp;&emsp;</label>
                    {$USUARIO}{$USUARIOID}
                </div>

            </div>
            <div class="form-group row">
                
                <div class="form-group row">
                    <div class="col-12 col-md-12 mb-2">
                        <label>¿Que hice hoy?&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</label>
                        {$QUEHICEHOY}                        
                    </div>

                    <div class="col-12 col-md-12 mb-2">
                        <label>¿Que voy hacer mañana?&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</label>
                        {$DOTOMORROW}
                    </div>

                    <div class="col-12 col-md-12 mb-2">
                        <label>¿Que novedades se me presentaron en medio del desarrollo de mis tareas?</label>
                        {$NOVEDADES}
                    </div>
                </div>



            </div>

            <div class="row justify-content-center">
                <div class="col-12 col-sm-9 col-md-4">
                    {$GUARDAR}&nbsp;{$ACTUALIZAR}&nbsp;{$LIMPIAR}
                </div>
            </div>

        </div>
    </div>
{$FORM1END}
  
</body>

</html>