// JavaScript Document

$(document).ready(function(){
				
				
    linkDetalles();				
    checkedAll();
	checkRow();
    autocompleteTercero();	
	autocompleteCentroCosto();
	autocompleteCodigoContable();
	getvalorCalculadoBase();
	
	autocompleteArea();
	autocompleteSucursal();
	autocompleteDepartamento();
	autocompleteUnidad();
	
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
	
	var encabezado_registro_id = $("#encabezado_registro_id").val();
	
	$("input[name=puc]").autocomplete("/rotterdan/framework/clases/ListaInteligente.php?consulta=cuentas_movimiento&encabezado_registro_id="+encabezado_registro_id, {
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
			
			$(this.parentNode.parentNode).find("input[name=descripcion]").val($.trim(codigo_puc[1]));

		}
		
	});
	
}

function autocompleteTercero(){
	
	$("input[name=tercero]").autocomplete("/rotterdan/framework/clases/ListaInteligente.php?consulta=tercero", {
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

	

	$("input[name=centro_de_costo]").autocomplete("/rotterdan/framework/clases/ListaInteligente.php?consulta=centro_costo", {

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

			

            $(this.parentNode.parentNode).find("input[name!=puc]&&input[name!=centro_de_costo]&&input[type=text]").each(function(){

               if(this.readOnly == false && txtNext == false){

				   this.focus();

				   txtNext = true;

			   }

			   

            });			

		}

	});

	

}




function autocompleteArea(){

	

	$("input[name=area]").autocomplete("/rotterdan/framework/clases/ListaInteligente.php?consulta=area", {

		width: 260,

		selectFirst: true

	});

	

	$("input[name=area]").result(function(event, data, formatted) {				   

		if (data){

			var area = data[0].split("-");

			$(this).val($.trim(area[0]));

			$(this).attr("title",data[0]);			

			$(this).next().val(data[1]);

			

			var txtNext = false;

			

            $(this.parentNode.parentNode).find("input[name!=puc]&&input[name!=tercero]&&input[name!=area]&&input[type=text]").each(function(){

               if(this.readOnly == false && txtNext == false){

				   this.focus();

				   txtNext = true;

			   }

			   

            });					

		}

	});

	

}

function autocompleteSucursal(){

	

	$("input[name=sucursal]").autocomplete("/rotterdan/framework/clases/ListaInteligente.php?consulta=busca_oficina", {

		width: 260,

		selectFirst: true

	});

	

	$("input[name=sucursal]").result(function(event, data, formatted) {				   

		if (data){

			var sucursal = data[0].split("-");

			$(this).val($.trim(sucursal[0]));

			$(this).attr("title",data[0]);			

			$(this).next().val(data[1]);

			

			var txtNext = false;

			

            $(this.parentNode.parentNode).find("input[name!=puc]&&input[name!=tercero]&&input[name!=sucursal]&&input[type=text]").each(function(){

               if(this.readOnly == false && txtNext == false){

				   this.focus();

				   txtNext = true;

			   }

			   

            });					

		}

	});

	

}

function autocompleteDepartamento(){

	

	$("input[name=departamento]").autocomplete("/rotterdan/framework/clases/ListaInteligente.php?consulta=departamento", {

		width: 260,

		selectFirst: true

	});

	

	$("input[name=departamento]").result(function(event, data, formatted) {				   

		if (data){

			var departamento = data[0].split("-");

			$(this).val($.trim(departamento[0]));

			$(this).attr("title",data[0]);			

			$(this).next().val(data[1]);

			

			var txtNext = false;

			

            $(this.parentNode.parentNode).find("input[name!=puc]&&input[name!=tercero]&&input[name!=departamento]&&input[type=text]").each(function(){

               if(this.readOnly == false && txtNext == false){

				   this.focus();

				   txtNext = true;

			   }

			   

            });					

		}

	});

	

}


function autocompleteUnidad(){

	

	$("input[name=unidadnegocio]").autocomplete("/rotterdan/framework/clases/ListaInteligente.php?consulta=unidad_negocio", {

		width: 260,

		selectFirst: true

	});

	

	$("input[name=unidadnegocio]").result(function(event, data, formatted) {				   

		if (data){

			var unidadnegocio = data[0].split("-");

			$(this).val($.trim(unidadnegocio[0]));

			$(this).attr("title",data[0]);			

			$(this).next().val(data[1]);

			

			var txtNext = false;

			

            $(this.parentNode.parentNode).find("input[name!=puc]&&input[name!=tercero]&&input[name!=unidadnegocio]&&input[type=text]").each(function(){

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
  var abono_factura_proveedor_id 	 =$("#abono_factura_proveedor_id").val();
  var QueryString            ="ACTIONCONTROLER=getRequieresCuenta&puc_id="+puc_id+'&abono_factura_proveedor_id='+abono_factura_proveedor_id;
	
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
	    var requiere_base          = requiere['requiere_base'];
		var requiere_sucursal    = requiere['requiere_sucursal'];	
		var requiere_area          = requiere['requiere_area'];
		var requiere_departamento          = requiere['requiere_departamento'];
		var requiere_unidad          = requiere['requiere_unidad'];
		var contrapartida          = requiere['contrapartida'];
		
       /* fila.find("input[name=tercero]").val("");			
        fila.find("input[name=tercero_id]").val("");											  		
        fila.find("input[name=centro_de_costo]").val("");			
        fila.find("input[name=centro_de_costo_id]").val("");											  		
        fila.find("input[name=base_factura_proveedor]").val("");
		fila.find("input[name=sucursal]").val("");
		 fila.find("input[name=area]").val("");	
		 fila.find("input[name=departamento]").val("");	
		 fila.find("input[name=unidad]").val("");	*/
	
		if($.trim(contrapartida) == "true"){
          fila.find("input[name=contra_factura_proveedor]").attr("checked","true");
		  fila.find("input[name=contra_factura_proveedor]").attr("disabled","");
		  
         							
        }else{
			fila.find("input[name=contra_factura_proveedor]").val("0");		
             fila.find("input[name=contra_factura_proveedor]").attr("checked","");
			 fila.find("input[name=contra_factura_proveedor]").attr("disabled","true");		
		  }
		  
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
		  if($.trim(requiere_sucursal) == "true"){

          fila.find("input[name=sucursal]").removeClass("no_requerido");

          fila.find("input[name=sucursal]").attr("readonly","");		  

          fila.find("input[name=sucursal]").parent().removeClass("no_requerido");			

          fila.find("input[name=sucursal_id]").addClass("required");									

        }else{

            fila.find("input[name=sucursal]").addClass("no_requerido");

            fila.find("input[name=sucursal]").attr("readonly","true");		  			

            fila.find("input[name=sucursal]").parent().addClass("no_requerido");			

            fila.find("input[name=sucursal_id]").removeClass("required");												

		  }

		  
		if($.trim(requiere_base) == "true"){
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
		 if($.trim(requiere_area) == "true"){

          fila.find("input[name=area]").removeClass("no_requerido");

          fila.find("input[name=area]").attr("readonly","");		  

          fila.find("input[name=area]").parent().removeClass("no_requerido");			

          fila.find("input[name=area_id]").addClass("required");									

        }else{

            fila.find("input[name=area]").addClass("no_requerido");

            fila.find("input[name=area]").attr("readonly","true");		  			

            fila.find("input[name=area]").parent().addClass("no_requerido");			

            fila.find("input[name=area_id]").removeClass("required");												

		  }

 		if($.trim(requiere_departamento) == "true"){

          fila.find("input[name=departamento]").removeClass("no_requerido");

          fila.find("input[name=departamento]").attr("readonly","");		  

          fila.find("input[name=departamento]").parent().removeClass("no_requerido");			

          fila.find("input[name=departamento_id]").addClass("required");									

        }else{

            fila.find("input[name=departamento]").addClass("no_requerido");

            fila.find("input[name=departamento]").attr("readonly","true");		  			

            fila.find("input[name=departamento]").parent().addClass("no_requerido");			

            fila.find("input[name=departamento_id]").removeClass("required");												

		  }

 		if($.trim(requiere_unidad) == "true"){

          fila.find("input[name=unidadnegocio]").removeClass("no_requerido");

          fila.find("input[name=unidadnegocio]").attr("readonly","");		  

          fila.find("input[name=unidadnegocio]").parent().removeClass("no_requerido");			

          fila.find("input[name=unidad_negocio_id]").addClass("required");									

        }else{

            fila.find("input[name=unidadnegocio]").addClass("no_requerido");

            fila.find("input[name=unidadnegocio]").attr("readonly","true");		  			

            fila.find("input[name=unidadnegocio]").parent().addClass("no_requerido");			

            fila.find("input[name=unidad_negocio_id]").removeClass("required");												

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
			 removeDivLoading();	
		  }
	  		  
    }
	
  });
	
}
function getvalorCalculadoBase(){

  $("input[name=base_abono_factura]").blur(function(){

    if($(this).is(".required")){

      var objBase                	 = this;
      var puc_id                 	 = $(this).parent().parent().find("input[name=puc_id]").val();
      var base_abono_factura 	 	 = $(this).parent().parent().find("input[name=base_abono_factura]").val();	  
	  var abono_factura_proveedor_id = $("#abono_factura_proveedor_id").val();
	  
      var QueryString            ="ACTIONCONTROLER=getvalorCalculadoBase&puc_id="+puc_id+'&abono_factura_proveedor_id='+
	                               abono_factura_proveedor_id+"&base_abono_factura="+base_abono_factura;
	  
	  
      $.ajax({
     	url     : "DetallesClass.php",
		data    : QueryString,
		success : function(response){
			
          try{
			  
           var datosCalculo = $.parseJSON(response);
		   
		   if($.trim(datosCalculo['naturaleza']) == 'D'){
			  $(objBase).parent().parent().find("input[name=deb_item_abono_factura]").val(datosCalculo['valor']);
		      $(objBase).parent().parent().find("input[name=cre_item_abono_factura]").val("0");			   			  
           }else{
			    $(objBase).parent().parent().find("input[name=deb_item_abono_factura]").val("0");			   
			    $(objBase).parent().parent().find("input[name=cre_item_abono_factura]").val(datosCalculo['valor']);			   
			  }
		   
		  }catch(e){
			 }

        }
	  });

    }

  });
  
}

function saveDetalle(obj){
	
	var row = obj.parentNode.parentNode;
	
    if(validaRequeridosDetalle(obj,row)){

    var Celda                  		= obj.parentNode;
    var Fila                   	  	= obj.parentNode.parentNode;	
    var item_abono_factura_id 		= $(Fila).find("input[name=item_abono_factura_id]").val();	
	var abono_factura_proveedor_id  = $("#abono_factura_proveedor_id").val();
	var puc_id                 		= $(Fila).find("input[name=puc_id]").val();		
	var tercero_id             		= $(Fila).find("input[name=tercero_id]").val();	
	var centro_de_costo_id     		= $(Fila).find("input[name=centro_de_costo_id]").val();	
	var sucursal_id     = $(Fila).find("input[name=sucursal_id]").val();
	var area_id     = $(Fila).find("input[name=area_id]").val();
	var departamento_id     = $(Fila).find("input[name=departamento_id]").val();
	var unidad_negocio_id     = $(Fila).find("input[name=unidad_negocio_id]").val();
	var desc_abono_factura      	= $(Fila).find("input[name=desc_abono_factura]").val();			
	var base_abono_factura      	= $(Fila).find("input[name=base_abono_factura]").val();	
	var deb_item_abono_factura  	= $(Fila).find("input[name=deb_item_abono_factura]").val();	
	var cre_item_abono_factura 	 	= $(Fila).find("input[name=cre_item_abono_factura]").val();	
	var valor_total  				= $(Fila).find("input[name=valor_total]").val();	
	var abonos 	 					= $(Fila).find("input[name=abonos]").val();	
	var checkProcesar          		= $(Fila).find("input[name=procesar]");		
	var saldo						= valor_total-abonos;
	
	tercero_id             		= tercero_id.length         	> 0 ? tercero_id         	: 'NULL';
	centro_de_costo_id     		= centro_de_costo_id.length 		> 0 ? centro_de_costo_id 		: 'NULL';
	sucursal_id     		= sucursal_id.length 	   > 0 ? sucursal_id 		: 'NULL';
	area_id     			= area_id.length 			> 0 ? area_id 			: 'NULL';
	departamento_id     	= departamento_id.length 	> 0 ? departamento_id 	: 'NULL';
	unidad_negocio_id    	= unidad_negocio_id.length 	> 0 ? unidad_negocio_id 	: 'NULL';
   base_abono_factura			= base_abono_factura.length 	> 0 ? base_abono_factura 	: 'NULL';
	deb_item_abono_factura 		= deb_item_abono_factura.length > 0 ? deb_item_abono_factura: 'NULL';
	cre_item_abono_factura 		= cre_item_abono_factura.length > 0 ? cre_item_abono_factura: 'NULL';
	
	/*if((parseInt(deb_item_abono_factura) > 0 || parseInt(cre_item_abono_factura))&& saldo>=deb_item_abono_factura &&  saldo>=cre_item_abono_factura){*/
				

	  var QueryString = "ACTIONCONTROLER=onclickUpdate&abono_factura_proveedor_id="+abono_factura_proveedor_id+"&item_abono_factura_id="+
	  item_abono_factura_id+"&puc_id="+puc_id+"&tercero_id="+tercero_id+"&centro_de_costo_id="+centro_de_costo_id+"&desc_abono_factura="+desc_abono_factura+
	  "&base_abono_factura="+base_abono_factura+"&deb_item_abono_factura="+deb_item_abono_factura+"&cre_item_abono_factura="+cre_item_abono_factura+"&sucursal_id="+sucursal_id+"&area_id="+area_id+"&departamento_id="+departamento_id+"&unidad_negocio_id="+unidad_negocio_id;			
	  		
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
			  parent.getTotalDebitoCredito(parent.document.getElementById("abono_factura_proveedor_id").value);
		    }else{
			  alertJquery(response);
		    }
			
 	    removeDivLoading();	
	    }
		  
	  });

	/*}else if(saldo<deb_item_abono_factura ||  saldo<cre_item_abono_factura){
		alertJquery("Los valores sobrepasan el saldo de la Factura","Validacion Debito / Credito");
	}else{
		alertJquery("Debe Ingresar un valor","Validacion Debito / Credito");
	}*/
	 
  }
 		
}


