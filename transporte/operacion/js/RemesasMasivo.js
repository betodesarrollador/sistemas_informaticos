var SolicitudId;
var foto_cumplido_checked_file         = false;

$(document).ready(function(){

	$("#fecha_vencimiento_poliza").blur(function(){
		
		if(!isDate(this.value)){
			alertJquery("Debe Ingresar Una Fecha Valida","Validacion Fecha");
			this.value = '';
			return false;
		}

	});
	
	$("#tipo_remesa_id").change(function(){

		var tipo_remesa_id = this.value; 										 
		var QueryString    = "ACTIONCONTROLER=getTipoEmpaque&tipo_remesa_id="+tipo_remesa_id;

		$.ajax({
			url        : "RemesasMasivoClass.php?rand="+Math.random(),
			data       : QueryString,
			beforeSend : function(){
				showDivLoading();
			},
			success    : function(resp){			 
				$("#empaque_id").parent().html(resp);
				getPesoVacioMinimoContenedor();			 
				removeDivLoading();
			}
		});

	});
	
	
	getPesoVacioMinimoContenedor();	
	
	$("#tipo_remesa_id").trigger("change");	

	$("#divAnulacion").css("display","none");	
	$("#iframeSolicitudRemesa").attr("src","SolicServToRemesaClass.php");	
	$("#iframeOrdenCargueRemesa").attr("src","OrdenCargueToRemesaClass.php");			

	$("#importSolcitud").click(function(){

		var formulario = document.getElementById('RemesasMasivoForm')		
		Reset(formulario);	
		RemesasMasivoOnReset();  		

		$("#divSolicitudRemesa").dialog({
			title: 'Solicitud de Servicio para Remesar',
			width: 950,
			height: 395,
			closeOnEscape:true,
			show: 'scale',
			hide: 'scale'
		});
		
	});
	
	$("#importOrdenCargue").click(function(){

		var formulario = document.getElementById('RemesasMasivoForm')		
		Reset(formulario);	
		RemesasMasivoOnReset();  		

		$("#divOrdenCargueRemesa").dialog({
			title: 'Orden de Carga para Remesar',
			width: 950,
			height: 395,
			closeOnEscape:true,
			show: 'scale',
			hide: 'scale'
		});
		
	});	
	
	
	$("a[name=saveDetalleRemesa]").click(function(){
		addRowProduct(this);
	});
	
	
	$("#print_out").click(function(){
		printOut();								   
	});
	
	$("#print_cancel").click(function(){
		printCancel();									  
	});
	
	$("#amparada_por").change(function(){
		setDataSeguroPoliza(this.value);									  							  
	});
	
	$("#saveDetallesRemesa").click(function(){
		window.frames[1].saveDetallesRemesa();
	});

	$("#deleteDetallesRemesa").click(function(){
		window.frames[1].deleteDetallesRemesa();
	});
	
	$("a[name=saveDetalleRemesa]").focus(function(){    
		$(this).parent().addClass("focusSaveRow");
	});
	
	$("a[name=saveDetalleRemesa]").blur(function(){
		$(this).parent().removeClass("focusSaveRow");
	});	

	$("#guardar,#actualizar").click(function(){


		var formulario = this.form;
		var nacional   = document.getElementById('nacional').value;	  
		var remesa_id  = $("#remesa_id").val();

		if(ValidaRequeridos(formulario)){ 

	    //$("#propietario_mercancia").val($("#propietario_mercancia_txt").val());
	    var peso =  $("#peso").val();
	    var nacional = document.getElementById('nacional').value;
	    if(this.id == 'guardar'){

if(nacional == '1'){ // si lista desplegable nacional es 'SI'
	if(peso>= 15 && peso<=35000){	    				
		foto_cumplido_checked_file         = document.getElementById('foto_cumplido_checked_file').checked;		
		var QueryString = "ACTIONCONTROLER=onclickSave&"+FormSerialize(formulario);


		$.ajax({
			url        : "RemesasMasivoClass.php?rand="+Math.random(),
			data       : QueryString,
			beforeSend : function(){
				showDivLoading();
			},
			success    : function(resp){				   
				updateGridRemesas();
				removeDivLoading();
				RemesasMasivoOnSave(nacional,formulario,resp);					  
			}
		});
	}else{
		alertJquery("                 Peso Neto actual :  "+peso+
			"\n\n El campo PESO NETO debe ser mayor a 14 kg e inferior a 35000 kg para transportes tipo 'Nacional'");
	}	
}else{

	foto_cumplido_checked_file         = document.getElementById('foto_cumplido_checked_file').checked;		
	var QueryString = "ACTIONCONTROLER=onclickSave&"+FormSerialize(formulario);


	$.ajax({
		url        : "RemesasMasivoClass.php?rand="+Math.random(),
		data       : QueryString,
		beforeSend : function(){
			showDivLoading();
		},
		success    : function(resp){				   
			updateGridRemesas();
			removeDivLoading();
			RemesasMasivoOnSave(nacional,formulario,resp);					  
		}
	});
}




}else{

	if(nacional == '1'){ // si lista desplegable nacional es 'SI'
		if(peso>= 15 && peso<=35000){
			
			foto_cumplido_checked_file         = document.getElementById('foto_cumplido_checked_file').checked;		
			var QueryString = "ACTIONCONTROLER=onclickUpdate&"+FormSerialize(formulario);

			submitIframe(formulario,QueryString,remesa_id);
					/*$.ajax({
					  url        : "RemesasMasivoClass.php?rand="+Math.random(),
					  data       : QueryString,
					  beforeSend : function(){
						showDivLoading();
					  },
					  success    : function(resp){
						  updateGridRemesas();
						  removeDivLoading();
					      RemesasMasivoOnUpdate(formulario,resp,remesa_id);						  
					  }
					});*/

				}else{
					alertJquery("                 Peso Neto actual :  "+peso+
						"\n\n El campo PESO NETO debe ser mayor a 15 kg e inferior a 35000 kg para transportes tipo 'Nacional'");
				}	
			}else{

				foto_cumplido_checked_file         = document.getElementById('foto_cumplido_checked_file').checked;		
				var QueryString = "ACTIONCONTROLER=onclickUpdate&"+FormSerialize(formulario);

				submitIframe(formulario,QueryString,remesa_id);
					/*$.ajax({
					  url        : "RemesasMasivoClass.php?rand="+Math.random(),
					  data       : QueryString,
					  beforeSend : function(){
						showDivLoading();
					  },
					  success    : function(resp){
						  updateGridRemesas();
						  removeDivLoading();
					      RemesasMasivoOnUpdate(formulario,resp,remesa_id);						  
					  }
					});*/

				}

				
				
			}
		}											

	});

	setValorLiquidacion();

	setRemesaComplemento();
	getRemesaComplemento();   
	setRangoDesdeHasta();      
	
});

