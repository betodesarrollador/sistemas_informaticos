// JavaScript Document
$(document).ready(function(){

	/*$('#tipo_servicio_mensajeria_id').attr("disabled","");
	$('#tipo_envio_id').attr("disabled","");
	$('#periodo').attr("disabled","");
	$('#porcentaje_seguro').attr("disabled","");
	$('#vr_kg_inicial_min').attr("disabled","");
	$('#vr_kg_inicial_max').attr("disabled","");
	$('#vr_kg_adicional_min').attr("disabled","");
	$('#vr_kg_adicional_max').attr("disabled","");*/
	$('#guardar').attr("disabled","");
	$('#actualizar').attr("disabled","true");
	$('#borrar').attr("disabled","true");
	$('#limpiar').attr("disabled","");
	$('#duplicar').attr("disabled","");
	
	$("#tipo_servicio_mensajeria_id").change(function(){
		getOptionsTipoEnvio();
	});	
	
	
});

function getOptionsTipoEnvio(){

	var TipoServicioId   = $("#tipo_servicio_mensajeria_id").val();
	var QueryString = "ACTIONCONTROLER=getOptionsTipoEnvio&tipo_servicio_mensajeria_id="+TipoServicioId;

	if(TipoServicioId != 'NULL'){
	
		$.ajax({
			url     : "../../../mensajeria/operacion/clases/GuiaClass.php",
			data    : QueryString,
			success : function(response){
				$("#tipo_envio_id").parent().html(response);
			}
		});
	}
}

function onclickDuplicar(formulario){
	
	if($("#divDuplicar").is(":visible")){
	 
	   var tipo_servicio_mensajeria_id 	= $("#tipo_servicio_mensajeria_id").val();
	   var periodo   					= $("#periodo").val();
	   var periodo_final   				= $("#periodo_final").val();
	   	
	var QueryString = "ACTIONCONTROLER=onclickDuplicar&"+FormSerialize(formulario);
	
	$.ajax({
       url        : "TarifasMensajeriaClass.php",
	   data       : QueryString,
	   beforeSend : function(){
		 showDivLoading();
	   },
	   success : function(response){
		   
		   try{
				var data	= $.parseJSON(response);
				if(response=='true'){
					alertJquery('Tarifas Duplicadas Exitosamente',"Tarifas Mensajeria");
				}else{
					alertJquery('Error al Duplicar Tarifas.',"Tarifas Mensajeria");					
				}
			}catch(e){
				alertJquery(response,"Error");
			}	
						 
	     removeDivLoading();			 
	     }
		 
	 });
	
    }else{
		
		    $("#divDuplicar").dialog({
			  title: 'Duplicar Tarifas Mensajeria',
			  width: 450,
			  height: 280,
			  closeOnEscape:true
             });
			
		
	}  
	  
}
function setDataFormWithResponse(){
	
	var tarifas_especiales_id	=  document.getElementById("tarifas_especiales_id").value;
	var forma 		= document.forms[0];
	var QueryString = "ACTIONCONTROLER=OnClickFind&tarifas_especiales_id="+tarifas_especiales_id;
	$.ajax({
		url        : "TarifasEspecialClass.php?rand="+Math.random(),
		data       : QueryString,
		beforeSend : function(){
			showDivLoading();
		},
		
		success    : function(resp){
			
			try{
				var data	= $.parseJSON(resp);
				if(isNaN(parseInt(data[0]['tarifas_especiales_id']))){
					TarifasEspecialesOnReset(forma);
					return false;
				}
				setFormWithJSON(forma,data);
				if($('#guardar'))		$('#guardar').attr("disabled","true");
				if($('#actualizar'))	$('#actualizar').attr("disabled","");
				if($('#borrar'))		$('#borrar').attr("disabled","");
				if($('#limpiar'))		$('#limpiar').attr("disabled","");
				if($('#duplicar'))		$('#duplicar').attr("disabled","");				
				//$('#tipo_servicio_mensajeria_id').attr("disabled","true");
				//$('#tipo_envio_id').attr("disabled","true");
				//$('#periodo').attr("disabled","true");
			}catch(e){
				alertJquery(resp,"Error :"+e);
			}
			removeDivLoading();
		}
	});
}

