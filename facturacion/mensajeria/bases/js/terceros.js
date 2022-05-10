// JavaScript Document

function setDataFormWithResponse(){
	
RequiredRemove();

FindRow([{campos:"tercero_id",valores:$('#tercero_id').val()}],document.forms[0],'TercerosClass.php',null,function(resp){
  
  var data = $.parseJSON(resp);
  
  ocultaFilaNombresRazon(data[0]['tipo_persona_id']);
  
  document.getElementById('propietario_vehiculo').value = 1;

  if($('#guardar'))    $('#guardar').attr("disabled","true");
  if($('#actualizar')) $('#actualizar').attr("disabled","");
  if($('#borrar'))     $('#borrar').attr("disabled","");
  if($('#limpiar'))    $('#limpiar').attr("disabled","");

  
});


}

function TerceroOnSaveOnUpdateonDelete(formulario,resp){
	
	
	if($.trim(resp) == 'true'){		
	
	  var QueryString = FormSerialize(formulario)+"&ACTIONCONTROLER=sendPropietarioMintransporte";
	  	
	  $.ajax({
		url        : "TercerosClass.php?rand="+Math.random(),	 
		data       : QueryString,
		beforeSend : function(){
			window.scrollTo(0,0);
			showDivMessage("Reportando al Ministerio de Transporte<br>Por Favor Espere..","/velotax/framework/media/images/general/cable_data_transfer_md_wht.gif");
		},
		success    : function(resp){			
					
			removeDivMessage();
			
			showDivMessage(resp,"/velotax/framework/media/images/general/cable_data_transfer_md_wht.gif");			

            Reset(formulario);
            clearFind();
            $("#refresh_QUERYGRID_terceros").click();
            $("#estado").val("B");
   
            if($('#guardar'))    $('#guardar').attr("disabled","");
            if($('#actualizar')) $('#actualizar').attr("disabled","true");
            if($('#borrar'))     $('#borrar').attr("disabled","true");
            if($('#limpiar'))    $('#limpiar').attr("disabled","");		
						
		}
		
	  });
		
	
	}else{
		alertJquery(resp);
	 }
	
   
}
function tercerosOnReset(formulario){
	
	Reset(formulario);
    clearFind();	
	$("#estado").val("B");
	$("#propietario_vehiculo").val("1");	
	$("#autoret_proveedor,#retei_proveedor").val("N");		
	
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
	 
       validaRegistro(this,params,"TercerosClass.php",null,function(resp){    
																  																  
         if(parseInt(resp) != 0 ){
           var params     = new Array({campos:"numero_identificacion",valores:numero_identificacion});
           var formulario = document.forms[0];
           var url        = 'TercerosClass.php';

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
	  
	  var formulario = document.getElementById('TercerosForm');
	  
	  if(ValidaRequeridos(formulario) && ValidaOtrosTercero(formulario)){ 
	    if(this.id == 'guardar'){
         Send(formulario,'onclickSave',null,TerceroOnSaveOnUpdateonDelete)
		}else{
            Send(formulario,'onclickUpdate',null,TerceroOnSaveOnUpdateonDelete)
		  }
	  }
	  	  
  });
  
  $("#tipo_persona_id").change(function(){
    
    ocultaFilaNombresRazon(this.value);
    
  });

});
	
