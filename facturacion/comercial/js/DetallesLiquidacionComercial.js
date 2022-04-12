
$(document).ready(function(){

   
	suma_cantidad();	
	//autocompleteRemesa();	
	
});

function viewDocument(encabezado_registro_id){
	
  var QueryString = "../../../contabilidad/reportes/clases/LibrosAuxiliaresClass.php?ACTIONCONTROLER=viewDocument&encabezado_registro_id="+encabezado_registro_id;
  var title       = "Visualizacion DOcumento Contable";
  var width       = 900;
  var height      = 600;
    
  popPup(QueryString,title,width,height);  
	
}

function suma_cantidad(){
	
	$("input[name=valor_pago]").keyup(function() {	
		var Fila        = $(this).parent().parent();
		var valor 		= removeFormatCurrency($(Fila).find("input[name=valor_pago]").val());	
		var porcentaje 	= removeFormatCurrency($(Fila).find("input[name=porcentaje]").val());
		console.log(valor+"--"+porcentaje);
		if(valor!='' && valor!=0  && porcentaje!='' && porcentaje!=0){
			console.log("++++");
			var total= ((valor)*(porcentaje))/100;
			//alert(porcentaje);

			$(Fila).find("input[name=total_comision]").val(setFormatCurrency(total));
		}

	});	

	$("input[name=porcentaje]").keyup(function() {	
		var Fila        = $(this).parent().parent();															   
		var valor 		= $(Fila).find("input[name=valor_pago]").val();	
		var porcentaje 	= removeFormatCurrency($(Fila).find("input[name=porcentaje]").val());
		
		if(valor!='' && valor!=0  && porcentaje!='' && porcentaje!=0){
			var total= (removeFormatCurrency(valor)*(porcentaje))/100;
			//alert(porcentaje);
			
			$(Fila).find("input[name=total_comision]").val(setFormatCurrency(total));
		}

	});			


}


function saveDetallesLiquidacion(){

  $("input[name=procesar]:checked").each(function(){
 
     saveLiquidacion(this);

  });
}

function saveLiquidacion(obj){
		
			var Celda               = obj.parentNode;
			var Fila                = obj.parentNode.parentNode;
			
			var comercial_id	    = $(Fila).find("input[name=comercial_id]").val();
			var cliente_id       	= $(Fila).find("input[name=cliente_id]").val();
			var desde    			= $(Fila).find("input[name=desde]").val();
			var hasta          		= $(Fila).find("input[name=hasta]").val();		
			var tipo 				= $(Fila).find("input[name=tipo]").val();
	        var valor               = removeFormatCurrency($(Fila).find("input[name=total_comision]").val());
			var porcentaje 			= $(Fila).find("input[name=porcentaje]").val();
			
			
			
			var QueryString = "ACTIONCONTROLER=SaveComision&comercial_id="+comercial_id+"&cliente_id="+cliente_id+"&desde="+desde+"&hasta="+hasta+"&tipo="+tipo+"&valor="+valor+"&porcentaje="+porcentaje;
			
			$.ajax({
						
						url        : "DetallesLiquidacionClass.php",
						data       : QueryString,
						beforeSend : function(){
						  
						  
						},
						success    : function(response){
							
							try{
									alertJquery("¡Liquidacion Comisiones Exitosa!",response);
							}catch(e){
							  alertJquery(e);
							}
								
						}/*fin del success*/
						
					});
	
}