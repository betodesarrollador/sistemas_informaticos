// JavaScript Document
function setDataFormWithResponse(){

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
	  
	  var url = "ComercialClass.php?tercero_id="+tercero_id+"&rand="+Math.random();
		$("#comerciales").attr("src",url);	

	  var url = "OperativaClass.php?tercero_id="+tercero_id+"&rand="+Math.random();
	  $("#operativa").attr("src",url);						  	

	  var url = "TarifasClass.php?tercero_id="+tercero_id+"&rand="+Math.random();
	  $("#tarifa").attr("src",url);						  	

	  $("#legal,#tributaria,#operativas,#financiera,#tarifas,#comercial").css("display","");
      $("#regimen_id").addClass("obligatorio");
         $("#comercial_hidden").addClass("obligatorio");
         $("#comercial").addClass("obligatorio");
	  
    });


}


function all_oficce(){
	if(document.getElementById('all_oficina').checked==true){
		$('#all_oficina').val('SI');

		var objSelect = document.getElementById('oficina_id'); 
		var numOp     = objSelect.options.length -1;
	   
	   
	   for(var i = numOp; i > 0; i-- ){
		   
		  if(objSelect.options[i].value != 'NULL'){
			 objSelect.options[i].selected = true;
		  }else{
			   objSelect.options[i].selected = false;
			} 		   
	   }

	}else{
		$('#all_oficina').val('NO');
		var objSelect = document.getElementById('oficina_id'); 
		var numOp     = objSelect.options.length -1;

		 
	     for(var i = numOp; i > 0; i-- ){
		   
		   if(objSelect.options[i].value != 'NULL'){
			 objSelect.options[i].selected = false;
		   }else{
			   objSelect.options[i].selected = true;
			 } 		   
	     } 		
	}	
}


function addNewRowComercial(){
	
  $("input[name=addComercial]").click(function(){
		
		var row     = this.parentNode.parentNode;	
		var Table   = row.parentNode;
		var posRow  = parseInt(row.rowIndex) + (1 * 1);
		var newRow  = Table.insertRow(posRow);
			newRow.className = 'rowAnticipos';
	
		$(newRow).html($(row).html()); 
	  
		$(newRow).find("input[type=text]:first").focus();
		addNewRowComercial();	 
		
		$(this).replaceWith("<input type='button' name='removeComercial' id='removeComercial' value='  Remover comercial  ' />");	
		removeComercial();
													 
													});
}

