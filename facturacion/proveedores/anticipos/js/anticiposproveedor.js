$(document).ready(function(){
 
 $("#frameRegistroContable").attr("height","250px");
 
 if(document.getElementById('imprimir'))document.getElementById('imprimir').disabled = true; 
 document.getElementById('frameAnticiposProveedor').src        = "about:blank"; 
 document.getElementById('frameDevolucionesPlaca').src        = "about:blank";  
 document.getElementById('frameRegistroContable').src = "about:blank";  

 
  $("#tipo_anticipo").change(function(){
							
	 document.getElementById('frameAnticiposProveedor').src        = "about:blank"; 
	 document.getElementById('frameDevolucionesPlaca').src        = "about:blank";  
	 document.getElementById('frameRegistroContable').src = "about:blank"; 							
     $("#conductor,#conductor_id,#tenedor,#tenedor_id,#proveedor_id").val("");		 	   	 
							
									 
  });
  
	 document.getElementById('frameAnticiposProveedor').src        = "about:blank"; 
	 document.getElementById('frameDevolucionesPlaca').src        = "about:blank";  
	 document.getElementById('frameRegistroContable').src = "about:blank"; 							  
						   
});

function setDataProveedor(proveedor_id){



	var QueryString = "ACTIONCONTROLER=setDataProveedor&proveedor_id="+proveedor_id;

	$.ajax({

    	url        : "AnticiposProveedorClass.php?rand="+Math.random(),

    	data       : QueryString,

    	beforeSend : function(){

    	},

    	success    : function(response){

      

			try{

		

				var responseArray         = $.parseJSON(response); 

				var proveedor_nit         = responseArray[0]['proveedor_nit'];

				$("#proveedor_nit").val(proveedor_nit);
				
				getAnticiposProveedor(proveedor_id);
				

			}catch(e){

				//alertJquery(e);

			}

    	}

  	});

}



function recargar_anticipos(proveedor_id){
	if(!isNaN(proveedor_id)){
	 document.getElementById('frameAnticiposProveedor').src = "DetalleAnticiposProveedorClass.php?proveedor_id="+proveedor_id; 
	 document.getElementById('frameDevolucionesPlaca').src = "DetalleDevolucionProveedorClass.php?proveedor_id="+proveedor_id; 
	}
}
function getAnticiposProveedor(proveedor_id){
	      
   if(!isNaN(proveedor_id)){
      
	   /*var QueryString = "ACTIONCONTROLER=validaAnticiposProveedor&proveedor_id="+proveedor_id;								
	   
	   $.ajax({
		 url        : "AnticiposProveedorClass.php?rand="+Math.random(),
		 data       : QueryString,
		 beforeSend : function(){
			 showDivLoading();
		 },
		 success     : function(resp){
			 
			 removeDivLoading();
			 
			 if($.trim(resp) == 'true'){*/			 
				document.getElementById('frameAnticiposProveedor').src = "DetalleAnticiposProveedorClass.php?proveedor_id="+proveedor_id; 
				document.getElementById('frameDevolucionesPlaca').src = "DetalleDevolucionProveedorClass.php?proveedor_id="+proveedor_id; 
				document.getElementById('frameRegistroContable').src = "about:blank"; 
				if(document.getElementById('imprimir'))document.getElementById('imprimir').disabled = true;
				setDataVehiculo(proveedor_id);
			 /*}else{
				 alertJquery(resp,"Validacion");
			  }
			 
		 }
		 
	   });*/
   
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


function AnticiposProveedorOnReset(formulario){
	
	Reset(formulario);
	if(document.getElementById('imprimir'))document.getElementById('imprimir').disabled = true; 
	document.getElementById('frameAnticiposProveedor').src        = "about:blank"; 
	document.getElementById('frameDevolucionesPlaca').src        = "about:blank"; 
	document.getElementById('frameRegistroContable').src = "about:blank"; 		
	
}