function updateGrid() {
    $("#refresh_QUERYGRID_Entrega").click();
}

$(document).ready(function () {

    $("#divEntrega").css("display", "none");
    

    if (intervalo) {
        clearInterval(intervalo);
        var intervalo = window.setInterval(function () { updateGrid() }, 120000);
    } else {
        var intervalo = window.setInterval(function () { updateGrid() }, 120000);
    }

    $("#generar_excel").click(function () {

        var formulario = this.form;

        var QueryString = "EntregaClass.php?ACTIONCONTROLER=generateFileexcel&rand=" + Math.random();

        document.location.href = QueryString;


    });


});

function viewDoc(despacho_id) {

    if ($("#divEntrega").is(":visible")) {

        $('#despacho_id').val(despacho_id);
        $("#divEntrega").dialog('close');
    } else {

        $('#despacho_id').val(despacho_id);

        $("#divEntrega").dialog({
            title: 'Entrega',
            width: 450,
            height: 280,
            closeOnEscape: true
        });

    }

}



function EntregaOnSaveOnUpdateonDelete(formulario, resp) {

    Reset(formulario);
    clearFind();
    $("#refresh_QUERYGRID_Entrega").click();

    if ($('#guardar')) $('#guardar').attr("disabled", "");


    alertJquery(resp, "Entrega");
    $("#divEntrega").dialog('close');
   

}


function reloadGrid() {
    $("#refresh_QUERYGRID_Entrega").click();

}