// JavaScript Document
$(document).ready(function(){	
							 					   
    checkedAll();
	
	checkRow();
	
	autocompletePuc();
	
	autocompleteFormato();
		
    autocompleteCategoria();
	
	autocompleteBaseCategoria();	
	
    autocompleteConcepto();	
	
	linkImputaciones();
	
	$("#generar").click(function () {
		var puc_id = $("#puc_id").val();
		Generar(puc_id);
	})
	
	$("input[type=text],textarea").keyup(function(){												

		this.value = this.value.toUpperCase();								   
		
		});
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
function autocompletePuc(){
	
	$("input[name=codigo_puc]").autocomplete("../../../framework/clases/ListaInteligente.php?consulta=cuentas_movimiento", {
		width: 355,
		selectFirst: true
	});
	
	$("input[name=codigo_puc]").result(function(event, data, formatted) {
		if (data) $(this).next().val(data[1]);
                $(this).parent().next().find("input").focus();
				$(this).css("boxShadow", "none");
				$(this).parent().next().find("input").css("boxShadow", "0 0 7px 2px green");
	});	
}

function validaSeleccionSolicitud(){
  
	 var formato_exogena_id = $("#formato_exogena_id").val();
	 var puc_id = $("#puc_id").val();
	
	if (parseInt(formato_exogena_id) > 0)  {
	  return true;
	} else if (parseInt(puc_id) > 0){
		return true;
	}else{
	   alertJquery('por favor digite un formato exogena !!','Validacion');
	   return false;
	}
	
  }

  function onSendFile(response){
  
	 if(response == 'true'){
		
		location.reload();
	  
	}else{
	  
		alertJquery(response,'error');
		console.log(response);
	  
	} 
	  
  }

function autocompleteFormato() {

	$("input[name=formato]").autocomplete("../../../framework/clases/ListaInteligente.php?consulta=formato_exogena", {
		width: 355,
		selectFirst: true
	});

	$("input[name=formato]").result(function (event, data, formatted) {
		if (data) $(this).next().val(data[1]);
		$(this).parent().next().find("input").focus();
		$(this).css("boxShadow", "none");
		$(this).parent().next().find("input").css("boxShadow", "0 0 7px 2px green");
	});
}

function autocompleteCategoria(){
	
	$("input[name=categoria_exogena]").autocomplete("../../../framework/clases/ListaInteligente.php?consulta=CategoriaExogena", {
		width: 355,
		selectFirst: true
	});
	
	$("input[name=categoria_exogena]").result(function(event, data, formatted) {
		
		if (data) $(this).next().val(data[1]);
		$(this).parent().next().find("input").focus();
		$(this).css("boxShadow", "none");
		$(this).parent().next().find("input").css("boxShadow", "0 0 7px 2px green");
    
	});	
}

function autocompleteBaseCategoria(){
	
	$("input[name=base_categoria_exogena]").autocomplete("../../../framework/clases/ListaInteligente.php?consulta=CategoriaExogena", {
		width: 355,
		selectFirst: true
	});
	
	$("input[name=base_categoria_exogena]").result(function(event, data, formatted) {
		
		if (data) $(this).next().val(data[1]);
		$(this).parent().next().find("input").focus();
		$(this).css("boxShadow", "none");
		$(this).parent().next().find("input").css("boxShadow", "0 0 7px 2px green");
    
	});	
}

function autocompleteConcepto() {
    
	$("input[name=concepto_exogena]").autocomplete("../../../framework/clases/ListaInteligente.php?consulta=conceptoExogena", {
		width: 355,
		selectFirst: true
	});

	$("input[name=concepto_exogena]").result(function (event, data, formatted) {

		if (data) $(this).next().val(data[1]);
		$(this).parent().next().find("select").focus();
		$(this).css("boxShadow", "none");

	});
}


function linkImputaciones(){
	$("a[name=saveDetalles]").attr("href","javascript:void(0)");
	
	$("a[name=saveDetalles]").focus(function(){
      var celda = this.parentNode;
      $(celda).addClass("focusSaveRow");	  
    });
	
	$("a[name=saveDetalles]").blur(function(){
      var celda = this.parentNode;
      $(celda).removeClass("focusSaveRow");	  
    });	
	
	$("a[name=saveDetalles]").click(function(){														
       saveDetalle(this);
	});	
	
	$("a[name=deleteDetalles]").click(function () {
		deleteDetalle(this);
	});	
}
	
function saveDetalle(obj){
	
	var row = obj.parentNode.parentNode;
	
    if(validaRequeridosDetalle(obj,row)){

		
		var Celda                  	= obj.parentNode;
		var Fila                   	= obj.parentNode.parentNode;	
		var formato_exogena_id 	    = $("#formato_exogena_id").val();
		var puc_id                  = $("#puc_id").val();

		if(formato_exogena_id != ''){
			var puc_id = $(Fila).find("input[name=puc_id]").val();	
			var tipo_formato 	        = $("#tipo_formato").val();
		}else if(puc_id != ''){
			var formato_exogena_id = $(Fila).find("input[name=formato_exogena_id]").val();	
		}

		var cuenta_exogena_id	    	= $(Fila).find("input[name=cuenta_exogena_id]").val();	
		var centro_de_costo_id			= $(Fila).find("select[name=centro_de_costo_id]").val();	
		var categoria_exogena_id    	= $(Fila).find("input[name=categoria_exogena_id]").val();		
		var base_categoria_exogena      = $(Fila).find("input[name=base_categoria_exogena]").val();		
		var base_categoria_exogena_id   = base_categoria_exogena == '' ? '' : $(Fila).find("input[name=base_categoria_exogena_id]").val();		
		var concepto_exogena_id     	= $(Fila).find("input[name=concepto_exogena_id]").val();	
		var tipo_sumatoria				= $(Fila).find("select[name=tipo_sumatoria]").val();
		var estado						= $(Fila).find("select[name=estado]").val();	
		var checkProcesar          		= $(Fila).find("input[name=procesar]");					
				
	if(!cuenta_exogena_id.length > 0){
	 
		var QueryString = "ACTIONCONTROLER=onclickSave&formato_exogena_id="+formato_exogena_id+"&centro_de_costo_id="+centro_de_costo_id+
		"&categoria_exogena_id="+categoria_exogena_id+"&puc_id="+puc_id+"&concepto_exogena_id="+concepto_exogena_id+"&tipo_sumatoria="
		+tipo_sumatoria+"&estado="+estado+'&base_categoria_exogena_id='+base_categoria_exogena_id;	
	
	  $.ajax({
		   
	    url        : "DetallesParametrosClass.php",
	    data       : QueryString,
	    beforeSend : function(){
	      showDivLoading();	
	    },
	    success    : function(response){
						
          if(!isNaN(response)){
			
            $(Fila).find("input[name=cuenta_exogena_id]").val(response);	
            var Table   = document.getElementById('tableDetalles');
			var numRows = (Table.rows.length);
			var newRow  = Table.insertRow(numRows);
		    $(newRow).html($("#clon").html());	
						
   	        checkRow();
			autocompletePuc();
			autocompleteFormato();
			autocompleteCategoria();	
			autocompleteConcepto();	
			autocompleteBaseCategoria();
            linkImputaciones();	
			
			
		   $("input[type=text],textarea").keyup(function(){												

			this.value = this.value.toUpperCase();								   
			
			});
			
			checkProcesar.attr("checked","");			
			$(Celda).removeClass("focusSaveRow");		
			removeDivLoading();
			setMessage("Formato Guardado Exitosamente!");
			$(newRow).find("input[name=codigo_puc]").css("boxShadow", "0 0 7px 2px green");
		
			
		  }else{
			alertJquery(response);
			removeDivLoading();
		  }
	    }		  
	  });	
	  
	}else{
		
		var QueryString = "ACTIONCONTROLER=onclickUpdate&formato_exogena_id="+formato_exogena_id+"&cuenta_exogena_id="+
		cuenta_exogena_id+"&centro_de_costo_id="+centro_de_costo_id+"&categoria_exogena_id="+categoria_exogena_id+"&puc_id="+puc_id
		+"&concepto_exogena_id="+concepto_exogena_id+"&tipo_sumatoria="+tipo_sumatoria+"&estado="+estado+'&base_categoria_exogena_id='+base_categoria_exogena_id;
		  
	  $.ajax({
		   
	    url        : "DetallesParametrosClass.php",
	    data       : QueryString,
	    beforeSend : function(){
	      showDivLoading();					
	    },
	    success    : function(response){
			
          if( $.trim(response) == 'true'){
			checkProcesar.attr("checked","");					
			$(Fila).find("a[name=saveDetalles]").parent().addClass("focusSaveRow");

			var formato_exogena_id = $("#formato_exogena_id").val();
			if(formato_exogena_id!=''){
				parent.document.getElementById("refresh_QUERYGRID_formato_exogena").click();
			}
			
			setMessage("Formato Actualizado Exitosamente!");

		  }else{
			alertJquery(response);
		    }			
 	     removeDivLoading();
	    }		  
	  });
	 }	 
	}else{
		alertJquery("Debe Ingresar un valor","Formato Exogena");
	  } 		
}

function deleteDetalle(obj){
    var Celda                   	= obj.parentNode;
    var Fila                    	= obj.parentNode.parentNode;
    var cuenta_exogena_id	= $(Fila).find("input[name=cuenta_exogena_id]").val();	
    var QueryString             	= "ACTIONCONTROLER=onclickDelete&cuenta_exogena_id="+cuenta_exogena_id;			
	
	if(cuenta_exogena_id.length > 0){
		
	  $.ajax({
		   
	    url        : "DetallesParametrosClass.php",
	    data       : QueryString,
	    beforeSend : function(){
	      showDivLoading();	
	    },
	    success    : function(response){
          if( $.trim(response) == 'true'){
			  
			var table = Fila.parentNode;
			table.removeChild(Fila);
			
			setMessage('Formato Eliminado Exitosamente','Formato Exogena');	
					
		  }else{
			alertJquery(response);
		   }
        removeDivLoading();
	    }		  
      });	  
	}else{
		alertJquery('No puede eliminar que no han sido guardados');
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
	$("input[type=radio]").click(function(){			 
	   var Fila  = this.parentNode.parentNode;	   
       $(Fila).find("input[name=procesar]").attr("checked","true");	   
    });	
}

function Generar(puc_id) {
	document.location.href = "DetallesParametrosClass.php?ACTIONCONTROLER=generateFile&puc_id=" +puc_id;
}
