// JavaScript Document
$(document).ready(function(){
	linkDetallesSolicitud();
	setCuentasFormaPago();
	verDocumentoContableAnticipo();
});

function generarAnticipoPlaca(obj){
	
	var row = obj.parentNode.parentNode;
	
	if(validaRequeridosDetalle(obj,row)){
	  
	  var Celda                        = obj.parentNode;
	  var Fila                         = Celda.parentNode;
	  var Tabla                        = Fila.parentNode;

	  var checkGenerar                 = $(Fila).find("input[name=generarAnticipoPlaca]");	  
	  var anticipos_proveedor_id       = $(Fila).find("input[name=anticipos_proveedor_id]").val();	  
	  var fecha_egreso             	   = $(Fila).find("input[name=fecha_egreso]").val();
	  //var tipo_doc             	   	   = $(Fila).find("select[name=tipo_doc]  option:selected").val();
	  var sub_anticipos_proveedor_id   	   = $(Fila).find("select[name=sub_anticipos_proveedor_id]  option:selected").val();	  
	  var numero                       = $(Fila).find("input[name=numero]").val();	  
	  var forma_pago_id                = $(Fila).find("select[name=forma_pago] option:selected").val();
	  var numero_soporte               = $(Fila).find("input[name=numero_soporte]").val();	  
	  var cuenta_tipo_pago             = $(Fila).find("select[name=cuenta_tipo_pago] option:selected").val();
	  var valor                        = $(Fila).find("input[name=valor]").val();
	 // var tenedor_id                   = $(Fila).find("input[name=tenedor_id]").val();
	  //var tenedor                      = $(Fila).find("input[name=tenedor]").val();
	  //var conductor_id               = $(Fila).find("input[name=conductor_id]").val();
	  //var nombre                 	   = $(Fila).find("input[name=nombre]").val();
	 // var tenedor_id                   = parent.document.getElementById("tenedor_id").value;
	  //var tenedor                      = parent.document.getElementById("tenedor").value;
	  //var conductor_id                 = parent.document.getElementById("conductor_hidden").value;
	  var parametros_anticipo_proveedor_id= $(Fila).find("select[name=parametros_anticipo_proveedor_id] option:selected").val();
	  var proveedor_id                 = $(Fila).find("input[name=proveedor_id]").val();
	  var nombre                 	   = $(Fila).find("input[name=nombre]").val();
	  
	  var consecutivo                  = $(Fila).find("input[name=consecutivo]").val();
  	  var observaciones                = $(Fila).find("input[name=observaciones]").val();
	  	  
	  if(forma_pago_id == 'NULL' || cuenta_tipo_pago == 'NULL'){
		  alertJquery("Debe Seleccionar forma de pago  y cuenta!!","Validacion");
		  return true;
	  }else{

	      var QueryString = "ACTIONCONTROLER=onclickSave&anticipos_proveedor_id="+anticipos_proveedor_id+"&numero="+numero+"&proveedor_id="+proveedor_id+"&consecutivo="+consecutivo+"&nombre="+nombre+"&fecha_egreso="+fecha_egreso+"&forma_pago_id="
		  +forma_pago_id+"&numero_soporte="+numero_soporte+"&cuenta_tipo_pago="+cuenta_tipo_pago+"&valor="+valor+"&observaciones="+observaciones+"&sub_anticipos_proveedor_id="+sub_anticipos_proveedor_id+"&parametros_anticipo_proveedor_id="+parametros_anticipo_proveedor_id;	      				      
		  
	      $.ajax({
		      url        : "DetalleDevolucionProveedorClass.php?rand="+Math.random(),
		      data       : QueryString,
		      beforeSend : function(){
			    showDivLoading();
		      },
		      success    : function(resp){
				  				  
				  try{
					  
					 var data                   = $.parseJSON(resp); 					 
					 var encabezado_registro_id = data['encabezado_registro_id'];

					 
					 if(!isNaN(encabezado_registro_id)){
						 
					 
					   var QueryString = "ACTIONCONTROLER=viewDocAnticipo&encabezado_registro_id="+encabezado_registro_id+"&view=window";
					 
					   parent.document.getElementById("encabezado_registro_id").value = encabezado_registro_id;
					   parent.document.getElementById("frameRegistroContable").src = "AnticiposPlacaClass.php?"+QueryString+"&rand="+Math.random();
					   
                       if(parent.document.getElementById('imprimir'))parent.document.getElementById('imprimir').disabled = false; 	
					   
					   $(obj.parentNode.parentNode).find("input[name=encabezado_registro_id]").val(encabezado_registro_id);					   					
					   $(obj.parentNode.parentNode).find("input[name=generarAnticipoPlaca]").attr("disabled","true");
					   $(obj.parentNode.parentNode).find("input[name=ver]").attr("disabled","");
					   $(obj.parentNode.parentNode).find("input[name=anular]").attr("disabled","");					   
					   parent.recargar_anticipos(proveedor_id);
					 }else{
						   removeDivLoading();
						   alertJquery(resp,"Error :"+e);
						   return false;
					 }
					  	
				  }catch(e){
					  removeDivLoading();
					  alertJquery(resp,"Error : "+e);
					  return false;
				  }
					
                  removeDivLoading();			      
			      
		      }
		      
	      });
		  
	  }
  }else{
	 alertJquery("Faltan Campos requeridos","Campos Requeridos");
  }
}  



