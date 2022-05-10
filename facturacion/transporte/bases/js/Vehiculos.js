// JavaScript Document
//funcion para cargar los datos desde BUSCAR
function setDataFormWithResponse(){

	var placa_id = document.getElementById("placa_id").value;
		
	var parametros  = new Array({campos:"placa_id",valores:$('#placa_id').val()});
	var forma       = document.forms[0];
	var controlador = 'VehiculosClass.php';
		
	FindRow(parametros,forma,controlador,null,function(resp){
	  
	   $("#tipo_vehiculo_id").trigger("change");  
       $("#configuracion").trigger('change'); 	   
	   
	   try{
		   
		var data = $.parseJSON(resp);
		
		$("#numero_ejes").val(data[0]["numero_ejes"]);		
	   
	    var responsable_verificacion1 = $.trim(data[0]['responsable_verificacion1']).length > 0 ? data[0]['responsable_verificacion1'] : 'null';
	    var responsable_verificacion2 = $.trim(data[0]['responsable_verificacion2']).length > 0 ? data[0]['responsable_verificacion2'] : 'null';
	    var responsable_verificacion3 = $.trim(data[0]['responsable_verificacion3']).length > 0 ? data[0]['responsable_verificacion3'] : 'null';	
								
		if(responsable_verificacion1 == 'null'){ 
		  $("#responsable_verificacion1").val($("#responsable_verificacion1_static").val()); 
		}
		
		if(responsable_verificacion2 == 'null'){ 
		  $("#responsable_verificacion2").val($("#responsable_verificacion1_static").val()); 
		}
		
		if(responsable_verificacion3 == 'null'){ 
		  $("#responsable_verificacion3").val($("#responsable_verificacion1_static").val()); 
		}
		
		$("#modelo_vehiculo").trigger("blur");
		
        if($('#guardar'))    $('#guardar').attr("disabled","true");
	    if($('#actualizar')) $('#actualizar').attr("disabled","");
	    if($('#borrar'))     $('#borrar').attr("disabled","");
	    if($('#limpiar'))    $('#limpiar').attr("disabled","");
	   
	   }catch(e){
		   alertJquery(resp,"Error :");
		 }
	      
    }); 
	
}

function setDataRemolque(placa_remolque_id){
  
  var QueryString = "ACTIONCONTROLER=setDataRemolque&placa_remolque_id="+placa_remolque_id;
  
  $.ajax({
    url        : "VehiculosClass.php?rand="+Math.random(),
    data       : QueryString,
    beforeSend : function(){
      
    },
    success    : function(response){
      
      try{
		  
	    var responseArray   = $.parseJSON(response);		
	    var placa_remolque  = responseArray[0]['placa_remolque'];
	    var marca_remolque  = responseArray[0]['marca_remolque'];
	    var modelo_remolque = responseArray[0]['modelo_remolque'];
	    var tipo_remolque   = responseArray[0]['tipo_remolque'];
	
	    $("#placa_remolque").val(placa_remolque);
	    $("#marca_remolque").val(marca_remolque);	
	    $("#modelo_remolque").val(modelo_remolque);
	    $("#tipo_remolque").val(tipo_remolque);
	
      }catch(e){
	     alertJquery(e);
       } 
      
    }
    
  });
  
}

function setDataPropietario(propietario_id){
    
  var QueryString = "ACTIONCONTROLER=setDataPropietario&propietario_id="+propietario_id;
  
  $.ajax({
    url        : "VehiculosClass.php?rand="+Math.random(),
    data       : QueryString,
    beforeSend : function(){
      
    },
    success    : function(response){
      
      try{
	
		var responseArray         = $.parseJSON(response); 
		var tipo_persona          = responseArray[0]['tipo_persona'];
		var numero_identificacion = responseArray[0]['numero_identificacion'];
		var telefono              = responseArray[0]['telefono'];
		var movil                 = responseArray[0]['movil'];
		var direccion             = responseArray[0]['direccion'];
		var ubicacion             = responseArray[0]['ubicacion'];
		var ubicacion_id          = responseArray[0]['ubicacion_id'];	
		var email                 = responseArray[0]['email'];	
		
		$("#tipo_persona_propietario").val(tipo_persona);
		$("#cedula_nit_propietario").val(numero_identificacion);
		$("#telefono_propietario").val(telefono);
		$("#celular_propietario").val(movil);
		$("#direccion_propietario").val(direccion);	
		$("#email_propietario").val(email);
		$("#ciudad_propietario").val(ubicacion);	
	
      }catch(e){
	  		alertJquery(e);
       }
      
    }
    
  });
  
}