function saveDetalles(){

  $("input[name=procesar]:checked").each(function(){
 
     saveDetalle(this);

  });

}


function checkRow(){
	
	$("input[type=text]").keyup(function(event){
       var Tecla = event.keyCode;
	   var Fila  = this.parentNode.parentNode;
	   
       $(Fila).find("input[name=procesar]").attr("checked","true");
	   
    });
	
}

function saveDetalleNuevo(obj){
	
	var row = obj.parentNode.parentNode;

    if(validaRequeridosDetalle(obj,row)){
	


    var Celda                  		= obj.parentNode;
    var Fila                   	  	= obj.parentNode.parentNode;	
	var relacion_abono_factura_id   = $(Fila).find("input[name=relacion_abono_factura_id]").val();	
    var item_abono_factura_id 		= $(Fila).find("input[name=item_abono_factura_id]").val();	
	var abono_factura_proveedor_id  = $("#abono_factura_proveedor_id").val();
	var puc_id                 		= $(Fila).find("input[name=puc_id]").val();		
	var tercero_id             		= $(Fila).find("input[name=tercero_id]").val();	
	var centro_de_costo_id     		= $(Fila).find("input[name=centro_de_costo_id]").val();	
	var sucursal_id     			= $(Fila).find("input[name=sucursal_id]").val();
	var area_id     				= $(Fila).find("input[name=area_id]").val();
	var departamento_id     		= $(Fila).find("input[name=departamento_id]").val();
	var unidad_negocio_id     		= $(Fila).find("input[name=unidad_negocio_id]").val();
	
	var desc_abono_factura      	= $(Fila).find("input[name=desc_abono_factura]").val();			
	var base_abono_factura      	= $(Fila).find("input[name=base_abono_factura]").val();	
	var deb_item_abono_factura  	= $(Fila).find("input[name=deb_item_abono_factura]").val();	
	var cre_item_abono_factura 	 	= $(Fila).find("input[name=cre_item_abono_factura]").val();	
	var valor_total  				= $(Fila).find("input[name=valor_total]").val();	
	var abonos 	 					= $(Fila).find("input[name=abonos]").val();	
	var checkProcesar          		= $(Fila).find("input[name=procesar]");		
	var saldo						= valor_total-abonos;
	
	base_abono_factura  = removeFormatCurrency(base_abono_factura);
	
	
	tercero_id             		= tercero_id.length         	> 0 ? tercero_id         	: 'NULL';
	centro_de_costo_id     		= centro_de_costo_id.length 		> 0 ? centro_de_costo_id 		: 'NULL';
	sucursal_id     		= sucursal_id.length 	   > 0 ? sucursal_id 		: 'NULL';
	area_id     			= area_id.length 			> 0 ? area_id 			: 'NULL';
	departamento_id     	= departamento_id.length 	> 0 ? departamento_id 	: 'NULL';
	unidad_negocio_id    	= unidad_negocio_id.length 	> 0 ? unidad_negocio_id 	: 'NULL';
   base_abono_factura			= base_abono_factura.length 	> 0 ? base_abono_factura 	: 'NULL';
	deb_item_abono_factura 		= deb_item_abono_factura.length > 0 ? deb_item_abono_factura: 'NULL';
	cre_item_abono_factura 		= cre_item_abono_factura.length > 0 ? cre_item_abono_factura: 'NULL';
	
			

	  var QueryString = "ACTIONCONTROLER=onclickSave&abono_factura_proveedor_id="+abono_factura_proveedor_id+"&item_abono_factura_id="+
	  item_abono_factura_id+"&puc_id="+puc_id+"&tercero_id="+tercero_id+"&centro_de_costo_id="+centro_de_costo_id+"&desc_abono_factura="+desc_abono_factura+
	  "&base_abono_factura="+base_abono_factura+"&deb_item_abono_factura="+deb_item_abono_factura+"&cre_item_abono_factura="+cre_item_abono_factura+"&relacion_abono_factura_id="+relacion_abono_factura_id+"&abono_factura_proveedor_id="+abono_factura_proveedor_id+"&sucursal_id="+sucursal_id+"&area_id="+area_id+"&departamento_id="+departamento_id+"&unidad_negocio_id="+unidad_negocio_id;			
	  		
	  $.ajax({
		   
	    url        : "DetallesClass.php",
	    data       : QueryString,
	    beforeSend : function(){
	      showDivLoading();				
	    },
	    success    : function(response){
						
          if( !isNaN(response)){
			checkProcesar.attr("checked","");	
			$(Fila).find("input[name=item_factura_id]").val(response);	
			if(parent.getTotalDebitoCredito) 
				parent.getTotalDebitoCredito(parent.document.getElementById("abono_factura_proveedor_id").value);
				var Table   = document.getElementById('tableDetalles');
				var numRows = (Table.rows.length);
				var newRow  = Table.insertRow(numRows);
	
				$(newRow).html($("#clon").html());
				$(newRow).find("input[name=puc]").focus();
				
				linkDetalles();				
				checkedAll();
				checkRow();
				autocompleteTercero();	
				autocompleteCentroCosto();
				autocompleteSucursal();
				autocompleteDepartamento();
				autocompleteUnidad();
				getvalorCalculadoBase();
				
				autocompleteCodigoContable();
				$(Celda).removeClass("focusSaveRow");		
				
			  
		    }else{
			  alertJquery(response);
		    }
			
 	    removeDivLoading();	
	    }
		  
	  });	 
  	
	
    }//fin de validaRequeridosDetalle	
  
}
function deleteDetalles(){

  $("input[name=procesar]:checked").each(function(){
 	 var tipo   		= $("#tipo").val();
	 
	     deleteDetalle(this);
	
  });

}

