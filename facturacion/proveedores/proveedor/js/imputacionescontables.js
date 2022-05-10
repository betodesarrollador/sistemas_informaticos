// JavaScript Document



$(document).ready(function(){

						   

    checkedAll();

	checkRow();

    autocompleteCodigoContable();

    autocompleteTercero();	

	autocompleteCentroCosto();
	
	autocompleteArea();
	
	autocompleteSucursal();
	
	autocompleteDepartamento();
			
	autocompleteUnidad();

    linkImputaciones();

	getvalorCalculadoBase();

	verificaEstadoEncabezadoContable();

	

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

    

    $("input[name=debito],input[name=credito]").keypress(function(e){

        

        var code = (e.keyCode ? e.keyCode : e.which);

        

        if(code == 9) return true; 

                 

        var row     = this.parentNode.parentNode;

        var actual  = this.name;

        var debito  = removeFormatCurrency($(row).find("input[name=debito]").val());

        var credito = removeFormatCurrency($(row).find("input[name=credito]").val());

        

        if(actual == 'debito'){                        

          if(credito > 0){

            return false;

          }            

        }else if(actual == 'credito'){            

          if(debito > 0){

             return false;

          }

        }         

         

        

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

			

            $(this.parentNode.parentNode).find("input[name!=puc]&&input[name!=centro_de_costo]&&input[name!=tercero]&&input[name!=sucursal]&&input[type=text]").each(function(){

               if(this.readOnly == false && txtNext == false){

				   this.focus();

				   txtNext = true;

			   }

			   

            });			

		}

	});

	

}


