// JavaScript Document
//eventos asignados a los objetos
$(document).ready(function(){

	$("#divAnulacion").css("display","none");
	// $("#proveedor").focus();
	leerCodigobar();
	setDevolucion();

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

	function setDevolucion(){
		$("#guardar,#actualizar").click(function(){
			if(this.id == 'guardar'){
				onclickSave(this.id,this.form);
			}else{
				onclickUpdate(this.form);
			}
		});
	}

function onclickUpdate(formulario){


	// var devolucion_id	= document.getElementById('devolucion_id').value;
	// var obser_dev		= document.getElementById('obser_dev').value;

	// alertJquery(devolucion_id+"-"+obser_dev+"");
	// if(!isNaN(devolucion_id)){
	// 	var QueryString = "ACTIONCONTROLER=onclickUpdate&devolucion_id="+devolucion_id+"&obser_dev="+obser_dev;
	// 	$.ajax({
	// 		url        : "DevolucionPruebaClass.php?rand="+Math.random(),
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
			var causal_devolucion_id = $("#causal_devolucion_id").val();
			var fecha_dev = $("#fecha_dev").val();
			var obser_dev = $("#obser_dev").val();

			if(parseInt(causal_devolucion_id)>0){
				if(document.getElementById('codigo_barras1').value!=''){
					$("#codigo_barras1").focus();
					if(guia == "NULL" || guia == ""){
						guia= 0;
					}else{
						var QueryString = "ACTIONCONTROLER=setLeerCodigobar&guia="+$('#codigo_barras1').val()+"&causal_devolucion_id="+causal_devolucion_id+"&fecha_dev="+fecha_dev+"&obser_dev="+obser_dev;
						$("#codigo_barras1").val('');

						$.ajax({
						   url        : 'DevolucionPruebaClass.php?random='+Math.random(),
						   data       : QueryString,
						   beforeSend : function(){
							   showDivLoading();
						   },
						   success    : function(resp){
							try{
							   var data       = $.parseJSON(resp);
							   if(data[0]['estado_mensajeria_id']=='4' || data[0]['estado_mensajeria_id']=='10'){
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
									$("#causal_devolucion_id1").val(causal_devolucion_id);
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
				if(!parseInt(causal_devolucion_id)>0 ){
					$("#mensaje_alerta").html("Por favor Seleccione una causal de devolucion");
				}
				$("#codigo_barras1").focus();
				$("#codigo_barras1").val('');
			}
		}
	});
}

function addRowProduct(obj){
	numRow =1;
	var Tabla			=	document.getElementById('tableDevolucion');
	var clon			=	document.getElementById('clon');
	var newRow			=	Tabla.insertRow(numRow);
	newRow.className	=	'rowGuias';
	newRow.innerHTML	=	clon.innerHTML;
}


function setDataFormWithResponse(){

	// var forma 		= document.forms[0];
	// var QueryString = "ACTIONCONTROLER=onclickFind&devolucion_id="+$('#devolucion_id').val();

	// $.ajax({
	// 	url        : 'DevolucionPruebaClass.php?random='+Math.random(),
	// 	data       : QueryString,
	// 	beforeSend : function(){
	// 		showDivLoading();
	// 	},
	// 	success    : function(resp){

	// 		try{

	// 			var data       = $.parseJSON(resp);
	// 			var devolucion = data[0]['devolucion_id'];
	// 			var estado     = data[0]['estado'];

	// 			setFormWithJSON(forma,data,false,function(){

	// 				if(estado == 'A'){ 
	// 					disabledInputsFormDevolucion(forma);
	// 				}else if(estado == 'D'){
	// 					enabledInputsFormDevolucion(forma);
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



function DevolucionOnSave(formulario,devolucion_id){		
   
	// if(parseInt(devolucion_id)>0){
		
	//   updateGrid();
	  
	//   if($('#guardar'))    $('#guardar').attr("disabled","true");
	//   if($('#actualizar'))    $('#actualizar').attr("disabled","");	  
	//   if($('#limpiar'))    $('#limpiar').attr("disabled","");
	//    $('#devolucion_id').val(devolucion_id);
	// 	alertJquery("Guardado Exitosamente","Devolucion");
 //  	}else{
	// 	if($('#guardar'))    $('#guardar').attr("disabled","");
	// 	if($('#actualizar')) $('#actualizar').attr("disabled","true");
	// 	if($('#limpiar'))    $('#limpiar').attr("disabled","");
	// }
}

function DevolucionOnUpdate(formulario,resp){

 //    if($.trim(resp) ==  'true'){
	//   alertJquery("Devolucion Actualizado Exitosamente","Devolucion Carga");
	// }else{
	//     alertJquery(resp,"Error Actualizacion Devolucion");
	// }	
	// updateGrid();
}

function beforePrint(formulario,url,title,width,height){

	// var devolucion_id = parseInt($("#devolucion_id").val());
	
	// if(isNaN(devolucion_id)){
	  
	//   alertJquery('Debe seleccionar un Devolucion a imprimir !!!','Impresion Devolucion');
	//   return false;
	  
	// }else{	  
	//     return true;
	//   }
}

function DevolucionOnDelete(formulario,resp){
	// Reset(formulario);	
	// DevolucionOnReset(formulario);
	// clearFind();
	// updateGrid();
	// alertJquery(resp);
}

function DevolucionOnReset(forma){
	
 //    enabledInputsFormDevolucion(forma);	
	// clearFind();
	
	// $("#empresa_id").val($("#empresa_id_static").val());	
	// $("#oficina_id").val($("#oficina_id_static").val());
	// $("#updateDevolucion").val('false');

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
	// $("#refresh_QUERYGRID_Devolucion").click();
}


function onclickCancellation(formulario){
	
	// if($("#divAnulacion").is(":visible")){
	 
	//    var formularioPrincipal = document.forms[0];
	//    var causal_anulacion_id = $("#causal_anulacion_id").val();
	//    var observaciones       = $("#observaciones_anulacion").val();
	   
 //       if(ValidaRequeridos(formulario)){
	
	//      var QueryString = "ACTIONCONTROLER=onclickCancellation&"+FormSerialize(formulario)+"&devolucion_id="+$("#devolucion_id").val();
		
	//      $.ajax({
 //           url  : "DevolucionPruebaClass.php",
	//        data : QueryString,
	//        beforeSend: function(){
	// 		   showDivLoading();
	//        },
	//        success : function(response){
			 
	// 		 Reset(formularioPrincipal);
 //             DevolucionOnReset(formulario);						  
						  
	// 	     if($.trim(response) == 'true'){
	// 			 alertJquery('Devolucion Carga Anulado','Anulado Exitosamente');
	// 		 }else{
	// 			   alertJquery(response,'Inconsistencia Anulando');
	// 		   }
			   
	// 		 removeDivLoading();
 //             $("#divAnulacion").dialog('close');
			 
	//        }
	//     });	   
	//   }
	
 //    }else{
		
	//  var devolucion_id = $("#devolucion_id").val();
	//  var estado        = document.getElementById("estado").value;
	 
	//  if(parseInt(devolucion_id) > 0){		
       
	// 	$("#divAnulacion").dialog({
	// 	  title: 'Anulacion Devolucion de Carga',
	// 	  width: 450,
	// 	  height: 280,
	// 	  closeOnEscape:true
	// 	 });
			
	//  }else{
	// 	alertJquery('Debe Seleccionar primero un Devolucion de carga','Anulacion');
	//   }		
 //   }  
}

function disabledInputsFormDevolucion(forma){	
   // $(forma).find("input,select,textarea").each(function(){
																				
		 // if(this.type != 'button'){
			// this.disabled = true;
		 // }			
   // });		
}

function enabledInputsFormDevolucion(forma){		
   // $(forma).find("input,select,textarea").each(function(){
		 // if(this.type != 'button'){
			// this.disabled = false;
		 // }
   // });
}