function removeComercial(){
	
  $("input[name=removeComercial]").click(function(){

	var row  = this.parentNode.parentNode;

    $(row).remove();
	
	addNewRowComercial();
	
	

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
		var dataJSON = $.parseJSON(resp);
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
		
		$("#legal,#tributaria,#operativas,#financiera,#tarifas,#comercial").css("display","");
		$("#regimen_id").addClass("obligatorio");		
         $("#comercial_hidden").addClass("obligatorio");
         $("#comercial").addClass("obligatorio");
		
		var url = "SocioClass.php?tercero_id="+tercero_id+"&rand="+Math.random();
		$("#socios").attr("src",url);	
		
		var url = "ComercialClass.php?tercero_id="+tercero_id+"&rand="+Math.random();
		$("#comerciales").attr("src",url);	
	
		var url = "OperativaClass.php?tercero_id="+tercero_id+"&rand="+Math.random();
		$("#operativa").attr("src",url);						  	

	  var url = "TarifasClass.php?tercero_id="+tercero_id+"&rand="+Math.random();
	  $("#tarifa").attr("src",url);						  	

       sendRemitenteDestinatarioMintransporte(resp,formulario);
		
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

var formSubmitted = false;

function sendRemitenteDestinatarioMintransporte(resp,formulario){
	
	if($.trim(resp) == 'true'){		
	
	 if(!formSubmitted){
		 
	  var QueryString = FormSerialize(formulario)+"&ACTIONCONTROLER=sendRemitenteDestinatarioMintransporte";
	  	
	  $.ajax({
		url        : "RemitenteClass.php?rand="+Math.random(),	 
		data       : QueryString,
		beforeSend : function(){
			window.scrollTo(0,0);
			showDivMessage("Reportando al Ministerio de Transporte<br>Por Favor Espere..","/roa/framework/media/images/general/cable_data_transfer_md_wht.gif");
			formSubmitted = true;
		},
		success    : function(resp){			
					
		   removeDivMessage();			
		   showDivMessage(resp,"/roa/framework/media/images/general/cable_data_transfer_md_wht.gif");			
		   formSubmitted = false;

		   Reset(formulario);
		   clearFind();
		   $("#tipo").val("R");  
		   $("#estado").val("D");     
		   $("#refresh_QUERYGRID_remitente").click();
		   
		   if($('#guardar'))    $('#guardar').attr("disabled","");
		   if($('#actualizar')) $('#actualizar').attr("disabled","true");
		   if($('#borrar'))     $('#borrar').attr("disabled","true");
		   if($('#limpiar'))    $('#limpiar').attr("disabled","");
						
		}
		
	  });
	
	 }
	
	}else{
		alertJquery(resp);
	 }
	   

	
}

function ClienteOnUpdate(formulario,resp){
	
	$("#refresh_QUERYGRID_terceros").click();
	
	if(resp == 'true' || resp === true || !isNaN(resp)){
		
		
		var clienteId = isNaN(resp) ? $('#cliente_id').val() : resp;
		$('#cliente_id').val(clienteId);
		
		$("#legal,#tributaria,#operativas,#financiera,#tarifas,#comercial").css("display","");
		$("#banco_id,#numcuenta_cliente_factura,#tipo_cta_id,#regimen_id,#comercial_hidden,#comercial,#recursos_cliente_factura").addClass("obligatorio");		
		
		var tercero_id = $('#tercero_id').val();
		var url = "SocioClass.php?tercero_id="+tercero_id+"&rand="+Math.random();
		$("#socios").attr("src",url);						  	
	
		var url = "ComercialClass.php?tercero_id="+tercero_id+"&rand="+Math.random();
		$("#comerciales").attr("src",url);	
		
		var url = "OperativaClass.php?tercero_id="+tercero_id+"&rand="+Math.random();
		$("#operativa").attr("src",url);						  	

	  var url = "TarifasClass.php?tercero_id="+tercero_id+"&rand="+Math.random();
	  $("#tarifa").attr("src",url);						  	

        sendRemitenteDestinatarioMintransporte(resp,formulario)
		
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
	
	$("#socios").attr("src","/roa/framework/tpl/blank.html");
	$("#operativa").attr("src","/roa/framework/tpl/blank.html");	
	$("#legal,#tributaria,#operativas,#financiera,#proyecto,#tarifas,#comercial").css("display","none");
	$("#banco_id,#numcuenta_cliente_factura,#tipo_cta_id,#regimen_id,#comercial_hidden,#comercial,#recursos_cliente_factura").removeClass("obligatorio");

   $("#refresh_QUERYGRID_terceros").click();
   clearFind();
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#imprimir'))   $('#imprimir').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
   $('#estado').val('B');
   $('#contado').val('1');
   $('#cuenta').val('1');
   $('#contra').val('1');
	
   alertJquery(resp,"Clientes");
   
}

function ClienteOnReset(formulario){

	$("#socios").attr("src","/roa/framework/tpl/blank.html");
	$("#operativa").attr("src","/roa/framework/tpl/blank.html");	
	$("#legal,#tributaria,#operativas,#financiera,#proyecto,#tarifas,#comercial").css("display","none");
	$("#banco_id,#numcuenta_cliente_factura,#tipo_cta_id,#regimen_id,#comercial_hidden,#comercial,#recursos_cliente_factura").removeClass("obligatorio");	
    clearFind();	
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
	if($('#imprimir'))   $('#imprimir').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");	
	$('#estado').val('B');
	$('#contado').val('1');
    $('#cuenta').val('1');
    $('#contra').val('1');
	
	
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

$(document).ready(function(){

  $("#legal,#tributaria,#operativas,#financiera,#proyecto,#tarifas,#comercial,#tarifasm").css("display","none");
						   
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
  $("#saveDetallecom").click(function(){										
    window.frames[2].saveDetalles();	
  });  


  $("#deleteDetallecom").click(function(){										
    window.frames[2].deleteDetalles();
  });  

  $("#tipo_identificacion_id").change(function(){
    calculaDigitoTercero();
  });
  
   addNewRowComercial();
  
  $("#numero_identificacion").blur(function(){

     var tercero_id            = $("#tercero_id").val();
	 var cliente_id            = $("#cliente_id").val();
     var numero_identificacion = this.value;
     var params                = new Array({campos:"numero_identificacion",valores:numero_identificacion});

	 if(!tercero_id.length > 0){
	 
       validaRegistro(this,params,"ClientesClass.php",null,function(resp){    
																  																  
         if(parseInt(resp) !== 0 ){
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
			  
			   var url = "ComercialClass.php?tercero_id="+tercero_id+"&rand="+Math.random();
			  $("#comerciales").attr("src",url);	
			
			  var url = "OperativaClass.php?tercero_id="+tercero_id+"&rand="+Math.random();
			  $("#operativa").attr("src",url);
			  
			  var url = "ComercialClass.php?tercero_id="+tercero_id+"&rand="+Math.random();
		$("#comerciales").attr("src",url);	
			  
			  var url = "TarifasClass.php?tercero_id="+tercero_id+"&rand="+Math.random();
			  $("#tarifa").attr("src",url);						  	
			  
			  $("#legal,#tributaria,#operativas,#financiera,#tarifas,#comercial").css("display","");
			  $("#banco_id,#numcuenta_cliente_factura,#tipo_cta_id,#regimen_id,#comercial_hidden,#comercial,#recursos_cliente_factura").addClass("obligatorio");
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
  
 $("#actualizar").click(function(){
	  
	  
	  
	  var formulario = document.getElementById('ClientesForm');
	  
	  if(ValidaRequeridos(formulario) && ValidaOtrosTercero(formulario)){ 
	    
            Send(formulario,'onclickUpdate',null,ClienteOnUpdate);
		  
	  }
	  	  
  });

  $("#tipo_persona_id").change(function(){
    ocultaFilaNombresRazon(this.value);
    
  });

});

function buscarClinton(){
	
	var documento = $("#numero_identificacion").val();
	var formulario = document.getElementById('ClientesForm');
	var QueryString = "ACTIONCONTROLER=validarClinton&documento="+documento;
	
		$.ajax({
			url:"ClientesClass.php?rand="+Math.random(),
			data:QueryString,
			beforeSend:function(){
				showDivLoading();
			},
			success:function(resp){
				removeDivLoading();
				if (resp > 0)
				{
					if (confirm ("El documento esta reportado en la lista clinton \n se guardara con estado bloqueado \n debera informar a la persona que autoriza para poder cambiar el estado \n guardar de todos modos?") == true)
					{
						$('#estado').val('B');
						$('#estado').attr("disabled","true");
					 	if(ValidaRequeridos(formulario) && ValidaOtrosTercero(formulario)){ 
							Send(formulario,'onclickSave',null,ClienteOnSave);
						}
					}
				}
				else 
				{
					if(ValidaRequeridos(formulario) && ValidaOtrosTercero(formulario)){ 
							Send(formulario,'onclickSave',null,ClienteOnSave);
					}
				}
				
			}
		});
		
		
	
	
}
	
