function setDataFormWithResponse(){

		

	var parametros  = new Array({campos:"encabezado_registro_id",valores:$('#encabezado_registro_id').val()});

	var forma       = document.forms[0];

	var controlador = 'MovimientosContablesClass.php';

	

	FindRow(parametros,forma,controlador,null,function(resp){

													   													   	  

	 var encabezado_registro_id = $('#encabezado_registro_id').val();	 

     var url    = "ImputacionesContablesClass.php?encabezado_registro_id="+encabezado_registro_id+"&rand="+Math.random();

	 

	 $("#movimientosContables").attr("src",url);

	 $("#movimientosContables").load(function(){

  	    getTotalDebitoCredito(encabezado_registro_id);

     });

	 

	 if($.trim($("#anulado").val()) == '1'){		 

	   if($('#guardar'))    $('#guardar').attr("disabled","true");

	   if($('#actualizar')) $('#actualizar').attr("disabled","true");

	   if($('#anular'))     $('#anular').attr("disabled","true");	   

	   if($('#borrar'))     $('#borrar').attr("disabled","true");
	   
	   if($('#estado'))     $('#estado').attr("disabled","true");

	   

	   $("#msj_anulado").css("display","");

	   $("#saveImputacionesContables").css("display","none");	   

	   $("#deleteImputacionesContables").css("display","none");	   	   

	   

	 }else{

	     if($('#guardar'))    $('#guardar').attr("disabled","true");

	     if($('#actualizar')) $('#actualizar').attr("disabled","");

	     if($('#anular'))     $('#anular').attr("disabled","");	   		 

	     if($('#borrar'))     $('#borrar').attr("disabled","");	
		 
		 if($('#estado'))     $('#estado').attr("disabled","true");

		 

 	     $("#msj_anulado").css("display","none");

	     $("#saveImputacionesContables").css("display","");	   

	     $("#deleteImputacionesContables").css("display","");	   	   		 

	   }

	  

	 if($('#limpiar'))    $('#limpiar').attr("disabled","");



     if($.trim($("#estado").val()) == 'E'){

      $("#contabilizar").css("display","");	
	  
	  $('#estado').attr("disabled","true");

	 }else{

         $("#contabilizar").css("display","none");
		 
		 $('#estado').attr("disabled","true");

	  }

	 

													   

    });





		

}



function MovimientosContablesOnSave(formulario,resp){

	   

   try{

	   

		var data = $.parseJSON(resp);

			  

		if($.isArray(data)){

	 

		var encabezado_registro_id = data[0]['encabezado_registro_id'];

		var consecutivo            = data[0]['consecutivo'];

		

		var url = "ImputacionesContablesClass.php?encabezado_registro_id="+encabezado_registro_id+"&rand="+Math.random();

					

			$("#encabezado_registro_id").val(encabezado_registro_id);						

			$("#consecutivo").val(consecutivo);								

			$("#movimientosContables").attr("src",url);						   

			

			if($('#guardar'))    $('#guardar').attr("disabled","true");

			if($('#actualizar')) $('#actualizar').attr("disabled","");

			if($('#borrar'))     $('#borrar').attr("disabled","");

			if($('#limpiar'))    $('#limpiar').attr("disabled","");		

			

			$("#contabilizar").css("display","");		  

			  

	  }else {

		 alertJquery(resp,'Validacion Registro Contable');

		 $("#contabilizar").css("display","none");	

		}

		 

   }catch(e){

	     alertJquery(resp,"Validacion Registros Contables !!");

	  }

		 	  

	

}



function MovimientosContablesOnUpdate(formulario,resp){



      if($('#guardar'))    $('#guardar').attr("disabled","true");

	  if($('#actualizar')) $('#actualizar').attr("disabled","");

	  if($('#borrar'))     $('#borrar').attr("disabled","");

	  if($('#limpiar'))    $('#limpiar').attr("disabled","");

	  

	  

      if($.trim(resp) == 'true' || parseInt(resp) > 0){

		  		

	    var encabezado_registro_id = $('#encabezado_registro_id').val();

	    var url    = "ImputacionesContablesClass.php?encabezado_registro_id="+encabezado_registro_id+"&rand="+Math.random();

				

        $("#movimientosContables").attr("src",url);						   

        if($.trim($("#estado").val()) != 'E') $("#contabilizar").css("display","none");	 		

		

		alertJquery("Se actualizo exitosamente",'Registros Contables');

		  

	  }else {

		   alertJquery(resp,'Registros Contables');

		   

		   if($("#contabilizar").is(":visible")) $("#estado").val("E");

		 }

		 



}





function MovimientosContablesOnDelete(formulario,resp){

	

   Reset(document.getElementById('MovimientosContablesForm'));

   MovimientosContablesOnReset();

   

   alertJquery(resp);  

	

}



function MovimientosContablesOnReset(){

	

  clearFind();

  

  $("#modifica").val($("#modifica_static").val());

  $("#usuario_id").val($("#usuario_id_static").val());

  $("#fecha_registro").val($("#fecha_registro_static").val());  

  

  document.getElementById('estado').value = 'E';



  $("#movimientosContables").attr("src","/rotterdan/framework/tpl/blank.html");						   

  $("#msj_anulado").css("display","none"); 

  $("#totalDebito").html("0.00");

  $("#totalCredito").html("0.00");	  

  

  $('#guardar').attr("disabled","");

  $('#actualizar').attr("disabled","true");

  $('#borrar').attr("disabled","true");

  $('#limpiar').attr("disabled","");  

  

}



