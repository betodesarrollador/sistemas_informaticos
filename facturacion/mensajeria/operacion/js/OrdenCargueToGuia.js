// JavaScript Document
var detalle_ss_id;

$(document).ready(function(){
	
	$("#guiar").click(function(){
		setOrdenCargue();		
	});  
});

function checkRow(obj){  
  var numChecks = 0;	
  $(document).find("input[type=checkbox]:checked").each(function(){
    numChecks += 1;
  });
	
  var numMaxGuia = 1;
  
  if(numChecks > numMaxGuia){
   alertJquery('Solo puede Seleccionar un Maximo de <span style="color:#red">'+numMaxGuia+'</span> productos por guia !!!','Validacion OrdenCargue Servicio Guia')
   obj.checked = false;
  }  
}

function setOrdenCargue(){  
    var numDetalles     = 0;
	var orden_cargue_id = '';
    $(document).find("input[type=checkbox]:checked").each(function(){ 
      orden_cargue_id = this.value;																   
      numDetalles++; 
	});
	        
    if(numDetalles > 0){       
	var QueryString = "ACTIONCONTROLER=setOrdenCargue&orden_cargue_id="+orden_cargue_id;
	
	$.ajax({
	  
	  url     : "OrdenCargueToGuiaClass.php?rand="+Math.random(),
	  data    : QueryString,
	  success : function(resp){
		  	        
	    try{
		  var response = $.parseJSON(resp);
		  
		  if(response[0]['orden_cargue'].length > 0){
		    
		    parent.cargaDatosOrden(response);
		    
		  }else{
		    alertJquery("Esta OrdenCargue no tiene productos asignados aun!!!","OrdenCargue");
		  }		  		  

	    }catch(e){
	       alertJquery(resp,"Error : "+e); 
	     }		  
	   }	  
	});
    
    }else{      
      if(numDetalles == 0){
	alertJquery("Debe seleccionar al menos un producto !!!","Validacion Productos OrdenCargue");
      }      
    }    
}

function loadform(resp){
	
	parent.OrdenCargueId                                     = resp[0]['OrdenCargue_id'];
	parent.document.forms[0]['detalle_ss_id'].value        = detalle_ss_id;
	parent.document.forms[0]['OrdenCargue'].value            = resp[0]['OrdenCargue_id']+"."+resp[0]['detalle_ss'];
	
}