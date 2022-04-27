// JavaScript Document
//eventos asignados a los objetos
$(document).ready(function(){

	$("#divAnulacion").css("display","none");
	// $("#proveedor").focus();
	leerCodigobar();
	setNovedad();

	$("#observaciones").blur(function(){
		var valor = $.trim(this.value);
		if(!valor.length > 0){
			$("#observaciones").val("NINGUNA");
		}
	});

	$("input[type=text]&&input[id=valor]").each(function(){
		setFormatCurrencyInput(this,2);
	});

});

	function setNovedad(){
		$("#guardar,#actualizar").click(function(){
			if(this.id == 'guardar'){
				onclickSave(this.id,this.form);
			}else{
				onclickUpdate(this.form);
			}
		});
	}

function onclickUpdate(formulario){


	// var novedad_id	= document.getElementById('novedad_id').value;
	// var obser_dev		= document.getElementById('obser_dev').value;

	// alertJquery(novedad_id+"-"+obser_dev+"");
	// if(!isNaN(novedad_id)){
	// 	var QueryString = "ACTIONCONTROLER=onclickUpdate&novedad_id="+novedad_id+"&obser_dev="+obser_dev;
	// 	$.ajax({
	// 		url        : "NovedadClass.php?rand="+Math.random(),
	// 		data       : QueryString,
	// 		beforeSend : function(){
	// 			showDivLoading();
	// 		},
	// 		success     : function(resp){
	// 			removeDivLoading();
	// 			if($.trim(resp) == 'true'){
	// 				alertJquery("Se he actualizado correctamente la observacion de la guia","Proceso completado");
	// 			}else{
	// 				alertJquery(resp,"Validacion");
	// 			}
	// 		}
	// 	});
	// }
}

//inicio save
function onclickSave(objId,formulario){

}
//fin save


