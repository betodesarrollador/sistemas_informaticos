// JavaScript Document
$(document).ready(function(){

	$("#importSolicitud").attr("disabled","true");
	$("#divOrdenServicio").css("display","none");
	$("#divAnulacion").css("display","none");


	$("#importSolicitud").click(function(){
		var desde		=	$("#fecha_inicial").val();
		var hasta		=	$("#fecha_final").val();
		var cierre_crm_id		=	$("#cierre_crm_id").val();

		if ( desde!='' && hasta!='' && parseInt(cierre_crm_id)>0) {
			$("#iframeOrdenServicio").attr("src","SolicCierreToGuiaClass.php?&desde="+desde+"&hasta="+hasta+"&cierre_crm_id="+cierre_crm_id);
			var formulario = document.getElementById('CierreCRMForm');
			$("#divOrdenServicio").dialog({
				title: 'Guias para Liquidar',
				width: 950,
				height: 425,
				closeOnEscape:true,
				show: 'scale',
				hide: 'scale'
			});
		}else{
			alertJquery("Por favor escoja las fechas y Dar un Clic en Guardar ","Validacion");	
		}
	});

	$("#fecha_inicial").change(function(){
		var desde		=	$("#fecha_inicial").val();
		var hasta		=	$("#fecha_final").val();
		if (desde!='' && hasta!='') {
			$("#importSolicitud").attr("disabled","");
		}else{
			$("#importSolicitud").attr("disabled","true");
		}
	});

	$("#fecha_final").change(function(){
		var desde		=	$("#fecha_inicial").val();
		var hasta		=	$("#fecha_final").val();

		if (desde!='' && hasta!='') {
			$("#importSolicitud").attr("disabled","");
		}else{
			$("#importSolicitud").attr("disabled","true");
		}
	});

	$("#guardar").click(function(){
		if (ValidaRequeridos(this.form)) {

			var QueryString = "ACTIONCONTROLER=onclickSave&"+FormSerialize(this.form);
			$.ajax({
			  url        : "CierreCRMClass.php?rand="+Math.random(),
			  data       : QueryString,
			  beforeSend : function(){
				showDivLoading();
			  },
			  success    : function(resp){				   
				  removeDivLoading();
				  LiquidacionOnSave(this.form,resp);					  
			  }
			});				

		}
	});
});

//funcion para cargar los datos desde BUSCAR
function setDataFormWithResponse(cierre_crm_id){	
	var forma 		= document.forms[0];	
	var QueryString = "ACTIONCONTROLER=onclickFind&cierre_crm_id="+cierre_crm_id;	
	$.ajax({
	  url        : "CierreCRMClass.php?rand="+Math.random(),
	  data       : QueryString,
	  beforeSend : function(){
		  showDivLoading();
	  },
	  success    : function(resp){		  
        try{			
		  var data         = $.parseJSON(resp);
		  var estado       = data[0]['estado'];		  		

		  setFormWithJSON(forma,data,false,function(){			
		  
			  if(estado == 'A' || estado == 'F'){
				  if($('#guardar'))    $('#guardar').attr("disabled","true");
				  if($('#anular'))     $('#anular').attr("disabled","true");
			  }else{
				  if($('#guardar'))    $('#guardar').attr("disabled","true");
				  if($('#anular'))     $('#anular').attr("disabled","");
			  }
			  if($('#imprimir'))     $('#imprimir').attr("disabled","");
			  if($('#limpiar'))    $('#limpiar').attr("disabled","");
			  
			  var url = "DetallesCierreGuiaClass.php?cierre_crm_id="+cierre_crm_id+"&rand="+Math.random();
			  $("#detalleLiquidacion").attr("src",url);		
			  
		 });	
		}catch(e){
			alertJquery(resp,"Error :"+e);
		 }	 		  
		 removeDivLoading(); 		 
		 $("input[name=valor]").each(function(){																					   
             setFormatCurrencyInput(this,2);																																	
         });
         	 
		  
       }	  
    });
}

