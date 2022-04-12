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

});

function Vehiculo_si(){
	if($('#si_vehiculo').val()==1){
		
		  if($('#vehiculo'))    $('#vehiculo').attr("disabled","");
	
	}else if($('#si_vehiculo').val()=='ALL'){
		
		  if($('#vehiculo'))    $('#vehiculo').attr("disabled","true");
		  $('#vehiculo').val('');
		  $('#vehiculo_id').val('');
	}
}

function Tenedor_si(){
	if($('#si_tenedor').val()==1){
		
		  if($('#tenedor'))    $('#tenedor').attr("disabled","");
	
	}else if($('#si_tenedor').val()=='ALL'){
		
		  if($('#tenedor'))    $('#tenedor').attr("disabled","true");
		  $('#tenedor').val('');
		  $('#tenedor_id').val('');
	}
}



function all_oficce(){
	if(document.getElementById('all_oficina').checked==true){
		$('#all_oficina').val('SI');

		var objSelect = document.getElementById('oficina_id'); 
		var numOp     = objSelect.options.length -1;
	   
	   
	   for(var i = numOp; i > 0; i-- ){
		   
		  if(objSelect.options[i].value != 'NULL'){
			 objSelect.options[i].selected = true;
		  }else{
			   objSelect.options[i].selected = false;
			} 		   
	   }

	}else{
		$('#all_oficina').val('NO');
		var objSelect = document.getElementById('oficina_id'); 
		var numOp     = objSelect.options.length -1;

		 
	     for(var i = numOp; i > 0; i-- ){
		   
		   if(objSelect.options[i].value != 'NULL'){
			 objSelect.options[i].selected = false;
		   }else{
			   objSelect.options[i].selected = true;
			 } 		   
	     } 		
	}	
}

function all_documentos(){
	if(document.getElementById('all_documento').checked==true){
		$('#all_documento').val('SI');

		var objSelect = document.getElementById('tipo'); 
		var numOp     = objSelect.options.length -1;
	   
	   
	   for(var i = numOp; i > 0; i-- ){
		   
		  if(objSelect.options[i].value != 'NULL'){
			 objSelect.options[i].selected = true;
		  }else{
			   objSelect.options[i].selected = false;
			} 		   
	   }

	}else{
		$('#all_documento').val('NO');
		var objSelect = document.getElementById('tipo'); 
		var numOp     = objSelect.options.length -1;

		 
	     for(var i = numOp; i > 0; i-- ){
		   
		   if(objSelect.options[i].value != 'NULL'){
			 objSelect.options[i].selected = false;
		   }else{
			   objSelect.options[i].selected = true;
			 } 		   
	     } 		
	}	
}

function OnclickGenerar(formulario){
	
	if(ValidaRequeridos(formulario)){
		 var QueryString = "DetallesProveedoresClass.php?"+FormSerialize(formulario);
		 $("#frameReporte").attr("src",QueryString);
		 showDivLoading();	 	   
		 $("#frameReporte").load(function(response){removeDivLoading();});		
	}
	
}

function beforePrint(formulario){
	
   if(ValidaRequeridos(formulario)){
	 var QueryString = "DetallesProveedoresClass.php?"+FormSerialize(formulario);
	 popPup(QueryString,'Impresion Reporte',800,600);
	   
   }
}

function descargarexcel(formulario){
	
	if(ValidaRequeridos(formulario)){
		 var QueryString = "DetallesProveedoresClass.php?download=true&"+FormSerialize(formulario);
		 $("#frameReporte").attr("src",QueryString);
		
	}
}

$(document).ready(function(){

 $("#generar_excel").click(function(){

     var formulario = this.form;

     if(ValidaRequeridos(formulario)){
		 
	 
       var desde		 = $("#desde").val();
	   var hasta		 = $("#hasta").val();
	   var all_oficina	 = $("#all_oficina").val();
       var oficina_id	 = $("#oficina_id").val();
	   var si_tenedor 	 = $("#si_tenedor").val();	 
	   var tenedor_id 	 = $("#tenedor_id").val();
	   var tipo 		 = $("#tipo").val();	
	   var si_vehiculo   = $("#si_vehiculo").val();	 
	   var vehiculo_id   = $("#vehiculo_id").val();	
		 var estado   = $("#estado").val();	
	   
       var QueryString = "reporteProveedoresClass.php?ACTIONCONTROLER=generateFileexcel&desde="+desde+"&hasta="+hasta+"&oficina_id="+oficina_id+
	                     "&si_tenedor="+si_tenedor+"&all_oficina="+all_oficina+"&tenedor_id="+tenedor_id+"&tipo="+tipo+"&estado="+estado+
						 "&si_vehiculo="+si_vehiculo+"&vehiculo_id="+vehiculo_id+"&rand="+Math.random();
						 
	   document.location.href = QueryString;	
	 }
   });	
});