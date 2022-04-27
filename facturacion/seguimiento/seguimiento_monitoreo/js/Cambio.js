// JavaScript Document
$(document).ready(function(){
	
	$("#actualizar").click(function(){
		var trafico_id  = $("#trafico_id").val();
		var ruta_id  = $("#ruta_id").val();
		var ordenar  = $("#ordenar").val();
		if(ordenar!='NULL' && ruta_id!='NULL' && parseInt(trafico_id) >0){
									
		    var iframeDetalles = document.getElementById('detalles_cambio');
									
		
			
	
	var n = $(iframeDetalles.contentDocument).find("input[id!=checkedAll]&&input[name=procesar]:checked").length;
	var cont =0;
	
	$(iframeDetalles.contentDocument).find("input[name=procesar]:checked").each(function(){
																						 
			var row = this.parentNode.parentNode;
					
			if(validaRequeridosDetalle(this,row)){
				
				var Celda               = this.parentNode;
				var Fila                = this.parentNode.parentNode;
				var trafico_id      	= $(iframeDetalles.contentDocument).find("input[id=trafico_id]").val();
				var detalle_ruta_id     = $(Fila).find("input[name=detalle_ruta_id]").val();
				var ubicacion_id        = $(Fila).find("input[name=ubicacion_id]").val();
				var punto_referencia    = $(Fila).find("input[name=punto_referencia]").val();
				var punto_referencia_id = $(Fila).find("input[name=punto_referencia_id]").val();
				var orden_det_ruta		= $(Fila).find("input[name=orden_det_ruta]").val();
				var checkProcesar       = $(Fila).find("input[name=procesar]");
				
				if(detalle_ruta_id.length > 0){
					
						var QueryString = "ACTIONCONTROLER=onclickSave&trafico_id="+trafico_id+"&detalle_ruta_id="+detalle_ruta_id+
						"&ubicacion_id="+ubicacion_id+"&punto_referencia="+punto_referencia+"&punto_referencia_id="
						+punto_referencia_id+"&orden_det_ruta="+orden_det_ruta;						
												
						$.ajax({
							
							url        : "DetallePuntosClass.php",
							data       : QueryString,
							beforeSend : function(){
							  showDivLoading();
							},
							success    : function(response){

								if(!isNaN(response)){
		
									cont++;
																		
									if(parseInt(cont)==parseInt(n)){																		
									  alert('cierrate');
									  removeDivLoading();
									  parent.closeDialogCambios();
									}
		
														
								}else{
									alertJquery(response);
								}
							}/*fin del success*/
						});

				}
			}
	});			

			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
		}else{
			alertJquery('Por favor Seleccione Ruta y Orden');	
		}
	});

});


function Rutatipo(){
	var trafico_id  = $("#trafico_id").val();
	var ruta_id  = $("#ruta_id").val();
	var ordenar  = $("#ordenar").val();
	if(ordenar!='NULL' && ruta_id!='NULL' && parseInt(trafico_id) >0){
		var url         = "DetallePuntosClass.php?trafico_id="+trafico_id+"&ruta_id="+ruta_id+"&ordenar="+ordenar+"&rand="+Math.random();
		$("#detalles_cambio").attr("src",url);
	}
	
}
