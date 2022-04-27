$(document).ready(function() {
    $("#divAnulacion").css('display', 'none');
    $("#saveDetallesCorreos").click(function() {
        window.frames[0].saveDetalleUsuarios();
    });

    $("#deleteDetallesTraslados").click(function() {
        window.frames[0].deleteDetallesTraslados();
    });


    $("input[type='checkbox']").click(function() {

        if ($("#calidad").is(":checked")) {
            $("#calidad").val("1");
        } else {
            $("#calidad").val("0");
        }

        if ($("#dureza").is(":checked")) {
            $("#dureza").val("1");
        } else {
            $("#dureza").val("0");
        }


        if ($("#soldadura").is(":checked")) {
            $("#soldadura").val("1");
        } else {
            $("#soldadura").val("0");
        }
    });

});

function onclickCancellation(formulario) {

    var traslado_id = $("#traslado_id").val();

    if ($("#divAnulacion").is(":visible")) {

        var formulario = document.getElementById('TrasladosForm');
        var causal_anulacion_id = $("#causal_anulacion_id").val();
        var observacion_anulacion = $("#observacion_anulacion").val();

        if (ValidaRequeridos(formulario)) {


            var QueryString = "ACTIONCONTROLER=onclickCancellation&traslado_id=" + traslado_id + "&observacion_anulacion=" + observacion_anulacion + "&causal_anulacion_id=" + causal_anulacion_id;

            $.ajax({
                url: "TrasladosClass.php?rand=" + Math.random(),
                data: QueryString,
                beforeSend: function() {
                    showDivLoading();
                    formSubmitted = true;
                },
                success: function(response) {

                    Reset(formulario);
                    TrasladosOnReset(formulario);
                    removeDivLoading();
                    $("#divAnulacion").dialog('close');

                    formSubmitted = false;
                    if ($.trim(response) == 'true') {

                        alertJquery('Traslado Anulado', 'Anulado Exitosamente');
                        $("#refresh_QUERYGRID_Traslados").click();



                    } else {
                        alertJquery(response, 'Inconsistencia Anulando');
                    }


                }

            });

        }

    } else {

        var estado = document.getElementById("estado").value;

        if (parseInt(traslado_id) > 0) {

            $("input[name=anular]").each(function() { this.disabled = false; });

            $("#divAnulacion").dialog({
                title: 'Anulacion Alistamientos',
                width: 450,
                height: 280,
                closeOnEscape: true
            });

        } else {
            alertJquery('Debe Seleccionar primero una Alistamiento', 'Anulacion');
        }

    }


}

function disabledInputsFormRemesa(forma) {

    $(forma).find("input,select,textarea").each(function() {

        if (this.type != 'button') {
            this.disabled = true;
        }
    });
}

function enabledInputsFormRemesa(forma) {

    $(forma).find("input,select,textarea").each(function() {

        if (this.type != 'button') {
            this.disabled = false;
        }
    });
}





function setDataFormWithResponse() {
    var parametros = new Array({
        campos: "traslado_id",
        valores: $("#traslado_id").val()
    });
    var forma = document.forms[0];
    var controlador = "TrasladosClass.php";

    FindRow(parametros, forma, controlador, null, function(resp) {

        var data = $.parseJSON(resp);

        var fecha = data[0]['fecha'];
        var producto_id = data[0]["producto_id"];
        var usuario_id = data[0]["usuario_id"];
        var fecha_registro = data[0]["fecha_registro"];
        var usuario_actualiza_id = data[0]["usuario_actualiza_id"];
        var fecha_actualiza = data[0]["fecha_actualiza"];
        var estado = data[0]["estado"];


        $("#fecha").val(fecha);
        $("#producto_id").val(producto_id);
        $("#estado").val(estado);
        $("#usuario_id").val(usuario_id);
        $("#fecha_registro").val(fecha_registro);
        $("#usuario_actualiza_id").val(usuario_actualiza_id);
        $("#fecha_actualiza").val(fecha_actualiza);


        var traslado_id = $("#traslado_id").val();

        var url = "DetalleTrasladosClass.php?traslado_id=" + traslado_id + "&rand=" + Math.random();

        $("#DetalleTraslados").attr("src", url);


        if (estado == 'I') {
            disabledInputsFormRemesa(forma);
            if ($("#guardar")) $("#guardar").attr("disabled", "true");
            if ($("#actualizar")) $("#actualizar").attr("disabled", "true");
            if ($("#borrar")) $("#borrar").attr("disabled", "");
            if ($("#limpiar")) $("#limpiar").attr("disabled", "");
            if ($("#anular")) $("#anular").attr("disabled", "true");
        } else {
            if (estado == 'A') {
                $('#traslado_id').attr("disabled", "true");
                $('#producto_id').attr("disabled", "");
                $('#estado').attr("disabled", "true");
                $('#fecha').attr("disabled", "");
                if ($("#guardar")) $("#guardar").attr("disabled", "true");
                if ($("#actualizar")) $("#actualizar").attr("disabled", "");
                if ($("#borrar")) $("#borrar").attr("disabled", "true");
                if ($("#limpiar")) $("#limpiar").attr("disabled", "");
                if ($("#anular")) $("#anular").attr("disabled", "");
            }
        }
    });

}




