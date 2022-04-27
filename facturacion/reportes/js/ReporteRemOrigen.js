function usuarioOnReset(formulario) {

    $("#frameReporte").attr("src", "../../../framework/tpl/blank.html");

}

function setObservaciones(id, text, obj) {

    var origen = text.split("-");

    $("textarea[id=observaciones]").val($.trim(origen[0]));

}

function OnclickGenerar(formulario) {

    if (ValidaRequeridos(formulario)) {
        var QueryString = "DetallesRemOrigenClass.php?" + FormSerialize(formulario);
        $("#frameReporte").attr("src", QueryString);
        showDivLoading();
        $("#frameReporte").load(function(response) { removeDivLoading(); });
    }

}

$(document).ready(function() {

    ///INICIO VALIDACION FECHAS DE REPORTE

    $('#desde').change(function() {

        var fechah = $('#hasta').val();
        var fechad = $('#desde').val();
        var today = new Date();

        if ((Date.parse(fechah) < Date.parse(fechad)) || (Date.parse(fechad) > today)) {
            alertJquery('Esta fecha no puede ser mayor a la fecha final o mayor a hoy.');
            return this.value = $('#hasta').val();
        };
    });

    $('#hasta').change(function() {

        var fechah = $('#hasta').val();
        var fechad = $('#desde').val();
        var today = new Date();

        if ((Date.parse(fechah) < Date.parse(fechad)) || (Date.parse(fechah) > today)) {
            alertJquery('Esta fecha no puede ser menor a la fecha de inicio o mayor a hoy.');
            return this.value = $('#desde').val();
        };
    });

    ///FIN VALIDACION FECHAS DE REPORTE

    $("#generar_excel").click(function() {

        var formulario = this.form;

        if (ValidaRequeridos(formulario)) {

            var desde = $("#desde").val();
            var hasta = $("#hasta").val();
            var tipo = $("#tipo").val();
            var oficina_id = $("#oficina_id").val();
            var all_ofice = $("#all_ofice").val();
            var si_cliente = $("#si_cliente").val();
            var cliente_id = $("#cliente_id").val();
            var saldos = $("#saldos").val();

            var QueryString = "ReportesRemOrigenClass.php?ACTIONCONTROLER=generateFileexcel&desde=" + desde + "&hasta=" + hasta + "&tipo=" + tipo + "&oficina_id=" + oficina_id +
                "&cliente_id=" + cliente_id + "&all_ofice=" + all_ofice + "&si_cliente=" + si_cliente + "&saldos=" + saldos + "&rand=" + Math.random();

            document.location.href = QueryString;

        }
    });

});

function descargarexcel(formulario) {

    if (ValidaRequeridos(formulario)) {
        var QueryString = "DetallesRemOrigenClass.php?download=true&" + FormSerialize(formulario);
        $("#frameReporte").attr("src", QueryString);

    }
}

function beforePrint(formulario) {

    if (ValidaRequeridos(formulario)) {
        var QueryString = "DetallesRemOrigenClass.php?" + FormSerialize(formulario);
        popPup(QueryString, 'Impresion Reporte', 800, 600);

    }
}