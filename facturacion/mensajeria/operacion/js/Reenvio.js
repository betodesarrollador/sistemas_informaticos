// JavaScript Document
//eventos asignados a los objetos
$(document).ready(function(){

    $("#divAnulacion").css("display","none");	
    leerCodigobar();
    setReenvio();
   
   $("#observaciones").blur(function(){
     var valor = $.trim(this.value);	 
	 if(!valor.length > 0){
		 $("#observaciones").val("NINGUNA");
	 }									 
   });
   
   $("input[type=text]&&input[id=valor]").each(function(){
     setFormatCurrencyInput(this,2);														 
   });  

});

function setReenvio(){
		
	$("#guardar,#actualizar").click(function(){
											 
      if(this.id == 'guardar'){		  
       	onclickSave(this.id,this.form);			  		  
	  }else{
        onclickUpdate(this.id,this.form);			  		  		  
	  }											 
											 
    });
	
}
//inicio save
function onclickSave(objId,formulario){

      var obj           = document.getElementById(objId);
	  var formulario    = obj.form;	   
	  var guias         = '';
	  var contGuias     = 0;
	  var QueryString   = '';	
	  var tableReenvio  = document.getElementById('tableReenvio');
	  var valida =0;
						  
	  $(tableReenvio).find(".rowGuias").each(function(){			
			
		var rowGuias             = this;	
		var guia_id = '';
				
		$(rowGuias).find("input[name=guia_id]").each(function(){   
									
			if(this.id == 'guia_id' && parseInt(this.value)>0 ){
			   guias += '&g['+contGuias+'][g_id]='+this.value;							
			   valida=1;
			}else{
			 	valida=0;
			}
		});
		if(valida==1){
			contGuias++;
		}
								 
	  });		  
	  
	  QueryString += guias;		  	  
	  

      if(ValidaRequeridos(formulario)){
		  		 		   
		   var QueryString  = 'ACTIONCONTROLER=onclickSave&reenvio_id=null&reexpedido_id='+$("#reexpedido_id").val()+'&fecha_ree='+$("#fecha_ree").val()
								+'&obser_ree='+$("#obser_ree").val()+'&estado='+$("#estado").val()+QueryString;
		   
		   $.ajax({
		     url        : "ReenvioClass.php?rand="+Math.random(),
			 data       : QueryString,
			 beforeSend : function(){
				showDivLoading();
			 },
			 success  : function(resp){				
			 			 
			     var reenvio_id = parseInt(resp);
				 
				 if(!isNaN(reenvio_id)){

					 ReenvioOnSave(formulario,reenvio_id);	
					 $("#refresh_QUERYGRID_Reenvio").click();	
					 
					 var url = "ReenvioClass.php?ACTIONCONTROLER=onclickPrint&reenvio_id="+reenvio_id+"&rand="+Math.random();
					 popPup(url,10,900,600);
						  
				 }else{
					 alertJquery(resp,"Validacion Reenvio");
				  }		 
			 
				 removeDivLoading();	
                 			 
		     }
			 
		   });
		   
       }											     

}
//fin save


