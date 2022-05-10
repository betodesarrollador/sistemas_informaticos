// JavaScript Document
$(document).ready(function(){
	linkDetalles();
	/*$( ".dtp" ).datepicker({ dateFormat: 'yy-mm-dd' });
	$( ".dtp" ).click(function(){$("#ui-datepicker-div").show(); });
	$( ".default" ).click(function(){$("#ui-datepicker-div").hide(); });*/

	$( ".ui-state-default" ).click(function(){
		$("#ui-datepicker-div").hide(); 
		console.log("21312"); 
	});

	$( ".ui-state-active" ).click(function(){
		console.log("asdasd45"); 
	});

	$( 'td[data-handler="selectDay"]').click(function(){
		$("#ui-datepicker-div").hide(); 
		console.log("654"); 
	});
	
});


function saveDetalleCosto(obj){
	
	var row = obj.parentNode.parentNode;
	
	if(validaRequeridosDetalle(obj,row)){
	  
	  var Celda                            = obj.parentNode;
	  var Fila                             = Celda.parentNode;
	  var Tabla                            = Fila.parentNode;
	  var producto_id		               = $("#producto_id").val();
	  var detalle_precios_id			   = $(Fila).find("input[name=detalle_precios_id]").val();	  	  
	  var fecha                     	   = $(Fila).find("input[name=fecha]").val();
	  var valor	                           = $(Fila).find("input[name=valor]").val();
	  
	 
	  if(!detalle_precios_id.length > 0){
	    
	    if( $('#guardar',parent.document).length > 0 ){
	      	      
	      var QueryString = "ACTIONCONTROLER=onclickSaveCosto&producto_id="+producto_id+"&detalle_precios_id="+
		  detalle_precios_id+"&fecha="+fecha+"&valor="+valor;
	      
				      
	      $.ajax({
		      url        : "DetalleProductoClass.php",
		      data       : QueryString,
		      beforeSend : function(){
			    setMessageWaiting();
		      },
		      success    : function(response){
		      
			      if(!isNaN(response)){
				
				      $(Fila).find("input[name=detalle_precios_id]").val(response);				      
				     
				      $(Celda).removeClass("focusSaveRow");
				      
				      insertaFilaAbajoClon(Tabla);
				      linkDetalles();
				      
				      setMessage('Se guardo exitosamente.');
		      
			      }else{
					  alert(response)
				      setMessage(response);
			      }
		      }
		      
	      });
	      
	}//fin del permiso de guardar
	
     }else{
       
	if( $('#actualizar',parent.document).length > 0 ){
	  
	      var QueryString = "ACTIONCONTROLER=onclickUpdateCosto&producto_id="+producto_id+"&detalle_precios_id="+detalle_precios_id+"&fecha="+fecha+"&valor="+valor;
		
		$.ajax({
			url        : "DetalleProductoClass.php",
			data       : QueryString,
			beforeSend : function(){
			  setMessageWaiting();
			},
			success    : function(response){
			  
			    if( $.trim(response) == 'true'){
				    

			      $(Celda).removeClass("focusSaveRow");
			      setMessage('Se guardo exitosamente.');				    
			    }else{
				    alertJquery(response);
			    }
			   
		       
		       }
		});
		
	}//find el permiso de actalizar
	
     }//fin detalle_ss_id.length
     
  }//fin de validaRequeridosDetalle	
  
}

