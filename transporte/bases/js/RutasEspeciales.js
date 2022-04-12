// JavaScript Document
$(document).ready(function(){

	$("input[name=porcentaje_seguro]").blur(function(){

		var celda = this.parentNode;
		var porcentaje_seguro = this.value;
		var impuesto_base = $(celda).find("input[name=impuesto_base]").val();

		if (parseFloat(porcentaje_seguro) < parseFloat(impuesto_base)) { 
			$(celda).find("input[name=porcentaje_seguro]").val($(celda).find("input[name=impuesto_base]").val());
			alertJquery("El valor no debe ser menor al valor base establecido.","Validacion");
		}
	});


	$("select[name=periodo]").change(function(){
		setDataFormWithResponse();
	});

	linkDetalles();
	    autocompleteCiudad();
});


function autocompleteCiudad(){
	
	
	$("input[name=origen]").autocomplete("../../../framework/clases/ListaInteligente.php?consulta=ciudad", {
		width: 260,
		selectFirst: true,
		minChars: 2,
		scrollHeight: 220
	});
	
	$("input[name=origen]").result(function(event, data, formatted) {				   
										 										 
		if (data){
			var Fila = this.parentNode.parentNode;	
			var codigo_puc = data[0].split("-");
			
			$(this).val($.trim(codigo_puc[0]));
			$(this).next().val(data[1]);
			$(Fila).find("input[name=origen_id]").val(data[1]);	
		}
		
	});
	
	$("input[name=destino]").autocomplete("../../../framework/clases/ListaInteligente.php?consulta=ciudad", {
		width: 260,
		selectFirst: true,
		minChars: 2,
		scrollHeight: 220
	});
	
	$("input[name=destino]").result(function(event, data, formatted) {				   
										 										 
		if (data){
			var Fila = this.parentNode.parentNode;	
			var codigo_puc = data[0].split("-");
			
			$(this).val($.trim(codigo_puc[0]));
			$(this).next().val(data[1]);
			$(Fila).find("input[name=destino_id]").val(data[1]);	
		}
		
	});
	
}

function saveDetalle(obj){

	var row		=	obj.parentNode.parentNode;
	if(validaRequeridosDetalle(obj,row) && ($("#periodo").val()!='')){
		var Celda							=	obj.parentNode;
		var Fila							=	obj.parentNode.parentNode;
		var cliente_id						=	$("#cliente_id").val();
		var tercero_id						=	$("#tercero_id").val();
		
		var rutas_especiales_id				=	$(Fila).find("input[name=rutas_especiales_id]").val();
		var convencion_id					=	$(Fila).find("select[name=convencion_id]").val();
		var tipo							=	$(Fila).find("select[name=tipo]").val();
		var porcentaje						=	$(Fila).find("input[name=porcentaje]").val();
		    porcentaje						=	removeFormatCurrency(porcentaje);
		var origen_id						=	$(Fila).find("input[name=origen_id]").val();
		var destino_id						=	$(Fila).find("input[name=destino_id]").val();
		var precio1							=	$(Fila).find("input[name=precio1]").val();
			precio1							=	removeFormatCurrency(precio1);
		var precio2							=	$(Fila).find("input[name=precio2]").val();
			precio2							=	removeFormatCurrency(precio2);
		var hasta							=	$(Fila).find("input[name=hasta]").val();
		
		if(!rutas_especiales_id.length > 0){
			
			 rutas_especiales_id    = 'NULL';
		  
	 		 var QueryString = "ACTIONCONTROLER=onclickSave&tercero_id="+tercero_id+"&cliente_id="+
	  cliente_id+"&convencion_id="+convencion_id+"&porcentaje="+porcentaje+"&origen_id="+origen_id+"&destino_id="+destino_id+"&precio1="+precio1+"&precio2="+precio2+"&hasta="+hasta+"&tipo="+tipo;
	  
	    $.ajax({
		   
	    url        : "RutasEspecialesClass.php",
	    data       : QueryString,
	    beforeSend : function(){
	      showDivLoading();	
	    },
	    success    : function(response){
						
          if(!isNaN(response)){
			
            $(Fila).find("input[name=rutas_especiales_id]").val(response);	

            var Table   = document.getElementById('tableDetalles');
			var numRows = (Table.rows.length);
			var newRow  = Table.insertRow(numRows);

		    $(newRow).html($("#clon").html());
			$(newRow).find("input[name=origen]").focus();
			
						
   	        checkRow();
            autocompleteCiudad();
            linkDetalles();	

			
			//checkProcesar.attr("checked","");			
			$(Celda).removeClass("focusSaveRow");		
   	        removeDivLoading();
			
			
		  }else{
			alertJquery(response);
		  }

	    }
		  
	  });
	  
	  
			
		}else{
			
				 var QueryString = "ACTIONCONTROLER=onclickupdate&rutas_especiales_id="+rutas_especiales_id+"&tercero_id="+tercero_id+"&cliente_id="+cliente_id+"&convencion_id="+convencion_id+"&porcentaje="+porcentaje+"&origen_id="+origen_id+"&destino_id="+destino_id+"&precio1="+precio1+"&precio2="+precio2+"&hasta="+hasta+"&tipo="+tipo;
	  
	    $.ajax({
		   
	    url        : "RutasEspecialesClass.php",
	    data       : QueryString,
	    beforeSend : function(){
	      showDivLoading();	
	    },
	    success    : function(response){
			
          if( $.trim(response) == 'true'){
			//checkProcesar.attr("checked","");					
			$(Fila).find("a[name=saveDetalleTarifaCliente]").parent().addClass("focusSaveRow");
			
		  }else{
			alertJquery(response);
		    }
			
 	     removeDivLoading();
	    }
		  
	  });
	  
	  
			
			
		}
		
		
		
		
		

			}
}

function linkDetalles(){
	

	$("a[name=saveDetalleTarifaCliente]").attr("href","javascript:void(0)");
	
	$("a[name=saveDetalleTarifaCliente]").focus(function(){
      var celda = this.parentNode;
      $(celda).addClass("focusSaveRow");	  
    });
	
	$("a[name=saveDetalleTarifaCliente]").blur(function(){
      var celda = this.parentNode;
      $(celda).removeClass("focusSaveRow");	  
    });	
	
	$("a[name=saveDetalleTarifaCliente]").click(function(){
														
       saveDetalle(this);

    });	
	
	
}

function setDataFormWithResponse(){
		var tercero_id						=	$("#tercero_id").val();
		var periodo							=	$("#periodo").val();
	
	  var url = "TarifasClass.php?tercero_id="+tercero_id+"&periodo="+periodo+"&rand="+Math.random();
	  parent.document.getElementById('tarifa').src=url;
	  //$("#tarifa").attr("src",url);						  	
	
}

function TarifasReset(){

	var form 		= document.forms[0];
	Reset(form);
}