function setCuentasFormaPago(){
	
	$("select[name=forma_pago]").change(function(){
						
      var obj           = this;						
	  var forma_pago_id = this.value;					
      var QueryString   = "ACTIONCONTROLER=setCuentasFormaPago&forma_pago_id="+forma_pago_id;						
						
	  $.ajax({
         url        : "DetalleDevolucionProveedorClass.php?rand="+Math.random(),
		 data       : QueryString,
		 beforeSend : function(){
		   showDivLoading();
		 },
		 success    : function(resp){
			 var row = obj.parentNode.parentNode;
			 $(row).find("#divCuentaTipoPago").html(resp);
			 removeDivLoading();
		 }
	  });											
  												
												
    });
	
	
}

function verDocumentoContableAnticipo(){

  $("input[name=ver]").click(function(){
									  
       this.checked               = false;									  
       var encabezado_registro_id = $(this.parentNode.parentNode).find("input[name=encabezado_registro_id]").val();									  	
	   var QueryString            = "ACTIONCONTROLER=viewDocAnticipo&encabezado_registro_id="+encabezado_registro_id+"&view=window";
	 
	   parent.document.getElementById("encabezado_registro_id").value = encabezado_registro_id;
	   parent.document.getElementById("frameRegistroContable").src = "AnticiposPlacaClass.php?"+QueryString+"&rand="+Math.random();
	   
	   if(parent.document.getElementById('imprimir'))parent.document.getElementById('imprimir').disabled = false; 	
	   
									  
  });

}

function anularAnticipoPlaca(obj){
	
	var row = obj.parentNode.parentNode;
	
	if(parent.document.getElementById("anular")){
	  
	  var Celda                        = obj.parentNode;
	  var Fila                         = Celda.parentNode;
	  var Tabla                        = Fila.parentNode;

	  var checkGenerar                 = $(Fila).find("input[name=anular]");	  
	  var anticipos_proveedor_id      	   = $(Fila).find("input[name=anticipos_proveedor_id]").val();	  
	  var encabezado_registro_id       = $(Fila).find("input[name=encabezado_registro_id]").val();	  	  
	  var proveedor_id                     = $(Fila).find("input[name=proveedor_id]").val();
	  
	  	  

	  var QueryString = "ACTIONCONTROLER=onclickAnular&anticipos_proveedor_id="+anticipos_proveedor_id+"&encabezado_registro_id="+encabezado_registro_id;	      				      
	  
	  $.ajax({
		  url        : "DetalleDevolucionProveedorClass.php?rand="+Math.random(),
		  data       : QueryString,
		  beforeSend : function(){
			showDivLoading();
		  },
		  success    : function(resp){
							  
			  try{
					   removeDivLoading();
					   parent.recargar_anticipos(proveedor_id);
					   alertJquery(resp,"Anulacion Devolucion Placa");					
			  }catch(e){
				  removeDivLoading();
				  alertJquery(resp,"Error : "+e);
				  return false;
			  }
				
			  removeDivLoading();			      
		  }
	  });
		  
  }else{
	 alertJquery("No tiene permisos para Anular","Permisos");
  }
}  


function eliminarAnticipoPlaca(obj){
	
	var row = obj.parentNode.parentNode;
	
	if(parent.document.getElementById("borrar")){
	  
	  var Celda                        = obj.parentNode;
	  var Fila                         = Celda.parentNode;
	  var Tabla                        = Fila.parentNode;

	  var checkGenerar                 = $(Fila).find("input[name=eliminar]");	  
	  var anticipos_proveedor_id      	   = $(Fila).find("input[name=anticipos_proveedor_id]").val();	  
	  var encabezado_registro_id       = $(Fila).find("input[name=encabezado_registro_id]").val();	  	  
	  var proveedor_id                     = $(Fila).find("input[name=proveedor_id]").val();
	  
	  	  

	  var QueryString = "ACTIONCONTROLER=onclickDelete&anticipos_proveedor_id="+anticipos_proveedor_id+"&encabezado_registro_id="+encabezado_registro_id;	      				      
	  
	  $.ajax({
		  url        : "DetalleDevolucionProveedorClass.php?rand="+Math.random(),
		  data       : QueryString,
		  beforeSend : function(){
			showDivLoading();
		  },
		  success    : function(resp){
							  
			  try{
					   removeDivLoading();
					   alertJquery(resp,"Eliminacion Devolucion Placa");
					   if(resp=='Devolucion Eliminado Exitosamente')
					   parent.recargar_anticipos(proveedor_id);
					   
			  }catch(e){
				  removeDivLoading();
				  alertJquery(resp,"Error : "+e);
				  return false;
			  }
				
			  removeDivLoading();			      
		  }
	  });
		  
  }else{
	 alertJquery("No tiene permisos para Eliminar","Permisos");
  }
}  

/***************************************************************
  Funciones para el objeto de guardado en los edtalles de ruta
***************************************************************/
function linkDetallesSolicitud(){

	$("input[name=generarAnticipoPlaca]").attr("href","javascript:void(0)");
	
	$("input[name=generarAnticipoPlaca]").focus(function(){
		var celda = this.parentNode;
		$(celda).addClass("focusSaveRow");
    });
	
	$("input[name=generarAnticipoPlaca]").blur(function(){
		var celda = this.parentNode;
		$(celda).removeClass("focusSaveRow");
    });
	
	$("input[name=generarAnticipoPlaca]").click(function(){ 
		generarAnticipoPlaca(this);
    });


	$("input[name=anular]").click(function(){ 
		anularAnticipoPlaca(this);
    });

	$("input[name=eliminar]").click(function(){ 
		eliminarAnticipoPlaca(this);
    });

}