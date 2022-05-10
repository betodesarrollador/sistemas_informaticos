// JavaScript Document
$(document).ready(function(){

	$("#importSolicitud").attr("disabled","true");
	$("#divOrdenServicio").css("display","none");
	$("#divAnulacion").css("display","none");


	$("#importSolicitud").click(function(){
		var cliente_id	=	$("#cliente_id").val();
		var desde		=	$("#fecha_inicial").val();
		var hasta		=	$("#fecha_final").val();
		var oficina_id	=	$("#oficina_id1").val();

		if (cliente_id>0 && desde!='' && hasta!='') {
			$("#iframeOrdenServicio").attr("src","SolicServToGuiaIndClass.php?cliente_id="+cliente_id+"&desde="+desde+"&hasta="+hasta+"&oficina_id="+oficina_id);
			var formulario = document.getElementById('LiquidacionGuiasClienteForm');
			$("#divOrdenServicio").dialog({
				title: 'Guias para Liquidar',
				width: 950,
				height: 425,
				closeOnEscape:true,
				show: 'scale',
				hide: 'scale'
			});
		}else{
			alertJquery("Por favor escoja cliente y las fechas ","Validacion");	
		}
	});

	$("#cliente").change(function(){
		if (!isNaN($("#cliente_id"))) {
			$("#importSolicitud").attr("disabled","true");
		}else{
			$("#importSolicitud").attr("disabled","");
		}
	});

	$("#guardar").click(function(){
		if (ValidaRequeridos(this.form)) {

			var QueryString = "ACTIONCONTROLER=onclickSave&"+FormSerialize(this.form);
			$.ajax({
			  url        : "LiquidacionGuiasClienteClass.php?rand="+Math.random(),
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
function setDataFormWithResponse(liquidacion_guias_cliente_id){	
	var forma 		= document.forms[0];	
	var QueryString = "ACTIONCONTROLER=onclickFind&liquidacion_guias_cliente_id="+liquidacion_guias_cliente_id;	
	$.ajax({
	  url        : "LiquidacionGuiasClienteClass.php?rand="+Math.random(),
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
			  
			  var url = "DetallesLiqGuiaClass.php?liquidacion_guias_cliente_id="+liquidacion_guias_cliente_id+"&rand="+Math.random();
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

function ultima(cliente_id){
  if(parseInt(cliente_id) > 0){

	var QueryString = "ACTIONCONTROLER=GetUltimo&cliente_id="+cliente_id;
	$.ajax({
	  url        : "LiquidacionGuiasClienteClass.php?rand="+Math.random(),
	  data       : QueryString,
	  beforeSend : function(){
		showDivLoading();
	  },
	  success    : function(respu){		
		  removeDivLoading();
		  $("#UltimaLiquidacion").val(respu);			  
	  }
	});	
  }
}

function LiquidacionOnSave(formulario,resp){
  var liquidacion_guias_cliente_id = parseInt(resp);
  if(liquidacion_guias_cliente_id > 0){

	var QueryString = "ACTIONCONTROLER=getConsecutivo&liquidacion_guias_cliente_id="+liquidacion_guias_cliente_id;
	$.ajax({
	  url        : "LiquidacionGuiasClienteClass.php?rand="+Math.random(),
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
	
	var url = "DetallesLiqGuiaClass.php?liquidacion_guias_cliente_id="+liquidacion_guias_cliente_id+"&rand="+Math.random();
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
	
	     var QueryString = "ACTIONCONTROLER=onclickCancellation&"+FormSerialize(formulario)+"&liquidacion_guias_cliente_id="+$("#liquidacion_guias_cliente_id").val();
		
	     $.ajax({
           url  : "LiquidacionGuiasClienteClass.php",
	       data : QueryString,
	       beforeSend: function(){
			   showDivLoading();
	       },
	       success : function(response){
			 
						  
		     if($.trim(response) == 'true'){
				 alertJquery('Liquidacion Anulada','Anulado Exitosamente');
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
		
	 var liquidacion_guias_cliente_id = $("#liquidacion_guias_cliente_id").val();
	 
	 if(parseInt(liquidacion_guias_cliente_id) > 0){		
       
		$("#divAnulacion").dialog({
		  title: 'Anulacion Liquidacion',
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
	var cliente_id	=	$("#cliente_id").val();
	var desde		=	$("#fecha_inicial").val();
	var hasta		=	$("#fecha_final").val();
	
	var url = "DetallesLiqGuiaClass.php?previsual=si&guias_id="+guias_id+"&cliente_id="+cliente_id+"&desde="+desde+"&hasta="+hasta+"&rand="+Math.random();
	$("#detalleLiquidacion").attr("src",url);		

	var QueryString	= "ACTIONCONTROLER=GetValorPorFacturado&guias_id="+guias_id+"&cliente_id="+cliente_id+"&desde="+desde+"&hasta="+hasta+"&rand="+Math.random();
	$.ajax({
		url			: "LiquidacionGuiasClienteClass.php?rand="+Math.random(),
		data		: QueryString,
		beforeSend	: function(){
			//showDivLoading();
		},
		success    : function(resp){
			if(parseInt(resp)>=0){
				$("#valor").val(setFormatCurrency(resp));
			}else{
				alertJquery('No existe valor a liquidar','Error en la liquidacion');
			}
		}
	});

	
}

function beforePrint(formulario,url,title,width,height){
	
	var liquidacion_guias_cliente_id = parseInt($("#liquidacion_guias_cliente_id").val());
	
	if(isNaN(liquidacion_guias_cliente_id)){
	  
	  alertJquery('Debe seleccionar una Liquidacion a imprimir !!!','Impresion Liquidacion');
	  return false;
	  
	}else{	  
	
	    var liquidacion_guias_cliente_id = $("#liquidacion_guias_cliente_id").val();
		
		if(liquidacion_guias_cliente_id > 0){
			
		  return true;	
			
		}else{
			
			 alertJquery("No se puede mostrar impresion ya que esta liquidacion no se ha CAUSADO aun!!!","Impresion Liquidacion");
			 return false;
			
		  }
		
	    return true;
	  }	
	
}