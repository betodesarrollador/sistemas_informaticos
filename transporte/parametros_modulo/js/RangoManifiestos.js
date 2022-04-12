// JavaScript Document
//funcion para cargar los datos desde BUSCAR
function setDataFormWithResponse(){
		
	var parametros  = new Array({campos:"rango_manif_id",valores:$('#rango_manif_id').val()});
	var forma       = document.forms[0];
	var controlador = 'RangoManifiestosClass.php';
	
	FindRow(parametros,forma,controlador,null,function(resp){
													   
		if($('#guardar')) $('#guardar').attr("disabled","true");
		if($('#actualizar')) $('#actualizar').attr("disabled","");
		if($('#borrar'))     $('#borrar').attr("disabled","");
		if($('#limpiar'))    $('#limpiar').attr("disabled","");
  
	});
}


function RangoManifiestosOnSaveUpdate(formulario,resp){
	Reset(formulario);  
	clearFind();
    $("#refresh_QUERYGRID_RangoManifiestos").click();
	if($('#guardar'))    $('#guardar').attr("disabled","");
	if($('#actualizar')) $('#actualizar').attr("disabled","true");
	if($('#borrar'))     $('#borrar').attr("disabled","true");
	if($('#limpiar'))    $('#limpiar').attr("disabled","");
	alertJquery($.trim(resp));
}


function RangoManifiestosOnDelete(formulario,resp){
	Reset(formulario);
	clearFind();
	$("#refresh_QUERYGRID_RangoManifiestos").click();
	if($('#guardar'))    $('#guardar').attr("disabled","");
	if($('#actualizar')) $('#actualizar').attr("disabled","true");
	if($('#borrar'))     $('#borrar').attr("disabled","true");
	if($('#limpiar'))    $('#limpiar').attr("disabled","");
	alertJquery($.trim(resp));
}

function RangoManifiestosOnReset(){
	
	clearFind();
	$('#guardar').attr("disabled","");
	$('#actualizar').attr("disabled","true");
	$('#borrar').attr("disabled","true");
	$('#limpiar').attr("disabled","");
	
   $("#inicio_disponible_res,#total_rango_manif,#rango_manif_ini,#rango_manif_fin,#utilizado_rango_manif,#saldo_rango_manif").val("0");	
	
}

/*se calcula el rango de los manifiestos asignados*/
function calculador( total ){
	var disponible        = $("#inicio_disponible_res").val();
	var utilizados        = $("#utilizado_rango_manif").val();
	var total_rango_manif = $("#total_rango_manif").val(); 

	var rango_manif_fin = parseInt(total_rango_manif) > 0 ? (Math.abs(Math.abs(parseInt(disponible)) + Math.abs(parseInt(total_rango_manif))) - 1) : 0;
		
	$("#rango_manif_ini").val( disponible );
	$("#rango_manif_fin").val(rango_manif_fin);
	$("#saldo_rango_manif").val( Math.abs(Math.abs(total_rango_manif) - Math.abs(utilizados)));
	
}

function calculaSaldo(){

  var total_rango_manif     = $("#total_rango_manif").val();	
  var utilizado_rango_manif = $("#utilizado_rango_manif").val();
  
  $("#saldo_rango_manif").val(Math.abs(Math.abs(total_rango_manif) - Math.abs(utilizado_rango_manif)));
	
	
}

/*se valida que no exista una agencia con rango asignado y estado activo*/
function validaAgencia(valor){
	
	    var valueOficinaId = valor;
				
		if( valueOficinaId != 'NULL'){
			
				
				var QueryString = "ACTIONCONTROLER=validaAgencia&oficina_id="+ valueOficinaId;
				$.ajax({
					url     : "RangoManifiestosClass.php?rand="+Math.random(),
					data    : QueryString,
					success : function(response){
												
						var rango_manif_id = parseInt(response);
												
					    if(rango_manif_id > 0){
						  $("#rango_manif_id").val(rango_manif_id);
						  setDataFormWithResponse();
					    }else{
						     $("#rango_manif_id").val("");
                             $("#total_rango_manif,#rango_manif_ini,#rango_manif_fin,#utilizado_rango_manif,#saldo_rango_manif").val("0");			
							 
							 
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
	$("#total_rango_manif,#inicio_disponible_res").keyup(function(){
		calculador( $(this).val() );		
	});
	
	$("#utilizado_rango_manif").keyup(function(){
		calculaSaldo();
	});
	
	/*se optiene el inicio disponible del rango de manifiestos en los datos de la empresa*/
	$("#empresa_id").change(function(){
		if( $(this).val() != 'NULL'){
			if( !$("#rango_manif_id").val().length > 0 ){
				
				var QueryString = "ACTIONCONTROLER=setDisponibleRes&empresa_id="+ $(this).val();
				$.ajax({
					url     : "RangoManifiestosClass.php",
					data    : QueryString,
					success : function(response){
																																				
						response = $.parseJSON(response);
						if($.isArray(response)){
							$("#inicio_disponible_res").val( response[0]['rango_manif_fin'] );
						}else{
							alertJquery("Ocurrio una inconsistencia,\n Verifique los Datos basicos de la empresa");
						}
						/*se valida que no exista una agencia con rango asignado y estado activo*/

					}
				});
				
			}
		}else{
			$("#inicio_disponible_res").val( 0 );
		}
	});
	
});