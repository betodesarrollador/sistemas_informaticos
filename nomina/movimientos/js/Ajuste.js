$(document).ready(function(){

    $("#lista_liquidacion_novedad_id").change(function(){
									
        $('#liquidacion_novedad_id').val($('#lista_liquidacion_novedad_id').val());

        setDataFormWithResponse();

        $('#ajustar').attr('disabled', false);
        $('#contabilizar_diferencia').attr('disabled', true);
        $('#previsual').attr('disabled', true);

    });

});

function getListaLiquidacion(){

    var consecutivo_nom = $('#consecutivo_nom').val();
    var QueryString = "ACTIONCONTROLER=validaConsecutivoNomina&consecutivo_nom="+consecutivo_nom;

    $.ajax({
        type: "POST",
        url: "AjusteClass.php?rand=" + Math.random(),
        data: QueryString,
        dataType: "json",
        success: function (resp) {
            
            try {

                $('#lista_liquidacion_novedad_id').empty();

                for (value in resp) {

                    $('#lista_liquidacion_novedad_id').append($('<option>').val(resp[value]['liquidacion_novedad_id']).text(resp[value]['descripcion']));    

                }
                 
                $('#lista_liquidacion_novedad_id').attr('disabled', false);

            } catch (e) {
                alertJquery("se presento un inconveniente: " + e, "Atencion");
            }
        }
    });

}

function OnclickAjustar(){

    var liquidacion_novedad_id = $('#liquidacion_novedad_id').val();

    try{
      
        var QueryString = "ACTIONCONTROLER=OnclickAjustar&liquidacion_novedad_id="+liquidacion_novedad_id;
    
        $.ajax({
            type: "POST",
            url: "AjusteClass.php?rand=" + Math.random(),
            data: QueryString,
            beforeSend: function(){
                showDivLoading();
                formSubmitted = true;
            },
            success: function (resp) {
                
                try {   
    
                    alertJquery(resp);
    
                } catch (e) {
                    alertJquery("se presento un inconveniente: " + e, "Atencion");
                }
            }
        });
  
  }catch(e){
       alertJquery(e);
       console.log(resp);
  }
}


function setDataFormWithResponse(){
	
    var parametros 	= new Array ({campos:"liquidacion_novedad_id", valores:$('#liquidacion_novedad_id').val()});
    var forma 	= document.forms[0];
    var controlador = 'AjusteClass.php';
    
    FindRow(parametros,forma,controlador,null,function(resp){
	    
        var liquidacion_novedad_id = $('#liquidacion_novedad_id').val();
        var estado = $('#estado').val();
        var url = "DetalleAjusteClass.php?liquidacion_novedad_id="+liquidacion_novedad_id;
        
        $("#detalleAjusteNovedad").attr("src",url);
        $('#contrato').attr("disabled","true");
        $('#empleados').attr("disabled","true");
        $('#fecha_inicial').attr("disabled","true");
        $('#fecha_final').attr("disabled","true");
        $('#periodo').attr("disabled", "true");	

        $('#centro_de_costo_id').attr("disabled","true");
        
        $('#guardar').attr("disabled","true");
        $("#previsual").attr("disabled", "true");
        
        
        $('#limpiar').attr("disabled","");
      	    
    });
}

