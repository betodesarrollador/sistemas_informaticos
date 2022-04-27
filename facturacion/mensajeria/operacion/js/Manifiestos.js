// JavaScript Document
//eventos asignados a los objetos
$(document).ready(function(){

    $("#divAnulacion").css("display","none");	
	$("#proveedor").focus();
    leerCodigobar();
	leerCodigobar1();	
    setManifiesto();
	leerSolicitud();
	borrarf();	
   
   $("input[type=text]&&input[id=valor]").each(function(){
     setFormatCurrencyInput(this,2);														 
   }); 

   		/*		if($('#origen_hidden'))    $('#origen_hidden').val(data[0]['origen_id']);
				//if($('#cliente_id'))    $('#cliente_id').val(data[0]['cliente_id']);
				if($('#origen'))    $('#origen').val(data[0]['origen']); */

});

function borrarf(){
	
	if($("#borrar").length){
	   	$("#retirar_remesa").css("display","");

   }else{
	   	$("#retirar_remesa").css("display","none");
		$("#mensaje_alerta").html("No tiene permisos de Borrar");
	   
   }	
}


function setManifiesto(){
		
	$("#guardar,#actualizar").click(function(){
											 
      if(this.id == 'guardar'){		  
       	onclickSave(this.id,this.form);			  		  
	  }else{
        onclickUpdate(this.form);			  		  		  
	  }											 
											 
    });
	
}

function Descargar_excel(formulario){
	
   if(ValidaRequeridos(formulario)){
	   var reexpedido_id = parseInt($("#reexpedido_id").val());
	 var QueryString = "ManifiestoClass.php?ACTIONCONTROLER=onclickPrint&reexpedido_id="+reexpedido_id+"&download=SI";
	 popPup(QueryString,'Impresion Manifiesito',800,600);
	   
   }
}
function onclickUpdate(formulario){


	var reexpedido_id  = document.getElementById('reexpedido_id').value;
	var obser_rxp	   = document.getElementById('obser_rxp').value;
	var fecha_rxp      = document.getElementById('fecha_rxp').value;
	var destino_id     = document.getElementById('destino_hidden').value;
	var proveedor_id   = document.getElementById('proveedor_id').value;
	var placa          = document.getElementById('placa').value;
						
	if(ValidaRequeridos(formulario)){

	// alertJquery(reexpedido_id+"-"+obser_dev+"");
	if(!isNaN(reexpedido_id)){
		var QueryString = "ACTIONCONTROLER=onclickUpdate&reexpedido_id="+reexpedido_id+"&obser_rxp="+obser_rxp+"&fecha_rxp="+fecha_rxp+"&destino_id="+destino_id+"&proveedor_id="+proveedor_id+"&placa="+placa;
		
		$.ajax({
			url        : "ManifiestoClass.php?rand="+Math.random(),
			data       : QueryString,
			beforeSend : function(){
				showDivLoading();
			},
			success     : function(resp){
				removeDivLoading();
				if($.trim(resp) == 'true'){
					alertJquery("Se ha actualizado correctamente","Proceso completado");
				}else{
					alertJquery(resp,"Validacion");
				}
			}
		});
	}
	}
}

