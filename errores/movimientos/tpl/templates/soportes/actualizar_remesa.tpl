<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />

    <script language="javascript" type="text/javascript" src="../../../../framework/jquery/jquery-3.5.1.min.js?random=1853308954"></script>
    <script language="javascript" type="text/javascript" src="../../../../framework/js/jqcalendar/jquery.ui.datepicker.js?random=607867917"></script>
    <script language="javascript" type="text/javascript" src="../../../../framework/js/jqcalendar/jquery.ui.datepicker-es.js?random=1023766485"></script>
    <script language="javascript" type="text/javascript" src="../../../../framework/js/jqueryform.js?random=399011339"></script>
    <script language="javascript" type="text/javascript" src="../../../../framework/js/funciones.js?random=527741931"></script>
    <script language="javascript" type="text/javascript" src="../../../../framework/js/ajax-list.js?random=1781966785"></script>
    <script language="javascript" type="text/javascript" src="../../../../framework/js/ajax-dynamic-list.js?random=1893488798"></script>
    <script language="javascript" type="text/javascript" src="../../js/MySql.js?random=1940952642"></script>
    <script language="javascript" type="text/javascript" src="../../../../framework/js/jquery.alerts.js?random=434790906"></script>
    <script language="javascript" type="text/javascript" src="../../../../framework/bootstrap-4.0.0/dist/js/bootstrap.min.js?random=62605505"></script>
    <script language="javascript" type="text/javascript" src="../../../../framework/sweetalert2/dist/sweetalert2.min.js?random=1348861726"></script>

    <link media="screen" type="text/css" href="../../../../framework/css/ajax-dynamic-list.css?random=175597587" rel="stylesheet" />
    <link media="screen" type="text/css" href="../../../../framework/css/DatosBasicos.css?random=2124475656" rel="stylesheet" />
    <link media="screen" type="text/css" href="../../../../framework/css/general.css?random=1622739242" rel="stylesheet" />
    <link media="screen" type="text/css" href="../../../../framework/css/jquery.alerts.css?random=1205080234" rel="stylesheet" />
    <link media="screen" type="text/css" href="../../../facturacion/reportes/css/Reporte.css?random=1183630628" rel="stylesheet" />
    <link media="screen" type="text/css" href="../../../../framework/bootstrap-4.0.0/dist/css/bootstrap.min.css?random=442740915" rel="stylesheet" />
    <link media="screen" type="text/css" href="../../../../framework/bootstrap-4.0.0/dist/css/bootstrap.css?random=765386410" rel="stylesheet" />
    <link media="screen" type="text/css" href="../../../../framework/sweetalert2/dist/sweetalert2.min.css?random=1932124885" rel="stylesheet" />
    <link media="screen" type="text/css" href="../../../../framework/css/font-awesome-4.7.0/css/font-awesome.min.css?random=1533589160" rel="stylesheet" />
</head>

<body>
    <form id="form_actualizar_fecha">
        <div class="form-row">

            <div class="col">
                <input type="text" class="form-control" placeholder="Numero de remesa"   name="numero_remesa" id="numero_remesa" />
            </div>

            <div class="col">
                <input type="date" class="form-control"  name="fecha_remesa" id="fecha_remesa" />
            </div>

            <div class="col">
                 <button type="button" class="btn btn-primary" onclick="setCamposFechaRemesa()">Crear SQL</button>
            </div>
        </div>

    </form>
</body>
