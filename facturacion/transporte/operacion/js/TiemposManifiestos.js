// JavaScript Document
$(document).ready(function(){
						   
  linkTiempos();  							 		  
  
		$("input[name=fecha_llegada_cargue],input[name=fecha_entrada_cargue],input[name=fecha_salida_cargue]" ).datepicker({
			dateFormat : "yy-mm-dd",
			    showOn: "button",
			    buttonImage: "../../../framework/media/images/calendar/calendar.gif",
			    buttonImageOnly: true,
			    changeMonth: true,
			    changeYear: true,
			    yearRange: '1900:2050'
		    }); 
  
});

function saveTiempos(obj){
	
	var row = obj.parentNode.parentNode;
	
	if(validaRequeridosDetalle(obj,row)){
	  
	  var Celda                       = obj.parentNode;
	  var Fila                        = Celda.parentNode;
	  var Tabla                       = Fila.parentNode;
      var tiempos_clientes_remesas_id = $(Fila).find("input[name=tiempos_clientes_remesas_id]").val();	  	
	  var fecha_llegada_cargue        = $(Fila).find("input[name=fecha_llegada_cargue]").val();
	  var hora_llegada_cargue         = $(Fila).find("input[name=hora_llegada_cargue]").val();
	  var fecha_entrada_cargue        = $(Fila).find("input[name=fecha_entrada_cargue]").val();
	  var hora_entrada_cargue         = $(Fila).find("input[name=hora_entrada_cargue]").val();
	  var fecha_salida_cargue         = $(Fila).find("input[name=fecha_salida_cargue]").val();
	  var hora_salida_cargue          = $(Fila).find("input[name=hora_salida_cargue]").val();
	
	    	      
	      var QueryString = "ACTIONCONTROLER=onclickUpdate&tiempos_clientes_remesas_id="+tiempos_clientes_remesas_id+"&fecha_llegada_cargue="+fecha_llegada_cargue+"&hora_llegada_cargue="+hora_llegada_cargue+"&fecha_entrada_cargue="+fecha_entrada_cargue+"&hora_entrada_cargue="+hora_entrada_cargue+"&fecha_salida_cargue="+fecha_salida_cargue+"&hora_salida_cargue="+hora_salida_cargue
	      
				      
	      $.ajax({
		      url        : "TiemposManifiestosClass.php",
		      data       : QueryString,
		      beforeSend : function(){
			setMessageWaiting();
		      },
		      success    : function(response){
		      
			      if($.trim(response) == 'true'){
				
				      $(Celda).removeClass("focusSaveRow");				      
				      linkTiempos();
				      setMessage('Se guardo exitosamente.');
		      
			      }else{
				      alert(response);
			      }
			      
			      
		      }
		      
	      });
	      
	     
  }//fin de validaRequeridosDetalle	
  
}


function saveDetallesSoliServi(){
	
	$("input[name=procesar]:checked").each(function(){
	
		saveTiempos(this);
	
	});

}
   
/***************************************************************
  Funciones para el objeto de guardado en los edtalles de ruta
***************************************************************/
function linkTiempos(){

	$("a[name=saveTiempos]").attr("href","javascript:void(0)");
	
	$("a[name=saveTiempos]").focus(function(){
		var celda = this.parentNode;
		$(celda).addClass("focusSaveRow");
    });
	
	$("a[name=saveTiempos]").blur(function(){
		var celda = this.parentNode;
		$(celda).removeClass("focusSaveRow");
    });
	
	$("a[name=saveTiempos]").click(function(){
		saveTiempos(this);
    });
	
}