//inicio save
function onclickSave(objId,formulario){

      var obj           = document.getElementById(objId);
	  var formulario    = obj.form;	   
	  var guias         = '';
	  var contGuias     = 0;
	  var QueryString   = '';	
	  var tableManifiesto  = document.getElementById('tableManifiesto');
	  var valida =0;
	  var placa            = document.getElementById('placa').value; 
						  
      if(ValidaRequeridos(formulario)){
		  		 		   
		   var QueryString  = 'ACTIONCONTROLER=onclickSave&reexpedido_id=null&proveedor_id='+$("#proveedor_id").val()
		   						+'&reexpedido='+$("#reexpedido").val()+'&origen_id='+$("#origen_hidden").val()	
								+'&destino_id='+$("#destino_hidden").val()+'&empresa_id='+$("#empresa_id").val()	
		   						+'&fecha_rxp='+$("#fecha_rxp").val()+'&proveedor='+$("#proveedor").val()
								+'&oficina_id='+$("#oficina_id").val()+'&usuario_id='+$("#usuario_id").val()	
								+'&usuario_registra='+$("#usuario_registra").val()+'&usuario_registra_numero_identificacion='+$("#usuario_registra_numero_identificacion").val()	
								+'&fecha_registro='+$("#fecha_registro").val()+'&hora_salida='+$("#hora_salida").val()+'&interno='+$("#interno").val()
								+'&obser_rxp='+$("#obser_rxp").val()+'&estado='+$("#estado").val()+'&placa='+placa+QueryString;
		   
		   $.ajax({
		     url        : "ManifiestoClass.php?rand="+Math.random(),
			 data       : QueryString,
			 beforeSend : function(){
				showDivLoading();
			 },
			 success  : function(resp){	
			 try{
			 	 var datos = $.parseJSON(resp);
				 if(parseInt(datos[0]['reexpedido_id'])>0){
					 var reexpedido_id = parseInt(datos[0]['reexpedido_id']);
					 var reexpedido = parseInt(datos[0]['reexpedido']);
				 }else{
					 var resp1=resp;
				 }

				 if(!isNaN(reexpedido_id)){

					 ManifiestoOnSave(formulario,reexpedido_id,reexpedido);	
					 $("#refresh_QUERYGRID_Reexpedidos").click();	
					 
					 //var url = "ManifiestoClass.php?ACTIONCONTROLER=onclickPrint&reexpedido_id="+reexpedido_id+"&rand="+Math.random();
					 //popPup(url,10,900,600);
						  
				 }else{
					 alertJquery(resp1,"Validacion Manifiesto2");
				  }		 
			 
				
				}catch(e){
					alertJquery(resp,"Validacion Manifiesto21");
				}
                 removeDivLoading();	 			 
		     }
			 
		   });
	   
       }											     
}
//fin save

function leerSolicitud(){
	$("#solicitud").keypress(function (e) {
		if (e.which == 13) {	
			e.preventDefault();
			
			var reexpedido_id = $("#reexpedido_id").val();
			var solicitud = $("#solicitud").val();

			
			if(parseInt(reexpedido_id)>0 ){//si ya esta guardado el encabezado del reexpedido (manifiesto mensajero)
				
				if(parseInt(solicitud)>0  ){ 
				
						
					var QueryString = "ACTIONCONTROLER=setSolicitud&solicitud="+$('#solicitud').val()+"&reexpedido_id="+$("#reexpedido_id").val();

					$.ajax({
					   url        : 'ManifiestoClass.php?random='+Math.random(),
					   data       : QueryString,
					   beforeSend : function(){
						   showDivLoading();
					   },
					   success    : function(resp){		   
					    alertJquery(resp,"Validacion Manifiesto3");
						$("#solicitud").focus();
						$("#solicitud").val('');
						removeDivLoading();
					   }
					});
					
					
				}else if(document.getElementById('solicitud').value==''){
					
					alertJquery("Por favor digite una Solicitud","Validacion");	
					$("#solicitud").focus();
					$("#solicitud").val('');
				}
				
				
			}else{
				alertJquery("No se ha guardado el Manifiesto","Validacion");	
			}
		}
	});
} 

