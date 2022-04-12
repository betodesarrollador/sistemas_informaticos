// JavaScript Document
function setDataFormWithResponse(){
    var tarifasId = $('#tarifa_proveedor_id').val();
    RequiredRemove();

    var parametros  = new Array({campos:"tarifa_proveedor_id",valores:$('#tarifa_proveedor_id').val()});
	var forma       = document.forms[0];
	var controlador = 'TarifasClass.php';

	FindRow(parametros,forma,controlador,null,function(resp){
      if($('#guardar'))    $('#guardar').attr("disabled","true");
      if($('#actualizar')) $('#actualizar').attr("disabled","");
      if($('#borrar'))     $('#borrar').attr("disabled","");
      if($('#limpiar'))    $('#limpiar').attr("disabled","");	  
    });


}

function TarifasOnSaveOnUpdateonDelete(formulario,resp){
	Reset(formulario);
   clearFind();
   $("#refresh_QUERYGRID_tarifas").click();
   
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
	
   alertJquery(resp,"Tarifas");
   
}
function TarifasOnReset(formulario){
	
    clearFind();	
	
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");	
}

$(document).ready(function(){
						   
  $("#guardar,#actualizar").click(function(){
	  
	  var formulario = document.getElementById('TarifasForm');
	  
	  if(ValidaRequeridos(formulario)){ 
	    if(this.id == 'guardar'){
			 if(parseFloat(removeFormatCurrency($('#cupo_proveedor').val())) <= parseFloat(removeFormatCurrency($('#cupofin_proveedor').val())) 
				&& parseFloat(removeFormatCurrency($('#tone_proveedor').val())) <= parseFloat(removeFormatCurrency($('#tonefin_proveedor').val())) 
				&& parseFloat(removeFormatCurrency($('#vol_proveedor').val())) <= parseFloat(removeFormatCurrency($('#volfin_proveedor').val()))  
				&& parseFloat(removeFormatCurrency($('#cant_proveedor').val())) <= parseFloat(removeFormatCurrency($('#cantfin_proveedor').val())) 
				&& parseFloat(removeFormatCurrency($('#antpropio_proveedor').val())) <= parseFloat(removeFormatCurrency($('#antfinpropio_proveedor').val())) &&  parseFloat(removeFormatCurrency($('#antpropio_proveedor').val()))>9999
				&& parseFloat($('#ant_proveedor').val()) <= parseFloat($('#antfin_proveedor').val())){	
				Send(formulario,'onclickSave',null,TarifasOnSaveOnUpdateonDelete)
			 }else{
				alertJquery("Uno de los Valores Maximos es Menor que el Minimo <br>o El valor del propio es menor a $10.000","Tarifas");
			 }
		}else{
			 if(parseFloat(removeFormatCurrency($('#cupo_proveedor').val())) <= parseFloat(removeFormatCurrency($('#cupofin_proveedor').val())) 
				&& parseFloat(removeFormatCurrency($('#tone_proveedor').val())) <= parseFloat(removeFormatCurrency($('#tonefin_proveedor').val())) 
				&& parseFloat(removeFormatCurrency($('#vol_proveedor').val())) <= parseFloat(removeFormatCurrency($('#volfin_proveedor').val()))  
				&& parseFloat(removeFormatCurrency($('#cant_proveedor').val())) <= parseFloat(removeFormatCurrency($('#cantfin_proveedor').val())) 
				&& parseFloat(removeFormatCurrency($('#antpropio_proveedor').val())) <= parseFloat(removeFormatCurrency($('#antfinpropio_proveedor').val())) &&  parseFloat(removeFormatCurrency($('#antpropio_proveedor').val()))>9999
				&& parseFloat($('#ant_proveedor').val()) <= parseFloat($('#antfin_proveedor').val())){	
            	Send(formulario,'onclickUpdate',null,TarifasOnSaveOnUpdateonDelete)
			 }else{
				alertJquery("Uno de los Valores Maximos es Menor que el Minimo <br>o El valor del propio es menor a $10.000","Tarifas");
			 }
		}
	  }
	  	  
  });

});
	
function SetCarga(){
  var configuracion = $("#configuracion").val();
    
  var QueryString = "ACTIONCONTROLER=SetCarga&configuracion="+configuracion;
  
  $.ajax({
    url        : "TarifasClass.php?rand="+Math.random(),
    data       : QueryString,
    beforeSend : function(){
      
    },
    success    : function(response){
      
      try{
	
		var responseArray     = $.parseJSON(response); 
		var capacidad_carga   = responseArray[0]['capacidad_carga'];
		
		$("#capacidad_carga").val(capacidad_carga);
	
      }catch(e){
	  alertJquery(e);
       }
      
    }
    
  });
  
}