function soloNumeros(e) {
    var key = window.Event ? e.which : e.keyCode;

    return (key >= 48 && key <= 57) || key == 8;
}

function TrasladosOnSave(formulario, resp) {

    var data = $.parseJSON(resp);

    var traslado_id = data['traslado_id'];
    var fecha_registro = data['fecha_registro'];


    if (isNumber(traslado_id)) {

        $("#refresh_QUERYGRID_Traslados").click();
        var url = "DetalleTrasladosClass.php?traslado_id=" + traslado_id + "&rand=" + Math.random();

        $("#DetalleTraslados").attr("src", url);

        var usuario_id = $('#usuario_static').val();
        $('#usuario_id').val(usuario_id);

        if ($("#guardar")) $("#guardar").attr("disabled", "true");
        if ($("#actualizar")) $("#actualizar").attr("disabled", "");
        if ($("#borrar")) $("#borrar").attr("disabled", "");
        if ($("#limpiar")) $("#limpiar").attr("disabled", "");
        $('#traslado_id').val(traslado_id);
        $("#fecha_registro").val(fecha_registro);

        alertJquery("Guardado Exitosamente.", "Traslados");

        clearFind();
    } else {
        if ($("#guardar")) $("#guardar").attr("disabled", "");
        if ($("#actualizar")) $("#actualizar").attr("disabled", "true");
        if ($("#borrar")) $("#borrar").attr("disabled", "true");
        if ($("#limpiar")) $("#limpiar").attr("disabled", "");
        alertJquery("Ocurrio una inconsistencia : " + resp, "Traslados");
    }
}

function TrasladosOnUpdate(formulario, resp) {
    var traslado_id = $("#traslado_id").val();
    var url =
        "DetalleTrasladosClass.php?traslado_id=" +
        traslado_id +
        "&rand=" +
        Math.random();

    $("#DetalleTraslados").attr("src", url);
    var usuario_id = $('#usuario_static').val();
    $('#usuario_id').val(usuario_id);

    $("#refresh_QUERYGRID_Traslados").click();
    if ($("#guardar")) $("#guardar").attr("disabled", "");
    if ($("#actualizar")) $("#actualizar").attr("disabled", "true");
    if ($("#borrar")) $("#borrar").attr("disabled", "true");
    if ($("#limpiar")) $("#limpiar").attr("disabled", "");


    alertJquery($.trim(resp), "Traslados");
    Reset(formulario);
    clearFind();
}

function TrasladosOnDelete(formulario, resp) {

    Reset(formulario);

    clearFind();
    var usuario_id = $('#usuario_static').val();
    $('#usuario_id').val(usuario_id);
    $("#DetalleTraslados").attr("src", "sistemas_informaticos/framework/tpl/blank.html");
    $("#refresh_QUERYGRID_Traslados").click();
    if ($("#guardar")) $("#guardar").attr("disabled", "");
    if ($("#actualizar")) $("#actualizar").attr("disabled", "true");
    if ($("#borrar")) $("#borrar").attr("disabled", "true");
    if ($("#limpiar")) $("#limpiar").attr("disabled", "");
    alertJquery($.trim(resp), "Traslados");
}

function TrasladosOnReset() {
    clearFind();
    var usuario_id = $('#usuario_static').val();
    $('#usuario_id').val(usuario_id);
    $("#DetalleTraslados").attr("src", "sistemas_informaticos/framework/tpl/blank.html");
    $("#guardar").attr("disabled", "");
    $("#actualizar").attr("disabled", "true");
    $("#borrar").attr("disabled", "true");
    $("#limpiar").attr("disabled", "");
}

function updateGrid() {
    $("#refresh_QUERYGRID_Traslados").click();
}