/*function autocompleteCentroCosto(){

	

	$("input[name=centro_de_costo]").autocomplete("/rotterdan/framework/clases/ListaInteligente.php?consulta=centro_costo", {

		width: 260,

		selectFirst: true

	});

	

	$("input[name=centro_de_costo]").result(function(event, data, formatted) {				   

		if (data){

			var centro_costo = data[0].split("-");

			$(this).val($.trim(centro_costo));

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
*/

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

			

            $(this.parentNode.parentNode).find("input[name!=puc]&&input[name!=tercero]&&input[name!=departamento]&&input[name!=area]&&input[name!=centro_de_costo]&&input[name!=sucursal]&&input[type=text]").each(function(){

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

			

            $(this.parentNode.parentNode).find("input[name!=puc]&&input[name!=tercero]&&input[name!=centro_de_costo]&&input[name!=sucursal]&&input[name!=departamento]&&input[type=text]").each(function(){

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

			

            $(this.parentNode.parentNode).find("input[name!=puc]&&input[name!=tercero]&&input[name!=centro_de_costo]&&input[name!=sucursal]&&input[name!=area]&&input[name!=departamento]&&input[name!=unidadnegocio]&&input[type=text]").each(function(){

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

  var encabezado_registro_id =$("#encabezado_registro_id").val();

  var QueryString            ="ACTIONCONTROLER=getRequieresCuenta&puc_id="+puc_id+'&encabezado_registro_id='+encabezado_registro_id;

	

  $.ajax({

	url        : "ImputacionesContablesClass.php",

	data       : QueryString,

	beforeSend : function (){

	  $(parent.document.getElementById("loading")).html("<img src='/rotterdan/framework/media/images/grid/mtg-loader.gif' />");

    },

	success    : function(response){



      try{

		  

  	    var requiere              = $.parseJSON(response);

	    var requiere_tercero      = requiere['requiere_tercero'];

	    var requiere_centro_costo = requiere['requiere_centro_costo'];	
		
		 var requiere_sucursal    = requiere['requiere_sucursal'];	

	    var requiere_base          = requiere['requiere_base'];
		
		var requiere_area          = requiere['requiere_area'];
		
		var requiere_departamento          = requiere['requiere_departamento'];
		
		var requiere_unidad          = requiere['requiere_unidad'];

		

        fila.find("input[name=tercero]").val("");			

        fila.find("input[name=tercero_id]").val("");											  		

        fila.find("input[name=centro_de_costo]").val("");			

        fila.find("input[name=centro_de_costo_id]").val("");											  		

        fila.find("input[name=base]").val("");	
		
		fila.find("input[name=area]").val("");	
		
		fila.find("input[name=departamento]").val("");	
		
		fila.find("input[name=unidad]").val("");	

	

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

          fila.find("input[name=base]").removeClass("no_requerido");

          fila.find("input[name=base]").attr("readonly","");		  

          fila.find("input[name=base]").parent().removeClass("no_requerido");			

          fila.find("input[name=base]").addClass("required");					  

          //fila.find("input[name=debito]").attr("readonly","true");					  

          //fila.find("input[name=credito]").attr("readonly","true");					  		  	  

        }else{

            fila.find("input[name=base]").addClass("no_requerido");

            fila.find("input[name=base]").attr("readonly","true");		  			

            fila.find("input[name=base]").parent().addClass("no_requerido");			

            fila.find("input[name=base]").removeClass("required");						

            //fila.find("input[name=debito]").attr("readonly","");					  

            //fila.find("input[name=credito]").attr("readonly","");			

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



		$(parent.document.getElementById("loading")).html("");		  

		

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



  $("input[name=base]").blur(function(){



    if($(this).is(".required")){



      var objBase                = this;

      var puc_id                 = $(this).parent().parent().find("input[name=puc_id]").val();

      var base                   = $(this).parent().parent().find("input[name=base]").val();	  

	  var encabezado_registro_id = $("#encabezado_registro_id").val();

	  

      var QueryString            ="ACTIONCONTROLER=getvalorCalculadoBase&puc_id="+puc_id+'&encabezado_registro_id='+

	                               encabezado_registro_id+"&base="+base;	  

	  

      $.ajax({

     	url     : "ImputacionesContablesClass.php",

		data    : QueryString,

		success : function(response){

			

          try{

			  

           var datosCalculo = $.parseJSON(response);

		   

		   if($.trim(datosCalculo['naturaleza']) == 'D'){

			  $(objBase).parent().parent().find("input[name=debito]").val(datosCalculo['valor']);

		      $(objBase).parent().parent().find("input[name=credito]").val("");			   			  

           }else{

			    $(objBase).parent().parent().find("input[name=debito]").val("");			   

			    $(objBase).parent().parent().find("input[name=credito]").val(datosCalculo['valor']);			   

			  }

		   

		  }catch(e){

			 }



        }

	  });



    }



  });

  

}



function linkImputaciones(){



	$("a[name=saveImputacion]").attr("href","javascript:void(0)");

	

	$("a[name=saveImputacion]").focus(function(){

      var celda = this.parentNode;

      $(celda).addClass("focusSaveRow");	  

    });

	

	$("a[name=saveImputacion]").blur(function(){

      var celda = this.parentNode;

      $(celda).removeClass("focusSaveRow");	  

    });	

	

	$("a[name=saveImputacion]").click(function(){

														

       saveImputacion(this);



    });	

	

}





	

function saveImputacion(obj){

	

	var row = obj.parentNode.parentNode;

	

    if(validaRequeridosDetalle(obj,row)){

				

    var Celda                  = obj.parentNode;

    var Fila                   = obj.parentNode.parentNode;	

    var imputacion_contable_id = $(Fila).find("input[name=imputacion_contable_id]").val();	

	var encabezado_registro_id = $("#encabezado_registro_id").val();

	var puc_id                 = $(Fila).find("input[name=puc_id]").val();		

	var tercero_id             = $(Fila).find("input[name=tercero_id]").val();	

	var centro_de_costo_id     = $(Fila).find("input[name=centro_de_costo_id]").val();
	
	var sucursal_id     = $(Fila).find("input[name=sucursal_id]").val();
	
	var area_id     = $(Fila).find("input[name=area_id]").val();
	
	var departamento_id     = $(Fila).find("input[name=departamento_id]").val();
	
	var unidad_negocio_id     = $(Fila).find("input[name=unidad_negocio_id]").val();

	var descripcion            = $(Fila).find("input[name=descripcion]").val();			

	var base                   = $(Fila).find("input[name=base]").val();	

	var debito                 = $(Fila).find("input[name=debito]").val();	

	var credito                = $(Fila).find("input[name=credito]").val();	

	var checkProcesar          = $(Fila).find("input[name=procesar]");					

	

	tercero_id             = tercero_id.length         > 0 ? tercero_id         : 'NULL';

	centro_de_costo_id     = centro_de_costo_id.length > 0 ? centro_de_costo_id : 'NULL';
	
	sucursal_id     		= sucursal_id.length 	   > 0 ? sucursal_id 		: 'NULL';
	
	area_id     			= area_id.length 			> 0 ? area_id 			: 'NULL';
	
	departamento_id     	= departamento_id.length 	> 0 ? departamento_id 	: 'NULL';
	
	unidad_negocio_id    	= unidad_negocio_id.length 	> 0 ? unidad_negocio_id 	: 'NULL';

	base                   = base.length               > 0 ? base               : 'NULL';

	debito                 = debito.length             > 0 ? debito             : 'NULL';

	credito                = credito.length            > 0 ? credito            : 'NULL';

	var debito1= debito.replace(".", "");

	var credito1= credito.replace(".", "");	

	

	debito1= debito1.replace(",", ".");

	credito1= credito1.replace(",", ".");	

	

	if(parseFloat(debito1) > 0 || parseFloat(credito1)){

				

	if(!imputacion_contable_id.length > 0){

	

   	  imputacion_contable_id    = 'NULL';

		  

	  var QueryString = "ACTIONCONTROLER=onclickSave&encabezado_registro_id="+encabezado_registro_id+"&imputacion_contable_id="+

	  imputacion_contable_id+"&puc_id="+puc_id+"&tercero_id="+tercero_id+"&centro_de_costo_id="+centro_de_costo_id+"&descripcion="+descripcion

	  +"&base="+base+"&debito="+debito+"&credito="+credito+"&sucursal_id="+sucursal_id+"&area_id="+area_id+"&departamento_id="+departamento_id+"&unidad_negocio_id="+unidad_negocio_id;	

	  

	

	  $.ajax({

		   

	    url        : "ImputacionesContablesClass.php",

	    data       : QueryString,

	    beforeSend : function(){

	      $(parent.document.getElementById('loading')).html("<img src='/rotterdan/framework/media/images/grid/mtg-loader.gif' />");

	    },

	    success    : function(response){

						

          if(!isNaN(response)){

			

            $(Fila).find("input[name=imputacion_contable_id]").val(response);	



            var Table   = document.getElementById('tableImputaciones');

			var numRows = (Table.rows.length);

			var newRow  = Table.insertRow(numRows);



		    $(newRow).html($("#clon").html());

			$(newRow).find("input[name=puc]").focus();

			

            if(parent.getTotalDebitoCredito){

				parent.getTotalDebitoCredito(parent.document.getElementById('encabezado_registro_id').value);

			}

						

   	        checkRow();

            autocompleteCodigoContable();

            autocompleteTercero();	

	        autocompleteCentroCosto();
			
			autocompleteArea();
			
			autocompleteSucursal();
			
			autocompleteDepartamento();
			
			autocompleteUnidad();

            linkImputaciones();	

			getvalorCalculadoBase();



			

			checkProcesar.attr("checked","");			

			$(Celda).removeClass("focusSaveRow");		

   	        $(parent.document.getElementById('loading')).html("");

			

			

		  }else{

			alertJquery(response);

		    }

	    }		  

	  });

	  

	}else{



	  var QueryString = "ACTIONCONTROLER=onclickUpdate&encabezado_registro_id="+encabezado_registro_id+"&imputacion_contable_id="+

	  imputacion_contable_id+"&puc_id="+puc_id+"&tercero_id="+tercero_id+"&centro_de_costo_id="+centro_de_costo_id+"&descripcion="+descripcion+

	  "&base="+base+"&debito="+debito+"&credito="+credito+"&sucursal_id="+sucursal_id+"&area_id="+area_id+"&departamento_id="+departamento_id+"&unidad_negocio_id="+unidad_negocio_id;		

	  		

	  $.ajax({

		   

	    url        : "ImputacionesContablesClass.php",

	    data       : QueryString,

	    beforeSend : function(){

	      $(parent.document.getElementById('loading')).html("<img src='/rotterdan/framework/media/images/grid/mtg-loader.gif' />");				

	    },

	    success    : function(response){

			

          if( $.trim(response) == 'true'){

			checkProcesar.attr("checked","");					

			$(Fila).find("a[name=saveImputacion]").parent().addClass("focusSaveRow");

			if(parent.getTotalDebitoCredito) 

			  parent.getTotalDebitoCredito(parent.document.getElementById("encabezado_registro_id").value);

		  }else{

			alertJquery(response);

		    }

			

 	    $(parent.document.getElementById('loading')).html("");

	    }

		  

	  });





	 }

	 

	}else{

		alertJquery("Debe Ingresar un valor","Validacion Debito / Credito");

	  }

	 

  }

 		

}



function deleteImputacion(obj){



    var Celda                   = obj.parentNode;

    var Fila                    = obj.parentNode.parentNode;

    var imputacion_contable_id	= $(Fila).find("input[name=imputacion_contable_id]").val();	

    var QueryString             = "ACTIONCONTROLER=onclickDelete&imputacion_contable_id="+imputacion_contable_id;			

	

	if(imputacion_contable_id.length > 0){

		

	  $.ajax({

		   

	    url        : "ImputacionesContablesClass.php",

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



function saveImputacionesContables(){



  $("input[name=procesar]:checked").each(function(){

 

     saveImputacion(this);



  });



}



function deleteImputacionesContables(){

	

  $("input[name=procesar]:checked").each(function(){

 

     deleteImputacion(this);



  });



}	





function checkRow(){

	

	$("input[type=text]").keyup(function(event){

										 

       var Tecla = event.keyCode;

	   var Fila  = this.parentNode.parentNode;

	   

       $(Fila).find("input[name=procesar]").attr("checked","true");

	   

    });

	

}





function verificaEstadoEncabezadoContable(){

	

	var encabezado_registro_id = $("#encabezado_registro_id").val();

	

	if(parseInt(encabezado_registro_id) > 0){



	 var QueryString = "ACTIONCONTROLER=getEstadoEncabezadoRegistro&encabezado_registro_id="+encabezado_registro_id;

	 

	 $.ajax({

       url        : "MovimientosContablesClass.php",

	   data       : QueryString,

	   beforeSend : function(){

		 showDivLoading();

	   },

	   success : function(response){

		   	   

		   var estado = response;

		   

		   if($.trim(estado) == 'A'){

             $("#titleSave").css("display","none");			   

             $("*[name=saveImputacion],*[name=procesar],#checkedAll").parent().css("display","none");

		   }else{

               $("#titleSave").css("display","");			   			   

               $("*[name=saveImputacion],*[name=procesar],#checkedAll").parent().css("display","");

			 }  

			 

	     removeDivLoading();			 

	     }

		 

	 });

	 

	}

	 

}