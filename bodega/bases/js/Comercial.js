//// JavaScript Document


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

	$("a[name=saveComerciales]").attr("href","javascript:void(0)");
	
	$("a[name=saveComerciales]").focus(function(){
      var celda = this.parentNode;
      $(celda).addClass("focusSaveRow");	  
    });
	
	$("a[name=saveComerciales]").blur(function(){
      var celda = this.parentNode;
      $(celda).removeClass("focusSaveRow");	  
    });	
	
	$("a[name=saveComerciales]").click(function(){
		console.log("entra");										
       saveDetalle(this);

    });	
	
}


	
function saveDetalle(obj){
	
	var row = obj.parentNode.parentNode;
	
    if(validaRequeridosDetalle(obj,row)){
				
    var Celda                  		= obj.parentNode;
    var Fila                   		= obj.parentNode.parentNode;	
    var comercial_id				= $(Fila).find("select[name=comercial_id]").val();	
	var tercero_id 					= $("#tercero_id").val();
	var oficina_id   				= $(Fila).find("select[name=agencia_id]").val();	
	var tipo_recaudo  				= $(Fila).find("select[name=tipo_comision]").val();		
	var comerciales_cliente_id		= $(Fila).find("input[name=comerciales_cliente_id]").val();	
	var checkProcesar          		= $(Fila).find("input[name=procesar]");					
	

				
	if(!comerciales_cliente_id.length > 0){
	
   	  comerciales_cliente_id    = 'NULL';
		  
	  var QueryString = "ACTIONCONTROLER=onclickSave&tercero_id="+tercero_id+"&comercial_id="+comercial_id+"&oficina_id="+oficina_id+"&tipo_recaudo="+tipo_recaudo;	

	
	  $.ajax({
		   
	    url        : "ComercialClass.php",
	    data       : QueryString,
	    beforeSend : function(){
	      showDivLoading();	
	    },
	    success    : function(response){
						
          if(!isNaN(response)){
			
            $(Fila).find("input[name=comerciales_cliente_id]").val(response);	

            var Table   = document.getElementById('tableDetalles');
			var numRows = (Table.rows.length);
			var newRow  = Table.insertRow(numRows);

		    $(newRow).html($("#clon").html());
			
			
						
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

	  var QueryString = "ACTIONCONTROLER=onclickUpdate&tercero_id="+tercero_id+"&comercial_id="+comercial_id+"&oficina_id="+oficina_id+"&tipo_recaudo="+tipo_recaudo;	
	  $.ajax({
		   
	    url        : "ComercialClass.php",
	    data       : QueryString,
	    beforeSend : function(){
	      showDivLoading();					
	    },
	    success    : function(response){
			
          if( $.trim(response) == 'true'){
			checkProcesar.attr("checked","");					
			$(Fila).find("a[name=saveComerciales]").parent().addClass("focusSaveRow");
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
    var comerciales_cliente_id		= $(Fila).find("input[name=comerciales_cliente_id]").val();	
    var QueryString             	= "ACTIONCONTROLER=onclickDelete&comerciales_cliente_id="+comerciales_cliente_id;			
	
	if(comerciales_cliente_id.length > 0){
		
	  $.ajax({
		   
	    url        : "ComercialClass.php",
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