function leerCodigobar(){
	$("#codigo_barras1").keypress(function (e) {
		if (e.which == 13) {	
			e.preventDefault();
			
			var reexpedido_id = $("#reexpedido_id").val();
			var proveedor_id = $("#proveedor_id").val();
			var guia = $("#codigo_barras1").val();
			var guia1 = $("#codigo_barras1").val();
			
			if(parseInt(reexpedido_id)>0 ){//si ya esta guardado el encabezado del reexpedido (manifiesto mensajero)
				
				if(parseInt(proveedor_id)>0  ){ 
				
					if(document.getElementById('codigo_barras1').value!=''){ 
						
						$("#codigo_barras1").focus();									   
			
						if(guia == "NULL" || guia == ""){
							guia= 0;
						}else{
							var QueryString = "ACTIONCONTROLER=setLeerCodigobar&guia="+$('#codigo_barras1').val()+"&reexpedido_id="+$("#reexpedido_id").val();
							$("#codigo_barras1").val('');
							$.ajax({
							   url        : 'ManifiestoClass.php?random='+Math.random(),
							   data       : QueryString,
							   beforeSend : function(){
								   showDivLoading();
							   },
							   success    : function(resp){		   
								try{
									
								   var data       = $.parseJSON(resp);
	
								   if((data[0]['estado_mensajeria_id']=='1' || data[0]['estado_mensajeria_id']=='9' || data[0]['estado_mensajeria_id']=='7')  && data[0]['numero_guia']!=''){ //&& (data[0]['reexped']=='null' || data[0]['reexped']=='' || data[0]['reexped']==null)
									   var guia = data[0]['numero_guia'];
									   var guia_id = data[0]['guia_id'];
									   var remitente = data[0]['remitente'];
									   var destinatario = data[0]['destinatario'];						   
									   var des_producto = data[0]['descripcion_producto'];
									   var peso = data[0]['peso'];
									   var cantidad = data[0]['cantidad'];
									  $("#guia_id").val(guia_id);
									  $("#guia_dev").val(guia);
									   $("#remitente").val(remitente);
									   $("#destinatario").val(destinatario);
									   $("#descripcion_producto").val(des_producto);
									   $("#peso").val(peso);
									   $("#cantidad").val(cantidad);
									   addRowProduct();
										$("#mensaje_alerta").html("<span style='color:#090;'>La guia "+guia1+", fue seleccionada exitosamente</span>");
								   }else if((data[0]['estado_mensajeria_id']!='1' && data[0]['estado_mensajeria_id']!='9' && data[0]['estado_mensajeria_id']!='7' && (data[0]['reexped']!='null' && data[0]['reexped']!='' && data[0]['reexped']!=null )) && data[0]['numero_guia']!=''){
										 $("#mensaje_alerta").html("La guia "+guia1+",<br> No se encuentra en estado Alistamiento11 o Bodega Puente, esta asociada al manifiesto "+data[0]['reexped']);
								   }else if(data[0]['estado_mensajeria_id']!='1' && data[0]['estado_mensajeria_id']!='9'  && data[0]['numero_guia']!=''){
										 $("#mensaje_alerta").html("La guia "+guia1+",<br> No se encuentra en estado Alistamiento22 o Bodega Puente.");
								   }else if(data[0]['numero_guia']==''){   
										$("#mensaje_alerta").html("La guia "+guia1+",<br> No existe");
								   }
								}catch(e){
									$("#mensaje_alerta").html(" "+resp+"");
								}
								$("#codigo_barras1").focus();
								//$("#codigo_barras1").val('');
								removeDivLoading();
							   }
							});
						}
					}
				}else if(document.getElementById('codigo_barras1').value!=''){
					if(!parseInt(proveedor_id)>0 ){
						$("#mensaje_alerta").html("Por favor Seleccione Primero Un mensajero");
					}
					$("#codigo_barras1").focus();
					$("#codigo_barras1").val('');
					$("#proveedor").focus();
		
				}
				
				
			}else{//si no esta guardado el encabezado reexpedido (manifiesto mensajero)
			  formulario=this.form;
			  if(ValidaRequeridos(formulario)){
								   
				   var QueryString  = 'ACTIONCONTROLER=onclickSave&reexpedido_id=null&proveedor_id='+$("#proveedor_id").val()
										+'&reexpedido='+$("#reexpedido").val()+'&origen_id='+$("#origen_hidden").val()	
										+'&destino_id='+$("#destino_hidden").val()+'&empresa_id='+$("#empresa_id").val()	
										+'&fecha_rxp='+$("#fecha_rxp").val()+'&proveedor='+$("#proveedor").val()
										+'&oficina_id='+$("#oficina_id").val()+'&usuario_id='+$("#usuario_id").val()	
										+'&usuario_registra='+$("#usuario_registra").val()+'&usuario_registra_numero_identificacion='+$("#usuario_registra_numero_identificacion").val()	
										+'&fecha_registro='+$("#fecha_registro").val()+'&hora_salida='+$("#hora_salida").val()+'&interno='+$("#interno").val()
										+'&obser_rxp='+$("#obser_rxp").val()+'&estado='+$("#estado").val()+QueryString;
				   
				   $.ajax({
					 url        : "ManifiestoClass.php?rand="+Math.random(),
					 data       : QueryString,
					 beforeSend : function(){
						showDivLoading();
					 },
					 success  : function(resp){			
					 try{
						 var datos = $.parseJSON(resp); 	  	 			 
						 
						 var reexpedido_id = parseInt(datos[0]['reexpedido_id']);
						 var reexpedido = parseInt(datos[0]['reexpedido']);
		
						 if(parseInt(reexpedido_id)>0){
		
							 ManifiestoOnSave(formulario,reexpedido_id,reexpedido);	
							 $("#refresh_QUERYGRID_Reexpedidos").click();	
							 
							if(parseInt(proveedor_id)>0  ){ 
							
								if(document.getElementById('codigo_barras1').value!=''){ 
									
									$("#codigo_barras1").focus();									   
						
									if(guia == "NULL" || guia == ""){
										guia= 0;
									}else{
										var QueryString = "ACTIONCONTROLER=setLeerCodigobar&guia="+$('#codigo_barras1').val()+"&reexpedido_id="+reexpedido_id;
										$("#codigo_barras1").val('');
										$.ajax({
										   url        : 'ManifiestoClass.php?random='+Math.random(),
										   data       : QueryString,
										   beforeSend : function(){
											   showDivLoading();
										   },
										   success    : function(resp){		   
											try{
												
											   var data       = $.parseJSON(resp);
				
											   if((data[0]['estado_mensajeria_id']=='1' || data[0]['estado_mensajeria_id']=='9')  && data[0]['numero_guia']!=''){//&& (data[0]['reexped']=='null' || data[0]['reexped']=='' || data[0]['reexped']==null)
												   var guia = data[0]['numero_guia'];
												   var guia_id = data[0]['guia_id'];
												   var remitente = data[0]['remitente'];
												   var destinatario = data[0]['destinatario'];						   
												   var des_producto = data[0]['descripcion_producto'];
												   var peso = data[0]['peso'];
												   var cantidad = data[0]['cantidad'];
												  $("#guia_id").val(guia_id);
												  $("#guia_dev").val(guia);
												   $("#remitente").val(remitente);
												   $("#destinatario").val(destinatario);
												   $("#descripcion_producto").val(des_producto);
												   $("#peso").val(peso);
												   $("#cantidad").val(cantidad);
												   addRowProduct();
													$("#mensaje_alerta").html("<span style='color:#090;'>La guia "+guia1+", fue seleccionada exitosamente</span>");
											   }else if((data[0]['estado_mensajeria_id']!='1' && data[0]['estado_mensajeria_id']!='9' && (data[0]['reexped']!='null' && data[0]['reexped']!='' && data[0]['reexped']!=null )) && data[0]['numero_guia']!=''){
													 $("#mensaje_alerta").html("La guia "+guia1+",<br> No se encuentra en estado Alistamiento o Bodega Puente, esta asociada al manifiesto "+data[0]['reexped']);
											   }else if(data[0]['estado_mensajeria_id']!='1' && data[0]['estado_mensajeria_id']!='9'  && data[0]['numero_guia']!=''){
													 $("#mensaje_alerta").html("La guia "+guia1+",<br> No se encuentra en estado Alistamiento o Bodega Puente.");
											   }else if(data[0]['numero_guia']==''){   
													$("#mensaje_alerta").html("La guia "+guia1+",<br> No existe");
											   }else{
												   $("#mensaje_alerta").html("La guia  No existe");
											   }
											}catch(e){
												$("#mensaje_alerta").html("Error: "+resp+" o Guia no Existe");
											}
											$("#codigo_barras1").focus();
											//$("#codigo_barras1").val('');
											removeDivLoading();
										   }
										});
									}
								}
							}else if(document.getElementById('codigo_barras1').value!=''){
								if(!parseInt(proveedor_id)>0 ){
									$("#mensaje_alerta").html("Por favor Seleccione Primero Un mensajero");
								}
								$("#codigo_barras1").focus();
								$("#codigo_barras1").val('');
								$("#proveedor").focus();
					
							}
								  
						 }else{
							 alertJquery(resp,"Validacion Manifiesto4");
						  }		 
					 
						 
						}catch(e){
							alertJquery(resp,"Validacion Manifiesto41");
						}
						removeDivLoading();	
					 }
					 
				   });
			   
			   }											     
			}
		}
	});
} 

