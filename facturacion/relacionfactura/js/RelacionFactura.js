$(document).ready(function(){
	
	 $('#fecha_inicio').change(function(){

    var fechah = $('#fecha_final').val();
    var fechad = $('#fecha_inicio').val();
    var today = new Date();

    if ((Date.parse(fechah) < Date.parse(fechad)) || (Date.parse(fechad)>today)) {
     alertJquery('Esta fecha no puede ser mayor a la fecha final o mayor a hoy.');
     return this.value = $('#fecha_final').val();
    };
 });

 $('#fecha_final').change(function(){

    var fechah = $('#fecha_final').val();
    var fechad = $('#fecha_inicio').val();
    var today = new Date();

    if ((Date.parse(fechah) < Date.parse(fechad)) || (Date.parse(fechah)>today)) {
     alertJquery('Esta fecha no puede ser menor a la fecha de inicio o mayor a hoy.');
     return this.value = $('#fecha_inicio').val();
    };
 });
	var formulario	=	document.forms[0];
	ResetForm(formulario);
	resetDetalle('frameDepreciados');
});

function generateReporte(form){
	var numero_remesas    		= $("#numero_remesas").val();
	var solicitud_id    		= $("#solicitud_id").val();
	var fecha_inicio    		= $("#fecha_inicio").val();
	var fecha_final				= $("#fecha_final").val();
	var QueryString = "RelacionFacturaClass.php?ACTIONCONTROLER=generateReporte&fecha_inicio="+fecha_inicio+"&fecha_final="+fecha_final+"&solicitud_id="+solicitud_id+"&numero_remesas="+numero_remesas;
	$("#frameDepreciados").attr("src",QueryString);

}

function generateReporteExcel(form){
	var QueryString = "RelacionFacturaClass.php?ACTIONCONTROLER=generateReporte&download=SI";
	 document.location.href = QueryString;
}

function beforePrint(formulario){
	
   if(ValidaRequeridos(formulario)){
	 var QueryString = "RelacionFacturaClass.php?ACTIONCONTROLER=generateReporte&printers=si";  
	   popPup(QueryString,'Impresi&oacute;n Pendientes',800,600);
   }else{
	 alertJquery("Por favor ingrese los datos requeridos","Validaci&oacute;n");
   }
}
function closeDialog(){
	$("#Renovarmarco").dialog('close');
}


	function asociar(form){
		 
	
		var relacion_factura_id = window.frames[0].$("#relacion_factura_id").val();
		var remesas='';
		window.frames[0].$("input[name=procesar]:checked").each(function(){
			remesas+=','+$(this).val();
		});		
	
		
		var QueryString = "ACTIONCONTROLER=onclickAsociar&relacion_factura_id="+relacion_factura_id+"&remesas="+remesas;
		$.ajax({
			url        : "RelacionFacturaClass.php?rand="+Math.random(),
			data       : QueryString,
			beforeSend : function(){
				showDivLoading();
			},
			success    : function(resp){
				try{
					if(resp=='si'){
						alertJquery("Remesas Asociadas y Actualizadas Correctamente","Proceso finalizado");
						ResetForm(form);					
					}else{
						alertJquery(resp,"Validacion");
					}
				}catch(e){
					alertJquery(resp,"Error :"+e);
					ResetForm(form);
				}
				removeDivLoading();
			}
		});

}


function setDataFormWithResponse(){

}

function ResetForm(formulario){

   Reset(formulario);
    clearFind();
	$("#fecha_inicio").val("");
	$("#solicitud_id").val("");	
	$("#numero_remesas").val("");	
	resetDetalle('frameDepreciados');
	
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");	
	
}