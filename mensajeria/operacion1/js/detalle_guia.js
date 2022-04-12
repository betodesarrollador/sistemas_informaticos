// JavaScript Document
$(document).ready(function(){
	autocompleteCodigoProducto();
	linkDetallesGuia();	
});

function saveDetalleGuia(obj){
	
	var row = obj.parentNode.parentNode;
	
	if(validaRequeridosDetalle(obj,row)){
	  
	  var Celda                  = obj.parentNode;
	  var Fila                   = Celda.parentNode;
	  var Tabla                  = Fila.parentNode;
	  var guia_id 	        	 = $("#guia_id").val();	  
	  var detalle_guia_id 		 = $(Fila).find("input[name=detalle_guia_id]").val();
	  var detalle_ss_id 	     = $(Fila).find("input[name=detalle_ss_id]").val();
	  var referencia_producto    = $(Fila).find("input[name=referencia_producto]").val();	  
	  var descripcion_producto   = $(Fila).find("input[name=descripcion_producto]").val();	  
	  var largo 	             = $(Fila).find("input[name=largo]").val();
	  var ancho 	             = $(Fila).find("input[name=ancho]").val();
	  var alto 	                 = $(Fila).find("input[name=alto]").val();
	  var peso_volumen 	         = $(Fila).find("input[name=peso_volumen]").val();
	  var peso 	                 = $(Fila).find("input[name=peso]").val();
	  var cantidad 	             = $(Fila).find("input[name=cantidad]").val();
	  var valor 	             = $(Fila).find("input[name=valor]").val();
	  var guia_cliente 	         = $(Fila).find("input[name=guia_cliente]").val();
	  var observaciones 	     = $(Fila).find("input[name=observaciones]").val(); 
	  var checkProcesar          = $(Fila).find("input[name=procesar]");	  	
				
	  if(!parseInt(detalle_guia_id) > 0){
		  		  	    
	    if( $('#guardar',parent.document).length > 0 ){
	      
	      detalle_guia_id= 'NULL';
	      
	      var QueryString  = "ACTIONCONTROLER=onclickSave&detalle_guia_id="+detalle_guia_id+"&guia_id="+guia_id+"&detalle_ss_id="+detalle_ss_id+"&descripcion_producto="+descripcion_producto+"&referencia_producto="+referencia_producto+"&largo="+largo+"&ancho="+ancho+"&alto="+alto+"&peso_volumen="+peso_volumen+"&peso="+peso+"&cantidad="+cantidad+"&valor="+valor+"&guia_cliente="+guia_cliente+
		  "&observaciones="+observaciones;	      
				      
	      $.ajax({
		      url        : "DetalleGuiaClass.php",
		      data       : QueryString,
		      beforeSend : function(){
			     showDivLoading();
		      },
		      success    : function(response){
		      
			      if(!isNaN(response)){
				
				      $(Fila).find("input[name=detalle_guia_id]").val(response);				      
				      checkProcesar.attr("checked","");
				      $(Celda).removeClass("focusSaveRow");
				      
				      insertaFilaAbajoClon(Tabla);
				      checkRow();
				      autocompleteCodigoProducto();
				      linkDetallesGuia();
				      updateGrid();
				      setMessage('Se guardo exitosamente.');
		      
			      }else{
				      alertJquery(response);
			      }			      
			    removeDivLoading();  
		      }		      
	      });
	      
	}//fin del permiso de guardar
	
     }else{
       
	if( $('#actualizar',parent.document).length > 0 ){
	  	      
	      var QueryString  = "ACTIONCONTROLER=onclickUpdate&detalle_guia_id="+detalle_guia_id+"&guia_id="+guia_id+
		  "&detalle_ss_id="+detalle_ss_id+"&descripcion_producto="+descripcion_producto+"&referencia_producto="+referencia_producto+"&largo="+
		  largo+"&ancho="+ancho+"&alto="+alto+"&peso_volumen="+peso_volumen+"&peso="+peso+"&cantidad="+cantidad+"&valor="+
		  valor+"&guia_cliente="+guia_cliente+"&observaciones="+observaciones;	
		
		$.ajax({
			url        : "DetalleGuiaClass.php",
			data       : QueryString,
			beforeSend : function(){
			  showDivLoading();
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
		       
			   removeDivLoading();
		       }
		});
		
	}//find el permiso de actalizar	
     }//fin detalle_ss_id.length     
  }//fin de validaRequeridosDetalle	  
}

function deleteDetalleGuia(obj){
	
	var Celda             = obj.parentNode;
	var Fila              = obj.parentNode.parentNode;	
	var detalle_guia_id = $(Fila).find("input[name=detalle_guia_id]").val();
		
	var QueryString   = "ACTIONCONTROLER=onclickDelete&detalle_guia_id="+detalle_guia_id;
		
	if(parseInt(detalle_guia_id) > 0){
		
		if( $('#borrar',parent.document).length > 0 ){
			
			$.ajax({
				   
				url        : "DetalleGuiaClass.php",
				data       : QueryString,
				beforeSend : function(){
				  showDivLoading();
				},
				success    : function(response){
					
					if( $.trim(response) == 'true'){
												
						$(Fila).remove();
						updateGrid();
						setMessage('Se borro exitosamente.'); 
						
					}else{
						alertJquery(response);
					}					
				    removeDivLoading(); 
				}
			});
			
		}
	}else{
		alertJquery('No puede eliminar elementos que no han sido guardados');
		$(Fila).find("input[name=procesar]").attr("checked","");
	}
}

function saveDetallesGuia(){	
	$("input[name=procesar]:checked").each(function(){	
		saveDetalleGuia(this);	
	});
}

function deleteDetallesGuia(){  
	$("input[name=procesar]:checked").each(function(){	
		deleteDetalleGuia(this);	
	});
}	
    
/***************************************************************
	  lista inteligente para la ubicacion con jquery
**************************************************************/

/**
* lista inteligente para el
* autocomplete de productos
*/
function autocompleteCodigoProducto(){
	
	$("input[name=codigo]").autocomplete("/velotax/framework/clases/ListaInteligente.php?consulta=producto", {
		width: 400,
		selectFirst: true
	});
	
	$("input[name=codigo]").result(function(event, data, formatted) {
		if(data){
			
			var Fila = this.parentNode.parentNode;
			var cadena = $(this).val().split('-');
			
			$(this).next().val(data[1]);
			$(this).val(cadena[0]);
			$(Fila).find("input[name=descripcion_producto]").val(cadena[1]);
			$(Fila).find("[name=descripcion_producto]").focus();			
			
		}
	});
	
}

/***************************************************************
  Funciones para el objeto de guardado en los edtalles de ruta
***************************************************************/
function linkDetallesGuia(){

	$("a[name=saveDetalleGuia]").attr("href","javascript:void(0)");
	
	$("a[name=saveDetalleGuia]").focus(function(){
		var celda = this.parentNode;
		$(celda).addClass("focusSaveRow");
    });
	
	$("a[name=saveDetalleGuia]").blur(function(){
		var celda = this.parentNode;
		$(celda).removeClass("focusSaveRow");
    });
	
	$("a[name=saveDetalleGuia]").click(function(){
		saveDetalleGuia(this);
    });
	
}