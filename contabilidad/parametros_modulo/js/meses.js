// JavaScript Document
$(document).ready(function(){		
						   
  $("#mes_trece").change(function(){
	   if(this.value == '1'){
   	   		$("#fecha_inicio").removeClass("obligatorio");
			$("#fecha_final").removeClass("obligatorio");
   	   		$("#fecha_inicio").val("");
			$("#fecha_final").val("");
			
			$('#fecha_inicio').attr("disabled","true");
			$('#fecha_final').attr("disabled","true");
			 alertJquery("La configuraci&oacute;n de mes Trece no requiere fechas de inicio y final","Mes contable");
			
	   }else{
		   $("#fecha_inicio").addClass("obligatorio");
		   $("#fecha_final").addClass("obligatorio");
			$('#fecha_inicio').attr("disabled","");
			$('#fecha_final').attr("disabled","");
		   
	   }
   
  });  
  
  $("#fecha_inicio").change(function(){
		if($("#mes_trece").val() == '1'){									 
   	   		$("#fecha_inicio").val("");
		}
								  
  });  

  $("#fecha_final").change(function(){
		if($("#mes_trece").val() == '1'){									 
			$("#fecha_final").val("");
		}
								  
  });  

});

function showTable(){
  
  var frame_grid =  document.getElementById('frame_grid');
  
    //Se valida que el iFrame no exista
    if(frame_grid == null ){

    var QueryString   = 'ACTIONCONTROLER=showGrid';

    $.ajax({
      url        : "MesesClass.php?rand="+Math.random(),
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

function LlenarFormPeriodo(){
	
RequiredRemove();

var params     = new Array({campos:"mes_contable_id",valores:$('#mes_contable_id').val()});
var formulario = document.forms[0];
var url        = 'MesesClass.php';

FindRow(params,formulario,url,null,null);

if($('#guardar'))    $('#guardar').attr("disabled","true");
if($('#actualizar')) $('#actualizar').attr("disabled","");
if($('#borrar'))     $('#borrar').attr("disabled","");
if($('#limpiar'))    $('#limpiar').attr("disabled","");
}

function MesOnSaveOnUpdateonDelete(formulario,resp){

   Reset(formulario);
   clearFind();
   setFocusFirstFieldForm(formulario);   
   $("#refresh_QUERYGRID_mes_contable").click();
   
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
	
   alertJquery(resp,"Meses Contables");
   
}
function MesOnReset(formulario){
	
	$("#periodo_contable_id option").each(function(){
     if(this.value != 'NULL'){
	   $(this).remove();	 
     }
    });
	
	Reset(formulario);
    clearFind();
    setFocusFirstFieldForm(formulario);	
	
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");	
}

function viewPeriodo(periodo_contable_id) {
  
	window.open("../../parametros_modulo/clases/PeriodosClass.php?periodo_contable_id="+periodo_contable_id);

}