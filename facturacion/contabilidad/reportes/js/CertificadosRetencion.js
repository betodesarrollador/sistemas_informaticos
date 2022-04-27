// JavaScript Document
function setDataFormWithResponse(){
	
RequiredRemove();

FindRow([{campos:"certificados_tercero_id",valores:$('#certificados_tercero_id').val()}],document.forms[0],'CertificadosRetencionClass.php',null, 
  function(resp){
	  
	try{
		
	var data          = $.parseJSON(resp);  
	var certificados_tercero_id = $('#certificados_tercero_id').val(); 
		
	document.getElementById('frameReporte').src = 'CertificadosRetencionClass.php?ACTIONCONTROLER=onclickGenerarCertificado1&certificados_tercero_id='+certificados_tercero_id;
  
    if($('#guardar'))    $('#guardar').attr("disabled","true");
    if($('#actualizar')) $('#actualizar').attr("disabled","");
    if($('#borrar'))     $('#borrar').attr("disabled","");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");
	
	}catch(e){
		 alertJquery(resp,"Error :"+e);
	  }	
  });
}

function getCuentasCertificado(valor){

 var url         = 'CertificadosRetencionClass.php?rand='+Math.random();
 var QueryString = 'ACTIONCONTROLER=getCuentasReporte&certificados_id='+valor; 
 
 $.ajax({
	url  : url,
	data : QueryString, 
	beforeSend: function(){
		showDivLoading();
	},
	success : function(responseText){

       try{
		
		if($.trim(responseText) == 'null'){			
		  alert('No existen cuentas paramtrizadas para el reporte!!');
		}else{
						var option = $.parseJSON(responseText);
			   
			$("#puc_id option").each(function(index, element) {
			  
			  if(this.value != 'NULL'){
				  $(this).remove();
			  }
				  
			});
			
			for(var i = 0; i < option.length; i++){
			 $("#puc_id").append("<option value='"+option[i]['value']+"'>"+option[i]['text']+"</option>");	
			}
		  }
		   
	   }catch(e){
		   alert("Error :"+responseText);
		}

	   removeDivLoading();
	}
 });

}

function onclickGenerarCertificado(){
	
	if(ValidaRequeridos(document.forms[0])){
		
		var QueryString = FormSerialize(document.forms[0]);
		
		document.getElementById('frameReporte').src = 'CertificadosRetencionClass.php?ACTIONCONTROLER=onclickGenerarCertificado&'+QueryString;
		
		
	}
	
}

$(document).ready(function(){
						   
   	///INICIO VALIDACION FECHAS DE REPORTE
	
  	$('#desde').change(function(){

	  	var fechah = $('#hasta').val();
	  	var fechad = $('#desde').val();
	  	var today = new Date();

	  	if ((Date.parse(fechah) < Date.parse(fechad)) || (Date.parse(fechad)>today)) {
	  		alertJquery('Esta fecha no puede ser mayor a la fecha final o mayor a hoy.');
	  		return this.value = $('#hasta').val();
	  	};
	});

	$('#hasta').change(function(){

	  	var fechah = $('#hasta').val();
	  	var fechad = $('#desde').val();
	  	var today = new Date();

	  	if ((Date.parse(fechah) < Date.parse(fechad)) || (Date.parse(fechah)>today)) {
	  		alertJquery('Esta fecha no puede ser menor a la fecha de inicio o mayor a hoy.');
	  		return this.value = $('#desde').val();
	  	};
	});
	
	///FIN VALIDACION FECHAS DE REPORTE						   
  
  $("#opciones_tercero").change(function(){
    if(this.value == 'T'){
	 $("#tercero_hidden").removeClass("obligatorio");
	 $("#tercero").removeClass("requerido");	 	 
	 $("#tercero").attr("disabled","true");	 	 	 
	 $("#tercero,#tercero_hidden").val("");	 	 	 	 
    }else if(this.value == 'U'){
		 $("#tercero_hidden").addClass("obligatorio");
	     $("#tercero").attr("disabled","");	 	 	 		 
      }						
  });  
  
});