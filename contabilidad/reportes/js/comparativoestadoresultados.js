// JavaScript Document
$(document).ready(function(){
						   
   	///INICIO VALIDACION FECHAS DE REPORTE
	
  	$('#desde1').change(function(){
	  	var fechah = $('#hasta1').val();
	  	var fechad = $('#desde1').val();
	  	var today = new Date();
	 	if ((Date.parse(fechah) < Date.parse(fechad)) || (Date.parse(fechad)>today)) {
	  		alertJquery('Esta fecha no puede ser mayor a la fecha final o mayor a hoy.');
	  		return this.value = $('#hasta1').val();
	  	};
	});
	
  	$('#desde2').change(function(){
	  	var fechah = $('#hasta2').val();
	  	var fechad = $('#desde2').val();
	  	var today = new Date();
	 	if ((Date.parse(fechah) < Date.parse(fechad)) || (Date.parse(fechad)>today)) {
	  		alertJquery('Esta fecha no puede ser mayor a la fecha final o mayor a hoy.');
	  		return this.value = $('#hasta2').val();
	  	};
	});

	$('#hasta1').change(function(){
	  	var fechah = $('#hasta1').val();
	  	var fechad = $('#desde1').val();
	  	var today = new Date();
	  	if ((Date.parse(fechah) < Date.parse(fechad)) || (Date.parse(fechah)>today)) {
	  		alertJquery('Esta fecha no puede ser menor a la fecha de inicio o mayor a hoy.');
	  		return this.value = $('#desde1').val();
	  	};
	});
	
	$('#hasta2').change(function(){
	  	var fechah = $('#hasta2').val();
	  	var fechad = $('#desde2').val();
	  	var today = new Date();
	  	if ((Date.parse(fechah) < Date.parse(fechad)) || (Date.parse(fechah)>today)) {
	  		alertJquery('Esta fecha no puede ser menor a la fecha de inicio o mayor a hoy.');
	  		return this.value = $('#desde2').val();
	  	};
	});	
	
	///FIN VALIDACION FECHAS DE REPORTE						   						   
						   
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
  $("#hasta2").change(function(){
  	var fechah = $("#hasta2").val();
  	var fechad = $("#desde2").val();
  	var today = new Date();
  	if ((Date.parse(fechah) < Date.parse(fechad)) || (Date.parse(fechah)>today)) {
  		alertJquery('Esta fecha no puede ser menor a la fecha de inicio o mayor a hoy');
  		return this.value = $("#desde2").val();
  	};
  });
  $("#desde2").change(function(){
  	var fechah = $("#hasta2").val();
  	var fechad = $("#desde2").val();
  	var today = new Date();
  	if ((Date.parse(fechah) < Date.parse(fechad)) || (Date.parse(fechad)>today)) {
  		alertJquery('Esta fecha no puede ser mayor a la fecha final o mayor a hoy');
  		return this.value = $("#hasta2").val();
  	};
  });
  $("#hasta1").change(function(){
  	var fechah = $("#hasta1").val();
  	var fechad = $("#desde1").val();
  	var today = new Date();
  	if ((Date.parse(fechah) < Date.parse(fechad)) || (Date.parse(fechah)>today)) {
  		alertJquery('Esta fecha no puede ser menor a la fecha de inicio o mayor a hoy');
  		return this.value = $("#desde1").val();
  	};
  });
  $("#desde1").change(function(){
  	var fechah = $("#hasta1").val();
  	var fechad = $("#desde1").val();
  	var today = new Date();
  	if ((Date.parse(fechah) < Date.parse(fechad)) || (Date.parse(fechad)>today)) {
  		alertJquery('Esta fecha no puede ser mayor a la fecha final o mayor a hoy');
  		return this.value = $("#hasta1").val();
  	};
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
     var QueryString = "ComparativoEstadoResultadosClass.php?ACTIONCONTROLER=onclickGenerarBalance&"+FormSerialize(formulario);
     $("#frameReporte").attr("src",QueryString);
     showDivLoading();	 	   
     $("#frameReporte").load(function(response){removeDivLoading();});
	   
   }
}
function descargarexcel(formulario){
 if(ValidaRequeridos(formulario)){
   var QueryString = "ComparativoEstadoResultadosClass.php?ACTIONCONTROLER=onclickGenerarBalance&download=true&"+FormSerialize(formulario);
   $("#frameReporte").attr("src",QueryString);
 }
}
function beforePrint(formulario){
 
   if(ValidaRequeridos(formulario)){
     var QueryString = "ComparativoEstadoResultadosClass.php?ACTIONCONTROLER=onclickGenerarBalance&"+FormSerialize(formulario);
  popPup(QueryString,'Impresion Reporte',800,600);
    
   }
}