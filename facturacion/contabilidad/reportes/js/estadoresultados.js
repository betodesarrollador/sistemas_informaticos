// JavaScript Document
$(document).ready(function(){
	///INICIO VALIDACION FECHAS DE REPORTE
	
  	$('#desde').change(function(){

	  	var fechah = $('#hasta').val();
	  	var fechad = $('#desde').val();
	  	var today = new Date();

	 	if ((Date.parse(fechah) < Date.parse(fechad)) || (Date.parse(fechad)>today)) {
	  		alertJquery('Esta fecha no puede ser mayor a la fecha final o mayor a hoy.');
	  		return this.value = $('#hasta').val();
	  	};
	});

	$('#hasta').change(function(){

	  	var fechah = $('#hasta').val();
	  	var fechad = $('#desde').val();
	  	var today = new Date();

	  	if ((Date.parse(fechah) < Date.parse(fechad)) || (Date.parse(fechah)>today)) {
	  		alertJquery('Esta fecha no puede ser menor a la fecha de inicio o mayor a hoy.');
	  		return this.value = $('#desde').val();
	  	};
	});
	
	///FIN VALIDACION FECHAS DE REPORTE		
	$("#nivel").change(function(){
		var nivel = $("#nivel").val();					
		 var QueryString = "ACTIONCONTROLER=cambiarCuentas&nivel="+nivel;
  
		  $.ajax({
			url        : "EstadoResultadosClass.php",
			data       : QueryString,
			beforeSend : function(){
			},
			success    : function(response){/*
				var data	= $.parseJSON(response);
				 var selectcuentas = document.getElementById('cuentas'); 
				
				for(var i=0; i<data.length;i++ ){
					 selectcuentas.options[i].value =data[i]['value'];
				}
				*/
				$("#cuentas").parent().html(response);
				}
		 
		  });
		
	});


  setWidthFrameReporte();
  getReportParams();  
  
  $("#oficina_id").css("display","none");
    
  $("#opciones_tercero").change(function(){
    if(this.value == 'T'){
	 $("#tercero_hidden").removeClass("obligatorio");
	 $("#tercero").removeClass("requerido");	 	 
	 $("#tercero").attr("disabled","true");	 	 	 
	 $("#tercero,#tercero_hidden").val("");	 	 	 	 
    }else if(this.value == 'U'){
		 $("#tercero_hidden").addClass("obligatorio");
	     $("#tercero").attr("disabled","");	 	 	 		 
      }						
  });  
      
  $("#opciones_centros").click(function(){

     if(this.checked){
	   this.value = 'T';	 
	 }else{
		  this.value = 'U';
	   }
	   
     var objSelect = document.getElementById('centro_de_costo_id'); 
	 var numOp     = objSelect.options.length -1;
	   
     if(this.value == 'T'){
	   
	   for(var i = numOp; i > 0; i-- ){
		   
		  if(objSelect.options[i].value != 'NULL'){
			 objSelect.options[i].selected = true;
		  }else{
			   objSelect.options[i].selected = false;
			} 
		   
	   }
		 		 
	 }else{
		 
	     for(var i = numOp; i > 0; i-- ){
		   
		   if(objSelect.options[i].value != 'NULL'){
			 objSelect.options[i].selected = false;
		   }else{
			   objSelect.options[i].selected = true;
			 } 
		   
	     } 		 
		 
	  }

  });
  
  $("#opciones_cuentas").click(function(){

     if(this.checked){
	   this.value = 'T';	 
	 }else{
		  this.value = 'U';
	   }
	   
     var objSelect = document.getElementById('cuentas'); 
	 var numOp     = objSelect.options.length -1;
	   
     if(this.value == 'T'){
	   
	   for(var i = numOp; i > 0; i-- ){
		   
		  if(objSelect.options[i].value != 'NULL'){
			  objSelect.options[i].selected = true;
		  }else{
			    objSelect.options[i].selected = false;			  
			 } 
		   
	   }
		 		 
	 }else{
		 
	     for(var i = numOp; i > 0; i-- ){
		   
		   if(objSelect.options[i].value != 'NULL'){
			  objSelect.options[i].selected = false;
		   }else{
			    objSelect.options[i].selected = true;			  			   
			 } 
		   
	     } 		 
		 
	  }

  });
  
  
  $("#centro_de_costo_id").change(function(){
     $("#opciones_centros").attr("checked","");								
     $("#opciones_centros").val("U");									 
  });  
  
						   
});

