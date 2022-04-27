// JavaScript Document
$(document).ready(function(){
	linkDetalles();
	autocompleteTercero();	
});

function saveDetalle(obj){
	
	var row = obj.parentNode.parentNode;
	if(validaRequeridosDetalle(obj,row)){
	  var Celda                        = obj.parentNode;
	  var Fila                         = Celda.parentNode;
	  var Tabla                        = Fila.parentNode;
	  var forma_pago_id                = $("#forma_pago_id").val();
	  var forma_pago_tercero_id        = $(Fila).find("input[name=forma_pago_tercero_id]").val();	  	  
	  var tercero_id                   = $(Fila).find("input[name=tercero_id]").val();
	  var checkProcesar                = $(Fila).find("input[name=procesar]");
	  	
	  if(!forma_pago_tercero_id.length > 0){
	    	      	      
	      var QueryString = "ACTIONCONTROLER=onclickSave&forma_pago_tercero_id="+forma_pago_tercero_id+"&tercero_id="+
		  tercero_id+'&forma_pago_id='+forma_pago_id;
	      
	      $.ajax({
		      url        : "TerceroFormaPagoClass.php",
		      data       : QueryString,
		      beforeSend : function(){
			    setMessageWaiting();
		      },
		      success    : function(response){
		      
			      if(!isNaN(response)){
				
		      
				      checkProcesar.attr("checked","");
				      $(Celda).removeClass("focusSaveRow");
				      
				      insertaFilaAbajoClon(Tabla);
					  autocompleteTercero()
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
       
	  
	      var QueryString = "ACTIONCONTROLER=onclickUpdate&forma_pago_tercero_id="+forma_pago_tercero_id+"&tercero_id="+
		  tercero_id+"&forma_pago_id="+forma_pago_id;
		
		$.ajax({
			url        : "TerceroFormaPagoClass.php",
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
	var forma_pago_tercero_id = $(Fila).find("input[name=forma_pago_tercero_id]").val();
		
	var QueryString   = "ACTIONCONTROLER=onclickDelete&forma_pago_id="+forma_pago_id+"&forma_pago_tercero_id="+forma_pago_tercero_id;
	
	if (forma_pago_tercero_id.length > 0){
			$.ajax({
				   
				url        : "TerceroFormaPagoClass.php",
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
function autocompleteTercero(){
	
	$("input[name=tercero]").autocomplete("../../../framework/clases/ListaInteligente.php?consulta=tercero", {
		width: 260,
		selectFirst: true
	});
	
	$("input[name=tercero]").result(function(event, data, formatted) {				   
		if (data){
			var numero_identificacion = data[0].split("-");
			$(this).val($.trim(numero_identificacion[0]));
			$(this).attr("title",data[0]);
			$(this).next().val(data[1]);
			
   		    var txtNext = false;			
			
            $(this.parentNode.parentNode).find("input[name!=puc]&&input[name!=tercero]&&input[type=text]").each(function(){
               if(this.readOnly == false && txtNext == false){
				   this.focus();
				   txtNext = true;
			   }
			   
            });			
		}
	});
	
}
