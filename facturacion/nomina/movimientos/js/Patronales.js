// JavaScript Document
//eventos asignados a los objetos
var	formSubmitted = false;			
$(document).ready(function(){

    $("#saveDetallesSoliServi").click(function(){
      window.frames[0].saveDetallesSoliServi();
    });
});


function setDataFormWithResponse(){
	
    var parametros 	= new Array ({campos:"liquidacion_patronal_id", valores:$('#liquidacion_patronal_id').val()});
    var forma 	= document.forms[0];
    var controlador = 'PatronalesClass.php';
    
    FindRow(parametros,forma,controlador,null,function(resp){
	    
      var liquidacion_patronal_id = $('#liquidacion_patronal_id').val();
	  var estado = $('#estado').val();
      var url 	    = "DetallePatronalesClass.php?liquidacion_patronal_id="+liquidacion_patronal_id;
      
      $("#detallePatronalesNovedad").attr("src",url);
	  $('#fecha_inicial').attr("disabled","true");
	  $('#fecha_final').attr("disabled","true");	  
	  
      $('#guardar').attr("disabled","true");
	  if(estado=='A'){
	      $('#anular').attr("disabled","true");
		  $('#contabilizar').attr("disabled","true");
	  }else if(estado=='C'){
		  $('#anular').attr("disabled","");
		  $('#contabilizar').attr("disabled","true");			   
	  }else if(estado=='E'){
		  $('#anular').attr("disabled","");
		  $('#contabilizar').attr("disabled","");			   
		  
	  }
      $('#limpiar').attr("disabled","");
      	    
    });
}

function showTable(){
  
	var frame_grid =  document.getElementById('frame_grid');
	
	  //Se valida que el iFrame no exista
	  if(frame_grid == null ){
  
	  var QueryString   = 'ACTIONCONTROLER=showGrid';
  
	  $.ajax({
		url        : "PatronalesClass.php?rand="+Math.random(),
		data       : QueryString,
		 async     : false,
		beforeSend : function(){
		showDivLoading();
		},
		success    : function(resp){
		  console.log(resp);
		  try{
			
			var iframe           = document.createElement('iframe');
			iframe.id            ='frame_grid';
			iframe.style.cssText = "border:0; height: 400px; background-color:transparent";
			//iframe.scrolling   = 'no';
			
			document.body.appendChild(iframe); 
			iframe.contentWindow.document.open();
			iframe.contentWindow.document.write(resp);
			iframe.contentWindow.document.close();
			
			$('#mostrar_grid').removeClass('btn btn-warning btn-sm');
			$('#mostrar_grid').addClass('btn btn-secondary btn-sm');
			$('#mostrar_grid').html('Ocultar tabla');
			
		  }catch(e){
			
			console.log(e);
			
		  }
		  removeDivLoading();
		} 
	  });
	  
	}else{
	  
		$('#frame_grid').remove();
		$('#mostrar_grid').removeClass('btn btn-secondary btn-sm');
		$('#mostrar_grid').addClass('btn btn-warning btn-sm');
		$('#mostrar_grid').html('Mostrar tabla');
	  
	}
	
  }



function PatronalesOnSave(formulario,resp){
  	
  	try{
		resp = $.parseJSON(resp);
		
		if($.isArray(resp)){
					
			$("#liquidacion_patronal_id").val(resp[0]['liquidacion_patronal_id']);
			
			var liquidacion_patronal_id = $('#liquidacion_patronal_id').val();
			var url 		= "DetallePatronalesClass.php?liquidacion_patronal_id="+liquidacion_patronal_id;
			
			$("#detallePatronalesNovedad").attr("src",url);
		    $('#fecha_inicial').attr("disabled","true");
		    $('#fecha_final').attr("disabled","true");	  

			$('#guardar').attr("disabled","true");
			$('#anular').attr("disabled","");
			$('#contabilizar').attr("disabled","");			
			$('#limpiar').attr("disabled","");
			
			updateGrid();
		
		}else{
			alertJquery("Ocurrio una inconsistencia : "+resp);
		}
	
    }catch(e){
		 alertJquery(e);
    }
}



function PatronalesOnReset(){
  
    var oficina    = $("#oficina_hidden").val();
    var oficina_id = $("#oficina_id_hidden").val();
    
    clearFind();
	$("#detallePatronalesNovedad").attr("src","");
    $('#guardar').attr("disabled","");
    $('#anular').attr("disabled","true");
	$('#contabilizar').attr("disabled","true");
    $('#limpiar').attr("disabled","");
    
    $("#oficina").val(oficina);
    $("#oficina_id").val(oficina_id);	
    $("#fecha_ss").val($("#fecha_ss_static").val());		
	$("#busqueda").val('');
    $('#fecha_inicial').attr("disabled","");
	$('#fecha_final').attr("disabled","");	  

    document.getElementById('estado').value = 'E';
    document.getElementById('estado').disabled=true;

	
}


function updateGrid(){
	$("#refresh_QUERYGRID_Patronales").click();
}

function beforePrint(formulario,url,title,width,height){
	
   var encabezado_registro_id = parseInt(document.getElementById("encabezado_registro_id").value);
      
   if(isNaN(encabezado_registro_id)){
     alertJquery("Debe Seleccionar una Liquidacion Provisi&oacute;n Contabilizada!!!","Impresion Liquidacion"); 
     return false;
   }else{
	  
      return true;
    }
  
  
}