function viewDoc(remesa_id) {
	$('#remesa_id').val(remesa_id);
	setDataFormWithResponse(remesa_id);
}

//inicio submitIframe

function submitIframe(formulario,QueryString,remesa_id){
	var option = 'onclickUpdate';
	showDivLoading();

	$(formulario).find("input[type=checkbox]").each(function(){

		if(this.checked == false){

			var Longitud    = this.name.length;
			var NombreCampo = this.name.substring(Longitud - 13,Longitud);

			if(NombreCampo == '_checked_file'){

				var fileDelete   = document.createElement("input");   		  
				fileDelete.type  = "hidden";
				fileDelete.name  = this.name;         
				fileDelete.id    = this.name+'_hidden';         			
				fileDelete.value = 'false';	

				formulario.appendChild(fileDelete);

			}		 

		}else if(document.getElementById(this.name+'_hidden')){
			var objRemove = document.getElementById(this.name+'_hidden');		 
			objRemove.parentNode.removeChild(objRemove);
		}

	});

	var FrameEnvio      = document.getElementById('frmsend');
	var ActionControler = document.getElementById('ACTIONCONTROLER');

	if(!FrameEnvio){
		var  FrameEnvio      = document.createElement("iframe");
		FrameEnvio.width     = "0";     
		FrameEnvio.height    = "0";
		FrameEnvio.name      = "frmsend";
		FrameEnvio.id        = "frmsend";
		FrameEnvio.className = "frmsend";		  
		FrameEnvio.style.display = 'none';

		var  ControlerAction       = document.createElement("input");   		  
		ControlerAction.type  = "hidden";
		ControlerAction.name  = "ACTIONCONTROLER";
		ControlerAction.id    = "ACTIONCONTROLER";
		ControlerAction.value = option;

		var  TypeSend              = document.createElement("input");   		  
		TypeSend.type         = "hidden";
		TypeSend.name         = "async";
		TypeSend.id           = "async";
		TypeSend.value        = "true";

		formulario.appendChild(TypeSend);	
		formulario.appendChild(ControlerAction);	
		formulario.appendChild(FrameEnvio);				 	 

	}else{
		$("#ACTIONCONTROLER").val(option);
	}

	formulario.target  = "frmsend";		 
	var formAction     = formulario.action;	 	 	 
	formulario.action  = formAction+'?'+QueryString;

	setCamposNulosForm(formulario);	      	 	   		   

	$("#frmsend").load(function() { 

		formulario.action  = formAction;

		var response = getFrameContents(this);			 	

		if(response.substring(0,10) == 'ENDSESSION'){
			logOut($.trim(response).substring(10));
		}

		$('#loading').html("");		

		RemovervaloresNulosForm(formulario);	  				

		if($.trim(response) == 'true'){
			
			
			updateGridRemesas();
			RemesasMasivoOnUpdate(formulario,response,remesa_id);						  

		}else{

			alertJquery(response,"1Error :");
			document.getElementById('actualizar').disabled = false;
		}


		removeDivLoading();


	});

	formulario.submit();   
	
}
//fin subbmitframe

function getPesoVacioMinimoContenedor(){

	$("#empaque_id").change(function(){

		var empaque_id = this.value;

		if(empaque_id == 7 || empaque_id == 8 || empaque_id == 9){

			var QueryString = "ACTIONCONTROLER=getPesoVacioMinimoContenedor&empaque_id="+empaque_id; 

			$.ajax({
				url        : "RemesasMasivoClass.php?rand="+Math.random(),				
				data       : QueryString,
				beforeSend : function(){
					showDivLoading();
				},
				success    : function(resp){

					removeDivLoading();

					var peso = parseInt(resp);

					if(!isNaN(peso)){
						$("#peso").val(peso);
					}

				}
			}); 

		}

	});
	
}

function closeDialog(){
	$("#divSolicitudRemesa,#divOrdenCargueRemesa").dialog('close');
}

function enabledInputsFormRemesa(forma){
	
	
	$(forma).find("input,select,textarea").each(function(){

		if(this.type != 'button'){
			this.disabled = false;
		}	
	});	
}

function disabledInputsFormRemesa(forma){
	
	$(forma).find("input,select,textarea").each(function(){

		if(this.type != 'button'){
			this.disabled = true;
		}										
		
	});	
	
}

