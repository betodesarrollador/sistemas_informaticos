// JavaScript Document
$(document).ready(function(){
	linkDetalles();
	autocompletePuc();
});

function saveDetalle(obj){
	
	var row = obj.parentNode.parentNode;
	if(validaRequeridosDetalle(obj,row)){

	  var Celda                        = obj.parentNode;
	  var Fila                         = Celda.parentNode;
	  var Tabla                        = Fila.parentNode;
	  var forma_pago_id                = $("#forma_pago_id").val();
	  var cuenta_tipo_pago_id          = $(Fila).find("input[name=cuenta_tipo_pago_id]").val();	  	  
	  var puc_id                       = $(Fila).find("input[name=puc_id]").val();
	  var banco_id                     = $(Fila).find("select[name=banco_id] option:selected").val();
	  var oficina_id                   = $(Fila).find("select[name=oficina_id] option:selected").val();	  
	  var cuenta_tipo_pago_natu        = $(Fila).find("select[name=cuenta_tipo_pago_natu] option:selected").val();
	  var checkProcesar                = $(Fila).find("input[name=procesar]");
	  	
	  if(!cuenta_tipo_pago_id.length > 0){
	    	      	      
	      var QueryString = "ACTIONCONTROLER=onclickSave&cuenta_tipo_pago_id="+cuenta_tipo_pago_id+"&puc_id="+
		  puc_id+"&banco_id="+banco_id+"&cuenta_tipo_pago_natu="+cuenta_tipo_pago_natu+'&forma_pago_id='+forma_pago_id+'&oficina_id='+oficina_id;
	      
	      $.ajax({
		      url        : "DetalleFormaPagoClass.php",
		      data       : QueryString,
		      beforeSend : function(){
			    setMessageWaiting();
		      },
		      success    : function(response){
		      
			      if(!isNaN(response)){
				
				      $(Fila).find("input[name=cuenta_tipo_pago_id]").val(response);				      
				      checkProcesar.attr("checked","");
				      $(Celda).removeClass("focusSaveRow");
				      
				      insertaFilaAbajoClon(Tabla);
					  autocompletePuc()
				      checkRow();
				      linkDetalles();
				      updateGrid();
				      setMessage('Se guardo exitosamente.');
		      
			      }else{
					  alert(response)
				      setMessage(response);
			      }		      
		      }		      
	      });	      
	
     }else{       

	      var QueryString = "ACTIONCONTROLER=onclickUpdate&cuenta_tipo_pago_id="+cuenta_tipo_pago_id+"&puc_id="+
		  puc_id+"&banco_id="+banco_id+"&cuenta_tipo_pago_natu="+cuenta_tipo_pago_natu+'&forma_pago_id='+forma_pago_id+'&oficina_id='+oficina_id;

		$.ajax({
			url        : "DetalleFormaPagoClass.php",
			data       : QueryString,
			beforeSend : function(){
			  setMessageWaiting();
			},
			success    : function(response){
			  
			    if( $.trim(response) == 'true'){
				    
			      checkProcesar.attr("checked","");
			      $(Celda).removeClass("focusSaveRow");
			      updateGrid();
			      setMessage('Se guardo exitosamente.');				    
			    }else{
				    alertJquery(response);
			    }		   	       
		     }
		});		
     }//fin detalle_ss_id.length     
  }//fin de validaRequeridosDetalle	  
}

function deleteDetalleSolicitud(obj){
	
	var Celda               = obj.parentNode;
	var Fila                = obj.parentNode.parentNode;
	var forma_pago_id       = $("#forma_pago_id").val();
	var cuenta_tipo_pago_id = $(Fila).find("input[name=cuenta_tipo_pago_id]").val();
		
	var QueryString   = "ACTIONCONTROLER=onclickDelete&forma_pago_id="+forma_pago_id+"&cuenta_tipo_pago_id="+cuenta_tipo_pago_id;
	
	if(cuenta_tipo_pago_id.length > 0){

			$.ajax({
				   
				url        : "DetalleFormaPagoClass.php",
				data       : QueryString,
				beforeSend : function(){
				  setMessageWaiting();
				},
				success    : function(response){
				  				  
					if( $.trim(response) == 'true'){
						
						$(Fila).remove();
						updateGrid();
						setMessage('Se borro exitosamente.'); 
						
					}else{
						alertJquery(response);
					}	
				 }
			});

	}else{
		setMessage('No puede eliminar elementos que no han sido guardados');
		$(Fila).find("input[name=procesar]").attr("checked","");
	}
}

function saveDetallesSoliServi(){	
	$("input[name=procesar]:checked").each(function(){	
		saveDetalle(this);	
	});
}

function deleteDetallesSoliServi(){  
	$("input[name=procesar]:checked").each(function(){	
		deleteDetalleSolicitud(this);	
	});
}	    
	
function updateGrid(){	
	parent.document.getElementById("refresh_QUERYGRID_forma_pago").click();	
}

/***************************************************************
  Funciones para el objeto de guardado en los edtalles de ruta
***************************************************************/
function linkDetalles(){

	$("a[name=saveDetalle]").attr("href","javascript:void(0)");
	
	$("a[name=saveDetalle]").focus(function(){
		var celda = this.parentNode;
		$(celda).addClass("focusSaveRow");
    });
	
	$("a[name=saveDetalle]").blur(function(){
		var celda = this.parentNode;
		$(celda).removeClass("focusSaveRow");
    });
	
	$("a[name=saveDetalle]").click(function(){
		saveDetalle(this);
    });	
}

/***************************************************************
	  lista inteligente para la los codigos puc
**************************************************************/
function autocompletePuc(){
	
	$("input[name=puc]").autocomplete("/envipack/framework/clases/ListaInteligente.php?consulta=cuentas_movimiento_activas", {
		width: 355,
		selectFirst: true
	});
	
	$("input[name=puc]").result(function(event, data, formatted) {
		if (data) $(this).next().val(data[1]);
                $(this).parent().next().find("input").focus();
	});	
}