function LiquidacionOnSave(formulario,resp){
  var cierre_crm_id = parseInt(resp);
  if(cierre_crm_id > 0){

	var QueryString = "ACTIONCONTROLER=getConsecutivo&cierre_crm_id="+cierre_crm_id;
	$.ajax({
	  url        : "CierreCRMClass.php?rand="+Math.random(),
	  data       : QueryString,
	  beforeSend : function(){
		showDivLoading();
	  },
	  success    : function(respu){		
		  removeDivLoading();
		  $("#consecutivo").val(respu);					  
		  alertJquery("<span style='font-weight:bold;font-size:14px'>LIQUIDACION : </span><span style='color:red;font-weight:bold;font-size:20px'>"+respu+"</span>","Liquidacion");	
		  
	  }
	});		
	
	var url = "DetallesCierreGuiaClass.php?cierre_crm_id="+cierre_crm_id+"&rand="+Math.random();
	$("#detalleLiquidacion").attr("src",url);		

	if($('#guardar')) $('#guardar').attr("disabled","true");
    if($('#anular')) $('#anular').attr("disabled","");
	if($('#imprimir')) $('#imprimir').attr("disabled","");
	if($('#limpiar')) $('#limpiar').attr("disabled","");	
	

 }else{
	alertJquery(resp,"Error : ");
 }
}

function LiquidacionOnReset(forma){
	
	document.getElementById('estado').value    = 'L';	
	document.getElementById('estado').disabled = true;	

    $("#divAnulacion").css("display","none");
	
	if($('#guardar')) $('#guardar').attr("disabled","");
    if($('#anular')) $('#anular').attr("disabled","");
	if($('#imprimir')) $('#imprimir').attr("disabled","true");
	if($('#limpiar')) $('#limpiar').attr("disabled","");	
	$("#detalleLiquidacion").attr("src","");
	
	clearFind();	
}

function onclickCancellation(formulario){
	
	if($("#divAnulacion").is(":visible")){
	 
	   var formularioPrincipal = document.forms[0];
	   var observaciones_anulacion       = $("#observaciones_anulacion").val();
	   
       if(ValidaRequeridos(formulario)){
	
	     var QueryString = "ACTIONCONTROLER=onclickCancellation&"+FormSerialize(formulario)+"&cierre_crm_id="+$("#cierre_crm_id").val();
		
	     $.ajax({
           url  : "CierreCRMClass.php",
	       data : QueryString,
	       beforeSend: function(){
			   showDivLoading();
	       },
	       success : function(response){
			 
						  
		     if($.trim(response) == 'true'){
				 alertJquery('Cierre Anulado','Anulado Exitosamente');
				 if($('#anular'))     $('#anular').attr("disabled","true");
			 }else{
				   alertJquery(response,'Inconsistencia Anulando');
			   }
			   
			 removeDivLoading();
             $("#divAnulacion").dialog('close');
			 
	       }
	    });	   
	  }
	
    }else{
		
	 var cierre_crm_id = $("#cierre_crm_id").val();
	 
	 if(parseInt(cierre_crm_id) > 0){		
       
		$("#divAnulacion").dialog({
		  title: 'Anulacion Cierre',
		  width: 450,
		  height: 280,
		  closeOnEscape:true
		 });
			
	 }else{
		alertJquery('Debe Seleccionar primero una Liquidacion','Anulacion');
	  }		
   }  
}

function previsual(){
	$("#divOrdenServicio").dialog('close');
	var guias_id  	= $('#guias_id').val();
	var desde		=	$("#fecha_inicial").val();
	var hasta		=	$("#fecha_final").val();
	
	var url = "DetallesCierreGuiaClass.php?previsual=si&guias_id="+guias_id+"&desde="+desde+"&hasta="+hasta+"&rand="+Math.random();
	$("#detalleLiquidacion").attr("src",url);		

	var QueryString	= "ACTIONCONTROLER=GetValorPorFacturado&guias_id="+guias_id+"&desde="+desde+"&hasta="+hasta+"&rand="+Math.random();
	$.ajax({
		url			: "CierreCRMClass.php?rand="+Math.random(),
		data		: QueryString,
		beforeSend	: function(){
			//showDivLoading();
		},
		success    : function(resp){
			if(parseInt(resp)>0){
				$("#valor").val(setFormatCurrency(resp));
			}else{
				alertJquery('No existe valor a liquidar','Error en la liquidacion');
			}
		}
	});

	
}