//funcion para cargar los datos desde BUSCAR
function setDataFormWithResponse(remesa_id){
	
	var forma 		= document.forms[0];	
	enabledInputsForm(forma);
	RemesasMasivoOnReset();	
	document.getElementById('estado').disabled = true;
	document.getElementById('amparada_por').disabled = true;
	document.getElementById('numero_poliza').disabled = true;
	document.getElementById('fecha_vencimiento_poliza').disabled = true;
	var QueryString = "ACTIONCONTROLER=onclickFind&remesa_id="+remesa_id;
	
	$.ajax({
		url        : "RemesasMasivoClass.php?rand="+Math.random(),
		data       : QueryString,
		beforeSend : function(){
			foto_cumplido_checked_file = false;
			showDivLoading();
		},
		success    : function(resp){

			try{			
				var data           	= $.parseJSON(resp);
				var remesa         	= data[0]['remesa'];
				var detalle_remesa 	= data[0]['detalle_remesa'];
				var contacto_id    	= remesa[0]['contacto_id'];		  		
				var cliente_id     	= remesa[0]['cliente_id'];		  		
				var clase_remesa   	= remesa[0]['clase_remesa'];		  
				var estado         	= remesa[0]['estado'];
				var placa_manifiesto  = remesa[0]['placa_manifiesto'];
				var placa_despachos   = remesa[0]['placa_despachos'];	
				var reportado_ministerio2 = remesa[0]['reportado_ministerio2'];
				var aprobacion_ministerio_man2 = remesa[0]['aprobacion_ministerio_man2'];
				var manifiesto_id = remesa[0]['manifiesto_id'];
				var despachos_urbanos_id = remesa[0]['despachos_urbanos_id'];

				if(placa_despachos == null){	  
					var placa = placa_manifiesto;
				} else if(placa_manifiesto == null){	  
					var placa = placa_despachos;
				} else{				
					var placa = placa_manifiesto + placa_despachos;
				}

				setContactos(cliente_id,contacto_id);		  
				setFormWithJSON(forma,remesa);

				$('#placa').val(placa);

				if(clase_remesa == 'CP'){	  
					document.getElementById('numero_remesa_padre').disabled = true;
				}else{	  			  
					document.getElementById('numero_remesa_padre').disabled = false;			  
				}

				if (estado == 'PD' || estado == 'PC' || estado == 'MF' || estado == 'LQ'){
					if($('#actualizar')) document.getElementById('actualizar').disabled = false;
					if(estado=='MF'){
						document.getElementById('foto_cumplido').disabled = false;
						document.getElementById('foto_cumplido_checked_file').disabled=false;	
					}
				}else{
					if($('#actualizar')) document.getElementById('actualizar').disabled = true;
				}						

				if(estado == 'PD' || estado == 'PC' || estado == 'MF'){
					if(document.getElementById('anular')) document.getElementById('anular').disabled = false;				
				}else{
					if(document.getElementById('anular')) document.getElementById('anular').disabled = true;				
				}

				if(estado == 'AN'){
					if($('#importSolcitud')) document.getElementById('importSolcitud').disabled = true;			   
					if($('#actualizar'))     document.getElementById('actualizar').disabled     = true;			   			 
				}else if(estado == 'PD' || estado == 'PC'){
					if($('#importSolcitud')) document.getElementById('importSolcitud').disabled = false;
					if($('#actualizar'))     document.getElementById('actualizar').disabled     = false;			   			 			   
				}	

				if ((((aprobacion_ministerio_man2 == 'null' || aprobacion_ministerio_man2 == null) && manifiesto_id > 0) || (despachos_urbanos_id > 0 && estado == 'LQ') || (!manifiesto_id > 0 && !despachos_urbanos_id > 0)) && estado != 'FT' && estado != 'AN' && estado == 'LQ' || estado =='PD'){
					if(document.getElementById('actualizar')) document.getElementById('actualizar').disabled = false;
						
				}else{
					
					if(document.getElementById('actualizar')) document.getElementById('actualizar').disabled = true;
					disabledInputsFormRemesa(forma);
				}

				if($('#guardar'))    $('#guardar').attr("disabled","true");
	 	  //if($('#actualizar')) $('#actualizar').attr("disabled","");
	 	  if($('#borrar'))     $('#borrar').attr("disabled","");
	 	  if($('#limpiar'))    $('#limpiar').attr("disabled","");


	 	}catch(e){
	 		alertJquery(resp,"Error :");
	 	}	  

	 	removeDivLoading(); 

	 	var remesa_id = $("#remesa_id").val();
	 	var numero_remesa = $("#numero_remesa").val();
	 	document.getElementById('foto_cumplido').disabled     = false;	


	 	if(remesa_id > 0){		  
	 		document.getElementById('rango_desde').value = numero_remesa;	  
	 		document.getElementById('rango_hasta').value = numero_remesa;			  		  
	 	}			  
	 }	  
	});
}

var formSubmitted = false;

function RemesasMasivoOnSave(nacional,formulario,resp){
	
	if(foto_cumplido_checked_file){
		document.getElementById('foto_cumplido_checked_file').checked = true;
	}	 

	var remesa_numero = parseInt(resp);

	if(remesa_numero > 0){
		
	    //if(nacional == 1){
	    	if(nacional == 10){			

	    		if(!formSubmitted){	

	    			$("#numero_remesa").val(remesa_numero);
	    			var QueryString = FormSerialize(formulario)+"&ACTIONCONTROLER=sendInformacionCarga";

	    			$.ajax({
	    				url        : "RemesasMasivoClass.php?rand="+Math.random(),	 
	    				data       : QueryString,
	    				beforeSend : function(){			
	    					showDivMessage("Reportando al Ministerio de Transporte<br>Por Favor Espere..","../../../framework/media/images/general/cable_data_transfer_md_wht.gif");
	    					formSubmitted = true;
	    				},
	    				success    : function(resp){			

	    					removeDivMessage();

	    					showDivMessage(resp,"../../../framework/media/images/general/cable_data_transfer_md_wht.gif");			
	    					formSubmitted = false;

	    					alertJquery("<span style='font-weight:bold;font-size:14px'>REMESA : </span><span style='color:red;font-weight:bold;font-size:20px'>"+remesa_numero+"</span>","Remesar");

	    					Reset(formulario);
	    					RemesasMasivoOnReset();							 
	    				}
	    			});


	    		}

	    	}else{

	    		alertJquery("<span style='font-weight:bold;font-size:14px'>REMESA : </span><span style='color:red;font-weight:bold;font-size:20px'>"+remesa_numero+"</span>","Remesar");

	    		Reset(formulario);
	    		RemesasMasivoOnReset();			  

	    	}


	    }else{
	    	alertJquery(resp);
	    }

	}


