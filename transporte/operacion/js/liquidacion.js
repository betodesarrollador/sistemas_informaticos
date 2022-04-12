// JavaScript Document

$(document).ready(function(){

  autocompleteProveedor();
  addRowCosto();
  removeRowCosto();
  setLiquidacion();
  validaTipoDescuento();
  setCalcularFlete();
  setValorLiquidacion();
  
$("#divAnulacion").css("display","none");

	$("input[id=fecha_llegada_descargue],input[id=fecha_entrada_descargue],input[id=fecha_salida_descargue]" ).datepicker({
		dateFormat : "yy-mm-dd",
			showOn: "button",
			buttonImage: "../../../framework/media/images/calendar/calendar.gif",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1900:2050'
	}); 

  $("input[id='valor_flete']").keypress(function(event){

 		if(this.value!=''){
			var cambio=0;
			$(".rowRemesa").each(function(){ 
			   
			   $(this).find("input[name=remesa]").each(function(){
													   
				 if(this.id == 'valor_costo' && this.value!='' ){
					 this.value='';
					 cambio=1;
					 
				 }

				 if(this.id == 'valor_unidad_costo' && this.value!='' ){
					 this.value='';
					 cambio=1;
				 }

			   });
			   
			   
			});
			if(cambio==1){ 
				alertJquery("No debe cambiar el valor del flete,<br> Si le ha puesto costo a alguna de las remesas.","Validacion");
				$("#valor_galon").val('');
			}
		}
	});

  $("input[id='valor_sobre_flete']").keypress(function(event){

 		if(this.value!=''){
			var cambio=0;
			$(".rowRemesa").each(function(){ 
			   
			   $(this).find("input[name=remesa]").each(function(){
													   
				 if(this.id == 'valor_costo' && this.value!='' ){
					 this.value='';
					 cambio=1;
					 
				 }

				 if(this.id == 'valor_unidad_costo' && this.value!='' ){
					 this.value='';
					 cambio=1;
				 }

			   });
			   
			   
			});
			if(cambio==1){ 
				alertJquery("No debe cambiar el valor del sobreflete,<br> Si le ha puesto costo a alguna de las remesas.","Validacion");
				$("#valor_galon").val('');
			}
		}
	});

  $("#reportar").click(function(){
		if(parseInt($("#manifiesto_id").val())>0){
			cumplirManifiestoCargaMinisterio();
		}else{
			alertJquery("Por favor escoja un manifiesto liquidado.","Validacion");		
		}
  });

	 $('#fecha_llegada_descargue').change(function(){

		var fecha1 = $('#fecha_llegada_descargue').val();
		var fecha2 = new Date();
		var fecha3 = $('#fecha_llegada_cargue').val();
		var fecha4 = $('#fecha_estimada_salida').val();
		var fecha5 = $('#fecha_entrada_cargue').val();
		var fecha6 = $('#fecha_salida_cargue').val();
		var fecha7 = $('#fecha_entrada_descargue').val();   
		var fecha8 = $('#fecha_salida_descargue').val();
		var fecha9 = $('#fecha_entrega_mcia_mc').val();
		
		

		if ((Date.parse(fecha1) >fecha2) ) {
			alertJquery('La fecha de llegada no puede ser mayor a la fecha actual!.'); 
			$('#fecha_llegada_descargue').val('');
		}else if ((Date.parse(fecha1) < Date.parse(fecha3) ) || (Date.parse(fecha1) < Date.parse(fecha5)) || (Date.parse(fecha1) < Date.parse(fecha6))) {
			alertJquery('La fecha de llegada del descargue no puede ser menor a las fechas del cargue!<br/> revise los tiempos de cargue digitados en el manifiesto');
			$('#fecha_llegada_descargue').val('');
		}else if ((Date.parse(fecha1) < Date.parse(fecha4)) ) {
			alertJquery('La fecha de llegada del descargue no puede ser menor a la fecha estimada de salida del manifiesto!.');
			$('#fecha_llegada_descargue').val('');
		}else if ((Date.parse(fecha1) < Date.parse(fecha9))){
			alertJquery('La fecha de llegada del descargue debe ser mayor o igual a la fecha estimada de entrega del manifiesto!.');
			$('#fecha_llegada_descargue').val('');
		}else if(parseInt($("#manifiesto_id").val()) > 0){

			validarFechaHoraRemesa(parseInt($("#manifiesto_id").val()));//nuevo cambio 16/07/2019

		}
	});
	
	$('#fecha_entrada_descargue').change(function(){

	  	var fecha1 = $('#fecha_llegada_descargue').val();
	  	var fecha2 = $('#fecha_entrada_descargue').val();
		var fecha3 = $('#fecha_entrada_cargue').val();
		var fecha4 = $('#fecha_salida_descargue').val();
		var fecha6 = $('#fecha_salida_cargue').val();
		var fecha7 = $('#fecha_llegada_cargue').val();   
		
		var fechaActual = new Date();
	  	
		//alert("llego");
	  	if ((Date.parse(fecha1) > Date.parse(fecha2)) || (Date.parse(fecha2) > Date.parse(fecha4))) {
	  		alertJquery('La fecha de llegada no puede ser mayor a la fecha de entrada y la fecha de entrada del descargue no puede ser mayor a la fecha de salida del descargue !.');
	  		$('#fecha_entrada_descargue').val('');
	  	}
		 if ((Date.parse(fecha2) >fechaActual) ) {
  			alertJquery('La fecha de entrada no puede ser mayor a la fecha actual!.');
  			$(obj).val('');
 		}if ((Date.parse(fecha2) < Date.parse(fecha3)) || (Date.parse(fecha2) < Date.parse(fecha7)) || (Date.parse(fecha2) < Date.parse(fecha6)) ) {
  			alertJquery('La fecha de entrada del descargue  no puede ser menor a las fechas de cargue!<br/> Por favor revise las fechas de cargue digitadas en el manifiesto');
  			$(obj).val('');
 		}
		
	});
	
	
	
	$('#fecha_salida_descargue').change(function(){

	  	var fecha1 = $('#fecha_llegada_descargue').val();
	  	var fecha2 = $('#fecha_entrada_descargue').val();
		var fecha3 = $('#fecha_salida_descargue').val();
		var fecha4 = $('#fecha_salida_cargue').val();
		var fecha5 = $('#fecha_entrada_cargue').val();
		var fecha6 = $('#fecha_llegada_cargue').val();
		
		var fechaActual = new Date();
	  	
		//alert("llego");
	  	if ((Date.parse(fecha2) > Date.parse(fecha3)) || (Date.parse(fecha1) > Date.parse(fecha3))) {
	  		alertJquery('La fecha de salida no puede ser menor a la fecha de llegada ni de entrada!!.');
	  		$('#fecha_salida_descargue').val('');
	  	}

  		if ((Date.parse(fecha3) >fechaActual) ) {
		  alertJquery('La fecha de salida no puede ser mayor a la fecha actual!.');
		  $(obj).val('');
		 }
		 
  		if ((Date.parse(fecha3) < Date.parse(fecha4)) || (Date.parse(fecha3) < Date.parse(fecha5)) || (Date.parse(fecha3) < Date.parse(fecha6)) ) {
		  alertJquery('La fecha de salida del desacargue no puede ser menor a las fechas del cargue!<br/> Por favor revise las fechas de cargue digitadas en el manifiesto');
		  $(obj).val('');
		 }
		
	});
	
	$('#hora_entrada_descargue').change(function(){
		
		var fecha1 = $('#fecha_llegada_descargue').val();
	  	var fecha2 = $('#fecha_entrada_descargue').val();
	  	var fecha3 = $('#fecha_entrada_cargue').val();
				
		if(fecha1==fecha2){
			var hllegada= $('#hora_llegada_descargue').val();
			var hentrada= $('#hora_entrada_descargue').val();
			
			var hora_llegada = hllegada.split(":"); 
			var hora_entrada = hentrada.split(":"); 
			
			 var hh1 = parseInt(hora_llegada[0],10);
   			 var mm1 = parseInt(hora_llegada[1],10);
			 
			 var hh2 = parseInt(hora_entrada[0],10);
   			 var mm2 = parseInt(hora_entrada[1],10);
			 
			 if (hh1 > hh2){alertJquery('La hora de entrada no puede ser menor a la hora de llegada!!.');
	  		$('#hora_entrada_descargue').val('');}
			if (hh1==hh2){
				if(mm1>mm2){alertJquery('La hora de entrada no puede ser menor a la hora de llegada!!.');
	  		$('#hora_entrada_descargue').val('');}
			}
			}
			
			if(fecha2==fecha3){
			var hentradac= $('#hora_llegada_cargue').val();
			var hentrada= $('#hora_entrada_descargue').val();
			
			var hora_entradac = hentradac.split(":"); 
			var hora_entrada = hentrada.split(":"); 
			
			 var hh1 = parseInt(hora_entradac[0],10);
   			 var mm1 = parseInt(hora_entradac[1],10);
			 
			 var hh2 = parseInt(hora_entrada[0],10);
   			 var mm2 = parseInt(hora_entrada[1],10);
			 
			 if (hh1 > hh2){alertJquery('La hora de entrada del descargue no puede ser menor a la hora de entrada del cargue!!.');
	  		$('#hora_entrada_descargue').val('');}
			if (hh1==hh2){
				if(mm1>mm2){alertJquery('La hora de entrada del descargue no puede ser menor a la hora de entrada del cargue!!.');
	  		$('#hora_entrada_descargue').val('');}
			}
			}
			
			
	
	});
	
	
	$('#hora_salida_descargue').change(function(){		
		
	  	var fecha2 = $('#fecha_entrada_descargue').val();
		var fecha3 = $('#fecha_salida_descargue').val();
		var fecha4 = $('#fecha_salida_cargue').val();		
		
		if(fecha2==fecha3){
			var hsalida= $('#hora_salida_descargue').val();
			var hentrada= $('#hora_entrada_descargue').val();
			
			var hora_salida = hsalida.split(":"); 
			var hora_entrada = hentrada.split(":"); 
			
			 var hh1 = parseInt(hora_entrada[0],10);
   			 var mm1 = parseInt(hora_entrada[1],10);
			 
			 var hh2 = parseInt(hora_salida[0],10);
   			 var mm2 = parseInt(hora_salida[1],10);
			 
			 if (hh1 > hh2){alertJquery('La hora de salida no puede ser menor a la hora de entrada!!.');
	  		$('#hora_salida_descargue').val('');}
			if (hh1==hh2){
				if(mm1>mm2){alertJquery('La hora de salida no puede ser menor a la hora de entrada!!.');
	  		$('#hora_salida_descargue').val('');}
			}
			}
			
			if(fecha3==fecha4){
			var hsalidac= $('#hora_salida_cargue').val();
			var hsalida= $('#hora_salida_descargue').val();
			
			var hora_salidac = hsalidac.split(":"); 
			var hora_salida = hsalida.split(":"); 
			
			 var hh1 = parseInt(hora_salidac[0],10);
   			 var mm1 = parseInt(hora_salidac[1],10);
			 
			 var hh2 = parseInt(hora_salida[0],10);
   			 var mm2 = parseInt(hora_salida[1],10);
			 
			 if (hh1 > hh2){alertJquery('La hora de salida del descargue no puede ser menor a la hora de salida del cargue !!.');
	  		$('#hora_salida_descargue').val('');}
			if (hh1==hh2){
				if(mm1>mm2){alertJquery('La hora de salida del descargue no puede ser menor a la hora de salida del cargue!!.');
	  		$('#hora_salida_descargue').val('');}
			}
			}
		
	
	});
	
		
	$('#hora_llegada_descargue').change(function(){		

		var fecha1 = $('#fecha_llegada_descargue').val();
		var fecha2 = $('#fecha_llegada_cargue').val();
		var fecha3 = $('#fecha_entrada_descargue').val();
		var fecha4 = $('#fecha_salida_descargue').val();
		var fecha5 = $('#fecha_entrada_cargue').val();
		var fecha6 = $('#fecha_salida_cargue').val();
		
		if((fecha1==fecha2) || (fecha1==fecha5) || (fecha1==fecha6)){
			var hllegadac= $('#hora_llegada_cargue').val();
			var hllegada= $('#hora_llegada_descargue').val();
			var hentradac= $('#hora_entrada_cargue').val();
			var hsalidac= $('#hora_salida_cargue').val();
			
			var hora_llegadac = hllegadac.split(":"); 
			var hora_llegada = hllegada.split(":"); 
			var hora_entradac = hentradac.split(":");
			var hora_salidac = hsalidac.split(":");
			
			var hh1 = parseInt(hora_llegadac[0],10);
			var mm1 = parseInt(hora_llegadac[1],10);

			var hh2 = parseInt(hora_llegada[0],10);
			var mm2 = parseInt(hora_llegada[1],10);

			var hh3 = parseInt(hora_entradac[0],10);
			var mm3 = parseInt(hora_entradac[1],10);

			var hh4 = parseInt(hora_salidac[0],10);
			var mm4 = parseInt(hora_salidac[1],10);

			if ((hh1 > hh2) || (hh3 > hh2) || (hh4 >= hh2)){alertJquery('La hora de descargue que esta digitando es incorrecta ya que tiene que ser mayor a las horas de cargue digitadas en el manifiesto!<br/> Revise las horas de los tiempos de cargue digitados en el manifiesto!');
			$('#hora_llegada_descargue').val('');}
			if ((hh1==hh2) || (hh3==hh2)){
				if((mm1>mm2) || (mm3>mm2)){alertJquery('La hora de llegada del descargue no puede ser menor a la hora de llegada del cargueni menor a la hora de entrada del cargue!<br/> Revise las horas de los tiempos de cargue digitados en el manifiesto!');
				$('#hora_llegada_descargue').val('');}
			}
		}

		if(fecha1==fecha3 || fecha1==fecha4){
			var hllegadac= $('#hora_llegada_cargue').val();
			var hllegada= $('#hora_llegada_descargue').val();
			var hentrada= $('#hora_entrada_descargue').val();
			var hsalida= $('#hora_salida_descargue').val();
			
			var hora_llegada = hllegada.split(":"); 
			var hora_entrada = hentrada.split(":"); 
			var hora_salida = hsalida.split(":"); 
			
			var hh1 = parseInt(hora_llegada[0],10);
			var mm1 = parseInt(hora_llegada[1],10);

			var hh2 = parseInt(hora_entrada[0],10);
			var mm2 = parseInt(hora_entrada[1],10);

			var hh3 = parseInt(hora_salida[0],10);
			var mm3 = parseInt(hora_salida[1],10);

			if (hh1 > hh2){
				alertJquery('La hora de llegada del descargue no puede ser mayor a la hora de entrada del descargue!!.');
				$('#hora_llegada_descargue').val('');
			}else if (hh1==hh2){

				if(mm1>mm2){

					alertJquery('La hora de llegada del descargue no puede ser mayor a la hora de entrada del descargue!!.');
					$('#hora_llegada_descargue').val('');

				}
			}else if (hh1 > hh3){

				alertJquery('La hora de llegada del descargue no puede ser mayor a la hora de salida del descargue!!.');
				$('#hora_llegada_descargue').val('');

			}else if (hh1==hh3){

				if(mm1>mm3){
					alertJquery('La hora de llegada del descargue no puede ser mayor a la hora de salida del descargue!!.');
					$('#hora_llegada_descargue').val('');

				}

			}else if(parseInt($("#manifiesto_id").val()) > 0){

				validarFechaHoraRemesa(parseInt($("#manifiesto_id").val())); //nuevo cambio 16/07/2019

			}
		}

	});

});

  
  