function deleteDetalle(obj){
	
	var row = obj.parentNode.parentNode;
	
    if(validaRequeridosDetalle(obj,row)){
				
    var Celda                  		= obj.parentNode;
    var Fila                   	  	= obj.parentNode.parentNode;	
    var item_abono_factura_id 	= $(Fila).find("input[name=item_abono_factura_id]").val();	
	var abono_factura_proveedor_id   		= $("#abono_factura_proveedor_id").val();
	
	var checkProcesar          		= $(Fila).find("input[name=procesar]");					
	
	
	if(parseInt(item_abono_factura_id) > 0 && parseInt(abono_factura_proveedor_id)){
		
	  var QueryString = "ACTIONCONTROLER=onclickDelete&abono_factura_proveedor_id="+abono_factura_proveedor_id+"&item_abono_factura_id="+item_abono_factura_id;	
	  		
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
			  parent.getTotalDebitoCredito(parent.document.getElementById("abono_factura_proveedor_id").value);
			  $(Fila).remove();
		    }else{
			  alertJquery(response);
		    }
			
 	    removeDivLoading();	
	    }
		  
	  });


	}else{
		alertJquery("Debe Seleccionar un pago Guardado.","Validacion");
	}
	 
  }
 		
}

function linkDetalles(){

	$("a[name=saveDetalle]").attr("href","javascript:void(0)");
	
	$("a[name=saveDetalle]").focus(function(){
		var celda = this.parentNode;
		$(celda).addClass("focusSaveRow");
    });
	
	$("a[name=saveDetalle]").blur(function(){
		var celda = this.parentNode;
		$(celda).removeClass("focusSaveRow");
    });
	
	$("a[name=saveDetalle]").click(function(){
		saveDetalleNuevo(this);
    });
	
}