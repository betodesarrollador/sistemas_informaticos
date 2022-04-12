// JavaScript Document
var detalle_ss_id;

$(document).ready(function(){
	
	$("#remesar").click(function(){
		setSolicitud();
		
	});
  
});

function checkRow(obj){
  
  var numChecks = 0;
	
  $(document).find("input[type=checkbox]:checked").each(function(){
    numChecks += 1;
  });
	
  var numMaxRemesas = 1;
  
  if(numChecks > numMaxRemesas){
   alertJquery('Solo puede Seleccionar un Maximo de <span style="color:#red">'+numMaxRemesas+'</span> productos por remesa !!!','Validacion Solicitud Servicio Remesa')
   obj.checked = false;
  }
  
  
}

function setSolicitud(){
  
    var numDetalles        = 0;
    var solicitud_id       = '';
    var solicitud_id_tmp   = '';
    var validaSolicitud    = true; 
    var detalles_ss_id     = '';
	var orden_despacho     = '';
	var orden_despacho_tmp = '';

    $(document).find("input[type=checkbox]:checked").each(function(){
                 
      if(orden_despacho == '' && orden_despacho_tmp == ''){
	
        orden_despacho   = parseInt($(this.parentNode.parentNode).find("td[aria-describedby=QUERYGRID_SolicServToRemesaPaqueteo_orden_despacho]").text());      		
	
	    orden_despacho_tmp = orden_despacho;
		
      }else{
	
         orden_despacho_tmp = parseInt($(this.parentNode.parentNode).find("td[aria-describedby=QUERYGRID_SolicServToRemesaPaqueteo_orden_despacho]").text());      	
	
	
	     if(parseInt(orden_despacho_tmp) != parseInt(orden_despacho)){
	  
	        alertJquery("Usted Selecciono uno o mas productos correspondientes a ordenes distintas !!","Validacion Solicitud Servicio");	

	        validaSolicitud = false;
	  
        }else{
	  
	           orden_despacho = orden_despacho_tmp;
	 
         }
       
      }
	            
    
    });	
	
	if(!validaSolicitud) return false;

    $(document).find("input[type=checkbox]:checked").each(function(){
                 
      if(solicitud_id == '' && solicitud_id_tmp == ''){
	
        solicitud_id     = parseInt($(this.parentNode.parentNode).find("td[aria-describedby=QUERYGRID_SolicServToRemesa_solicitud]").text());      		
	
	    solicitud_id_tmp = solicitud_id;
	
	    detalles_ss_id += this.value+',';
	
      }else{
	
         solicitud_id_tmp = parseInt($(this.parentNode.parentNode).find("td[aria-describedby=QUERYGRID_SolicServToRemesa_solicitud]").text());      	
	
	
	if(parseInt(solicitud_id_tmp) != parseInt(solicitud_id)){
	  
	  alertJquery("Usted Selecciono uno o mas productos correspondientes a solicitudes distintas !!","Validacion Solicitud Servicio");	

	  validaSolicitud = false;
	  
        }else{
	  
	   solicitud_id = solicitud_id_tmp;
	   detalles_ss_id += this.value+',';
	 
         }
       
      }
	
    numDetalles++;
            
    });
        
    if(validaSolicitud && numDetalles > 0){
       
    detalles_ss_id = detalles_ss_id.substring(0,(detalles_ss_id.length - 1));
	    	    
	var QueryString = "ACTIONCONTROLER=setSolicitud&detalles_ss_id="+detalles_ss_id+"&solicitud_id="+solicitud_id;
	
	$.ajax({
	  
	  url     : "SolicServToRemesaClass.php?rand="+Math.random(),
	  data    : QueryString,
	  success : function(resp){
		  	        
	    try{
		  var response = $.parseJSON(resp);
		  
		  if(response[0]['detalle_solicitud'].length > 0){
		    
		    parent.cargaDatos(response);
		    
		  }else{
		    alertJquery("Esta solicitud no tiene productos asignados aun!!!","Solicitud");
		  }
		  		  

	    }catch(e){
	       alertJquery(resp,"Error : "+e); 
	     }
		  
	  }
	  
	});
    
    }else{
      
      if(numDetalles == 0){
	alertJquery("Debe seleccionar al menos un producto !!!","Validacion Productos Solicitud");
      }
      
     }
    
}

function loadform(resp){
	
	parent.SolicitudId                                     = resp[0]['solicitud_id'];
	parent.document.forms[0]['detalle_ss_id'].value        = detalle_ss_id;
	parent.document.forms[0]['solicitud'].value            = resp[0]['solicitud_id']+"."+resp[0]['detalle_ss'];
	
}