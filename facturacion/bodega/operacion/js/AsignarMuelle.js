// JavaScript Document
function updateGrid(){
  $("#refresh_QUERYGRID_AsignarMuelle").click();
}

$(document).ready(function(){

  $("#divAnulacion").css("display", "none");	
  
  if(intervalo){
      clearInterval(intervalo);
       var intervalo = window.setInterval(function(){updateGrid()},120000);
  }else{
       var intervalo = window.setInterval(function(){updateGrid()},120000);
	}
	
	$("#generar_excel").click(function(){
	
	 var formulario = this.form;

	var QueryString = "AsignarMuelleClass.php?ACTIONCONTROLER=generateFileexcel&rand="+Math.random();
						 
	   document.location.href = QueryString;						 
	
								
	});	
	
});

function viewDoc(enturnamiento_id) {
  if ($("#divAnulacion").is(":visible")) {
    
    $('#enturnamiento_id').val(enturnamiento_id);
    $("#divAnulacion").dialog('close');
  }else{
    $('#enturnamiento_id').val(enturnamiento_id);
    $("#divAnulacion").dialog({
      title: 'Asignar Muelle',
      width: 450,
      height: 280,
      closeOnEscape: true
    });
  }
}

function AsignarMuelleOnSaveOnUpdateonDelete(formulario, resp) {

  Reset(formulario);
  clearFind();
  $("#refresh_QUERYGRID_AsignarMuelle").click();

  if ($('#guardar')) $('#guardar').attr("disabled", "");


  alertJquery(resp, "Asignar Muelle");
  $("#divAnulacion").dialog('close');

}


function reloadGrid(){
  $("#refresh_QUERYGRID_AsignarMuelle").click();
	
}