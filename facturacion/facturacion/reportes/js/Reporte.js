function Cliente_si() {
    if ($('#si_cliente').val() == 1) {

        if ($('#cliente')) $('#cliente').attr("disabled", "");

    } else if ($('#si_cliente').val() == 'ALL') {

        if ($('#cliente')) $('#cliente').attr("disabled", "true");
        $('#cliente').val('');
        $('#cliente_id').val('');
    }

}

//Agregado filtro para comerciales
function Comercial_si() {
    if ($('#si_comercial').val() == 1) {

        if ($('#comercial')) $('#comercial').attr("disabled", "");

        if ($('#cliente')) $('#cliente').attr("disabled", "true");
        $('#cliente').val('');
        $('#cliente_id').val('');
        document.getElementById("si_cliente").selectedIndex = 2;

    } else if ($('#si_comercial').val() == 'ALL') {

        if ($('#comercial')) $('#comercial').attr("disabled", "true");
        $('#comercial').val('');
        $('#comercial_id').val('');

    }

}

//Agregado filtro para comerciales

$(document).ready(function() {
    $("#generar_excel").click(function() {

        var formulario = this.form;

        if (ValidaRequeridos(formulario)) {

            var desde = $("#desde").val();
            var hasta = $("#hasta").val();
            var tipo = $("#tipo").val();
            var oficina_id = $("#oficina_id").val();
            var all_ofice = $("#all_ofice").val();
            var si_cliente = $("#si_cliente").val();
            var si_comercial = $("#si_comercial").val();
            var comercial_id = $("#comercial_id").val();
            var cliente_id = $("#cliente_id").val();
            var saldos = $("#saldos").val();

            var QueryString = "ReportesClass.php?ACTIONCONTROLER=generateFileexcel&desde=" + desde + "&hasta=" + hasta + "&tipo=" + tipo + "&oficina_id=" + oficina_id +
                "&cliente_id=" + cliente_id + "&comercial_id=" + comercial_id + "&all_ofice=" + all_ofice + "&si_cliente=" + si_cliente + "&si_comercial=" + si_comercial + "&saldos=" + saldos + "&rand=" + Math.random();

            document.location.href = QueryString;

        }
    });

    $('#saldo').hide();
    $('#saldos').hide();
    $('#saldo_pendiente').hide();
    $('#saldos_corte').hide();
    $('#fecha_corte').hide();
    $('#fecha_cortes').hide();

    $('#tipo').change(function() {
        if ($('#tipo').val() == 'EC' || $('#tipo').val() == 'FP') {

            if ($('#tipo').val() == 'EC') {
                $('#saldo').show();
                $('#saldo_pendiente').show();
            } else {
                $('#saldo').hide();
                $('#saldo_pendiente').hide();
            }

            $('#saldos').show();
            $('#saldos_corte').show();
        } else {
            $('#saldo').hide();
            $('#saldos').hide();
            $('#saldo_pendiente').hide();
            $('#saldos_corte').hide();
        }

    });

    $('#saldos').change(function() {
        if ($('#saldos').val() == '1') {
            $('#fecha_corte').show();
            $('#fecha_cortes').show();
        } else {
            $('#fecha_corte').hide();
            $('#fecha_cortes').hide();
        }
    });


});

function enviarEmail(formulario) {

    var QueryString = "ACTIONCONTROLER=enviar&formulario=" + FormSerialize(formulario);
    /* popPup(QueryString, 'Impresion Cartas Cobro', 900, 600); */
    $.ajax({
        url: "DetallesClass.php?rand=" + Math.random(),
        data: QueryString,
        success: function(response) {
            if ($.trim(response) == 'true') {
                alertJquery('Email Enviado', '¡Enviado Exitosamente!');
            } else {
                console.log(response);
                alertJquery(response, 'Inconsistencia Enviando');
            }
        }

    });

}


function beforePrint(formulario) {

    if (ValidaRequeridos(formulario)) {

        var QueryString = "DetallesClass.php?" + FormSerialize(formulario);

        popPup(QueryString, 'Impresion Reporte', 800, 600);
    }
}

function descargarexcel(formulario) {

    if (ValidaRequeridos(formulario)) {
        var QueryString = "DetallesClass.php?download=true&" + FormSerialize(formulario);
        $("#frameReporte").attr("src", QueryString);

    }
}


function all_oficce() {
    if (document.getElementById('all_oficina').checked == true) {
        $('#all_oficina').val('SI');

        var objSelect = document.getElementById('oficina_id');
        var numOp = objSelect.options.length - 1;


        for (var i = numOp; i > 0; i--) {

            if (objSelect.options[i].value != 'NULL') {
                objSelect.options[i].selected = true;
            } else {
                objSelect.options[i].selected = false;
            }

        }



    } else {
        $('#all_oficina').val('NO');
        var objSelect = document.getElementById('oficina_id');
        var numOp = objSelect.options.length - 1;


        for (var i = numOp; i > 0; i--) {

            if (objSelect.options[i].value != 'NULL') {
                objSelect.options[i].selected = false;
            } else {
                objSelect.options[i].selected = true;
            }

        }

    }

}

function OnclickGenerar(formulario) {

    if (ValidaRequeridos(formulario)) {
        var QueryString = "DetallesClass.php?" + FormSerialize(formulario);
        $("#frameReporte").attr("src", QueryString);
        showDivLoading();
        $("#frameReporte").load(function(response) { removeDivLoading(); });

    }

}