function setDataTenedor(tenedor_id){
    
   var QueryString = "ACTIONCONTROLER=setDataTenedor&tenedor_id="+tenedor_id;
  
  $.ajax({
    url        : "VehiculosClass.php?rand="+Math.random(),
    data       : QueryString,
    beforeSend : function(){
      
    },
    success    : function(response){
           
      try{
	
		var responseArray         = $.parseJSON(response); 
		var tipo_persona          = responseArray[0]['tipo_persona'];
		var numero_identificacion = responseArray[0]['numero_identificacion'];
		var telefono              = responseArray[0]['telefono'];
		var movil                 = responseArray[0]['movil'];
		var direccion             = responseArray[0]['direccion'];
		var ubicacion             = responseArray[0]['ubicacion'];
		var ubicacion_id          = responseArray[0]['ubicacion_id'];	
		var email                 = responseArray[0]['email'];	
		var tipo_cuenta           = responseArray[0]['tipo_cuenta'];	
		var entidad_bancaria      = responseArray[0]['entidad_bancaria'];
		var numero_cuenta_tene    = responseArray[0]['numero_cuenta_tene'];
		
		$("#tipo_persona_tenedor").val(tipo_persona);
		$("#cedula_nit_tenedor").val(numero_identificacion);
		$("#telefono_tenedor").val(telefono);
		$("#celular_tenedor").val(movil);
		$("#direccion_tenedor").val(direccion);	
		$("#email_tenedor").val(email);
		$("#ciudad_tenedor").val(ubicacion);	
		$("#tipo_cuenta_tenedor").val(tipo_cuenta);
		$("#banco_cuenta_tenedor").val(entidad_bancaria);
		$("#numero_cuenta_tenedor").val(numero_cuenta_tene);		
	
      }catch(e){
	      alertJquery(e);
       }
      
     
    }
    
  }); 
  
  
}

var formSubmitted = false;