/*function RemesasMasivoOnUpdate(formulario,resp,remesa_id){
	
	if($.trim(resp) == 'true'){
		
		var nacional = document.getElementById('nacional').value;
		
		//if(nacional == 1){
		if(nacional == 10){	
			
		 var QueryString = "ACTIONCONTROLER=informacionCargaFueReportada&remesa_id="+remesa_id;	
		 
		 $.ajax({
		   url        : "RemesasMasivoClass.php?rand="+Math.random(),		
		   data       : QueryString,
		   beforeSend : function(resp){
			   showDivLoading();
		   },
		   success    : function(resp){
			   
			   var reportado_ministerio = $.trim(resp);
			   
			   if(reportado_ministerio == 'false'){
				   
					if(!formSubmitted){	
						
						var QueryString = FormSerialize(formulario)+"&ACTIONCONTROLER=sendInformacionCarga";
						
						$.ajax({
						 url        : "RemesasMasivoClass.php?rand="+Math.random(),	 
						 data       : QueryString,
						 beforeSend : function(){			
							showDivMessage("Reportando al Ministerio de Transporte<br>Por Favor Espere..","../../../framework/media/images/general/cable_data_transfer_md_wht.gif");
							formSubmitted = true;
						 },
						 success    : function(resp){			
									
							removeDivMessage();							
							showDivMessage(resp,"../../../framework/media/images/general/cable_data_transfer_md_wht.gif");			
							formSubmitted = false;
							
							alertJquery("Se Actualizo de Forma Exitosa");
							Reset(formulario);
							RemesasOnReset();
							updateGridRemesas();
							updateRangoDesde();							 
						 }
					   });
						
						
					}				   
				   
			   }else{
				
				  if(reportado_ministerio == 'true'){
					  
					alertJquery("Se Actualizo de Forma Exitosa");
					Reset(formulario);
					RemesasOnReset();
					updateGridRemesas();
					updateRangoDesde();					
				  
				  }else{
					  
					 alertJquery(resp);
					 Reset(formulario);
					 RemesasOnReset();
					 updateGridRemesas();
					 updateRangoDesde();										  
					  
					}
				
				}
			   
			   removeDivLoading();
		   }
				
	     });
			
        }else{
			
			alertJquery("Se Actualizo de Forma Exitosa");
			Reset(formulario);
			RemesasOnReset();
			updateGridRemesas();
			updateRangoDesde();			
			
		  }
		
	}else{
		alertJquery(resp);
	}
}


function RemesasMasivoOnDelete(formulario,resp){
	Reset(formulario);
	RemesasMasivoOnReset();
	updateGridRemesas();
	updateRangoDesde();	
	alertJquery(resp);
}*/
function RemesasMasivoOnUpdate(formulario,resp,remesa_id){
	
	if($.trim(resp) == 'true'){
		
		var nacional = document.getElementById('nacional').value;
		
		if(nacional == 1){
			
			var QueryString = "ACTIONCONTROLER=informacionCargaFueReportada&remesa_id="+remesa_id;	

			$.ajax({
				url        : "RemesasMasivoClass.php?rand="+Math.random(),		
				data       : QueryString,
				beforeSend : function(resp){
					showDivLoading();
				},
				success    : function(resp){

					var aprobacion_ministerio_man2 = $("#aprobacion_ministerio_man2").val();
					var aprobacion_ministerio2 = $("#aprobacion_ministerio2").val();
					var reportado_ministerio = $.trim(resp);
			   //alert (aprobacion_ministerio2+'reporte remesa');
			   if((reportado_ministerio == 'false' || aprobacion_ministerio_man2 == '') && (aprobacion_ministerio2 != '')){

			   	if(!formSubmitted){	

			   		var QueryString = FormSerialize(formulario)+"&ACTIONCONTROLER=sendCorreccionInformacionCarga";

			   		$.ajax({
			   			url        : "RemesasMasivoClass.php?rand="+Math.random(),	 
			   			data       : QueryString,
			   			beforeSend : function(){			
			   				showDivMessage("Reportando al Ministerio de Transporte<br>Por Favor Espere..","/chiquinquira/framework/media/images/general/cable_data_transfer_md_wht.gif");
			   				formSubmitted = true;
			   			},
			   			success    : function(resp){			

			   				removeDivMessage();							
			   				showDivMessage(resp,"/chiquinquira/framework/media/images/general/cable_data_transfer_md_wht.gif");			
			   				formSubmitted = false;

			   				alertJquery("Se Actualizo de Forma Exitosa");
			   				Reset(formulario);
			   				RemesasOnReset();
			   				updateGridRemesas();
			   				updateRangoDesde();							 
			   			}
			   		});


			   	}				   

			   }else{

			   	if(reportado_ministerio == 'true'){

			   		alertJquery("Se Actualizo de Forma Exitosa");
			   		Reset(formulario);
			   		RemesasOnReset();
			   		updateGridRemesas();
			   		updateRangoDesde();					

			   	}else{

					 //alertJquery(resp);
					 Reset(formulario);
					 RemesasOnReset();
					 updateGridRemesas();
					 updateRangoDesde();										  

					}

				}

				removeDivLoading();
			}

		});
			
		}else{
			
			alertJquery("Se Actualizo de Forma Exitosa");
			Reset(formulario);
			RemesasOnReset();
			updateGridRemesas();
			updateRangoDesde();			
			
		}
		
	}else{
		alertJquery(resp);
	}
}