function leerCodigobar1(){
	$("#codigo_barras2").keypress(function (e) {
		if (e.which == 13) {	
			e.preventDefault();
			
			var reexpedido_id 	= $("#reexpedido_id").val();
			var proveedor_id 	= $("#proveedor_id").val();
			var guia 			= $("#codigo_barras2").val();
			var guia1			= $("#codigo_barras2").val();
			
			if(parseInt(reexpedido_id)>0 ){//si ya esta guardado el encabezado del reexpedido (manifiesto mensajero)
				
				if(parseInt(proveedor_id)>0  ){ 
				
					if(document.getElementById('codigo_barras2').value!=''){ 
						
						$("#codigo_barras2").focus();									   
			
						if(guia == "NULL" || guia == ""){
							guia= 0;
						}else{
							var QueryString = "ACTIONCONTROLER=setLeerCodigobar1&guia="+$('#codigo_barras2').val()+"&reexpedido_id="+$("#reexpedido_id").val();
							$("#codigo_barras2").val('');
							$.ajax({
							   url        : 'ManifiestoClass.php?random='+Math.random(),
							   data       : QueryString,
							   beforeSend : function(){
								   showDivLoading();
							   },
							   success    : function(resp){		   
								try{
									
								   var data       = $.parseJSON(resp);
	
								   if(data[0]['estado_mensajeria_id']=='4' && data[0]['reexped']!=''  && data[0]['numero_guia']!=''){
									   var guia = data[0]['numero_guia'];
									   var guia_id = data[0]['guia_id'];
									   var remitente = data[0]['remitente'];
									   var destinatario = data[0]['destinatario'];						   
									   var des_producto = data[0]['descripcion_producto'];
									   var peso = data[0]['peso'];
									   var cantidad = data[0]['cantidad'];
									  $("#guia_id1").val(guia_id);
									  $("#guia_dev1").val(guia);
									   $("#remitente1").val(remitente);
									   $("#destinatario1").val(destinatario);
									   $("#descripcion_producto1").val(des_producto);
									   $("#peso1").val(peso);
									   $("#cantidad1").val(cantidad);
									   addRowProduct1();
										$("#mensaje_alerta1").html("<span style='color:#090;'>La guia "+guia1+", fue retirada exitosamente</span>");
								   }else if((data[0]['estado_mensajeria_id']!='4' && (data[0]['reexped']!='null' && data[0]['reexped']!='' && data[0]['reexped']!=null )) && data[0]['numero_guia']!=''){
										 $("#mensaje_alerta1").html("La guia "+guia1+",<br> No se encuentra en estado Transito Y no esta enlazada a este manifiesto. "+data[0]['reexped']);
								   }else if(data[0]['estado_mensajeria_id']!='4'  && data[0]['numero_guia']!=''){
										 $("#mensaje_alerta1").html("La guia "+guia1+",<br> No se encuentra en estado Transito");
								   }else if(data[0]['numero_guia']==''){   
										$("#mensaje_alerta1").html("La guia "+guia1+",<br> No existe");
								   }
								}catch(e){
									$("#mensaje_alerta1").html(" "+resp+"");
								}
								$("#codigo_barras2").focus();
								//$("#codigo_barras1").val('');
								removeDivLoading();
							   }
							});
						}
					}
				}else if(document.getElementById('codigo_barras2').value!=''){
					if(!parseInt(proveedor_id)>0 ){
						$("#mensaje_alerta1").html("Por favor Seleccione Primero Un mensajero");
					}
					$("#codigo_barras2").focus();
					$("#codigo_barras2").val('');
					$("#proveedor").focus();
		
				}
				
				
			}else{//si no esta guardado el encabezado reexpedido (manifiesto mensajero)
			  formulario=this.form;
			  if(ValidaRequeridos(formulario)){
								   
				   var QueryString  = 'ACTIONCONTROLER=onclickSave&reexpedido_id=null&proveedor_id='+$("#proveedor_id").val()
										+'&reexpedido='+$("#reexpedido").val()+'&origen_id='+$("#origen_hidden").val()	
										+'&destino_id='+$("#destino_hidden").val()+'&empresa_id='+$("#empresa_id").val()	
										+'&fecha_rxp='+$("#fecha_rxp").val()+'&proveedor='+$("#proveedor").val()
										+'&oficina_id='+$("#oficina_id").val()+'&usuario_id='+$("#usuario_id").val()	
										+'&usuario_registra='+$("#usuario_registra").val()+'&usuario_registra_numero_identificacion='+$("#usuario_registra_numero_identificacion").val()	
										+'&fecha_registro='+$("#fecha_registro").val()+'&hora_salida='+$("#hora_salida").val()+'&interno='+$("#interno").val()
										+'&obser_rxp='+$("#obser_rxp").val()+'&estado='+$("#estado").val()+QueryString;
				   
				   $.ajax({
					 url        : "ManifiestoClass.php?rand="+Math.random(),
					 data       : QueryString,
					 beforeSend : function(){
						showDivLoading();
					 },
					 success  : function(resp){	
					 try{
						 var datos = $.parseJSON(resp); 	  	 			 
						 
						 var reexpedido_id = parseInt(datos[0]['reexpedido_id']);
						 var reexpedido = parseInt(datos[0]['reexpedido']);
		
						 if(parseInt(reexpedido_id)>0){
		
							 ManifiestoOnSave(formulario,reexpedido_id,reexpedido);	
							 $("#refresh_QUERYGRID_Reexpedidos").click();	
							 
							if(parseInt(proveedor_id)>0  ){ 
							
								if(document.getElementById('codigo_barras2').value!=''){ 
									
									$("#codigo_barras2").focus();									   
						
									if(guia == "NULL" || guia == ""){
										guia= 0;
									}else{
										var QueryString = "ACTIONCONTROLER=setLeerCodigobar1&guia="+$('#codigo_barras2').val()+"&reexpedido_id="+reexpedido_id;
										$("#codigo_barras2").val('');
										$.ajax({
										   url        : 'ManifiestoClass.php?random='+Math.random(),
										   data       : QueryString,
										   beforeSend : function(){
											   showDivLoading();
										   },
										   success    : function(resp){		   
											try{
												
											   var data       = $.parseJSON(resp);
				
											   if(data[0]['estado_mensajeria_id']=='4' && data[0]['reexped']!='' && data[0]['numero_guia']!=''){
												   var guia = data[0]['numero_guia'];
												   var guia_id = data[0]['guia_id'];
												   var remitente = data[0]['remitente'];
												   var destinatario = data[0]['destinatario'];						   
												   var des_producto = data[0]['descripcion_producto'];
												   var peso = data[0]['peso'];
												   var cantidad = data[0]['cantidad'];
												  $("#guia_id1").val(guia_id);
												  $("#guia_dev1").val(guia);
												   $("#remitente1").val(remitente);
												   $("#destinatario1").val(destinatario);
												   $("#descripcion_producto1").val(des_producto);
												   $("#peso1").val(peso);
												   $("#cantidad1").val(cantidad);
												   addRowProduct1();
													$("#mensaje_alerta1").html("<span style='color:#090;'>La guia "+guia1+", fue retirada exitosamente</span>");
											   }else if((data[0]['estado_mensajeria_id']!='4' && (data[0]['reexped']!='null' && data[0]['reexped']!='' && data[0]['reexped']!=null )) && data[0]['numero_guia']!=''){
													 $("#mensaje_alerta1").html("La guia "+guia1+",<br> No se encuentra en estado Transito Y No esta enlazada a este Manifiesto.");
											   }else if(data[0]['estado_mensajeria_id']!='4'  && data[0]['numero_guia']!=''){
													 $("#mensaje_alerta1").html("La guia "+guia1+",<br> No se encuentra en estado Transito");
											   }else if(data[0]['numero_guia']==''){   
													$("#mensaje_alerta1").html("La guia "+guia1+",<br> No existe");
											   }
											}catch(e){
												$("#mensaje_alerta1").html(" "+resp+"");
											}
											$("#codigo_barras2").focus();
											//$("#codigo_barras1").val('');
											removeDivLoading();
										   }
										});
									}
								}
							}else if(document.getElementById('codigo_barras2').value!=''){
								if(!parseInt(proveedor_id)>0 ){
									$("#mensaje_alerta1").html("Por favor Seleccione Primero Un mensajero");
								}
								$("#codigo_barras2").focus();
								$("#codigo_barras2").val('');
								$("#proveedor").focus();
					
							}
								  
						 }else{
							 alertJquery(resp,"Validacion Manifiesto1");
						  }		 
						}catch(e){
							alertJquery(resp,"Validacion Manifiesto11");
						}
					 
						 removeDivLoading();	
									 
					 }
					 
				   });
			   
			   }											     
			}
		}
	});
} 

