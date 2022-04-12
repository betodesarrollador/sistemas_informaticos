$(document).ready(function(){
 
 $("#frameRegistroContable").attr("height","250px");
 
 if(document.getElementById('imprimir'))document.getElementById('imprimir').disabled = true; 
 document.getElementById('frameAnticipos').src        = "about:blank"; 
 document.getElementById('frameDevoluciones').src        = "about:blank";
 document.getElementById('frameRegistroContable').src = "about:blank";  

 $("#divDespacho").css("display","none");
 
  $("#tipo_anticipo").change(function(){
							
	 document.getElementById('frameAnticipos').src        = "about:blank"; 
	 document.getElementById('frameDevoluciones').src        = "about:blank";
	 document.getElementById('frameRegistroContable').src = "about:blank"; 							
     $("#manifiesto,#despacho,#manifiesto_id,#despachos_urbanos_id").val("");		 	   	 
							
     if(this.value == 'M'){
       $("#divManifiesto").css("display","");		 
       $("#divDespacho").css("display","none");		 
	 }else{
         $("#divManifiesto").css("display","none");		 
         $("#divDespacho").css("display","");	
	  }									 
									 
  });
  
	 document.getElementById('frameAnticipos').src        = "about:blank"; 
	 document.getElementById('frameDevoluciones').src     = "about:blank";	 
	 document.getElementById('frameRegistroContable').src = "about:blank"; 	
	 
	var manifiesto_id = $('#manifiesto_id_hidden').val();
	if (manifiesto_id != '') getAnticiposManifiesto(manifiesto_id);
						   
});

function getAnticiposManifiesto(manifiesto_id){
	      
   if(!isNaN(manifiesto_id)){
      
	   var QueryString = "ACTIONCONTROLER=validaAnticiposManifiesto&manifiesto_id="+manifiesto_id;								
	   
	   $.ajax({
		 url        : "AnticiposClass.php?rand="+Math.random(),
		 data       : QueryString,
		 beforeSend : function(){
			 showDivLoading();
		 },
		 success     : function(resp){
			 
			 removeDivLoading();
			 
			 if($.trim(resp) == 'true'){			 
				document.getElementById('frameAnticipos').src = "DetalleAnticiposClass.php?manifiesto_id="+manifiesto_id; 
				document.getElementById('frameDevoluciones').src = "DetalleDevolucionessClass.php?manifiesto_id="+manifiesto_id; 
				document.getElementById('frameRegistroContable').src = "about:blank"; 
				if(document.getElementById('imprimir'))document.getElementById('imprimir').disabled = true; 
			 }else{
				 alertJquery(resp,"Validacion");
			  }
			 
		 }
		 
	   });
   
   }
								
 
}
 
function getAnticiposDespacho(despachos_urbanos_id){ 
 
      
   if(!isNaN(despachos_urbanos_id)){
      
	   var QueryString = "ACTIONCONTROLER=validaAnticiposDespacho&despachos_urbanos_id="+despachos_urbanos_id;								
	   
	   $.ajax({
		 url        : "AnticiposClass.php?rand="+Math.random(),
		 data       : QueryString,
		 beforeSend : function(){
			 showDivLoading();
		 },
		 success     : function(resp){
			 
			 removeDivLoading();
			 
			 if($.trim(resp) == 'true'){
			 		 
				document.getElementById('frameAnticipos').src = "DetalleAnticiposClass.php?despachos_urbanos_id="+despachos_urbanos_id; 
				document.getElementById('frameDevoluciones').src = "DetalleDevolucionessClass.php?despachos_urbanos_id="+despachos_urbanos_id; 	
				document.getElementById('frameRegistroContable').src = "about:blank"; 
				if(document.getElementById('imprimir'))document.getElementById('imprimir').disabled = true; 
			 }else{
				 alertJquery(resp,"Validacion");
			  }
			 
		 }
		 
	   });
   
   }								
	
	
}

function beforePrint(formulario,url,title,width,height){

   var encabezado_registro_id = $("#encabezado_registro_id").val() * 1;
   
   if(encabezado_registro_id > 0){
	 return true;
   }else{
	   alertJquery("No se ha generado un registro contable para imprimir!!");
	   return false;
	}

}


function AnticiposOnReset(formulario){
	
	Reset(formulario);
	if(document.getElementById('imprimir'))document.getElementById('imprimir').disabled = true; 
	document.getElementById('frameAnticipos').src        = "about:blank"; 
	document.getElementById('frameDevoluciones').src        = "about:blank"; 
	document.getElementById('frameRegistroContable').src = "about:blank"; 		
	
}