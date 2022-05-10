// JavaScript Document
//variables globales para buscar coincidencia entre origen-destino de las remesas y manifiesto
var contori  =0;
var contdest =0;
var cantRemesas =0;
var ingreso =0; 

$(document).ready(function(){
	
	$("#despachar").click(function(){
		saveDetallesDespacho();
	});
  
});


function saveDetallesDespacho(){
	//para cada una de las remesas checkeadas buscamos origen y destino
	$("input[type=checkbox]:checked").each(function(){
		//contamos cuantas remesas se seleccionaron en total	
		var fecharecogida = valiFechSalida(this);
		var horarecogida = valiHoraSalida(this);
		var tiempo = tiemviaje(this);
		if(fecharecogida && horarecogida && tiempo){
				cantRemesas++;
				ciudades(this);
		}

	});	
		
}

function valiFechSalida(obj){
	var fila = obj.parentNode.parentNode;
	var fecha_estimada_Salida = parent.document.getElementById('fecha_estimada_salida').value;
	var hora_estimada_salida = parent.document.getElementById('hora_estimada_salida').value;
	var fecha_recogida = $(fila).find("td[aria-describedby=QUERYGRID_RemesaToMC_fecha_recogida_ss]").text();
	var hora_recogida = $(fila).find("td[aria-describedby=QUERYGRID_RemesaToMC_hora_recogida_ss]").text();
	
	if(fecha_estimada_Salida < fecha_recogida ){
		alertJquery("La fecha estimada de salida del manifiesto es menor a la fecha de recogida de la remesa. Por favor actualice la fecha de recogida en la remesa seleccionada");	return false;	
	}else{
		return true;
	}
	
}

function valiHoraSalida(obj){
	var fila = obj.parentNode.parentNode;
	var fecha_estimada_Salida = parent.document.getElementById('fecha_estimada_salida').value;
	var hora_estimada_salida = parent.document.getElementById('hora_estimada_salida').value;
	var fecha_recogida = $(fila).find("td[aria-describedby=QUERYGRID_RemesaToMC_fecha_recogida_ss]").text();
	var hora_recogida = $(fila).find("td[aria-describedby=QUERYGRID_RemesaToMC_hora_recogida_ss]").text();
	
	if(fecha_estimada_Salida == fecha_recogida ){
		 if(hora_estimada_salida < hora_recogida){
				alertJquery("La hora estimada de salida del manifiesto es menor a la hora de recogida de la remesa. Por favor actualice la hora de recogida en la remesa seleccionada");
				return false;	
		}else{
			return true;
		}
	}else{
		return true;
	}
}


function validar(){
	//validamos si se hizo la verificacion con todas las remesas
	if(ingreso==cantRemesas){
		//validamos si existe por lo menos un origen y un destino igual
		if (contori==1 && contdest==1){
			$("input[type=checkbox]:checked").each(function(){
				saveDetalleDespacho(this);
			});	
			parent.loadDetalle();		
		}else {
			//creamos el mensaje de que item esta faltando si el origen o el destino
			var mensaje1='';
			var mensaje2='';
			if(contori == 1 && contdest == 0){
				mensaje1 = "Debe incluir al menos una remesa con el mismo destino!!"
			}
			if(contori == 0 && contdest == 1){
				mensaje2 = "Debe incluir al menos una remesa con el mismo origen!!"
			}if(contori == 0 && contdest == 0){
				mensaje2 = "Debe incluir al menos una remesa con el mismo origen Y mismo destino!!"
			}
			alertJquery(mensaje1+"<br>"+mensaje2,"ADVERTENCIA");
			//reiniciamos los contadores 
			contori=0;
			contdest=0;
		}
	}
}

function ciudades(obj){
			
	var remesa_id     = obj.value;
	var manifiesto_id = $("#manifiesto_id").val();
	var origen_id = parent.document.getElementById('origen_hidden').value;
	var destino_id = parent.document.getElementById('destino_hidden').value;

	var QueryString = "ACTIONCONTROLER=onclickOrigDest&remesa_id="+remesa_id+"&manifiesto_id="+manifiesto_id+"&origen_id="+origen_id+"&destino_id="+destino_id;
	
	$.ajax({
		url        : "RemesaToMCClass.php?rand="+Math.random(),
		data       : QueryString,
		beforeSend : function(){},
		success    : function(resp){
		
		try{
			
			data 	= $.parseJSON(resp);
			origen 	=  data[0]['origen'];
			destino =  data[0]['destino'];
			//si el origen es igual al del manifiesto cambiamos el valor de la variable global contori
			if(origen == 1){
				contori = 1;
			}
			//si el destino es igual al del manifiesto cambiamos el valor de la variable global contdest
			if(destino == 1){
				contdest = 1;
			}
			//contamos las veces que se realiza esta validacion para compararla con el total de remesas
			ingreso++;
			//funcion que nos mostrara el mensaje final
			validar();
		}catch(e){
			alertJquery(resp,"Error :");			 
		}
		 
    	
			
		}
	});
}

function tiemviaje(obj){
	var fila = obj.parentNode.parentNode;
	var fecha1 = parent.document.getElementById('fecha_entrega_mcia_mc').value;
	var fecha_recogida1 = $(fila).find("td[aria-describedby=QUERYGRID_RemesaToMC_fecha_recogida_ss]").text();
	var fecha1conver = Date.parse(fecha1);
	var fecha_recogida1conver = Date.parse(fecha_recogida1);
	var dife = fecha1conver - fecha_recogida1conver;
	var numDias = Math.round(dife/(1000*60*60*24));
	//alert("numero de dias:  "+numDias);
	if(numDias > 5){
		alertJquery("La duracion del viaje no puede ser mayor a 5 dias. La fecha de recogida es: "+fecha_recogida1+" y la fecha de entraga es: "+fecha1+"Por favor actualice la fecha de recogida en la remesa.");	
		return false;	
	}else{
		return true;
	}
	
}

function saveDetalleDespacho(obj){
			
	var remesa_id     = obj.value;
	var manifiesto_id = $("#manifiesto_id").val();
	
	var QueryString = "ACTIONCONTROLER=onclickSave&remesa_id="+remesa_id+"&manifiesto_id="+manifiesto_id;
	
	$.ajax({
		url        : "RemesaToMCClass.php?rand="+Math.random(),
		data       : QueryString,
		beforeSend : function(){},
		success    : function(resp){
		
			if(!isNaN(resp)){
				
				$(obj).attr("checked","");
               	$("#refresh_QUERYGRID_RemesaToMC").click();
				
			}else{
				alertJquery(resp);
			}
			
    	parent.loadDetalle();		
			
		}
	});

}