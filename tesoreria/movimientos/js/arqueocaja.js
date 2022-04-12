// JavaScript Document
var formSubmitted = false;
var param_id;
$(document).ready(function(){
  param_id = $("#parametros_legalizacion_arqueo_id").val();
  $("#saveDetalle").click(function(){										
    window.frames[0].saveDetalles();	
  });  

  $("#guardar,#actualizar").click(function(){	  
	  var formulario = this.form;	  
	  if(ValidaRequeridos(formulario)){ 

		var QueryString       = '';	
		var monedas='';
		var billetes='';
		var contMonedas  = 0;
		var contBilletes = 0;
		
	  	var tableMonedas  = document.getElementById('tableMonedas');
						  
	   $(tableMonedas).find("#rowMonedas").each(function(){			
		
		   $(this).find("input[name=monedas]").each(function(){
												   
			 if(this.id == 'tipo_dinero_id'){
				 monedas += '&monedas['+contMonedas+'][tipo_dinero_id]='+this.value;
			 }else if(this.id == 'valor_dinero'){
				 monedas += '&monedas['+contMonedas+'][valor_dinero]='+this.value;			  
			 }else if(this.id == 'cantidad'){
				 monedas += '&monedas['+contMonedas+'][cantidad]='+this.value;			 
			 }else if(this.id == 'total'){
				 monedas += '&monedas['+contMonedas+'][total]='+removeFormatCurrency(this.value);				
			 }
		   });
		   contMonedas++;																				   
	  });		  
		   
	   QueryString += monedas;

	  	var tableBilletes  = document.getElementById('tableBilletes');
						  
	   $(tableBilletes).find("#rowBilletes").each(function(){			

		   $(this).find("input[name=billetes]").each(function(){
												   
			 if(this.id == 'tipo_dinero_id'){
				 billetes += '&billetes['+contBilletes+'][tipo_dinero_id]='+this.value;
			 }else if(this.id == 'valor_dinero'){
				 billetes += '&billetes['+contBilletes+'][valor_dinero]='+this.value;			  
			 }else if(this.id == 'cantidad'){
				 billetes += '&billetes['+contBilletes+'][cantidad]='+this.value;			 
			 }else if(this.id == 'total'){
				 billetes += '&billetes['+contBilletes+'][total]='+removeFormatCurrency(this.value);				
			 }
		  }); 
		 contBilletes++;																				   
																						   
	   });
	   QueryString += billetes;

	    if(this.id == 'guardar'){
		   QueryString  = 'ACTIONCONTROLER=onclickSave&'+FormSerialize(formulario)+QueryString;
		   
		   $.ajax({
		     url        : "ArqueoCajaClass.php?rand="+Math.random(),
			 data       : QueryString,
			 beforeSend : function(){
				showDivLoading();
			 },
			 success  : function(resp){				
			 			 
			     var arqueo_caja_id = parseInt(resp);
				 
				 if(!isNaN(arqueo_caja_id)){
					 
				 	 $("#refresh_QUERYGRID_arqueocaja").click();	
					 
					 var url = "ArqueoCajaClass.php?ACTIONCONTROLER=onclickPrint&arqueo_caja_id="+arqueo_caja_id+"&rand="+Math.random();
					 
					 //popPup(url,10,900,600);
					 getconsecutivo(resp);
					ArqueoCajaOnSave(formulario,resp);					 
					
				 }else{
					 alertJquery(resp,"Validacion Arqueo Caja");
				  }		 
				 removeDivLoading();	
		     }
			 
		   });

		}else{
		   QueryString  = 'ACTIONCONTROLER=onclickUpdate&'+FormSerialize(formulario)+QueryString;
		   
		   $.ajax({
		     url        : "ArqueoCajaClass.php?rand="+Math.random(),
			 data       : QueryString,
			 beforeSend : function(){
				showDivLoading();
			 },
			 success  : function(resp){				
				 ArqueoCajaOnUpdate(formulario,resp);
				 
					 
				 removeDivLoading();	
		     }
			 
		   });
		}
	  }	  	  
  });
  calcular_cifras();
});

