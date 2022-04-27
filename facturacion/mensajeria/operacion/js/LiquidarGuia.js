// JavaScript Document
//eventos asignados a los objetos
$(document).ready(function(){
	
    $("#saveDetallesSoliServi").click(function(){
      window.frames[0].saveDetallesSoliServi();
    });
    
    $("#deleteDetallesSoliServi").click(function(){
	window.frames[0].deleteDetallesSoliServi();
    });

    resetDetalle("detalleSoliServi");
	
});


function setDataFormWithResponse(){
	
    var parametros 	= new Array ({campos:"solicitud_id", valores:$('#solicitud_id').val()});
    var forma 	= document.forms[0];
    var controlador = 'LiquidarRemesasClass.php';
    
    FindRow(parametros,forma,controlador,null,function(resp){
	    
      var solicitudId = $('#solicitud_id').val();
      var url 	    = "DetalleLiquidarRemesasClass.php?solicitud_id="+solicitudId;
      
      $("#detalleSoliServi").attr("src",url);
      
      if($('#guardar'))    $('#guardar').attr("disabled","true");
      if($('#actualizar')) $('#actualizar').attr("disabled","");
      if($('#borrar'))     $('#borrar').attr("disabled","");
      if($('#limpiar'))    $('#limpiar').attr("disabled","");
      
      document.getElementById('cliente_id').disabled = true;	    
      setContactos();
	    
    });
}

function LiquidarRemesasOnSave(formulario,resp){
  	
       try{
	resp = $.parseJSON(resp);
	
	if($.isArray(resp)){
				
		$("#solicitud_id").val(resp[0]['solicitud_id']);
		
		var solicitudId = $('#solicitud_id').val();
		var url 		= "DetalleLiquidarRemesasClass.php?solicitud_id="+solicitudId;
		
		$("#detalleSoliServi").attr("src",url);
		
		if($('#guardar'))    $('#guardar').attr("disabled","true");
		if($('#actualizar')) $('#actualizar').attr("disabled","");
		if($('#borrar'))     $('#borrar').attr("disabled","");
		if($('#limpiar'))    $('#limpiar').attr("disabled","");
		
		updateGrid();
	
	}else{
		alertJquery("Ocurrio una inconsistencia : "+resp);
	}
	
       }catch(e){
	      alertJquery(e);
        }
}


function LiquidarRemesasOnUpdate(formulario,resp){
	
          
	if($.trim(resp) == 'true'){
	  
        alertJquery("Datos guardados Exitosamente","Solicitud de Servicio");
		
		var solicitud_id = $("#solicitud_id").val();
		var url          = "DetalleLiquidarRemesasClass.php?solicitud_id="+solicitud_id;
		
		$("#detalleSoliServi").attr("src",url);
		
		updateGrid();
	
	}else{
		alertJquery(resp,"Solicitud de Servicio");
	}
}


function LiquidarRemesasOnDelete(formulario,resp){
	resetContactos();
	LiquidarRemesasOnReset();
	Reset(formulario);
	clearFind();
	updateGrid();
	alertJquery(resp);
}


function setContactos(){

	var QueryString = "ACTIONCONTROLER=setContactos&cliente_id="+ $("#cliente_id").val()+'&solicitud_id='+$("#solicitud_id").val();
	
	$.ajax({
		url     : "LiquidarRemesasClass.php",
		data    : QueryString,
		success : function(response){			
			$("#contacto_id").parent().html(response);
		}
	});	
}

function LiquidarRemesasOnReset(){
  
    var oficina    = $("#oficina_hidden").val();
    var oficina_id = $("#oficina_id_hidden").val();
    
    resetContactos();
    clearFind();
    resetDetalle("detalleSoliServi");
    
    $('#guardar').attr("disabled","");
    $('#actualizar').attr("disabled","true");
    $('#borrar').attr("disabled","true");
    $('#limpiar').attr("disabled","");
    
    $("#oficina").val(oficina);
    $("#oficina_id").val(oficina_id);	
    $("#fecha_ss").val($("#fecha_ss_static").val());		
    document.getElementById('cliente_id').disabled = false;
	
}


function resetContactos(){
	$("#contacto_id option").each(function(){
		if(this.value != 'NULL') $(this).remove();
	});
}

function getDataManifiestoDespacho(objId,text,obj){

  var formulario  = obj.form;
  var tipo        = text.split(":");
      tipo        = $.trim(tipo[0]);
  var QueryString = "ACTIONCONTROLER=getDataManifiestoDespacho&manifiesto_despacho_id="+objId+"&tipo="+tipo;
  
  $.ajax({
	url        : "LiquidarRemesasClass.php?rand="+Math.random(),
	data       : QueryString,
	beforeSend : function(){
		showDivLoading();
	},
	success    : function(resp){
		
	  var data        = $.parseJSON(resp);
      var QueryString = "manifiesto_despacho_id="+objId+"&tipo="+tipo;

	  setFormWithJSON(formulario,resp,true);
	  
	  document.getElementById('detalleLiquidacionRemesas').src = 'DetalleLiquidacionRemesasClass.php?'+QueryString;
	  
	  removeDivLoading();
	  
    }
	
  });

}