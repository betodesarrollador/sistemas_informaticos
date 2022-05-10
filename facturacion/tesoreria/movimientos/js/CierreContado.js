// JavaScript Document
var formSubmitted = false;
$(document).ready(function(){

	$("#importSolicitud").attr("disabled","true");
	$("#divOrdenServicio").css("display","none");
	$("#divAnulacion").css("display","none");


	$("#importSolicitud").click(function(){
		var desde		=	$("#fecha_inicial").val();
		var hasta		=	$("#fecha_final").val();
		var cierre_contado_id		=	$("#cierre_contado_id").val();

		if ( desde!='' && hasta!='' && parseInt(cierre_contado_id)>0) {
			$("#iframeOrdenServicio").attr("src","SolicCierreToGuiaClass.php?&desde="+desde+"&hasta="+hasta+"&cierre_contado_id="+cierre_contado_id);
			var formulario = document.getElementById('CierreContadoForm');
			$("#divOrdenServicio").dialog({
				title: 'Remesas Contado',
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
			  url        : "CierreContadoClass.php?rand="+Math.random(),
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
function setDataFormWithResponse(cierre_contado_id){	
	var forma 		= document.forms[0];	
	var QueryString = "ACTIONCONTROLER=onclickFind&cierre_contado_id="+cierre_contado_id;	
	$.ajax({
	  url        : "CierreContadoClass.php?rand="+Math.random(),
	  data       : QueryString,
	  beforeSend : function(){
		  showDivLoading();
	  },
	  success    : function(resp){		  
        try{			
		  var data         = $.parseJSON(resp);
		  var estado       = data[0]['estado'];		  		

		  setFormWithJSON(forma,data,false,function(){			
		  
			  if(estado == 'A' ){
				  if($('#guardar'))    $('#guardar').attr("disabled","true");
				  if($('#anular'))     $('#anular').attr("disabled","true");
				  if($('#contabilizar'))     $('#contabilizar').attr("disabled","true");
			  }else if(estado=='E'){
				  if($('#guardar'))    $('#guardar').attr("disabled","true");
				  if($('#anular'))     $('#anular').attr("disabled","");
				  if($('#contabilizar'))     $('#contabilizar').attr("disabled","");
				  if($('#importSolicitud'))  $("#importSolicitud").attr("disabled","");
			  }else{
				  if($('#guardar'))    $('#guardar').attr("disabled","true");
				  if($('#anular'))     $('#anular').attr("disabled","");
				  if($('#contabilizar'))     $('#contabilizar').attr("disabled","true");				  
			  }
			  if($('#imprimir'))     $('#imprimir').attr("disabled","");
			  if($('#limpiar'))    $('#limpiar').attr("disabled","");
			  
			  loadDetalle();
			  
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
  var cierre_contado_id = parseInt(resp);
  if(cierre_contado_id > 0){

	var QueryString = "ACTIONCONTROLER=getConsecutivo&cierre_contado_id="+cierre_contado_id;
	$.ajax({
	  url        : "CierreContadoClass.php?rand="+Math.random(),
	  data       : QueryString,
	  beforeSend : function(){
		showDivLoading();
	  },
	  success    : function(respu){		
		  removeDivLoading();
		  $("#consecutivo").val(respu);					  
		  $("#cierre_contado_id").val(resp);					  
		  alertJquery("<span style='font-weight:bold;font-size:14px'>CIERRE : </span><span style='color:red;font-weight:bold;font-size:20px'>"+respu+"</span>","Cierre Contado");	
		  
	  }
	});		
	

	if($('#guardar')) $('#guardar').attr("disabled","true");
    if($('#anular')) $('#anular').attr("disabled","");
	if($('#imprimir')) $('#imprimir').attr("disabled","");
	if($('#limpiar')) $('#limpiar').attr("disabled","");	
	

 }else{
	alertJquery(resp,"Error : ");
 }
}

function LiquidacionOnReset(forma){
	
	document.getElementById('estado').value    = 'E';	
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
	
	     var QueryString = "ACTIONCONTROLER=onclickCancellation&"+FormSerialize(formulario)+"&cierre_contado_id="+$("#cierre_contado_id").val();
		
	     $.ajax({
           url  : "CierreContadoClass.php",
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
		
	 var cierre_contado_id = $("#cierre_contado_id").val();
	 
	 if(parseInt(cierre_contado_id) > 0){		
       
		$("#divAnulacion").dialog({
		  title: 'Anulacion Cierre',
		  width: 450,
		  height: 280,
		  closeOnEscape:true
		 });
			
	 }else{
		alertJquery('Debe Seleccionar primero un Cierre','Anulacion');
	  }		
   }  
}

function previsual(){
	$("#divOrdenServicio").dialog('close');
	var guias_id  	= $('#guias_id').val();
	var desde		=	$("#fecha_inicial").val();
	var hasta		=	$("#fecha_final").val();
	
	var url = "DetalleCierreClass.php?previsual=si&guias_id="+guias_id+"&desde="+desde+"&hasta="+hasta+"&rand="+Math.random();
	$("#detalleLiquidacion").attr("src",url);		

	var QueryString	= "ACTIONCONTROLER=GetValorPorFacturado&guias_id="+guias_id+"&desde="+desde+"&hasta="+hasta+"&rand="+Math.random();
	$.ajax({
		url			: "CierreContadoClass.php?rand="+Math.random(),
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

function loadDetalle(){
		
	var cierre_contado_id  = $('#cierre_contado_id').val();	
    var url            = "DetalleCierreClass.php?cierre_contado_id="+cierre_contado_id+"&rand="+Math.random();

	document.getElementById('detalleLiquidacion').src = url;
	
	var QueryString	= "ACTIONCONTROLER=GetValorPorFacturado&cierre_contado_id="+cierre_contado_id+"&rand="+Math.random();
	$.ajax({
		url			: "CierreContadoClass.php?rand="+Math.random(),
		data		: QueryString,
		beforeSend	: function(){
			//showDivLoading();
		},
		success    : function(resp){
			if(parseInt(resp)>0){
				$("#valor").val(setFormatCurrency(resp));
			}else{
				alertJquery('No existe valor en las remesas para el Cierre','Error en el Cierre');
			}
		}
	});
	
	
}



function OnclickContabilizar(formu){ 
	var cierre_contado_id = $("#cierre_contado_id").val();
	
	if(parseInt(cierre_contado_id)>0){
		if(!formSubmitted){	
			formSubmitted = true;			
						  

			var QueryString = "ACTIONCONTROLER=OnclickContabilizar&cierre_contado_id="+cierre_contado_id;	


			$.ajax({
				url     : "CierreContadoClass.php?rand="+Math.random(),
				data    : QueryString,
				success : function(response){
			  
					try{
						 if($.trim(response) == 'true'){
							 alertJquery('Cierre Contabilizado','Contabilizacion Exitosa');
							 setDataFormWithResponse(cierre_contado_id);
							 formSubmitted = false;	
						 }else{
							   alertJquery(response,'Inconsistencia Contabilizando');
						 }
						

					}catch(e){
					  
					}
				}
			});
			
		}
	}else{
		alertJquery('Debe Seleccionar primero un Cierre','Contabilizacion'); 
	}
}


function beforePrint(formulario,url,title,width,height){
	var encabezado_registro_id = $("#encabezado_registro_id").val()*1;
	if(encabezado_registro_id > 0){
		return true;
	}else{
		alertJquery("No se ha generado un registro contable para imprimir!!");
		return false;
	}
}
