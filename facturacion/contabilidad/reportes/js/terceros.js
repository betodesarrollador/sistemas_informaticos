// JavaScript Document
function setDataFormWithResponse(){
	
RequiredRemove();
FindRow([{campos:"tercero_id",valores:$('#tercero_id').val()}],document.forms[0],'TercerosClass.php');
if($('#guardar'))    $('#guardar').attr("disabled","true");
if($('#actualizar')) $('#actualizar').attr("disabled","");
if($('#borrar'))     $('#borrar').attr("disabled","");
if($('#limpiar'))    $('#limpiar').attr("disabled","");
}
function TerceroOnSaveOnUpdateonDelete(formulario,resp){
   Reset(formulario);
   clearFind();
   $("#refresh_QUERYGRID_terceros").click();
   
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
	
   alertJquery(resp,"Terceros");
   
}
function tercerosOnReset(formulario){
	
	Reset(formulario);
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
	 
       validaRegistro(this,params,"TercerosClass.php",null,function(resp){    
																  																  
         if(parseInt(resp) != 0 ){
           var params     = new Array({campos:"numero_identificacion",valores:numero_identificacion});
           var formulario = document.forms[0];
           var url        = 'TercerosClass.php';
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
});
	
