// JavaScript Document
$(document).ready(function(){
	linkDetallesSolicitud();
	setCuentasFormaPago();
	verDocumentoContableAnticipo();
});

function generarAnticipoManifiesto(obj){
	
	var row = obj.parentNode.parentNode;
	
	if(validaRequeridosDetalle(obj,row)){
	  
	  var Celda                        = obj.parentNode;
	  var Fila                         = Celda.parentNode;
	  var Tabla                        = Fila.parentNode;
	  var celdaFechaEgreso             = $(Fila).find("td[id=fecha_egreso]");	  
	  var checkGenerar                 = $(Fila).find("input[name=generarAnticipoManifiesto]");	  
	  var anticipos_manifiesto_id      = $(Fila).find("input[name=anticipos_manifiesto_id]").val();	  
	  var numero                       = $(Fila).find("input[name=numero]").val();	  
	  var forma_pago_id                = $(Fila).find("select[name=forma_pago] option:selected").val();
	  var numero_soporte               = $(Fila).find("input[name=numero_soporte]").val();	  
	  var cuenta_tipo_pago             = $(Fila).find("select[name=cuenta_tipo_pago] option:selected").val();
	  var valor                        = $(Fila).find("input[name=valor]").val();
	  var conductor_id                 = $(Fila).find("input[name=conductor]").val();
	  var tenedor_id                   = $(Fila).find("input[name=tenedor]").val();
	  	  
	  if(forma_pago_id == 'NULL' || cuenta_tipo_pago == 'NULL'){
		  alertJquery("Debe Seleccionar forma de pago  y cuenta!!","Validacion");
		  return true;
	  }else{
		    
	      var QueryString = "ACTIONCONTROLER=onclickSave&anticipos_manifiesto_id="+anticipos_manifiesto_id+"&numero="+numero+"&forma_pago_id="
		  +forma_pago_id+"&numero_soporte="+numero_soporte+"&cuenta_tipo_pago="+cuenta_tipo_pago+"&valor="+valor+"&conductor_id="+conductor_id
		  +"&tenedor_id="+tenedor_id;	      				      
		  
	      $.ajax({
		      url        : "DetalleAnticiposClass.php?rand="+Math.random(),
		      data       : QueryString,
		      beforeSend : function(){
			    showDivLoading();
		      },
		      success    : function(resp){
				  				  
				  try{
					  
					 var data                   = $.parseJSON(resp); 					 
					 var encabezado_registro_id = data['encabezado_registro_id'];
					 var fecha_egreso           = data['fecha_egreso'];
					 
					 if(!isNaN(encabezado_registro_id)){
						 
					  celdaFechaEgreso.html(fecha_egreso);	 
					 
					   var QueryString = "ACTIONCONTROLER=viewDocAnticipo&encabezado_registro_id="+encabezado_registro_id+"&view=window";
					 
					   parent.document.getElementById("encabezado_registro_id").value = encabezado_registro_id;
					   parent.document.getElementById("frameRegistroContable").src = "AnticiposClass.php?"+QueryString+"&rand="+Math.random();
					   
                       if(parent.document.getElementById('imprimir'))parent.document.getElementById('imprimir').disabled = false; 	
					   
					   $(obj.parentNode.parentNode).find("input[name=encabezado_registro_id]").val(encabezado_registro_id);					   					
					   $(obj.parentNode.parentNode).find("input[name=generarAnticipoManifiesto]").attr("disabled","true");
					   $(obj.parentNode.parentNode).find("input[name=ver]").attr("disabled","");
					   $(obj.parentNode.parentNode).find("input[name=anular]").attr("disabled","");					   
					 
					 }else{
						   alertJquery(resp,"Error :"+e);
						   return false;
					   }
					  
				  }catch(e){
					  alertJquery(resp,"Error : "+e);
					  return false;
					}
					
                  removeDivLoading();			      
			      
		      }
		      
	      });
		  
	  }
	      
	

     
  }//fin de validaRequeridosDetalle	
  
}  


