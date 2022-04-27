// JavaScript Document
//funcion para cargar los datos desde BUSCAR
function setDataFormWithResponse(){
		
	var parametros  = new Array({campos:"rango_guia_id",valores:$('#rango_guia_id').val()});
	var forma       = document.forms[0];
	var controlador = 'RangoGuiaClass.php';
	
	FindRow(parametros,forma,controlador,null,function(resp){
													   
		if($('#guardar')) $('#guardar').attr("disabled","true");
		if($('#actualizar')) $('#actualizar').attr("disabled","");
		if($('#borrar'))     $('#borrar').attr("disabled","");
		if($('#limpiar'))    $('#limpiar').attr("disabled","");
  
	});
}

function RangoGuiaOnSaveUpdate(formulario,resp){
	Reset(formulario);  
	clearFind();
    $("#refresh_QUERYGRID_RangoGuia").click();
	if($('#guardar'))    $('#guardar').attr("disabled","");
	if($('#actualizar')) $('#actualizar').attr("disabled","true");
	if($('#borrar'))     $('#borrar').attr("disabled","true");
	if($('#limpiar'))    $('#limpiar').attr("disabled","");
	alertJquery($.trim(resp));
}

function RangoGuiaOnDelete(formulario,resp){
	Reset(formulario);
	clearFind();
	$("#refresh_QUERYGRID_RangoGuia").click();
	if($('#guardar'))    $('#guardar').attr("disabled","");
	if($('#actualizar')) $('#actualizar').attr("disabled","true");
	if($('#borrar'))     $('#borrar').attr("disabled","true");
	if($('#limpiar'))    $('#limpiar').attr("disabled","");
	alertJquery($.trim(resp));
}

function RangoGuiaOnReset(){
	
	clearFind();
	$('#guardar').attr("disabled","");
	$('#actualizar').attr("disabled","true");
	$('#borrar').attr("disabled","true");
	$('#limpiar').attr("disabled","");
	
   $("#inicio_disponible_res,#total_rango_guia,#rango_guia_ini,#rango_guia_fin,#utilizado_rango_guia,#saldo_rango_guia").val("0");		
}

/*se calcula el rango de los manifiestos asignados*/
function calculador( total ){
	var disponible        = $("#inicio_disponible_res").val();
	var utilizados        = $("#utilizado_rango_guia").val();
	var total_rango_guia = $("#total_rango_guia").val(); 

	var rango_guia_fin = parseInt(total_rango_guia) > 0 ? (Math.abs(Math.abs(parseInt(disponible)) + Math.abs(parseInt(total_rango_guia))) - 1) : 0;
		
	$("#rango_guia_ini").val( disponible );
	$("#rango_guia_fin").val(rango_guia_fin);
	$("#saldo_rango_guia").val( Math.abs(Math.abs(total_rango_guia) - Math.abs(utilizados)));
	
}

function calculaSaldo(){

  var total_rango_guia     = $("#total_rango_guia").val();	
  var utilizado_rango_guia = $("#utilizado_rango_guia").val();
  
  $("#saldo_rango_guia").val(Math.abs(Math.abs(total_rango_guia) - Math.abs(utilizado_rango_guia)));
	
}

/*se valida que no exista una agencia con rango asignado y estado activo*/
function validaAgencia(valor){
	
	    var valueOficinaId = valor;
				
		if( valueOficinaId != 'NULL'){
			
				
				var QueryString = "ACTIONCONTROLER=validaAgencia&oficina_id="+ valueOficinaId;
				$.ajax({
					url     : "RangoGuiaClass.php?rand="+Math.random(),
					data    : QueryString,
					success : function(response){
												
						var rango_guia_id = parseInt(response);
												
					    if(rango_guia_id > 0){
						  $("#rango_guia_id").val(rango_guia_id);
						  setDataFormWithResponse();
					    }else{
						     $("#rango_guia_id").val("");
                             $("#total_rango_guia,#rango_guia_ini,#rango_guia_fin,#utilizado_rango_guia,#saldo_rango_guia").val("0");									 
							 
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
	$("#total_rango_guia,#inicio_disponible_res").keyup(function(){
		calculador( $(this).val() );		
	});
	
	$("#utilizado_rango_guia").keyup(function(){
		calculaSaldo();
	});
	
	/*se optiene el inicio disponible del rango de manifiestos en los datos de la empresa*/
	$("#empresa_id").change(function(){
		if( $(this).val() != 'NULL'){
			if( !$("#rango_guia_id").val().length > 0 ){
				
				var QueryString = "ACTIONCONTROLER=setDisponibleRes&empresa_id="+ $(this).val();
				$.ajax({
					url     : "RangoGuiaClass.php",
					data    : QueryString,
					success : function(response){
																																				
						response = $.parseJSON(response);
						if($.isArray(response)){
							$("#inicio_disponible_res").val( response[0]['rango_guia_fin'] );
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