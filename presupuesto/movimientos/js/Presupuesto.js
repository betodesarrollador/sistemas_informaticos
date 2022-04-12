// JavaScript Document
//eventos asignados a los objetos
$(document).ready(function(){
	
    $("#saveDetallesPresupuesto").click(function(){
      window.frames[0].saveDetallesPresupuesto();
    });
	
    resetDetalle("detallePresupuesto");
    
    document.getElementById("detallePresupuesto").height = '350';
	
});


function setDataFormWithResponse(){
	
    var parametros 	= new Array ({campos:"presupuesto_id", valores:$('#presupuesto_id').val()});
    var forma 	= document.forms[0];
    var controlador = 'PresupuestoClass.php';
    
    FindRow(parametros,forma,controlador,null,function(resp){
	    
      var presupuesto_id = $('#presupuesto_id').val();
      var url 	         = "DetallePresupuestoClass.php?presupuesto_id="+presupuesto_id;
      
      $("#detallePresupuesto").attr("src",url);
      
      if($('#guardar'))    $('#guardar').attr("disabled","true");
      if($('#actualizar')) $('#actualizar').attr("disabled","");
      if($('#borrar'))     $('#borrar').attr("disabled","");
      if($('#limpiar'))    $('#limpiar').attr("disabled","");
	    
    });
}

function PresupuestoOnSave(formulario,resp){

  try{
 
    var presupuesto_id = parseInt($.trim(resp)); 
    
    if(!isNaN(presupuesto_id)){
        
		$("#presupuesto_id").val(presupuesto_id);
        var periodo = $("#periodo_contable_id option:selected").text(); 
				
        alertJquery('Ahora Puede Ingresar el presupuesto para el año ['+periodo+']','Presupuesto');
        document.getElementById('detallePresupuesto').src = 'DetallePresupuestoClass.php?presupuesto_id='+presupuesto_id;
		
		if($('#guardar'))    $('#guardar').attr("disabled","true");
		if($('#actualizar')) $('#actualizar').attr("disabled","");
		if($('#borrar'))     $('#borrar').attr("disabled","");
		if($('#limpiar'))    $('#limpiar').attr("disabled","");
          
    }else{
        alertJquery(resp,'Error:')
     }       
    
  }catch(e){
    alertJquery(e+'<br>'+resp,'Error:');
  }

}


function PresupuestoOnUpdate(formulario,resp){
	          
	if($.trim(resp) == 'true'){
	  		
	  window.frames[0].setDetallePresupuesto();
	
	}else{
		alertJquery(resp,"Presupuesto");
	}
}


function PresupuestoOnDelete(formulario,resp){
	PresupuestoOnReset();
	Reset(formulario);
	clearFind();
	alertJquery(resp);
}

function PresupuestoOnReset(){
  
    resetDetalle("detallePresupuesto");
    
    $('#guardar').attr("disabled","");
    $('#actualizar').attr("disabled","true");
    $('#borrar').attr("disabled","true");
    $('#limpiar').attr("disabled","");
    	
}