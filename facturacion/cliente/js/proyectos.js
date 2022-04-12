$(document).ready(function(){
						   
    checkedAll();
	checkRow();
    //autocompleteCiudad();
    linkImputaciones();
	
	
});

function checkedAll(){
	
   $("#checkedAll").click(function(){
								   
							   								   
      if($(this).is(":checked")){
		$("input[name=procesar]").attr("checked","true");
      }else{
  		  $("input[name=procesar]").attr("checked","");
		}
								   
   });

}
    

function linkImputaciones(){

	$("a[name=saveProyectos]").attr("href","javascript:void(0)");
	
	$("a[name=saveProyectos]").focus(function(){
      var celda = this.parentNode;
      $(celda).addClass("focusSaveRow");	  
    });
	
	$("a[name=saveProyectos]").blur(function(){
      var celda = this.parentNode;
      $(celda).removeClass("focusSaveRow");	  
    });	
	
	$("a[name=saveProyectos]").click(function(){
														
       saveDetalle(this);

    });	
	
}


	
function saveDetalle(obj){
	
	var row = obj.parentNode.parentNode;
	
    if(validaRequeridosDetalle(obj,row)){
				
    var Celda                  		= obj.parentNode;
    var Fila                   		= obj.parentNode.parentNode;	
    var cliente_proyecto_id			= $(Fila).find("input[name=cliente_proyecto_id]").val();	
	var tercero_id 					= $("#tercero_id").val();
	var nombre_proyecto   			= $(Fila).find("input[name=nombre_proyecto]").val();	
	var codigo_proyecto  			= $(Fila).find("input[name=codigo_proyecto]").val();		
	var estado_proyecto   			= $(Fila).find("select[name=estado_proyecto]").val();
	var checkProcesar          		= $(Fila).find("input[name=procesar]");					
	var comercial_id 				= $(Fila).find("select[name=comercial_id]").val();	

				
	if(!cliente_proyecto_id.length > 0){
	
   	  cliente_proyecto_id    = 'NULL';
		  
	  var QueryString = "ACTIONCONTROLER=onclickSave&tercero_id="+tercero_id+"&cliente_proyecto_id="+
	  cliente_proyecto_id+"&nombre_proyecto="+nombre_proyecto+"&codigo_proyecto="+codigo_proyecto+"&estado_proyecto="+estado_proyecto+"&comercial_id="+comercial_id;	

	
	  $.ajax({
		   
	    url        : "ProyectosClass.php",
	    data       : QueryString,
	    beforeSend : function(){
	      showDivLoading();	
	    },
	    success    : function(response){
						
          if(!isNaN(response)){
			
            $(Fila).find("input[name=cliente_proyecto_id]").val(response);	

            var Table   = document.getElementById('tableDetalles1');
			var numRows = (Table.rows.length);
			var newRow  = Table.insertRow(numRows);

		    $(newRow).html($("#clon").html());
			$(newRow).find("input[name=nombre_proyecto]").focus();
			
						
   	        checkRow();
            //autocompleteCiudad();
            linkImputaciones();	

			checkProcesar.attr("checked","");			
			$(Celda).removeClass("focusSaveRow");		
   	        removeDivLoading();
			parent.document.getElementById("refresh_QUERYGRID_terceros").click();
			
		  }else{
			alertJquery(response);
		  }

	    }
		  
	  });
	  
	}else{

	var QueryString = "ACTIONCONTROLER=onclickSave&tercero_id="+tercero_id+"&cliente_proyecto_id="+
	  cliente_proyecto_id+"&nombre_proyecto="+nombre_proyecto+"&codigo_proyecto="+codigo_proyecto+"&estado_proyecto="+estado_proyecto+"&comercial_id="+comercial_id;	

	  		
	  $.ajax({
		   
	    url        : "ProyectosClass.php",
	    data       : QueryString,
	    beforeSend : function(){
	      showDivLoading();					
	    },
	    success    : function(response){
			
          if( $.trim(response) == 'true'){
			checkProcesar.attr("checked","");					
			$(Fila).find("a[name=saveProyectos]").parent().addClass("focusSaveRow");
			parent.document.getElementById("refresh_QUERYGRID_terceros").click();
		  }else{
			alertJquery(response);
		    }
			
 	     removeDivLoading();
	    }
		  
	  });


	 }
	 
	}else{
		alertJquery("Debe Ingresar los Campos Requeridos","Clientes");
	}
	 
 		
}

function deleteDetalle(obj){

    var Celda                   	= obj.parentNode;
    var Fila                    	= obj.parentNode.parentNode;
    var cliente_proyecto_id			= $(Fila).find("input[name=cliente_proyecto_id]").val();	
    var QueryString             	= "ACTIONCONTROLER=onclickDelete&cliente_proyecto_id="+cliente_proyecto_id;			
	
	if(cliente_proyecto_id.length > 0){
		
	  $.ajax({
		   
	    url        : "ProyectosClass.php",
	    data       : QueryString,
	    beforeSend : function(){
	      showDivLoading();	
	    },
	    success    : function(response){

          if( $.trim(response) == 'true'){
			
			var numRow = (Fila.rowIndex - 1);
			Fila.parentNode.deleteRow(numRow);
			
		  }else{
			alertJquery(response);
		   }

        removeDivLoading();
	    }
		  
      });
	  
	}else{
		alertJquery('No puede eliminar elementos que no han sido guardados');
        $(Fila).find("input[name=procesar]").attr("checked","");				
	  }
	
}

function saveDetalles(){

  $("input[name=procesar]:checked").each(function(){
 
     saveDetalle(this);

  });

}

function deleteDetalles(){
	
  $("input[name=procesar]:checked").each(function(){
 
     deleteDetalle(this);

  });

}	


function checkRow(){
	
	$("input[type=text]").keyup(function(event){
										 
       var Tecla = event.keyCode;
	   var Fila  = this.parentNode.parentNode;
	   
       $(Fila).find("input[name=procesar]").attr("checked","true");
	   
    });
	
}