function setCalcularFlete(){

  $("#calcularFlete").click(function(){
     calcularFlete(null,this.id,this.form);									 
  });
	
}

var formSubmitted = false;
function onclickCancellation(formulario){
	var manifiesto_id = $("#manifiesto_id").val();
	var manifiesto= $("#manifiesto_id").val();
	var liquidacion_despacho_id = $("#liquidacion_despacho_id").val();
	var liquidacion_despacho   = $("#liquidacion_despacho").val();	
	
	if($("#divAnulacion").is(":visible")){
	 
	   var formularioPrincipal = document.forms[0];
	   var causal_anulacion_id = $("#causal_anulacion_id").val();
	   var observacion_anulacion       = $("#observacion_anulacion").val();
	   
       if(ValidaRequeridos(formulario)){
		   
		 if(!formSubmitted){  		   
	
	     var QueryString = "ACTIONCONTROLER=onclickCancellation&liquidacion_despacho_id="+liquidacion_despacho_id+'&causal_anulacion_id='+causal_anulacion_id+'&observacion_anulacion='+observacion_anulacion+'&manifiesto='+manifiesto;
		
	     $.ajax({
           url  : "LiquidacionClass.php",
	       data : QueryString,
	       beforeSend: function(){
			   showDivLoading();
			   formSubmitted = true;
	       },
	       success : function(response){
			 
			 formSubmitted = false;
			 Reset(formularioPrincipal);
             LiquidacionManifiestoOnReset(formulario);						  
						  
		     if($.trim(response) == 'true'){
				 
			   alertJquery('Liquidacion Manifiesto Carga Anulado','Anulado Exitosamente');		 
				 				 
			 }else{
				   alertJquery(response,'Inconsistencia Anulando');
			   }
			   
			 removeDivLoading();
             $("#divAnulacion").dialog('close');
			 
	       }
	   
	     });
		 
	    }
	   
	   }
	
    }else{
		
	 var liquidacion_despacho_id = $("#liquidacion_despacho_id").val();
	 var estado_liquidacion        = document.getElementById("estado_liquidacion").value;
	 
	 if(parseInt(liquidacion_despacho_id) > 0){		

		$("#divAnulacion").dialog({
		  title: 'Anulacion Liquidacion Manifiesto de Carga',
		  width: 450,
		  height: 280,
		  closeOnEscape:true
		 });
			
	 }else{
		alertJquery('Debe Seleccionar primero un manifiesto de carga','Anulacion');
	  }		
		
	}  
	  
	
}

function calcularFlete(afterCalculation,objId,formulario){
						 
    var tenedor_id        = document.getElementById('tenedor_id').value;						 
    var valor_flete       = document.getElementById('valor_flete').value;	
    var valor_sobre_flete = document.getElementById('valor_sobre_flete').value;		
	
	if(!valor_flete > 0){
		alertJquery("Digite el valor pactado del flete por favor !!!","Validacion");
		return false;
	}
	
	var impuestos     = '';
	var descuentos    = '';
	var anticipos     = '';
	var contImpuesto  = 0;
	var contDescuento = 0;
	var contAnticipos = 0;
	var QueryString   = 'ACTIONCONTROLER=calcularFlete&valor_flete='+valor_flete+'&valor_sobre_flete='+valor_sobre_flete+'&tenedor_id='+tenedor_id;
	
	$(".rowImpuestos").each(function(){
	   
	   $(this).find("input[name=impuestos]").each(function(){
											   
         if(this.id == 'impuestos_manifiesto_id'){
			 impuestos += '&impuestos['+contImpuesto+'][impuestos_manifiesto_id]='+this.value;
		 }else if(this.id == 'impuesto_id'){
			   impuestos += '&impuestos['+contImpuesto+'][impuesto_id]='+this.value;			 
		  }else if(this.id == 'nombre'){
			      impuestos += '&impuestos['+contImpuesto+'][nombre]='+this.value;			  
			}else if(this.id == 'base'){
			        impuestos += '&impuestos['+contImpuesto+'][base]='+this.value;				
			  }else if(this.id == 'valor'){
			        impuestos += '&impuestos['+contImpuesto+'][valor]='+this.value;				
			  }
											   											   
       });
	   
	   contImpuesto++;
	   
    });
	
    QueryString += impuestos;
	
	$(".rowDescuentos").each(function(){
	   
	   $(this).find("input[name=descuentos]").each(function(){
											   
         if(this.id == 'descuento_id'){
			 descuentos += '&descuentos['+contDescuento+'][descuento_id]='+this.value;
		 }else if(this.id == 'nombre'){
			   descuentos += '&descuentos['+contDescuento+'][nombre]='+this.value;			 
		  }else if(this.id == 'valor'){
			      descuentos += '&descuentos['+contDescuento+'][valor]='+this.value;			  
			}
											   											   
       });
	   
	   contDescuento++;
	   
    });	
	
    QueryString += descuentos;	
	
	$(".rowAnticipos").each(function(){
	   	   
	   var adiciono = false;
	   	   
		   
	   $(this).find("input[name=anticipos]").each(function(){
											   
		 if(this.id == 'anticipos_manifiesto_id'){
			 anticipos += '&anticipo['+contAnticipos+'][anticipos_manifiesto_id]='+this.value;
		 }else if(this.id == 'numero'){
			   anticipos += '&anticipo['+contAnticipos+'][numero]='+this.value;			 
		  }else if(this.id == 'valor'){
				  anticipos += '&anticipo['+contAnticipos+'][valor]='+this.value;			  
			}else if(this.id == 'tenedor'){
					anticipos += '&anticipo['+contAnticipos+'][tenedor]='+this.value;			  
			  }else if(this.id == 'tenedor_id'){
					  anticipos += '&anticipo['+contAnticipos+'][tenedor_id]='+this.value;			  
			   }else if(this.id == 'observaciones'){
					   anticipos += '&anticipo['+contAnticipos+'][observaciones]='+this.value;			  
				}
																						   
	   });
		   
	   contAnticipos++;	   
	   
    });		
	
    QueryString += anticipos;	
	
	$.ajax({
	  url        : "LiquidacionClass.php?rand="+Math.random(),
	  data       : QueryString,
	  beforeSend : function(){
		  showDivLoading();
	  },
	  success    : function(resp){

		  removeDivLoading();

		  try{
			  
			 var data      = $.parseJSON(resp);			 
			 var impuestos = data['impuestos'];
			 
			 if(data['impuestos']){
			 
			  for(var i = 0; i < impuestos.length; i++){
			  
			      var impuesto_id = impuestos[i]['impuesto_id'];
			      var valor       = impuestos[i]['valor'];
			      var base        = impuestos[i]['base'];				  
				  
			      $(".rowImpuestos").find("input[name=impuestos]&&input[id=impuesto_id]").each(function(){
																									  
				  if(this.value == impuesto_id){
					    
				    var row = this.parentNode.parentNode;
					    
				    $(row).find("input[name=impuestos]&&input[id=valor]").val(valor);
				    $(row).find("input[name=impuestos]&&input[id=base]").val(base);					
				    return true;
					    
				  }
																										  
			      });
			  
			  }			 
			
			 }
			 
			 
			 if(data['descuentos']){
			   
			    var descuentos = data['descuentos'];
			    
			    for(i = 0; i < descuentos.length; i++){
			    
				var descuento_id = descuentos[i]['descuento_id'];
				    var valor        = descuentos[i]['valor'];
				    
				$(".rowDescuentos").find("input[name=descuentos]&&input[id=descuento_id]").each(function(){
																									    
				if(this.value == descuento_id){
					      
				  var row = this.parentNode.parentNode;
					      
				  $(row).find("input[name=descuentos]&&input[id=valor]").val(valor);
				  return true;
					      
				}
																										    
			      });
			    
			    }
			 
			 }
			 
			 
			 if(data['valor_neto_pagar']){
		           var valor_neto_pagar = data['valor_neto_pagar'];	   
			   $("#valor_neto_pagar").val(valor_neto_pagar);
                        }
                        
                        if(data['saldo_por_pagar']){
			    var saldo_por_pagar  = data['saldo_por_pagar'];			 
			    $("#saldo_por_pagar").val(saldo_por_pagar);	
			 }
			 
			  
		  }catch(e){
			   alertJquery(resp,"Error :");
			}
		 
		 
	   afterCalculation(objId,formulario);	 
	   } 
	  
    });
	      

}

