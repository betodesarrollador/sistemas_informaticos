// JavaScript Document
function updateGrid(){
  $("#refresh_QUERYGRID_Reportes").click();
}

function generar(cliente_id,fecha_reg,desde,hasta){
	
		var QueryString = "ACTIONCONTROLER=onclickCrear&cliente_id="+cliente_id+"&fecha_reg="+fecha_reg+"&desde="+desde+"&hasta="+hasta;
		
		$.ajax({
		url     : "ReportesClass.php",
		data    : QueryString,
		success : function(resp){
			alertJquery(resp);
		}
		
	   });
	
}


function enviar(cliente_id,fecha_reg,desde,hasta){
	
		var QueryString = "ACTIONCONTROLER=onclickEnviar&cliente_id="+cliente_id+"&fecha_reg="+fecha_reg+"&desde="+desde+"&hasta="+hasta;
		
		$.ajax({
		url     : "ReportesClass.php",
		data    : QueryString,
		success : function(resp){
			alertJquery(resp);
		}
		
	   });
	
}

function descargar_file(url){
	window.open(url,'','toolbar=no,directories=no,menub ar=no,status=no,resizable=yes,scrollbars=yes,width=50,height=50,top=15,left=15');	
}


