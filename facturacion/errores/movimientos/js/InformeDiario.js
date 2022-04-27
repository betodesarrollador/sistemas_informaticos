// JavaScript Document
$(document).ready(function(){

    getusuario();
    $("#novedad_informe_diario_id").val('1');

});

function getusuario(){

    var QueryString = "ACTIONCONTROLER=getusuario";

    $.ajax({
        url: "InformeDiarioClass.php",
        data: QueryString,
        success: function (response) {

            $("#usuario").val(response);
        }
    });


}

function setDataFormWithResponse() {

    var QueryString = "ACTIONCONTROLER=onclickFind&informe_id="+$('#informe_id').val();

    $.ajax({
        url: "InformeDiarioClass.php",
        data: QueryString,
        success: function (response) {

            var datos = $.parseJSON(response);
		  
            var novedad_informe_diario_id = document.getElementById('novedad_informe_diario_id');
                
            novedades 		= datos[0]['novedad_informe_diario_id'].split(',');
                
            for (var i = 0; i < novedad_informe_diario_id.length; i++) {

                novedad_informe_diario_id.options[i].selected = false;
                    
                for (var j = 0; j < datos[0]['novedad_informe_diario_id'].length; j++) {
                        
                    if(novedad_informe_diario_id.options[i].value == datos[0]['novedad_informe_diario_id'][j]){
                    
                        novedad_informe_diario_id.options[i].selected = true;
                            
                    }
                        
                }
            } 

            $("#usuario").val(datos[0]['usuario']);
            $("#quehicehoy").val(datos[0]['quehicehoy']);
            $("#dotomorrow").val(datos[0]['dotomorrow']);
            $("#novedades").val(datos[0]['novedades']);

            if ($('#guardar')) $('#guardar').attr("disabled", "true");
            if ($('#actualizar')) $('#actualizar').attr("disabled", "");
            if ($('#borrar')) $('#borrar').attr("disabled", "");
            if ($('#limpiar')) $('#limpiar').attr("disabled", "");
        }
    });


}




function InformeDiarioOnSaveOnUpdateonDelete(formulario, resp) {

    InformeDiarioOnReset(formulario);
    getusuario();
    alertJquery(resp, "informe_diario");


}

function InformeDiarioOnReset(formulario) {

    Reset(formulario);
    clearFind();
    $("#novedad_informe_diario_id").val('1');
    if ($('#guardar')) $('#guardar').attr("disabled", "");
    if ($('#actualizar')) $('#actualizar').attr("disabled", "true");
    if ($('#borrar')) $('#borrar').attr("disabled", "true");
    if ($('#limpiar')) $('#limpiar').attr("disabled", "");

}

