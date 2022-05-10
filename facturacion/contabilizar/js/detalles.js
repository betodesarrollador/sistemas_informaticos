// JavaScript Document

$(document).ready(function(){
						   
    checkedAll();
	checkRow();
    autocompleteTercero();	
	autocompleteCentroCosto();
	autocompleteCodigoContable();
	getvalorCalculadoBase();
	linkImputaciones();
	
    $(document).bind('keyup', 'Ctrl+c',function (evt){ 

      var txtConcepto = $(document).find(":focus");
      var concepto    = parent.document.getElementById("concepto").value;
	  
	  if(txtConcepto.attr("name") == "descripcion"){
          var varTmp = txtConcepto.val();
		  txtConcepto.val(varTmp+' '+concepto);
      }
	  
      return false;

    });	
	
    $(document).bind('keydown', 'Ctrl+t',function (evt){ 
						
      var txtConcepto = $(document).find(":focus");
      var tercero     = parent.document.getElementById("tercero").value;
	  
	  if(txtConcepto.attr("name") == "descripcion"){
          var varTmp = txtConcepto.val();
		  txtConcepto.val(varTmp+' '+tercero);
      }						
						
       return false; 
	   
    });	
	
	$("*[name=saveDetalle]").click(function(){
       saveDetalle(this);					   
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
function autocompleteCodigoContable(){
	
	
	$("input[name=puc]").autocomplete("../../../framework/clases/ListaInteligente.php?consulta=cuentas_movimiento", {
		width: 260,
		selectFirst: true,
		minChars: 4,
		scrollHeight: 220
	});
	
	$("input[name=puc]").result(function(event, data, formatted) {				   
										 										 
		if (data){
			
			var codigo_puc = data[0].split("-");
			
			$(this).val($.trim(codigo_puc[0]));
			$(this).attr("title",data[0]);			
			
			$(this).next().val(data[1]);
            getRequieresCuenta(data[1],this);
			
			$(this.parentNode.parentNode).find("input[name=desc_factura_proveedor]").val($.trim(codigo_puc[1]));

		}
		
	});
	
}

function autocompleteTercero(){
	
	$("input[name=tercero]").autocomplete("../../../framework/clases/ListaInteligente.php?consulta=tercero", {
		width: 260,
		selectFirst: true
	});
	
	$("input[name=tercero]").result(function(event, data, formatted) {				   
		if (data){
			var numero_identificacion = data[0].split("-");
			$(this).val($.trim(numero_identificacion[0]));
			$(this).attr("title",data[0]);
			$(this).next().val(data[1]);
			
   		    var txtNext = false;			
			
            $(this.parentNode.parentNode).find("input[name!=puc]&&input[name!=tercero]&&input[type=text]").each(function(){
               if(this.readOnly == false && txtNext == false){
				   this.focus();
				   txtNext = true;
			   }
			   
            });			
		}
	});
	
}

function autocompleteCentroCosto(){
	
	$("input[name=centro_de_costo]").autocomplete("../../../framework/clases/ListaInteligente.php?consulta=centro_costo", {
		width: 260,
		selectFirst: true
	});
	
	$("input[name=centro_de_costo]").result(function(event, data, formatted) {				   
		if (data){
			var centro_costo = data[0].split("-");
			$(this).val($.trim(centro_costo[0]));
			$(this).attr("title",data[0]);			
			$(this).next().val(data[1]);
			
			var txtNext = false;
			
            $(this.parentNode.parentNode).find("input[name!=puc]&&input[name!=tercero]&&input[name!=centro_de_costo]&&input[type=text]").each(function(){
               if(this.readOnly == false && txtNext == false){
				   this.focus();
				   txtNext = true;
			   }
			   
            });					
		}
	});
	
}



/***************************************************************
	  Funciones para el objeto de guardado en las imputaciones
***************************************************************/

function getRequieresCuenta(puc_id,objTxt){
	
  var fila                   =$(objTxt).parent().parent();
  var factura_proveedor_id 	 =$("#factura_proveedor_id").val();
  var QueryString            ="ACTIONCONTROLER=getRequieresCuenta&puc_id="+puc_id+'&factura_proveedor_id='+factura_proveedor_id;
	
  $.ajax({
	url        : "DetallesClass.php",
	data       : QueryString,
	beforeSend : function (){
	  showDivLoading();	
    },
	success    : function(response){

      try{
		  
  	    var requiere              = $.parseJSON(response);
	    var requiere_tercero      = requiere['requiere_tercero'];
	    var requiere_centro_costo = requiere['requiere_centro_costo'];		
	    var require_base          = requiere['require_base'];
		
        fila.find("input[name=tercero]").val("");			
        fila.find("input[name=tercero_id]").val("");											  		
        fila.find("input[name=centro_de_costo]").val("");			
        fila.find("input[name=centro_de_costo_id]").val("");											  		
        fila.find("input[name=base_factura_proveedor]").val("");											  				
	
		if($.trim(requiere_tercero) == "true"){
          fila.find("input[name=tercero]").removeClass("no_requerido");
          fila.find("input[name=tercero]").attr("readonly","");		  
          fila.find("input[name=tercero]").parent().removeClass("no_requerido");			
          fila.find("input[name=tercero_id]").addClass("required");									
        }else{
            fila.find("input[name=tercero]").addClass("no_requerido");
            fila.find("input[name=tercero]").attr("readonly","true");		  			
            fila.find("input[name=tercero]").parent().addClass("no_requerido");			
            fila.find("input[name=tercero_id]").removeClass("required");												
		  }


		if($.trim(requiere_centro_costo) == "true"){
          fila.find("input[name=centro_de_costo]").removeClass("no_requerido");
          fila.find("input[name=centro_de_costo]").attr("readonly","");		  
          fila.find("input[name=centro_de_costo]").parent().removeClass("no_requerido");			
          fila.find("input[name=centro_de_costo_id]").addClass("required");									
        }else{
            fila.find("input[name=centro_de_costo]").addClass("no_requerido");
            fila.find("input[name=centro_de_costo]").attr("readonly","true");		  			
            fila.find("input[name=centro_de_costo]").parent().addClass("no_requerido");			
            fila.find("input[name=centro_de_costo_id]").removeClass("required");												
		  }
		  
		if($.trim(require_base) == "true"){
          fila.find("input[name=base_factura_proveedor]").removeClass("no_requerido");
          fila.find("input[name=base_factura_proveedor]").attr("readonly","");		  
          fila.find("input[name=base_factura_proveedor]").parent().removeClass("no_requerido");			
          fila.find("input[name=base_factura_proveedor]").addClass("required numeric");					  
          fila.find("input[name=deb_item_factura_proveedor]").attr("readonly","true");					  
          fila.find("input[name=cre_item_factura_proveedor]").attr("readonly","true");					  
        }else{
            fila.find("input[name=base_factura_proveedor]").addClass("no_requerido");
            fila.find("input[name=base_factura_proveedor]").attr("readonly","true");		  			
            fila.find("input[name=base_factura_proveedor]").parent().addClass("no_requerido");			
            fila.find("input[name=base_factura_proveedor]").removeClass("required");						
            fila.find("input[name=deb_item_factura_proveedor]").attr("readonly","");					  
            fila.find("input[name=cre_item_factura_proveedor]").attr("readonly","");			
		  }		  

		 removeDivLoading();		  
		
           var txtNext = false;
			
            $(fila).find("input[name!=puc]&&input[type=text]").each(function(){
               if(this.readOnly == false && txtNext == false){
				   this.focus();
				   txtNext = true;
			   }
			   
            });	
		
		
	  }catch(e){

		  }
	  		  
    }
	
  });
	
}

function getvalorCalculadoBase(){

  $("input[name=base_factura_proveedor]").blur(function(){

    if($(this).is(".required")){

      var objBase                = this;
      var puc_id                 = $(this).parent().parent().find("input[name=puc_id]").val();
      var base_factura_proveedor = removeFormatCurrency($(this).parent().parent().find("input[name=base_factura_proveedor]").val());	  
	  var factura_proveedor_id = $("#factura_proveedor_id").val();
	  
      var QueryString            ="ACTIONCONTROLER=getvalorCalculadoBase&puc_id="+puc_id+'&factura_proveedor_id='+
	                               factura_proveedor_id+"&base_factura_proveedor="+base_factura_proveedor;
	  
	  
      $.ajax({
     	url     : "DetallesClass.php",
		data    : QueryString,
		success : function(response){
			
          try{
			  
           var datosCalculo = $.parseJSON(response);
		   var dato_real=Math.round(parseFloat(datosCalculo['valor']));
		   
		   if($.trim(datosCalculo['naturaleza']) == 'D'){
			  $(objBase).parent().parent().find("input[name=deb_item_factura_proveedor]").val(setFormatCurrency(dato_real));
		      $(objBase).parent().parent().find("input[name=cre_item_factura_proveedor]").val("0");			   			  
           }else{
			    $(objBase).parent().parent().find("input[name=deb_item_factura_proveedor]").val("0");			   
			    $(objBase).parent().parent().find("input[name=cre_item_factura_proveedor]").val(setFormatCurrency(dato_real));			   
			  }
		   
		  }catch(e){
			 }

        }
	  });

    }

  });
  
}

function linkImputaciones(){

	$("a[name=saveAgregar]").attr("href","javascript:void(0)");
	
	$("a[name=saveAgregar]").focus(function(){
      var celda = this.parentNode;
      $(celda).addClass("focusSaveRow");	  
    });
	
	$("a[name=saveAgregar]").blur(function(){
      var celda = this.parentNode;
      $(celda).removeClass("focusSaveRow");	  
    });	
	
	$("a[name=saveAgregar]").click(function(){
														
       saveDetalle1(this);

    });	
	
}

function saveDetalle1(obj){
	
	var row = obj.parentNode.parentNode;
	
    if(validaRequeridosDetalle(obj,row)){

    var Celda                  		= obj.parentNode;
    var Fila                   	  	= obj.parentNode.parentNode;	
    var item_factura_proveedor_id 	= $(Fila).find("input[name=item_factura_proveedor_id]").val();	
	var factura_proveedor_id   		= $("#factura_proveedor_id").val();
	var puc_id                 		= $(Fila).find("input[name=puc_id]").val();		
	var tercero_id             		= $(Fila).find("input[name=tercero_id]").val();	
	var centro_de_costo_id     		= $(Fila).find("input[name=centro_de_costo_id]").val();	
	var centro_de_costo     		= $(Fila).find("input[name=centro_de_costo]").val();		
	var desc_factura_proveedor      = $(Fila).find("input[name=desc_factura_proveedor]").val();			
	var base_factura_proveedor      = $(Fila).find("input[name=base_factura_proveedor]").val();	
	var deb_item_factura_proveedor  = $(Fila).find("input[name=deb_item_factura_proveedor]").val();	
	var cre_item_factura_proveedor  = $(Fila).find("input[name=cre_item_factura_proveedor]").val();	
	var contra_factura_proveedor    = $(Fila).find("input[name=contra_factura_proveedor]").is(":checked")?1:0;	
	var checkProcesar          		= $(Fila).find("input[name=procesar]");					
	
	tercero_id             		= tercero_id.length         		> 0 ? tercero_id         		: 'NULL';
	centro_de_costo_id     		= centro_de_costo_id.length 		> 0 ? centro_de_costo_id 		: 'NULL';
	base_factura_proveedor		= base_factura_proveedor.length 	> 0 ? base_factura_proveedor 	: 'NULL';
	deb_item_factura_proveedor 	= deb_item_factura_proveedor.length > 0 ? deb_item_factura_proveedor: 'NULL';
	cre_item_factura_proveedor 	= cre_item_factura_proveedor.length > 0 ? cre_item_factura_proveedor: 'NULL';
				
	if((parseInt(deb_item_factura_proveedor) > 0 || parseInt(cre_item_factura_proveedor)>0) && !parseInt(item_factura_proveedor_id)>0 ){
  	  item_factura_proveedor_id='NULL';
	  var QueryString = "ACTIONCONTROLER=onclickSave&factura_proveedor_id="+factura_proveedor_id+"&item_factura_proveedor_id="+
	  item_factura_proveedor_id+"&puc_id="+puc_id+"&tercero_id="+tercero_id+"&centro_de_costo_id="+centro_de_costo_id+"&centro_de_costo="+centro_de_costo+"&desc_factura_proveedor="+desc_factura_proveedor+
	  "&base_factura_proveedor="+base_factura_proveedor+"&deb_item_factura_proveedor="+deb_item_factura_proveedor+"&cre_item_factura_proveedor="+cre_item_factura_proveedor+"&contra_factura_proveedor="+contra_factura_proveedor;	

	  $.ajax({
		   
	    url        : "DetallesClass.php",
	    data       : QueryString,
	    beforeSend : function(){
	      showDivLoading();				
	    },
	    success    : function(response){
			
          if( !isNaN(response)){
			checkProcesar.attr("checked","");	
			$(Fila).find("input[name=item_factura_proveedor_id]").val(response);	
			if(parent.getTotalDebitoCredito) 
				parent.getTotalDebitoCredito(parent.document.getElementById("factura_proveedor_id").value);
				var Table   = document.getElementById('tableDetalles');
				var numRows = (Table.rows.length);
				var newRow  = Table.insertRow(numRows);
	
				$(newRow).html($("#clon").html());
				$(newRow).find("input[name=puc]").focus();
				
				checkedAll();
				checkRow();
				autocompleteTercero();	
				autocompleteCentroCosto();
				autocompleteCodigoContable();
				getvalorCalculadoBase();
				linkImputaciones();
				$(Celda).removeClass("focusSaveRow");		
				
			  
		    }else{
			  alertJquery(response);
		    }
			
 	    removeDivLoading();	
	    }
						
	  });
  
	}else if((parseInt(deb_item_factura_proveedor) > 0 || parseInt(cre_item_factura_proveedor)>0) && parseInt(item_factura_proveedor_id)>0 ){
	  var QueryString = "ACTIONCONTROLER=onclickUpdates&factura_proveedor_id="+factura_proveedor_id+"&item_factura_proveedor_id="+
	  item_factura_proveedor_id+"&puc_id="+puc_id+"&tercero_id="+tercero_id+"&centro_de_costo_id="+centro_de_costo_id+"&desc_factura_proveedor="+desc_factura_proveedor+
	  "&base_factura_proveedor="+base_factura_proveedor+"&deb_item_factura_proveedor="+deb_item_factura_proveedor+"&cre_item_factura_proveedor="+cre_item_factura_proveedor+"&contra_factura_proveedor="+contra_factura_proveedor;	



	  $.ajax({
		   
	    url        : "DetallesClass.php",
	    data       : QueryString,
	    beforeSend : function(){
	      showDivLoading();					
	    },
	    success    : function(response){
			
          if( $.trim(response) == 'true'){
			checkProcesar.attr("checked","");					
			$(Fila).find("a[name=saveAgregar]").parent().addClass("focusSaveRow");
		  }else{
			alertJquery(response);
		    }
			
 	     removeDivLoading();
	    }
		  
	  });


	 }
	 
	}else{
		alertJquery("Debe Ingresar un valor","Validacion Debito / Credito");
	  }
	 
 		
}

function saveDetalle(obj){
	
	var row = obj.parentNode.parentNode;
	
    if(validaRequeridosDetalle(obj,row)){
				
    var Celda                  		= obj.parentNode;
    var Fila                   	  	= obj.parentNode.parentNode;	
    var item_factura_proveedor_id 	= $(Fila).find("input[name=item_factura_proveedor_id]").val();	
	var factura_proveedor_id   		= $("#factura_proveedor_id").val();
	var puc_id                 		= $(Fila).find("input[name=puc_id]").val();		
	var tercero_id             		= $(Fila).find("input[name=tercero_id]").val();	
	var centro_de_costo_id     		= $(Fila).find("input[name=centro_de_costo_id]").val();	
	var desc_factura_proveedor      = $(Fila).find("input[name=desc_factura_proveedor]").val();			
//	var base_factura_proveedor      = $(Fila).find("input[name=base_factura_proveedor]").val();	
	var deb_item_factura_proveedor  = $(Fila).find("input[name=deb_item_factura_proveedor]").val();	
	var cre_item_factura_proveedor  = $(Fila).find("input[name=cre_item_factura_proveedor]").val();	
	var checkProcesar          		= $(Fila).find("input[name=procesar]");					
	
	tercero_id             		= tercero_id.length         		> 0 ? tercero_id         		: 'NULL';
	centro_de_costo_id     		= centro_de_costo_id.length 		> 0 ? centro_de_costo_id 		: 'NULL';
//	base_factura_proveedor		= base_factura_proveedor.length 	> 0 ? base_factura_proveedor 	: 'NULL';
	deb_item_factura_proveedor 	= deb_item_factura_proveedor.length > 0 ? deb_item_factura_proveedor: 'NULL';
	cre_item_factura_proveedor 	= cre_item_factura_proveedor.length > 0 ? cre_item_factura_proveedor: 'NULL';
	
	if(parseInt(deb_item_factura_proveedor) > 0 || parseInt(cre_item_factura_proveedor)){
				

	  var QueryString = "ACTIONCONTROLER=onclickUpdate&factura_proveedor_id="+factura_proveedor_id+"&item_factura_proveedor_id="+
	  item_factura_proveedor_id+"&puc_id="+puc_id+"&tercero_id="+tercero_id+"&centro_de_costo_id="+centro_de_costo_id+"&desc_factura_proveedor="+desc_factura_proveedor+
	  /*"&base_factura_proveedor="+base_factura_proveedor+*/"&deb_item_factura_proveedor="+deb_item_factura_proveedor+"&cre_item_factura_proveedor="+cre_item_factura_proveedor;	
	  		
	  $.ajax({
		   
	    url        : "DetallesClass.php",
	    data       : QueryString,
	    beforeSend : function(){
	      showDivLoading();				
	    },
	    success    : function(response){
			
          if( $.trim(response) == 'true'){
			checkProcesar.attr("checked","");					
			if(parent.getTotalDebitoCredito) 
			  parent.getTotalDebitoCredito(parent.document.getElementById("factura_proveedor_id").value);
		    }else{
			  alertJquery(response);
		    }
			
 	    removeDivLoading();	
	    }
		  
	  });


	}else{
		alertJquery("Debe Ingresar un valor","Validacion Debito / Credito");
	}
	 
  }
 		
}


function deleteDetalle(obj){
	
	var row = obj.parentNode.parentNode;
	
    if(validaRequeridosDetalle(obj,row)){
				
    var Celda                  		= obj.parentNode;
    var Fila                   	  	= obj.parentNode.parentNode;	
    var item_factura_proveedor_id 	= $(Fila).find("input[name=item_factura_proveedor_id]").val();	
	var factura_proveedor_id   		= $("#factura_proveedor_id").val();
	
	var checkProcesar          		= $(Fila).find("input[name=procesar]");					
	
	
	if(parseInt(item_factura_proveedor_id) > 0 && parseInt(factura_proveedor_id)){
		
	  var QueryString = "ACTIONCONTROLER=onclickDelete&factura_proveedor_id="+factura_proveedor_id+"&item_factura_proveedor_id="+item_factura_proveedor_id;	
	  		
	  $.ajax({
		   
	    url        : "DetallesClass.php",
	    data       : QueryString,
	    beforeSend : function(){
	      showDivLoading();				
	    },
	    success    : function(response){
			
          if( $.trim(response) == 'true'){
			checkProcesar.attr("checked","");					
			if(parent.getTotalDebitoCredito) 
			  parent.getTotalDebitoCredito(parent.document.getElementById("factura_proveedor_id").value);
			  $(Fila).remove();
		    }else{
			  alertJquery(response);
		    }
			
 	    removeDivLoading();	
	    }
		  
	  });


	}else{
		alertJquery("Debe Seleccionar una Causacion Guardada.","Validacion");
	}
	 
  }
 		
}


function saveDetalles(){

  $("input[name=procesar]:checked").each(function(){
 	 var tipo   		= $("#tipo").val();
	 if(parseInt(tipo)==0)
	     saveDetalle(this);
	 else	 
		saveDetalle1(this);
  });

}

function deleteDetalles(){

  $("input[name=procesar]:checked").each(function(){
 	 var tipo   		= $("#tipo").val();
	 
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