function RemesasMasivoOnReset(){
	
	var Tabla = document.getElementById('tableRemesas');

	document.getElementById("clase_remesa").value           = 'NN';	
	document.getElementById("numero_remesa_padre").value    = '';		
	document.getElementById("numero_remesa_padre").disabled = true;	
	document.getElementById('estado').value                 = 'PD';
	document.getElementById('nacional').value               = 1;  	

	if(document.getElementById('anular')) document.getElementById('anular').disabled = true;							  
	if($('#importSolcitud')) document.getElementById('importSolcitud').disabled = false;			   
	document.getElementById('nacional').disabled = false;  

	$("#horas_pactadas_cargue,#horas_pactadas_descargue").val("12");			
	
	resetContactos();
	clearFind();
	
	document.getElementById('naturaleza_id').value  = 1;
	document.getElementById('empaque_id').value     = 1;
	document.getElementById('medida_id').value      = 77;	
	
	$("#fecha_remesa").val($("#fecha").val());
	$("#oficina_id").val($("#oficina_id_static").val());	
	$("#amparada_por").val("E");			
	$("#aseguradora_id").val($("#aseguradora_id_static").val());		
	$("#numero_poliza").val($("#numero_poliza_static").val());
	$("#fecha_vencimiento_poliza").val($("#fecha_vencimiento_poliza_static").val());
	document.getElementById('aseguradora_id').disabled = true;
	
	$('#guardar').attr("disabled","");
	$('#actualizar').attr("disabled","true");
	$('#borrar').attr("disabled","true");
	$('#limpiar').attr("disabled","");
	
	foto_cumplido_checked_file         = false;
}

/*function beforePrint(formulario,url,title,width,height){
	var remesa_id = $("#remesa_id").val();
    var QueryString = "ACTIONCONTROLER=updateRangoDesde&remesa_id="+remesa_id;
	
	$.ajax({
          url        : "RemesasMasivoClass.php?rand="+Math.random(),
	  data       : QueryString,
	  beforeSend : function(){
	    showDivLoading();
	  },
	  success    : function(resp){
	    
	    $("#rango_desde").replaceWith(resp);	
	    setRangoDesdeHasta();
	    
	    var QueryString = "ACTIONCONTROLER=updateRangoHasta&remesa_id="+remesa_id;
	
	    $.ajax({
             url        : "RemesasMasivoClass.php?rand="+Math.random(),
	     data       : QueryString,
	     beforeSend : function(){
	     },
	     success    : function(resp){
	       
		  $("#rango_hasta").replaceWith(resp);
		  
		  var remesa_id = $("#remesa_id").val();
		  
		  if(remesa_id > 0){		  
	       document.getElementById('rango_desde').value = remesa_id;	  
	       document.getElementById('rango_hasta').value = remesa_id;			  		  
		  }			  
		  
		  $("#rangoImp").dialog({
			  title: 'Impresion de Remesas',
			  width: 700,
			  height: 120,
				  closeOnEscape:true,
				  show: 'scale',
				  hide: 'scale'
		  });
		  
		  
		  removeDivLoading();
		  
            }
            
         });	
	    
	    
	    
	  		  
        }
        
    });
	

   return false;

}

function printOut(){	
	
	var rango_desde = document.getElementById("rango_desde").value;
	var rango_hasta = document.getElementById("rango_hasta").value;
	var formato     = document.getElementById("formato").value;
	var url         = "RemesasMasivoClass.php?ACTIONCONTROLER=onclickPrint&rango_desde="+rango_desde+"&rango_hasta="+rango_hasta+"&formato="+formato+"&random="+Math.random();
	
	printCancel();
	
    onclickPrint(null,url,"Impresion Remesas","950","600");	
	
}


function printCancel(){
	$("#rangoImp").dialog('close');	
	removeDivLoading();
}

function updateRangoDesde(){
	
	var QueryString = "ACTIONCONTROLER=updateRangoDesde";
	
	$.ajax({
      url        : "RemesasMasivoClass.php?rand="+Math.random(),
	  data       : QueryString,
	  beforeSend : function(){
	  },
	  success    : function(resp){
		  $("#rango_desde").replaceWith(resp);		  
		  updateRangoHasta();		  		  
      }
    });
	
	
}

function updateRangoHasta(){
	
	var QueryString = "ACTIONCONTROLER=updateRangoHasta";
	
	$.ajax({
          url        : "RemesasMasivoClass.php?rand="+Math.random(),
	  data       : QueryString,
	  beforeSend : function(){
	  },
	  success    : function(resp){
		  $("#rango_hasta").replaceWith(resp);
      }
    });	
	
	
}*/

function beforePrint(formulario,url,title,width,height){

	document.getElementById("rango_desde").style.width="120px";
	document.getElementById("rango_desde").style.height="16px";	
	document.getElementById("rango_hasta").style.width="120px";
	document.getElementById("rango_hasta").style.height="16px";
	document.getElementById("remesas").style.width="120px";
	document.getElementById("remesas").style.height="16px";	

	document.getElementById("fecha_remesa_crea").style.width="120px";
	document.getElementById("fecha_remesa_crea").style.height="16px";	

	document.getElementById("rango_desde").style.fontSize="14px";
	document.getElementById("rango_hasta").style.fontSize="14px";
	document.getElementById("remesas").style.fontSize="14px";

	document.getElementById("fecha_remesa_crea").style.fontSize="14px";



	$("#rangoImp").dialog({
		title: 'Impresion de Remesas, Puede filtrar por Remesas o Fecha',
		width: 700,
		height: 200,
		closeOnEscape:true,
		show: 'scale',
		hide: 'scale'
	});			  
	
	return false;
}