function beforePrint(formulario,url,title,width,height){
	
	var liquidacion_despacho_id = parseInt($("#liquidacion_despacho_id").val());
	
	if(isNaN(liquidacion_despacho_id)){
	  
	  alertJquery('Debe seleccionar un Despacho a imprimir !!!','Impresion Liquidacion');
	  return false;
	  
	}else{	  
	
	    var liquidacion_despacho_id = $("#liquidacion_despacho_id").val();
		
		if(liquidacion_despacho_id > 0){
			
		  return true;	
			
		}else{
			
			 alertJquery("No se puede mostrar impresion ya que esta liquidacion no se ha CAUSADO aun!!!","Impresion Liquidacion");
			 return false;
			
		  }
		
	    return true;
	  }	
	
}

function setValorLiquidacion(){

  $("select[id=tipo_liquidacion]").change(function(){

     var Row = this.parentNode.parentNode;
	 	 
     if(this.value == 'P'){
		 
		var peso           =  $(Row).find("input[id=peso]").val();
		var peso_neto      = ((peso * 1) * 0.001);
		var valor_unidad   = removeFormatCurrency($(Row).find("input[id=valor_unidad_costo]").val());
		var valor_costo = (peso_neto * valor_unidad);
				
		if(!isNaN(valor_costo)){
			if(parseFloat($(Row).find("input[id=valor_facturar]").val())>=parseFloat(valor_costo)){
				$(Row).find("input[id=valor_costo]").val(setFormatCurrency(valor_costo));		
				//$(Row).find("input[name=valor_unidad_facturar]").removeAttr("readOnly");
				//$(Row).find("input[name=valor_facturar]").attr("readOnly","true");
			
			}else{
				$(Row).find("input[id=valor_costo]").val("");	
				$(Row).find("input[id=valor_unidad_costo]").val("");	
				 alertJquery("El costo ($"+setFormatCurrency(valor_costo)+") es mayor al valor a Facturar ($"+setFormatCurrency($(Row).find("input[id=valor_facturar]").val())+")!!!","Liquidacion");
			}
			
		}	
		
		 
	 }else if(this.value == 'V'){
		 
			var peso_volumen   = ($(Row).find("input[id=peso_volumen]").val() * 1);
			var valor_unidad   = removeFormatCurrency($(Row).find("input[id=valor_unidad_costo]").val());
			var valor_costo = (peso_volumen * valor_unidad);
			
			if(!isNaN(valor_costo)){ 			 			  

				if(parseFloat($(Row).find("input[id=valor_facturar]").val())>=parseFloat(valor_costo)){
					$(Row).find("input[id=valor_costo]").val(setFormatCurrency(valor_costo));		
					//$(Row).find("input[name=valor_unidad_facturar]").removeAttr("readOnly");
					//$(Row).find("input[name=valor_facturar]").attr("readOnly","true");
				
				}else{
					$(Row).find("input[id=valor_costo]").val("");	
					$(Row).find("input[id=valor_unidad_costo]").val("");	
					 alertJquery("El costo ($"+setFormatCurrency(valor_costo)+") es mayor al valor a Facturar ($"+setFormatCurrency($(Row).find("input[id=valor_facturar]").val())+")!!!","Liquidacion");
				}
			  
			}	 
	 }else if(this.value == 'G'){
		 
			var cantidad   = ($(Row).find("input[id=cantidad]").val() * 1);
			var valor_unidad   = removeFormatCurrency($(Row).find("input[id=valor_unidad_costo]").val());
			var valor_costo = (cantidad * valor_unidad);
			
			if(!isNaN(valor_costo)){ 			 			  

				if(parseFloat($(Row).find("input[id=valor_facturar]").val())>=parseFloat(valor_costo)){
					$(Row).find("input[id=valor_costo]").val(setFormatCurrency(valor_costo));		
					//$(Row).find("input[name=valor_unidad_facturar]").removeAttr("readOnly");
					//$(Row).find("input[name=valor_facturar]").attr("readOnly","true");
				
				}else{
					$(Row).find("input[id=valor_costo]").val("");	
					$(Row).find("input[id=valor_unidad_costo]").val("");	
					 alertJquery("El costo ($"+setFormatCurrency(valor_costo)+") es mayor al valor a Facturar ($"+setFormatCurrency($(Row).find("input[id=valor_facturar]").val())+")!!!","Liquidacion");
				}

			}	 
		 
	  }else if(this.value == 'C'){

//		     $(Row).find("input[name=valor_unidad_facturar]").attr("readOnly","true");
//		     $(Row).find("input[name=valor_facturar]").removeAttr("readOnly","false");			  			 
//		     $(Row).find("input[name=valor_facturar]").removeAttr("readOnly");			  
             $(Row).find("input[id=valor_unidad_costo]").val("0");		  
  			 $(Row).find("input[id=valor_costo]").val("");
		  
		}		

		var total_cost=0;
		$(".rowRemesa").each(function(){ 
		   
		   $(this).find("input[name=remesa]").each(function(){
												   
			 if(this.id == 'valor_costo' && this.value!='' ){
				 total_cost = parseFloat(parseFloat(total_cost) + parseFloat(removeFormatCurrency(this.value)));
			 }
																							   
		   });
		   
		  $("#valor_galon").val(setFormatCurrency(total_cost));
		  $("#valor_flete").val(setFormatCurrency(total_cost));
		   
		});

										 
  });
  
  $("input[id=valor_unidad_costo]").keyup(function(){
														
      var Row              = this.parentNode.parentNode;
      var tipo_liquidacion = $(Row).find('select[id=tipo_liquidacion]').val();
					
     if(tipo_liquidacion == 'P'){
		 
		var peso_neto      = (($(Row).find("input[id=peso]").val() * 1) * 0.001);
		var valor_unidad   = removeFormatCurrency(this.value);
		var valor_costo = Math.round(peso_neto * valor_unidad);
		if(!isNaN(valor_costo)){

			if(parseFloat($(Row).find("input[id=valor_facturar]").val())>=parseFloat(valor_costo)){
				$(Row).find("input[id=valor_costo]").val(setFormatCurrency(valor_costo));		
				$(Row).find("input[name=valor_unidad_costo]").removeAttr("readOnly");
				$(Row).find("input[name=valor_costo]").attr("readOnly","true");
			
			}else{
				$(Row).find("input[id=valor_costo]").val("");	
				$(Row).find("input[id=valor_unidad_costo]").val("");	
				 alertJquery("El costo ($"+setFormatCurrency(valor_costo)+") es mayor al valor a Facturar ($"+setFormatCurrency($(Row).find("input[id=valor_facturar]").val())+")!!!","Liquidacion");
			}

		}
		
		 
	 }else if(tipo_liquidacion == 'V'){
		 
			var peso_volumen   = ($(Row).find("input[id=peso_volumen]").val() * 1);
			var valor_unidad   = removeFormatCurrency(this.value);
			var valor_costo = Math.round(peso_volumen * valor_unidad);
			
			if(!isNaN(valor_costo)){ 

				if(parseFloat($(Row).find("input[id=valor_facturar]").val())>=parseFloat(valor_costo)){
					$(Row).find("input[id=valor_costo]").val(setFormatCurrency(valor_costo));		
					$(Row).find("input[name=valor_unidad_costo]").removeAttr("readOnly");
					$(Row).find("input[name=valor_costo]").attr("readOnly","true");
				
				}else{
					$(Row).find("input[id=valor_costo]").val("");	
					$(Row).find("input[id=valor_unidad_costo]").val("");	
					 alertJquery("El costo ($"+setFormatCurrency(valor_costo)+") es mayor al valor a Facturar ($"+setFormatCurrency($(Row).find("input[id=valor_facturar]").val())+")!!!","Liquidacion");
				}

			}
	 }else if(tipo_liquidacion == 'G'){
		 
			var cantidad   = ($(Row).find("input[id=cantidad]").val() * 1);
			var valor_unidad   = removeFormatCurrency(this.value);
			var valor_costo = (cantidad * valor_unidad);
			
			if(!isNaN(valor_costo)){ 			 			  

				if(parseFloat($(Row).find("input[id=valor_facturar]").val())>=parseFloat(valor_costo)){
					$(Row).find("input[id=valor_costo]").val(setFormatCurrency(valor_costo));		
					$(Row).find("input[name=valor_unidad_costo]").removeAttr("readOnly");
					$(Row).find("input[name=valor_costo]").attr("readOnly","true");
				
				}else{
					$(Row).find("input[id=valor_costo]").val("");	
					$(Row).find("input[id=valor_unidad_costo]").val("");	
					 alertJquery("El costo ($"+setFormatCurrency(valor_costo)+") es mayor al valor a Facturar ($"+setFormatCurrency($(Row).find("input[id=valor_facturar]").val())+")!!!","Liquidacion");
				}
			}	 
		 
		 
	  }else if(tipo_liquidacion == 'C'){
		  
		      $(Row).find("input[id=valor_unidad_costo]").attr("readOnly","true");
		      $(Row).find("input[id=valor_costo]").removeAttr("readOnly");			  
              $(Row).find("input[id=valor_unidad_costo]").val("0");		  
  			  $(Row).find("input[id=valor_costo]").val("");		  
		  
		}						

		var total_cost=0;
		$(".rowRemesa").each(function(){ 
		   
		   $(this).find("input[name=remesa]").each(function(){
												   
			 if(this.id == 'valor_costo' && this.value!='' ){
				 total_cost = parseFloat(parseFloat(total_cost) + parseFloat(removeFormatCurrency(this.value)));
			 }
																							   
		   });
		   
		  $("#valor_galon").val(setFormatCurrency(total_cost));
		  $("#valor_flete").val(setFormatCurrency(total_cost));
		   
		});

  });

  $("input[id=cantidad]").keyup(function(){
														
      var Row              = this.parentNode.parentNode;
      var tipo_liquidacion = $(Row).find('select[id=tipo_liquidacion]').val();
					
     if(tipo_liquidacion == 'P'){
		 
		var peso_neto      = (($(Row).find("input[id=peso]").val() * 1) * 0.001);
		var valor_unidad   = removeFormatCurrency($(Row).find("input[id=valor_unidad_costo]").val());
		var valor_costo = Math.round(peso_neto * valor_unidad);
		if(!isNaN(valor_costo)){

			if(parseFloat($(Row).find("input[id=valor_facturar]").val())>=parseFloat(valor_costo)){
				$(Row).find("input[id=valor_costo]").val(setFormatCurrency(valor_costo));		
				$(Row).find("input[name=valor_unidad_costo]").removeAttr("readOnly");
				$(Row).find("input[name=valor_costo]").attr("readOnly","true");
			
			}else{
				$(Row).find("input[id=valor_costo]").val("");	
				$(Row).find("input[id=valor_unidad_costo]").val("");	
				 alertJquery("El costo ($"+setFormatCurrency(valor_costo)+") es mayor al valor a Facturar ($"+setFormatCurrency($(Row).find("input[id=valor_facturar]").val())+")!!!","Liquidacion");
			}
		}
		
		 
	 }else if(tipo_liquidacion == 'V'){
		 
			var peso_volumen   = ($(Row).find("input[id=peso_volumen]").val() * 1);
			var valor_unidad   = removeFormatCurrency($(Row).find("input[id=valor_unidad_costo]").val());
			var valor_costo = Math.round(peso_volumen * valor_unidad);
			
			if(!isNaN(valor_costo)){ 
			
				if(parseFloat($(Row).find("input[id=valor_facturar]").val())>=parseFloat(valor_costo)){
					$(Row).find("input[id=valor_costo]").val(setFormatCurrency(valor_costo));		
					$(Row).find("input[name=valor_unidad_costo]").removeAttr("readOnly");
					$(Row).find("input[name=valor_costo]").attr("readOnly","true");
				
				}else{
					$(Row).find("input[id=valor_costo]").val("");	
					$(Row).find("input[id=valor_unidad_costo]").val("");	
					 alertJquery("El costo ($"+setFormatCurrency(valor_costo)+") es mayor al valor a Facturar ($"+setFormatCurrency($(Row).find("input[id=valor_facturar]").val())+")!!!","Liquidacion");
				}
			  
			}
	 }else if(tipo_liquidacion == 'G'){
		 
			var cantidad   = ($(Row).find("input[id=cantidad]").val() * 1);
			var valor_unidad   = removeFormatCurrency($(Row).find("input[id=valor_unidad_costo]").val());
			var valor_costo = (cantidad * valor_unidad);
			
			if(!isNaN(valor_costo)){ 			 			  
			  
				if(parseFloat($(Row).find("input[id=valor_facturar]").val())>=parseFloat(valor_costo)){
					$(Row).find("input[id=valor_costo]").val(setFormatCurrency(valor_costo));		
					$(Row).find("input[name=valor_unidad_costo]").removeAttr("readOnly");
					$(Row).find("input[name=valor_costo]").attr("readOnly","true");
				
				}else{
					$(Row).find("input[id=valor_costo]").val("");	
					$(Row).find("input[id=valor_unidad_costo]").val("");	
					 alertJquery("El costo ($"+setFormatCurrency(valor_costo)+") es mayor al valor a Facturar ($"+setFormatCurrency($(Row).find("input[id=valor_facturar]").val())+")!!!","Liquidacion");
				}
			  
			}	 
		 
		 
	  }else if(tipo_liquidacion == 'C'){
		  
		      $(Row).find("input[id=valor_unidad_costo]").attr("readOnly","true");
		      $(Row).find("input[id=valor_costo]").removeAttr("readOnly");			  
              $(Row).find("input[id=valor_unidad_costo]").val("0");		  
  			  $(Row).find("input[id=valor_costo]").val("");		  
		  
		}						

		var total_cost=0;
		var total_cantidad=0;		
		$(".rowRemesa").each(function(){ 
		   
		   $(this).find("input[name=remesa]").each(function(){
												   
			 if(this.id == 'valor_costo' && this.value!='' ){
				 total_cost = parseFloat(parseFloat(total_cost) + parseFloat(removeFormatCurrency(this.value)));
			 }

			 if(this.id == 'cantidad' && this.value!='' ){
				 total_cantidad = parseFloat(parseFloat(total_cantidad) + parseFloat(removeFormatCurrency(this.value)));
			 }

		   });
		   
		  $("#valor_galon").val(setFormatCurrency(total_cost));
		  $("#valor_flete").val(setFormatCurrency(total_cost));
		  $("#cantidad_galon").val(setFormatCurrency(total_cantidad));
		   
		});

  });


  $("input[id=peso]").keyup(function(){
														
      var Row              = this.parentNode.parentNode;
      var tipo_liquidacion = $(Row).find('select[id=tipo_liquidacion]').val();
					
     if(tipo_liquidacion == 'P'){
		 
		var peso_neto      = (($(Row).find("input[id=peso]").val() * 1) * 0.001);
		var valor_unidad   = removeFormatCurrency($(Row).find("input[id=valor_unidad_costo]").val());
		var valor_costo = Math.round(peso_neto * valor_unidad);
		if(!isNaN(valor_costo)){
			
			if(parseFloat($(Row).find("input[id=valor_facturar]").val())>=parseFloat(valor_costo)){
				$(Row).find("input[id=valor_costo]").val(setFormatCurrency(valor_costo));		
				$(Row).find("input[name=valor_unidad_costo]").removeAttr("readOnly");
				$(Row).find("input[name=valor_costo]").attr("readOnly","true");
			
			}else{
				$(Row).find("input[id=valor_costo]").val("");	
				$(Row).find("input[id=valor_unidad_costo]").val("");	
				 alertJquery("El costo ($"+setFormatCurrency(valor_costo)+") es mayor al valor a Facturar ($"+setFormatCurrency($(Row).find("input[id=valor_facturar]").val())+")!!!","Liquidacion");
			}
			
		}
		
		 
	 }else if(tipo_liquidacion == 'V'){
		 
			var peso_volumen   = ($(Row).find("input[id=peso_volumen]").val() * 1);
			var valor_unidad   = removeFormatCurrency($(Row).find("input[id=valor_unidad_costo]").val());
			var valor_costo = Math.round(peso_volumen * valor_unidad);
			
			if(!isNaN(valor_costo)){ 
			
				if(parseFloat($(Row).find("input[id=valor_facturar]").val())>=parseFloat(valor_costo)){
					$(Row).find("input[id=valor_costo]").val(setFormatCurrency(valor_costo));		
					$(Row).find("input[name=valor_unidad_costo]").removeAttr("readOnly");
					$(Row).find("input[name=valor_costo]").attr("readOnly","true");
				
				}else{
					$(Row).find("input[id=valor_costo]").val("");	
					$(Row).find("input[id=valor_unidad_costo]").val("");	
					 alertJquery("El costo ($"+setFormatCurrency(valor_costo)+") es mayor al valor a Facturar ($"+setFormatCurrency($(Row).find("input[id=valor_facturar]").val())+")!!!","Liquidacion");
				}
			  
			}
	 }else if(tipo_liquidacion == 'G'){
		 
			var cantidad   = ($(Row).find("input[id=cantidad]").val() * 1);
			var valor_unidad   = removeFormatCurrency($(Row).find("input[id=valor_unidad_costo]").val());
			var valor_costo = (cantidad * valor_unidad);
			
			if(!isNaN(valor_costo)){ 			 			  
			  
				if(parseFloat($(Row).find("input[id=valor_facturar]").val())>=parseFloat(valor_costo)){
					$(Row).find("input[id=valor_costo]").val(setFormatCurrency(valor_costo));		
					$(Row).find("input[name=valor_unidad_costo]").removeAttr("readOnly");
					$(Row).find("input[name=valor_costo]").attr("readOnly","true");
				
				}else{
					$(Row).find("input[id=valor_costo]").val("");	
					$(Row).find("input[id=valor_unidad_costo]").val("");	
					 alertJquery("El costo ($"+setFormatCurrency(valor_costo)+") es mayor al valor a Facturar ($"+setFormatCurrency($(Row).find("input[id=valor_facturar]").val())+")!!!","Liquidacion");
				}
			  
			}	 
		 
		 
	  }else if(tipo_liquidacion == 'C'){
		  
		      $(Row).find("input[id=valor_unidad_costo]").attr("readOnly","true");
		      $(Row).find("input[id=valor_costo]").removeAttr("readOnly");			  
              $(Row).find("input[id=valor_unidad_costo]").val("0");		  
  			  $(Row).find("input[id=valor_costo]").val("");		  
		  
		}						

		var total_cost=0;
		var total_peso=0;		
		$(".rowRemesa").each(function(){ 
		   
		   $(this).find("input[name=remesa]").each(function(){
												   
			 if(this.id == 'valor_costo' && this.value!='' ){
				 total_cost = parseFloat(total_cost + removeFormatCurrency(this.value));
			 }

			 if(this.id == 'peso' && this.value!='' ){
				 total_peso = parseFloat(parseFloat(total_peso) + parseFloat(removeFormatCurrency(this.value)));
			 }

		   });
		   
		  $("#valor_galon").val(setFormatCurrency(total_cost));
		  $("#valor_flete").val(setFormatCurrency(total_cost));
		  $("#cantidad_peso").val(setFormatCurrency(total_peso));
		   
		});

  });

  $("input[id=peso_volumen]").keyup(function(){
														
      var Row              = this.parentNode.parentNode;
      var tipo_liquidacion = $(Row).find('select[id=tipo_liquidacion]').val();
					
     if(tipo_liquidacion == 'P'){
		 
		var peso_neto      = (($(Row).find("input[id=peso]").val() * 1) * 0.001);
		var valor_unidad   = removeFormatCurrency($(Row).find("input[id=valor_unidad_costo]").val());
		var valor_costo = Math.round(peso_neto * valor_unidad);
		if(!isNaN(valor_costo)){
			
			if(parseFloat($(Row).find("input[id=valor_facturar]").val())>=parseFloat(valor_costo)){
				$(Row).find("input[id=valor_costo]").val(setFormatCurrency(valor_costo));		
				$(Row).find("input[name=valor_unidad_costo]").removeAttr("readOnly");
				$(Row).find("input[name=valor_costo]").attr("readOnly","true");
			
			}else{
				$(Row).find("input[id=valor_costo]").val("");	
				$(Row).find("input[id=valor_unidad_costo]").val("");	
				 alertJquery("El costo ($"+setFormatCurrency(valor_costo)+") es mayor al valor a Facturar ($"+setFormatCurrency($(Row).find("input[id=valor_facturar]").val())+")!!!","Liquidacion");
			}
			
		}
		
		 
	 }else if(tipo_liquidacion == 'V'){
		 
			var peso_volumen   = ($(Row).find("input[id=peso_volumen]").val() * 1);
			var valor_unidad   = removeFormatCurrency($(Row).find("input[id=valor_unidad_costo]").val());
			var valor_costo = Math.round(peso_volumen * valor_unidad);
			
			if(!isNaN(valor_costo)){ 
			
				if(parseFloat($(Row).find("input[id=valor_facturar]").val())>=parseFloat(valor_costo)){
					$(Row).find("input[id=valor_costo]").val(setFormatCurrency(valor_costo));		
					$(Row).find("input[name=valor_unidad_costo]").removeAttr("readOnly");
					$(Row).find("input[name=valor_costo]").attr("readOnly","true");
				
				}else{
					$(Row).find("input[id=valor_costo]").val("");	
					$(Row).find("input[id=valor_unidad_costo]").val("");	
					 alertJquery("El costo ($"+setFormatCurrency(valor_costo)+") es mayor al valor a Facturar ($"+setFormatCurrency($(Row).find("input[id=valor_facturar]").val())+")!!!","Liquidacion");
				}
			  
			}
	 }else if(tipo_liquidacion == 'G'){
		 
			var cantidad   = ($(Row).find("input[id=cantidad]").val() * 1);
			var valor_unidad   = removeFormatCurrency($(Row).find("input[id=valor_unidad_costo]").val());
			var valor_costo = (cantidad * valor_unidad);
			
			if(!isNaN(valor_costo)){ 			 			  
			  
				if(parseFloat($(Row).find("input[id=valor_facturar]").val())>=parseFloat(valor_costo)){
					$(Row).find("input[id=valor_costo]").val(setFormatCurrency(valor_costo));		
					$(Row).find("input[name=valor_unidad_costo]").removeAttr("readOnly");
					$(Row).find("input[name=valor_costo]").attr("readOnly","true");
				
				}else{
					$(Row).find("input[id=valor_costo]").val("");	
					$(Row).find("input[id=valor_unidad_costo]").val("");	
					 alertJquery("El costo ($"+setFormatCurrency(valor_costo)+") es mayor al valor a Facturar ($"+setFormatCurrency($(Row).find("input[id=valor_facturar]").val())+")!!!","Liquidacion");
				}
			}	 
		 
		 
	  }else if(tipo_liquidacion == 'C'){
		  
		      $(Row).find("input[id=valor_unidad_costo]").attr("readOnly","true");
		      $(Row).find("input[id=valor_costo]").removeAttr("readOnly");			  
              $(Row).find("input[id=valor_unidad_costo]").val("0");		  
  			  $(Row).find("input[id=valor_costo]").val("");		  
		  
		}						

		var total_cost=0;
		var total_peso_volumen=0;		
		$(".rowRemesa").each(function(){ 
		   
		   $(this).find("input[name=remesa]").each(function(){
												   
			 if(this.id == 'valor_costo' && this.value!='' ){
				 total_cost = parseFloat(parseFloat(total_cost) + parseFloat(removeFormatCurrency(this.value)));
			 }

			 if(this.id == 'peso_volumen' && this.value!='' ){
				 total_peso_volumen = parseFloat(parseFloat(total_peso_volumen) + parseFloat(removeFormatCurrency(this.value)));
			 }

		   });
		   
		  $("#valor_galon").val(setFormatCurrency(total_cost));
		  $("#valor_flete").val(setFormatCurrency(total_cost));
		  $("#cantidad_volu").val(setFormatCurrency(total_peso_volumen));
		   
		});

  });

 $("input[id=valor_costo]").keyup(function(){
														
      var Row              = this.parentNode.parentNode;
      var tipo_liquidacion = $(Row).find('select[id=tipo_liquidacion]').val();
					
     if(tipo_liquidacion == 'C'){
		 
		var valor_costo   = removeFormatCurrency($(Row).find("input[id=valor_costo]").val());
		var valor_costo = parseFloat(valor_costo);
		if(!isNaN(valor_costo)){
			
			if(parseFloat($(Row).find("input[id=valor_facturar]").val())>=parseFloat(valor_costo)){
				$(Row).find("input[id=valor_costo]").val(setFormatCurrency(valor_costo));		
				$(Row).find("input[name=valor_unidad_costo]").attr("readOnly","true");
			
			}else{
				$(Row).find("input[id=valor_costo]").val("");	
				$(Row).find("input[id=valor_unidad_costo]").val("0");	
				 alertJquery("El costo ($"+setFormatCurrency(valor_costo)+") es mayor al valor a Facturar ($"+setFormatCurrency($(Row).find("input[id=valor_facturar]").val())+")!!!","Liquidacion");
			}
			
		}
		
		 
	 }

		var total_cost=0;
		var total_peso_volumen=0;		
		$(".rowRemesa").each(function(){ 
		   
		   $(this).find("input[name=remesa]").each(function(){
												   
			 if(this.id == 'valor_costo' && this.value!='' ){
				 total_cost = parseFloat(parseFloat(total_cost) + parseFloat(removeFormatCurrency(this.value)));
			 }

			 if(this.id == 'peso_volumen' && this.value!='' ){
				 total_peso_volumen = parseFloat(parseFloat(total_peso_volumen) + parseFloat(removeFormatCurrency(this.value)));
			 }

		   });
		   
		  $("#valor_galon").val(setFormatCurrency(total_cost));
		  $("#valor_flete").val(setFormatCurrency(total_cost));
		  $("#cantidad_volu").val(setFormatCurrency(total_peso_volumen));
		   
		});

  });

}



