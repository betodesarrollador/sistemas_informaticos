// JavaScript Document
$(document).ready(function(){
	linkDetalles();
	autocompleteTercero();	
});

function saveDetalle(obj){
	
	var row = obj.parentNode.parentNode;
	if(validaRequeridosDetalle(obj,row)){
	var Celda						= obj.parentNode;
	var Fila						= Celda.parentNode;
	var Tabla						= Fila.parentNode;
	var acta_id						= $("#acta_id").val();
	var participantes_actas_id		= $(Fila).find("input[name=participantes_actas_id]").val();	  	  
	var participante				= $(Fila).find("input[name=participante]").val();
	var tipo_participante			= $(Fila).find("select[name=tipo_participante] option:selected").val();
	var checkProcesar				= $(Fila).find("input[name=procesar]");
	console.log(participantes_actas_id,' si');
	  	
	  if(!participantes_actas_id.length > 0){
	    	      	      
	      var QueryString = "ACTIONCONTROLER=onclickSave&participantes_actas_id="+participantes_actas_id+"&participante="+
		  participante+'&acta_id='+acta_id+'&tipo_participante='+tipo_participante;
	      
	      $.ajax({
		      url        : "ParticipantesActaClass.php",
		      data       : QueryString,
		      beforeSend : function(){
			    setMessageWaiting();
		      },
		      success    : function(response){
		      
			      if(!isNaN(response)){
				
		      
				      setMessage('Se guardo exitosamente.');
				      checkProcesar.attr("checked","");
				      $(Celda).removeClass("focusSaveRow");
				      
				      insertaFilaAbajoClon(Tabla);
					  autocompleteTercero()
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
       
	  
	      var QueryString = "ACTIONCONTROLER=onclickUpdate&participantes_actas_id="+participantes_actas_id+"&participante="+
		  participante+'&acta_id='+acta_id+'&tipo_participante='+tipo_participante;
		
		$.ajax({
			url        : "ParticipantesActaClass.php",
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
	var participantes_actas_id = $(Fila).find("input[name=participantes_actas_id]").val();
		
	var QueryString   = "ACTIONCONTROLER=onclickDelete&acta_id="+acta_id+"&participantes_actas_id="+participantes_actas_id;
	
	if (participantes_actas_id.length > 0){
			$.ajax({
				   
				url        : "ParticipantesActaClass.php",
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