function validar_caja(){
	var msj = "<div align='center'>Esta Seguro de Cambiar la Caja ? <br>Tenga en Cuenta que si esta Ingresando datos de otra caja y no ha Guardado se perderan los datos</div>";
	jConfirm(msj, "Arqueo",  
	function(r) {  
																				   
	  if(r) {  
		   ArqueoCajaOnReset(this.form);
			   
	  }else{
		 $("#parametros_legalizacion_arqueo_id option[value="+param_id+"]").attr("selected",true);    
	  }
	 }); 
					
	
}
function getconsecutivo(id){

	 var QueryString = "ACTIONCONTROLER=onclickconsecutivo&arqueo_caja_id="+id;
	 
	 $.ajax({
	   url        : "ArqueoCajaClass.php",
	   data       : QueryString,
	   beforeSend : function(){
	
	   },
	   success : function(response){
			   
		   var consecutivo = response;
		   
		   if(parseInt(consecutivo) >= 0 ){
				$("#consecutivo").val(consecutivo);	
		   }else{
			   $("#consecutivo").val('');			   
		   }  
		 }		 
	 });	 

}
function setDataFormWithResponse(){
	
    var parametros  = new Array({campos:"arqueo_caja_id",valores:$('#arqueo_caja_id').val()});
	var forma       = document.forms[0];
	var controlador = 'ArqueoCajaClass.php';
	var formulario = this.form;




	FindRow(parametros,forma,controlador,null,function(resp){

	var desde =  $("#fecha_arqueo").val();
	var hasta =  $("#fecha_arqueo").val();		
	var fecha =  $("#fecha_arqueo").val();	
	var oficina_id =  $("#oficina_id").val();	

      if($('#guardar'))   		$('#guardar').attr("disabled","true");
	  if($('#estado_arqueo').val()=='E'){
		  if($('#actualizar')) 	$('#actualizar').attr("disabled","");
		  if($('#cerrar')) 	$('#cerrar').attr("disabled","");
		  if($('#anular')) 		$('#anular').attr("disabled","");  
	  }else if($('#estado_arqueo').val()=='C'){		  
		  if($('#actualizar')) 	$('#actualizar').attr("disabled","true");
		   if($('#cerrar')) 	$('#cerrar').attr("disabled","true");
		  if($('#anular')) 		$('#anular').attr("disabled","");  
	  }else{
		  if($('#actualizar')) 	$('#actualizar').attr("disabled","true");
		  if($('#anular')) 		$('#anular').attr("disabled","true");  
	     if($('#cerrar')) 	$('#cerrar').attr("disabled","true");
		  
	  }
      if($('#limpiar'))    $('#limpiar').attr("disabled","");
	  if($('#imprimir'))   $('#imprimir').attr("disabled","");  

	 var QueryString = "ACTIONCONTROLER=setDocumentos";
	 
	 $.ajax({
	   url        : "ArqueoCajaClass.php",
	   data       : QueryString,
	   beforeSend : function(){

	   },
	   success : function(response){
			   
		   var valor = response;
		   
		   if(valor!= '' ){
				$("#documentos").val(valor);	
		   }  
			 var complemento = '&opciones_centros=U&opciones_documentos=T&reporte=C&opciones_tercero=T&oficina_id='+oficina_id+'&tercero=NULL&tercero_id=NULL&agrupar=cuenta&desde='
			 +desde+'&hasta='+hasta;
			
			
			 var QueryString1 = "/envipack/tesoreria/movimientos/clases/LibrosAuxiliaresClass.php?ACTIONCONTROLER=onclickGenerarAuxiliar&"+FormSerialize(forma)+complemento;
			 $("#detallesCaja").attr("src",QueryString1);

			 if($('#estado_arqueo').val()=='E'){
				 var complemento = '&opciones_centros=U&opciones_documentos=T&reporte=C&opciones_tercero=T&oficina_id='+oficina_id+'&tercero=NULL&tercero_id=NULL&agrupar=cuenta&desde='
				 +desde+'&hasta='+hasta;
				 
				 var QueryString2 = "ACTIONCONTROLER=onclickGenerarAuxiliar&saldoauxi=si&"+FormSerialize(forma)+complemento; 
		
				 //funcion para saber saldo auxiliar
				 $.ajax({
				   url        : "LibrosAuxiliaresClass.php",
				   data       : QueryString2,
				   beforeSend : function(){
			
				   },
				   success : function(response){
						   
					   var valor = response;
					   
					   if(parseInt(valor) >= 0 ){
							$("#saldo_auxiliar").val(setFormatCurrency(parseInt(valor)));	
					   }else{
						   $("#saldo_auxiliar").val(0);			   
					   }  
					   sumar_efe_che();
					 }		 
				 });	 
			 }


		 }		 
	 });	 

	 var QueryString = "ACTIONCONTROLER=setMonedasarqueo&arqueo_caja_id="+$('#arqueo_caja_id').val();
	 
	 $.ajax({
	   url        : "ArqueoCajaClass.php",
	   data       : QueryString,
	   beforeSend : function(){

	   },
	   success : function(response){
		  var rowMonedas  = document.getElementById('rowMonedas');	
		  var Tabla_mon  = document.getElementById('tableMonedas');
	      var rowCount = Tabla_mon.rows.length;

		  var datas = $.parseJSON(response); 
		  var numRow=1;
		  
		  for(i = 0; i < datas.length; i++){ 
			 $(Tabla_mon.rows[numRow]).find("input[name=monedas]").each(function(){
					
				var input = this;
				
				  if(input.id == 'valor_dinero'){ 
					  input.value = datas[i]['valor_dinero'];
					  
				  }
				  if(input.id == 'tipo_dinero_id'){ 
					  input.value = datas[i]['tipo_dinero_id'];
					  
				  }
				  if(input.id == 'cantidad'){ 
					  input.value = datas[i]['cantidad'];
					  
				  }
				  if(input.id == 'total'){ 
					  input.value = datas[i]['total'];
					  
				  }
				  
				  
			 });
			 numRow++;    
			
		  }
		}
		 		 
	 });	 


	 var QueryString = "ACTIONCONTROLER=setBilletesarqueo&arqueo_caja_id="+$('#arqueo_caja_id').val();
	 
	 $.ajax({
	   url        : "ArqueoCajaClass.php",
	   data       : QueryString,
	   beforeSend : function(){

	   },
	   success : function(response){
		  var rowBilletes  = document.getElementById('rowBilletes');	
		  var Tabla_bill  = document.getElementById('tableBilletes');
	      var rowCount = Tabla_bill.rows.length;

		  var datas = $.parseJSON(response); 
		  var numRow=1;
		  
		  for(i = 0; i < datas.length; i++){ 
			 $(Tabla_bill.rows[numRow]).find("input[name=billetes]").each(function(){
					
				var input = this;
				
				  if(input.id == 'valor_dinero'){ 
					  input.value = datas[i]['valor_dinero'];
					  
				  }
				  if(input.id == 'tipo_dinero_id'){ 
					  input.value = datas[i]['tipo_dinero_id'];
					  
				  }

				  if(input.id == 'cantidad'){ 
					  input.value = datas[i]['cantidad'];
					  
				  }
				  if(input.id == 'total'){ 
					  input.value = datas[i]['total'];
					  
				  }

			 });
			 numRow++;    
			
		  }
		}
		 		 
	 });	

    });
}