function saveDetalleVenta(obj){
	
	var row = obj.parentNode.parentNode;
	
	if(validaRequeridosDetalle(obj,row)){
	  
	  var Celda                            = obj.parentNode;
	  var Fila                             = Celda.parentNode;
	  var Tabla                            = Fila.parentNode;
	  var producto_id		               = $("#producto_id").val();
	  var detalle_precios_id			   = $(Fila).find("input[name=detalle_precios_id]").val();	  	  
	  var fecha                     		= $(Fila).find("input[name=fecha]").val();
	  var campo								= $(Fila).find("input[name=valor]").attr('id');

	  var valor	                           = removeFormatCurrencyAmericano($(Fila).find("input[name=valor]").val());
	 
	  if(!detalle_precios_id.length > 0){
	    
	    if( $('#guardar',parent.document).length > 0 ){
	      	      
	      var QueryString = "ACTIONCONTROLER=onclickSaveVenta&producto_id="+producto_id+"&detalle_precios_id="+
		  detalle_precios_id+"&fecha="+fecha+"&valor="+valor+"&campo="+campo;
	      
				      
	      $.ajax({
		      url        : "DetalleProductoClass.php",
		      data       : QueryString,
		      beforeSend : function(){
			    setMessageWaiting();
		      },
		      success    : function(response){
		      
			      if(!isNaN(response)){
				
				      $(Fila).find("input[name=detalle_precios_id]").val(response);				      
				     
				      $(Celda).removeClass("focusSaveRow");
				      
				      insertaFilaAbajoClon(Tabla);
				      linkDetalles();
				      
				      setMessage('Se guardo exitosamente.');
		      
			      }else{
					  alert(response)
				      setMessage(response);
			      }
		      }
		      
	      });
	      
	}//fin del permiso de guardar
	
     }else{
       
	if( $('#actualizar',parent.document).length > 0 ){
	  
	      var QueryString = "ACTIONCONTROLER=onclickUpdateVenta&producto_id="+producto_id+"&detalle_precios_id="+detalle_precios_id+"&fecha="+fecha+"&campo="+campo+"&valor="+valor;
		
		$.ajax({
			url        : "DetalleProductoClass.php",
			data       : QueryString,
			beforeSend : function(){
			  setMessageWaiting();
			},
			success    : function(response){
			  
			    if( $.trim(response) == 'true'){
				    

			      $(Celda).removeClass("focusSaveRow");
			      setMessage('Se guardo exitosamente.');				    
			    }else{
				    alertJquery(response);
			    }
			   
		       
		       }
		});
		
	}//find el permiso de actalizar
	
     }//fin detalle_ss_id.length
     
  }//fin de validaRequeridosDetalle	
  
}


function deleteDetalleSolicitud(obj){
	
	var Celda               = obj.parentNode;
	var Fila                = obj.parentNode.parentNode;
	var tipo_documento_id   = $("#tipo_documento_id").val();
	var consecutivo_documento_oficina_id = $(Fila).find("input[name=consecutivo_documento_oficina_id]").val();
		
	var QueryString   = "ACTIONCONTROLER=onclickDelete&tipo_documento_id="+tipo_documento_id+"&consecutivo_documento_oficina_id="+consecutivo_documento_oficina_id;
	
	if(consecutivo_documento_oficina_id.length > 0){
		if( $('#borrar',parent.document).length > 0 ){
			$.ajax({
				   
				url        : "DetalleProductoClass.php",
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
		}
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
	
	parent.document.getElementById("refresh_QUERYGRID_tipo_de_documento").click();
	
}

/***************************************************************
  Funciones para el objeto de guardado en los edtalles de ruta
***************************************************************/
function linkDetalles(){

	$("a[name=saveDetalleCosto]").attr("href","javascript:void(0)");
	
	$("a[name=saveDetalleCosto]").focus(function(){
		var celda = this.parentNode;
		$(celda).addClass("focusSaveRow");
    });
	
	$("a[name=saveDetalleCosto]").blur(function(){
		var celda = this.parentNode;
		$(celda).removeClass("focusSaveRow");
    });
	
	$("a[name=saveDetalleCosto]").click(function(){
		saveDetalleCosto(this);
    });
	/*-----*/

	$("a[name=saveDetalleVenta]").attr("href","javascript:void(0)");
	
	$("a[name=saveDetalleVenta]").focus(function(){
		var celda = this.parentNode;
		$(celda).addClass("focusSaveRow");
    });
	
	$("a[name=saveDetalleVenta]").blur(function(){
		var celda = this.parentNode;
		$(celda).removeClass("focusSaveRow");
    });
	
	$("a[name=saveDetalleVenta]").click(function(){
		saveDetalleVenta(this);
    });
}