function validarFechaHoraRemesa(manifiesto_id){ //nuevo cambio 13/08/2019
	

	var QueryString   = 'ACTIONCONTROLER=setRemesa&manifiesto_id='+manifiesto_id;

	$.ajax({
		url        : "LiquidacionClass.php?rand="+Math.random(),
		data       : QueryString,
		beforeSend : function(){
			showDivLoading();
		},
		success    : function(resp){
			try{
				removeDivLoading();
				var remesa = $.parseJSON(resp);

				var fecha_recogida_ss=remesa[0]['fecha_recogida_ss'];
				var hora_recogida_ss = remesa[0]['hora_recogida_ss'];

				var fecha_llegada_descargue = $('#fecha_llegada_descargue').val();
				var hora_llegada_descargue = $('#hora_llegada_descargue').val();

				if (fecha_llegada_descargue == fecha_recogida_ss){

					if(hora_llegada_descargue<hora_recogida_ss){

						if($('#hora_llegada_descargue').val()!=''){

							alertJquery("La hora de llegada debe ser mayor a la hora de recojida de la remesa : "+hora_recogida_ss+"","validacion de hora");
							$('#hora_llegada_descargue').val('');

						}
					}

				}

				if (fecha_llegada_descargue < fecha_recogida_ss){

					alertJquery("La fecha de llegada - descargue : "+fecha_llegada_descargue+" debe ser mayor o igual a la fecha de recojida de la remesa : "+fecha_recogida_ss+"","validacion de fecha");
					$('#fecha_llegada_descargue').val('');

				}



				console.log("fecha_recogida_ss : "+fecha_recogida_ss+"\n hora_recogida_ss : "+hora_recogida_ss);



			}catch(e){

				alertJquery("Se presento un error :"+e,"Error");

			}
		} 
	});


}

