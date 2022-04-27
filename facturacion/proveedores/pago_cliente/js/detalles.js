// JavaScript Document



$(document).ready(function(){

						   

    checkedAll();

	checkRow();
	
	linkImputaciones();

	autocompleteCodigoContable();
	
    autocompleteTercero();

	autocompleteCentroCosto();

	getvalorCalculadoBase();

	

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



function autocompleteCodigoContable(){

	

	
	$("input[name=puc]").autocomplete("/rotterdan/framework/clases/ListaInteligente.php?consulta=cuentas_movimiento", {

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

	

  var fila                   	=$(objTxt).parent().parent();

  var abono_factura_id=$("#abono_factura_id").val();

  var QueryString            	="ACTIONCONTROLER=getRequieresCuenta&puc_id="+puc_id+'&abono_factura_id='+abono_factura_id;

	

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

        fila.find("input[name=base_abono]").val("");											  				

	

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

          fila.find("input[name=base_abono]").removeClass("no_requerido");

          fila.find("input[name=base_abono]").attr("readonly","");		  

          fila.find("input[name=base_abono]").parent().removeClass("no_requerido");			

          fila.find("input[name=base_abono]").addClass("required");					  

          /*fila.find("input[name=deb_item_abono]").attr("readonly","true");					  

          fila.find("input[name=cre_item_abono]").attr("readonly","true");	*/				  		  	  

        }else{

            fila.find("input[name=base_abono]").addClass("no_requerido");

            fila.find("input[name=base_abono]").attr("readonly","true");		  			

            fila.find("input[name=base_abono]").parent().addClass("no_requerido");			

            fila.find("input[name=base_abono]").removeClass("required");						

            fila.find("input[name=deb_item_abono]").attr("readonly","");					  

            fila.find("input[name=cre_item_abono]").attr("readonly","");			

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



  $("input[name=base_abono]").blur(function(){



    if($(this).is(".required")){



      var objBase                	 = this;

      var puc_id                 	 = $(this).parent().parent().find("input[name=puc_id]").val();

      var base_abono 	 	 =removeFormatCurrency( $(this).parent().parent().find("input[name=base_abono]").val());	  

	  var abono_factura_proveedor_id = $("#abono_factura_proveedor_id").val();

	//  base_abono = removeFormatCurrency(base_abono);

      var QueryString            ="ACTIONCONTROLER=getvalorCalculadoBase&puc_id="+puc_id+'&abono_factura_proveedor_id='+

	                               abono_factura_proveedor_id+"&base_abono="+base_abono;

	  

	  

      $.ajax({

     	url     : "DetallesClass.php",

		data    : QueryString,

		success : function(response){

			

          try{

			  

           var datosCalculo = $.parseJSON(response);

		   

		   if($.trim(datosCalculo['naturaleza']) == 'D'){

			  $(objBase).parent().parent().find("input[name=deb_item_abono]").val(datosCalculo['valor']);

		      $(objBase).parent().parent().find("input[name=cre_item_abono]").val("");			   			  

           }else{

			    $(objBase).parent().parent().find("input[name=deb_item_abono]").val("");			   

			    $(objBase).parent().parent().find("input[name=cre_item_abono]").val(datosCalculo['valor']);			   

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

    var item_abono_id 		= $(Fila).find("input[name=item_abono_id]").val();	

	var abono_factura_id  	= $("#abono_factura_id").val();

	var puc_id                 		= $(Fila).find("input[name=puc_id]").val();		

	var tercero_id             		= $(Fila).find("input[name=tercero_id]").val();	

	var centro_de_costo_id     		= $(Fila).find("input[name=centro_de_costo_id]").val();	

	var desc_abono      	= $(Fila).find("input[name=desc_abono]").val();			

	var base_abono      	= $(Fila).find("input[name=base_abono]").val();	

	var deb_item_abono  	= $(Fila).find("input[name=deb_item_abono]").val();	

	var cre_item_abono 	 	= $(Fila).find("input[name=cre_item_abono]").val();	

	var valor_total  				= $(Fila).find("input[name=valor_total]").val();	

	var abonos 	 					= $(Fila).find("input[name=abonos]").val();	

	var checkProcesar          		= $(Fila).find("input[name=procesar]");		

	var saldo						= parseInt(valor_total)-parseInt(abonos);

	
    item_abono_id             		= item_abono_id.length         	> 0 ? item_abono_id         	: 'NULL';

	tercero_id             		= tercero_id.length         	> 0 ? tercero_id         	: 'NULL';

	centro_de_costo_id     		= centro_de_costo_id.length 	> 0 ? centro_de_costo_id 	: 'NULL';

	base_abono			= base_abono.length 	> 0 ? base_abono 	: 'NULL';

	deb_item_abono 		= deb_item_abono.length > 0 ? deb_item_abono: 'NULL';

	cre_item_abono 		= cre_item_abono.length > 0 ? cre_item_abono: 'NULL';

	


		
	if(item_abono_id == 'NULL'){



	  var QueryString = "ACTIONCONTROLER=onclickSave&abono_factura_id="+abono_factura_id+"&puc_id="+puc_id+"&tercero_id="+tercero_id+"&centro_de_costo_id="+centro_de_costo_id+"&desc_abono="+desc_abono+"&deb_item_abono="+deb_item_abono+"&cre_item_abono="+cre_item_abono+"&base_abono="+base_abono;	

	  		

	  $.ajax({

		   

	    url        : "DetallesClass.php",

	    data       : QueryString,

	    beforeSend : function(){

	      showDivLoading();				

	    },

	    success    : function(response){

			

          if(response.length>0){

			checkProcesar.attr("checked","");					
			$(Fila).find("input[name=item_abono_id]").val(response);
			if(parent.getTotalDebitoCredito) 

			  parent.getTotalDebitoCredito(parent.document.getElementById("abono_factura_id").value);
			  
			    var Table   = document.getElementById('tableDetalles');

				var numRows = (Table.rows.length);
	
				var newRow  = Table.insertRow(numRows);
	
	
	
				$(newRow).html($("#clon").html());
	
				$(newRow).find("input[name=puc]").focus();
				
				 checkedAll();

					checkRow();
					
					linkImputaciones();
				
					autocompleteCodigoContable();
					
					autocompleteTercero();
				
					autocompleteCentroCosto();
				
					getvalorCalculadoBase();

		    }else{

			  alertJquery(response);

		    }

			

 	    removeDivLoading();	

	    }

		  

	  });

	}else{
		
		
		
		  var QueryString = "ACTIONCONTROLER=onclickUpdate&abono_factura_id="+abono_factura_id+"&item_abono_id="+

	  item_abono_id+"&puc_id="+puc_id+"&tercero_id="+tercero_id+"&centro_de_costo_id="+centro_de_costo_id+"&desc_abono="+desc_abono+

	  "&base_abono="+base_abono+"&deb_item_abono="+deb_item_abono+"&cre_item_abono="+cre_item_abono;	

	  		

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

			  parent.getTotalDebitoCredito(parent.document.getElementById("abono_factura_id").value);
			  
			  
          


		    }else{

			  alertJquery(response);

		    }

			

 	    removeDivLoading();	

	    }

		  

	  });
		
	}

	

	 

  }else
  {
	  alertJquery('Debe ingresar los requeridos');

  }

 		

}


function linkImputaciones(){



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

														

       saveDetalle(this);



    });	

	

}



function saveDetalles(){



  $("input[name=procesar]:checked").each(function(){

 

     saveDetalle(this);



  });



}

function deleteDetallePuc(){

	

  $("input[name=procesar]:checked").each(function(){

 

     deleteImputacion(this);



  });
  
}

function deleteImputacion(obj){



    var Celda                   = obj.parentNode;

    var Fila                    = obj.parentNode.parentNode;

    var item_abono_id	= $(Fila).find("input[name=item_abono_id]").val();	

    var QueryString             = "ACTIONCONTROLER=onclickDelete&item_abono_id="+item_abono_id;			

	

	if(item_abono_id.length > 0){

		

	  $.ajax({

		   

	    url        : "DetallesClass.php",

	    data       : QueryString,

	    beforeSend : function(){

	      $(parent.document.getElementById('loading')).html("<img src='/rotterdan/framework/media/images/grid/mtg-loader.gif' />")  

	    },

	    success    : function(response){



          if( $.trim(response) == 'true'){

			

			var numRow = (Fila.rowIndex - 1);

			Fila.parentNode.deleteRow(numRow);

			

            if(parent.getTotalDebitoCredito){

				parent.getTotalDebitoCredito(parent.document.getElementById('encabezado_registro_id').value);

			}

			

		  }else{

			alertJquery(response);

		   }



        $(parent.document.getElementById('loading')).html("");

	    }

		  

      });

	  

	}else{

		alertJquery('No puede eliminar elementos que no han sido guardados');

        $(Fila).find("input[name=procesar]").attr("checked","");				

	  }

	

}






function checkRow(){

	

	$("input[type=text]").keyup(function(event){

       var Tecla = event.keyCode;

	   var Fila  = this.parentNode.parentNode;

	   

       $(Fila).find("input[name=procesar]").attr("checked","true");

	   

    });

	

}