function VehiculoOnSaveUpdate(formulario,resp){
				
	if($.trim(resp) == 'true'){				
	
	 if(!formSubmitted){	
				
	  var QueryString = FormSerialize(formulario)+"&ACTIONCONTROLER=sendVehiculoMintransporte";
	  	
	  $.ajax({
		url        : "VehiculosClass.php?rand="+Math.random(),	 
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

		  Reset(document.getElementById('VehiculosForm'));
		  vehiculoReset(formulario);
		  $("#refresh_QUERYGRID_vehiculos").click();  
		  
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

function VehiculoOnDelete(formulario,resp){
	
      Reset(document.getElementById('VehiculosForm'));
	  vehiculoReset(formulario);
      $("#refresh_QUERYGRID_vehiculos").click();  
        
	  if($('#guardar'))    $('#guardar').attr("disabled","");
	  if($('#actualizar')) $('#actualizar').attr("disabled","true");
	  if($('#borrar'))     $('#borrar').attr("disabled","true");
	  if($('#limpiar'))    $('#limpiar').attr("disabled","");	   
   
   	  alertJquery(resp);  
}

function vehiculoReset(formulario){
  
      $("#empresa_id").val($("#empresa_id_static").val());
	  $("#estado").val("B");
      $("#responsable_verificacion1").val($("#responsable_verificacion1_static").val());
      $("#responsable_verificacion2").val($("#responsable_verificacion2_static").val());
      $("#responsable_verificacion3").val($("#responsable_verificacion3_static").val());
	  $("#tecnomecanico_vehiculo").removeClass("obligatorio");
	  clearFind();
	  
	  $("#placa_remolque_hidden").removeClass("obligatorio");
	  $("#placa_remolque").removeClass("requerido");				  
	  document.getElementById('placa_remolque').readOnly = true;
	  $("#filaRemolque").css("display","none");		  
	  
	  $("#numero_ejes").removeClass('obligatorio');
	  $("#numero_ejes").removeClass('requerido');
	  
 	  $("#capacidad").removeClass('obligatorio');
 	  $("#capacidad").removeClass('requerido');	  
	  
	  document.getElementById('carroceria_id').value    = 'NULL';
	  document.getElementById('carroceria_id').disabled = false;		  
  
	  if($('#guardar'))    $('#guardar').attr("disabled","");
	  if($('#actualizar')) $('#actualizar').attr("disabled","true");
	  if($('#borrar'))     $('#borrar').attr("disabled","true");
	  if($('#limpiar'))    $('#limpiar').attr("disabled","");	
}

function beforePrint(){

  var placa_id = parseInt($("#placa_id").val());
  
  if(isNaN(placa_id)){
      alertJquery("Debe Seleccionar un Vehiculo !!","Impresion Hoja de Vida Vehiculo");
      return false;
  }else{
         return true;
   }

}

//eventos asignados a los objetos
$(document).ready(function(){
  
	var placa_id = $("#placa_id").val();

	if (placa_id.length > 0) {
		setDataFormWithResponse();
	}
  //evento que busca la placa duplicada
  
  $("#configuracion").change(function(){
									  
     var configuracion = this.value;									  
	 
	 if(configuracion == '55' || configuracion == '56'){		 
	  $("#numero_ejes").addClass('obligatorio');		 
	 }else{
 	    $("#numero_ejes").removeClass('obligatorio');
 	    $("#numero_ejes").removeClass('requerido');		
	   }	   
	   
	 if(configuracion == '50' || configuracion == '55' || configuracion == '56'){
	   $("#capacidad").addClass('obligatorio');	
	   
	 }else{
 	    $("#capacidad").removeClass('obligatorio');
 	    $("#capacidad").removeClass('requerido');				 
	   }
	   
	   
	 if(configuracion == '53' || configuracion == '54' || configuracion == '55'){
	   document.getElementById('carroceria_id').value    = '0';
	   document.getElementById('carroceria_id').disabled = true;	   
	 }else{
	    //document.getElementById('carroceria_id').value    = 'NULL';
	    document.getElementById('carroceria_id').disabled = false;				 
	   }
	   
	 if(configuracion == '53' || configuracion == '50'){
	   document.getElementById('numero_ejes').value    = '2';
	   document.getElementById('numero_ejes').disabled = true;
	 }else if(configuracion == '51' || configuracion == '54'){
		 document.getElementById('numero_ejes').value    = '3';
	     document.getElementById('numero_ejes').disabled = true;				 
	   }else if (configuracion == '52'){
		    document.getElementById('numero_ejes').value    = '4';
		    document.getElementById('numero_ejes').disabled = true;			
		   }else if (configuracion == '55' || configuracion == '56' ){
		    document.getElementById('numero_ejes').disabled = false;			
    		document.getElementById('numero_ejes').value    = '';
		   }   
									  
  });
  
    $("#propio").change(function(){
	 var obj =this;
	 var propio =$("#propio").val();
	 
	 
	 if(propio==1){
		 $("#propietario,#tipo_persona_propietario,#cedula_nit_propietario,#telefono_propietario,#celular_propietario,#direccion_propietario,#ciudad_propietario,#email_propietario").attr("disabled","true");
		 var QueryString = "ACTIONCONTROLER=validapropio";
		 
		$.ajax({
		url        : "VehiculosClass.php?rand="+Math.random(),
		data       : QueryString,
		beforeSend : function(){
		  showDivLoading();	
		},
		
		success    : function(resp){
			
		 try{
				
		  var propietarios            = $.parseJSON(resp);	
									  
		  var  propietario            = propietarios[0]['razon_social'] != 'null' ? propietarios[0]['razon_social'] : '';
		  var  tercero_id            = propietarios[0]['tercero_id'] != 'null' ? propietarios[0]['tercero_id'] : '';
		  var  tipo_persona_propietario  = propietarios[0]['tipo_persona_id'] != 'null' ? propietarios[0]['tipo_persona_id'] : '';
		  var  cedula_nit_propietario  = propietarios[0]['numero_identificacion'] != 'null' ? propietarios[0]['numero_identificacion'] : '';
		  var  telefono_propietario  = propietarios[0]['telefono'] != 'null' ? propietarios[0]['telefono'] : '';
		  var  celular_propietario  = propietarios[0]['movil'] != 'null' ? propietarios[0]['movil'] : '';
		  var  direccion_propietario  = propietarios[0]['direccion'] != 'null' ? propietarios[0]['direccion'] : '';
		  var  ciudad_propietario  = propietarios[0]['ubicacion'] != 'null' ? propietarios[0]['ubicacion'] : '';
		  var  email_propietario  = propietarios[0]['email'] != 'null' ? propietarios[0]['email'] : '';

	
		  $("#propietario").val(propietario);
		  $("#propietario_hidden").val(tercero_id);
		  $("#tipo_persona_propietario").val(tipo_persona_propietario);
		  $("#cedula_nit_propietario").val(cedula_nit_propietario);
		  $("#telefono_propietario").val(telefono_propietario);
		  $("#celular_propietario").val(celular_propietario);
		  $("#direccion_propietario").val(direccion_propietario);
		  $("#ciudad_propietario").val(ciudad_propietario);
		  $("#email_propietario").val(email_propietario);
		 
				
		}catch(e){
		
		}
		 removeDivLoading();
	}
	
  });
		 
	 }else if(propio==0){

		 $(							                                   "#propietario,#tipo_persona_propietario,#cedula_nit_propietario,#telefono_propietario,#celular_propietario,#direccion_propietario,#ciudad_propietario,#email_propietario").attr("disabled","");
		 
		 		 $("#propietario,#tipo_persona_propietario,#cedula_nit_propietario,#telefono_propietario,#celular_propietario,#direccion_propietario,#ciudad_propietario,#email_propietario").val(" ");
			
	 }
});
  
  $("#peso_vacio").blur(function(){
								 
      var peso_vacio = parseInt(this.value);
	  
	  if(peso_vacio > 200 && peso_vacio < 53000){
		 return true;
	  }else{
		  alertJquery("El peso reportado debe ser mayor a 200 kilogramos y menor a 53000 kilogramos.","Validacion Vehiculo");
		  this.value = '';
	   }
								 
  });
  
  $("#modelo_repotenciado,#modelo_vehiculo").blur(function(){
						
     var obj             = this;
     var modelo_vehiculo = $("#modelo_vehiculo").val();								
	 var repotenciado    = $("#modelo_repotenciado").val();		
	 
	 if($.trim(repotenciado).length > 0 && $.trim(modelo_vehiculo).length > 0){
		 
       var QueryString  = "ACTIONCONTROLER=validaRepotenciacion&modelo_vehiculo="+modelo_vehiculo+"&repotenciado="+repotenciado;			
			
       $.ajax({
	     url        : "VehiculosClass.php?rand="+Math.random(),
	     data       : QueryString,
		 beforeSend : function(){
		  showDivLoading();
		 },
		 success    : function(resp){
			 
			var validacion = $.trim(resp);
			
			if(validacion != 'true'){
				
			  if(validacion == 'mayor'){
			   alertJquery("El a�o al que fue repotenciado el vehiculo no puede ser mayor al a�o actual","Validacion Vehiculo");
			  }else if(validacion == 'menor'){
			     alertJquery("El a�o al que fue repotenciado No puede ser menor al modelo.","Validacion Vehiculo");				
			    }else if(validacion == 'igual'){
			       alertJquery("El a�o al que fue repotenciado No puede ser igual al modelo.","Validacion Vehiculo");									
				  }	
				  
               obj.value = '';				
			}
			 
			removeDivLoading();
		 }
	   });			 
		 
	 }
	 
  });
  
  $("#vencimiento_soat").blur(function(){
		
	 var obj         = this;	
     var QueryString = "ACTIONCONTROLER=validaVencimientoSoat&vencimiento_soat="+this.value;		
			
     $.ajax({
	   url        : "VehiculosClass.php?rand="+Math.random(),
	   data       : QueryString,
	   beforeSend : function(){
		  showDivLoading();
	   },
	   success    : function(resp){
		   
		   var validacion = $.trim(resp);
		   
		   if(validacion == 'true'){
			   alertJquery("La fecha del vencimiento del SOAT no puede ser un a�o mayor a la fecha actual","Validacion");
			   obj.value = '';
			   return false;
			   
		   }
		   
		   removeDivLoading();
	   }
	 });									   
									   
  });
  
  $('#vencimiento_soat').change(function(){

    var fechav = $('#vencimiento_soat').val();
    var today = new Date();

    if ((Date.parse(fechav)<today)) {
     alertJquery("La fecha del vencimiento de SOAT no puede ser menor a la fecha actual","Validacion");
     return $('#vencimiento_soat').val('');
    };
 });
   
   $('#vencimiento_tecno_vehiculo').change(function(){

    var fechav = $('#vencimiento_tecno_vehiculo').val();
    var today = new Date();

    if ((Date.parse(fechav)<today)) {
     alertJquery("La fecha de vigencia de la TECNOMECANICA no puede ser menor a la fecha actual","Validacion");
     return $('#vencimiento_tecno_vehiculo').val('');
    };
 });

    
  $("#configuracion").trigger('change');   
  
  $("#placa").blur(function(){
							
     var params = new Array({campos:"placa",valores:$("#placa").val()});
	 
     validaRegistro(this,params,"VehiculosClass.php",null,function(resp){
       																   
     if(parseInt(resp) != 0 ){

      	var parametros  = new Array({campos:"placa",valores:$('#placa').val()});
    	var forma       = document.forms[0];
    	var controlador = 'VehiculosClass.php';
	
	    FindRow(parametros,forma,controlador,null,function(resp){																	
			
           $("#modelo_vehiculo").trigger("blur");			
			
           if($('#guardar'))    $('#guardar').attr("disabled","true");
           if($('#actualizar')) $('#actualizar').attr("disabled","");
	       if($('#borrar'))     $('#borrar').attr("disabled","");
	       if($('#limpiar'))    $('#limpiar').attr("disabled","");
	      
        }); 

     }else{
		   
	   var placa_id = $.trim($("#placa_id").val());
		   
	   if(!placa_id.length  > 0){
			 
	       $('#guardar').attr("disabled","");
       	   $('#actualizar').attr("disabled","true");
           $('#borrar').attr("disabled","true");
           $('#limpiar').attr("disabled","true");
		   
	   }
		 
     }
	  
   });
	 
  
 });
   
 
 $("#tipo_vehiculo_id").change(function(){
										  
   if(this.value != 'NULL'){
	   
	  
	 var QueryString = 'ACTIONCONTROLER=tieneRemolque&tipo_vehiculo_id='+this.value; 
	 
	 $.ajax({
        url        : "VehiculosClass.php?rand="+Math.random(),
		data       : QueryString,
		beforeSend : function(){
			
		},
		success    : function(response){

        if(response == 'true'){
			  
	      $("#placa_remolque_hidden").addClass("obligatorio");
	      document.getElementById('placa_remolque').readOnly = false;
		  $("#filaRemolque").css("display","");
			  
			  
	    }else{
			  
	  	    $("#placa_remolque_hidden").removeClass("obligatorio");
	  	    $("#placa_remolque").removeClass("requerido");				  
		    document.getElementById('placa_remolque').readOnly = true;
		    $("#filaRemolque").css("display","none");		
		
	        $("#placa_remolque_hidden").val('');
	        $("#placa_remolque").val('');
	        $("#marca_remolque").val('');			  
	        $("#modelo_remolque").val('');			  			  
	        $("#tipo_remolque").val('');			  			  			  		
		  
	    }


        }
			
			
	 });
	   
   }else{
	   
	    $("#placa_remolque_hidden").removeClass("obligatorio");	   
		$("#placa_remolque").removeClass("requerido");				  		
	   
	 }
										  
 });  

 $("#modelo_vehiculo").blur(function(){
							
      var modelo = parseInt(this.value);						

      if(modelo > 0){
		  
		var QueryString = "ACTIONCONTROLER=validaRevision&modelo="+modelo;
		  
		$.ajax({
		  url        : "VehiculosClass.php?rand="+Math.random(),
		  data       : QueryString,
		  beforeSend : function(){
			 showDivLoading();
		  },
		  success    : function(resp){
			   
			   var revisionTecnicoMecanica = $.trim(resp);
			   			   
			   if(revisionTecnicoMecanica == 'true'){				   
				 $("#tecnomecanico_vehiculo").addClass("obligatorio");				   
			   }else{				   
	   			  $("#tecnomecanico_vehiculo").removeClass("obligatorio");
				  $("#tecnomecanico_vehiculo").removeClass("requerido");				   
				 }
			   
			   removeDivLoading();
		  }
		  
	    });  
		  		  
	 }	    
							
 });
  

});


function getReferenciasConductor(value,text,obj){
	
  var QueryString = "ACTIONCONTROLER=getReferenciasConductor&conductor_id="+value;	
	
  $.ajax({
	url        : "VehiculosClass.php?rand="+Math.random(),
	data       : QueryString,
	beforeSend : function(){
	  showDivLoading();	
    },
	success    : function(resp){
		
	 try{
			
	  var referencias             = $.parseJSON(resp);	
		  			  			  
	  var  referencia1            = referencias[0]['referencia1']           != 'null' ? referencias[0]['referencia1'] : '';
	  var  ciudad_referencia1     = referencias[0]['ciudad_referencia1']    != 'null' ? referencias[0]['ciudad_referencia1'] : '';			
	  var  ciudad_referencia1_id  = referencias[0]['ciudad_referencia1_id'] != 'null' ? referencias[0]['ciudad_referencia1_id'] : '';
	  var  telefono_referencia1   = referencias[0]['telefono_referencia1']  != 'null' ? referencias[0]['telefono_referencia1'] : '';
	  var  referencia2            = referencias[0]['referencia2']           != 'null' ? referencias[0]['referencia2'] : '';
	  var  ciudad_referencia2     = referencias[0]['ciudad_referencia2']    != 'null' ? referencias[0]['ciudad_referencia2'] : '';						
	  var  ciudad_referencia2_id  = referencias[0]['ciudad_referencia2_id'] != 'null' ? referencias[0]['ciudad_referencia2_id'] : '';
	  var  telefono_referencia2   = referencias[0]['telefono_referencia2']  != 'null' ? referencias[0]['telefono_referencia2'] : '';
	  var  referencia3            = referencias[0]['referencia3']           != 'null' ? referencias[0]['referencia3'] : '';
	  var  ciudad_referencia3     = referencias[0]['ciudad_referencia3']    != 'null' ? referencias[0]['ciudad_referencia3'] : '';			  
	  var  ciudad_referencia3_id  = referencias[0]['ciudad_referencia3_id'] != 'null' ? referencias[0]['ciudad_referencia3_id'] : '';
	  var  telefono_referencia3   = referencias[0]['telefono_referencia3']  != 'null' ? referencias[0]['telefono_referencia3'] : '';
		  
	  $("#nombre_persona_atendio1").val(referencia1);
	  $("#ciudad_persona_atendio1").val(ciudad_referencia1);
	  $("#ciudad_persona_atendio1_id").val(ciudad_referencia1_id);
	  $("#ciudad_persona_atendio1_hidden").val(ciudad_referencia1_id);
	  $("#telefono_persona_atendio1").val(telefono_referencia1); 	

	  $("#nombre_persona_atendio2").val(referencia2);
	  $("#ciudad_persona_atendio2").val(ciudad_referencia2);
	  $("#ciudad_persona_atendio2_id").val(ciudad_referencia2_id);
	  $("#ciudad_persona_atendio2_hidden").val(ciudad_referencia2_id);
	  $("#telefono_persona_atendio2").val(telefono_referencia2); 	

	  $("#nombre_persona_atendio3").val(referencia3);
	  $("#ciudad_persona_atendio3").val(ciudad_referencia3);
	  $("#ciudad_persona_atendio3_id").val(ciudad_referencia3_id);
	  $("#ciudad_persona_atendio3_hidden").val(ciudad_referencia3_id);
	  $("#telefono_persona_atendio3").val(telefono_referencia3); 	

			
	}catch(e){
	  }

	 removeDivLoading();
	}
	
  });
	
}