function setDataFormWithResponse(liquidacion_despacho_id){
	
	var formulario  = document.forms[0];	
	var QueryString = "ACTIONCONTROLER=onclickFind&liquidacion_despacho_id="+liquidacion_despacho_id;
	
	$.ajax({
	  url        : "LiquidacionClass.php?rand="+Math.random(),
	  data       : QueryString,
	  beforeSend : function(){
		  showDivLoading();
	  },
      success    : function(resp){
		  
	    Reset(formulario);
        clearFind();	
        setFocusFirstFieldForm(formulario);	
	    clearDataForm(formulario);
	    clearRowAnticipos();
	    clearCostos();	
		clearRowTiempos();
		clearRowRemesa();
	
	    $("#concepto").val("LIQUIDACION MC: ");
	    $("#fecha").val($("#fecha_static").val());			  
		  				
		try{
			
		 var data                   = $.parseJSON(resp); 		 
		 var encabezado_registro_id = $.trim(data[0]['encabezado_registro_id']);
		 var estado_liquidacion     = data[0]['estado_liquidacion'];
		 var remesa_dat             = data[0]['remesa_dat'];
		 var tiempos_dat            = data[0]['tiempos_dat'];
		 var impuestos              = data[0]['impuestos'];
		 var descuentos             = data[0]['descuentos'];
		 var anticipos              = data[0]['anticipos'];						 
		 var valor_flete            = data[0]['valor_flete'];						 
		 var valor_sobre_flete      = data[0]['valor_sobre_flete'];						 		 
		 var valor_neto_pagar       = data[0]['valor_neto_pagar'];						 						 
		 var saldo_por_pagar        = data[0]['saldo_por_pagar'];						 						  

		 var peso_total      		= data[0]['peso_total'];						 		 
		 var peso_vol_total      	= data[0]['peso_vol_total'];						 		 
    	 var cantidad_total      	= data[0]['cantidad_total'];	
	     var valor_costos      	= data[0]['valor_costos'];
	     var reportado_ministerio3	= data[0]['reportado_ministerio3'];			  

		 var totalImpuestos         = 0;
		 var totalDescuentos        = 0;
		 var totalAnticipos         = 0; 

		  var Tabla_rem      = document.getElementById('remesas_reg');
		  var rowRemesa      = document.getElementById('rowRemesa');	

		  var Tabla_tie      = document.getElementById('tiempos_reg');
		  var rowTiempos     = document.getElementById('rowTiempos');	

		 var Tabla           = document.getElementById('tableLiquidacion');
		 var rowImpuestos    = document.getElementById('rowImpuestos');			  
		 var rowDescuentos   = document.getElementById('rowDescuentos');			  
		 var rowAnticipos    = document.getElementById('rowAnticipos');
		 var manifiesto_id   = data[0]['manifiesto_id'];
		 var numRow          = 2;		 
		 
         setFormWithJSON(formulario,resp,true);		 
				
		$("#valor_flete").val(valor_flete);
		$("#valor_sobre_flete").val(valor_sobre_flete);		
		$("#valor_neto_pagar").val(valor_neto_pagar);
		$("#saldo_por_pagar").val(saldo_por_pagar);						

		$("#cantidad_peso").val(peso_total);		
		$("#cantidad_volu").val(peso_vol_total);
		$("#cantidad_galon").val(cantidad_total);
		$("#valor_galon").val(valor_costos);

		if(tiempos_dat){
		
		 for(var i = 0; i < tiempos_dat.length; i++){
			 
			 if(i == 0){
													
				 $(rowTiempos).find("input[name=tiempos]").each(function(){
						
					var input = this;

					
					for(var llave in tiempos_dat[0]){
													
					  if(input.id == llave){
						  input.value = tiempos_dat[0][llave];
						  
					  }
					  
					
					}
																			 
				 });							 
				 
			 }else{

				  var newRow       = Tabla_tie.insertRow(numRow);
				  newRow.className = 'rowTiempos';
				  newRow.innerHTML = rowTiempos.innerHTML;
				  
				 $(newRow).find("input[name=tiempos]").each(function(){
						
					var input = this;
					
					for(var llave in tiempos_dat[i]){
					
					  if(input.id == llave){
						  input.value = tiempos_dat[i][llave];
					  }
					
					}
																			 
				 });


			 numRow++;                              
			 }
			 
			 
		 }
		 
	 }
				
		 numRow=2;	

		if(remesa_dat){
		
		 for(var i = 0; i < remesa_dat.length; i++){
			 
			 if(i == 0){
													
				 $(rowRemesa).find("input[name=remesa]").each(function(){
						
					var input = this;

					
					for(var llave in remesa_dat[0]){
													
					  if(input.id == llave){
						  input.value = remesa_dat[0][llave];
						  
					  }
					  if(llave == 'tipo_liquidacion'){ 
						  $('#tipo_liquidacion option[value='+remesa_dat[0][llave]+']').attr('selected', true);
						  //input.selected = (input.value == (remesa_dat[0][llave]));
						  
					  }
					  
					
					}
																			 
				 });							 
				 
			 }else{

				  var newRow       = Tabla_rem.insertRow(numRow);
				  newRow.className = 'rowRemesa';
				  newRow.innerHTML = rowRemesa.innerHTML;
				  
				 $(newRow).find("input[name=remesa]").each(function(){
						
					var input = this;
					
					for(var llave in remesa_dat[i]){
					
					  if(input.id == llave){
						  input.value = remesa_dat[i][llave];
					  }
					  if(llave == 'tipo_liquidacion'){ 
						  $('#tipo_liquidacion option[value='+remesa_dat[0][llave]+']').attr('selected', true);
						  //input.selected = (input.value == (remesa_dat[0][llave]));
						  
					  }
					  
					
					}
																			 
				 });
		     setValorLiquidacion();
			 numRow++;                              
			 }
			 
			 
		 }
		 
	 }
				
		 numRow=2;	


		if(impuestos){
		
		 for(var i = 0; i < impuestos.length; i++){
			 
			 if(i == 0){
													
				 $(rowImpuestos).find("input[name=impuestos]").each(function(){
						
					var input = this;
					
					for(var llave in impuestos[0]){
														
					  if(input.id == llave){
						  input.value = impuestos[0][llave];
						  
						  if(llave == 'valor'){
							  totalImpuestos += (impuestos[0][llave] * 1);										  
						  }
						  
					  }
					
					}
																			 
				 });							 
				 
			 }else{

				  var newRow       = Tabla.insertRow(numRow);
				  newRow.className = 'rowImpuestos';
				  newRow.innerHTML = rowImpuestos.innerHTML;
				  
				 $(newRow).find("input[name=impuestos]").each(function(){
						
					var input = this;
					
					for(var llave in impuestos[i]){
					
					  if(input.id == llave){
						  input.value = impuestos[i][llave];
						  
						  if(llave == 'valor'){
							  totalImpuestos += (impuestos[i][llave] * 1);
						  }									  
						  
					  }
					
					}
																			 
				 });

			 numRow++;                              
			 }
			 
			 
		 }
		 
		 
	    }
				
		 numRow++;		
		 
	  if(descuentos){	 
				
		 for(var i = 0; i < descuentos.length; i++){
			 
			 if(i == 0){
													
				 $(rowDescuentos).find("input[name=descuentos]").each(function(){
						
					var input = this;
					
					for(var llave in descuentos[0]){
														
					  if(input.id == llave){
						  input.value = descuentos[0][llave];
						  
						  if(llave == 'valor'){
							  totalDescuentos += (descuentos[0][llave] * 1);										  
						  }
						  
					  }
					
					}
																			 
				 });							 
				 
			 }else{

				  var newRow       = Tabla.insertRow(numRow);
				  newRow.className = 'rowDescuentos';
				  newRow.innerHTML = rowDescuentos.innerHTML;
												  
				 $(newRow).find("input[name=descuentos]").each(function(){
						
					var input = this;
					
					for(var llave in descuentos[i]){
					
					  if(input.id == llave){
						  input.value = descuentos[i][llave];
						  
						  if(llave == 'valor'){
							  totalDescuentos += (descuentos[i][llave] * 1);
						  }									  
						  
					  }
					
					}
																			 
				 });

			 numRow++;                              
			 }
			 
			 
		 }	
		 
	   }
				
				
      if(anticipos){				
				
		 for(var i = 0; i < anticipos.length; i++){
			 
			 if(i == 0){
													
				 $(rowAnticipos).find("input[name=anticipos]").each(function(){
						
					var input = this;
					
					for(var llave in anticipos[0]){
														
					  if(input.id == llave){
						  input.value = anticipos[0][llave];
						  
						  if(llave == 'valor'){
							  totalAnticipos += (anticipos[0][llave] * 1);										  
						  }
						  
					  }
					
					}
																			 
				 });							 
				 
			 }else{

				  var newRow       = Tabla.insertRow(numRow);
				  newRow.className = 'rowAnticipos';
				  newRow.innerHTML = rowAnticipos.innerHTML;
				  
				 $(newRow).find("input[name=anticipos]").each(function(){
						
					var input = this;
					
					for(var llave in anticipos[i]){
					
					  if(input.id == llave){
						  input.value = anticipos[i][llave];
						  
						  if(llave == 'valor'){
							  totalAnticipos += (anticipos[i][llave] * 1);
						  }									  
						  
					  }
					
					}
																			 
				 });

			 numRow++;                              
			 }
			 
			 
		 } 
		 
	  
	  }
		 
		
        removeDivLoading();
		validaTipoDescuento();			
		
		if($("#guardar"))        $("#guardar").attr("disabled","true");
		if($("#imprimir"))       $("#imprimir").attr("disabled","");
		if(reportado_ministerio3 == 1 || estado_liquidacion == 'A' || estado_liquidacion == 'C'){
			$("#anular").attr("disabled","true");
		}else{
			$("#anular").attr("disabled","");
		}
		
		if(estado_liquidacion == 'L' || estado_liquidacion == 'C' ){
		  if($("#actualizar"))     $("#actualizar").attr("disabled","");				
		  if($("#calcularFlete"))  $("#calcularFlete").attr("disabled","");						  
		}else{
		    if($("#actualizar"))     $("#actualizar").attr("disabled","true");				
		    if($("#calcularFlete"))  $("#calcularFlete").attr("disabled","true");							
		  }
		
		
		}catch(e){
			 alertJquery(resp,"Error : "+e);
		  }
		
	  }
		
    });

}