function printOut(){	
	
	var rango_desde = document.getElementById("rango_desde").value;
	var rango_hasta = document.getElementById("rango_hasta").value;
	var remesas = document.getElementById("remesas").value;
	var formato     = document.getElementById("formato").value;
	var fecha_remesa_crea     = document.getElementById("fecha_remesa_crea").value;
	var url = "RemesasMasivoClass.php?ACTIONCONTROLER=onclickPrint&remesas="+remesas+"&rango_desde="+rango_desde+"&rango_hasta="+rango_hasta+"&formato="+formato+"&fecha_remesa_crea="+fecha_remesa_crea+"&random="+Math.random();	
	
	if( (parseInt(remesas)!='' || (parseInt(rango_hasta)>0 || parseInt(rango_desde)>0) || (fecha_remesa_crea!='' && fecha_remesa_crea!='null')) && formato!='NULL'  ){
		printCancel();
		onclickPrint(null,url,"Impresion Remesa","950","600");		
	}else{
		alertJquery("Por favor indique algunos de los items: Remesas(Separadas por coma ',') o Fecha","Validacion Impresion");
	}
}


function printCancel(){
	$("#rangoImp").dialog('close');	
	document.getElementById("rango_desde").style.width="120px";
	document.getElementById("rango_desde").style.height="16px";	
	document.getElementById("rango_hasta").style.width="120px";
	document.getElementById("rango_hasta").style.height="16px";	
	document.getElementById("remesas").style.width="120px";
	document.getElementById("remesas").style.height="16px";
	removeDivLoading();
}

function setContactos(cliente_id,contacto_id){
	
	var QueryString = "ACTIONCONTROLER=setContactos&cliente_id="+cliente_id+"&contacto_id="+contacto_id;
	
	$.ajax({
		url     : "RemesasMasivoClass.php?rand="+Math.random(),
		data    : QueryString,
		success : function(response){
			$("#contacto_id").parent().html(response);
		}
	});
}

function cargaDatos(response){

	var formulario = document.getElementById('RemesasMasivoForm');


	setContactos(response[0]['solicitud'][0]['cliente_id'],response[0]['solicitud'][0]['contacto_id']);    

	var solicitud          = response[0]['solicitud'];
	var detalles_solicitud = response[0]['detalle_solicitud'];
	var numDetalles        = detalles_solicitud.length - 1;

	setFormWithJSON(document.getElementById('RemesasMasivoForm'),solicitud,'true');   

	closeDialog();  

}

function cargaDatosOrden(response){

	var formulario   = document.getElementById('RemesasMasivoForm');  
	var orden_cargue = response[0]['orden_cargue'];

	setFormWithJSON(document.getElementById('RemesasMasivoForm'),orden_cargue,'true');   

	closeDialog();  

}


function resetContactos(){
	$("#contacto_id option").each(function(){
		if(this.value != 'NULL') $(this).remove();
	});
}


function separaCodigoDescripcion(){
	
	var producto            = $('#producto').val().split("-");
	var descripcion_empresa = producto[0];

	$('#producto').val(producto[0]);
	$('#descripcion_producto').val(producto[1]);
}


function updateGridRemesas(){
	$("#refresh_QUERYGRID_RemesasMasivo").click();
}

function setDataSeguroPoliza(amparada_por){

	$("#aseguradora_id,#numero_poliza").removeClass("requerido");		  
	
	if(amparada_por == 'E'){
		
		$("#aseguradora_id").val($("#aseguradora_id_static").val());
		$("#numero_poliza").val($("#numero_poliza_static").val());		
		$("#fecha_vencimiento_poliza").val($("#fecha_vencimiento_poliza_static").val());
		$("#aseguradora,#numero_poliza").addClass("obligatorio");
		
		
		document.getElementById('aseguradora_id').disabled  = true;
		document.getElementById('numero_poliza').readOnly = true;		
		
	}else if(amparada_por == 'N'){
		
		$("#aseguradora_id").val("NULL");
		$("#numero_poliza").val("");		
		$("#aseguradora,#numero_poliza").removeClass("obligatorio");		  
		
		document.getElementById('aseguradora_id').disabled= true;
		document.getElementById('numero_poliza').readOnly = true;				
		
	}else{

		$("#aseguradora_id").val("NULL");
		$("#numero_poliza").val("");		

		$("#aseguradora_id,#numero_poliza").addClass("obligatorio");		 
		
		document.getElementById('aseguradora_id').disabled = false;
		document.getElementById('numero_poliza').readOnly = false;				  		  

	}
	
	
}


function getDataClienteRemitente(cliente_id,cliente,obj){
	
	var QueryString = "ACTIONCONTROLER=getDataClienteRemitente&cliente_id="+cliente_id;
	
	$.ajax({
		url        : "RemesasMasivoClass.php?rand="+Math.random(),
		data       : QueryString,
		beforeSend : function(){
			showDivLoading();
		},
		success    : function(resp){

			try{

				var dataResp = $.parseJSON(resp);	 

				$("#remitente").val(dataResp[0]['remitente_destinatario']);
				$("#remitente_hidden").val(dataResp[0]['remitente_destinatario_id']);				 
				$("#origen").val(dataResp[0]['origen']);
				$("#origen_hidden").val(dataResp[0]['origen_id']);		  		  
				$("#doc_remitente").val(dataResp[0]['numero_identificacion']);				 				 
				$("#tipo_identificacion_remitente_id").val(dataResp[0]['tipo_identificacion_id']);				 				 				 				             $("#direccion_remitente").val(dataResp[0]['direccion']);				 				 				 
				$("#telefono_remitente").val(dataResp[0]['telefono']);				 				 				 	
				getDataClientePropietario(cliente_id,obj);

			}catch(e){
				alertJquery(resp,"Error :"+e);
			}

			removeDivLoading();
		}

	});	
	
}

