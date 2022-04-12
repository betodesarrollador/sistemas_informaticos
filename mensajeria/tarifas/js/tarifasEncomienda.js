// JavaScript Document
$(document).ready(function(){
	
	$("#tipo_servicio_mensajeria_id").change(function(){
		getOptionsTipoEnvio();
	});	
	
	
});

function EncomiendaOnSaveOnUpdateonDelete(formulario,resp){
	
	switch (resp) {
      
		case 'save':
		  TarifasEncomiendaesOnReset();
		  alertJquery('Se guardo exitosamente el registro','respuesta');
		  break;
		  
		case 'update':
		  TarifasEncomiendaesOnReset();
		  alertJquery('Se actualizo exitosamente el registro','respuesta');
		  break;
	   
		case 'delete':
		  TarifasEncomiendaesOnReset();
		  alertJquery('Se elimino exitosamente el registro','respuesta');
	   break;
	   
		default:
		
		  alertJquery(resp,'Error');
		  
		  break;
	  }
	
 }

 function NumCheck(e, field) {

    key = e.keyCode ? e.keyCode : e.which
  
    // backspace
  
    if (key == 8) return true
  
    // 0-9
  
    if (key > 47 && key < 58) {
      
      
      if (field.value == "") return true
      
      regexp = /.[0-9]{2}$/
  
      return true
  
    }
  
    // .
  
    if (key == 46) {
  
      if (field.value == "") return false
  
      regexp = /^[0-9]+$/
  
      return regexp.test(field.value)
  
    }
  
    // other key
  
    return false
  
   
  
  }
 

function getOptionsTipoEnvio(){

	var TipoServicioId   = $("#tipo_servicio_mensajeria_id").val();
	var QueryString = "ACTIONCONTROLER=getOptionsTipoEnvio&tipo_servicio_mensajeria_id="+TipoServicioId;

	if(TipoServicioId != 'NULL'){
	
		$.ajax({
			url     : "../../../mensajeria/operacion/clases/GuiaClass.php",
			data    : QueryString,
			success : function(response){
				$("#tipo_envio_id").parent().html(response);
			}
		});
	}
}

function setDataFormWithResponse(){
	
	var tarifas_encomienda_id	=  document.getElementById("tarifas_encomienda_id").value;
	var forma 		= document.forms[0];
	var QueryString = "ACTIONCONTROLER=OnClickFind&tarifas_encomienda_id="+tarifas_encomienda_id;
	$.ajax({
		url        : "TarifasEncomiendaClass.php?rand="+Math.random(),
		data       : QueryString,
		beforeSend : function(){
			showDivLoading();
		},
		
		success    : function(resp){
			
			try{
				var data	= $.parseJSON(resp);
				if(isNaN(parseInt(data[0]['tarifas_encomienda_id']))){
					TarifasEncomiendaesOnReset();
					return false;
				}
				setFormWithJSON(forma,data);
				if($('#guardar'))		$('#guardar').attr("disabled","true");
				if($('#actualizar'))	$('#actualizar').attr("disabled","");
				if($('#borrar'))		$('#borrar').attr("disabled","");
				if($('#limpiar'))		$('#limpiar').attr("disabled","");
				if($('#duplicar'))		$('#duplicar').attr("disabled","");				
				
			}catch(e){
				alertJquery(resp,"Error :"+e);
			}
			removeDivLoading();
		}
	});
}

function TarifasEncomiendaesOnReset(){

	var form 		= document.forms[0];
	clearFind();
	$("#refresh_QUERYGRID_TarifasEncomiendas").click();
	Reset(form);
	
	if($('#guardar'))    $('#guardar').attr("disabled","");
	if($('#actualizar')) $('#actualizar').attr("disabled","true");
	if($('#borrar'))     $('#borrar').attr("disabled","true");
	if($('#limpiar'))    $('#limpiar').attr("disabled","");

}