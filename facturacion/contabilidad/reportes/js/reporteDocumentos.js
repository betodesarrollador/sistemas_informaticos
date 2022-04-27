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
function all_traza(){
	if(document.getElementById('all_trazabilidad').checked==true){
		$('#all_trazabilidad').val('SI');
		var objSelect = document.getElementById('trazabilidad_id'); 
		var numOp     = objSelect.options.length -1;	   
	   
	   for(var i = numOp; i > 0; i-- ){
		   
		  if(objSelect.options[i].value != 'NULL'){
			 objSelect.options[i].selected = true;
		  }else{
			   objSelect.options[i].selected = false;
			} 		   
	   }
	}else{
		$('#all_trazabilidad').val('NO');
		var objSelect = document.getElementById('trazabilidad_id'); 
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
			var QueryString = "reporteDocumentosClass.php?ACTIONCONTROLER=OnclickGenerar&"+FormSerialize(formulario);
			$("#frameReporte").attr("src",QueryString);
			showDivLoading();	 	   
			$("#frameReporte").load(function(response){removeDivLoading();});		
		}
	}	
	
	function descargarexcel(formulario){
		if(ValidaRequeridos(formulario)){
			var QueryString = "reporteDocumentosClass.php?ACTIONCONTROLER=onclickGenerar&download=true&"+FormSerialize(formulario);
			$("#frameReporte").attr("src",QueryString);
		}
	}
	function beforePrint(formulario){
		if(ValidaRequeridos(formulario)){
			var QueryString = "reporteDocumentosClass.php?ACTIONCONTROLER=onclickGenerar&"+FormSerialize(formulario);
			popPup(QueryString,'Impresion Reporte',800,600);
		}
	}
	function viewDocument(encabezado_registro_id){
		var QueryString = "../../../contabilidad/reportes/clases/LibrosAuxiliaresClass.php?ACTIONCONTROLER=viewDocument&encabezado_registro_id="+encabezado_registro_id;
		var title       = "Visualizacion Documento Contable";
		var width       = 900;
		var height      = 600;
		popPup(QueryString,title,width,height);  
	}