function LiquidacionManifiestoOnSaveOnUpdateonDelete(formulario,resp){

   //LiquidacionManifiestoOnReset(formulario);
   
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
   if($('#anular'))    $('#anular').attr("disabled","true");
	
}

function LiquidacionManifiestoOnReset(formulario){
	
	Reset(formulario);
    clearFind();	
    setFocusFirstFieldForm(formulario);	
	clearDataForm(formulario);
	clearRowAnticipos();
	clearRowTiempos();
	clearCostos();	
	clearRowRemesa();
	
	$("#concepto").val("LIQUIDACION MC: ");
	$("#fecha").val($("#fecha_static").val());	
	
	$("#refresh_QUERYGRID_LiquidacionManifiestos").click();
			
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");	
	if($("#imprimir"))       $("#imprimir").attr("disabled","true");	
}

function addRowCosto(obj){  	
       
  $("input[name=add]").click(function(){
						
      var row      = this.parentNode.parentNode;						
	  var table    = row.parentNode;
	  var indexRow = row.rowIndex;
						
      var newRow           = table.insertRow(indexRow);
          newRow.className = 'rowCostos';
          newRow.innerHTML = row.innerHTML;									  
		  
		  autocompleteProveedor();
		  addRowCosto();
		  
          $(row).find("input[name=add]").replaceWith("<input type='button' name='remove' id='remove' value=' - ' />");	
		  removeRowCosto();
		  calculaTotalCosto();
		  calculaDiferencia();
									  
  });

}

function removeRowCosto(){
  
    
	$("input[name=remove]").click(function(){
										   
        var row = this.parentNode.parentNode;
		
		$(row).remove();		
	    calculaTotalCosto();
		calculaDiferencia();
										   
    });
  
  
}

function getDataManifiesto(manifiesto_id,manifiesto,obj){
		   	   
	   if(manifiesto_id > 0){
	
		   var formulario  = obj.form;	   		   
		   var manifiesto  = manifiesto.split("-");
		       manifiesto  = manifiesto[0];
		   var QueryString = "ACTIONCONTROLER=getDataManifiesto&manifiesto="+manifiesto+"&manifiesto_id="+manifiesto_id;
				   
		   LiquidacionManifiestoOnReset(formulario);	   
					  
          if(!isNaN(parseInt(manifiesto_id))){	    
		   
		   $.ajax({
			 url        : "LiquidacionClass.php?rand="+Math.random(),
			 data       : QueryString,
			 beforeSend : function(){
				showDivLoading();
				clearRowAnticipos();
				clearCostos();
				clearRowTiempos();
				clearRowRemesa();
			 },
			 success    : function(resp){
									 
			   try{
						 
				 var data = $.parseJSON(resp); 
														 
				 setFormWithJSON(formulario,resp,true);
				 
				 var concepto = $("#concepto").val();
				 $("#concepto").val(concepto+' '+manifiesto);
				 
				 removeDivLoading();
				  var Tabla_rem     = document.getElementById('remesas_reg');
				  var rowRemesa  = document.getElementById('rowRemesa');	

				  var Tabla_tie     = document.getElementById('tiempos_reg');
				  var rowTiempos  = document.getElementById('rowTiempos');	

				  var Tabla         = document.getElementById('tableLiquidacion');
				  var rowImpuestos  = document.getElementById('rowImpuestos');			  
				  var rowDescuentos = document.getElementById('rowDescuentos');			  
				  var rowAnticipos  = document.getElementById('rowAnticipos');
				  var manifiesto_id = data[0]['manifiesto_id'];
				  var numRow        = 2;
				  
				  QueryString  = "ACTIONCONTROLER=getLiquidacionManifiesto&manifiesto_id="+manifiesto_id;
				  
				  $.ajax({
					url        : "LiquidacionClass.php?rand="+Math.random(),
					data       : QueryString,
					beforeSend : function(){
					  showDivLoading();
					},
					success    : function(resp){
											
					  try{
											  
						 if($.trim(resp).length == 0 || resp == 'null'){
													
							alertJquery("<p align='center'>Este manifiesto no tiene anticipos !! <br> No se puede legalizar</p>","Validacion Liquidacion"); 
							Reset(formulario);
							return true;
							 
						 }else{
										
							 var data            = $.parseJSON(resp); 
							 var tiempos_dat       = data[0]['tiempos_dat'];
							 var remesa_dat       = data[0]['remesa_dat'];
							 var impuestos       = data[0]['impuestos'];
							 var descuentos      = data[0]['descuentos'];
							 var anticipos       = data[0]['anticipos'];						 
							 var valor_flete     = data[0]['valor_flete'];	
							 var valor_sobre_flete = data[0]['valor_sobre_flete'];	
							 var valor_neto_pagar= data[0]['valor_neto_pagar'];						 						 
							 var saldo_por_pagar = data[0]['saldo_por_pagar'];		
							 
							 var peso_total      		= data[0]['peso_total'];						 		 
							 var peso_vol_total      	= data[0]['peso_vol_total'];						 		 
							 var cantidad_total      	= data[0]['cantidad_total'];	
							  var valor_costos      	= data[0]['valor_costos'];
							 
							 var totalImpuestos  = 0;
							 var totalDescuentos = 0;
							 var totalAnticipos  = 0; 
									
							$("#valor_flete").val(valor_flete);
							$("#valor_sobre_flete").val(valor_sobre_flete);							
							$("#valor_neto_pagar").val(valor_neto_pagar);
							$("#saldo_por_pagar").val(saldo_por_pagar);	
							
							$("#cantidad_peso").val(peso_total);		
							$("#cantidad_volu").val(peso_vol_total);
							$("#cantidad_galon").val(cantidad_total);
							$("#valor_galon").val(valor_costos);
							
							
							if(remesa_dat){
							
							 for(var i = 0; i < remesa_dat.length; i++){
								 
								 if(i == 0){
																		
									 $(rowRemesa).find("input[name=remesa]").each(function(){
											
										var input = this;
										
										for(var llave in remesa_dat[0]){
																		
										  if(input.id == llave){
											  input.value = remesa_dat[0][llave];
											  
										  }
										  if(llave == 'tipo_liquidacion'){
											  $('#tipo_liquidacion option[value='+remesa_dat[0][llave]+']').attr('selected', true);
											  
										  }
										
										}
																								 
									 });							 
									 
								 }else{
		
									  var newRow       = Tabla_rem.insertRow(numRow);
									  newRow.className = 'rowRemesa';
									  newRow.innerHTML = rowRemesa.innerHTML;
									  
									 $(newRow).find("input[name=remesa]").each(function(){
											
										var input = this;
										
										for(var llave in remesa_dat[i]){
										
										  if(input.id == llave){
											  input.value = remesa_dat[i][llave];
										  }
										  if(llave == 'tipo_liquidacion'){
											  $('#tipo_liquidacion option[value='+remesa_dat[0][llave]+']').attr('selected', true);
											  
										  }
										
										}
																								 
									 });
								 setValorLiquidacion();
								 numRow++;                              
								 }
								 
								 
							 }
							 
						 }

							numRow  = 2;	
							
							if(tiempos_dat){
							
							 for(var i = 0; i < tiempos_dat.length; i++){
								 
								 if(i == 0){
																		
									 $(rowTiempos).find("input[name=tiempos]").each(function(){
											
										var input = this;
					
										
										for(var llave in tiempos_dat[0]){
																		
										  if(input.id == llave){
											  input.value = tiempos_dat[0][llave];
											  
										  }
										  
										
										}
																								 
									 });							 
									 
								 }else{
					
									  var newRow       = Tabla_tie.insertRow(numRow);
									  newRow.className = 'rowTiempos';
									  newRow.innerHTML = rowTiempos.innerHTML;
									  
									 $(newRow).find("input[name=tiempos]").each(function(){
											
										var input = this;
										
										for(var llave in tiempos_dat[i]){
										
										  if(input.id == llave){
											  input.value = tiempos_dat[i][llave];
										  }
										
										}
																								 
									 });
								
								 numRow++;                              
								 }
								 
								 
							 }
							 
						 }
									
							 numRow  = 2;
							
							if(impuestos){
							
							 for(var i = 0; i < impuestos.length; i++){
								 
								 if(i == 0){
																		
									 $(rowImpuestos).find("input[name=impuestos]").each(function(){
											
										var input = this;
										
										for(var llave in impuestos[0]){
																			
										  if(input.id == llave){
											  input.value = impuestos[0][llave];
											  
											  if(llave == 'valor'){
												  totalImpuestos += (impuestos[0][llave] * 1);										  
											  }
											  
										  }
										
										}
																								 
									 });							 
									 
								 }else{
		
									  var newRow       = Tabla.insertRow(numRow);
									  newRow.className = 'rowImpuestos';
									  newRow.innerHTML = rowImpuestos.innerHTML;
									  
									 $(newRow).find("input[name=impuestos]").each(function(){
											
										var input = this;
										
										for(var llave in impuestos[i]){
										
										  if(input.id == llave){
											  input.value = impuestos[i][llave];
											  
											  if(llave == 'valor'){
												  totalImpuestos += (impuestos[i][llave] * 1);
											  }									  
											  
										  }
										
										}
																								 
									 });
		
								 numRow++;                              
								 }
								 
								 
							 }
							 
						 }
									
							 numRow++;	
							 numRow++;	
							 
						if(descuentos)	{									 

									
							 for(var i = 0; i < descuentos.length; i++){
								 
								 if(i == 0){
																		
									 $(rowDescuentos).find("input[name=descuentos]").each(function(){
											
										var input = this;
										
										for(var llave in descuentos[0]){
																			
										  if(input.id == llave){
											  input.value = descuentos[0][llave];
											  
											  if(llave == 'valor'){
												  totalDescuentos += (descuentos[0][llave] * 1);										  
											  }
											  
										  }
										
										}
																								 
									 });							 
									 
								 }else{
		
									  var newRow       = Tabla.insertRow(numRow);
									  newRow.className = 'rowDescuentos';
									  newRow.innerHTML = rowDescuentos.innerHTML;
																	  
									 $(newRow).find("input[name=descuentos]").each(function(){
											
										var input = this;
										
										for(var llave in descuentos[i]){
										
										  if(input.id == llave){
											  input.value = descuentos[i][llave];
											  
											  if(llave == 'valor'){
												  totalDescuentos += (descuentos[i][llave] * 1);
											  }									  
											  
										  }
										
										}
																								 
									 });
		
								 numRow++;                              
								 }
								 
								 
							 }
							 
							 
						 }
									

						  if(anticipos){
									
							 for(var i = 0; i < anticipos.length; i++){
								 
								 if(i == 0){
																		
									 $(rowAnticipos).find("input[name=anticipos]").each(function(){
											
										var input = this;
										
										for(var llave in anticipos[0]){
																			
										  if(input.id == llave){
											  input.value = anticipos[0][llave];
											  
											  if(llave == 'valor'){
												  totalAnticipos += (anticipos[0][llave] * 1);										  
											  }
											  
										  }
										
										}
																								 
									 });							 
									 
								 }else{
		
									  var newRow       = Tabla.insertRow(numRow);
									  newRow.className = 'rowAnticipos';
									  newRow.innerHTML = rowAnticipos.innerHTML;
									  
									 $(newRow).find("input[name=anticipos]").each(function(){
											
										var input = this;
										
										for(var llave in anticipos[i]){
										
										  if(input.id == llave){
											  input.value = anticipos[i][llave];
											  
											  if(llave == 'valor'){
												  totalAnticipos += (anticipos[i][llave] * 1);
											  }									  
											  
										  }
										
										}
																								 
									 });
		
								 numRow++;                              
								 }
								 
								 
							 }
							 
							 
						 }
							 
						 
						}
						  
					  }catch(e){
						   alertJquery(resp,"Error :"+e);
						}                 
	
					  removeDivLoading();
					  validaTipoDescuento();	
					}
					
				  });		
				  
			   }catch(e){
				   
				   alertJquery(resp,"Manifiesto : "+manifiesto);
				   LiquidacionManifiestoOnReset(formulario);
				   
				 }
				 
		 
			 }
			 
		   });	
				 
	     }
		 
	  }
		
}