function setWidthFrameReporte(){
  $("#frameReporte").css("height",($(parent.document.body).height() - 110));
}

function getReportParams(){
	
  $("#reporte").change(function(){

    if($.trim(this.value) != 'NULL'){
        getEmpresas(this.value);
    }

  });
  
}

function getEmpresas(reporte){
	
  var QueryString = "ACTIONCONTROLER=getEmpresas&reporte="+reporte;
  
  $.ajax({
    url        : "EstadoResultadosClass.php",
	data       : QueryString,
	beforeSend : function(){
	},
	success    : function(response){
		
		if(reporte == 'E'){
		  $("#empresaReporte").html(response);
		  $("#oficinaReporte").html("");
		  $("#centroCostoReporte").html("");			
		}else if(reporte == 'O'){
		    $("#empresaReporte").html(response);
		    $("#oficinaReporte").html("<select name='oficina_id' id='oficina_id' disabled><option value='NULL'>( Seleccione )</option></select>");
		    $("#centroCostoReporte").html("");	
		  }else if(reporte == 'C'){
		     $("#empresaReporte").html(response);
		     $("#oficinaReporte").html("");
		     $("#centroCostoReporte").html("<select name='centro_de_costo' id='centro_de_costo' disabled><option value='NULL'>( Seleccione )</option></select>");	
		    }
			 
	  }
		 
  });
	
}

function onclickGenerarBalance(formulario){

   if(ValidaRequeridos(formulario)){
	 
	 var desde = $("#desde").val();
	 var hasta = $("#hasta").val();
	 
	 var opciones_tercero = $("#opciones_tercero").val();
	 
	 var centro_de_costo_id = $("#centro_de_costo_id").val();
	 
	 var nivel =  $("#nivel").val();
	 
	 var opciones_cierre = $("#opciones_cierre").val();
	 
	 var agrupar_por = $("#agrupar_por").val();
	 	 
	 var opciones_cuentas = $("#opciones_cuentas").val();
	 
	 var cuentas = $("#cuentas").val();
	 
	 
	 if(agrupar_por=='C'){
		 
		 var QueryString = "EstadoResultadosClass.php?ACTIONCONTROLER=onclickGenerarBalance&desde="+desde+"&hasta="+hasta+"&opciones_tercero="+opciones_tercero+"&centro_de_costo_id="+centro_de_costo_id+"&nivel="+nivel+"&opciones_cuentas="+opciones_cuentas+"&agrupar_por="+agrupar_por+"&opciones_cierre="+opciones_cierre;
		 
	 }else if(agrupar_por=='F'){
		 
		 if(opciones_cuentas=='T')
		 {
			 
		 	var QueryString = "EstadoResultadosClass.php?ACTIONCONTROLER=onclickGenerarBalance&desde="+desde+"&hasta="+hasta+"&opciones_tercero="+opciones_tercero+"&centro_de_costo_id="+centro_de_costo_id+"&nivel="+nivel+"&opciones_cuentas="+opciones_cuentas+"&agrupar_por="+agrupar_por+"&opciones_cierre="+opciones_cierre;
			
		 }else if(opciones_cuentas=='U'){
			 
			 var QueryString = "EstadoResultadosClass.php?ACTIONCONTROLER=onclickGenerarBalance&desde="+desde+"&hasta="+hasta+"&opciones_tercero="+opciones_tercero+"&centro_de_costo_id="+centro_de_costo_id+"&nivel="+nivel+"&cuentas="+cuentas+"&opciones_cuentas="+opciones_cuentas+"&agrupar_por="+agrupar_por+"&opciones_cierre="+opciones_cierre;
			 
		 }
	 }
	 
     //var QueryString = "EstadoResultadosClass.php?ACTIONCONTROLER=onclickGenerarBalance&"+FormSerialize(formulario);
	 //alert(QueryString);
     $("#frameReporte").attr("src",QueryString);
     showDivLoading();	 	   
     $("#frameReporte").load(function(response){removeDivLoading();});
	   
   }

}

