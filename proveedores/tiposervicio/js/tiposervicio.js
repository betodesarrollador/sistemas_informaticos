// JavaScript Document
function setDataFormWithResponse(){
    var tipoServicioId = $('#tipo_bien_servicio_id').val();
    RequiredRemove();

    var parametros  = new Array({campos:"tipo_bien_servicio_id",valores:$('#tipo_bien_servicio_id').val()});
	var forma       = document.forms[0];
	var controlador = 'TipoServicioClass.php';

	var url = "DetallesClass.php?tipo_bien_servicio_id="+tipoServicioId+"&rand="+Math.random();
	$("#detalles").attr("src",url);						  	

	var url = "DevolucionClass.php?tipo_bien_servicio_id="+tipoServicioId+"&rand="+Math.random();
	$("#devolucion").attr("src",url);						  	

	FindRow(parametros,forma,controlador,null,function(resp){
		if($('#guardar'))    $('#guardar').attr("disabled","true");
		if($('#actualizar')) $('#actualizar').attr("disabled","");
		if($('#borrar'))     $('#borrar').attr("disabled","");
		if($('#limpiar'))    $('#limpiar').attr("disabled","");	 
	  

		var QueryString = "ACTIONCONTROLER=getAgencias&tipo_bien_servicio_id="+tipoServicioId;
		
		$.ajax({
		  url     : "TipoServicioClass.php",
		  data    : QueryString,
		  success : function(response){
					  
			  try{
				 var agencia	 = $.parseJSON(response); 

				 for(i=0;i<agencia.length;i++){
					$("#agencia option").each(function(){
					  if(this.value =='NULL'){
					  	  this.selected = false;				
					  }
					  if(this.value == agencia[i]['oficina_id']){
						  this.selected = true;				
					  }
														
					});
				 }
			  }catch(e){
				  
				}
		  }
		  
		});    

    });


}


function TipoServicioOnSave(formulario,resp){
   if(resp){
		var tipo_bien_servicio_id = resp;
		var url = "DetallesClass.php?tipo_bien_servicio_id="+tipo_bien_servicio_id+"&rand="+Math.random();
		$("#tipo_bien_servicio_id").val(tipo_bien_servicio_id);						
		$("#detalles").attr("src",url);		
		var url = "DevolucionClass.php?tipo_bien_servicio_id="+tipo_bien_servicio_id+"&rand="+Math.random();
		$("#devolucion").attr("src",url);						  	

   }
   $("#refresh_QUERYGRID_tiposervicio").click();
   
   if($('#guardar'))    $('#guardar').attr("disabled","true");
   if($('#actualizar')) $('#actualizar').attr("disabled","");
   if($('#borrar'))     $('#borrar').attr("disabled","");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
	
   alertJquery(resp,"TipoServicio");
}
function TipoServicioOnUpdate(formulario,resp){
   if(resp){
		var tipo_bien_servicio_id = $("#tipo_bien_servicio_id").val();
		var url = "DetallesClass.php?tipo_bien_servicio_id="+tipo_bien_servicio_id+"&rand="+Math.random();
		$("#detalles").attr("src",url);		
		var url = "DevolucionClass.php?tipo_bien_servicio_id="+tipo_bien_servicio_id+"&rand="+Math.random();
		$("#devolucion").attr("src",url);						  	
		
   }
   $("#refresh_QUERYGRID_tiposervicio").click();
   
   if($('#guardar'))    $('#guardar').attr("disabled","true");
   if($('#actualizar')) $('#actualizar').attr("disabled","");
   if($('#borrar'))     $('#borrar').attr("disabled","");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
	
   alertJquery(resp,"TipoServicio");
}

function TipoServicioOnDelete(formulario,resp){
   if(resp){
		$("#detalles").attr("src","/rotterdan/framework/tpl/blank.html");
		$("#devolucion").attr("src","/rotterdan/framework/tpl/blank.html");
	   clearFind();
       $("#refresh_QUERYGRID_tiposervicio").click();
	   
	   if($('#guardar'))    $('#guardar').attr("disabled","");
	   if($('#actualizar')) $('#actualizar').attr("disabled","true");
	   if($('#borrar'))     $('#borrar').attr("disabled","true");
	   if($('#limpiar'))    $('#limpiar').attr("disabled","");
   }
   alertJquery(resp,"TipoServicio");
}

function TipoServicioOnReset(formulario){

	$("#detalles").attr("src","/rotterdan/framework/tpl/blank.html");
	$("#devolucion").attr("src","/rotterdan/framework/tpl/blank.html");
    clearFind();	
	
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");	
}


$(document).ready(function(){

  $("#saveDetallepuc").click(function(){										
    window.frames[0].saveDetalles();	
  });  


  $("#deleteDetallepuc").click(function(){										
    window.frames[0].deleteDetalles();
  });  

  $("#saveDetalledev").click(function(){										
    window.frames[1].saveDetalles();	
  });  


  $("#deleteDetalledev").click(function(){										
    window.frames[1].deleteDetalles();
  });  

						   
  $("#guardar,#actualizar").click(function(){
	  
	  var formulario = document.getElementById('TipoServicioForm');
	  
	  if(ValidaRequeridos(formulario)){ 
	    if(this.id == 'guardar'){
         Send(formulario,'onclickSave',null,TipoServicioOnSave)
		}else{
            Send(formulario,'onclickUpdate',null,TipoServicioOnUpdate)
		  }
	  }
	  	  
  });

});
	