function setProveedor(id,text,obj){
	
 var row = obj.parentNode.parentNode;
 
 $(row).find("#tercero_id").val(id);

}

function clearRowAnticipos(){
	
   $(".rowAnticipos").each(function(){
									
       if(this.id != 'rowAnticipos'){
		   $(this).remove();
	   }									
									
   });
     
	
}
function clearRowTiempos(){
	
   $(".rowTiempos").each(function(){
									
       if(this.id != 'rowTiempos'){
		   $(this).remove();
	   }									
									
   });
     
	
}

function clearRowRemesa(){
	
   $(".rowRemesa").each(function(){
									
       if(this.id != 'rowRemesa'){
		   $(this).remove();
	   }									
									
   });
     
	
}
function clearCostos(){

  $(".rowCostos").each(function(){									 
	 $(this).remove();	 
  });
  
  $("#rowCostos").find("select,input").each(function(){														   
													 
      if(this.type == 'select-one'){
		 this.value = 'NULL';
	  }else{
		  
		  if(this.name == 'remove'){
			  
	         $(this).replaceWith('<input type="button" name="add" id="add" value=" + " />');													   
             addRowCosto();														   			  
			  
		  }else if(this.name != 'add'){
			  
			   this.value = '';
			  
			}
		  
		}													 
		
  });
  

}

function autocompleteProveedor(){
	
  $("input[id=tercero]").keypress(function(event){
      ajax_suggest(this,event,"tercero","null",setProveedor,null,document.forms[0]);    
  });
  
}


function calculaTotalCosto(){	
	
	var total_costos_viaje = 0;
	
    $("input[name=costos_viaje]&&input[id=valor]").each(function(){
        total_costos_viaje += (this.value * 1);
    });
	
	$("#total_costos_viaje").val(total_costos_viaje);
	
}

function calculaDiferencia(){
	
	var diferencia         = 0;
	var total_anticipos    = ($("#total_anticipos").val() * 1);
	var total_costos_viaje = ($("#total_costos_viaje").val() * 1);
	    diferencia         = (total_anticipos - total_costos_viaje);
	
	$("#diferencia").val(Math.abs(diferencia));

}


function onclickSave(objId,formulario){

      var obj               = document.getElementById(objId);
	  var formulario        = obj.form;	   
	  var anticipos         = '';
	  var impuestos         = '';
	  var descuentos        = '';
	  var tiempos        	= '';
	  var remesa        	= '';
	  var contAnticipos     = 0;
	  var contImpuestos     = 0;
	  var contDescuentos    = 0;
	  var contTiempos 		=0;
  	  var contRemesa 		=0;
	  var fletes            = '';
	  	  
	  var QueryString       = '';	
	  var tableLiquidacion  = document.getElementById('tableLiquidacion');
	  var tiempos_reg  = document.getElementById('tiempos_reg');
	  var remesas_reg  = document.getElementById('remesas_reg');
						  
	  $(tableLiquidacion).find(".rowImpuestos").each(function(){			
			
		var rowImpuesto             = this;	
		var impuestos_manifiesto_id = '';
		var impuesto_id             = '';
		var nombre                  = '';
		var valor                   = '';
				
		$(rowImpuesto).find("input[name=impuestos]").each(function(){   
									
			if(this.id == 'impuestos_manifiesto_id'){
			   impuestos += '&impuestos['+contImpuestos+'][impuestos_manifiesto_id]='+this.value;							
			}else if(this.id == 'impuesto_id'){
				 impuestos += '&impuestos['+contImpuestos+'][impuesto_id]='+this.value;	
			}else if(this.id == 'nombre'){
				   impuestos += '&impuestos['+contImpuestos+'][nombre]='+this.value;	
			 }else if(this.id == 'base'){
					 impuestos += '&impuestos['+contImpuestos+'][base]='+this.value;	
			  }else if(this.id == 'valor'){
					 impuestos += '&impuestos['+contImpuestos+'][valor]='+this.value;	
			  }
			
															 
		});
		
		contImpuestos++;
								 
	  });		  
	  
	  QueryString += impuestos;		  	  
	  
	  $(tableLiquidacion).find(".rowDescuentos").each(function(){
															   				
		var descuento_id = '';
		var nombre       = '';
		var valor        = '';
				
		$(this).find("input[name=descuentos]").each(function(){   
				
			if(this.id == 'descuentos_manifiesto_id'){
			   descuentos += '&descuentos['+contDescuentos+'][descuentos_manifiesto_id]='+this.value;													
			}else if(this.id == 'descuento_id'){
				 descuentos += '&descuentos['+contDescuentos+'][descuento_id]='+this.value;							
			}else if(this.id == 'nombre'){
				   descuentos += '&descuentos['+contDescuentos+'][nombre]='+this.value;	
			 }else if(this.id == 'valor'){
					 descuentos += '&descuentos['+contDescuentos+'][valor]='+this.value;	
			  }
			
															 
		});
		
		contDescuentos++;
																 
	  });		  
	  
	  QueryString += descuentos;				  
	  	  
	  $(tableLiquidacion).find(".rowAnticipos").each(function(){
		
		var anticipos_manifiesto_id = '';
		var conductor               = '';
		var conductor_id            = '';
		var valor                   = '';
		var observaciones           = '';			
			
		$(this).find("input[name=anticipos]").each(function(){   
									
			if(this.id == 'anticipos_manifiesto_id'){
			   anticipos += '&anticipos['+contAnticipos+'][anticipos_manifiesto_id]='+this.value;							
			}else if(this.id == 'tenedor'){
				 anticipos += '&anticipos['+contAnticipos+'][tenedor]='+this.value;	
			}else if(this.id == 'tenedor_id'){
				   anticipos += '&anticipos['+contAnticipos+'][tenedor_id]='+this.value;	
			 }else if(this.id == 'valor'){
					 anticipos += '&anticipos['+contAnticipos+'][valor]='+this.value;	
			  }else if(this.id == 'numero'){
					 anticipos += '&anticipos['+contAnticipos+'][numero]='+this.value;	
			  }
			
															 
		});
			
		contAnticipos++;
															 
	  });		  
	  
	  QueryString += anticipos;

	  $(tiempos_reg).find(".rowTiempos").each(function(){
		
		var tiempos_clientes_remesas_id = '';
		var fecha_llegada_descargue     = '';
		var hora_llegada_descargue      = '';
		var fecha_entrada_descargue     = '';
		var hora_entrada_descargue      = '';		
		var fecha_salida_descargue      = '';		
		var hora_salida_descargue       = '';		
			
		$(this).find("input[name=tiempos]").each(function(){   
									
			if(this.id == 'tiempos_clientes_remesas_id'){
			    tiempos += '&tiempos['+contTiempos+'][tiempos_clientes_remesas_id]='+this.value;							
			}else if(this.id == 'fecha_llegada_descargue'){
				tiempos += '&tiempos['+contTiempos+'][fecha_llegada_descargue]='+this.value;	
			}else if(this.id == 'hora_llegada_descargue'){
				tiempos += '&tiempos['+contTiempos+'][hora_llegada_descargue]='+this.value;	
			}else if(this.id == 'fecha_entrada_descargue'){
				tiempos += '&tiempos['+contTiempos+'][fecha_entrada_descargue]='+this.value;	
			}else if(this.id == 'hora_entrada_descargue'){
				tiempos += '&tiempos['+contTiempos+'][hora_entrada_descargue]='+this.value;	
			}else if(this.id == 'fecha_salida_descargue'){
				tiempos += '&tiempos['+contTiempos+'][fecha_salida_descargue]='+this.value;	
			}else if(this.id == 'hora_salida_descargue'){
				tiempos += '&tiempos['+contTiempos+'][hora_salida_descargue]='+this.value;	
				
			}
			
															 
		});
			
		contTiempos++;
															 
	  });		  
	  
	  QueryString += tiempos;

	  $(remesas_reg).find(".rowRemesa").each(function(){
		
		var remesa_id = '';
		var cantidad     = '';
		var peso      = '';
		var peso_volumen     = '';
		var tipo_liquidacion      = '';		
		var valor_unidad_costo      = '';		
		var valor_costo       = '';	
		var estado       = '';	
		var numero_remesa       = '';			
			
		$(this).find("input[name=remesa]").each(function(){   
									
			if(this.id == 'remesa_id'){
			    remesa += '&remesa['+contRemesa+'][remesa_id]='+this.value;							
			}else if(this.id == 'cantidad'){
				remesa += '&remesa['+contRemesa+'][cantidad]='+this.value;	
			}else if(this.id == 'peso'){
				remesa += '&remesa['+contRemesa+'][peso]='+this.value;	
			}else if(this.id == 'peso_volumen'){
				remesa += '&remesa['+contRemesa+'][peso_volumen]='+this.value;	
			}else if(this.id == 'tipo_liquidacion'){
				remesa += '&remesa['+contRemesa+'][tipo_liquidacion]='+this.value;	
			}else if(this.id == 'valor_unidad_costo'){
				remesa += '&remesa['+contRemesa+'][valor_unidad_costo]='+this.value;
			}else if(this.id == 'estado'){
				remesa += '&remesa['+contRemesa+'][estado]='+this.value;
			}else if(this.id == 'numero_remesa'){
				remesa += '&remesa['+contRemesa+'][numero_remesa]='+this.value;	
			}else if(this.id == 'valor_costo'){
				remesa += '&remesa['+contRemesa+'][valor_costo]='+this.value;	
				
			}
			
															 
		});
			
		contRemesa++;
															 
	  });		  
	  
	  QueryString += remesa;

      if(ValidaRequeridos(formulario)){
		  		 		   
		   var QueryString  = 'ACTIONCONTROLER=onclickSave&'+FormSerialize(formulario)+QueryString;
		   
		   $.ajax({
		     url        : "LiquidacionClass.php?rand="+Math.random(),
			 data       : QueryString,
			 beforeSend : function(){
				showDivLoading();
			 },
			 success  : function(resp){				
			 			 
			     var liquidacion_despacho_id = parseInt(resp);
				 
				 if(!isNaN(liquidacion_despacho_id)){
					 
				 	 $("#refresh_QUERYGRID_LiquidacionManifiestos").click();	
					 
					 var url = "LiquidacionClass.php?ACTIONCONTROLER=onclickPrint&liquidacion_despacho_id="+liquidacion_despacho_id+"&rand="+Math.random();
					 
					 popPup(url,10,900,600);
					 
					 cumplirManifiestoCargaMinisterio();	
//					 document.location.href = "LiquidacionDespachosClass.php?"+QueryString;
					 
				 }else{
					 alertJquery(resp,"Validacion Liquidacion Manifiesto");
				  }		 
			 
			 
				// alertJquery(resp,"Liquidacion");				 
				 removeDivLoading();	
                 LiquidacionManifiestoOnSaveOnUpdateonDelete(formulario);				 
		     }
			 
		   });
		   
       }											     

}

