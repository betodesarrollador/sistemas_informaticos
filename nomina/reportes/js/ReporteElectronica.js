$(document).ready(function(){   
						   
	$("#si_empleado").change(function(){

      if(this.value == 1){
		
		$("#empleado").addClass("obligatorio");	
		$("#empleado").addClass("requerido");	
	  }else{
          $("#empleado").removeClass("obligatorio");
          $("#empleado").removeClass("requerido");		 		 
		 
      }
    });
	
	$("#si_cargo").change(function(){

      if(this.value == 1){
		
		$("#cargo").addClass("obligatorio");	
		$("#cargo").addClass("requerido");	
		
	  }else{		  
	   				  
		 
 		 $("#cargo").removeClass("obligatorio");		 
 		 $("#cargo").removeClass("requerido");		 		 
		 
	    }
});
	
	 $("#generar_excel").click(function(){

     var formulario = this.form;

     if(ValidaRequeridos(formulario)){
	 
       var desde		 = $("#desde").val();
	   var hasta		 = $("#hasta").val();
	   var si_empleado   = $("#si_empleado").val();	 
	   var empleado_id   = $("#empleado_id").val();		   
	   
       var QueryString = "ReporteElectronicaClass.php?ACTIONCONTROLER=generateView&download=true&desde="+desde+"&hasta="+hasta+"&si_empleado="+si_empleado+"&empleado_id="+empleado_id+"&rand="+Math.random();
						 
	   document.location.href = QueryString;	
	 }								
   });	


///INICIO VALIDACION FECHAS DE REPORTE
 
   $('#desde').change(function(){

    var fechah = $('#hasta').val();
    var fechad = $('#desde').val();
    var today = new Date();

    if ((Date.parse(fechah) < Date.parse(fechad)) || (Date.parse(fechad)>today)) {
     alertJquery('Esta fecha no puede ser mayor a la fecha final o mayor a hoy.');
     return this.value = $('#hasta').val();
    };

	$('#enviar_reporte').attr('disabled',true);

 });

 	$('#hasta').change(function(){

		var fechah = $('#hasta').val();
		var fechad = $('#desde').val();
		var today = new Date();

		if ((Date.parse(fechah) < Date.parse(fechad)) || (Date.parse(fechah)>today)) {
			alertJquery('Esta fecha no puede ser menor a la fecha de inicio o mayor a hoy.');
			return this.value = $('#desde').val();
		};

		$('#enviar_reporte').attr('disabled',true);

 	});
 
 ///FIN VALIDACION FECHAS DE REPORTE

 //enviar reporte apirest


	$('#enviar_reporte').click(function(){

		var formulario = this.form;

		var fechaDesde = $('#desde').attr('value');
		var fechahasta = $('#hasta').attr('value');

		var validaFecha = validaFechas(fechaDesde,fechahasta);

		if(ExisteSeleccionados()){

			let arraydentificacion=[];  

			$('#frameReporte').contents().find("tr").each(function(){

			 	if ($(this).find('input[name=check]').attr('checked') == true) {
					arraydentificacion.push($(this).find('#identificacion').html());
				}	
					
			});
			
			//console.log(arraydentificacion);

			var QueryString = "ACTIONCONTROLER=enviarReporte&arrayIdentificacion="+arraydentificacion+"&"+FormSerialize(formulario)+"&validaFecha="+validaFecha;

			$.ajax({
				url: "ReporteElectronicaClass.php?rand="+Math.random(),
				data: QueryString,
				beforeSend : function(){
				showDivLoading();	
				},
				success: function (response) {
					try{
	
						alertJquery(response);
						OnclickGenerar(formulario);
					
					}catch(e){
						  alertJquery(e);
					}
					removeDivLoading();
				}
			});

		}else{
			alertJquery("Debe seleccionar al menos un registro");
		}

	});
});


function validaFechas(fechad,fechah){

	//validacion para activar boton de reporte

	var result = false;

	var fechaHastaFormat = new Date(fechah + ' 00:00:00');
	var fechaDesdeFormat = new Date(fechad + ' 00:00:00');

	if (fechaDesdeFormat.getMonth() != fechaHastaFormat.getMonth()) {
		alertJquery('Las fechas seleccionadas deben ser del mismo mes');
		$('#enviar_reporte').attr('disabled',true);
		result = false;

	}else{
		
		var fechaInicial = new Date(fechad + ' 00:00:00');
		var mes = fechaInicial.getMonth();

		var primerDia = new Date(fechaInicial.getFullYear(), mes, 1);
		var ultimoDia = new Date(fechaInicial.getFullYear(), mes + 1, 0);

		if (fechaDesdeFormat.getTime() == primerDia.getTime() && fechaHastaFormat.getTime() == ultimoDia.getTime()) {
			
			$('#enviar_reporte').attr('disabled',false);

			result = true;

		}else{

			alertJquery('Las fechas seleccionadas deben ser del inicio y fin de mes');
			$('#enviar_reporte').attr('disabled',true);

			result = false;

		}

	}

	return result;

}

