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
	  var certificados_id                = $("#certificados_id").val();
	  var cuentas_certificado_id          = $(Fila).find("input[name=cuentas_certificado_id]").val();	  	  
	  var puc_id                       = $(Fila).find("input[name=puc_id]").val();
	  var checkProcesar                = $(Fila).find("input[name=procesar]");
	  	
	  if(!cuentas_certificado_id.length > 0){
	    	      	      
	      var QueryString = "ACTIONCONTROLER=onclickSave&cuentas_certificado_id="+cuentas_certificado_id+"&puc_id="+
		  puc_id+'&certificados_id='+certificados_id;
	      
	      $.ajax({
		      url        : "DetalleCertificadosClass.php",
		      data       : QueryString,
		      beforeSend : function(){
			    setMessageWaiting();
		      },
		      success    : function(response){
		      
			      if(!isNaN(response)){
				
				      $(Fila).find("input[name=cuentas_certificado_id]").val(response);				      
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
       
	  
	      var QueryString = "ACTIONCONTROLER=onclickUpdate&cuentas_certificado_id="+cuentas_certificado_id+
		  "&puc_id="+puc_id+'&certificados_id='+certificados_id;
		
		$.ajax({
			url        : "DetalleCertificadosClass.php",
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
	var certificados_id       = $("#certificados_id").val();
	var cuentas_certificado_id = $(Fila).find("input[name=cuentas_certificado_id]").val();
		
	var QueryString   = "ACTIONCONTROLER=onclickDelete&certificados_id="+certificados_id+"&cuentas_certificado_id="+cuentas_certificado_id;
	
	if(cuentas_certificado_id.length > 0){
			$.ajax({
				   
				url        : "DetalleCertificadosClass.php",
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
	
	parent.document.getElementById("refresh_QUERYGRID_certificados").click();
	
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
	
	$("input[name=puc]").autocomplete("../../../framework/clases/ListaInteligente.php?consulta=cuentas_movimiento_activas", {
		width: 355,
		selectFirst: true
	});
	
	$("input[name=puc]").result(function(event, data, formatted) {
		if (data) $(this).next().val(data[1]);
                $(this).parent().next().find("input").focus();
	});
	
}