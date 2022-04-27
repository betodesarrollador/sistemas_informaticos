function setDataFormWithResponse(tabla_impuestos_id){
		
	var parametros  = new Array({campos:"tabla_impuestos_id",valores:""+tabla_impuestos_id+""});
	var forma       = document.forms[0];
	var controlador = 'TablaImpuestosClass.php';
	
	FindRow(parametros,forma,controlador,null,function(resp){

		try {

			var data = $.parseJSON(resp);
			var tabla_impuestos_id = data[0]['tabla_impuestos_id'];
			var empresa_id = data[0]['empresa_id'];

			var QueryString = "ACTIONCONTROLER=onchangeSetOptionList&empresa_id=" + empresa_id;

			$.ajax({
				url: "TablaImpuestosClass.php?rand=" + Math.random(),
				data: QueryString,
				beforeSend: function () {
					showDivLoading();
				},
				success: function (resp) {

					$("#oficina_id").replaceWith(resp);
					removeDivLoading();
					
					var QueryString = "ACTIONCONTROLER=getOficinasImpuesto&tabla_impuestos_id="+tabla_impuestos_id; 
					

					$.ajax({
						url: "TablaImpuestosClass.php?rand=" + Math.random(),
						data: QueryString,
						beforeSend: function () {
							showDivLoading();
						},
						success: function (resp) {

							var oficinas = $.parseJSON(resp);

							if (oficinas) {

								for (var i = 0; i < oficinas.length; i++) {

									var oficina_id = oficinas[i]['oficina_id'];

									$("select[name=oficina_id] option").each(function () {

										if (this.value == oficina_id) {
											this.selected = true;
											return true;
										}

									});


								}

							}

							removeDivLoading();

							if ($('#guardar')) $('#guardar').attr("disabled", "true");
							if ($('#actualizar')) $('#actualizar').attr("disabled", "");
							if ($('#borrar')) $('#borrar').attr("disabled", "");
							if ($('#limpiar')) $('#limpiar').attr("disabled", "");

						}
					});


				}
			});


		} catch (e) {

			alertJquery(resp, "Error :" + e);

			if ($('#guardar')) $('#guardar').attr("disabled", "true");
			if ($('#actualizar')) $('#actualizar').attr("disabled", "");
			if ($('#borrar')) $('#borrar').attr("disabled", "");
			if ($('#limpiar')) $('#limpiar').attr("disabled", "");

		}		
		
	});
}


function TablaImpuestosOnSaveUpdate(formulario,resp){
	
			Reset(formulario);
			clearFind();
			$("#refresh_QUERYGRID_TablaImpuestos").click();
			if($('#guardar'))    $('#guardar').attr("disabled","");
			if($('#actualizar')) $('#actualizar').attr("disabled","true");
			if($('#borrar'))     $('#borrar').attr("disabled","true");
			if($('#limpiar'))    $('#limpiar').attr("disabled","");
			
			alertJquery(resp);					
}


function TablaImpuestosOnDelete(formulario,resp){
	
			Reset(formulario);
			clearFind();
			$("#refresh_QUERYGRID_TablaImpuestos").click();
			if($('#guardar'))    $('#guardar').attr("disabled","");
			if($('#actualizar')) $('#actualizar').attr("disabled","true");
			if($('#borrar'))     $('#borrar').attr("disabled","true");
			if($('#limpiar'))    $('#limpiar').attr("disabled","");
			
			alertJquery(resp);				
	
}


function TablaImpuestosOnReset(){
	clearFind();
	$('#guardar').attr("disabled","");
	$('#actualizar').attr("disabled","true");
	$('#borrar').attr("disabled","true");
	$('#limpiar').attr("disabled","");
}

function setNombreImpuesto(){
	
  $("#impuesto_id").change(function(){
								   
    var lista = document.getElementById('impuesto_id');
	
	for(var i = 0; i < lista.options.length; i++){
		
		
		if(lista[i].value == this.value){
			
			document.getElementById('nombre').value = lista[i].text;
			
		}
		
		
	}
								   
  });	
	
}

function habilitaImpuestoBase(){
	
	$("#base").change(function(){
							   
		if(this.value == 'NULL' || this.value == 'F'){
          document.getElementById('base_impuesto_id').value    = 'NULL';			
		  document.getElementById('base_impuesto_id').disabled = true;
		}else{
			document.getElementById('base_impuesto_id').disabled = false;
		  }
							   
    });
	
}

function habilitaRteIca(){
	
	$("#rte").change(function(){
							   
		if(this.value == '1' || this.value == 'SI'){
          document.getElementById('ica').value  = '0';			
		  document.getElementById('ica').disabled = true;
		}else{
			document.getElementById('ica').disabled = false;
		  }
							   
    });

    	$("#ica").change(function(){
							   
		if(this.value == '1' || this.value == 'SI'){
          document.getElementById('rte').value    = '0';			
		  document.getElementById('rte').disabled = true;
		}else{
			document.getElementById('rte').disabled = false;
		  }
							   
    });
	
}

//eventos asignados a los objetos
$(document).ready(function(){
	
    setNombreImpuesto();
	habilitaImpuestoBase();
	habilitaRteIca();

	
});