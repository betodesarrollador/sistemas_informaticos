// JavaScript Document
function setDataFormWithResponse(){

  var parametros  = new Array({campos:"tercero_id",valores:$('#tercero_id').val()});
  var forma       = document.forms[0];
  var controlador = 'ConductoresClass.php';

  FindRow(parametros,forma,controlador,null,function(resp){

    $("#carga_por_primera_vez").trigger("change");

    if($('#guardar'))    $('#guardar').attr("disabled","true");
    if($('#actualizar')) $('#actualizar').attr("disabled","");
    if($('#borrar'))     $('#borrar').attr("disabled","");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");
	
  });
  
}

var formSubmitted = false;

function ConductoresOnSaveUpdate(formulario,resp){
	
	
	if($.trim(resp) == 'true'){		
	
	 if(!formSubmitted){
		
	  var QueryString = FormSerialize(formulario)+"&ACTIONCONTROLER=sendConductorMintransporte";
	  	
	  $.ajax({
		url        : "ConductoresClass.php?rand="+Math.random(),	 
		data       : QueryString,
		beforeSend : function(){
			window.scrollTo(0,0);
			showDivMessage("Reportando al Ministerio de Transporte<br>Por Favor Espere..","../../../framework/media/images/general/cable_data_transfer_md_wht.gif");
			formSubmitted = true;
		},
		success    : function(resp){			
					
			removeDivMessage();
			
			showDivMessage(resp,"../../../framework/media/images/general/cable_data_transfer_md_wht.gif");			
			formSubmitted = false;
					
			Reset(formulario);
			clearFind();	
			
			$("#refresh_QUERYGRID_conductores").click();
			$("#tipo_persona_id").val("1");	
			$("#estado").val("B");		
			document.getElementById('carga_por_primera_vez').value    = 0;  	
			
			$("#empresa_cargo1").addClass("obligatorio");
			$("#telefono_empresa_cargo1").addClass("obligatorio");
			$("#ciudad_empresa_cargo1_txt,#ciudad_empresa_cargo1_txt_hidden").addClass("obligatorio");
			$("#nombre_persona_atendio1").addClass("obligatorio");
			$("#nombre_persona_atendio1").addClass("obligatorio");
			$("#cargo_persona_atendio1").addClass("obligatorio");
			$("#tiempo_lleva_cargando1").addClass("obligatorio");
			$("#rutas1").addClass("obligatorio");
			$("#tipo_mercancia1").addClass("obligatorio");
			$("#viajes_realizados1").addClass("obligatorio");		
			
			if($('#guardar'))    $('#guardar').attr("disabled","true");
			if($('#actualizar')) $('#actualizar').attr("disabled","");
			if($('#borrar'))     $('#borrar').attr("disabled","");
			if($('#limpiar'))    $('#limpiar').attr("disabled","");	
						
		}
		
	  });
	
	 }
	
	}else{
		alertJquery(resp);
	 }
	
}

function ConductoresOnDelete(formulario,resp){
    
    Reset(formulario);
    clearFind();
    $("#refresh_QUERYGRID_conductores").click();
    $("#tipo_persona_id").val("1");	
    $("#estado").val("B");	
	document.getElementById('carga_por_primera_vez').value    = 0;  	
	
    $("#empresa_cargo1").addClass("obligatorio");
	$("#telefono_empresa_cargo1").addClass("obligatorio");
	$("#ciudad_empresa_cargo1_txt,#ciudad_empresa_cargo1_txt_hidden").addClass("obligatorio");
	$("#nombre_persona_atendio1").addClass("obligatorio");
	$("#nombre_persona_atendio1").addClass("obligatorio");
	$("#cargo_persona_atendio1").addClass("obligatorio");
	$("#tiempo_lleva_cargando1").addClass("obligatorio");
	$("#rutas1").addClass("obligatorio");
	$("#tipo_mercancia1").addClass("obligatorio");
	$("#viajes_realizados1").addClass("obligatorio");		
    
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");
   	
    alertJquery(resp);  
}

