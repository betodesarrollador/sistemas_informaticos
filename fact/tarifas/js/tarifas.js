// JavaScript Document
function setDataFormWithResponse(){
    var tarifasId = $('#tarifa_cliente_id').val();
    RequiredRemove();

    var parametros  = new Array({campos:"tarifa_cliente_id",valores:$('#tarifa_cliente_id').val()});
	var forma       = document.forms[0];
	var controlador = 'TarifasClass.php';

	FindRow(parametros,forma,controlador,null,function(resp){
      if($('#guardar'))    $('#guardar').attr("disabled","true");
      if($('#actualizar')) $('#actualizar').attr("disabled","");
      if($('#borrar'))     $('#borrar').attr("disabled","");
      if($('#limpiar'))    $('#limpiar').attr("disabled","");	  
    });


}

function showTable(){
  
  var frame_grid =  document.getElementById('frame_grid');
  
    //Se valida que el iFrame no exista
    if(frame_grid == null ){

    var QueryString   = 'ACTIONCONTROLER=showGrid';

    $.ajax({
      url        : "TarifasClass.php?rand="+Math.random(),
      data       : QueryString,
       async     : false,
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

function TarifasOnSaveOnUpdateonDelete(formulario,resp){

   clearFind();
   $("#refresh_QUERYGRID_tarifas").click();
   
   if($('#guardar'))    $('#guardar').attr("disabled","true");
   if($('#actualizar')) $('#actualizar').attr("disabled","");
   if($('#borrar'))     $('#borrar').attr("disabled","");
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
			 if(parseFloat($('#cupo_cliente').val()) <= parseFloat($('#cupofin_cliente').val()) && parseFloat($('#tone_cliente').val()) <= parseFloat($('#tonefin_cliente').val()) && parseFloat($('#vol_cliente').val()) <= parseFloat($('#volfin_cliente').val())){	
				Send(formulario,'onclickSave',null,TarifasOnSaveOnUpdateonDelete)
			 }else{
				alertJquery("Uno de los Valores Finales es Menor que el Inicial","Tarifas");
			 }
		}else{
		 	if(parseFloat($('#cupo_cliente').val()) <= parseFloat($('#cupofin_cliente').val()) && parseFloat($('#tone_cliente').val()) <= parseFloat($('#tonefin_cliente').val()) && parseFloat($('#vol_cliente').val()) <= parseFloat($('#volfin_cliente').val())){	
            	Send(formulario,'onclickUpdate',null,TarifasOnSaveOnUpdateonDelete)
			 }else{
				alertJquery("Uno de los Valores Finales es Menor que el Inicial","Tarifas");
			 }
		}
	  }
	  	  
  });

});
	
