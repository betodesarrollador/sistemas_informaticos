// JavaScript Document
//eventos asignados a los objetos
$(document).ready(function(){  	
  setDTA();	
});


function setDTA(){
	
  $("#numero_formulario,#manifiesto,#despacho").blur(function(){
																	 
      var valor       = $.trim(this.value);
	  
	  if(valor.length > 0){

		  var busqueda    = this.name;
		  var formulario  = this.form;
		  var QueryString = "ACTIONCONTROLER=setDTA&valor="+this.value+'&busqueda='+busqueda;
	
		  $.ajax({
			 url        : "CierreDTAClass.php?rand="+Math.random(),
			 data       : QueryString,
			 beforeSend : function(){
				showDivLoading();
			 },
			 success    : function(resp){
				 
				 try{
					 
					var dta        = $.parseJSON(resp); 
					var estado_dta = dta[0]['estado_dta'];
					
					setFormWithJSON(document.forms[0],resp,false,function(resp){
																		  
					   $("a").each(function(){
	
							var enlace = this;
	
							if($.trim(this.name).length > 0){
								
								var nameLink = $.trim(this.name.replace("_file",""));
								
								for(var llave in dta[0]){
																	
									if(llave == nameLink){
									
										enlace.href = dta[0][llave];
										
									}
									
								}
								
								
							}										
											
					   });																  
																		  
					});
					
					if(estado_dta == 'C'){
					  if($('#actualizar')) $('#actualizar').attr("disabled","true");
					  if($('#imprimir'))   $('#imprimir').attr("disabled","");
					  if($('#limpiar'))    $('#limpiar').attr("disabled","");						
					}else{
						if($('#actualizar')) $('#actualizar').attr("disabled","");
						if($('#imprimir'))   $('#imprimir').attr("disabled","true");
						if($('#limpiar'))    $('#limpiar').attr("disabled","");						
					  }
									
				 }catch(e){
					 
					  alertJquery(resp,"Error :"+e);
					  
					  Reset(formulario);
					  CierreDTAOnReset(formulario);
					  
					  if($('#actualizar')) $('#actualizar').attr("disabled","true");
					  if($('#imprimir'))   $('#imprimir').attr("disabled","true");
					  if($('#limpiar'))    $('#limpiar').attr("disabled","");	
					  
					 
				   }
				   
			   removeDivLoading();
				 
			 }
		  });	
	  
     }
										
  });
  
  
	
}

function setDataFormWithResponse(){
	
}

function CierreDTAOnUpdate(formulario,resp){
	
    if($.trim(resp) ==  'true'){
	  alertJquery("DTA cerrado Exitosamente","Cierre DTA");
	}else{
	    alertJquery(resp,"Error Actualizacion DTA");
	}
	
	Reset(formulario);
	CierreDTAOnReset(formulario);
	updateGrid();

}

function beforePrint(formulario,url,title,width,height){

	var dta_id = parseInt($("#dta_id").val());
	
	if(isNaN(dta_id)){
	  
	  alertJquery('Debe seleccionar un DTA para imprimir !!!','Impresion DTA');
	  return false;
	  
	}else{	  
	    return true;
	  }
	
}

function CierreDTAOnDelete(formulario,resp){
	Reset(formulario);	
	CierreDTAOnReset();
	clearFind();
	updateGrid();
	alertJquery(resp);
}

function CierreDTAOnReset(formulario){
	
	clearFind();
	
	$("#imagenesDTA").find("a").each(function(){
        this.href = 'javascript:void(0)';										  
    });
	
	$('#actualizar').attr("disabled","true");
	$('#imprimir').attr("disabled","true");
	$('#limpiar').attr("disabled","");
	
}

function updateGrid(){
	$("#refresh_QUERYGRID_Manifiestos").click();
}