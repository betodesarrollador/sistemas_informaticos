// JavaScript Document
$(document).ready(function(){
	linkDetallesSolicitud();
});

function saveDetalleSolicitud(obj){
	
	var row = obj.parentNode.parentNode;
	
	if(validaRequeridosDetalle(obj,row)){
	  
	  var Celda                        = obj.parentNode;
	  var Fila                         = Celda.parentNode;
	  var Tabla                        = Fila.parentNode;
	  var impuesto_id                  = $("#impuesto_id").val();
	  var impuesto_periodo_contable_id = $(Fila).find("input[name=impuesto_periodo_contable_id]").val();	  
	  
	  var  periodo_contable_id         = $(Fila).find("select[name=periodo_contable_id] option:selected").val();
	  var  porcentaje                  = $(Fila).find("input[name=porcentaje]").val();
	  var  formula                     = $(Fila).find("input[name=formula]").val();
	  var  monto                       = $(Fila).find("input[name=monto]").val();
	  var  checkProcesar               = $(Fila).find("input[name=procesar]");
	
	  if(!impuesto_periodo_contable_id.length > 0){
	    
	    if( $('#guardar',parent.document).length > 0 ){
	      
	      detalle_ss_id   = 'NULL';
	      
	      var QueryString = "ACTIONCONTROLER=onclickSave&impuesto_periodo_contable_id="+impuesto_periodo_contable_id+"&periodo_contable_id="+
		  periodo_contable_id+"&porcentaje="+porcentaje+"&formula="+formula+"&monto="+monto+'&impuesto_id='+impuesto_id;
	      
				      
	      $.ajax({
		      url        : "DetalleImpuestosClass.php",
		      data       : QueryString,
		      beforeSend : function(){
			    setMessageWaiting();
		      },
		      success    : function(response){
		      
			      if(!isNaN(response)){
				
				      $(Fila).find("input[name=impuesto_periodo_contable_id]").val(response);				      
				      checkProcesar.attr("checked","");
				      $(Celda).removeClass("focusSaveRow");
				      
				      insertaFilaAbajoClon(Tabla);
				      checkRow();
				      linkDetallesSolicitud();
				      updateGrid();
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
	  
	      var QueryString = "ACTIONCONTROLER=onclickUpdate&impuesto_periodo_contable_id="+impuesto_periodo_contable_id+"&periodo_contable_id="+
		  periodo_contable_id+"&porcentaje="+porcentaje+"&formula="+formula+"&monto="+monto+'&impuesto_id='+impuesto_id;
		
		$.ajax({
			url        : "DetalleImpuestosClass.php",
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
		
	}//find el permiso de actalizar
	
     }//fin detalle_ss_id.length
     
  }//fin de validaRequeridosDetalle	
  
}

function deleteDetalleSolicitud(obj){
	
	var Celda                        = obj.parentNode;
	var Fila                         = obj.parentNode.parentNode;
	var impuesto_id                  = $("#impuesto_id").val();
	var impuesto_periodo_contable_id = $(Fila).find("input[name=impuesto_periodo_contable_id]").val();
		
	var QueryString   = "ACTIONCONTROLER=onclickDelete&impuesto_id="+impuesto_id+"&impuesto_periodo_contable_id="+impuesto_periodo_contable_id;
	
	if(impuesto_periodo_contable_id.length > 0){
		if( $('#borrar',parent.document).length > 0 ){
			$.ajax({
				   
				url        : "DetalleImpuestosClass.php",
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
	
		saveDetalleSolicitud(this);
	
	});
}
function deleteDetallesSoliServi(){
  
	$("input[name=procesar]:checked").each(function(){
	
		deleteDetalleSolicitud(this);
	
	});
}	
    
	
function updateGrid(){
	
	parent.document.getElementById("refresh_QUERYGRID_impuesto").click();
	
}
/***************************************************************
  Funciones para el objeto de guardado en los edtalles de ruta
***************************************************************/
function linkDetallesSolicitud(){
	$("a[name=saveDetalleSoliServi]").attr("href","javascript:void(0)");
	
	$("a[name=saveDetalleSoliServi]").focus(function(){
		var celda = this.parentNode;
		$(celda).addClass("focusSaveRow");
    });
	
	$("a[name=saveDetalleSoliServi]").blur(function(){
		var celda = this.parentNode;
		$(celda).removeClass("focusSaveRow");
    });
	
	$("a[name=saveDetalleSoliServi]").click(function(){
		saveDetalleSolicitud(this);
    });
	
}