function descargarexcel(formulario){

	if(ValidaRequeridos(formulario)){
		
	 var desde = $("#desde").val();
		
	 var hasta = $("#hasta").val();
	 
	 var opciones_tercero = $("#opciones_tercero").val();
	 
	 var centro_de_costo_id = $("#centro_de_costo_id").val();
	 
	 var nivel =  $("#nivel").val();
	 
	 var opciones_cierre = $("#opciones_cierre").val();
	 
	 var agrupar_por = $("#agrupar_por").val();
	 	 
	 var opciones_cuentas = $("#opciones_cuentas").val();
	 
	 var cuentas = $("#cuentas").val();
	 
	 
	 if(agrupar_por=='C'){
		 
		 var QueryString = "EstadoResultadosClass.php?ACTIONCONTROLER=onclickGenerarBalance&download=true&desde="+desde+"&hasta="+hasta+"&opciones_tercero="+opciones_tercero+"&centro_de_costo_id="+centro_de_costo_id+"&nivel="+nivel+"&opciones_cuentas="+opciones_cuentas+"&agrupar_por="+agrupar_por+"&opciones_cierre="+opciones_cierre;
		 
	 }else if(agrupar_por=='F'){
		 
		 if(opciones_cuentas=='T')
		 {
			 
		 	var QueryString = "EstadoResultadosClass.php?ACTIONCONTROLER=onclickGenerarBalance&download=true&desde="+desde+"&hasta="+hasta+"&opciones_tercero="+opciones_tercero+"&centro_de_costo_id="+centro_de_costo_id+"&nivel="+nivel+"&opciones_cuentas="+opciones_cuentas+"&agrupar_por="+agrupar_por+"&opciones_cierre="+opciones_cierre;
			
		 }else if(opciones_cuentas=='U'){
			 
			 var QueryString = "EstadoResultadosClass.php?ACTIONCONTROLER=onclickGenerarBalance&download=true&desde="+desde+"&hasta="+hasta+"&opciones_tercero="+opciones_tercero+"&centro_de_costo_id="+centro_de_costo_id+"&nivel="+nivel+"&cuentas="+cuentas+"&opciones_cuentas="+opciones_cuentas+"&agrupar_por="+agrupar_por+"&opciones_cierre="+opciones_cierre;
			 
		 }
	 }
	
	}else{
		alertJquery("Faltan campos obligatorios!");
	}
	
	$("#frameReporte").attr("src",QueryString);
}

function descargar_file(url){
	window.open(url,'','toolbar=no,directories=no,menub ar=no,status=no,resizable=yes,scrollbars=yes,width=50,height=50,top=15,left=15');	
}

function beforePrint(formulario){

		if ($('#opciones_cuentas').is(':checked')) {

			var desde = $("#desde").val();
		
			var hasta = $("#hasta").val();
			
			var opciones_tercero = $("#opciones_tercero").val();
			
			var centro_de_costo_id = $("#centro_de_costo_id").val();
			
			var nivel =  $("#nivel").val();
			
			var opciones_cierre = $("#opciones_cierre").val();
			
			var agrupar_por = $("#agrupar_por").val();
				 
			var opciones_cuentas = $("#opciones_cuentas").val();
			
			// var cuentas = $("#cuentas").val();

		  if(ValidaRequeridos(formulario)){
			var QueryString = "EstadoResultadosClass.php?ACTIONCONTROLER=onclickGenerarBalance&desde="+desde+"&hasta="+hasta+"&opciones_tercero="+opciones_tercero+"&centro_de_costo_id="+centro_de_costo_id+"&nivel="+nivel+"&opciones_cuentas="+opciones_cuentas+"&agrupar_por="+agrupar_por+"&opciones_cierre="+opciones_cierre;
			 popPup(QueryString,'Impresion Reporte',800,600);
		    
		  }
		}else{
			 if(ValidaRequeridos(formulario)){
				var QueryString = "EstadoResultadosClass.php?ACTIONCONTROLER=onclickGenerarBalance&"+FormSerialize(formulario);
				 popPup(QueryString,'Impresion Reporte',800,600);
			   
			  }
		}

}
