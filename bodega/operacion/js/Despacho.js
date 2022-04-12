function updateGrid() {
    $("#refresh_QUERYGRID_Despacho").click();
}

$(document).ready(function () {

    $("#divTurno").css("display", "none");
    $("#divMuelle").css("display", "none");


    if (intervalo) {
        clearInterval(intervalo);
        var intervalo = window.setInterval(function () { updateGrid() }, 120000);
    } else {
        var intervalo = window.setInterval(function () { updateGrid() }, 120000);
    }

    $("#generar_excel").click(function () {

        var formulario = this.form;

        var QueryString = "DespachoClass.php?ACTIONCONTROLER=generateFileexcel&rand=" + Math.random();

        document.location.href = QueryString;


    });


});

function viewDoc(alistamiento_id) {

    if ($("#divTurno").is(":visible")) {

        $('#alistamiento_salida_id').val(alistamiento_id);
        $('#turno').val(turno + 1);
        $("#divTurno").dialog('close');
    } else {

        $('#alistamiento_salida_id').val(alistamiento_id);
        $('#turno').val(turno + 1);
        //document.getElementById('turno').disabled = true;
        /* $('#turno').blur(function () {
            
             if (this.value <= turno && this.value != '') {
                alertJquery("¡El Turno "+turno+" Ya fue Asignado!");
                 $('#turno').val('');
            }
        }); */

        $("#divTurno").dialog({
            title: 'Asignar Turno',
            width: 450,
            height: 280,
            closeOnEscape: true
        });

    }

}

/* function viewDoc1(alistamiento_id) {

    if ($("#divMuelle").is(":visible")) {

        $('#alistamiento_salida_id1').val(alistamiento_id);
        $("#divMuelle").dialog('close');
    } else {
        $('#alistamiento_salida_id1').val(alistamiento_id);
        $("#divMuelle").dialog({
            title: 'Asignar Muelle',
            width: 450,
            height: 280,
            closeOnEscape: true
        });
    }
} */



function DespachoOnSaveOnUpdateonDelete(formulario, resp) {

    Reset(formulario);
    clearFind();
    $("#refresh_QUERYGRID_Despacho").click();

    if ($('#guardar')) $('#guardar').attr("disabled", "");


    alertJquery(resp, "Asignar");
    $("#divTurno").dialog('close');
    $("#divMuelle").dialog('close');

}


function reloadGrid() {
    $("#refresh_QUERYGRID_Despacho").click();

}