function leerCodigobar(){
	$("#codigo_barras1").keypress(function (e) {
		if (e.which == 13) {	
			e.preventDefault();
			
			var guia = $("#codigo_barras1").val();
			var guia1 = $("#codigo_barras1").val();
			
				if(document.getElementById('codigo_barras1').value!=''){ 
					
					$("#codigo_barras1").focus();									   
		
					if(guia == "NULL" || guia == ""){
						guia= 0;
					}else{
						var QueryString = "ACTIONCONTROLER=setLeerCodigobar&guia="+$('#codigo_barras1').val();
						$.ajax({
						   url        : 'ReenvioClass.php?random='+Math.random(),
						   data       : QueryString,
						   beforeSend : function(){
							   showDivLoading();
						   },
						   success    : function(resp){		   
							try{			
							   var data       = $.parseJSON(resp);
							   if(data[0]['estado_mensajeria_id']=='7'){
								   var guia = data[0]['numero_guia'];
								   var guia_id = data[0]['guia_id'];
								   var remitente = data[0]['remitente'];
								   var destinatario = data[0]['destinatario'];						   
								   var des_producto = data[0]['descripcion_producto'];
								   var peso = data[0]['peso'];
								   var cantidad = data[0]['cantidad'];
								  $("#guia_id").val(guia_id);
								  $("#guia_dev").val(guia);
								   $("#remitente").val(remitente);
								   $("#destinatario").val(destinatario);
								   $("#descripcion_producto").val(des_producto);
								   $("#peso").val(peso);
								   $("#cantidad").val(cantidad);
								   addRowProduct();
								    $("#mensaje_alerta").html("<span style='color:#090;'>La guia "+guia1+", fue seleccionada exitosamente</span>");
							   }else{
								   $("#mensaje_alerta").html("La guia "+guia1+",<br> No se encuentra en estado Devolucion");

							   }
							}catch(e){
							   $("#mensaje_alerta").html("No ha sido asignada o creada la guia "+guia1+"");

							}
							$("#codigo_barras1").focus();
							$("#codigo_barras1").val('');
							removeDivLoading();
						   }
						});
					}
				}
			else if(document.getElementById('codigo_barras1').value!=''){
				
				$("#codigo_barras1").focus();
				$("#codigo_barras1").val('');
	
			}
		}
	});
} 

function addRowProduct(obj){  	
       numRow =1;
	  var Tabla           = document.getElementById('tableReenvio');
	  var clon    = document.getElementById('clon');				   
	  var newRow       = Tabla.insertRow(numRow);
	  newRow.className = 'rowGuias';
	  newRow.innerHTML = clon.innerHTML;

}


function setDataFormWithResponse(){
	
	var forma 		= document.forms[0];	
	var QueryString = "ACTIONCONTROLER=onclickFind&reenvio_id="+$('#reenvio_id').val();
	
	$.ajax({
       url        : 'ReenvioClass.php?random='+Math.random(),
	   data       : QueryString,
	   beforeSend : function(){
		   showDivLoading();
	   },
	   success    : function(resp){		   
		   	  
		try{
			
		   var data       = $.parseJSON(resp);
		   var reenvio = data[0]['reenvio_id'];
		   var estado     = data[0]['estado'];		   

	       setFormWithJSON(forma,data,false,function(){														  
		  
  			if(estado == 'A'){ 
				disabledInputsFormEntrega(forma);
			}else if(estado == 'R'){
				enabledInputsFormEntrega(forma);
			}
			if($('#guardar')) document.getElementById('guardar').disabled = true;

			if(estado == 'R'){
				if($('#actualizar')) document.getElementById('actualizar').disabled = false;
			}else{
				if($('#actualizar')) document.getElementById('actualizar').disabled = true;
			}

			if($('#imprimir')) $('#imprimir').attr("disabled","");

			if(estado == 'R'){
				if($('#anular')) document.getElementById('anular').disabled = false;
			}else if(estado == 'A'){
				if($('#anular')) document.getElementById('anular').disabled = true;
			}

			if($('#limpiar'))    $('#limpiar').attr("disabled","");
		   
		   removeDivLoading();	
		   
         });	
		 
	   }catch(e){
		   //alertJquery(resp,"Error : "+e);
   		   removeDivLoading();
		 }
	   }
    });
}



function ReenvioOnSave(formulario,reenvio_id){		
   
	if(parseInt(reenvio_id)>0){
		
	  updateGrid();
	  
	  if($('#guardar'))    $('#guardar').attr("disabled","true");
	  if($('#actualizar'))    $('#actualizar').attr("disabled","");	  
	  if($('#limpiar'))    $('#limpiar').attr("disabled","");
	   $('#reenvio_id').val(reenvio_id);
		alertJquery("Guardado Exitosamente","Reenvio");
	  
	    
  	}else{
		
		if($('#guardar'))    $('#guardar').attr("disabled","");
		if($('#actualizar')) $('#actualizar').attr("disabled","true");
		if($('#limpiar'))    $('#limpiar').attr("disabled","");		 
		
	}	
}

