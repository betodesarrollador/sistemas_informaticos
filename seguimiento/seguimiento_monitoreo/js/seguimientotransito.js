// JavaScript Document

function getSeguimientoSelected(s){
	
	alert(s);
	
}

/*************************************************************************
 otra manera de obtener las filas marcadas con los checkbox del jqGrid
*************************************************************************/

$(document).ready(function(){

  $("#getSeguimientosMarcados").click( function() { 
    var s; 
	
	s = jQuery("#QUERYGRID_Seguimiento").jqGrid('getGridParam','selarrrow'); 

	alert(s); 
		
  });
  
});