function getTotalDebitoCredito(encabezado_registro_id){

		

	var QueryString = "ACTIONCONTROLER=getTotalDebitoCredito&encabezado_registro_id="+encabezado_registro_id;

	

	$.ajax({

      url     : "MovimientosContablesClass.php",

	  data    : QueryString,

	  success : function(response){

		  		  

		  try{

			 var totalDebitoCredito = $.parseJSON(response); 

             var totalDebito        = parseFloat(totalDebitoCredito[0]['debito']) > 0 ? totalDebitoCredito[0]['debito'] : 0;

			 var totalCredito       = parseFloat(totalDebitoCredito[0]['credito']) > 0 ? totalDebitoCredito[0]['credito'] : 0;

			 var totalDiferencia    = Math.abs(totalDebito - totalCredito);              

			 

			 $("#totalDebito").html(totalDebito);

			 $("#totalCredito").html(totalCredito);

			 $("#totalDiferencia").html(totalDiferencia);		 

		  }catch(e){

			  

			}

      }

	  

    });    





}



function beforePrint(formulario,url,title,width,height){



  var encabezado_registro_id = $('#encabezado_registro_id').val();

  

  if(encabezado_registro_id > 0){

    return true;

  }else{

	  alertJquery("Ningun Comprobante Seleccionado","Impresion Documento Contable");

	  return false;

	}	

}



function setTitulosDocumento(Id){

	

  var QueryString = "ACTIONCONTROLER=setTitulosDocumento&tipo_documento_id="+Id;

  

  $.ajax({

    url     : "MovimientosContablesClass.php",

	data    : QueryString,

	success : function(responsetext){



      try{

		  

		var Titulos          = $.parseJSON(responsetext);   

        var requiere_soporte = Titulos[0]['requiere_soporte'];				

		

        $("#texto_tercero").html(Titulos[0]['texto_tercero']);

        $("#texto_soporte").html(Titulos[0]['texto_soporte']);		

		

		if(parseInt(requiere_soporte) == 1){

		  $("#numero_soporte").addClass("obligatorio");

    	}else{

		     $("#numero_soporte").removeClass("obligatorio");			

  		     $("#numero_soporte").removeClass("requerido");			 

		  }



      }catch(e){

		  }



  	}

	

  });

	

}



function onclickCancellation(formulario){

	

	if($("#divAnulacion").is(":visible")){

	 

	   var causal_anulacion_id = $("#causal_anulacion_id").val();

	   var observaciones       = $("#observaciones").val();

	   

       if(ValidaRequeridos(formulario)){

	

	     var QueryString = "ACTIONCONTROLER=onclickCancellation&"+FormSerialize(formulario)+"&encabezado_registro_id="+$("#encabezado_registro_id").val();

		

	     $.ajax({

           url  : "MovimientosContablesClass.php",

	       data : QueryString,

	       beforeSend: function(){

			   showDivLoading();

	       },

	       success : function(response){

			              

		     if($.trim(response) == 'true'){

				 alertJquery('Movimiento Contable Anulado','Anulado Exitosamente');

				 setDataFormWithResponse();

			 }else{

				   alertJquery(response,'Inconsistencia Anulando');

			   }

			   

			 removeDivLoading();

             $("#divAnulacion").dialog('close');

			 

	       }

	   

	     });

	   

	   }

	

    }else{

		

	 var encabezado_registro_id = $("#encabezado_registro_id").val();

	 var estado                 = $("#estado").val();

	 

	 if(parseInt(encabezado_registro_id) > 0){		



	 var QueryString = "ACTIONCONTROLER=getEstadoEncabezadoRegistro&encabezado_registro_id="+encabezado_registro_id;

	 

	 $.ajax({

       url        : "MovimientosContablesClass.php",

	   data       : QueryString,

	   beforeSend : function(){

		 showDivLoading();

	   },

	   success : function(response){

		   	   

		   var estado = response;

		   

		   if($.trim(estado) == 'C'){

			   

		    $("#divAnulacion").dialog({

			  title: 'Anulacion Registro Contable',

			  width: 450,

			  height: 280,

			  closeOnEscape:true

             });

			

		   }else{

		      alertJquery('Solo se permite anular movimientos en estado : <b>CONTABILIZADO</b>','Anulacion');			   

			 }  

			 

	     removeDivLoading();			 

	     }

		 

	 });

	 

		

	 }else{

		alertJquery('Debe Seleccionar primero un movimiento contable','Anulacion');

	  }		

		

	}  

	  

	

}



function OnclickContabilizar(formulario){

	$("#estado").attr("disabled","false");

	$("#estado").val("C");	

	$("#estado").attr("disabled","true");	

	Send(formulario,'onclickUpdate',null,MovimientosContablesOnUpdate);

}



$(document).ready(function(){		

						   

  $("#empresa_id").trigger("change");						     

  						   

  $("#msj_anulado,#contabilizar").css("display","none");

						   

  $("#movimientosContables").attr("src","/rotterdan/framework/tpl/blank.html");	

  

  $("#saveImputacionesContables").click(function(){										

    window.frames[0].saveImputacionesContables();	

  });  

  

  $("#deleteImputacionesContables").click(function(){										

    window.frames[0].deleteImputacionesContables();

  });  

  

  $("#preView").click(function(){

     preView();					   

  });

  

  $("#tipo_documento_id").change(function(){

    setTitulosDocumento(this.value);

  });

  

  if(isNumber($("#encabezado_registro_id").val())){ 

    setDataFormWithResponse();

  }

  

  $("#tipo_documento_id").focus();

  

						   

});