function setDataRemitente(remitente_id,remitente,input){

	var QueryString = "ACTIONCONTROLER=getDataRemitente&remitente_destinatario_id="+remitente_id;
	
	$.ajax({
		url        : "RemesasMasivoClass.php?rand="+Math.random(),
		data       : QueryString,
		beforeSend : function(){
			showDivLoading();
		},
		success    : function(resp){

			try{

				var dataResp = $.parseJSON(resp);	 

				$("#remitente").val(dataResp[0]['remitente_destinatario']);
				$("#remitente_hidden").val(dataResp[0]['remitente_destinatario_id']);				 
				$("#origen").val(dataResp[0]['origen']);
				$("#origen_hidden").val(dataResp[0]['origen_id']);			 			 
				$("#doc_remitente").val(dataResp[0]['numero_identificacion']);				 				 
				$("#tipo_identificacion_remitente_id").val(dataResp[0]['tipo_identificacion_id']);
				$("#direccion_remitente").val(dataResp[0]['direccion']);				 				 				 
				$("#telefono_remitente").val(dataResp[0]['telefono']);				 				 				 	


			}catch(e){
				alertJquery(resp,"Error :"+e);
			}

			removeDivLoading();
		}

	});

	
}

function setDataDestinatario(destinatario_id,destinatario,input){

	var QueryString = "ACTIONCONTROLER=getDataDestinatario&remitente_destinatario_id="+destinatario_id;
	
	$.ajax({
		url        : "RemesasMasivoClass.php?rand="+Math.random(),
		data       : QueryString,
		beforeSend : function(){
			showDivLoading();
		},
		success    : function(resp){

			try{

				var dataResp = $.parseJSON(resp);	 

				$("#destinatario").val(dataResp[0]['remitente_destinatario']);
				$("#destinatario_hidden").val(dataResp[0]['remitente_destinatario_id']);				 
				$("#destino").val(dataResp[0]['destino']);			 
				$("#destino_hidden").val(dataResp[0]['destino_id']);			 			 			 			 
				$("#doc_destinatario").val(dataResp[0]['numero_identificacion']);				 				 
				$("#tipo_identificacion_destinatario_id").val(dataResp[0]['tipo_identificacion_id']);				 				 				 		     $("#direccion_destinatario").val(dataResp[0]['direccion']);				 				 				 
				$("#telefono_destinatario").val(dataResp[0]['telefono']);				 				 				 	


			}catch(e){
				alertJquery(resp,"Error :"+e);
			}

			removeDivLoading();
		}

	});

	
}



function getDataPropietario(tercero_id,tercero,obj){

	var QueryString = "ACTIONCONTROLER=getDataPropietario&tercero_id="+tercero_id;

	$.ajax({
		url        : "RemesasMasivoClass.php?rand="+Math.random(),
		data       : QueryString,
		beforeSend : function(){
			showDivLoading();
		},
		success    : function(resp){

			try{

				var data  = $.parseJSON(resp);
				var forma = obj.form;

				for(var llave in data[0]){
					$(forma).find("input[name="+llave+"]").val(data[0][llave]);
				}

			}catch(e){
				alertJquery(resp,"Error: "+e);
			}

			removeDivLoading();

		}
	});

}

function getDataClientePropietario(cliente_id,obj){

	var QueryString = "ACTIONCONTROLER=getDataClientePropietario&cliente_id="+cliente_id;

	$.ajax({
		url        : "RemesasMasivoClass.php?rand="+Math.random(),
		data       : QueryString,
		beforeSend : function(){
			showDivLoading();
		},
		success    : function(resp){

			try{

				var data  = $.parseJSON(resp);
				var forma = obj.form;   

				for(var llave in data[0]){	  
					$(forma).find("input[name="+llave+"]").val(data[0][llave]);
				}

			}catch(e){
				alertJquery(resp,"Error: "+e);
			}

			removeDivLoading();

		}
	}); 


}

