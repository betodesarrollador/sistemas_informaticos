// JavaScript Document



$(document).ready(function(){

						   

    checkedAll();

	checkRow();

    autocompleteCodigoContable();

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



function autocompleteCodigoContable(){

	

	var tipo_bien_servicio_id = $("#tipo_bien_servicio_id").val();

	

	$("input[name=puc]").autocomplete("/sistemas_informaticos/framework/clases/ListaInteligente.php?consulta=cuentas_movimiento_servicio", {

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

			$(this.parentNode.parentNode).find("input[name=despuc_bien_servicio]").val($.trim(codigo_puc[2]));			



		}

		

	});

	
	

}


function getRequieresCuenta(puc_id,objTxt){
	
  var fila                   =$(objTxt).parent().parent();
  var QueryString            ="ACTIONCONTROLER=getRequieresCuenta&puc_id="+puc_id;
	
  $.ajax({
	url        : "DetallesClass.php",
	data       : QueryString,
	beforeSend : function (){
	  showDivLoading();	
    },
	success    : function(response){

      try{
		  
  	    var requiere              = $.parseJSON(response);
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
          fila.find("input[name=contra_bien_servicio]").attr("checked","true");
		  fila.find("input[name=contra_bien_servicio]").attr("disabled","");		
         							
        }else{
             fila.find("input[name=contra_bien_servicio]").attr("checked","");
			 fila.find("input[name=contra_bien_servicio]").attr("disabled","true");		
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

	

}





	

function saveDetalle(obj){

	

	var row = obj.parentNode.parentNode;

	

    if(validaRequeridosDetalle(obj,row)){

				

    var Celda                  	= obj.parentNode;

    var Fila                   	= obj.parentNode.parentNode;	

    var codpuc_bien_servicio_id	= $(Fila).find("input[name=codpuc_bien_servicio_id]").val();	

	var tipo_bien_servicio_id 	= $("#tipo_bien_servicio_id").val();

	var puc_id                 	= $(Fila).find("input[name=puc_id]").val();	

	var despuc_bien_servicio   	= $(Fila).find("input[name=despuc_bien_servicio]").val();		

	var natu_bien_servicio     	= $(Fila).find("select[name=natu_bien_servicio]").val();

	var contra_bien_servicio    = $(Fila).find("input[name=contra_bien_servicio]").is(":checked")?1:0;		

	var checkProcesar          	= $(Fila).find("input[name=procesar]");					

	



				

	if(!codpuc_bien_servicio_id.length > 0){

	

   	  codpuc_bien_servicio_id    = 'NULL';

		  

	  var QueryString = "ACTIONCONTROLER=onclickSave&tipo_bien_servicio_id="+tipo_bien_servicio_id+"&codpuc_bien_servicio_id="+

	  codpuc_bien_servicio_id+"&puc_id="+puc_id+"&natu_bien_servicio="+natu_bien_servicio+"&contra_bien_servicio="+contra_bien_servicio+"&despuc_bien_servicio="+despuc_bien_servicio;	



	

	  $.ajax({

		   

	    url        : "DetallesClass.php",

	    data       : QueryString,

	    beforeSend : function(){

	      showDivLoading();	

	    },

	    success    : function(response){

						

          if(!isNaN(response)){

			

            $(Fila).find("input[name=codpuc_bien_servicio_id]").val(response);	



            var Table   = document.getElementById('tableDetalles');

			var numRows = (Table.rows.length);

			var newRow  = Table.insertRow(numRows);



		    $(newRow).html($("#clon").html());

			$(newRow).find("input[name=puc]").focus();

			

						

   	        checkRow();

            autocompleteCodigoContable();

            linkImputaciones();	



			

			checkProcesar.attr("checked","");			

			$(Celda).removeClass("focusSaveRow");		

   	        removeDivLoading();

			parent.document.getElementById("refresh_QUERYGRID_tiposervicio").click();

			

		  }else{

			alertJquery(response);

		  }



	    }

		  

	  });

	  

	}else{



	  var QueryString = "ACTIONCONTROLER=onclickUpdate&tipo_bien_servicio_id="+tipo_bien_servicio_id+"&codpuc_bien_servicio_id="+

	  codpuc_bien_servicio_id+"&puc_id="+puc_id+"&natu_bien_servicio="+natu_bien_servicio+"&contra_bien_servicio="+contra_bien_servicio+"&despuc_bien_servicio="+despuc_bien_servicio;	

	  		

	  $.ajax({

		   

	    url        : "DetallesClass.php",

	    data       : QueryString,

	    beforeSend : function(){

	      showDivLoading();					

	    },

	    success    : function(response){

			

          if( $.trim(response) == 'true'){

			checkProcesar.attr("checked","");					

			$(Fila).find("a[name=saveDetalles]").parent().addClass("focusSaveRow");

			parent.document.getElementById("refresh_QUERYGRID_tiposervicio").click();

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



function deleteDetalle(obj){



    var Celda                   = obj.parentNode;

    var Fila                    = obj.parentNode.parentNode;

    var codpuc_bien_servicio_id	= $(Fila).find("input[name=codpuc_bien_servicio_id]").val();	

    var QueryString             = "ACTIONCONTROLER=onclickDelete&codpuc_bien_servicio_id="+codpuc_bien_servicio_id;			

	

	if(codpuc_bien_servicio_id.length > 0){

		

	  $.ajax({

		   

	    url        : "DetallesClass.php",

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





