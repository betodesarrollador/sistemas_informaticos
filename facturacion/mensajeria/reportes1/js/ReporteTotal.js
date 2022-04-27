$(document).ready(function(){
    var cliente_id=$("#cliente_id").val();
	if(parseInt(cliente_id)>0){
		$('#si_cliente').attr("disabled","true");
		$('#si_cliente').val('1');
	}
  	$("#desde").change(function(){

	  	var fechah = $("#hasta").val();
	  	var fechad = $("#desde").val();
	  	var today = new Date();

	  	if ((Date.parse(fechah) < Date.parse(fechad)) || (Date.parse(fechad)>today)) {
	  		alertJquery('Esta fecha no puede ser mayor a la fecha final o mayor a hoy');
	  		return this.value = $("#hasta").val();
	  	};

	});

	$("#hasta").change(function(){

	  	var fechah = $("#hasta").val();
	  	var fechad = $("#desde").val();
	  	var today = new Date();

	  	if ((Date.parse(fechah) < Date.parse(fechad)) || (Date.parse(fechah)>today)) {
	  		alertJquery('Esta fecha no puede ser menor a la fecha de inicio o mayor a hoy');
	  		return this.value = $("#desde").val();
	  	};
	});

});

$(document).keypress(function(e){
	if(e.which == 13){
		var form = document.forms[0];
		OnclickGenerar(form);
	}
});



function Cliente_si(){
	if($('#si_cliente').val()==1){
		
		  if($('#cliente'))    $('#cliente').attr("disabled","");
	
	}else if($('#si_cliente').val()=='ALL'){
		
		  if($('#cliente'))    $('#cliente').attr("disabled","true");
		  $('#cliente').val('');
		  $('#cliente_id').val('');
	}

}

function OnclickGenerar(formulario){
	
	if(ValidaRequeridos(formulario)){
		 var QueryString = "DetallesReporteTotalClass.php?"+FormSerialize(formulario);
		 $("#frameReporte").attr("src",QueryString);
		 showDivLoading();
		 $("#frameReporte").load(function(response){removeDivLoading();});
	}
	
}

function OnclickGenerarExcel(formulario){
     if(ValidaRequeridos(formulario)){
	 
		
       var QueryString = "DetallesReporteTotalClass.php?ACTIONCONTROLER=generateFile&"+FormSerialize(formulario)+"&download=SI&rand="+Math.random();
			 
	   document.location.href = QueryString;

	 }
}

function OnclickGenerarExcelFormato(formulario){
     if(ValidaRequeridos(formulario)){
	 
		
       var QueryString = "DetallesReporteTotalClass.php?ACTIONCONTROLER=generateFileFormato&"+FormSerialize(formulario)+"&download=SI&rand="+Math.random();
			 
	   document.location.href = QueryString;

	 }
}

function OnclickGenerarFotos(formulario){
     if(ValidaRequeridos(formulario)){
	   if($('#si_cliente').val()=='1'){
			
		   var QueryString = "DetallesReporteTotalClass.php?ACTIONCONTROLER=generateFotos&"+FormSerialize(formulario)+"&download=SI&rand="+Math.random();
				 
		   document.location.href = QueryString;
	   }else{
			alertJquery("Solo se puede Generar un archivo Zip para un solo cliente","Validacion");   
	   }
	 }
}
function beforePrint(formulario){
	
   if(ValidaRequeridos(formulario)){
	 var QueryString = "DetallesReporteTotalClass.php?"+FormSerialize(formulario);
	 popPup(QueryString,'Impresion Reporte',800,600);
	   
   }
}