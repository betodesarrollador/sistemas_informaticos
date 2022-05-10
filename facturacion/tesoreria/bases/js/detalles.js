// JavaScript Document

$(document).ready(function(){
						   
    checkedAll();
	checkRow();
    autocompleteCodigoContable();
    autocompleteTercero();	
	autocompleteCentroCosto();	
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
	
	var tipo_bien_servicio_teso_id = $("#tipo_bien_servicio_teso_id").val();
	
	$("input[name=puc]").autocomplete("/envipack/framework/clases/ListaInteligente.php?consulta=cuentas_movimiento_servicio", {
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
	
	$("input[name=tercero]").autocomplete("/envipack/framework/clases/ListaInteligente.php?consulta=tercero", {
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
	
	$("input[name=centro_de_costo]").autocomplete("/envipack/framework/clases/ListaInteligente.php?consulta=centro_costo", {
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
				
    var Celda                  			= obj.parentNode;
    var Fila                   			= obj.parentNode.parentNode;	
    var codpuc_bien_servicio_teso_id	= $(Fila).find("input[name=codpuc_bien_servicio_teso_id]").val();	
	var tipo_bien_servicio_teso_id 		= $("#tipo_bien_servicio_teso_id").val();
	var puc_id                 			= $(Fila).find("input[name=puc_id]").val();	
	var natu_bien_servicio_teso     	= $(Fila).find("select[name=natu_bien_servicio_teso]").val();
	var contra_bien_servicio_teso    	= $(Fila).find("input[name=contra_bien_servicio_teso]").is(":checked")?1:0;		
	var tercero_id             			= $(Fila).find("input[name=tercero_id]").val();	
	var centro_de_costo_id     			= $(Fila).find("input[name=centro_de_costo_id]").val();	
	var base                   			= $(Fila).find("input[name=base]").val();	
	var checkProcesar          			= $(Fila).find("input[name=procesar]");		
				
	if(!codpuc_bien_servicio_teso_id.length > 0){
	
   	  codpuc_bien_servicio_teso_id    = 'NULL';
		  
	  var QueryString = "ACTIONCONTROLER=onclickSave&tipo_bien_servicio_teso_id="+tipo_bien_servicio_teso_id+"&codpuc_bien_servicio_teso_id="+
	  codpuc_bien_servicio_teso_id+"&puc_id="+puc_id+"&natu_bien_servicio_teso="+natu_bien_servicio_teso+"&contra_bien_servicio_teso="+
	  contra_bien_servicio_teso+"&tercero_id="+tercero_id+"&centro_de_costo_id="+centro_de_costo_id;	

	  $.ajax({
		   
	    url        : "DetallesClass.php",
	    data       : QueryString,
	    beforeSend : function(){
	      showDivLoading();	
	    },
	    success    : function(response){
						
          if(!isNaN(response)){
			
            $(Fila).find("input[name=codpuc_bien_servicio_teso_id]").val(response);	

            var Table   = document.getElementById('tableDetalles');
			var numRows = (Table.rows.length);
			var newRow  = Table.insertRow(numRows);

		    $(newRow).html($("#clon").html());
			$(newRow).find("input[name=puc]").focus();			
						
   	        checkRow();
            autocompleteCodigoContable();
            linkImputaciones();	
            autocompleteTercero();	
	        autocompleteCentroCosto();			
			
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

	  var QueryString = "ACTIONCONTROLER=onclickUpdate&tipo_bien_servicio_teso_id="+tipo_bien_servicio_teso_id+"&codpuc_bien_servicio_teso_id="+
	  codpuc_bien_servicio_teso_id+"&puc_id="+puc_id+"&natu_bien_servicio_teso="+natu_bien_servicio_teso+"&contra_bien_servicio_teso="+
	  contra_bien_servicio_teso+"&tercero_id="+tercero_id+"&centro_de_costo_id="+centro_de_costo_id;	

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

    var Celda                   		 = obj.parentNode;
    var Fila                   			 = obj.parentNode.parentNode;
    var codpuc_bien_servicio_teso_id	 = $(Fila).find("input[name=codpuc_bien_servicio_teso_id]").val();	
    var QueryString             		 = "ACTIONCONTROLER=onclickDelete&codpuc_bien_servicio_teso_id="+codpuc_bien_servicio_teso_id;			
	
	if(codpuc_bien_servicio_teso_id.length > 0){
		
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

function getRequieresCuenta(puc_id,objTxt){

  var fila			=$(objTxt).parent().parent();
  var puc_id        = $(fila).find("input[name=puc_id]").val();	
  var QueryString	="ACTIONCONTROLER=getRequieresCuenta&puc_id="+puc_id;
  
  $.ajax({
	url        : "DetallesClass.php",
	data       : QueryString,
	beforeSend : function (){
	  $(parent.document.getElementById("loading")).html("<img src='/envipack/framework/media/images/grid/mtg-loader.gif' />");
    },
	success    : function(response){

      try{
		  
  	    var requiere              = $.parseJSON(response);
 		var requiere_tercero      = requiere['requiere_tercero'];
		var requiere_centro_costo = requiere['requiere_centro_costo'];		
	    var requiere_base         = requiere['requiere_base'];
		var tercero_manual		  = parent.document.getElementById('tercero_manual').value;
		var centro_manual		  = parent.document.getElementById('centro_manual').value;

		fila.find("input[name=tercero]").val("");			
        fila.find("input[name=tercero_id]").val("");											  		
        fila.find("input[name=centro_de_costo]").val("");			
        fila.find("input[name=centro_de_costo_id]").val("");											  		
        fila.find("input[name=base]").val("");											  				
	
		if($.trim(requiere_tercero) == "true" && tercero_manual == 0){
          fila.find("input[name=tercero]").removeClass("no_requerido");
          fila.find("input[name=tercero]").attr("readonly","");		  
          fila.find("input[name=tercero]").parent().removeClass("no_requerido");			
          fila.find("input[name=tercero_id]").addClass("required");									
		}else if($.trim(requiere_tercero) == "true" && tercero_manual == 1){
            fila.find("input[name=tercero]").addClass("no_requerido");
            fila.find("input[name=tercero]").attr("readonly","true");		  			
            fila.find("input[name=tercero]").parent().addClass("no_requerido");			
            fila.find("input[name=tercero_id]").removeClass("required");								
		}else{
            fila.find("input[name=tercero]").addClass("no_requerido");
            fila.find("input[name=tercero]").attr("readonly","true");		  			
            fila.find("input[name=tercero]").parent().addClass("no_requerido");			
            fila.find("input[name=tercero_id]").removeClass("required");												
		  }

		if($.trim(requiere_centro_costo) == "true" && centro_manual == 0){
          fila.find("input[name=centro_de_costo]").removeClass("no_requerido");
          fila.find("input[name=centro_de_costo]").attr("readonly","");		  
          fila.find("input[name=centro_de_costo]").parent().removeClass("no_requerido");			
          fila.find("input[name=centro_de_costo_id]").addClass("required");									
        }else if($.trim(requiere_tercero) == "true" && centro_manual == 1){
            fila.find("input[name=tercero]").addClass("no_requerido");
            fila.find("input[name=tercero]").attr("readonly","true");		  			
            fila.find("input[name=tercero]").parent().addClass("no_requerido");			
            fila.find("input[name=tercero_id]").removeClass("required");								
		}else{
            fila.find("input[name=centro_de_costo]").addClass("no_requerido");
            fila.find("input[name=centro_de_costo]").attr("readonly","true");		  			
            fila.find("input[name=centro_de_costo]").parent().addClass("no_requerido");			
            fila.find("input[name=centro_de_costo_id]").removeClass("required");												
		  }
		  
		if($.trim(requiere_base) == "true"){
          fila.find("input[name=base]").removeClass("no_requerido");
          fila.find("input[name=base]").attr("readonly","");		  
          fila.find("input[name=base]").parent().removeClass("no_requerido");			
          fila.find("input[name=base]").addClass("required");					  		  	  
        }else{
            fila.find("input[name=base]").addClass("no_requerido");
            fila.find("input[name=base]").attr("readonly","true");		  			
            fila.find("input[name=base]").parent().addClass("no_requerido");			
            fila.find("input[name=base]").removeClass("required");		
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
