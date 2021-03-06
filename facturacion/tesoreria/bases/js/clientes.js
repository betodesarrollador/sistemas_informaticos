// JavaScript Document
function setDataFormWithResponse(){
	auto();
    var tercero_id = $('#tercero_id').val();
	
    RequiredRemove();

    var parametros  = new Array({campos:"tercero_id",valores:$('#tercero_id').val()});
	var forma       = document.forms[0];
	var controlador = 'ClientesClass.php';

	FindRow(parametros,forma,controlador,null,function(resp){

	  var data = $.parseJSON(resp);
	  ocultaFilaNombresRazon(data[0]['tipo_persona_id']);
      if($('#guardar'))    $('#guardar').attr("disabled","true");
      if($('#actualizar')) $('#actualizar').attr("disabled","");
	  if($('#imprimir')) $('#imprimir').attr("disabled","");
      if($('#borrar'))     $('#borrar').attr("disabled","");
      if($('#limpiar'))    $('#limpiar').attr("disabled","");	  
	  
	  var url = "SocioClass.php?tercero_id="+tercero_id+"&rand="+Math.random();
	  $("#socios").attr("src",url);						  	

	  var url = "OperativaClass.php?tercero_id="+tercero_id+"&rand="+Math.random();
	  $("#operativa").attr("src",url);						  	
	  $("#legal,#tributaria,#operativas,#financiera").css("display","");
      $("#banco_id,#numcuenta_cliente_factura,#tipo_cta_id,#regimen_id,#recursos_cliente_factura").addClass("obligatorio");
	  
    });
}

function LlenarFormNumId(){
	
	RequiredRemove();
	
	FindRow([{campos:"tercero_id",valores:$('#tercero_id').val()}],document.forms[0],'ClientesClass.php');
	
	if($('#guardar'))    $('#guardar').attr("disabled","true");
	if($('#actualizar')) $('#actualizar').attr("disabled","");
	if($('#imprimir')) $('#imprimir').attr("disabled","");
	if($('#borrar'))     $('#borrar').attr("disabled","");
	if($('#limpiar'))    $('#limpiar').attr("disabled","");
}

function ClienteOnSave(formulario,resp){
	
	$("#refresh_QUERYGRID_terceros").click();
	
	try{ 
		var dataJSON = $.parseJSON(resp) 
	}catch(e){
	    alertJquery(e);
	  }
	
	if($.isArray(dataJSON)){
		
		var tercero_id = dataJSON[0]['tercero_id'];
		var cliente_id = dataJSON[0]['cliente_id'];
		var remitente_destinatario_id = dataJSON[0]['remitente_destinatario_id'];
		
		$("#tercero_id").val(tercero_id);
		$("#cliente_id").val(cliente_id);
		$("#remitente_destinatario_id").val(remitente_destinatario_id);
		
		$("#legal,#tributaria,#operativas,#financiera").css("display","");
		$("#banco_id,#numcuenta_cliente_factura,#tipo_cta_id,#regimen_id,#recursos_cliente_factura").addClass("obligatorio");		
		var url = "SocioClass.php?tercero_id="+tercero_id+"&rand="+Math.random();
		$("#socios").attr("src",url);						  	
	
		var url = "OperativaClass.php?tercero_id="+tercero_id+"&rand="+Math.random();
		$("#operativa").attr("src",url);						  	

		alertJquery("Guardado exitosamente");		  
		
	   if($('#guardar'))    $('#guardar').attr("disabled","true");
	   if($('#actualizar')) $('#actualizar').attr("disabled","");
       if($('#imprimir'))   $('#imprimir').attr("disabled","");
	   if($('#borrar'))     $('#borrar').attr("disabled","");
	   if($('#limpiar'))    $('#limpiar').attr("disabled","");
		
	}else{
		
		alertJquery("Ocurrio una inconsistencia : "+resp);
		
		if($('#guardar'))    $('#guardar').attr("disabled","");
		if($('#actualizar')) $('#actualizar').attr("disabled","true");
		if($('#borrar'))     $('#borrar').attr("disabled","true");
		if($('#imprimir'))   $('#imprimir').attr("disabled","true");
		if($('#limpiar'))    $('#limpiar').attr("disabled","");		 	 		   
	
	}	
}

function ClienteOnUpdate(formulario,resp){
	
	$("#refresh_QUERYGRID_terceros").click();
	
	if(resp == 'true' || resp == true || !isNaN(resp)){
		
		
		var clienteId = isNaN(resp) ? $('#cliente_id').val() : resp;
		$('#cliente_id').val(clienteId);
		
		$("#legal,#tributaria,#operativas,#financiera").css("display","");
		$("#banco_id,#numcuenta_cliente_factura,#tipo_cta_id,#regimen_id,#recursos_cliente_factura").addClass("obligatorio");		
		
		var tercero_id = $('#tercero_id').val();
		var url = "SocioClass.php?tercero_id="+tercero_id+"&rand="+Math.random();
		$("#socios").attr("src",url);						  	
	
		var url = "OperativaClass.php?tercero_id="+tercero_id+"&rand="+Math.random();
		$("#operativa").attr("src",url);						  	
		
		alertJquery("Actualizado exitosamente");		  
		
		if($('#guardar'))    $('#guardar').attr("disabled","true");
		if($('#actualizar')) $('#actualizar').attr("disabled","");
		if($('#imprimir'))   $('#imprimir').attr("disabled","");
		if($('#borrar'))     $('#borrar').attr("disabled","");
		if($('#limpiar'))    $('#limpiar').attr("disabled","");		 		
	
	}else {
		
		alertJquery("Ocurrio una inconsistencia : "+resp);
		
		if($('#guardar'))    $('#guardar').attr("disabled","");
		if($('#actualizar')) $('#actualizar').attr("disabled","true");
		if($('#borrar'))     $('#borrar').attr("disabled","true");
		if($('#imprimir'))   $('#imprimir').attr("disabled","true");
		if($('#limpiar'))    $('#limpiar').attr("disabled","");
		
	}	
}