function addRowProduct(obj){  	
       numRow =1;
	  var Tabla           = document.getElementById('tableManifiesto');
	  var clon    = document.getElementById('clon');				   
	  var newRow       = Tabla.insertRow(numRow);
	  newRow.className = 'rowGuias';
	  newRow.innerHTML = clon.innerHTML;

	var n_guias = $("#n_guias").val();
	if ($("#n_guias").val().length<1) {
		var n_guias=0;
		n_guias++;
	}else{
		n_guias++;
	}
	$("#n_guias").val(n_guias);

}

function addRowProduct1(obj){  	
      numRow1 =1;
	  var Tabla1       	= document.getElementById('tableManifiesto1');
	  var clon1    		= document.getElementById('clon1');				   
	  var newRow1      	= Tabla1.insertRow(numRow1);
	  newRow1.className 	= 'rowGuias1';
	  newRow1.innerHTML 	= clon1.innerHTML;

	var n_guias = $("#n_guias").val();
	if ($("#n_guias").val().length<1) {
		var n_guias=0;
		n_guias--;
	}else{
		n_guias--;
	}
	$("#n_guias").val(n_guias);

}

function setDataFormWithResponse(){
	
	var forma 		= document.forms[0];	
	var QueryString = "ACTIONCONTROLER=onclickFind&reexpedido_id="+$('#reexpedido_id').val();
	
	$.ajax({
       url        : 'ManifiestoClass.php?random='+Math.random(),
	   data       : QueryString,
	   beforeSend : function(){
		   showDivLoading();
	   },
	   success    : function(resp){		   
		   	  
		try{
			
		   var data       = $.parseJSON(resp);
		   var reexpedido = data[0]['reexpedido_id'];
		   var estado     = data[0]['estado'];		   

	       setFormWithJSON(forma,data,false,function(){														  
		  

  			if(estado == 'A'){ 
				disabledInputsFormManifiesto(forma);
			}else if(estado == 'P'){
				enabledInputsFormManifiesto(forma);
			}
			if($('#guardar')) document.getElementById('guardar').disabled = true;

			if(estado == 'M'){
				if($('#actualizar')) document.getElementById('actualizar').disabled = false;
			}else{
				if($('#actualizar')) document.getElementById('actualizar').disabled = true;
			}

			if($('#imprimir')) $('#imprimir').attr("disabled","");
			if($('#imprimir1')) $('#imprimir1').attr("disabled","");

			if(estado == 'M'){
				if($('#anular')) document.getElementById('anular').disabled = false;
			}else if(estado == 'A'){
				if($('#anular')) document.getElementById('anular').disabled = true;
			}
			 if($('#excel'))   if(document.getElementById('excel'))document.getElementById('excel').disabled = false;
			if($('#limpiar'))    $('#limpiar').attr("disabled","");
		   
		   removeDivLoading();	
		   
         });	
		 
	   }catch(e){
		   //alertJquery(resp,"Error : "+e);
   		   removeDivLoading();
		 }
	   }
    });
}