function ArqueoCajaOnSave(formulario,resp){	
   if(isInteger(resp)){
		var arqueo_caja_id = resp;
		
		$("#arqueo_caja_id").val(arqueo_caja_id);						

 	    $("#refresh_QUERYGRID_arqueocaja").click();
	   
		if($('#guardar'))    $('#guardar').attr("disabled","true");
		if($('#actualizar')) $('#actualizar').attr("disabled","");
		if($('#cerrar')) 		$('#cerrar').attr("disabled","");
		if($('#anular')) 	 $('#anular').attr("disabled","");	
		if($('#limpiar'))    $('#limpiar').attr("disabled","");	
	    if($('#imprimir'))   $('#imprimir').attr("disabled",""); 
		alertJquery("Se guardo el Arqueo exitosamente","ArqueoCaja");	   
		
   }else{
       alertJquery(resp,"ArqueoCaja");	   
	 }   
}

function ArqueoCajaOnUpdate(formulario,resp){
   $("#refresh_QUERYGRID_arqueocaja").click();
   
    if($('#guardar'))    	$('#guardar').attr("disabled","true");
	if($("#estado_arqueo_caja").val()=='A'){
	if($('#actualizar')) 	$('#actualizar').attr("disabled","true");
	if($('#cerrar')) 		$('#cerrar').attr("disabled","true");
	if($('#anular')) 		$('#anular').attr("disabled","true");	
    }else if($('#estado_arqueo_caja').val()=='C'){		
	      if($('#actualizar'))   $('#actualizar').attr("disabled","true");
		  if($('#cerrar')) 		$('#cerrar').attr("disabled","true");
	      if($('#anular')) 		 $('#anular').attr("disabled","");  
	}else{
		if($('#actualizar'))   $('#actualizar').attr("disabled","");
		if($('#cerrar')) 		$('#cerrar').attr("disabled","");
		if($('#anular')) 	   $('#anular').attr("disabled","");	
	}
	
    if($('#limpiar'))    	$('#limpiar').attr("disabled","");	
    if($('#imprimir'))      $('#imprimir').attr("disabled","");  	
	
   alertJquery(resp,"ArqueoCaja");   
}