function TarifasEspecialesOnReset(){

	var form 		= document.forms[0];
	clearFind();
	Reset(form);
	/*$('#tipo_servicio_mensajeria_id').attr("disabled","");
	$('#tipo_envio_id').attr("disabled","");
	$('#periodo').attr("disabled","");
	$('#porcentaje_seguro').attr("disabled","");
	$('#vr_kg_inicial_min').attr("disabled","");
	$('#vr_kg_inicial_max').attr("disabled","");
	$('#vr_kg_adicional_min').attr("disabled","");
	$('#vr_kg_adicional_max').attr("disabled","");*/
	if($('#guardar'))    $('#guardar').attr("disabled","");
	if($('#actualizar')) $('#actualizar').attr("disabled","true");
	if($('#borrar'))     $('#borrar').attr("disabled","true");
	if($('#limpiar'))    $('#limpiar').attr("disabled","");
	if($('#duplicar'))   $('#duplicar').attr("disabled","");
}

function OnClickSave(formulario){
	if(ValidaRequeridos(formulario)){

		var tarifas_especiales_id = document.getElementById("tarifas_especiales_id").value;
		var origen= document.getElementById("origen").value;
		var destino= document.getElementById("destino").value;
		var valor_primerKg = document.getElementById("valor_primerKg").value;
		var valor_adicionalKg = document.getElementById("valor_adicionalkg").value;
		var tipo_envio_id = document.getElementById("tipo_envio_id").value;

		// var QueryString		= "ACTIONCONTROLER=OnClickSave&tipo_servicio_mensajeria_id="+tipo_servicio_mensajeria_id+"&tipo_envio_id="+tipo_envio_id+
		// "&periodo="+periodo+"&porcentaje_seguro="+porcentaje_seguro+"&vr_kg_inicial_min="+vr_kg_inicial_min+"&vr_kg_inicial_max="+vr_kg_inicial_max+
		// "&vr_kg_adicional_min="+vr_kg_adicional_min+"&vr_kg_adicional_max="+vr_kg_adicional_max+"&vr_min_declarado="+vr_min_declarado;
		var QueryString		= "ACTIONCONTROLER=OnClickSave&"+FormSerialize(formulario);

		$.ajax({
			url			: "TarifasEspecialClass.php?rand="+Math.random(),
			data		: QueryString,
			beforeSend	: function(){
				showDivLoading();
			},
			success    : function(resp){
				try{
					$("#refresh_QUERYGRID_TarifasEspecialeses").click();
				 	TarifasEspecialesOnReset(formulario);
					alertJquery(resp,"Tarifas Especiales");
				}catch(e){
					alertJquery(resp,"Error :"+e);
				}
				removeDivLoading();
			}
		});
	}
}

function OnClickUpdate(formulario){
	if(ValidaRequeridos(formulario)){
		
		var tarifas_especiales_id = document.getElementById("tarifas_especiales_id").value;
		var origen= document.getElementById("origen").value;
		var destino= document.getElementById("destino").value;
		var valor_primerKg = document.getElementById("valor_primerKg").value;
		var valor_adicionalKg = document.getElementById("valor_adicionalkg").value;
		var tipo_envio_id = document.getElementById("tipo_envio_id").value;
		
		var QueryString = "ACTIONCONTROLER=OnClickUpdate&"+FormSerialize(formulario);
		$.ajax({
			url			: "TarifasEspecialClass.php?rand="+Math.random(),
			data		: QueryString,
			beforeSend	: function(){
				showDivLoading();
			},
			success    : function(resp){
				try{
					$("#refresh_QUERYGRID_TarifasEspeciales").click();
					TarifasEspecialesOnReset(formulario);
					alertJquery(resp,"Tarifas Especial");
				}catch(e){
					alertJquery(resp,"Error :"+e);
				}
				removeDivLoading();
			}
		});
	}
}

function OnClickDelete(formulario){
	if(ValidaRequeridos(formulario)){
		var QueryString = "ACTIONCONTROLER=OnClickDelete&"+FormSerialize(formulario);
		$.ajax({
			url			: "TarifasEspecialClass.php?rand="+Math.random(),
			data		: QueryString,
			beforeSend	: function(){
				showDivLoading();
			},
			success    : function(resp){
				try{
					$("#refresh_QUERYGRID_TarifasEspeciales").click();
					TarifasEspecialesOnReset(formulario);
					alertJquery(resp,"Tarifas Especiales");
				}catch(e){
					alertJquery(resp,"Error :"+e);
				}
				removeDivLoading();
			}
		});
	}
}