function ExisteSeleccionados() {
	
	var seleccionados=0;
	var resultado = false;

	$('#frameReporte').contents().find("input[name=check]:checked").each(function(){
	
		seleccionados=seleccionados+1;
			
	});
	

	if (seleccionados > 0) {
		resultado = true;
	} else {
		resultado = false;
	}

	return resultado;
}

function empleado_si(){
	if($('#si_empleado').val()==1){
		
		  if($('#empleado'))    $('#empleado').attr("disabled","");
	
	}else if($('#si_empleado').val()=='ALL'){
		
		  if($('#empleado'))    $('#empleado').attr("disabled","true");
		  $('#empleado').val('');
		  $('#empleado_id').val('');
	}
}

function cargo_si(){
	if($('#si_cargo').val()==1){
		
		  if($('#cargo'))    $('#cargo').attr("disabled","");
	
	}else if($('#si_cargo').val()=='ALL'){
		
		  if($('#cargo'))    $('#cargo').attr("disabled","true");
		  $('#cargo').val('');
		  $('#cargo_id').val('');
	}
}



function OnclickGenerar(formulario){
	
	if(ValidaRequeridos(formulario)){

		var QueryString = "ReporteElectronicaClass.php?ACTIONCONTROLER=generateView&"+FormSerialize(formulario);
		$("#frameReporte").attr("src",QueryString);
		showDivLoading();	 	   
		 
		$("#frameReporte").load(function(){
			removeDivLoading();
		});

		$('#frameReporte').bind("load",function(){

			var frame = $('#frameReporte').contents().find("#id_table_nomina").html();

			let filas = $(frame).find('tr').length -2; //se quitan las dos columna del encabezado
			
			if (filas > 0) {
				
				$('#enviar_reporte').removeAttr('disabled');
				console.log("habilitar boton");
			} else {
				$('#enviar_reporte').attr('disabled','true');
				console.log("desabilitar boton");
			}


		});

	}

}

function ContratoOnReset(formulario){
	$("#frameReporte").attr("src","../../../framework/tpl/blank.html");	
	Reset(formulario);
    clearFind();  
	$("#estado").val('A');
	$('#contrato_id').attr("disabled","");
	$('#contratos').attr("disabled","");
	if($('#guardar'))    $('#guardar').attr("disabled","");
	if($('#actualizar')) $('#actualizar').attr("disabled","true");
	if($('#borrar'))     $('#borrar').attr("disabled","true");
	if($('#limpiar'))    $('#limpiar').attr("disabled","");
}

function beforePrint(formulario){
	
   if(ValidaRequeridos(formulario)){
	 var QueryString = "DetallesHorasExtrasClass.php?"+FormSerialize(formulario);
	 popPup(QueryString,'Impresion Reporte',800,600);
	   
   }
}

//grid

function checkAll(obj) {

    $("input[name='check']").each(function() {

        var Fila = this;

		if ($(obj).is(':checked')) {

			$(Fila).attr("checked", "true");

		}else{

			$(Fila).removeAttr("checked");

		}

    });

}

function UrlExists(url)
{
    var http = new XMLHttpRequest();
    http.open('HEAD', url, false);
    http.send();
    return http.status==200;
	
}

function viewDoc(consecutivo){

	var url = "../../../archivos/nomina/nominaE/"+consecutivo+".pdf";

	if (UrlExists(url)) {
		window.open(url,"_blank");
	}else{
		console.log("El archivo solicitado no fue encontrado");
	}

	

}

function showTable(){
  
	var frame_grid =  document.getElementById('frame_grid');
	
	  //Se valida que el iFrame no exista
	  if(frame_grid == null ){
  
	  var QueryString   = 'ACTIONCONTROLER=showGrid';
  
	  $.ajax({
		url        : "ReporteElectronicaClass.php?rand="+Math.random(),
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