// JavaScript Document
//funcion para cargar los datos desde BUSCAR
function setDataFormWithResponse() {

	RequiredRemove();

	var forma = document.forms[0];
	var QueryString = "ACTIONCONTROLER=onclickFind&bodega_id=" + $('#bodega_id').val();

	$.ajax({
		url: 'Crear_BodegaClass.php?random=' + Math.random(),
		data: QueryString,
		beforeSend: function () {
			showDivLoading();
		},
		success: function (resp) {

			try {
				var data = $.parseJSON(resp);
				var ubicacion = data[0]['ubicacion'];
				var ubicacion_id = data[0]['ubicacion_id'];
				var estado = data[0]['estado'];

				setFormWithJSON(forma, data, false, function () {

					if ($('#guardar')) $('#guardar').attr("disabled", "true");
					if ($('#actualizar')) $('#actualizar').attr("disabled", "");
					if ($('#borrar')) $('#borrar').attr("disabled", "");
					if ($('#limpiar')) $('#limpiar').attr("disabled", "");
				});
			} catch (e) {
				alertJquery(resp, "Error :" + e);
			}

			removeDivLoading();

		}

	});



}


function Crear_BodegaOnSaveUpdate(formulario,resp){
	  Reset(formulario);  
	  clearFind();
      $("#refresh_QUERYGRID_Crear_Bodega").click();
	  if($('#guardar'))    $('#guardar').attr("disabled","");
	  if($('#actualizar')) $('#actualizar').attr("disabled","true");
	  if($('#borrar'))     $('#borrar').attr("disabled","true");
	  if($('#limpiar'))    $('#limpiar').attr("disabled","");
	  alertJquery($.trim(resp));
}


function Crear_BodegaOnDelete(formulario,resp){
   Reset(formulario);  
   clearFind();
   $("#refresh_QUERYGRID_Crear_Bodega").click();   
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
   alertJquery($.trim(resp));
}

function Crear_BodegaOnReset(){
  clearFind();
  $('#guardar').attr("disabled","");
  $('#actualizar').attr("disabled","true");
  $('#borrar').attr("disabled","true");
  $('#limpiar').attr("disabled","");  
}

//eventos asignados a los objetos
$(document).ready(function(){
  
/*    $('#alto').keypress( function(){
	   alertJquery("oprime");
	   setFormatCurrency($('#alto').val());
   }); */
	
  //evento que busca los datos ingresados
  $('#ancho').blur(function (){

	  var alto = $('#alto').val();
	  var alto = alto.replace(',','.');

	  var largo = $('#largo').val();
	  var largo = largo.replace(',', '.');

	  var ancho = $('#ancho').val();
	  var ancho = ancho.replace(',', '.');

	  var area=(largo*ancho);
	  var volumen = (largo * ancho* alto);
	  
	  $('#area').val(area);
	  $('#volumen').val(volumen);
  });
	
	var url = "DetalleCrear_BodegaClass.php";
	$("#detallePoliza").attr("src",url);
});