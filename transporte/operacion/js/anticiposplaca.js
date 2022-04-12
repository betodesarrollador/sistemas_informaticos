$(document).ready(function(){
 
 $("#frameRegistroContable").attr("height","250px");
 
 if(document.getElementById('imprimir'))document.getElementById('imprimir').disabled = true; 
 document.getElementById('frameAnticiposPlaca').src        = "about:blank"; 
 document.getElementById('frameDevolucionesPlaca').src        = "about:blank";  
 document.getElementById('frameRegistroContable').src = "about:blank";  

 
  $("#tipo_anticipo").change(function(){
							
	 document.getElementById('frameAnticiposPlaca').src        = "about:blank"; 
	 document.getElementById('frameDevolucionesPlaca').src        = "about:blank";  
	 document.getElementById('frameRegistroContable').src = "about:blank"; 							
     $("#conductor,#conductor_id,#tenedor,#tenedor_id,#placa_id").val("");		 	   	 
							
									 
  });
  
	 document.getElementById('frameAnticiposPlaca').src        = "about:blank"; 
	 document.getElementById('frameDevolucionesPlaca').src        = "about:blank";  
	 document.getElementById('frameRegistroContable').src = "about:blank"; 							  
						   
});

function separaNombre(conductor_id){
		
	var QueryString = "ACTIONCONTROLER=setDataConductor&conductor_id="+conductor_id;
	
	$.ajax({
	  url        : "AnticiposPlacaClass.php?random="+Math.random(),
	  data       : QueryString,
	  beforeSend : function(){
		showDivLoading();
      },
	  success    : function(resp){		  
	  
            var data                 = $.parseJSON(resp);
			var vencimiento_licencia = data[0]['vencimiento_licencia_cond'];
			var licencia_vencio      = data[0]['licencia_vencio'];
			var conductor            = data[0]['nombre'];
					
            setFormWithJSON(document.forms[0],resp,true,function(){
			
              removeDivLoading();			
																 
			  if(licencia_vencio == 'SI'){
				   
		       alertJquery("<div align='center'>La licencia del conductor : <b>"+conductor+"</b> <br> tiene fecha de vencimiento <b>"+vencimiento_licencia+"</b> en el sistema, el conductor fue bloqueado.<br><br> <b>no se permite asignar el manifiesto al conductor!!!</b><br><br>Contacte el area encargada de autorizar a los conductores por favor.</div>","Validacion Vencimiento Licencia");
				   
			  }
			  
			  
																 
            });
			
	       
	  }
	  
	});
	
	
}

function separaNombreTenedor(tenedor_id){
		
	var QueryString = "ACTIONCONTROLER=setDataTenedor&tenedor_id="+tenedor_id;
	
	$.ajax({
	  url        : "AnticiposPlacaClass.php?random="+Math.random(),
	  data       : QueryString,
	  beforeSend : function(){
		showDivLoading();
      },
	  success    : function(resp){		  
	  
            var data                 = $.parseJSON(resp);
					
            setFormWithJSON(document.forms[0],resp,true,function(){
			
              removeDivLoading();			
																 
            });
	  }
	  
	});
	
	
}

