// JavaScript Document
function setDataFormWithResponse(){
	auto();
    var terceroId = $('#tercero_id').val();

    RequiredRemove();

    var parametros  = new Array({campos:"tercero_id",valores:$('#tercero_id').val()});
	var forma       = document.forms[0];
	var controlador = 'ProveedorClass.php';

	FindRow(parametros,forma,controlador,null,function(resp){
	  var data = $.parseJSON(resp);
	  ocultaFilaNombresRazon(data[0]['tipo_persona_id']);
      if($('#guardar'))    $('#guardar').attr("disabled","true");
      if($('#actualizar')) $('#actualizar').attr("disabled","");
      if($('#borrar'))     $('#borrar').attr("disabled","");
      if($('#limpiar'))    $('#limpiar').attr("disabled","");	  
    });


}

function LlenarFormNumId(){
	
RequiredRemove();

FindRow([{campos:"tercero_id",valores:$('#tercero_id').val()}],document.forms[0],'ProveedorClass.php');

if($('#guardar'))    $('#guardar').attr("disabled","true");
if($('#actualizar')) $('#actualizar').attr("disabled","");
if($('#borrar'))     $('#borrar').attr("disabled","");
if($('#limpiar'))    $('#limpiar').attr("disabled","");
}

function ProveedorOnSaveOnUpdateonDelete(formulario,resp){
	Reset(formulario);
   clearFind();
   $("#refresh_QUERYGRID_terceros").click();
   
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
	
   alertJquery(resp,"Terceros");
   
}
function proveedorOnReset(formulario){
	
    clearFind();	
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");	
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
  $("#tipo_identificacion_id").change(function(){
    calculaDigitoTercero();
  });
  
  $("#numero_identificacion").blur(function(){

     var tercero_id            = $("#tercero_id").val();
     var numero_identificacion = this.value;
     var params                = new Array({campos:"numero_identificacion",valores:numero_identificacion});
	 
	 if(!tercero_id.length > 0){
	 
       validaRegistro(this,params,"ProveedorClass.php",null,function(resp){    
																  																  
         if(parseInt(resp) != 0 ){
           var params     = new Array({campos:"numero_identificacion",valores:numero_identificacion});
           var formulario = document.forms[0];
           var url        = 'ProveedorClass.php';

           FindRow(params,formulario,url,null,function(resp){
													   
		   var data = $.parseJSON(resp);
		   ocultaFilaNombresRazon(data[0]['tipo_persona_id']);	     
													   
													 
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
	 
	 }
  
  });
  
  $("#guardar,#actualizar").click(function(){
	  
	  var formulario = document.getElementById('ProveedoresForm');
	  
	  if(ValidaRequeridos(formulario) && ValidaOtrosTercero(formulario)){ 
	    if(this.id == 'guardar'){
         Send(formulario,'onclickSave',null,ProveedorOnSaveOnUpdateonDelete)
		}else{
            Send(formulario,'onclickUpdate',null,ProveedorOnSaveOnUpdateonDelete)
		  }
	  }
	  	  
  });
  $("#tipo_persona_id").change(function(){
    ocultaFilaNombresRazon(this.value);
	if(this.value==1){
		$("#razon_social").removeClass("obligatorio");
		$("#primer_nombre,#primer_apellido").addClass("obligatorio");	
	}else{
		$("#razon_social").addClass("obligatorio");
		$("#primer_nombre,#primer_apellido").removeClass("obligatorio");	
		
	}
    
  });
  

});
	