function ConductoresOnClear(){
	
    clearFind();
    $("#tipo_persona_id").val("1");	
    $("#estado").val("B");	
    $("#numero_hijos,#personas_a_cargo").val("0");
    $("#telefono_arrendatario,#arrendatario").removeClass("obligatorio");	
	document.getElementById('carga_por_primera_vez').value    = 0;  	
	document.getElementById('telefono_arrendatario').disabled = false;  
	document.getElementById('arrendatario').disabled          = false; 	
	
	$("#empresa_cargo1").addClass("obligatorio");
	$("#telefono_empresa_cargo1").addClass("obligatorio");
	$("#ciudad_empresa_cargo1_txt,#ciudad_empresa_cargo1_txt_hidden").addClass("obligatorio");
	$("#nombre_persona_atendio1").addClass("obligatorio");
	$("#nombre_persona_atendio1").addClass("obligatorio");
	$("#cargo_persona_atendio1").addClass("obligatorio");
	$("#tiempo_lleva_cargando1").addClass("obligatorio");
	$("#rutas1").addClass("obligatorio");
	$("#tipo_mercancia1").addClass("obligatorio");
	$("#viajes_realizados1").addClass("obligatorio");		
	
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");
}

function beforePrint(){
	
   var conductor_id = parseInt(document.getElementById("conductor_id").value);
      
   if(isNaN(conductor_id)){
     alertJquery("Debe Seleccionar un Conductor !!","Impresion Conductor"); 
     return false;
   }else{
      return true;
    }
  
  
}

function calculateAge(dateText,inst){
  
     if(isDate(dateText)){
   
	var QueryString = "ACTIONCONTROLER=calculateAge&fecha_nacimiento_cond="+dateText;
	
	$.ajax({
	  url        : "ConductoresClass.php?rand="+Math.random(),
	  data       : QueryString,
	  beforeSend : function(){
	    showDivLoading(); 
	  },
	  success     : function(response){
	    
	    removeDivLoading();
	    
	    if(isNumber(parseInt(response))){
	      $("#edad").val(response);
	      $("#estatura").focus();
	    }
	    
	  }
	  
	});
     
    }     
    
}  

$(document).ready(function(){						   	   
						   
  //referenciasEmpresa();						   
  
  $("#numero_identificacion").blur(function(){
				
     var valor  = $("#numero_identificacion").val();
     var params = new Array({campos:"numero_identificacion",valores:valor});
	 
     validaRegistro(this,params,"ConductoresClass.php",null,function(resp){
	   		 													      
       if(resp == 0){       
	
	 $('#guardar').attr("disabled","");
         $('#actualizar').attr("disabled","true");
         $('#borrar').attr("disabled","true");
         $('#limpiar').attr("disabled","");
		 
       }else{
                      
           var params = new Array({campos:"numero_identificacion",valores:$('#numero_identificacion').val()});					  		  
           FindRow(params,document.forms[0],'ConductoresClass.php',null,function(res){
	     	
		   
           if($('#guardar'))    $('#guardar').attr("disabled","true");
           if($('#actualizar')) $('#actualizar').attr("disabled","");
           if($('#borrar'))     $('#borrar').attr("disabled","");
           if($('#limpiar'))    $('#limpiar').attr("disabled","");
         
         });
     
        }
			 
     });
  
  });
  
  
   
  $("#fecha_nacimiento_cond").blur(function(){
    
    calculateAge(this.value,this);
    
  });
  
  
  $("#tipo_vivienda").change(function(){

      if(this.value == 'A'){
		  
		document.getElementById('telefono_arrendatario').disabled = false;  
		document.getElementById('arrendatario').disabled          = false;  				  
		
		//$("#telefono_arrendatario,#arrendatario").addClass("obligatorio");		 
		
	  }else{		  
	  
		 document.getElementById('telefono_arrendatario').disabled = true;  
		 document.getElementById('arrendatario').disabled          = true;  				  
		 
 		 $("#telefono_arrendatario,#arrendatario").removeClass("obligatorio");		 
 		 $("#telefono_arrendatario,#arrendatario").removeClass("requerido");		 		 
		 
	    }
									  
  });
    
});
	
