// JavaScript Document
//eventos asignados a los objetos
$(document).ready(function(){

	leerCodigobar();
	setEstado();

	$("input[type=text]&&input[id=valor]").each(function(){
		setFormatCurrencyInput(this,2);														 
	});  
});

function setEstado(){
		
	$("#guardar,#actualizar").click(function(){
											 
		if(this.id == 'guardar'){		  
		 	onclickSave(this.id,this.form);			  		  
	  }else{
		  onclickUpdate(this.form);			  		  		  
	  }											 
											 
	 });
	
}

function onclickUpdate(formulario){


	var entrega_id	= document.getElementById('entrega_id').value;
	var obser_ent		= document.getElementById('obser_ent').value;

	// alertJquery(entrega_id+"-"+obser_dev+"");
	if(!isNaN(entrega_id)){
		var QueryString = "ACTIONCONTROLER=onclickUpdate&entrega_id="+entrega_id+"&obser_ent="+obser_ent;
		$.ajax({
			url		  : "EstadoClass.php?rand="+Math.random(),
			data		 : QueryString,
			beforeSend : function(){
				showDivLoading();
			},
			success	  : function(resp){
				removeDivLoading();
				if($.trim(resp) == 'true'){
					alertJquery("Se he actualizado correctamente la observacion de la guia","Proceso completado");
				}else{
					alertJquery(resp,"Validacion");
				}
			}
		});
	}
}

//inicio save
function onclickSave(objId,formulario){

		var obj			  = document.getElementById(objId);
	  var formulario	 = obj.form;		
	  var guias			= '';
	  var contGuias	  = 0;
	  var QueryString	= '';	
	  var tableEstado  = document.getElementById('tableEstado');
	  var valida =0;
						  
		if(ValidaRequeridos(formulario)){
		  		 			
			var QueryString  = 'ACTIONCONTROLER=onclickSave&entrega_id=null&proveedor_id='+$("#proveedor_id").val()
									+'&fecha_ent='+$("#fecha_ent").val()+'&proveedor='+$("#proveedor").val()
								+'&obser_ent='+$("#obser_ent").val()+'&estado='+$("#estado").val()+QueryString;
			
			$.ajax({
			  url		  : "EstadoClass.php?rand="+Math.random(),
			 data		 : QueryString,
			 beforeSend : function(){
				showDivLoading();
			 },
			 success  : function(resp){				
			 			 
				  var entrega_id = parseInt(resp);
				 
				 if(!isNaN(entrega_id)){

					 EstadoOnSave(formulario,entrega_id);	
					 $("#refresh_QUERYGRID_Estado").click();	
					 
					 //var url = "EstadoClass.php?ACTIONCONTROLER=onclickPrint&entrega_id="+entrega_id+"&rand="+Math.random();
					 //popPup(url,10,900,600);
						  
				 }else{
					 alertJquery(resp,"Validacion Estado");
				  }		 
			 
				 removeDivLoading();	
					  			 
			  }
			 
			});
			
		 }												  

}
//fin save

