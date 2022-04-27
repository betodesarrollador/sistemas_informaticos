// JavaScript Document
//funcion para cargar los datos desde BUSCAR
function setDataFormWithResponse(){
		
	var parametros  = new Array({campos:"rango_orden_servicio_id",valores:$('#rango_orden_servicio_id').val()});
	var forma       = document.forms[0];
	var controlador = 'RangoOrdenServicioClass.php';
	
	FindRow(parametros,forma,controlador,null,function(resp){
													   
		if($('#guardar')) $('#guardar').attr("disabled","true");
		if($('#actualizar')) $('#actualizar').attr("disabled","");
		if($('#borrar'))     $('#borrar').attr("disabled","");
		if($('#limpiar'))    $('#limpiar').attr("disabled","");
  
	});
}

function RangoOrdenServicioOnSaveUpdate(formulario,resp){
	Reset(formulario);  
	clearFind();
    $("#refresh_QUERYGRID_RangoOrdenServicio").click();
	if($('#guardar'))    $('#guardar').attr("disabled","");
	if($('#actualizar')) $('#actualizar').attr("disabled","true");
	if($('#borrar'))     $('#borrar').attr("disabled","true");
	if($('#limpiar'))    $('#limpiar').attr("disabled","");
	alertJquery($.trim(resp));
}

function RangoOrdenServicioOnDelete(formulario,resp){
	Reset(formulario);
	clearFind();
	$("#refresh_QUERYGRID_RangoOrdenServicio").click();
	if($('#guardar'))    $('#guardar').attr("disabled","");
	if($('#actualizar')) $('#actualizar').attr("disabled","true");
	if($('#borrar'))     $('#borrar').attr("disabled","true");
	if($('#limpiar'))    $('#limpiar').attr("disabled","");
	alertJquery($.trim(resp));
}

function RangoOrdenServicioOnReset(){
	
	clearFind();
	$('#guardar').attr("disabled","");
	$('#actualizar').attr("disabled","true");
	$('#borrar').attr("disabled","true");
	$('#limpiar').attr("disabled","");
	
   $("#inicio_disponible_res,#total_rango_orden_servicio,#rango_orden_servicio_ini,#rango_orden_servicio_fin,#utilizado_rango_orden_servicio,#saldo_rango_orden_servicio").val("0");		
}

/*se calcula el rango de los manifiestos asignados*/
function calculador( total ){
	var disponible        = $("#inicio_disponible_res").val();
	var utilizados        = $("#utilizado_rango_orden_servicio").val();
	var total_rango_orden_servicio = $("#total_rango_orden_servicio").val(); 

	var rango_orden_servicio_fin = parseInt(total_rango_orden_servicio) > 0 ? (Math.abs(Math.abs(parseInt(disponible)) + Math.abs(parseInt(total_rango_orden_servicio))) - 1) : 0;
		
	$("#rango_orden_servicio_ini").val( disponible );
	$("#rango_orden_servicio_fin").val(rango_orden_servicio_fin);
	$("#saldo_rango_orden_servicio").val( Math.abs(Math.abs(total_rango_orden_servicio) - Math.abs(utilizados)));
	
}

function calculaSaldo(){

  var total_rango_orden_servicio     = $("#total_rango_orden_servicio").val();	
  var utilizado_rango_orden_servicio = $("#utilizado_rango_orden_servicio").val();
  
  $("#saldo_rango_orden_servicio").val(Math.abs(Math.abs(total_rango_orden_servicio) - Math.abs(utilizado_rango_orden_servicio)));
	
}

/*se valida que no exista una agencia con rango asignado y estado activo*/
function validaAgencia(valor){
	
	    var valueOficinaId = valor;
				
		if( valueOficinaId != 'NULL'){
			
				
				var QueryString = "ACTIONCONTROLER=validaAgencia&oficina_id="+ valueOficinaId;
				$.ajax({
					url     : "RangoOrdenServicioClass.php?rand="+Math.random(),
					data    : QueryString,
					success : function(response){
												
						var rango_orden_servicio_id = parseInt(response);
												
					    if(rango_orden_servicio_id > 0){
						  $("#rango_orden_servicio_id").val(rango_orden_servicio_id);
						  setDataFormWithResponse();
					    }else{
						     $("#rango_orden_servicio_id").val("");
                             $("#total_rango_orden_servicio,#rango_orden_servicio_ini,#rango_orden_servicio_fin,#utilizado_rango_orden_servicio,#saldo_rango_orden_servicio").val("0");									 
							 
		if($('#guardar')) $('#guardar').attr("disabled","");
		if($('#actualizar')) $('#actualizar').attr("disabled","true");
		if($('#borrar'))     $('#borrar').attr("disabled","true");
		if($('#limpiar'))    $('#limpiar').attr("disabled","");							 
							 							 					 
						  }								
					  }
				});
		}
}

//eventos asignados a los objetos
$(document).ready(function(){
	/*se calcula el rango de los manifiestos asignados*/
	$("#total_rango_orden_servicio,#inicio_disponible_res").keyup(function(){
		calculador( $(this).val() );		
	});
	
	$("#utilizado_rango_orden_servicio").keyup(function(){
		calculaSaldo();
	});
	
	/*se optiene el inicio disponible del rango de manifiestos en los datos de la empresa*/
	$("#empresa_id").change(function(){
		if( $(this).val() != 'NULL'){
			if( !$("#rango_orden_servicio_id").val().length > 0 ){
				
				var QueryString = "ACTIONCONTROLER=setDisponibleRes&empresa_id="+ $(this).val();
				$.ajax({
					url     : "RangoOrdenServicioClass.php",
					data    : QueryString,
					success : function(response){
																																				
						response = $.parseJSON(response);
						if($.isArray(response)){
							$("#inicio_disponible_res").val( response[0]['rango_orden_servicio_fin'] );
						}else{
							alertJquery("Ocurrio una inconsistencia,\n Verifique los Datos basicos de la empresa");
						}
						/*se valida que no exista una agencia con rango asignado y estado activo*/

					}
				});				
			}
		}else{
			$("#inicio_disponible_res").val(0);
		}
	});
	
});