function ManifiestoOnSave(formulario,reexpedido_id,reexpedido){		
   
	if(parseInt(reexpedido_id)>0){
		
	  updateGrid();
	  
	  if($('#guardar'))    $('#guardar').attr("disabled","true");
	  if($('#actualizar'))    $('#actualizar').attr("disabled","");	  
	  if($('#limpiar'))    $('#limpiar').attr("disabled","");
	   $('#reexpedido_id').val(reexpedido_id);
	    $('#reexpedido').val(reexpedido);
		alertJquery("Guardado Exitosamente","Manifiesto");
	  
	    
  	}else{
		
		if($('#guardar'))    $('#guardar').attr("disabled","");
		if($('#actualizar')) $('#actualizar').attr("disabled","true");
		if($('#limpiar'))    $('#limpiar').attr("disabled","");		 
		
	}	
}

function ManifiestoOnUpdate(formulario,resp){

    if($.trim(resp) ==  'true'){
	  alertJquery("Manifiesto Actualizado Exitosamente","Manifiesto Carga");
	}else{
	    alertJquery(resp,"Error Actualizacion Manifiesto");
	}	
	updateGrid();
}

function beforePrint(formulario,id){

	var reexpedido_id = parseInt($("#reexpedido_id").val());
	
	if(id=='imprimir'){
		document.getElementById('tipo_impre').value='S';
		var tipo_impre ='S';
	}else{
		document.getElementById('tipo_impre').value='F';
		var tipo_impre ='F';
		
	}
	
	var QueryString = "ManifiestoClass.php?ACTIONCONTROLER=onclickPrint&reexpedido_id="+reexpedido_id+"&tipo_impre="+tipo_impre;  
	popPup(QueryString,'Impresion Manifiesto',800,600);
	
	if(isNaN(reexpedido_id)){
	  
	  alertJquery('Debe seleccionar un Manifiesto a imprimir !!!','Impresion Manifiesto');
	  return false;
	  
	}else{	  
	    return true;
	  }
}

