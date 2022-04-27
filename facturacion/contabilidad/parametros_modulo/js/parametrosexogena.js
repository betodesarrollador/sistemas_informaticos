// JavaScript Document
function onclickDuplicar(formulario){
	if(formulario == null){
		formulario = document.getElementById('ParametrosExogenaForm'); 
		}
	if($("#divDuplicar").is(":visible")){
	 
	   var formato_base   	= $("#formato_base").val();
	   var tipo_formato_n   = $("#tipo_formato_n").val();
	   var version_n   		= $("#version_n").val();
	   var resolucion_n   	= $("#resolucion_n").val();

	   var cuantia_minima_n     = $("#cuantia_minima_n").val();
	   var fecha_resolucion_n  	= $("#fecha_resolucion_n").val();
	   var ano_gravable_n   	= $("#ano_gravable_n").val();

	   if(ValidaRequeridos(formulario)){ 
			var QueryString = "ACTIONCONTROLER=onclickDuplicar&formato_base="+formato_base+"&tipo_formato_n="+tipo_formato_n+"&version_n="+version_n+"&resolucion_n="+resolucion_n+"&cuantia_minima_n="+cuantia_minima_n+"&fecha_resolucion_n="+fecha_resolucion_n+"&ano_gravable_n="+ano_gravable_n;
			
			$.ajax({
			   url        : "ParametrosExogenaClass.php",
			   data       : QueryString,
			   beforeSend : function(){
				 showDivLoading();
			   },
			   success : function(response){
				   
				   
				  try{
						var data	= $.parseJSON(response);
						if(response=='true'){
							alertJquery('Parametro Duplicado Exitosamente',"Parametros Exogena");
						}else{
							alertJquery('Error al Duplicar Parametro.',"Parametros Exogena");					
						}
					}catch(e){
						alertJquery(response,"Error");
					}	
								 
				 removeDivLoading();			 
				 }
				 
			 });
	   }
    }else{
		
		    $("#divDuplicar").dialog({
			  title: 'Duplicar Parametro Exogena',
			  width: 680,
			  height: 280,
			  closeOnEscape:true
             });
		
	}  
	  
}

function showTable(){
  
	var frame_grid =  document.getElementById('frame_grid');
	
	  //Se valida que el iFrame no exista
	  if(frame_grid == null ){
  
	  var QueryString   = 'ACTIONCONTROLER=showGrid';
  
	  $.ajax({
		url        : "ParametrosExogenaClass.php?rand="+Math.random(),
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

function Generar(formulario){

	document.location.href = "ParametrosExogenaClass.php?ACTIONCONTROLER=generateFile&"+Math.random()+FormSerialize(formulario);	
}


function setDataFormWithResponse(){
   
    //RequiredRemove();
	var formatoExogenaId = $('#formato_exogena_id').val();
    var parametros  = new Array({campos:"formato_exogena_id",valores:$('#formato_exogena_id').val()});
	var forma       = document.forms[0];
	var controlador = 'ParametrosExogenaClass.php';

	FindRow(parametros,forma,controlador,null,function(resp){
      if($('#guardar'))    $('#guardar').attr("disabled","true");
      if($('#actualizar')) $('#actualizar').attr("disabled","");
      if($('#borrar'))     $('#borrar').attr("disabled","");
      if($('#limpiar'))    $('#limpiar').attr("disabled","");	
	  var url = "DetallesParametrosClass.php?formato_exogena_id="+formatoExogenaId+"&rand="+Math.random();
	  $("#detalles").attr("src",url);						  	
    });
}
function ParametrosExogenaOnSave(formulario,resp){
   if(parseInt(resp)>0){
		var formato_exogena_id = resp;
		var url = "DetallesParametrosClass.php?formato_exogena_id="+formato_exogena_id+"&rand="+Math.random();
		$("#formato_exogena_id").val(formato_exogena_id);						
		$("#detalles").attr("src",url);						  	
	   $("#refresh_QUERYGRID_formato_exogena").click();
	   
	   if($('#guardar'))    $('#guardar').attr("disabled","true");
	   if($('#actualizar')) $('#actualizar').attr("disabled","");
	   if($('#borrar'))     $('#borrar').attr("disabled","");
	   if($('#limpiar'))    $('#limpiar').attr("disabled","");
		
	   alertJquery("Guardado Exitosamente","ParametrosExogena");
   }else{
	   alertJquery("Ocurrio una Inconsistencia","ParametrosExogena");
   }
}
function ParametrosExogenaOnUpdate(formulario,resp){
   if(resp){
		var formato_exogena_id = $("#formato_exogena_id").val();
		var url = "DetallesParametrosClass.php?formato_exogena_id="+formato_exogena_id+"&rand="+Math.random();
		$("#detalles").attr("src",url);						  	
   }
   $("#refresh_QUERYGRID_formato_exogena").click();
   
   if($('#guardar'))    $('#guardar').attr("disabled","true");
   if($('#actualizar')) $('#actualizar').attr("disabled","");
   if($('#borrar'))     $('#borrar').attr("disabled","");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
	
   alertJquery(resp,"ParametrosExogena");
}
function ParametrosExogenaOnDelete(formulario,resp){
   if(resp){
		$("#detalles").attr("src","../../../framework/tpl/blank.html");
	   clearFind();
       $("#refresh_QUERYGRID_formato_exogena").click();
	   
	   if($('#guardar'))    $('#guardar').attr("disabled","");
	   if($('#actualizar')) $('#actualizar').attr("disabled","true");
	   if($('#borrar'))     $('#borrar').attr("disabled","true");
	   if($('#limpiar'))    $('#limpiar').attr("disabled","");
   }
   alertJquery(resp,"ParametrosExogena");
}
function ParametrosExogenaOnReset(formulario){
	$("#detalles").attr("src","../../../framework/tpl/blank.html");
    clearFind();		
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");	
}
$(document).ready(function(){
  $("#saveDetalle").click(function(){										
    window.frames[0].saveDetalles();	
  });  
  $("#deleteDetalle").click(function(){										
    window.frames[0].deleteDetalles();
  });  						   
						   
  $("#guardar,#actualizar").click(function(){
	  
	  var formulario = document.getElementById('ParametrosExogenaForm');
	  
	  if(ValidaRequeridos(formulario)){ 
	    if(this.id == 'guardar'){
         Send(formulario,'onclickSave',null,ParametrosExogenaOnSave)
		}else{
            Send(formulario,'onclickUpdate',null,ParametrosExogenaOnUpdate)
		  }
	  }	  	  
  });
});
	