function leerCodigobar(){
	$("#codigo_barras1").keypress(function (e) {
		if (e.which == 13) {	
			e.preventDefault();
			
			var guia = $("#codigo_barras1").val();
			var guia1 = $("#codigo_barras1").val();
			var causal_novedad_id = $("#causal_novedad_id").val();
			var fecha_dev = $("#fecha_dev").val();
			var obser_dev = $("#obser_dev").val();

			if(parseInt(causal_novedad_id)>0){
				if(document.getElementById('codigo_barras1').value!=''){
					$("#codigo_barras1").focus();
					if(guia == "NULL" || guia == ""){
						guia= 0;
					}else{
						var QueryString = "ACTIONCONTROLER=setLeerCodigobar&guia="+$('#codigo_barras1').val()+"&causal_novedad_id="+causal_novedad_id+"&fecha_dev="+fecha_dev+"&obser_dev="+obser_dev;
						$("#codigo_barras1").val('');

						$.ajax({
						   url        : 'NovedadClass.php?random='+Math.random(),
						   data       : QueryString,
						   beforeSend : function(){
							   showDivLoading();
						   },
						   success    : function(resp){
							try{
							   var data       = $.parseJSON(resp);
							   if(data[0]['estado_mensajeria_id']=='11' || data[0]['estado_mensajeria_id']=='10'){
									var guia			= data[0]['numero_guia'];
									var guia_id			= data[0]['guia_id'];
									var proveedor		= data[0]['proveedor'];
									var proveedor_id	= data[0]['proveedor_id'];
									var remitente		= data[0]['remitente'];
									var destinatario	= data[0]['destinatario'];
									var des_producto	= data[0]['descripcion_producto'];
									var peso			= data[0]['peso'];
									var cantidad		= data[0]['cantidad'];
									$("#guia_id").val(guia_id);
									$("#guia_dev").val(guia);
									$("#proveedor_id").val(proveedor_id);
									$("#proveedor").val(proveedor);
									$("#remitente").val(remitente);
									$("#destinatario").val(destinatario);
									$("#descripcion_producto").val(des_producto);
									$("#peso").val(peso);
									$("#cantidad").val(cantidad);
									$("#causal_novedad_id1").val(causal_novedad_id);
									addRowProduct();
									$("#mensaje_alerta").html("<span style='color:#090;'>La guia "+guia1+", fue seleccionada exitosamente</span>");
								}else{
									$("#mensaje_alerta").html("La guia "+guia1+",<br> No se encuentra en estado Transito");
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
				if(!parseInt(causal_novedad_id)>0 ){
					$("#mensaje_alerta").html("Por favor Seleccione una causal de novedad");
				}
				$("#codigo_barras1").focus();
				$("#codigo_barras1").val('');
			}
		}
	});
}

function addRowProduct(obj){
	numRow =1;
	var Tabla			=	document.getElementById('tableNovedad');
	var clon			=	document.getElementById('clon');
	var newRow			=	Tabla.insertRow(numRow);
	newRow.className	=	'rowGuias';
	newRow.innerHTML	=	clon.innerHTML;
}


function setDataFormWithResponse(){

	// var forma 		= document.forms[0];
	// var QueryString = "ACTIONCONTROLER=onclickFind&novedad_id="+$('#novedad_id').val();

	// $.ajax({
	// 	url        : 'NovedadClass.php?random='+Math.random(),
	// 	data       : QueryString,
	// 	beforeSend : function(){
	// 		showDivLoading();
	// 	},
	// 	success    : function(resp){

	// 		try{

	// 			var data       = $.parseJSON(resp);
	// 			var novedad = data[0]['novedad_id'];
	// 			var estado     = data[0]['estado'];

	// 			setFormWithJSON(forma,data,false,function(){

	// 				if(estado == 'A'){ 
	// 					disabledInputsFormNovedad(forma);
	// 				}else if(estado == 'D'){
	// 					enabledInputsFormNovedad(forma);
	// 				}
	// 				if($('#guardar')) document.getElementById('guardar').disabled = true;

	// 				if(estado == 'D'){
	// 					if($('#actualizar')) document.getElementById('actualizar').disabled = false;
	// 				}else{
	// 					if($('#actualizar')) document.getElementById('actualizar').disabled = true;
	// 				}

	// 				if($('#imprimir')) $('#imprimir').attr("disabled","");

	// 				if(estado == 'D'){
	// 					if($('#anular')) document.getElementById('anular').disabled = false;
	// 				}else if(estado == 'A'){
	// 					if($('#anular')) document.getElementById('anular').disabled = true;
	// 				}

	// 				if($('#limpiar'))    $('#limpiar').attr("disabled","");

	// 				removeDivLoading();	

	// 			});	

	// 		}catch(e){
	// 			//alertJquery(resp,"Error : "+e);
	// 			removeDivLoading();
	// 		}
	// 	}
	// });
}



function NovedadOnSave(formulario,novedad_id){		
   
	// if(parseInt(novedad_id)>0){
		
	//   updateGrid();
	  
	//   if($('#guardar'))    $('#guardar').attr("disabled","true");
	//   if($('#actualizar'))    $('#actualizar').attr("disabled","");	  
	//   if($('#limpiar'))    $('#limpiar').attr("disabled","");
	//    $('#novedad_id').val(novedad_id);
	// 	alertJquery("Guardado Exitosamente","Novedad");
 //  	}else{
	// 	if($('#guardar'))    $('#guardar').attr("disabled","");
	// 	if($('#actualizar')) $('#actualizar').attr("disabled","true");
	// 	if($('#limpiar'))    $('#limpiar').attr("disabled","");
	// }
}

function NovedadOnUpdate(formulario,resp){

 //    if($.trim(resp) ==  'true'){
	//   alertJquery("Novedad Actualizado Exitosamente","Novedad Carga");
	// }else{
	//     alertJquery(resp,"Error Actualizacion Novedad");
	// }	
	// updateGrid();
}

function beforePrint(formulario,url,title,width,height){

	// var novedad_id = parseInt($("#novedad_id").val());
	
	// if(isNaN(novedad_id)){
	  
	//   alertJquery('Debe seleccionar un Novedad a imprimir !!!','Impresion Novedad');
	//   return false;
	  
	// }else{	  
	//     return true;
	//   }
}

function NovedadOnDelete(formulario,resp){
	// Reset(formulario);	
	// NovedadOnReset(formulario);
	// clearFind();
	// updateGrid();
	// alertJquery(resp);
}

function NovedadOnReset(forma){
	
 //    enabledInputsFormNovedad(forma);	
	// clearFind();
	
	// $("#empresa_id").val($("#empresa_id_static").val());	
	// $("#oficina_id").val($("#oficina_id_static").val());
	// $("#updateNovedad").val('false');

	// document.getElementById('estado').value    = 'D';	
	// document.getElementById('estado').disabled = true;	


 //    $("#divAnulacion").css("display","none");
	
	// $('#guardar').attr("disabled","");
	// $('#actualizar').attr("disabled","true");
 //    if($('#anular')) document.getElementById('anular').disabled = true;	
	// $('#imprimir').attr("disabled","true");
	// $('#limpiar').attr("disabled","");	
}

function updateGrid(){
	// $("#refresh_QUERYGRID_Novedad").click();
}


function onclickCancellation(formulario){
	
	// if($("#divAnulacion").is(":visible")){
	 
	//    var formularioPrincipal = document.forms[0];
	//    var causal_anulacion_id = $("#causal_anulacion_id").val();
	//    var observaciones       = $("#observaciones_anulacion").val();
	   
 //       if(ValidaRequeridos(formulario)){
	
	//      var QueryString = "ACTIONCONTROLER=onclickCancellation&"+FormSerialize(formulario)+"&novedad_id="+$("#novedad_id").val();
		
	//      $.ajax({
 //           url  : "NovedadClass.php",
	//        data : QueryString,
	//        beforeSend: function(){
	// 		   showDivLoading();
	//        },
	//        success : function(response){
			 
	// 		 Reset(formularioPrincipal);
 //             NovedadOnReset(formulario);						  
						  
	// 	     if($.trim(response) == 'true'){
	// 			 alertJquery('Novedad Carga Anulado','Anulado Exitosamente');
	// 		 }else{
	// 			   alertJquery(response,'Inconsistencia Anulando');
	// 		   }
			   
	// 		 removeDivLoading();
 //             $("#divAnulacion").dialog('close');
			 
	//        }
	//     });	   
	//   }
	
 //    }else{
		
	//  var novedad_id = $("#novedad_id").val();
	//  var estado        = document.getElementById("estado").value;
	 
	//  if(parseInt(novedad_id) > 0){		
       
	// 	$("#divAnulacion").dialog({
	// 	  title: 'Anulacion Novedad de Carga',
	// 	  width: 450,
	// 	  height: 280,
	// 	  closeOnEscape:true
	// 	 });
			
	//  }else{
	// 	alertJquery('Debe Seleccionar primero un Novedad de carga','Anulacion');
	//   }		
 //   }  
}

function disabledInputsFormNovedad(forma){	
   // $(forma).find("input,select,textarea").each(function(){
																				
		 // if(this.type != 'button'){
			// this.disabled = true;
		 // }			
   // });		
}

function enabledInputsFormNovedad(forma){		
   // $(forma).find("input,select,textarea").each(function(){
		 // if(this.type != 'button'){
			// this.disabled = false;
		 // }
   // });
}