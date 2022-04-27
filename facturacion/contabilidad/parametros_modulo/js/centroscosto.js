// JavaScript Document
$(document).ready(function(){
						   
  setTipoCentroCosto();
  $("#tipo").trigger("change");
						   
});
function setTipoCentroCosto(){
	
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
      url        : "CentrosCostoClass.php?rand="+Math.random(),
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

function LlenarFormCentroCosto(){
	
	RequiredRemove();
	
	var params     = new Array({campos:"centro_costo_id",valores:$('#centro_de_costo_id').val()});
	var formulario = document.forms[0];
	var url        = 'CentrosCostoClass.php';
	
	FindRow(params,formulario,url,null,function(){
	
	  if($('#guardar'))    $('#guardar').attr("disabled","true");
	  if($('#actualizar')) $('#actualizar').attr("disabled","");
	  if($('#borrar'))     $('#borrar').attr("disabled","");
	  if($('#limpiar'))    $('#limpiar').attr("disabled","");
		
	  $("#tipo").trigger("change");											
												
	});
}
function CentroCostoOnSaveOnUpdateonDelete(formulario,resp){
   Reset(formulario);
   clearFind();
   setFocusFirstFieldForm(formulario);   
   $("#refresh_QUERYGRID_centro_costo").click();
   
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
	
   alertJquery(resp,"Centros Costo");
   
}
function CentroCostoOnReset(formulario){
	
	Reset(formulario);
    clearFind();	
    setFocusFirstFieldForm(formulario);	
	
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");	
}