function ArqueoCajaOnReset(formulario){
	$("#detallesCaja").attr("src","/envipack/framework/tpl/blank.html");
    if($('#guardar'))    		$('#guardar').attr("disabled","");
	if($('#cerrar')) 		$('#cerrar').attr("disabled","true");
    if($('#actualizar')) 		$('#actualizar').attr("disabled","true");
    if($('#anular')) 			$('#anular').attr("disabled","true");	
    if($('#limpiar'))    		$('#limpiar').attr("disabled","");	
    if($('#imprimir'))          $('#imprimir').attr("disabled","true");  
	var parametros_legalizacion_arqueo_id = $("#parametros_legalizacion_arqueo_id").val();	
    clearFind();
	$("#parametros_legalizacion_arqueo_id").val(parametros_legalizacion_arqueo_id);	

	document.getElementById('usuario_id').value=document.getElementById('anul_usuario_id').value;
	document.getElementById('oficina_id').value=document.getElementById('anul_oficina_id').value;
	document.getElementById('estado_arqueo').value='E';

	 var QueryString = "ACTIONCONTROLER=setCuentas&parametros_legalizacion_arqueo_id="+parametros_legalizacion_arqueo_id;
	 
	 $.ajax({
	   url        : "ArqueoCajaClass.php",
	   data       : QueryString,
	   beforeSend : function(){

	   },
	   success : function(response){
			   
		   var datas = $.parseJSON(response); 
		   
		   $("#puc_id").val(datas[0]['puc_id']);	
		   $("#ini_puc_id").val(datas[0]['ini_puc_id']);	
		   $("#ini2_puc_id").val(datas[0]['ini2_puc_id']);	
		   $("#ini3_puc_id").val(datas[0]['ini3_puc_id']);	
		   $("#ini4_puc_id").val(datas[0]['ini4_puc_id']);	
		   $("#ini5_puc_id").val(datas[0]['ini5_puc_id']);	
		   $("#ini6_puc_id").val(datas[0]['ini6_puc_id']);	


		 }		 
	 });	 

	 var QueryString = "ACTIONCONTROLER=setDocumentos";
	 
	 $.ajax({
	   url        : "ArqueoCajaClass.php",
	   data       : QueryString,
	   beforeSend : function(){

	   },
	   success : function(response){
			   
		   var valor = response;
		   
		   if(valor!= '' ){
				$("#documentos").val(valor);	
		   }  

		 }		 
	 });	 

	 var QueryString = "ACTIONCONTROLER=setMonedas";
	 
	 $.ajax({
	   url        : "ArqueoCajaClass.php",
	   data       : QueryString,
	   beforeSend : function(){

	   },
	   success : function(response){
		  var rowMonedas  = document.getElementById('rowMonedas');	
		  var Tabla_mon  = document.getElementById('tableMonedas');
	      var rowCount = Tabla_mon.rows.length;

		  var datas = $.parseJSON(response); 
		  var numRow=1;
		  
		  for(i = 0; i < datas.length; i++){ 
			 $(Tabla_mon.rows[numRow]).find("input[name=monedas]").each(function(){
					
				var input = this;
				
				  if(input.id == 'valor_dinero'){ 
					  input.value = datas[i]['valor_dinero'];
					  
				  }
				  if(input.id == 'tipo_dinero_id'){ 
					  input.value = datas[i]['tipo_dinero_id'];
					  
				  }
				  
			 });
			 numRow++;    
			
		  }
		}
		 		 
	 });	 


	 var QueryString = "ACTIONCONTROLER=setBilletes";
	 
	 $.ajax({
	   url        : "ArqueoCajaClass.php",
	   data       : QueryString,
	   beforeSend : function(){

	   },
	   success : function(response){
		  var rowBilletes  = document.getElementById('rowBilletes');	
		  var Tabla_bill  = document.getElementById('tableBilletes');
	      var rowCount = Tabla_bill.rows.length;

		  var datas = $.parseJSON(response); 
		  var numRow=1;
		  
		  for(i = 0; i < datas.length; i++){ 
			 $(Tabla_bill.rows[numRow]).find("input[name=billetes]").each(function(){
					
				var input = this;
				
				  if(input.id == 'valor_dinero'){ 
					  input.value = datas[i]['valor_dinero'];
					  
				  }
				  if(input.id == 'tipo_dinero_id'){ 
					  input.value = datas[i]['tipo_dinero_id'];
					  
				  }
				  
			 });
			 numRow++;    
			
		  }
		}
		 		 
	 });	 

}