var formSubmitted = false;

function cumplirManifiestoCargaMinisterio(){
		
	if(!formSubmitted){
	
	  var QueryString = FormSerialize(document.forms[0])+"&ACTIONCONTROLER=cumplirManifiestoCargaMinisterio";
	  	
	  $.ajax({
		 url        : "LiquidacionClass.php?rand="+Math.random(),	 
		 data       : QueryString,
		 beforeSend : function(){			
			showDivMessage("Reportando al Ministerio de Transporte<br>Por Favor Espere..","../../../framework/media/images/general/cable_data_transfer_md_wht.gif");
			formSubmitted = true;
		 },
		 success    : function(resp){			
					
			removeDivMessage();
			
			showDivMessage(resp,"../../../framework/media/images/general/cable_data_transfer_md_wht.gif");			
			formSubmitted = false;
							
		 }
	  }); 
	  
	}
	
}

function onclickUpdate(objId,formulario){

      var obj               = document.getElementById(objId);
	  var formulario        = obj.form;	   
	  var anticipos         = '';
	  var impuestos         = '';
	  var descuentos        = '';
	  var tiempos        	= '';
	  var remesa        	= '';
	  var contAnticipos     = 0;
	  var contImpuestos     = 0;
	  var contDescuentos    = 0;
	  var contTiempos 		=0;
  	  var contRemesa 		=0;
	  var fletes            = '';
	  	  
	  var QueryString       = '';	
	  var tableLiquidacion  = document.getElementById('tableLiquidacion');
	  var tiempos_reg  = document.getElementById('tiempos_reg');
	  var remesas_reg  = document.getElementById('remesas_reg');
						  
	  $(tableLiquidacion).find(".rowImpuestos").each(function(){			
			
		var rowImpuesto             = this;	
		var impuestos_manifiesto_id = '';
		var impuesto_id             = '';
		var nombre                  = '';
		var valor                   = '';
				
		$(rowImpuesto).find("input[name=impuestos]").each(function(){   
									
			if(this.id == 'impuestos_manifiesto_id'){
			   impuestos += '&impuestos['+contImpuestos+'][impuestos_manifiesto_id]='+this.value;							
			}else if(this.id == 'impuesto_id'){
				 impuestos += '&impuestos['+contImpuestos+'][impuesto_id]='+this.value;	
			}else if(this.id == 'nombre'){
				   impuestos += '&impuestos['+contImpuestos+'][nombre]='+this.value;	
			 }else if(this.id == 'base'){
					 impuestos += '&impuestos['+contImpuestos+'][base]='+this.value;	
			  }else if(this.id == 'valor'){
					 impuestos += '&impuestos['+contImpuestos+'][valor]='+this.value;	
			  }else if(this.id == 'detalle_liquidacion_despacho_id'){
					 impuestos += '&impuestos['+contImpuestos+'][detalle_liquidacion_despacho_id]='+this.value;	
			  }
			
															 
		});
		
		contImpuestos++;
								 
	  });		  
	  
	  QueryString += impuestos;		  	  
	  
	  $(tableLiquidacion).find(".rowDescuentos").each(function(){
															   				
		var descuento_id = '';
		var nombre       = '';
		var valor        = '';
				
		$(this).find("input[name=descuentos]").each(function(){   
				
			if(this.id == 'descuentos_manifiesto_id'){
			   descuentos += '&descuentos['+contDescuentos+'][descuentos_manifiesto_id]='+this.value;													
			}else if(this.id == 'descuento_id'){
				 descuentos += '&descuentos['+contDescuentos+'][descuento_id]='+this.value;							
			}else if(this.id == 'nombre'){
				   descuentos += '&descuentos['+contDescuentos+'][nombre]='+this.value;	
			 }else if(this.id == 'valor'){
					 descuentos += '&descuentos['+contDescuentos+'][valor]='+this.value;	
			  }else if(this.id == 'detalle_liquidacion_despacho_id'){
					 descuentos += '&descuentos['+contDescuentos+'][detalle_liquidacion_despacho_id]='+this.value;	
			  }
			
															 
		});
		
		contDescuentos++;
																 
	  });		  
	  
	  QueryString += descuentos;				  
	  	  
	  $(tableLiquidacion).find(".rowAnticipos").each(function(){
		
		var anticipos_manifiesto_id = '';
		var conductor               = '';
		var conductor_id            = '';
		var valor                   = '';
		var observaciones           = '';			
			
		$(this).find("input[name=anticipos]").each(function(){   
									
			if(this.id == 'anticipos_manifiesto_id'){
			   anticipos += '&anticipos['+contAnticipos+'][anticipos_manifiesto_id]='+this.value;							
			}else if(this.id == 'tenedor'){
				 anticipos += '&anticipos['+contAnticipos+'][tenedor]='+this.value;	
			}else if(this.id == 'tenedor_id'){
				   anticipos += '&anticipos['+contAnticipos+'][tenedor_id]='+this.value;	
			 }else if(this.id == 'valor'){
					 anticipos += '&anticipos['+contAnticipos+'][valor]='+this.value;	
			  }else if(this.id == 'numero'){
					 anticipos += '&anticipos['+contAnticipos+'][numero]='+this.value;	
			  }
			
															 
		});
			
		contAnticipos++;
															 
	  });		  
	  
	  QueryString += anticipos;


	  $(tiempos_reg).find(".rowTiempos").each(function(){
		
		var tiempos_clientes_remesas_id = '';
		var fecha_llegada_descargue     = '';
		var hora_llegada_descargue      = '';
		var fecha_entrada_descargue     = '';
		var hora_entrada_descargue      = '';		
		var fecha_salida_descargue      = '';		
		var hora_salida_descargue       = '';		
			
		$(this).find("input[name=tiempos]").each(function(){   
									
			if(this.id == 'tiempos_clientes_remesas_id'){
			    tiempos += '&tiempos['+contTiempos+'][tiempos_clientes_remesas_id]='+this.value;							
			}else if(this.id == 'fecha_llegada_descargue'){
				tiempos += '&tiempos['+contTiempos+'][fecha_llegada_descargue]='+this.value;	
			}else if(this.id == 'hora_llegada_descargue'){
				tiempos += '&tiempos['+contTiempos+'][hora_llegada_descargue]='+this.value;	
			}else if(this.id == 'fecha_entrada_descargue'){
				tiempos += '&tiempos['+contTiempos+'][fecha_entrada_descargue]='+this.value;	
			}else if(this.id == 'hora_entrada_descargue'){
				tiempos += '&tiempos['+contTiempos+'][hora_entrada_descargue]='+this.value;	
			}else if(this.id == 'fecha_salida_descargue'){
				tiempos += '&tiempos['+contTiempos+'][fecha_salida_descargue]='+this.value;	
			}else if(this.id == 'hora_salida_descargue'){
				tiempos += '&tiempos['+contTiempos+'][hora_salida_descargue]='+this.value;	
				
			}
			
															 
		});
			
		contTiempos++;
															 
	  });		  
	  
	  QueryString += tiempos;

	  $(remesas_reg).find(".rowRemesa").each(function(){
		
		var remesa_id = '';
		var cantidad     = '';
		var peso      = '';
		var peso_volumen     = '';
		var tipo_liquidacion      = '';		
		var valor_unidad_costo      = '';		
		var valor_costo       = '';		
		var estado       = '';	
		var numero_remesa       = '';					
			
		$(this).find("input[name=remesa]").each(function(){   
									
			if(this.id == 'remesa_id'){
			    remesa += '&remesa['+contRemesa+'][remesa_id]='+this.value;							
			}else if(this.id == 'cantidad'){
				remesa += '&remesa['+contRemesa+'][cantidad]='+this.value;	
			}else if(this.id == 'peso'){
				remesa += '&remesa['+contRemesa+'][peso]='+this.value;	
			}else if(this.id == 'peso_volumen'){
				remesa += '&remesa['+contRemesa+'][peso_volumen]='+this.value;	
			}else if(this.id == 'tipo_liquidacion'){
				remesa += '&remesa['+contRemesa+'][tipo_liquidacion]='+this.value;	
			}else if(this.id == 'valor_unidad_costo'){
				remesa += '&remesa['+contRemesa+'][valor_unidad_costo]='+this.value;	
			}else if(this.id == 'estado'){
				remesa += '&remesa['+contRemesa+'][estado]='+this.value;	
			}else if(this.id == 'numero_remesa'){
				remesa += '&remesa['+contRemesa+'][numero_remesa]='+this.value;	
			}else if(this.id == 'valor_costo'){
				remesa += '&remesa['+contRemesa+'][valor_costo]='+this.value;	
				
			}
			
															 
		});
			
		contRemesa++;
															 
	  });		  
	  
	  QueryString += remesa;

      if(ValidaRequeridos(formulario)){
		   
   		   var QueryString  = 'ACTIONCONTROLER=onclickUpdate&'+FormSerialize(formulario)+QueryString;
		   
		   $.ajax({
		     url        : "LiquidacionClass.php?rand="+Math.random(),
			 data       : QueryString,
			 beforeSend : function(){
				showDivLoading();
			 },
			 success  : function(resp){
			 	 $("#refresh_QUERYGRID_LiquidacionManifiestos").click();					 
				 alertJquery(resp,"Liquidacion");
				 cumplirManifiestoCargaMinisterio();	
				 removeDivLoading();
				 LiquidacionManifiestoOnSaveOnUpdateonDelete(formulario);
		     }
		   });		   
		 
       }
											     
}

function setLiquidacion(){
		
	$("#guardar,#actualizar").click(function(){
											 
      if(this.id == 'guardar'){		  
        calcularFlete(onclickSave,this.id,this.form);		  		  
	  }else{
          calcularFlete(onclickUpdate,this.id,this.form);		  
		}											 
											 
    });
	
}

function validaTipoDescuento(){

  $("input[name=descuentos]").keypress(function(event){
											 
      var row     = this.parentNode.parentNode;									 
	  var calculo = $(row).find("input[id=calculo]").val();
	  
	  if(calculo == 'P'){
	    return false;
	  }else{
		  
         var params = new Array({"campo":"valor_flete","type":"numeric","length":null,"presicion":null,"patron":null,"mensaje":null,"value":null});
		 return SetValidacion(event,this,params);		   

		}
											 
  });
  
  
   $("input[name=descuentos]&&input[id=valor]").keyup(function(){ format(this,0); });

}

function clearDataForm(){
	
	$(".rowImpuestos").each(function() { if(this.id != 'rowImpuestos') { $(this).remove(); } });
	$(".rowDescuentos").each(function(){ if(this.id != 'rowDescuentos'){ $(this).remove(); } });
	$(".rowAnticipos").each(function() { if(this.id != 'rowAnticipos') { $(this).remove(); } });

}