function ClienteonDelete(formulario,resp){
	
	$("#socios").attr("src","/envipack/framework/tpl/blank.html");
	$("#operativa").attr("src","/envipack/framework/tpl/blank.html");	
	$("#legal,#tributaria,#operativas,#financiera").css("display","none");
	$("#banco_id,#numcuenta_cliente_factura,#tipo_cta_id,#regimen_id,#recursos_cliente_factura").removeClass("obligatorio");

   $("#refresh_QUERYGRID_terceros").click();
   clearFind();
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#imprimir'))   $('#imprimir').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
   $('#estado').val('B');
	
   alertJquery(resp,"Clientes");
   
}

function ClienteOnReset(formulario){

	$("#socios").attr("src","/envipack/framework/tpl/blank.html");
	$("#operativa").attr("src","/envipack/framework/tpl/blank.html");	
	$("#legal,#tributaria,#operativas,#financiera").css("display","none");
	$("#banco_id,#numcuenta_cliente_factura,#tipo_cta_id,#regimen_id,#recursos_cliente_factura").removeClass("obligatorio");	
    clearFind();	
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
	if($('#imprimir'))   $('#imprimir').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");	
	$('#estado').val('B');
}

function beforePrint(formulario,url,title,width,height){

	var cliente_id = parseInt($("#cliente_id").val());
	
	if(isNaN(cliente_id)){
	  
	  alertJquery('Debe seleccionar un Cliente a imprimir !!!','Impresion Cliente');
	  return false;
	  
	}else{	  
	    return true;
	  }
	
}

function auto(){
	
	if(document.getElementById("auto_si").checked==true ){
		document.getElementById("regimen_id").options[3].disabled = false;	
		document.getElementById("regimen_id").options[4].disabled = false;	
		//document.getElementById('regimen_id').disabled=true;  
	}
	else if(document.getElementById("auto_no").checked==true){
		document.getElementById("regimen_id").options[3].disabled = true;	
		document.getElementById("regimen_id").options[4].disabled = true;	
	}
											   
}

$(document).ready(function(){
	auto();
  $("#legal,#tributaria,#operativas,#financiera").css("display","none");
						   
  $("#saveDetallesoc").click(function(){										
    window.frames[0].saveDetalles();	
  });  


  $("#deleteDetallesoc").click(function(){										
    window.frames[0].deleteDetalles();
  });  

  $("#saveDetalleope").click(function(){										
    window.frames[1].saveDetalles();	
  });  


  $("#deleteDetalleope").click(function(){										
    window.frames[1].deleteDetalles();
  });  

  $("#tipo_identificacion_id").change(function(){
    calculaDigitoTercero();
  });
  
  $("#numero_identificacion").blur(function(){

     var tercero_id            = $("#tercero_id").val();
	 var cliente_id            = $("#cliente_id").val();
     var numero_identificacion = this.value;
     var params                = new Array({campos:"numero_identificacion",valores:numero_identificacion});

	 if(!tercero_id.length > 0){
	 
       validaRegistro(this,params,"ClientesClass.php",null,function(resp){    
																  																  
         if(parseInt(resp) != 0 ){
           var params     = new Array({campos:"numero_identificacion",valores:numero_identificacion});
           var formulario = document.forms[0];
           var url        = 'ClientesClass.php';

           FindRow(params,formulario,url,null,function(resp){

		   var data = $.parseJSON(resp);
		   ocultaFilaNombresRazon(data[0]['tipo_persona_id']);	     

           clearFind();		 
		 
			$('#guardar').attr("disabled","true");
			$('#actualizar').attr("disabled","");
			$('#borrar').attr("disabled","");
			$('#limpiar').attr("disabled","");	
			var tercero_id            = $("#tercero_id").val();
			var cliente_id            = $("#cliente_id").val();
			
			if(cliente_id>0 && tercero_id>0){
			 
			  var url = "SocioClass.php?tercero_id="+tercero_id+"&rand="+Math.random();
			  $("#socios").attr("src",url);						  	
			
			  var url = "OperativaClass.php?tercero_id="+tercero_id+"&rand="+Math.random();
			  $("#operativa").attr("src",url);						  	
			  $("#legal,#tributaria,#operativas,#financiera").css("display","");
			  $("#banco_id,#numcuenta_cliente_factura,#tipo_cta_id,#regimen_id,#recursos_cliente_factura").addClass("obligatorio");
			}else if(tercero_id>0){
				$('#guardar').attr("disabled","");
				$('#actualizar').attr("disabled","true");
				$('#borrar').attr("disabled","true");
				$('#limpiar').attr("disabled","");
			}
													 
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
         Send(formulario,'onclickSave',null,ClienteOnSave)
		}else{
            Send(formulario,'onclickUpdate',null,ClienteOnUpdate)
		  }
	  }
	  	  
  });

  $("#tipo_persona_id").change(function(){
    ocultaFilaNombresRazon(this.value);
    
  });

});
	