function calcular_cifras(){

  $("input[name=monedas]&&input[id=cantidad]").keypress(function(event){
											 
      var row     = this.parentNode.parentNode;									 
	  var valor_dinero = $(row).find("input[id=valor_dinero]").val();
	 

	 var params = new Array({"campo":"valor_dinero","type":"integer","length":null,"presicion":null,"patron":null,"mensaje":null,"value":null});
	 return SetValidacion(event,this,params);		   

  });
  
   
   $("input[name=monedas]&&input[id=cantidad]").keyup(function(){ 
		 var row     = this.parentNode.parentNode;																				
		  var valor_dinero = removeFormatCurrency($(row).find("input[id=valor_dinero]").val());
		  var cantidad = removeFormatCurrency($(row).find("input[id=cantidad]").val());		
	
		  var valor_total=(cantidad * valor_dinero);
		  $(row).find("input[id=total]").val(setFormatCurrency(valor_total));

		  var valorTotal = 0;
	 	  var Tabla = document.getElementById('tableMonedas');
    
      	  	$(Tabla).find("input[id=total]").each(function(){ 
        	var valor = removeFormatCurrency(this.value);  																	  
        	valorTotal += (valor * 1) 
	  	  });	   

	 	  var Tabla = document.getElementById('tableBilletes');
    
      	  	$(Tabla).find("input[id=total]").each(function(){ 
        	var valor = removeFormatCurrency(this.value);  																	  
        	valorTotal += (valor * 1) 
	  	  });	   

		  $("#total_efectivo").val(setFormatCurrency(valorTotal));
		  sumar_efe_che();
														
	});

  $("input[name=billetes]&&input[id=cantidad]").keypress(function(event){
											 
      var row     = this.parentNode.parentNode;									 
	  var valor_dinero = $(row).find("input[id=valor_dinero]").val();

	 var params = new Array({"campo":"valor_dinero","type":"integer","length":null,"presicion":null,"patron":null,"mensaje":null,"value":null});
	 return SetValidacion(event,this,params);		   

  });
  
   
   $("input[name=billetes]&&input[id=cantidad]").keyup(function(){ 
		 var row     = this.parentNode.parentNode;																				
		  var valor_dinero = removeFormatCurrency($(row).find("input[id=valor_dinero]").val());
		  var cantidad = removeFormatCurrency($(row).find("input[id=cantidad]").val());		
		  
		  var valor_total=(cantidad * valor_dinero);
		  $(row).find("input[id=total]").val(setFormatCurrency(valor_total));
		  
		  var valorTotal = 0;
	 	  var Tabla = document.getElementById('tableMonedas');
    
      	  	$(Tabla).find("input[id=total]").each(function(){ 
        	var valor = removeFormatCurrency(this.value);  																	  
        	valorTotal += (valor * 1) 
	  	  });	   

	 	  var Tabla = document.getElementById('tableBilletes');
    
      	  	$(Tabla).find("input[id=total]").each(function(){ 
        	var valor = removeFormatCurrency(this.value);  																	  
        	valorTotal += (valor * 1) 
	  	  });	   

		  $("#total_efectivo").val(setFormatCurrency(valorTotal));
		  
		  sumar_efe_che();
														
	});

}
function sumar_efe_che(){
	 var efectivo =	removeFormatCurrency($("#total_efectivo").val());
	 efectivo = parseInt(efectivo)>0 ? efectivo : 0;
	 var cheque =	removeFormatCurrency($("#total_cheque").val());	 
	 cheque = parseInt(cheque)>0 ? cheque : 0;
	 
	 var saldo_auxiliar =	removeFormatCurrency($("#saldo_auxiliar").val());
	 saldo_auxiliar = parseInt(saldo_auxiliar)>0 ? saldo_auxiliar : 0;

	 var total_caja = parseFloat(efectivo)+parseFloat(cheque);
     $("#total_caja").val(setFormatCurrency(total_caja));

	 var diferencia = parseFloat(saldo_auxiliar)-parseFloat(total_caja);
     $("#diferencia").val(setFormatCurrency(diferencia));

	
}
function onclickCerrar(formulario){
	 var diferencia = $("#diferencia").val();
	 diferencia = diferencia.replace("-", ""); 
	 diferencia = removeFormatCurrency(diferencia);
	 if(diferencia<50){
	
		 var QueryString = "ACTIONCONTROLER=onclickCerrar&arqueo_caja_id="+$("#arqueo_caja_id").val();
		
		 $.ajax({
		   url  : "ArqueoCajaClass.php",
		   data : QueryString,
		   beforeSend: function(){
			   showDivLoading();
		   },
		   success : function(response){
						  
			 if($.trim(response) == 'true'){
				 alertJquery('Arqueo Cerrado Exitosamente','Arqueo');
				 
				  if($('#guardar'))   	$('#guardar').attr("disabled","true");
				  if($('#actualizar')) 	$('#actualizar').attr("disabled","true");
				  if($('#cerrar')) 		$('#cerrar').attr("disabled","true");
				  if($('#anular')) 		$('#anular').attr("disabled","");
				  if($('#limpiar'))     $('#limpiar').attr("disabled","");
				  if($('#imprimir'))    $('#imprimir').attr("disabled","");  
				  $("#refresh_QUERYGRID_arqueocaja").click();
			 }else{
				   alertJquery(response,'Inconsistencia Cerrando');
			   }			   
			 removeDivLoading();
		 
		   }	   
		 });	   
	 }else{
		 alertJquery('La diferencia debe ser menor a 50 Pesos','Inconsistencia Cerrando');
	 }
}
function onclickCancellation(formulario){
	
	if($("#divAnulacion").is(":visible")){

	   var causal_anulacion_id	= $("#causal_anulacion_id").val();
	   var desc_anul_arqueo		= $("#desc_anul_arqueo").val();
	   var fecha_anul			= $("#fecha_anul").val();
	   
       if(ValidaRequeridos(formulario)){
	
	     var QueryString = "ACTIONCONTROLER=onclickCancellation&"+FormSerialize(formulario)+"&arqueo_caja_id="+$("#arqueo_caja_id").val();
		
	     $.ajax({
           url  : "ArqueoCajaClass.php",
	       data : QueryString,
	       beforeSend: function(){
			   showDivLoading();
	       },
	       success : function(response){
			              
		     if($.trim(response) == 'true'){
				 alertJquery('Arqueo Anulado','Anulado Exitosamente');
				 $("#refresh_QUERYGRID_arqueocaja").click();
				 setDataFormWithResponse();
			 }else{
				   alertJquery(response,'Inconsistencia Anulando');
			   }			   
			 removeDivLoading();
             $("#divAnulacion").dialog('close');			 
	       }	   
	     });	   
	   }
	
    }else{
		
	 var arqueo_caja_id 		= $("#arqueo_caja_id").val();
	 var estado_arqueo_caja   = $("#estado_arqueo_caja").val();
	 
	 if(parseInt(arqueo_caja_id) > 0){		

	 var QueryString = "ACTIONCONTROLER=getEstadoEncabezadoRegistro&arqueo_caja_id="+arqueo_caja_id;
	 
	 $.ajax({
       url        : "ArqueoCajaClass.php",
	   data       : QueryString,
	   beforeSend : function(){
		 showDivLoading();
	   },
	   success : function(response){
		   	   
		   var estado = response;
		   
		   if($.trim(estado) == 'E' || $.trim(estado) == 'C'){
			   
		    $("#divAnulacion").dialog({
			  title: 'Anulacion Cierre Caja',
			  width: 650,
			  height: 280,
			  closeOnEscape:true
             });
			
		   }else{
		      alertJquery('Solo se permite anular Cierres en estado : <b>EDICION O CERRADO</b>','Anulacion');			   
		   }  
			 
	     removeDivLoading();			 
	     }		 
	 });	 
		
	 }else{
		alertJquery('Debe Seleccionar primero un Registro Liquidado','Anulacion');
	  }			
   }  
}

