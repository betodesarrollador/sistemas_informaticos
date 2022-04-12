// JavaScript Document
function setDataFormWithResponse(){
	
	var parametros  = new Array({campos:"tercero_id",valores:$('#tercero_id').val()});
	var forma       = document.forms[0];
	var controlador = 'ClientesClass.php';
	
	FindRow(parametros,forma,controlador,null,function(resp){
  
	 	var clienteId = $('#cliente_id').val();
				
     	if ($.trim(clienteId)>0){
			
			var url = "ContactosClass.php?cliente_id="+clienteId;
	 		$("#Contactos").attr("src",url);
	    }
		
		if($('#actualizar')) $('#guardar').attr("disabled","true");
		if($('#actualizar')) $('#actualizar').attr("disabled","");
		if($('#borrar'))     $('#borrar').attr("disabled","");
		if($('#limpiar'))    $('#limpiar').attr("disabled","");
				   
	});
}

function ClientesOnSave(formulario,resp){
    $("#refresh_QUERYGRID_Clientes").click();
	  	  
	  try{ 
	    var dataJSON = $.parseJSON(resp) 
	  }catch(e){
		 }
		
      if($.isArray(dataJSON)){
		  
		var tercero_id = dataJSON[0]['tercero_id'];
	    var cliente_id = dataJSON[0]['cliente_id'];
		
		$("#tercero_id").val(tercero_id);
		$("#cliente_id").val(cliente_id);
		
	    var url = "ContactosClass.php?cliente_id="+cliente_id;
	
	    $("#Contactos").attr("src",url);
		
	    alertJquery("Guardado exitosamente");		  
		
		if($('#actualizar')) $('#guardar').attr("disabled","true");
		if($('#actualizar')) $('#actualizar').attr("disabled","");
		if($('#borrar'))     $('#borrar').attr("disabled","");
		if($('#limpiar'))    $('#limpiar').attr("disabled","");		 	 		
		  
	  }else{
		  
		   alertJquery("Ocurrio una inconsistencia : "+resp);
		   
		   if($('#actualizar')) $('#guardar').attr("disabled","");
		   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   		   if($('#borrar'))     $('#borrar').attr("disabled","true");
		   if($('#limpiar'))    $('#limpiar').attr("disabled","");		 	 		   
		   
		 }
		 
}
function ClientesOnUpdate(formulario,resp){
	
    $("#refresh_QUERYGRID_Clientes").click();
	  	  
      if(resp == 'true' || resp == true || !isNaN(resp)){
	    var clienteId = isNaN(resp) ? $('#cliente_id').val() : resp;
	    var url       = "ContactosClass.php?cliente_id="+clienteId;
	
	    $("#Contactos").attr("src",url);
		
	    alertJquery("Guardado exitosamente");		  
		
		if($('#actualizar')) $('#guardar').attr("disabled","true");
		if($('#actualizar')) $('#actualizar').attr("disabled","");
		if($('#borrar'))     $('#borrar').attr("disabled","");
		if($('#limpiar'))    $('#limpiar').attr("disabled","");		 		
		  
	  }else {
		  
		   alertJquery("Ocurrio una inconsistencia : "+resp);
		   
   		   if($('#actualizar')) $('#guardar').attr("disabled","");
		   if($('#actualizar')) $('#actualizar').attr("disabled","true");
		   if($('#borrar'))     $('#borrar').attr("disabled","true");
		   if($('#limpiar'))    $('#limpiar').attr("disabled","");
		   
		 }
		 
	
}
function ClientesOnDelete(formulario,resp){
   Reset(document.getElementById('ClientesForm'));
   $("#refresh_QUERYGRID_Clientes").click();
   clearFind();
   
   $("#Contactos").attr("src","../../../framework/tpl/blank.html");   
   
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","true");
   
   alertJquery($.trim(resp));  
}
function ClientesOnClear(){
	
 	$("#Contactos").attr("src","../../../framework/tpl/blank.html");
	clearFind();
  
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");
	
}

$(document).ready(function(){
  
  $("#tipo_identificacion_id").change(function(){
    calculaDigitoTercero();
  });
  
  $("#numero_identificacion").blur(function(){
     var tercero_id            = $("#tercero_id").val();
     var numero_identificacion = this.value;
     var params                = new Array({campos:"numero_identificacion",valores:numero_identificacion});
	 
	 if(!tercero_id.length > 0){
	 
        validaRegistro(this,params,"ClientesClass.php",null,function(resp){    
																  																  
        if(parseInt(resp) != 0 ){
		   
           var params     = new Array({campos:"numero_identificacion",valores:numero_identificacion});
           var formulario = document.forms[0];
           var url        = 'ClientesClass.php';
           FindRow(params,formulario,url,null,function(resp){
													 
           clearFind();		
		   
   	 	   var clienteId = $('#cliente_id').val();
		   				
     	   if ($.trim(clienteId)>0){
			var url = "ContactosClass.php?cliente_id="+clienteId;
	 		$("#Contactos").attr("src",url);
	       }
		 
	  	   $('#guardar').attr("disabled","true");
           $('#actualizar').attr("disabled","");
           $('#borrar').attr("disabled","");
           $('#limpiar').attr("disabled","");	
													 
         });
		 
	   }else{	   		  
          calculaDigitoTercero();				  
		  $('#guardar').attr("disabled","");
          $('#actualizar').attr("disabled","true");
          $('#borrar').attr("disabled","true");
          $('#limpiar').attr("disabled","");
		  }
		  
       });
		
	 }
  
  });
  
  $("#guardar,#actualizar").click(function(){
	  
	  var formulario = document.getElementById('ClientesForm');
	  
	  if(ValidaRequeridos(formulario) && ValidaOtrosTercero(formulario)){ 
	    if(this.id == 'guardar'){
         Send(formulario,'onclickSave',null,ClientesOnSave)
		}else{
            Send(formulario,'onclickUpdate',null,ClientesOnUpdate)
		  }
	  }
	  	  
  });
  
  $("#Contactos").attr("src","../../../framework/tpl/blank.html");
  
  $("#saveContactos").click(function(){								
    window.frames[0].saveContactos();
  });
  
  
  $("#deleteContactos").click(function(){	
    window.frames[0].deleteContactos();
  });
  
});