function leerCodigobar(){
	$("#codigo_barras1").keypress(function (e) {
		if (e.which == 13) {	
			e.preventDefault();

			var guia = $("#codigo_barras1").val();
			var guia1 = $("#codigo_barras1").val();

			if(parseInt(guia)>0 ){

				$("#codigo_barras1").focus();

				var QueryString = "ACTIONCONTROLER=setLeerCodigobar&guia="+$('#codigo_barras1').val();
				$("#codigo_barras1").val('');
				$.ajax({
					url		  : 'EstadoClass.php?random='+Math.random(),
					data		 : QueryString,
					beforeSend : function(){
						showDivLoading();
					},
					success	 : function(resp){
					try{
						var data		 = $.parseJSON(resp);
						if(data[0]['estado_mensajeria_id']=='6' || data[0]['estado_mensajeria_id']=='7'){
							var guia = data[0]['numero_guia'];
							var guia_id = data[0]['guia_id'];
							var remitente = data[0]['remitente'];
							var destinatario = data[0]['destinatario'];
							var des_producto = data[0]['descripcion_producto'];
							var peso = data[0]['peso'];
							var cantidad = data[0]['cantidad'];
							var estado_anterior = data[0]['estado_mensajeria_id'];
							if (estado_anterior=='6') {
								estado_anterior = 'ENTREGADO';
							}else if(estado_anterior == '7'){
								estado_anterior = 'DEVUELTO';
							}
							$("#guia_id").val(guia_id);
							$("#guia_dev").val(guia);
							$("#remitente").val(remitente);
							$("#destinatario").val(destinatario);
							$("#descripcion_producto").val(des_producto);
							$("#peso").val(peso);
							$("#cantidad").val(cantidad);
							$("#estado_anterior").val(estado_anterior);
							addRowProduct();
							$("#mensaje_alerta").html("<span style='color:#090;'>La guia "+guia1+", fue seleccionada exitosamente</span>");
						}else{
							$("#mensaje_alerta").html("La guia "+guia1+",<br> No se encuentra en estado Devuelto o Entregado");
						}
					}catch(e){
						$("#mensaje_alerta").html(e);
					}
					$("#codigo_barras1").focus();
					$("#codigo_barras1").val('');
					removeDivLoading();
					}
				});
			}else{
				 $("#mensaje_alerta").html("No se digito Guia");
				 $("#codigo_barras1").focus();
			}
		}
	});
} 

function addRowProduct(obj){  	
		 numRow =1;
	  var Tabla			  = document.getElementById('tableEstado');
	  var clon	 = document.getElementById('clon');					
	  var newRow		 = Tabla.insertRow(numRow);
	  newRow.className = 'rowGuias';
	  newRow.innerHTML = clon.innerHTML;

}


function EstadoOnSave(formulario,entrega_id){		
	
	if(parseInt(entrega_id)>0){
		
	  updateGrid();
	  
	  if($('#guardar'))	 $('#guardar').attr("disabled","true");
	  if($('#actualizar'))	 $('#actualizar').attr("disabled","");	  
	  if($('#limpiar'))	 $('#limpiar').attr("disabled","");
		$('#entrega_id').val(entrega_id);
		alertJquery("Guardado Exitosamente","Estado");
	  
		 
  	}else{
		
		if($('#guardar'))	 $('#guardar').attr("disabled","");
		if($('#actualizar')) $('#actualizar').attr("disabled","true");
		if($('#limpiar'))	 $('#limpiar').attr("disabled","");		 
		
	}	
}

function EstadoOnUpdate(formulario,resp){

	 if($.trim(resp) ==  'true'){
	  alertJquery("Estado Actualizado Exitosamente","Estado Carga");
	}else{
		 alertJquery(resp,"Error Actualizacion Estado");
	}	
	updateGrid();
}

function EstadoOnReset(forma){
	
	 enabledInputsFormEstado(forma);	
	clearFind();
	
	$("#empresa_id").val($("#empresa_id_static").val());	
	$("#oficina_id").val($("#oficina_id_static").val());
	$("#updateEstado").val('false');
	
	$('#guardar').attr("disabled","");
	$('#actualizar').attr("disabled","true");
	 if($('#anular')) document.getElementById('anular').disabled = true;	
	$('#imprimir').attr("disabled","true");
	$('#limpiar').attr("disabled","");	
}

function disabledInputsFormEstado(forma){	
	$(forma).find("input,select,textarea").each(function(){
																				
		 if(this.type != 'button'){
			this.disabled = true;
		 }			
	});		
}

function enabledInputsFormEstado(forma){		
	$(forma).find("input,select,textarea").each(function(){
																				
		 if(this.type != 'button'){
			this.disabled = false;
		 }			
	});		
}