function OnclickGenerar(formulario){
	
		
	var desde =  $("#fecha_arqueo").val();
	var hasta =  $("#fecha_arqueo").val();		
	var fecha =  $("#fecha_arqueo").val();	
	var puc_id =  $("#puc_id").val();	
	var oficina_id =  $("#oficina_id").val();	
	var parametros_legalizacion_arqueo_id = $("#parametros_legalizacion_arqueo_id").val();	
	
	$("#consecutivo").val('');
	$("input[name=monedas]").val('');
	$("input[name=billetes]").val('');
	$("#total_efectivo").val('');
	$("#total_cheque").val('');
	$("#total_caja").val('');
	$("#saldo_auxiliar").val('');
	$("#diferencia").val('');
	
	ArqueoCajaOnReset(formulario);
	
	if(parseInt(parametros_legalizacion_arqueo_id)>0 && desde!=''){
		
	
	
	
		var complemento = '&opciones_centros=U&opciones_documentos=T&reporte=C&opciones_tercero=T&oficina_id='+oficina_id+'&tercero=NULL&tercero_id=NULL&agrupar=cuenta&desde='
		+desde+'&hasta='+hasta;
	
		
		 var QueryString = "/envipack/tesoreria/movimientos/clases/LibrosAuxiliaresClass.php?ACTIONCONTROLER=onclickGenerarAuxiliar&"+FormSerialize(formulario)+complemento;
		 var QueryString1 = "ACTIONCONTROLER=onclickGenerarAuxiliar&saldoauxi=si&"+FormSerialize(formulario)+complemento; 
		 $("#detallesCaja").attr("src",QueryString);
	
		 
		 showDivLoading();	 	
	 
		 var QueryString = "ACTIONCONTROLER=onclickComprobar&fecha="+fecha+"&parametros_legalizacion_arqueo_id="+parametros_legalizacion_arqueo_id;
		 
		 $.ajax({
		   url        : "ArqueoCajaClass.php",
		   data       : QueryString,
		   beforeSend : function(){
	
		   },
		   success : function(response){
				   
			   var data = response;
			   
			   if(parseInt(data)>0){
				   $("#arqueo_caja_id").val(data);
				   setDataFormWithResponse();
			   }else{
	
				 var QueryString = "ACTIONCONTROLER=onclickCheques&fecha="+fecha;
				 
				 $.ajax({
				   url        : "ArqueoCajaClass.php",
				   data       : QueryString,
				   beforeSend : function(){
			
				   },
				   success : function(response){
						   
					   $("#cheques").val(response);	
					   
					 }		 
				 });	 
			
				 var QueryString = "ACTIONCONTROLER=onclickChequesVal&fecha="+fecha;
				 
				 $.ajax({
				   url        : "ArqueoCajaClass.php",
				   data       : QueryString,
				   beforeSend : function(){
			
				   },
				   success : function(response){
						   
					   var valor = response;
					   
					   if(parseInt(valor) >= 0 ){
							$("#total_cheque").val(setFormatCurrency(valor));	
					   }else{
						   $("#total_cheque").val(0);			   
					   }  
					   sumar_efe_che();
					 }		 
				 });	 
	
				 //funcion para saber saldo auxiliar
				 $.ajax({
				   url        : "LibrosAuxiliaresClass.php",
				   data       : QueryString1,
				   beforeSend : function(){
			
				   },
				   success : function(response){
						   
					   var valor = response;
					   
					   if(parseInt(valor) >= 0 ){
							$("#saldo_auxiliar").val(setFormatCurrency(parseInt(valor)));	
					   }else{
						   $("#saldo_auxiliar").val(0);			   
					   }  
					   sumar_efe_che();
					 }		 
				 });	 
				
			   }
			   
			 }		 
		 });	 
	
		 
		 $("#detallesCaja").load(function(response){removeDivLoading();});		
	}else{
		alertJquery('Debe Seleccionar primero una fecha y Caja','Validacion');
	}
}


function beforePrint(formulario,url,title,width,height){
	
	var arqueo_caja_id = parseInt($("#arqueo_caja_id").val());
	
	if(isNaN(arqueo_caja_id)){
	  
	  alertJquery('Debe seleccionar un Arqueo a imprimir !!!','Impresion Arqueo');
	  return false;
	  
	}else{	  
	
	    var arqueo_caja_id = $("#arqueo_caja_id").val();
		
		if(arqueo_caja_id > 0){
			
		  return true;	
			
		}else{
			 return false;
			
		}
	    return true;
	  }	
	
}
