// JavaScript Document

function setDataFormWithResponse(){
	
	var parametros  = new Array({campos:"tercero_id",valores:$('#tercero_id').val()});
	var forma       = document.forms[0];
	var controlador = 'TenedoresClass.php';
	
	FindRow(parametros,forma,controlador,null,function(resp){
	  
	        var data = $.parseJSON(resp);
  
                ocultaFilaNombresRazon(data[0]['tipo_persona_id']);
		
		if($('#actualizar')) $('#guardar').attr("disabled","true");
		if($('#actualizar')) $('#actualizar').attr("disabled","");
		if($('#borrar'))     $('#borrar').attr("disabled","");
		if($('#limpiar'))    $('#limpiar').attr("disabled","");
		   
	});
}

function TenedoresOnSaveUpdate(formulario,resp){
		
	if($.trim(resp) == 'true'){		
	
	  var QueryString = FormSerialize(formulario)+"&ACTIONCONTROLER=sendTenedorMintransporte";
	  	
	  $.ajax({
		url        : "TenedoresClass.php?rand="+Math.random(),	 
		data       : QueryString,
		beforeSend : function(){
			window.scrollTo(0,0);
			showDivMessage("Reportando al Ministerio de Transporte<br>Por Favor Espere..","../../../framework/media/images/general/cable_data_transfer_md_wht.gif");
		},
		success    : function(resp){			
					
			removeDivMessage();
			
			showDivMessage(resp,"../../../framework/media/images/general/cable_data_transfer_md_wht.gif");			
						
			Reset(document.getElementById('TenedoresForm'));
			clearFind();
			$("#refresh_QUERYGRID_tenedores").click();
			$("#estado").val("B");
		
			if($('#guardar'))    $('#guardar').attr("disabled","true");
			if($('#actualizar')) $('#actualizar').attr("disabled","");
			if($('#borrar'))     $('#borrar').attr("disabled","");
			if($('#limpiar'))    $('#limpiar').attr("disabled","");
						
		}
		
	  });
		
	
	}else{
		alertJquery(resp);
	 }
		
}

function TenedoresOnDelete(formulario,resp){

   Reset(document.getElementById('TenedoresForm'));
   clearFind();
   $("#estado").val("B");   
   $("#refresh_QUERYGRID_tenedores").click();
   
   	alertJquery(resp);  
}

function TenedoresOnClear(){
  
    Reset(document.getElementById('TenedoresForm'));
	clearFind();
    $("#estado").val("B");

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

     var numero_identificacion = this.value;
     var params                = new Array({campos:"numero_identificacion",valores:numero_identificacion});
	 
     validaRegistro(this,params,"TenedoresClass.php",null,function(resp){    
															  																  
       if(parseInt(resp) != 0 ){
         var params     = new Array({campos:"numero_identificacion",valores:numero_identificacion});
         var formulario = document.forms[0];
         var url        = 'TenedoresClass.php';

         FindRow(params,formulario,url,null,function(){
													 
           clearFind();		 
		 
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
  
  });
  
  $("#guardar,#actualizar").click(function(){
	  
	  var formulario = document.getElementById('TenedoresForm');
	  
	  if(ValidaRequeridos(formulario) && ValidaOtrosTercero(formulario)){ 
	  	  
         if(this.name == 'actualizar'){
            Send(formulario,'onclickUpdate',null,TenedoresOnSaveUpdate)			 
		 }else{
               Send(formulario,'onclickSave',null,TenedoresOnSaveUpdate)			 
		   }
	  
	  }
	  	  
  });
  
  $("#tipo_persona_id").change(function(){
    
    ocultaFilaNombresRazon(this.value);
	var tipo = document.getElementById('tipo_persona_id');
	
	if(tipo==2){
		$("#primer_nombre,#primer_apellido").removeClass('obligatorio');
	  	$("#primer_nombre,#primer_apellido").removeClass('requerido');
	}else{
	  	$("#primer_nombre,#primer_apellido").addClass('requerido');
		$("#primer_nombre,#primer_apellido").addClass('requerido');
	}	
    
  });

});