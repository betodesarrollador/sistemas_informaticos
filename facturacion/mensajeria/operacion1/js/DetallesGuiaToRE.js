$(document).ready(function(){	
		checkedAlls();	
		$("#codigo_barras1").focus();
		leercodigobar();
});
// JavaScript Document
function saveDetallesReexpedido(){
	$("input[type=checkbox]:checked").each(function(){														
		saveDetalleReexpedido(this);	
	});	
}

function saveDetalleReexpedido(obj){	
	clearFind();	
	var guia_id     = obj.value;
	var reexpedido_id = $("#reexpedido_id").val();	
	var QueryString = "ACTIONCONTROLER=onclickSave&guia_id="+guia_id+"&reexpedido_id="+reexpedido_id;	
	$.ajax({
		url        : "DetallesGuiaToREClass.php?rand="+Math.random(),
		data       : QueryString,
		beforeSend : function(){},
		success    : function(resp){		
			if(!isNaN(resp)){		
				$(obj).attr("checked","");
               	$("#refresh_QUERYGRID_DetallesGuiaToRE").click();				
			}else{
				alertJquery(resp);
			}			
    	parent.parent.loadDetalle();				
		}
	});	
}


function leercodigobar(){

	var inputStart, inputStop, firstKey, lastKey, timing, userFinishedEntering;
	var minChars = 1;
	
	// handle a key value being entered by either keyboard or scanner
	$("#codigo_barras1").keypress(function (e) {
		// restart the timer
		if (timing) {
			clearTimeout(timing);
		}
	
		// handle the key event
		if (e.which == 13) {
			// Enter key was entered
	
			// don't submit the form
			e.preventDefault();
	
			// has the user finished entering manually?
			if ($("#codigo_barras1").val().length >= minChars){

				if(document.getElementById('codigo_barras1').value!=''){
					
					if(document.getElementById(document.getElementById('codigo_barras1').value)){ 
						document.getElementById(document.getElementById('codigo_barras1').value).checked=true;
						$("#mensaje_alerta").html("Guia "+document.getElementById('codigo_barras1').value+" Seleccionada");
						
					}else{
						$("#mensaje_alerta").html("Guia "+document.getElementById('codigo_barras1').value+" No encontrada");
					}
				}

				$("#codigo_barras1").val('');
				$("#codigo_barras1").focus();		
				
			}
		}
	});
}

function checkedAlls(){
	
   $("#checkedAllss").click(function(){ 
								   
							   								   
      if($(this).is(":checked")){
		$("input[name=procesar]").attr("checked","true");
      }else{
  		  $("input[name=procesar]").attr("checked","");
		}
								   
   });

}
