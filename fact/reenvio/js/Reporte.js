var formSubmitted = false;	
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
	
						
						
	$("#generar_excel").click(function(){
	
	 var formulario = this.form;
	
	 if(ValidaRequeridos(formulario)){
	 
	   
	   var QueryString = "ReportesClass.php?ACTIONCONTROLER=generateFileexcel&"+FormSerialize(formulario)+"&rand="+Math.random();
						 
	   document.location.href = QueryString;						 
	
	 }								
	});	
						   
});

function ReportesOnReset(formulario){
	
		$("#frameReporte").attr("src","../../../framework/tpl/blank.html");	
	
}

function Cliente_si(){
	if($('#si_cliente').val()==1){
		
		  if($('#cliente'))    $('#cliente').attr("disabled","");
	
	}else if($('#si_cliente').val()=='ALL'){
		
		  if($('#cliente'))    $('#cliente').attr("disabled","true");
		  $('#cliente').val('');
		  $('#cliente_id').val('');
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

function OnclickGenerar(formulario){
	
	if(ValidaRequeridos(formulario)){
		 var QueryString = "DetallesClass.php?"+FormSerialize(formulario);
		 $("#frameReporte").attr("src",QueryString);
		 showDivLoading();	 	   
		 $("#frameReporte").load(function(response){removeDivLoading();});
		
	}
	
}

function sincroniza_estado(factura_id){



	if(parseInt(factura_id)>0){
		$('#reportar').attr("disabled","true");
		if(!formSubmitted){	
			formSubmitted = true;			
					 
			var QueryString = "ACTIONCONTROLER=OnclickReportar&factura_id="+factura_id;	

			$.ajax({
				url     : "DetallesClass.php",
				data    : QueryString,
				beforeSend : function(){
				  showDivLoading();
				},
				
				success : function(response){
					try{
					   alertJquery(response,'Consulta Estado Factura');
					   $('#reportar').attr("disabled","");
						 formSubmitted = false;	
						 OnclickGenerar(document.getElementById('ReportesForm'));
						 
					}catch(e){
						alertJquery(e,'Consulta Estado Factura');
					  formSubmitted = false;	
					}
					removeDivLoading();
				}
			});
	  }
			
	}else{
		alertJquery('Debe Seleccionar primero una Factura','Reporte Factura Electronica'); 
	}

}

function sincroniza_reenvio(factura_id){



	if(parseInt(factura_id)>0){
		if(!formSubmitted){	
			formSubmitted = true;			
					 
			var QueryString = "ACTIONCONTROLER=OnclickReenviar&factura_id="+factura_id;	

			$.ajax({
				url     : "DetallesClass.php",
				data    : QueryString,
				beforeSend : function(){
				  showDivLoading();
				},
				
				success : function(response){
					try{
					   alertJquery(response,'Consulta Estado Factura');
					   $('#reportar').attr("disabled","");
						 formSubmitted = false;	
						 OnclickGenerar(document.getElementById('ReportesForm'));
						 
					}catch(e){
						alertJquery(e,'Consulta Estado Factura');
					  formSubmitted = false;	
					}
					removeDivLoading();
				}
			});
	  }
			
	}else{
		alertJquery('Debe Seleccionar primero una Factura','Reporte Factura Electronica'); 
	}

}

function descargarexcel(formulario){
	
	if(ValidaRequeridos(formulario)){
		 var QueryString = "DetallesClass.php?download=true&"+FormSerialize(formulario);
		 $("#frameReporte").attr("src",QueryString);
		
	}
}

function beforePrint(formulario){
 
   if(ValidaRequeridos(formulario)){
     var QueryString = "DetallesClass.php?"+FormSerialize(formulario);
  popPup(QueryString,'Impresion Reporte',800,600);
    
   }
}