function setValorLiquidacion(){

	$("#tipo_liquidacion").change(function(){

		if(this.value == 'P'){

			var peso           =  $("#peso").val();
			//var peso_neto      = ((peso * 1) * 0.001);
			var valor_unidad   = removeFormatCurrency($("#valor_unidad_facturar").val());
			var valor_facturar = (peso * valor_unidad);


			if(!isNaN(valor_facturar)){

				$("#valor_facturar").val(setFormatCurrency(valor_facturar,2));		
				document.getElementById('valor_unidad_facturar').readOnly = false;
				document.getElementById('valor_facturar').readOnly        = true;			  			  			

			}	


		}else if(this.value == 'V'){

			var peso_volumen   = (removeFormatCurrency($("#peso_volumen").val()) * 1);
			var valor_unidad   = removeFormatCurrency($("#valor_unidad_facturar").val());
			var valor_facturar = (peso_volumen * valor_unidad);
			
			if(!isNaN(valor_facturar)){ 

				$("#valor_facturar").val(setFormatCurrency(valor_facturar,2));		 
				document.getElementById('valor_unidad_facturar').readOnly = false;
				document.getElementById('valor_facturar').readOnly        = true;			  			  

			}	 

		}else if(this.value == 'C'){

			document.getElementById('valor_unidad_facturar').readOnly = true;
			document.getElementById('valor_facturar').readOnly        = false;			  
			$("#valor_unidad_facturar").val("0");		  
			$("#valor_facturar").val("");

		}										 

	});

	$("#valor_unidad_facturar").keyup(function(){

		var tipo_liquidacion = document.getElementById('tipo_liquidacion').value;

		if(tipo_liquidacion == 'P'){

			//var peso_neto      = (($("#peso").val() * 1) * 0.001);
			var peso = $("#peso").val();
			var valor_unidad   = removeFormatCurrency(this.value);
			var valor_facturar = (peso * valor_unidad);

			if(!isNaN(valor_facturar)){

				$("#valor_facturar").val(setFormatCurrency(valor_facturar,2));		
				document.getElementById('valor_unidad_facturar').readOnly = false;
				document.getElementById('valor_facturar').readOnly        = true;			  			  			

			}


		}else if(tipo_liquidacion == 'V'){

			var peso_volumen   = (removeFormatCurrency($("#peso_volumen").val()) * 1);
			var valor_unidad   = removeFormatCurrency(this.value);
			var valor_facturar = (peso_volumen * valor_unidad);
			
			if(!isNaN(valor_facturar)){ 

				$("#valor_facturar").val(setFormatCurrency(valor_facturar,2));		 
				document.getElementById('valor_unidad_facturar').readOnly = false;
				document.getElementById('valor_facturar').readOnly        = true;			  			  

			}

		}else if(tipo_liquidacion == 'C'){

			document.getElementById('valor_unidad_facturar').readOnly = true;
			document.getElementById('valor_facturar').readOnly        = false;			  
			$("#valor_unidad_facturar").val("0");		  
			$("#valor_facturar").val("");		  

		}						

	});
	
}

function setRemesaComplemento(){
	
	$("#clase_remesa").change(function(){

		var formulario = this.form;

		if(this.value == 'CP'){
			Reset(formulario);
			RemesasMasivoOnReset(formulario);		  
			document.getElementById("numero_remesa_padre").disabled = false;
			document.getElementById("clase_remesa").value           = 'CP';		
			$("#numero_remesa_padre").focus();
		}else{									  
			document.getElementById("numero_remesa_padre").disabled = true;		
			$("#numero_remesa_padre").val("");	  
		}

	});
	
}

function getRemesaComplemento(){

	$("#numero_remesa_padre").blur(function(){

		var numero_remesa = this.value;
		var forma         = this .form;
		var QueryString   = "ACTIONCONTROLER=getRemesaComplemento&numero_remesa="+numero_remesa; 									  
		if(numero_remesa > 0 && numero_remesa!=''){		 	 
			$.ajax({			
				url        : "RemesasMasivoClass.php?rand="+Math.random(),		
				data       : QueryString,
				beforeSend : function(){
					showDivLoading();
				},
				success    : function(resp){

					try{

						var data           = $.parseJSON(resp);
						var remesa         = data[0]['remesa'];
						var contacto_id    = remesa[0]['contacto_id'];		  		
						var cliente_id     = remesa[0]['cliente_id'];		  		

				 // setContactos(cliente_id,contacto_id);

				 setFormWithJSON(forma,remesa);

				 document.getElementById("numero_remesa_padre").disabled = false;	
				 document.getElementById('clase_remesa').value = 'CP';
				 document.getElementById('aprobacion_ministerio2').value = '';
				  //document.getElementById("complemento").value = 1;
				  $("#numero_remesa_padre").val(numero_remesa);
				  

				  if($('#guardar'))    $('#guardar').attr("disabled","");
				  if($('#actualizar')) $('#actualizar').attr("disabled","true");
				  if($('#borrar'))     $('#borrar').attr("disabled","true");
				  if($('#limpiar'))    $('#limpiar').attr("disabled","");


				}catch(e){
					alertJquery(e,"Error :");
				}	  

				removeDivLoading(); 




			}			
		});
		}

	});

}

function setRangoDesdeHasta(){

	$("#rango_desde").change(function(){

		document.getElementById('rango_hasta').value = this.value;									 

	});
	
}

function onclickCancellation(formulario){
	
	if($("#divAnulacion").is(":visible")){

		var formularioPrincipal = document.getElementById('RemesasMasivoForm');
		var causal_anulacion_id = $("#causal_anulacion_id").val();
		var observaciones       = $("#observaciones_anulacion").val();

		if(ValidaRequeridos(formulario)){

			var QueryString = "ACTIONCONTROLER=onclickCancellation&"+FormSerialize(formulario)+"&remesa_id="+$("#remesa_id").val();

			$.ajax({
				url  : "RemesasMasivoClass.php",
				data : QueryString,
				beforeSend: function(){
					showDivLoading();
				},
				success : function(response){

					Reset(formularioPrincipal);	
					RemesasMasivoOnReset();					  

					if($.trim(response) == 'true'){
						alertJquery('Remesa Anulada','Anulado Exitosamente');
					}else{
						alertJquery(response,'Inconsistencia Anulando');
					}

					removeDivLoading();
					$("#divAnulacion").dialog('close');

				}

			});

		}

	}else{
		
		var remesa_id = $("#remesa_id").val();
		var estado    = document.getElementById("estado").value;

		if(parseInt(remesa_id) > 0){		

			$("input[name=anular]").each(function(){ this.disabled = false; });

			$("#divAnulacion").dialog({
				title: 'Anulacion Remesa',
				width: 450,
				height: 280,
				closeOnEscape:true
			});
			
		}else{
			alertJquery('Debe Seleccionar primero una remesa','Anulacion');
		}		
		
	}  

	
}