function generarAnticipoDespacho(obj){
	
	var row = obj.parentNode.parentNode;
	
	if(validaRequeridosDetalle(obj,row)){
	  
	  var Celda                        = obj.parentNode;
	  var Fila                         = Celda.parentNode;
	  var Tabla                        = Fila.parentNode;
	  var celdaFechaEgreso             = $(Fila).find("td[id=fecha_egreso]");		  
	  var anticipos_despacho_id        = $(Fila).find("input[name=anticipos_despacho_id]").val();	  
	  var numero                       = $(Fila).find("input[name=numero]").val();	  
	  var forma_pago_id                = $(Fila).find("select[name=forma_pago] option:selected").val();
	  var numero_soporte               = $(Fila).find("input[name=numero_soporte]").val();		  
	  var cuenta_tipo_pago             = $(Fila).find("select[name=cuenta_tipo_pago] option:selected").val();
	  var valor                        = $(Fila).find("input[name=valor]").val();
	  var conductor_id                 = $(Fila).find("input[name=conductor]").val();
	  var tenedor_id                   = $(Fila).find("input[name=tenedor]").val();
	  
	  if(forma_pago_id == 'NULL' || cuenta_tipo_pago == 'NULL'){
		  alertJquery("Debe Seleccionar forma de pago  y cuenta!!","Validacion");
		  return true;
	  }else{
		    
	      var QueryString = "ACTIONCONTROLER=onclickSave&anticipos_despacho_id="+anticipos_despacho_id+"&numero="+numero+"&forma_pago_id="
		  +forma_pago_id+"&numero_soporte="+numero_soporte+"&cuenta_tipo_pago="+cuenta_tipo_pago+"&valor="+valor+"&conductor_id="+conductor_id
		  +"&tenedor_id="+tenedor_id;	      				      
		  
	      $.ajax({
		      url        : "DetalleAnticiposClass.php?rand="+Math.random(),
		      data       : QueryString,
		      beforeSend : function(){
			    showDivLoading();
		      },
		      success    : function(resp){
				  				  
				  try{
					  
					 var data                   = $.parseJSON(resp); 					 
					 var encabezado_registro_id = data['encabezado_registro_id'];
					 var fecha_egreso           = data['fecha_egreso'];					 
					 
					 if(!isNaN(encabezado_registro_id)){
					 					 
   					   celdaFechaEgreso.html(fecha_egreso);	 
					   
					   var QueryString = "ACTIONCONTROLER=viewDocAnticipo&encabezado_registro_id="+encabezado_registro_id+"&view=window";
					 
					   parent.document.getElementById("encabezado_registro_id").value = encabezado_registro_id;
					   parent.document.getElementById("frameRegistroContable").src = "AnticiposClass.php?"+QueryString+"&rand="+Math.random();
					   
                       if(parent.document.getElementById('imprimir'))parent.document.getElementById('imprimir').disabled = false; 	
					   					   
					   $(obj.parentNode.parentNode).find("input[name=encabezado_registro_id]").val(encabezado_registro_id);					   
					   $(obj.parentNode.parentNode).find("input[name=generarAnticipoDespacho]").attr("disabled","true");
					   $(obj.parentNode.parentNode).find("input[name=ver]").attr("disabled","");
					   $(obj.parentNode.parentNode).find("input[name=anular]").attr("disabled","");					   
					 
					 }else{
						   alertJquery(resp,"Error :"+e);
						   return false;
					   }
					  
				  }catch(e){
					  alertJquery(resp,"Error : "+e);
					  return false;
					}
					
                  removeDivLoading();			      
			      
		      }
		      
	      });
		  
	  }
	      
	

     
  }//fin de validaRequeridosDetalle	
  
}  

function setCuentasFormaPago(){
	
	$("select[name=forma_pago]").change(function(){
						
      var obj           = this;						
	  var forma_pago_id = this.value;					
      var QueryString   = "ACTIONCONTROLER=setCuentasFormaPago&forma_pago_id="+forma_pago_id;						
						
	  $.ajax({
         url        : "DetalleAnticiposClass.php?rand="+Math.random(),
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
	   parent.document.getElementById("frameRegistroContable").src = "AnticiposClass.php?"+QueryString+"&rand="+Math.random();
	   
	   if(parent.document.getElementById('imprimir'))parent.document.getElementById('imprimir').disabled = false; 	
	   
									  
  });

}

/***************************************************************
  Funciones para el objeto de guardado en los edtalles de ruta
***************************************************************/
function linkDetallesSolicitud(){

	$("input[name=generarAnticipoManifiesto]").attr("href","javascript:void(0)");
	
	$("input[name=generarAnticipoManifiesto]").focus(function(){
		var celda = this.parentNode;
		$(celda).addClass("focusSaveRow");
    });
	
	$("input[name=generarAnticipoManifiesto]").blur(function(){
		var celda = this.parentNode;
		$(celda).removeClass("focusSaveRow");
    });
	
	$("input[name=generarAnticipoManifiesto]").click(function(){
		generarAnticipoManifiesto(this);
    });
	
	
	$("input[name=generarAnticipoDespacho]").attr("href","javascript:void(0)");
	
	$("input[name=generarAnticipoDespacho]").focus(function(){
		var celda = this.parentNode;
		$(celda).addClass("focusSaveRow");
    });
	
	$("input[name=generarAnticipoDespacho]").blur(function(){
		var celda = this.parentNode;
		$(celda).removeClass("focusSaveRow");
    });
	
	$("input[name=generarAnticipoDespacho]").click(function(){
		generarAnticipoDespacho(this);
    });	
	
}