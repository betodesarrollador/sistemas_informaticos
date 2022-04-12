// JavaScript Document
function setDataFormWithResponse(){
	var parametrosId = $('#retencion_salarial_id').val();
	var parametros  = new Array({campos:"retencion_salarial_id",valores:parametrosId});
	var forma       = document.forms[0];
	var controlador = 'RetencionClass.php';

	
	FindRow(parametros,forma,controlador,null,function(resp){

		if($('#guardar'))    $('#guardar').attr("disabled","true");
		if($('#actualizar')) $('#actualizar').attr("disabled","");
		if($('#borrar'))     $('#borrar').attr("disabled","");
		if($('#limpiar'))    $('#limpiar').attr("disabled","");
	});

	$('#rango_ini,#rango_fin,#porcentaje,#concepto').attr("disabled", "");
}

function showTable(){
  
	var frame_grid =  document.getElementById('frame_grid');
	
	  //Se valida que el iFrame no exista
	  if(frame_grid == null ){
  
	  var QueryString   = 'ACTIONCONTROLER=showGrid';
  
	  $.ajax({
		url        : "RetencionClass.php?rand="+Math.random(),
		data       : QueryString,
		 async     :false,
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

function RetencionOnSaveOnUpdateonDelete(formulario,resp){
	Reset(formulario);
	clearFind();
	$("#refresh_QUERYGRID_retencion_salarial").click();
	if($('#guardar'))    $('#guardar').attr("disabled","");
	if($('#actualizar')) $('#actualizar').attr("disabled","true");
	if($('#borrar'))     $('#borrar').attr("disabled","true");
	if($('#limpiar'))    $('#limpiar').attr("disabled","");
	alertJquery(resp,"Depreciacion");
}

function RetencionOnReset(formulario){
	 Reset(formulario);
    clearFind();  
    setFocusFirstFieldForm(formulario); 
	if($('#guardar'))    $('#guardar').attr("disabled","");
	if($('#actualizar')) $('#actualizar').attr("disabled","true");
	if($('#borrar'))     $('#borrar').attr("disabled","true");
	if($('#limpiar'))    $('#limpiar').attr("disabled","");
}

function calculaUVTini() {
	
	var rango_ini = $("#rango_ini").val();
	var periodo_contable_id = $("#periodo_contable_id").val();

	var QueryString = "ACTIONCONTROLER=calculauvt&periodo_contable_id=" + periodo_contable_id;

	$.ajax({
		url: "RetencionClass.php?rand=" + Math.random(),
		data: QueryString,
		beforeSend: function () {

		},
		success: function (response) {

			try {
				showDivLoading();
				var responseArray = $.parseJSON(response);

				var uvt_nominal = responseArray[0]['uvt_nominal'];

				var total = (parseInt(uvt_nominal)*parseInt(rango_ini));

				


				$("#rango_ini_pesos").val(setFormatCurrency(total));
				removeDivLoading();


			} catch (e) {
				//alertJquery(e);
			}

		}

	});


}

function calculaUVTfin() {
	
	var rango_fin = $("#rango_fin").val();
	var periodo_contable_id = $("#periodo_contable_id").val();

	var QueryString = "ACTIONCONTROLER=calculauvt&periodo_contable_id=" + periodo_contable_id;

	$.ajax({
		url: "RetencionClass.php?rand=" + Math.random(),
		data: QueryString,
		beforeSend: function () {

		},
		success: function (response) {

			try {
				showDivLoading();
				var responseArray = $.parseJSON(response);

				var uvt_nominal = responseArray[0]['uvt_nominal'];

				var total = (uvt_nominal * rango_fin);

				$("#rango_fin_pesos").val(setFormatCurrency(total));
				removeDivLoading();


			} catch (e) {
				//alertJquery(e);
			}

		}

	});


}



$(document).ready(function(){

	$('#rango_ini,#rango_fin,#porcentaje,#concepto').attr("disabled", "true");

	$("#periodo_contable_id").blur(function() {		
		if ($("#periodo_contable_id").val() == 'NULL') {
			$('#rango_ini,#rango_fin,#porcentaje,#concepto').attr("disabled", "true");	
		}else{
			$('#rango_ini,#rango_fin,#porcentaje,#concepto').attr("disabled", "");	

		}

	});

	$("#rango_ini,#rango_fin").keyup(function(){
		// var formulario = document.getElementById('RetencionForm');
		// if(ValidaRequeridos(formulario)){
			if (this.id == 'rango_ini'){
				calculaUVTini();
			}else{
				calculaUVTfin();
			}
		// }
	});

	$("#guardar,#actualizar").click(function(){
		var formulario = document.getElementById('RetencionForm');
		if(ValidaRequeridos(formulario)){
			if(this.id == 'guardar'){
				Send(formulario,'onclickSave',null,RetencionOnSaveOnUpdateonDelete)
			}else{
				Send(formulario,'onclickUpdate',null,RetencionOnSaveOnUpdateonDelete)
			}
		}
	});
});