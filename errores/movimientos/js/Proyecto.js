// JavaScript Document

$(document).ready(function(){
  resetDetalle('detalleProyecto');
  $("#saveDetalles").click(function(){
    window.frames[0].saveDetallesSoliServi();
  });
    
  $("#deleteDetalles").click(function(){
    window.frames[0].deleteDetallesSoliServi();
  });   

  $("#saveTerceros").click(function(){
    window.frames[1].saveDetallesSoliServi();
  });
    
  $("#deleteTerceros").click(function(){
    window.frames[1].deleteDetallesSoliServi();
  });   
		

/*$("#ubicacion").blur(function(){
	//alert(document.getElementById('ubicacion_id'));
	var ubicacion_id = $('#ubicacion_hidden').val();
    getBarrio(ubicacion_id,null);
  }); */
								
});

function setDataFormWithResponse(){
  
RequiredRemove();

FindRow([{campos:"proyecto_id",valores:$('#proyecto_id').val()}],document.forms[0],'ProyectoClass.php',null, 
  function(resp){
    
  try{
    
  var data          = $.parseJSON(resp);  
  var proyecto_id = data[0]['proyecto_id']; 
  //var ubicacion_id = data[0]['ubicacion_id'];
  //var barrio_id = data[0]['barrio_id'];

    //getBarrio(ubicacion_id,barrio_id);
  
    if($('#guardar'))    $('#guardar').attr("disabled","true");
    if($('#actualizar')) $('#actualizar').attr("disabled","");
    if($('#borrar'))     $('#borrar').attr("disabled","");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");
  
  }catch(e){
     alertJquery(resp,"Error :"+e);
    }
  
  });



}

function getBarrio(valor,barrio_id){

 var url         = 'ProyectoClass.php?rand='+Math.random();
 var QueryString = 'ACTIONCONTROLER=getBarrio&ubicacion_id='+valor+"&barrio_id="+barrio_id; 
 
 $.ajax({
	url  : url,
	data : QueryString, 
	beforeSend: function(){
		showDivLoading();
	},
	success : function(responseText){

       try{
		
		if($.trim(responseText) == 'null'){			
		  alert('No existen cuentas paramtrizadas para el reporte!!');
		}else{
						var option = $.parseJSON(responseText);
			   
			$("#barrio_id option").each(function(index, element) {
			  
			  if(this.value != 'NULL'){
				  $(this).remove();
			  }
				  
			});
			
			for(var i = 0; i < option.length; i++){
			 $("#barrio_id").append("<option value='"+option[i]['value']+"' selected='"+option[i]['value']+"'>"+option[i]['text']+"</option>");	
			}
		  }
		   
	   }catch(e){
		   alert("Error :"+responseText);
		}

	   removeDivLoading();
	}
 });

}

function ProyectoOnSaveOnUpdateonDelete(formulario,resp){

   Reset(formulario);
   clearFind();
   resetDetalle('detalleProyecto');   
   $("#refresh_QUERYGRID_Proyecto").click();
   
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
  
   alertJquery(resp,"Proyecto");
   
}
function ProyectoOnReset(formulario){
  
    Reset(formulario);
    clearFind();  
  resetDetalle('detalleProyecto');
  
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled",""); 
}