function ManifiestoOnDelete(formulario,resp){
	Reset(formulario);	
	ManifiestoOnReset(formulario);
	clearFind();
	updateGrid();
	alertJquery(resp);
}

function ManifiestoOnReset(forma){
	
    enabledInputsFormManifiesto(forma);	
	clearFind();
	
	$("#empresa_id").val($("#empresa_id_static").val());	
	$("#oficina_id").val($("#oficina_id_static").val());
	$("#updateManifiesto").val('false');

	document.getElementById('estado').value    = 'M';	
	document.getElementById('estado').disabled = true;	

	document.getElementById('origen').value= document.getElementById('origencopia').value;
	document.getElementById('origen_hidden').value= document.getElementById('origencopia_id').value;


    $("#divAnulacion").css("display","none");
	
	$('#guardar').attr("disabled","");
	$('#actualizar').attr("disabled","true");
    if($('#anular')) document.getElementById('anular').disabled = true;	
	if($('#excel'))   if(document.getElementById('excel'))document.getElementById('excel').disabled = true;			
	$('#imprimir').attr("disabled","");
	$('#imprimir1').attr("disabled","");
	$('#limpiar').attr("disabled","");	
}

function updateGrid(){
	$("#refresh_QUERYGRID_Reexpedidos").click();
}


