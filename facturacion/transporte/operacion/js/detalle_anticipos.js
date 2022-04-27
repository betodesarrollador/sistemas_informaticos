// JavaScript Document
$(document).ready(function(){
	linkDetallesSolicitud();
	setCuentasFormaPago();
	setTercerosFormaPago();	
	verDocumentoContableAnticipo();
});

function generarAnticipoManifiesto(obj){
	
	var row = obj.parentNode.parentNode;
	
	if(validaRequeridosDetalle(obj,row)){
	  
	  var Celda						= obj.parentNode;
	  var Fila						= Celda.parentNode;
	  var Tabla						= Fila.parentNode;
      $(obj.parentNode.parentNode).find("input[name=generarAnticipoManifiesto]").attr("disabled","true");
	  var celdaFechaEgreso			= $(Fila).find("td[id=fecha_egreso]");	  
	  var checkGenerar				= $(Fila).find("input[name=generarAnticipoManifiesto]");	  
	  var anticipos_manifiesto_id	= $(Fila).find("input[name=anticipos_manifiesto_id]").val();	  
	  var numero					= $(Fila).find("input[name=numero]").val();	  
	  var forma_pago_id				= $(Fila).find("select[name=forma_pago] option:selected").val();
	  var numero_soporte			= $(Fila).find("input[name=numero_soporte]").val();
	  var tipo_descuento			= $(Fila).find("select[name=tipo_descuento]").val();
	  var valor_descuento			= $(Fila).find("input[name=valor_descuento]").val();
	  var cuenta_tipo_pago			= $(Fila).find("select[name=cuenta_tipo_pago] option:selected").val();
	  var forma_pago_tercero		= $(Fila).find("select[name=forma_pago_tercero] option:selected").val();
	  var valor						= $(Fila).find("input[name=valor]").val();
	  var conductor_id				= $(Fila).find("input[name=conductor]").val();
	  var tenedor_id				= $(Fila).find("input[name=tenedor]").val();
	  
	  var a_conductor				= $(Fila).find("input[name=a_conductor]").is(":checked")?1:0;	
	  	  
	if (valor_descuento>0 && tipo_descuento=='NULL') {
		alertJquery("Porfavor seleccione un tipo de descuento a aplicar","Tipo Descuento");
		return false;
	}
	  if(forma_pago_id == 'NULL' || cuenta_tipo_pago == 'NULL'){
		  alertJquery("Debe Seleccionar forma de pago  y cuenta!!","Validacion");
		  return true;
	  }else{
		    
	      var QueryString = "ACTIONCONTROLER=onclickSave&anticipos_manifiesto_id="+anticipos_manifiesto_id+"&numero="+numero+"&forma_pago_id="
		  +forma_pago_id+"&numero_soporte="+numero_soporte+"&tipo_descuento="+tipo_descuento+"&valor_descuento="+valor_descuento+"&cuenta_tipo_pago="+cuenta_tipo_pago+"&valor="+valor+"&conductor_id="+conductor_id
		  +"&tenedor_id="+tenedor_id+"&forma_pago_tercero="+forma_pago_tercero+"&a_conductor="+a_conductor;	      				      
		  
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
						   $(obj.parentNode.parentNode).find("input[name=generarAnticipoManifiesto]").attr("disabled","");
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
	  $(obj.parentNode.parentNode).find("input[name=generarAnticipoDespacho]").attr("disabled","true");
	  var celdaFechaEgreso             = $(Fila).find("td[id=fecha_egreso]");		  
	  var anticipos_despacho_id        = $(Fila).find("input[name=anticipos_despacho_id]").val();	  
	  var numero                       = $(Fila).find("input[name=numero]").val();	  
	  var forma_pago_id                = $(Fila).find("select[name=forma_pago] option:selected").val();
	  var numero_soporte               = $(Fila).find("input[name=numero_soporte]").val();		  
	  var cuenta_tipo_pago             = $(Fila).find("select[name=cuenta_tipo_pago] option:selected").val();
	  var forma_pago_tercero           = $(Fila).find("select[name=forma_pago_tercero] option:selected").val();
	  var valor                        = $(Fila).find("input[name=valor]").val();
	  var conductor_id                 = $(Fila).find("input[name=conductor]").val();
	  var tenedor_id                   = $(Fila).find("input[name=tenedor]").val();
	  
	  var a_conductor				= $(Fila).find("input[name=a_conductor]").is(":checked")?1:0;	
	  
	  if(forma_pago_id == 'NULL' || cuenta_tipo_pago == 'NULL'){
		  alertJquery("Debe Seleccionar forma de pago  y cuenta!!","Validacion");
		  return true;
	  }else{
		    
	      var QueryString = "ACTIONCONTROLER=onclickSave&anticipos_despacho_id="+anticipos_despacho_id+"&numero="+numero+"&forma_pago_id="
		  +forma_pago_id+"&numero_soporte="+numero_soporte+"&cuenta_tipo_pago="+cuenta_tipo_pago+"&valor="+valor+"&conductor_id="+conductor_id
		  +"&tenedor_id="+tenedor_id+"&forma_pago_tercero="+forma_pago_tercero+"&a_conductor="+a_conductor;	      				      
		  
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
						   $(obj.parentNode.parentNode).find("input[name=generarAnticipoDespacho]").attr("disabled","");
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

function anularAnticipo(obj){

	var row = obj.parentNode.parentNode;

	if(parent.document.getElementById("anular")){

		var Celda                        = obj.parentNode;
		var Fila                         = Celda.parentNode;
		var Tabla                        = Fila.parentNode;

		var checkGenerar                 = $(Fila).find("input[name=anular]");
		var anticipos_manifiesto_id      = $(Fila).find("input[name=anticipos_manifiesto_id]").val();
		var anticipos_despacho_id        = $(Fila).find("input[name=anticipos_despacho_id]").val();
		var encabezado_registro_id       = $(Fila).find("input[name=encabezado_registro_id]").val();
		var QueryString = "ACTIONCONTROLER=onclickAnular&anticipos_manifiesto_id="+anticipos_manifiesto_id+"&anticipos_despacho_id="+anticipos_despacho_id+"&encabezado_registro_id="+encabezado_registro_id;

		$.ajax({
			url        : "DetalleAnticiposClass.php?rand="+Math.random(),
			data       : QueryString,
			beforeSend : function(){
				showDivLoading();
			},
			success    : function(resp){
				try{
					removeDivLoading();
					// parent.recargar_anticipos(placa_id);
					alertJquery(resp,"Anulacion Anticipos");
				}catch(e){
					removeDivLoading();
					alertJquery(resp,"Error : "+e);
					return false;
				}
			}
		});
	}else{
		alertJquery("No tiene permisos para Anular","Permisos");
	}
}
function setTercerosFormaPago(){

	$("select[name=forma_pago]").change(function(){

		var obj           = this;						
		var forma_pago_id = this.value;					
		var QueryString   = "ACTIONCONTROLER=setTercerosFormaPago&forma_pago_id="+forma_pago_id;						

		$.ajax({
			url        : "DetalleAnticiposClass.php?rand="+Math.random(),
			data       : QueryString,
			beforeSend : function(){
				showDivLoading();
			},
			success    : function(resp){
				var row = obj.parentNode.parentNode;
				$(row).find("#divTerceroTipoPago").html(resp);
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
		showDivLoading();
		generarAnticipoManifiesto(this);
		removeDivLoading();
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
		showDivLoading();													
		generarAnticipoDespacho(this);
		removeDivLoading();
    });	

	$("input[name=anular]").click(function(){ 
		anularAnticipo(this);
    });
	
}