function printOut(){	
	
	var tipo_impresion = document.getElementById("tipo_impresion").value;
	var desprendibles = document.getElementById("desprendibles").value;
	var liquidacion_patronal_id = document.getElementById("liquidacion_patronal_id").value;
	var url = "PatronalesClass.php?ACTIONCONTROLER=onclickPrint&tipo_impresion="+tipo_impresion+"&desprendibles="+desprendibles+"&liquidacion_patronal_id="+liquidacion_patronal_id+"&random="+Math.random();
	
	printCancel();
    onclickPrint(null,url,"Impresion Liquidacion Nomina","950","600");	
	
}



function onclickCancellation(formulario){


	var liquidacion_patronal_id     = $("#liquidacion_patronal_id").val();

	if($("#divAnulacion").is(":visible")){
	 
	   var formularioPrincipal = document.getElementById('PatronalesForm');
	   var causal_anulacion_id = $("#causal_anulacion_id").val();
	   var observacion_anulacion       = $("#observacion_anulacion").val();
	   
       if(ValidaRequeridos(formulario)){
		   
		   
		 if(!formSubmitted){  
	
	     var QueryString = "ACTIONCONTROLER=onclickCancellation&liquidacion_patronal_id="+liquidacion_patronal_id+"&causal_anulacion_id="+causal_anulacion_id+"&observacion_anulacion="+observacion_anulacion;
		
	     $.ajax({
           url  : "PatronalesClass.php?rand="+Math.random(),
	       data : QueryString,
	       beforeSend: function(){
			   showDivLoading();
			   formSubmitted = true;
	       },
	       success : function(response){
			 
             Reset(formularioPrincipal);	
             PatronalesOnReset();		
			 removeDivLoading();
             $("#divAnulacion").dialog('close');			 
			 
			 formSubmitted = false;
						  
		     if($.trim(response) == 'true'){
				 
			    alertJquery('Liquidacion Patronal Anulada','Anulado Exitosamente');
			 
			 }else{
			    alertJquery(response,'Inconsistencia Anulando');
			 }
			   
			 
	       }
	   
	     });
		 
	    }
	   
	   }
	
    }else{
		
	 var liquidacion_patronal_id = $("#liquidacion_patronal_id").val();
	 var estado    = document.getElementById("estado").value;
	 
	 if(parseInt(liquidacion_patronal_id) > 0 ){		

	    $("input[name=anular]").each(function(){ this.disabled = false; });
		
		$("#divAnulacion").dialog({
		  title: 'Anulacion Liquidacion',
		  width: 550,
		  height: 280,
		  closeOnEscape:true
		 });
			
	 }else if(!parseInt(liquidacion_patronal_id) > 0){
		alertJquery('Debe Seleccionar primero una Liquidacion','Validacion Anulacion');
	 
		
	 }else{
		alertJquery('Por favor verifique que este correcto','Validacion Anulacion'); 
	 }
		
	}
}


function OnclickContabilizar(){
	var liquidacion_patronal_id  = $("#liquidacion_patronal_id").val();
	var fecha_inicial 			= $("#fecha_inicial").val();	
	$('#contabilizar').attr("disabled","true");
	var QueryString 		 = "ACTIONCONTROLER=getTotalDebitoCredito&liquidacion_patronal_id="+liquidacion_patronal_id;	

	if(parseInt(liquidacion_patronal_id)>0){
		if(!formSubmitted){	
			formSubmitted = true;			
			$.ajax({
			  url     : "PatronalesClass.php",
			  data    : QueryString,
			  success : function(response){
						  
				  try{
					 var totalDebitoCredito = $.parseJSON(response); 
					 var totalDebito        = parseFloat(totalDebitoCredito[0]['debito']) > 0 ? totalDebitoCredito[0]['debito'] : 0;
					 var totalCredito       = parseFloat(totalDebitoCredito[0]['credito']) > 0 ? totalDebitoCredito[0]['credito'] : 0;
					 
					 if(parseFloat(totalDebito)==parseFloat(totalCredito) && parseFloat(totalCredito)>0 ){
						var QueryString = "ACTIONCONTROLER=getContabilizar&liquidacion_patronal_id="+liquidacion_patronal_id+"&fecha_inicial="+fecha_inicial;	
	
						$.ajax({
							url     : "PatronalesClass.php",
							data    : QueryString,
							success : function(response){
						  
								try{
									 if(parseInt(response)>0){
										$('#guardar').attr("disabled","true");
										$('#anular').attr("disabled","");
										$('#contabilizar').attr("disabled","true");
										$('#limpiar').attr("disabled","");
										$("#encabezado_registro_id").val(response);	
										document.getElementById('estado').value = 'C';
										alertJquery('Registro Contabilizado','Contabilizacion Exitosa');
										$("#refresh_QUERYGRID_Patronales").click();
									    formSubmitted = false;	
									 }else{
										   alertJquery(response,'Inconsistencia Contabilizando');
										   $('#contabilizar').attr("disabled",""); 
									 }
									
		
								}catch(e){
									$('#contabilizar').attr("disabled","true");  
								}
							}
						});
					 }else if(parseFloat(totalDebito)==parseFloat(totalCredito) && parseFloat(totalCredito)==0){
						alertJquery('Los valores no Pueden estar En Ceros :<b>NO SE CONTABILIZARA</b>','Contabilizacion'); 
						$('#contabilizar').attr("disabled","");
					 }else{
						alertJquery('No existen sumas iguales :<b>NO SE CONTABILIZARA</b>','Contabilizacion'); 
						$('#contabilizar').attr("disabled","");
					 }
				  }catch(e){
					  
				  }
			  }
			  
			});  
		}
	}else{
		alertJquery('Debe Seleccionar primero un Registro','Contabilizacion'); 
		$('#contabilizar').attr("disabled","");
	}
}