function onclickCancellation(formulario){
	
	if($("#divAnulacion").is(":visible")){
	 
	   var formularioPrincipal = document.forms[0];
	   var causal_anulacion_id = $("#causal_anulacion_id").val();
	   var observaciones       = $("#observaciones_anulacion").val();
	   
       if(ValidaRequeridos(formulario)){
	
	     var QueryString = "ACTIONCONTROLER=onclickCancellation&"+FormSerialize(formulario)+"&reexpedido_id="+$("#reexpedido_id").val();
		
	     $.ajax({
           url  : "ManifiestoClass.php",
	       data : QueryString,
	       beforeSend: function(){
			   showDivLoading();
	       },
	       success : function(response){
			 
			 Reset(formularioPrincipal);
             ManifiestoOnReset(formulario);						  
						  
		     if($.trim(response) == 'true'){
				 alertJquery('Manifiesto Mensajero Anulado','Anulado Exitosamente');
			 }else{
				   alertJquery(response,'Inconsistencia Anulando');
			   }
			   
			 removeDivLoading();
             $("#divAnulacion").dialog('close');
			 
	       }
	    });	   
	  }
	
    }else{
		
	 var reexpedido_id = $("#reexpedido_id").val();
	 var estado        = document.getElementById("estado").value;
	 
	 if(parseInt(reexpedido_id) > 0){		
       
		$("#divAnulacion").dialog({
		  title: 'Anulacion Manifiesto Mensajero',
		  width: 450,
		  height: 280,
		  closeOnEscape:true
		 });
			
	 }else{
		alertJquery('Debe Seleccionar primero un Manifiesto Mensajero','Anulacion');
	  }		
   }  
}

function disabledInputsFormManifiesto(forma){	
   $(forma).find("input,select,textarea").each(function(){
																				
		 if(this.type != 'button'){
			this.disabled = true;
		 }			
   });		
}

function enabledInputsFormManifiesto(forma){		
   $(forma).find("input,select,textarea").each(function(){
																				
		 if(this.type != 'button'){
			this.disabled = false;
		 }			
   });		
}