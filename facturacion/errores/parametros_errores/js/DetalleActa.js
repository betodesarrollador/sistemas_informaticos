// JavaScript Document
$(document).ready(function(){
	linkDetalles();
	autocompletePuc();
});
function saveDetalle(obj){
	
	var row = obj.parentNode.parentNode;
	if(validaRequeridosDetalle(obj,row)){
	  var Celda					= obj.parentNode;
	  var Fila					= Celda.parentNode;
	  var Tabla					= Fila.parentNode;
	  var acta_id				= $("#acta_id").val();
	  var tema_id				= $(Fila).find("input[name=tema_id]").val();	  	  
	  var tema					= $(Fila).find("input[name=tema]").val();
	  var checkProcesar         = $(Fila).find("input[name=procesar]");
	  	
	  if(!tema_id.length > 0){
	    	      	      
	      var QueryString = "ACTIONCONTROLER=onclickSave&tema_id="+tema_id+"&acta_id="+
		  acta_id+"&tema="+tema;
	      
	      $.ajax({
		      url        : "DetalleActaClass.php",
		      data       : QueryString,
		      beforeSend : function(){
			    setMessageWaiting();
		      },
		      success    : function(response){
				removeDivLoading();
			      if(!isNaN(response)){
				
				      setMessage('Se guardo exitosamente.');
				      $(Fila).find("input[name=tema_id]").val(response);				      
				      checkProcesar.attr("checked","");
				      $(Celda).removeClass("focusSaveRow");
				      
				      insertaFilaAbajoClon(Tabla);
					  autocompletePuc()
				      checkRow();
				      linkDetalles();
				      updateGrid();
		      
			      }else{
				      setMessage(response);
					  alert(response)
			      }
			      
			      
		      }
		      
	      });
	      
	
     }else{
       
	  
	      var QueryString = "ACTIONCONTROLER=onclickUpdate&tema_id="+tema_id+"&acta_id="+
		  acta_id+"&tema="+tema;
		
		$.ajax({
			url        : "DetalleActaClass.php",
			data       : QueryString,
			beforeSend : function(){
			  setMessageWaiting();
			},
			success    : function(response){
			    if( $.trim(response) == 'true'){
				  setMessage('Se actualizo exitosamente.');  
			      checkProcesar.attr("checked","");
			      $(Celda).removeClass("focusSaveRow");
			      updateGrid();
			      				    
			    }else{
					setMessage(response);
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
	var acta_id       = $("#acta_id").val();
	var tema_id = $(Fila).find("input[name=tema_id]").val();
		
	var QueryString   = "ACTIONCONTROLER=onclickDelete&acta_id="+acta_id+"&tema_id="+tema_id;
	
	if(tema_id.length > 0){
			$.ajax({
				   
				url        : "DetalleActaClass.php",
				data       : QueryString,
				beforeSend : function(){
				  setMessageWaiting();
				},
				success    : function(response){
								  
					if( $.trim(response) == 'true'){
						
						setMessage('Se borro exitosamente.'); 
						$(Fila).remove();
						updateGrid();
						
					}else{
						setMessage(response);
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
	
	$("input[name=puc]").autocomplete("../../../framework/clases/ListaInteligente.php?consulta=cuentas_movimiento_activas", {
		width: 355,
		selectFirst: true
	});
	
	$("input[name=puc]").result(function(event, data, formatted) {
		if (data) $(this).next().val(data[1]);
                $(this).parent().next().find("input").focus();
	});
	
}