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
  
 
  
}

function setSolicitud(){
  
    var numDetalles        = 0;
    var solicitud_id       = '';
    var solicitud_id_tmp   = '';
    var validaSolicitud    = true; 
    var detalles_ss_id     = '';
	var proveedor     = '';
	var proveedor_tmp = '';

    
	if(!validaSolicitud) return false;

    $(document).find("input[type=checkbox]:checked").each(function(){
                 
      if(solicitud_id == '' && solicitud_id_tmp == ''){
	
        solicitud_id     = parseInt($(this.parentNode.parentNode).find("td[aria-describedby=QUERYGRID_SolicServToOrden_orden_compra]").text());      		
	
	    solicitud_id_tmp = solicitud_id;
	
	    detalles_ss_id += this.value+',';
	
      }else{
	
         solicitud_id_tmp = parseInt($(this.parentNode.parentNode).find("td[aria-describedby=QUERYGRID_SolicServToOrden_orden_compra]").text());      	
	
	
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
       console.log('detalles_id='+detalles_ss_id);
    detalles_ss_id = detalles_ss_id.substring(0,(detalles_ss_id.length - 1));
	    	    
	var QueryString = "ACTIONCONTROLER=setSolicitud&detalles_ss_id="+detalles_ss_id+"&solicitud_id="+solicitud_id;
	
	$.ajax({
	  
	  url     : "SolicServToOrdenClass.php?rand="+Math.random(),
	  data    : QueryString,
	  success : function(resp){
		  	        
	    try{
		  var response = $.parseJSON(resp);
		  
		  if(response[0]['solicitud'][0]['item_pre_orden_id'].length > 0){
		    
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