// JavaScript Document

$(document).ready(function(){
						   
    checkedAll();
	checkRow();
    autocompleteCiudad();
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
    
/***************************************************************
	  lista inteligente para la ubicacion con jquery
**************************************************************/

function autocompleteCiudad(){
	
	
	$("input[name=ciudad]").autocomplete("/roa/framework/clases/ListaInteligente.php?consulta=ciudad", {
		width: 260,
		selectFirst: true,
		minChars: 2,
		scrollHeight: 220
	});
	
	$("input[name=ciudad]").result(function(event, data, formatted) {				   
										 										 
		if (data){
			
			var codigo_puc = data[0].split("-");
			
			$(this).val($.trim(codigo_puc[0]));
			$(this).next().val(data[1]);
		}
		
	});
	
}

function linkImputaciones(){

	$("a[name=saveOperativas]").attr("href","javascript:void(0)");
	
	$("a[name=saveOperativas]").focus(function(){
      var celda = this.parentNode;
      $(celda).addClass("focusSaveRow");	  
    });
	
	$("a[name=saveOperativas]").blur(function(){
      var celda = this.parentNode;
      $(celda).removeClass("focusSaveRow");	  
    });	
	
	$("a[name=saveOperativas]").click(function(){
														
       saveDetalle(this);

    });	
	
}


	
function saveDetalle(obj){
	
	var row = obj.parentNode.parentNode;
	
    if(validaRequeridosDetalle(obj,row)){
				
    var Celda                  		= obj.parentNode;
    var Fila                   		= obj.parentNode.parentNode;	
    var cliente_factura_operativa_id= $(Fila).find("input[name=cliente_factura_operativa_id]").val();	
	var tercero_id 					= $("#tercero_id").val();
	var nombre_cliente_operativa   	= $(Fila).find("input[name=nombre_cliente_operativa]").val();	
	var telefono_cliente_operativa  = $(Fila).find("input[name=telefono_cliente_operativa]").val();		
	var cargo_cliente_operativa   	= $(Fila).find("input[name=cargo_cliente_operativa]").val();			
	var direccion_cliente_operativa	= $(Fila).find("input[name=direccion_cliente_operativa]").val();
	var correo_cliente_factura_operativa	= $(Fila).find("input[name=correo_cliente_factura_operativa]").val();
	var ubicacion_id    			= $(Fila).find("input[name=ubicacion_id]").val();		
	var checkProcesar          		= $(Fila).find("input[name=procesar]");					
	

				
	if(!cliente_factura_operativa_id.length > 0){
	
   	  cliente_factura_operativa_id    = 'NULL';
		  
	  var QueryString = "ACTIONCONTROLER=onclickSave&tercero_id="+tercero_id+"&cliente_factura_operativa_id="+
	  cliente_factura_operativa_id+"&nombre_cliente_operativa="+nombre_cliente_operativa+"&telefono_cliente_operativa="+telefono_cliente_operativa+"&direccion_cliente_operativa="+direccion_cliente_operativa+"&ubicacion_id="+ubicacion_id+"&cargo_cliente_operativa="+cargo_cliente_operativa+"&correo_cliente_factura_operativa="+correo_cliente_factura_operativa;	

	
	  $.ajax({
		   
	    url        : "OperativaClass.php",
	    data       : QueryString,
	    beforeSend : function(){
	      showDivLoading();	
	    },
	    success    : function(response){
						
          if(!isNaN(response)){
			
            $(Fila).find("input[name=cliente_factura_operativa_id]").val(response);	

            var Table   = document.getElementById('tableDetalles');
			var numRows = (Table.rows.length);
			var newRow  = Table.insertRow(numRows);

		    $(newRow).html($("#clon").html());
			$(newRow).find("input[name=nombre_cliente_operativa]").focus();
			
						
   	        checkRow();
            autocompleteCiudad();
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

	  var QueryString = "ACTIONCONTROLER=onclickUpdate&tercero_id="+tercero_id+"&cliente_factura_operativa_id="+
	  cliente_factura_operativa_id+"&nombre_cliente_operativa="+nombre_cliente_operativa+"&telefono_cliente_operativa="+telefono_cliente_operativa+"&direccion_cliente_operativa="+direccion_cliente_operativa+"&ubicacion_id="+ubicacion_id+"&cargo_cliente_operativa="+cargo_cliente_operativa+"&correo_cliente_factura_operativa="+correo_cliente_factura_operativa;	
	  		
	  $.ajax({
		   
	    url        : "OperativaClass.php",
	    data       : QueryString,
	    beforeSend : function(){
	      showDivLoading();					
	    },
	    success    : function(response){
			
          if( $.trim(response) == 'true'){
			checkProcesar.attr("checked","");					
			$(Fila).find("a[name=saveOperativas]").parent().addClass("focusSaveRow");
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
    var cliente_factura_operativa_id= $(Fila).find("input[name=cliente_factura_operativa_id]").val();	
    var QueryString             	= "ACTIONCONTROLER=onclickDelete&cliente_factura_operativa_id="+cliente_factura_operativa_id;			
	
	if(cliente_factura_operativa_id.length > 0){
		
	  $.ajax({
		   
	    url        : "OperativaClass.php",
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


