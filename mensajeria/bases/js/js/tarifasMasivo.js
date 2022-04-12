// JavaScript Document
$(document).ready(function(){

	$('#tipo_servicio_mensajeria_id').attr("disabled","");
	$('#tipo_servicio_mensajeria_id').val(2);
	$('#periodo').attr("disabled","");
	// $('#porcentaje_seguro').attr("disabled","");
	$('#rango_inicial').attr("disabled","");
	$('#rango_final').attr("disabled","");
	$('#valor_min').attr("disabled","");
	$('#valor_max').attr("disabled","");
	if($('#guardar'))		$('#guardar').attr("disabled","");
	if($('#actualizar'))	$('#actualizar').attr("disabled","true");
	if($('#borrar'))		$('#borrar').attr("disabled","true");
	if($('#limpiar'))		$('#limpiar').attr("disabled","");
	if($('#duplicar'))		$('#duplicar').attr("disabled","");

});

function onclickDuplicar(formulario){
	
	if($("#divDuplicar").is(":visible")){
	 
	   var periodo   					= $("#periodo").val();
	   var periodo_final   				= $("#periodo_final").val();
	   	
	var QueryString = "ACTIONCONTROLER=onclickDuplicar&"+FormSerialize(formulario);
	
	$.ajax({
       url        : "TarifasMasivoClass.php",
	   data       : QueryString,
	   beforeSend : function(){
		 showDivLoading();
	   },
	   success : function(response){
		   
		   
		  try{
				var data	= $.parseJSON(response);
				if(response=='true'){
					alertJquery('Tarifas Duplicadas Exitosamente',"Tarifas Masivo");
				}else{
					alertJquery('Error al Duplicar Tarifas.',"Tarifas Masivo");					
				}
			}catch(e){
				alertJquery(response,"Error");
			}	
						 
	     removeDivLoading();			 
	     }
		 
	 });
	
    }else{
		
		    $("#divDuplicar").dialog({
			  title: 'Duplicar Tarifas Masivo',
			  width: 450,
			  height: 280,
			  closeOnEscape:true
             });
		
	}  
	  
}

function setDataFormWithResponse(){
	var tarifas_masivo_id	=	document.getElementById("tarifas_masivo_id").value;
	var forma				=	document.forms[0];
	var QueryString			=	"ACTIONCONTROLER=OnClickFind&tarifas_masivo_id="+tarifas_masivo_id;
	$.ajax({
		url        : "TarifasMasivoClass.php?rand="+Math.random(),
		data       : QueryString,
		beforeSend : function(){
			showDivLoading();
		},
		success    : function(resp){
			try{
				var data	= $.parseJSON(resp);
				if(isNaN(parseInt(data[0]['tarifas_masivo_id']))){
					TarifasMasivoOnReset(forma);
					return false;
				}
				setFormWithJSON(forma,data);
				if($('#guardar'))		$('#guardar').attr("disabled","true");
				if($('#actualizar'))	$('#actualizar').attr("disabled","");
				if($('#borrar'))		$('#borrar').attr("disabled","");
				if($('#limpiar'))		$('#limpiar').attr("disabled","");
				if($('#duplicar'))		$('#duplicar').attr("disabled","");				
				$('#tipo_servicio_mensajeria_id').attr("disabled","true");
				$('#periodo').attr("disabled","true");
				$('#rango_inicial').attr("disabled","true");
				$('#rango_final').attr("disabled","true");
			}catch(e){
				alertJquery(resp,"Error :"+e);
			}
			removeDivLoading();
		}
	});
}

function TarifasMasivoOnReset(){

	var form 		= document.forms[0];
	clearFind();
	Reset(form);
	$('#tipo_servicio_mensajeria_id').attr("disabled","");
	$('#tipo_servicio_mensajeria_id').val(2);
	$('#periodo').attr("disabled","");
	// $('#porcentaje_seguro').attr("disabled","");
	$('#rango_inicial').attr("disabled","");
	$('#rango_final').attr("disabled","");
	$('#valor_min').attr("disabled","");
	$('#valor_max').attr("disabled","");
	if($('#guardar'))		$('#guardar').attr("disabled","");
	if($('#actualizar'))	$('#actualizar').attr("disabled","true");
	if($('#borrar'))		$('#borrar').attr("disabled","true");
	if($('#limpiar'))		$('#limpiar').attr("disabled","");
	if($('#duplicar'))		$('#duplicar').attr("disabled","");
	
}

function OnClickSave(formulario){
	if(ValidaRequeridos(formulario)){
		var tipo_servicio_mensajeria_id		= document.getElementById("tipo_servicio_mensajeria_id").value;
		var tipo_envio_id		= document.getElementById("tipo_envio_id").value;

		var periodo							= document.getElementById("periodo").value;
		var porcentaje_seguro				= document.getElementById("porcentaje_seguro").value;
		var vr_min_declarado				= document.getElementById("vr_min_declarado").value;
		var rango_inicial					= document.getElementById("rango_inicial").value;
		var rango_final						= document.getElementById("rango_final").value;
		var valor_min						= document.getElementById("valor_min").value;
		var valor_max						= document.getElementById("valor_max").value;
		var QueryString		= "ACTIONCONTROLER=OnClickSave&tipo_servicio_mensajeria_id="+tipo_servicio_mensajeria_id+"&periodo="+periodo+"&porcentaje_seguro="+porcentaje_seguro+"&tipo_envio_id="+tipo_envio_id+"&vr_min_declarado="+vr_min_declarado+"&rango_inicial="+rango_inicial+"&rango_final="+rango_final+"&valor_min="+valor_min+"&valor_max="+valor_max;
		$.ajax({
			url			: "TarifasMasivoClass.php?rand="+Math.random(),
			data		: QueryString,
			beforeSend	: function(){
				showDivLoading();
			},
			success    : function(resp){
				try{
					$("#refresh_QUERYGRID_TarifasMasivo").click();
				 	TarifasMasivoOnReset(formulario);
					alertJquery(resp,"Tarifas Masivo");
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
		var QueryString = "ACTIONCONTROLER=OnClickUpdate&"+FormSerialize(formulario);
		$.ajax({
			url			: "TarifasMasivoClass.php?rand="+Math.random(),
			data		: QueryString,
			beforeSend	: function(){
				showDivLoading();
			},
			success    : function(resp){
				try{
					$("#refresh_QUERYGRID_TarifasMasivo").click();
					TarifasMasivoOnReset(formulario);
					alertJquery(resp,"Tarifas Masivo");
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
			url			: "TarifasMasivoClass.php?rand="+Math.random(),
			data		: QueryString,
			beforeSend	: function(){
				showDivLoading();
			},
			success    : function(resp){
				try{
					$("#refresh_QUERYGRID_TarifasMasivo").click();
					TarifasMasivoOnReset(formulario);
					alertJquery(resp,"Tarifas Masivo");
				}catch(e){
					alertJquery(resp,"Error :"+e);
				}
				removeDivLoading();
			}
		});
	}
}