function ReenvioOnUpdate(formulario,resp){

    if($.trim(resp) ==  'true'){
	  alertJquery("Reenvio Actualizado Exitosamente","Reenvio Carga");
	}else{
	    alertJquery(resp,"Error Actualizacion Reenvio");
	}	
	updateGrid();
}

function beforePrint(formulario,url,title,width,height){

	var reenvio_id = parseInt($("#reenvio_id").val());
	
	if(isNaN(reenvio_id)){
	  
	  alertJquery('Debe seleccionar un Reenvio a imprimir !!!','Impresion Reenvio');
	  return false;
	  
	}else{	  
	    return true;
	  }
}

function ReenvioOnDelete(formulario,resp){
	Reset(formulario);	
	ReenvioOnReset(formulario);
	clearFind();
	updateGrid();
	alertJquery(resp);
}

function ReenvioOnReset(forma){
	
    enabledInputsFormReenvio(forma);	
	clearFind();
	
	$("#empresa_id").val($("#empresa_id_static").val());	
	$("#oficina_id").val($("#oficina_id_static").val());
	$("#updateReenvio").val('false');

	document.getElementById('estado').value    = 'R';	
	document.getElementById('estado').disabled = true;	


    $("#divAnulacion").css("display","none");
	
	$('#guardar').attr("disabled","");
	$('#actualizar').attr("disabled","true");
    if($('#anular')) document.getElementById('anular').disabled = true;	
	$('#imprimir').attr("disabled","true");
	$('#limpiar').attr("disabled","");	
}

function updateGrid(){
	$("#refresh_QUERYGRID_Reenvio").click();
}


function onclickCancellation(formulario){
	
	if($("#divAnulacion").is(":visible")){
	 
	   var formularioPrincipal = document.forms[0];
	   var causal_anulacion_id = $("#causal_anulacion_id").val();
	   var observaciones       = $("#observaciones_anulacion").val();
	   
       if(ValidaRequeridos(formulario)){
	
	     var QueryString = "ACTIONCONTROLER=onclickCancellation&"+FormSerialize(formulario)+"&reenvio_id="+$("#reenvio_id").val();
		
	     $.ajax({
           url  : "ReenvioClass.php",
	       data : QueryString,
	       beforeSend: function(){
			   showDivLoading();
	       },
	       success : function(response){
			 
			 Reset(formularioPrincipal);
             ReenvioOnReset(formulario);						  
						  
		     if($.trim(response) == 'true'){
				 alertJquery('Reenvio Carga Anulado','Anulado Exitosamente');
			 }else{
				   alertJquery(response,'Inconsistencia Anulando');
			   }
			   
			 removeDivLoading();
             $("#divAnulacion").dialog('close');
			 
	       }
	    });	   
	  }
	
    }else{
		
	 var reenvio_id = $("#reenvio_id").val();
	 var estado        = document.getElementById("estado").value;
	 
	 if(parseInt(reenvio_id) > 0){		
       
		$("#divAnulacion").dialog({
		  title: 'Anulacion Reenvio de Carga',
		  width: 450,
		  height: 280,
		  closeOnEscape:true
		 });
			
	 }else{
		alertJquery('Debe Seleccionar primero un Reenvio','Anulacion');
	  }		
   }  
}

function disabledInputsFormReenvio(forma){	
   $(forma).find("input,select,textarea").each(function(){
																				
		 if(this.type != 'button'){
			this.disabled = true;
		 }			
   });		
}

function enabledInputsFormReenvio(forma){		
   $(forma).find("input,select,textarea").each(function(){
																				
		 if(this.type != 'button'){
			this.disabled = false;
		 }			
   });		
}