function setDataVehiculo(placa_id){
		  
  if(parseInt(placa_id) > 0){
	  
	  var QueryString = "ACTIONCONTROLER=setDataVehiculo&placa_id="+placa_id;
	  
	  $.ajax({
	    url        : "AnticiposPlacaClass.php?rand="+Math.random(),
		data       : QueryString,
		beforeSend : function(){
		  showDivLoading()
		},
		success    : function(resp){					
		
            var data                   = $.parseJSON(resp);
			var vencimiento_licencia   = data[0]['vencimiento_licencia_cond'];
			var licencia_vencio        = data[0]['licencia_vencio'];			
	        var soat_vencio            = data[0]['soat_vencio'];
	        var tecnicomecanica_vencio = data[0]['tecnicomecanica_vencio'];						
			var conductor              = data[0]['nombre'];	
			var reportado_ministerio   = data[0]['reportado_ministerio'];				
		
		    removeDivLoading();					
			
		   if(soat_vencio == 'SI' || tecnicomecanica_vencio == 'SI'){
			   
			   if(soat_vencio == 'SI' && tecnicomecanica_vencio == 'SI'){
				   
				alertJquery("<div align='center'>El <b>SOAT</b> y la revision <b>TECNICOMECANICA</b> del vehiculo se encuentran vencidas en el sistema!!!<br>no se permite asignar este vehiculo a ningun manifiesto, el vehiculo fue bloqueado.<br><br>Contacte al area encargada de autorizar vehiculos.</div>","Validacion Vencimiento SOAT - TECNICOMECANICA");
									   
			   }else if(soat_vencio == 'SI'){
				   
					alertJquery("<div align='center'>El <b>SOAT</b> del vehiculo se encuentra vencido en el sistema!!!<br>no se permite asignar este vehiculo a ningun manifiesto, el vehiculo fue bloqueado.<br><br>Contacte al area encargada de autorizar vehiculos.</div>","Validacion Vencimiento SOAT");
													   
				 }else if(tecnicomecanica_vencio == 'SI'){
					  alertJquery("<div align='center'>la revision <b>TECNICOMECANICA</b> del vehiculo se encuentra vencida en el sistema!!!<br>no se permite asignar este vehiculo a ningun manifiesto, el vehiculo fue bloqueado.<br><br>Contacte al area encargada de autorizar vehiculos.</div>","Validacion Vencimiento TECNICOMECANICA");						 
				 }
			   
			   return false;
			   
		   }else{
			   
				setFormWithJSON(document.forms[0],resp,true,function(){
					   
				   if(licencia_vencio == 'SI'){
					   
					   alertJquery("<div align='center'>La licencia del conductor asignado al vehiculo : <b>"+conductor+"</b> <br> tiene fecha de vencimiento <b>"+vencimiento_licencia+"</b> en el sistema,el conductor fue bloqueado.<br><br> <b>no se permite asignar el manifiesto al conductor!!!</b><br><br>Contacte el area encargada de autorizar a los conductores por favor.</div>","Validacion Vencimiento Licencia");
					   
				   }
				  
				});	
			}			
		  }
      });
  }
}
function recargar_anticipos(placa_id){
	if(!isNaN(placa_id)){
	 document.getElementById('frameAnticiposPlaca').src = "DetalleAnticiposPlacaClass.php?placa_id="+placa_id; 
	 document.getElementById('frameDevolucionesPlaca').src = "DetalleDevolucionPlacaClass.php?placa_id="+placa_id; 
	}
}
function getAnticiposPlaca(placa_id){
	      
   if(!isNaN(placa_id)){
      
	   var QueryString = "ACTIONCONTROLER=validaAnticiposPlaca&placa_id="+placa_id;								
	   
	   $.ajax({
		 url        : "AnticiposPlacaClass.php?rand="+Math.random(),
		 data       : QueryString,
		 beforeSend : function(){
			 showDivLoading();
		 },
		 success     : function(resp){
			 
			 removeDivLoading();
			 
			 if($.trim(resp) == 'true'){			 
				document.getElementById('frameAnticiposPlaca').src = "DetalleAnticiposPlacaClass.php?placa_id="+placa_id; 
				document.getElementById('frameDevolucionesPlaca').src = "DetalleDevolucionPlacaClass.php?placa_id="+placa_id; 
				document.getElementById('frameRegistroContable').src = "about:blank"; 
				if(document.getElementById('imprimir'))document.getElementById('imprimir').disabled = true;
				setDataVehiculo(placa_id);
			 }else{
				 alertJquery(resp,"Validacion");
			  }
			 
		 }
		 
	   });
   
   }
								
 
}
 

function beforePrint(formulario,url,title,width,height){

   var encabezado_registro_id = $("#encabezado_registro_id").val() * 1;
   
   if(encabezado_registro_id > 0){
	 return true;
   }else{
	   alertJquery("No se ha generado un registro contable para imprimir!!");
	   return false;
	}

}


function AnticiposPlacaOnReset(formulario){
	
	Reset(formulario);
	if(document.getElementById('imprimir'))document.getElementById('imprimir').disabled = true; 
	document.getElementById('frameAnticiposPlaca').src        = "about:blank"; 
	document.getElementById('frameDevolucionesPlaca').src        = "about:blank"; 
	document.getElementById('frameRegistroContable').src = "about:blank"; 		
	
}