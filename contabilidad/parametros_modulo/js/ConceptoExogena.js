// JavaScript Document
$(document).ready(function(){
						   
  setTipoConceptoExogena();
  $("#tipo").trigger("change");
						   
});
function setTipoConceptoExogena(){
	
  $("#tipo").change(function(){
							 
      if(this.value == 'V'){
		 $("#labelVehiculo,#placa_id").css("display",""); 
		 $("#labelOficina,#oficina_id").css("display","none"); 		 
	  }else if(this.value == 'O'){
		  $("#labelVehiculo,#placa_id").css("display","none"); 
		  $("#labelOficina,#oficina_id").css("display",""); 		 		  
		}else{
            $("#labelVehiculo,#labelOficina,#placa_id,#oficina_id").css("display","none");	
          }							 
							 
  });	
	
}

function showTable(){
  
  var frame_grid =  document.getElementById('frame_grid');
  
    //Se valida que el iFrame no exista
    if(frame_grid == null ){

    var QueryString   = 'ACTIONCONTROLER=showGrid';

    $.ajax({
      url        : "ConceptoExogenaClass.php?rand="+Math.random(),
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

function LlenarFormConceptoExogena(){
	
	RequiredRemove();
	
	var params     = new Array({campos:"concepto_exogena_id",valores:$('#concepto_exogena_id').val()});
	var formulario = document.forms[0];
	var url        = 'ConceptoExogenaClass.php';
	
	FindRow(params,formulario,url,null,function(){
	
	  if($('#guardar'))    $('#guardar').attr("disabled","true");
	  if($('#actualizar')) $('#actualizar').attr("disabled","");
	  if($('#borrar'))     $('#borrar').attr("disabled","");
	  if($('#limpiar'))    $('#limpiar').attr("disabled","");
		
	  $("#tipo").trigger("change");											
												
	});
}
function ConceptoExogenaOnSaveOnUpdateonDelete(formulario,resp){
   Reset(formulario);
   clearFind();
   setFocusFirstFieldForm(formulario);   
   $("#refresh_QUERYGRID_concepto_exogena_id").click();
   
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
	
   alertJquery(resp,"Concepto Exogena");
   
}
function ConceptoExogenaOnReset(formulario){
	
	Reset(formulario);
    clearFind();	
    setFocusFirstFieldForm(formulario);	
	
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");	
    $('#estado').val('A');
}