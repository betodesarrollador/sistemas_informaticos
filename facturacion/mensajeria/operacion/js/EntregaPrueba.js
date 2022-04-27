// JavaScript Document
//eventos asignados a los objetos
$(document).ready(function(){

    $("#divAnulacion").css("display","none");	
	$("#proveedor").focus();
    leerCodigobar();
    setEntrega();
   
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

function setEntrega(){
		
	$("#guardar,#actualizar").click(function(){
											 
      if(this.id == 'guardar'){		  
       	onclickSave(this.id,this.form);			  		  
	  }else{
        onclickUpdate(this.form);			  		  		  
	  }											 
											 
    });
	
}

function onclickUpdate(formulario){


	// var entrega_id	= document.getElementById('entrega_id').value;
	// var obser_ent		= document.getElementById('obser_ent').value;

	// // alertJquery(entrega_id+"-"+obser_dev+"");
	// if(!isNaN(entrega_id)){
	// 	var QueryString = "ACTIONCONTROLER=onclickUpdate&entrega_id="+entrega_id+"&obser_ent="+obser_ent;
	// 	$.ajax({
	// 		url        : "EntregaPruebaClass.php?rand="+Math.random(),
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
			var fecha_ent = $("#fecha_ent").val();
			var obser_ent = $("#obser_ent").val();
			if(document.getElementById('codigo_barras1').value!=''){						
				$("#codigo_barras1").focus();
				if(guia == "NULL" || guia == ""){
					guia= 0;
				}else{
					var QueryString = "ACTIONCONTROLER=setLeerCodigobar&guia="+$('#codigo_barras1').val()+"&fecha_ent="+fecha_ent+"&obser_ent="+obser_ent;
					$("#codigo_barras1").val('');
					$.ajax({
					   url        : 'EntregaPruebaClass.php?random='+Math.random(),
					   data       : QueryString,
					   beforeSend : function(){
						   showDivLoading();
					   },
					   success    : function(resp){		   
						try{
							
						   var data       = $.parseJSON(resp);
							if(data[0]['estado_mensajeria_id']=='10' || data[0]['estado_mensajeria_id']=='7'){
								var guia			= data[0]['numero_guia'];
								var guia_id			= data[0]['guia_id'];
								var proveedor		= data[0]['proveedor'];
								var proveedor_id	= data[0]['proveedor_id'];
								var remitente		= data[0]['remitente'];
								var destinatario	= data[0]['destinatario'];
								var des_producto	= data[0]['descripcion_producto'];
								var peso			= data[0]['peso'];
								var cantidad		= data[0]['cantidad'];
								//var oficina_id		= data[0]['oficina_id'];
								$("#guia_id").val(guia_id);
								$("#guia_dev").val(guia);
								$("#proveedor").val(proveedor);
								$("#proveedor_id").val(proveedor_id);
								$("#remitente").val(remitente);
								$("#destinatario").val(destinatario);
								$("#descripcion_producto").val(des_producto);
								$("#peso").val(peso);
								$("#cantidad").val(cantidad);
								addRowProduct();
								$("#mensaje_alerta").html("<span style='color:#090;'>La guia "+guia1+", fue seleccionada exitosamente</span>");
							}else{
								$("#mensaje_alerta").html("La guia "+guia1+",<br> No se encuentra en estado EN OFICINA ni DEVUELTO.");
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
		}
	});
} 

function addRowProduct(obj){  	
       numRow =1;
	  var Tabla           = document.getElementById('tableEntrega');
	  var clon    = document.getElementById('clon');				   
	  var newRow       = Tabla.insertRow(numRow);
	  newRow.className = 'rowGuias';
	  newRow.innerHTML = clon.innerHTML;

}


function setDataFormWithResponse(){
	
	// var forma 		= document.forms[0];	
	// var QueryString = "ACTIONCONTROLER=onclickFind&entrega_id="+$('#entrega_id').val();
	
	// $.ajax({
 //       url        : 'EntregaPruebaClass.php?random='+Math.random(),
	//    data       : QueryString,
	//    beforeSend : function(){
	// 	   showDivLoading();
	//    },
	//    success    : function(resp){		   
		   	  
	// 	try{
			
	// 	   var data       = $.parseJSON(resp);
	// 	   var entrega = data[0]['entrega_id'];
	// 	   var estado     = data[0]['estado'];		   

	//        setFormWithJSON(forma,data,false,function(){														  
		  

 //  			if(estado == 'A'){ 
	// 			disabledInputsFormEntrega(forma);
	// 		}else if(estado == 'E'){
	// 			enabledInputsFormEntrega(forma);
	// 		}
	// 		if($('#guardar')) document.getElementById('guardar').disabled = true;

	// 		if(estado == 'E'){
	// 			if($('#actualizar')) document.getElementById('actualizar').disabled = false;
	// 		}else{
	// 			if($('#actualizar')) document.getElementById('actualizar').disabled = true;
	// 		}

	// 		if($('#imprimir')) $('#imprimir').attr("disabled","");

	// 		if(estado == 'E'){
	// 			if($('#anular')) document.getElementById('anular').disabled = false;
	// 		}else if(estado == 'A'){
	// 			if($('#anular')) document.getElementById('anular').disabled = true;
	// 		}

	// 		if($('#limpiar'))    $('#limpiar').attr("disabled","");
		   
	// 	   removeDivLoading();	
		   
 //         });	
		 
	//    }catch(e){
	// 	   //alertJquery(resp,"Error : "+e);
 //   		   removeDivLoading();
	// 	 }
	//    }
 //    });
}



function EntregaOnSave(formulario,entrega_id){		
   
	// if(parseInt(entrega_id)>0){
		
	//   updateGrid();
	  
	//   if($('#guardar'))    $('#guardar').attr("disabled","true");
	//   if($('#actualizar'))    $('#actualizar').attr("disabled","");	  
	//   if($('#limpiar'))    $('#limpiar').attr("disabled","");
	//    $('#entrega_id').val(entrega_id);
	// 	alertJquery("Guardado Exitosamente","Entrega");
	  
	    
 //  	}else{
		
	// 	if($('#guardar'))    $('#guardar').attr("disabled","");
	// 	if($('#actualizar')) $('#actualizar').attr("disabled","true");
	// 	if($('#limpiar'))    $('#limpiar').attr("disabled","");		 
		
	// }	
}

function EntregaOnUpdate(formulario,resp){

 //    if($.trim(resp) ==  'true'){
	//   alertJquery("Entrega Actualizado Exitosamente","Entrega Carga");
	// }else{
	//     alertJquery(resp,"Error Actualizacion Entrega");
	// }	
	// updateGrid();
}

function beforePrint(formulario,url,title,width,height){

	// var entrega_id = parseInt($("#entrega_id").val());
	
	// if(isNaN(entrega_id)){
	  
	//   alertJquery('Debe seleccionar un Entrega a imprimir !!!','Impresion Entrega');
	//   return false;
	  
	// }else{	  
	//     return true;
	//   }
}

function EntregaOnDelete(formulario,resp){
	// Reset(formulario);	
	// EntregaOnReset(formulario);
	// clearFind();
	// updateGrid();
	// alertJquery(resp);
}

function EntregaOnReset(forma){
	
 //    enabledInputsFormEntrega(forma);	
	// clearFind();
	
	// $("#empresa_id").val($("#empresa_id_static").val());	
	// $("#oficina_id").val($("#oficina_id_static").val());
	// $("#updateEntrega").val('false');

	// document.getElementById('estado').value    = 'E';	
	// document.getElementById('estado').disabled = true;	


 //    $("#divAnulacion").css("display","none");
	
	// $('#guardar').attr("disabled","");
	// $('#actualizar').attr("disabled","true");
 //    if($('#anular')) document.getElementById('anular').disabled = true;	
	// $('#imprimir').attr("disabled","true");
	// $('#limpiar').attr("disabled","");	
}

function updateGrid(){
	$("#refresh_QUERYGRID_Entrega").click();
}


function onclickCancellation(formulario){
	
	// if($("#divAnulacion").is(":visible")){
	 
	//    var formularioPrincipal = document.forms[0];
	//    var causal_anulacion_id = $("#causal_anulacion_id").val();
	//    var observaciones       = $("#observaciones_anulacion").val();
	   
 //       if(ValidaRequeridos(formulario)){
	
	//      var QueryString = "ACTIONCONTROLER=onclickCancellation&"+FormSerialize(formulario)+"&entrega_id="+$("#entrega_id").val();
		
	//      $.ajax({
 //           url  : "EntregaPruebaClass.php",
	//        data : QueryString,
	//        beforeSend: function(){
	// 		   showDivLoading();
	//        },
	//        success : function(response){
			 
	// 		 Reset(formularioPrincipal);
 //             EntregaOnReset(formulario);						  
						  
	// 	     if($.trim(response) == 'true'){
	// 			 alertJquery('Entrega Carga Anulado','Anulado Exitosamente');
	// 		 }else{
	// 			   alertJquery(response,'Inconsistencia Anulando');
	// 		   }
			   
	// 		 removeDivLoading();
 //             $("#divAnulacion").dialog('close');
			 
	//        }
	//     });	   
	//   }
	
 //    }else{
		
	//  var entrega_id = $("#entrega_id").val();
	//  var estado        = document.getElementById("estado").value;
	 
	//  if(parseInt(entrega_id) > 0){		
       
	// 	$("#divAnulacion").dialog({
	// 	  title: 'Anulacion Entrega de Carga',
	// 	  width: 450,
	// 	  height: 280,
	// 	  closeOnEscape:true
	// 	 });
			
	//  }else{
	// 	alertJquery('Debe Seleccionar primero un Entrega de carga','Anulacion');
	//   }		
 //   }  
}

function disabledInputsFormEntrega(forma){	
   // $(forma).find("input,select,textarea").each(function(){
																				
		 // if(this.type != 'button'){
			// this.disabled = true;
		 // }			
   // });		
}

function enabledInputsFormEntrega(forma){		
   // $(forma).find("input,select,textarea").each(function(){
																				
		 // if(this.type != 'button'){
			// this.disabled = false;
		 // }			
   // });		
}