/*function referenciasEmpresa(){
  
  $("#carga_por_primera_vez").change(function(){
											  
    if(this.value == 1){											  
	
        $("#empresa_cargo1,#empresa_cargo2").removeClass("obligatorio");
	    $("#telefono_empresa_cargo1,#telefono_empresa_cargo2").removeClass("obligatorio");
	    $("#ciudad_empresa_cargo1_txt,#ciudad_empresa_cargo1_txt_hidden,#ciudad_empresa_cargo2_txt,#ciudad_empresa_cargo2_txt_hidden").removeClass("obligatorio");
	    $("#nombre_persona_atendio1,#nombre_persona_atendio2").removeClass("obligatorio");
	    $("#nombre_persona_atendio1,#nombre_persona_atendio2").removeClass("obligatorio");
	    $("#cargo_persona_atendio1,#cargo_persona_atendio2").removeClass("obligatorio");
	    $("#tiempo_lleva_cargando1,#tiempo_lleva_cargando2").removeClass("obligatorio");
	    $("#rutas1,#rutas2").removeClass("obligatorio");
	    $("#tipo_mercancia1,#tipo_mercancia2").removeClass("obligatorio");
	    $("#viajes_realizados1,#viajes_realizados2").removeClass("obligatorio");	
		
        $("#empresa_cargo1,#empresa_cargo2").removeClass("requerido");
	    $("#telefono_empresa_cargo1,#telefono_empresa_cargo2").removeClass("requerido");
	    $("#ciudad_empresa_cargo1_txt,#ciudad_empresa_cargo1_txt_hidden,#ciudad_empresa_cargo2_txt,#ciudad_empresa_cargo2_txt_hidden").removeClass("requerido");
	    $("#nombre_persona_atendio1,#nombre_persona_atendio2").removeClass("requerido");
	    $("#nombre_persona_atendio1,#nombre_persona_atendio2").removeClass("requerido");
	    $("#cargo_persona_atendio1,#cargo_persona_atendio2").removeClass("requerido");
	    $("#tiempo_lleva_cargando1,#tiempo_lleva_cargando2").removeClass("requerido");
	    $("#rutas1,#rutas2").removeClass("requerido");
	    $("#tipo_mercancia1,#tipo_mercancia2").removeClass("requerido");
	    $("#viajes_realizados1,#viajes_realizados2").removeClass("requerido");			
	  
	}else{
		
         $("#empresa_cargo1,#empresa_cargo2").addClass("obligatorio");
	     $("#telefono_empresa_cargo1,#telefono_empresa_cargo2").addClass("obligatorio");
	     $("#ciudad_empresa_cargo1_txt,#ciudad_empresa_cargo1_txt_hidden,#ciudad_empresa_cargo2_txt,#ciudad_empresa_cargo2_txt_hidden").addClass("obligatorio");
	     $("#nombre_persona_atendio1,#nombre_persona_atendio2").addClass("obligatorio");
	     $("#nombre_persona_atendio1,#nombre_persona_atendio2").addClass("obligatorio");
	     $("#cargo_persona_atendio1,#cargo_persona_atendio2").addClass("obligatorio");
	     $("#tiempo_lleva_cargando1,#tiempo_lleva_cargando2").addClass("obligatorio");
	     $("#rutas1,#rutas2").addClass("obligatorio");
	     $("#tipo_mercancia1,#tipo_mercancia2").addClass("obligatorio");
	     $("#viajes_realizados1,#viajes_realizados2").addClass("obligatorio");	  	
		
		}
	  

  });
  
}*/	