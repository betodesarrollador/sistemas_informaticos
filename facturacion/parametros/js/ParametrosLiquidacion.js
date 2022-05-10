// JavaScript Document

$(document).ready(function(){

 autocompleteCodigoContable(); 

});

function setDataFormWithResponse(parametros_liquidacion_id){
	
	var forma 		= document.forms[0];	
	var QueryString = "ACTIONCONTROLER=onclickFind&parametros_liquidacion_id="+parametros_liquidacion_id;
	
	$.ajax({
	  url        : "ParametrosLiquidacionClass.php?rand="+Math.random(),
	  data       : QueryString,
	  beforeSend : function(){
		  showDivLoading();
	  },
	  success    : function(resp){
		  		  
		 var data        = $.parseJSON(resp);
		 var empresa_id  = data[0]['empresa_id'];
		 var oficina_id  = data[0]['oficina_id'];
		  
	     setOficinasCliente(empresa_id,oficina_id);				  
         setFormWithJSON(forma,resp);
		 removeDivLoading(); 
		 
	    if($('#guardar'))    $('#guardar').attr("disabled","true");
        if($('#actualizar')) $('#actualizar').attr("disabled","");
        if($('#borrar'))     $('#borrar').attr("disabled","");
        if($('#limpiar'))    $('#limpiar').attr("disabled","");
		  
      }
	  
    });

}

function parametrosLiquidacionOnSaveOnUpdateonDelete(formulario,resp){

   $("#refresh_QUERYGRID_parametros_legalizacion").click();
   parametrosLiquidacionOnReset(formulario);
   
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
	
   alertJquery(resp,"parametros Legalizacion");
   
}
function showTable(){ 
  
	var frame_grid =  document.getElementById('frame_grid');
	
	  //Se valida que el iFrame no exista
	  if(frame_grid == null ){
  
	  var QueryString   = 'ACTIONCONTROLER=showGrid';
  
	  $.ajax({
		url        : "ParametrosLiquidacionClass.php?rand="+Math.random(),
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

function parametrosLiquidacionOnReset(formulario){
	
	Reset(formulario);
    clearFind();	
    setFocusFirstFieldForm(formulario);			
	autocompleteCodigoContable();	
	$("#refresh_QUERYGRID_parametros_liquidacion").click();
		
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");	
}

function autocompleteCodigoContable(){
	
  $("input[name=puc]").keypress(function(event){

      ajax_suggest(this,event,"cuentas_movimiento","null",setNombreCuenta,null,document.forms[0]);  
  
  });
  	
}


function setOficinasCliente(empresa_id,oficina_id){
	
	var QueryString = "ACTIONCONTROLER=setOficinasCliente&empresa_id="+empresa_id+"&oficina_id="+oficina_id;
	
	$.ajax({
		url     : "ParametrosLiquidacionClass.php?rand="+Math.random(),
		data    : QueryString,
		success : function(response){
			$("#oficina_id").parent().html(response);
		}
	});
}