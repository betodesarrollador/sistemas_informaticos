// JavaScript Document
//eventos asignados a los objetos
$(document).ready(function(){

    $("#divAnulacion").css("display","none");	

	$("#importGuia").click(function(){
		
		if($('#reexpedido_id').val().length > 0){
			
			$("#divGuia").dialog({
				title: 'Guias a Despachar',
				width: 900,
				height: 450,
				closeOnEscape:true,
				show: 'scale',
				hide: 'scale'
			});
						
			var reexpedido_id = $('#reexpedido_id').val();
			var url           = "GuiaToREClass.php?reexpedido_id="+reexpedido_id;
			$("#iframeGuia").attr("src",url);
			
		}else {
			alertJquery('Debe Guardar o Seleccionar el Manifiesto');
		 }		
	});	
	
	$("#deleteDetallesReexpedido").click(function(){
		window.frames[0].deleteDetallesReexpedido();
	});
	
   $("#guiaReexpedido,#divToolBarButtons").css("display","none");
   
   $("#detalleReexpedido").load(function(){
      closeDialog();
   });   
   

   setReexpedido();
   
   $("#observaciones").blur(function(){
     var valor = $.trim(this.value);	 
	 if(!valor.length > 0){
		 $("#observaciones").val("NINGUNA");
	 }									 
   });
   
   validaNumeroFormulario();
   onclickSave();
	  
   $("input[type=text]&&input[id=valor]").each(function(){
     setFormatCurrencyInput(this,2);														 
   });  

});

function closeDialog(){
	$("#divGuia").dialog('close');
}


function setDataFormWithResponse(){
	
	var forma 		= document.forms[0];	
	var QueryString = "ACTIONCONTROLER=onclickFind&reexpedido_id="+$('#reexpedido_id').val();
	
	$.ajax({
       url        : 'ReexpedidosClass.php?random='+Math.random(),
	   data       : QueryString,
	   beforeSend : function(){
		   showDivLoading();
	   },
	   success    : function(resp){		   
		   	  
		try{
			
		   var data       = $.parseJSON(resp);
		   var reexpedido = data[0]['reexpedido'];
		   var estado     = data[0]['estado'];		   

	       setFormWithJSON(forma,data,false,function(){														  
		   loadDetalle();
			  
           if(estado != 'P'){ 
		     disabledInputsFormReexpedido(forma);			  
		   }
		   

		   if($('#guardar'))    $('#guardar').attr("disabled","true");
           if($('#importGuia'))  document.getElementById('importGuia').disabled = true;
		   if($('#despachar')) $('#despachar').attr("disabled","true");
		   
		   if(estado == 'P' ){
		     if($('#actualizar')) document.getElementById('actualizar').disabled = false;			   
		   }else{
		       if($('#actualizar')) document.getElementById('actualizar').disabled = true;
			 }			 
			 			 
		   if(estado == 'P' || estado == 'M'){			   
		     if($('#anular')) document.getElementById('anular').disabled = false;			   
		   }else{
		       if($('#anular')) document.getElementById('anular').disabled = true;
			 }						 
			 
		   if(estado == 'P'){
		     if($('#importGuia')) document.getElementById('importGuia').disabled   = false;			   
		   }else{
		       if($('#importGuia')) document.getElementById('importGuia').disabled = true;
			 }				 			 		 

		   if(estado == 'P'){
		     if($('#despachar')) document.getElementById('despachar').disabled   = false;			   
		   }else{
		       if($('#despachar')) document.getElementById('despachar').disabled = true;
			 }				 			 		 

		   if($('#excel'))   if(document.getElementById('excel'))document.getElementById('excel').disabled = false;
		   if($('#imprimir'))   if(document.getElementById('imprimir'))document.getElementById('imprimir').disabled = false;
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

function loadDetalle(){
		
	var reexpedido_id  = $('#reexpedido_id').val();	
    var url            = "DetalleReexpedidosClass.php?reexpedido_id="+reexpedido_id;
	
	document.getElementById('detalleReexpedido').src = url;
	
	$("#guiaReexpedido,#divToolBarButtons").css("display","");
	  
   if(document.getElementById('imprimir'))document.getElementById('imprimir').disabled    = false;	
  if($('#excel'))   if(document.getElementById('excel'))document.getElementById('excel').disabled = false;   
   document.getElementById('guardar').disabled     = true;   
   document.getElementById('despachar').disabled  = false;   
   updateGrid();	
}

function ReexpedidosOnSave(formulario,resp){		
   
	try{
		
	  updateGrid();
	  
	  if($('#guardar'))    $('#guardar').attr("disabled","true");
	  if($('#actualizar')) $('#actualizar').attr("disabled","");
	  if($('#limpiar'))    $('#limpiar').attr("disabled","");
	  
	  resp = $.parseJSON(resp); 	  
	  	  		  
	    $("#reexpedido_id").val(resp[0]['reexpedido_id']);
	    $("#reexpedido").val(resp[0]['reexpedido']);	
	    
	    $("#importGuia").trigger("click");
		document.getElementById('importGuia').disabled = false;

  	}catch(e){
		
		 var error = e;
	  
	     try{
	       resp = $.parseJSON(resp);
		 }catch(e){
			 alertJquery(resp,"Error :"+error);			 
		   }		    
		
		if($('#guardar'))    $('#guardar').attr("disabled","");
		if($('#actualizar')) $('#actualizar').attr("disabled","true");
		if($('#borrar'))     $('#borrar').attr("disabled","true");
		if($('#limpiar'))    $('#limpiar').attr("disabled","");		 
		if($('#excel'))   if(document.getElementById('excel'))document.getElementById('excel').disabled = true;		
		
	  }	
}

function ReexpedidosOnUpdate(formulario,resp){

    if($.trim(resp) ==  'true'){
	  alertJquery("Manifiesto Actualizado Exitosamente","Manifiesto Mensajero");
	}else{
	    alertJquery(resp,"Error Actualizacion Manifiesto");
	}	
	updateGrid();
}

function beforePrint(formulario,url,title,width,height){

	var reexpedido_id = parseInt($("#reexpedido_id").val());
	
	if(isNaN(reexpedido_id)){
	  
	  alertJquery('Debe seleccionar un Reexpedido a imprimir !!!','Impresion reexpedido');
	  return false;
	  
	}else{	  
	    return true;
	  }
}

function Descargar_excel(formulario){
	
   if(ValidaRequeridos(formulario)){
	   var reexpedido_id = parseInt($("#reexpedido_id").val());
	 var QueryString = "ReexpedidosClass.php?ACTIONCONTROLER=onclickPrint&reexpedido_id="+reexpedido_id+"&download=SI";
	 popPup(QueryString,'Impresion Manifiesito',800,600);
	   
   }
}
function ReexpedidosOnDelete(formulario,resp){
	Reset(formulario);	
	ReexpedidosOnReset(formulario);
	clearFind();
	updateGrid();
	alertJquery(resp);
}

function ReexpedidosOnReset(forma){
	
	clearFind();
	document.getElementById('detalleReexpedido').src = "about:blank";

	enabledInputsFormReexpedido(forma);
	
	$("#empresa_id").val($("#empresa_id_static").val());	
	$("#oficina_id").val($("#oficina_id_static").val());
	$("#updateReexpedido").val('false');

	document.getElementById('estado').disabled = false;
	document.getElementById('estado').value    = 'M';	
	document.getElementById('estado').disabled = true;	

    $("#guiaReexpedido,#divToolBarButtons").css("display","none");	

    $("#divAnulacion").css("display","none");
	
	$('#guardar').attr("disabled","");
	if($('#importGuia'))  document.getElementById('importGuia').disabled = false;
	$('#actualizar').attr("disabled","true");
    if($('#anular')) document.getElementById('anular').disabled = true;	
	$('#imprimir').attr("disabled","true");
	if($('#excel'))   if(document.getElementById('excel'))document.getElementById('excel').disabled = true;		
	$('#limpiar').attr("disabled","");	
}

function updateGrid(){
	$("#refresh_QUERYGRID_Reexpedidos").click();
}

function onclickSave(){
   $("#guardar").click(function(){
      Send(this.form,'onclickSave',null,ReexpedidosOnSave,false);											
  });
}

function setReexpedido(){	
   $("#despachar,#actualizar").click(function(){
		calcularFlete(despachar,this.id,this.form);		
   });		
}

function calcularFlete(afterCalculation,objId,formulario){  
	 if(afterCalculation)afterCalculation(objId,formulario);    									 
}

function despachar(objId,formulario){

	if(objId == 'actualizar'){
	 document.getElementById('updateReexpedido').value = 'true';
	}else{
	    document.getElementById('updateReexpedido').value = 'false';
	  }	
		
    var reexpedido_id = document.getElementById('reexpedido_id').value;
    var QueryString   = 'ACTIONCONTROLER=asignoGuiaReexpedido&reexpedido_id='+reexpedido_id;

    $.ajax({
	  url        : "ReexpedidosClass.php?rand="+Math.random(),
	  data       : QueryString,
	  beforeSend : function(){
		 showDivLoading();
	  },
	  success    : function(resp){
		  
		if($.trim(resp) == 'false'){
		
		  alertJquery("Debe asignar Guias al Manifiesto antes de despachar!!!!","Validacion Guias Manifiesto");
		  return false;
			
		}else{			
			removeDivLoading();	
			setCamposNulosForm(formulario);											   
			  
			  var actionControler      = document.getElementById('ACTIONCONTROLER');
		
			  if(actionControler){
				 actionControler.value = 'setReexpedido';
			  }	  
			  
			  var QueryString       = '';	
			  var reexpedido        = document.getElementById('reexpedido').value;
										
			  submitIframe(formulario,QueryString,objId,reexpedido);				 
			}		
		 } 	  
    });
}

function submitIframe(formulario,QueryString,objId,reexpedido){
	
	enabledInputsFormReexpedido(formulario);
    var option = 'setReexpedido';
	showDivLoading();
	document.getElementById('despachar').disabled = true;
	if(document.getElementById('imprimir'))document.getElementById('imprimir').disabled   = true;	
         	   	   	  	 
	 $(formulario).find("input[type=checkbox]").each(function(){
       if(this.checked == false){
		   
         var Longitud    = this.name.length;
         var NombreCampo = this.name.substring(Longitud - 13,Longitud);
	  
	     if(NombreCampo == '_checked_file'){
			 
	        var fileDelete   = document.createElement("input");   		  
 	        fileDelete.type  = "hidden";
	        fileDelete.name  = this.name;         
            fileDelete.id    = this.name+'_hidden';         			
            fileDelete.value = 'false';	
			
			formulario.appendChild(fileDelete);			   
		  }		 
		 
	   }else if(document.getElementById(this.name+'_hidden')){
            var objRemove = document.getElementById(this.name+'_hidden');		 
   			objRemove.parentNode.removeChild(objRemove);
		 }															  
	 });
	 	     	   
	 var FrameEnvio      = document.getElementById('frmsend');
	 var ActionControler = document.getElementById('ACTIONCONTROLER');
	 
     if(!FrameEnvio){
     var  FrameEnvio      = document.createElement("iframe");
  	      FrameEnvio.width     = "0";     
		  FrameEnvio.height    = "0";
   		  FrameEnvio.name      = "frmsend";
   		  FrameEnvio.id        = "frmsend";
   		  FrameEnvio.className = "frmsend";		  
		  FrameEnvio.style.display = 'none';
		  
	 var  ControlerAction       = document.createElement("input");   		  
 	      ControlerAction.type  = "hidden";
	      ControlerAction.name  = "ACTIONCONTROLER";
   		  ControlerAction.id    = "ACTIONCONTROLER";
		  ControlerAction.value = option;
		  
	 var  TypeSend              = document.createElement("input");   		  
 	      TypeSend.type         = "hidden";
	      TypeSend.name         = "async";
   		  TypeSend.id           = "async";
		  TypeSend.value        = "true";

          formulario.appendChild(TypeSend);	
          formulario.appendChild(ControlerAction);	
          formulario.appendChild(FrameEnvio);				 	 
	 
	 }else{

	 	$("#ACTIONCONTROLER").val(option);
	  }
	  
     formulario.target  = "frmsend";		 
	 var formAction     = formulario.action;	 	 	 
	 formulario.action  = formAction+'?'+QueryString;
     
     setCamposNulosForm(formulario);	      	 	   		   
					   
 	 $("#frmsend").load(function() { 
	 	 
	    formulario.action  = formAction;
	 
        var response = getFrameContents(this);			 	
	   
	    if(response.substring(0,10) == 'ENDSESSION'){
		  logOut($.trim(response).substring(10));
	    }
	   
        $('#loading').html("");		
	  
	    RemovervaloresNulosForm(formulario);	  				
						
	    if($.trim(response) == 'true'){
				   
		var msj = '';
						
		if(objId == 'despachar'){
		  msj = "<div align='center'><b>Manifiesto Mensajero Numero: </b><font color='red' size='10'><b>"+reexpedido+"</b></font>generado exitosamente!!!</br></br> Desea Imprimir el Manifiesto ?</div>";
		}else{
			msj = "<div align='center'><b>Manifiesto Mensajero Numero: </b><font color='red' size='10'><b>"+reexpedido+"</b></font>actualizado exitosamente!!!</br></br> Desea Imprimir el Manifiesto ?</div>";
		}
 				   
        jConfirm(msj, "Manifiesto Mensajero",  
		function(r) {  
																					   
          if(r) {  

           onclickPrint(formulario,'ReexpedidosClass.php','Impresion Manifiesto','900','600',null);						  
		   Reset(formulario);	
           ReexpedidosOnReset(formulario);
           clearFind();
           updateGrid();
				   
          } else { 
             Reset(formulario);	
             ReexpedidosOnReset(formulario);
             clearFind();
             updateGrid();				   
             return false;  
             }  
         }); 

	     }else{
			alertJquery(response,"Error :");
		 }	   
	    removeDivLoading();	  
	 });
     formulario.submit();   	
}

function validaNumeroFormulario(){
		
	$("#numero_formulario").blur(function(){

        var obj               = this;
        var numero_formulario = this.value;
		var QueryString       = "ACTIONCONTROLER=validaNumeroFormulario&numero_formulario="+numero_formulario;
		
		$.ajax({
		  url        : "ReexpedidosClass.php?rand="+Math.random(),
		  data       : QueryString,
		  beforeSend : function(){
			showDivLoading();
		  },
		  success    : function(resp){
			  			  
			  try{
				  
				var formulario = $.trim(resp);  
				
				if(formulario == "true"){
					alertJquery("Ya existe un formulario ingresado con este numero : [ "+numero_formulario+" ] ");
					obj.value = '';
					return false;
				}else if(formulario != "false"){
					    alertJquery(resp);
					}
				  
			  }catch(e){
				    alertJquery(resp," Error :"+e);
				}
			  
			  removeDivLoading();
		   }
		});         					  
    });		
}

function onclickCancellation(formulario){
	
	if($("#divAnulacion").is(":visible")){
	 
	   var formularioPrincipal = document.forms[0];
	   var causal_anulacion_id = $("#causal_anulacion_id").val();
	   var observaciones       = $("#observaciones_anulacion").val();
	   
       if(ValidaRequeridos(formulario)){
	
	     var QueryString = "ACTIONCONTROLER=onclickCancellation&"+FormSerialize(formulario)+"&reexpedido_id="+$("#reexpedido_id").val();
		
	     $.ajax({
           url  : "ReexpedidosClass.php",
	       data : QueryString,
	       beforeSend: function(){
			   showDivLoading();
	       },
	       success : function(response){
			 
			 Reset(formularioPrincipal);
             ReexpedidosOnReset(formulario);						  
						  
		     if($.trim(response) == 'true'){
				 alertJquery('Manifiesto  Anulado','Anulado Exitosamente');
			 }else{
				   alertJquery(response,'Inconsistencia Anulando');
			   }
			   
			 removeDivLoading();
             $("#divAnulacion").dialog('close');
			 
	       }
	    });	   
	  }
	
    }else{
		
	 var reexpedido_id = $("#reexpedido_id").val();
	 var estado        = document.getElementById("estado").value;
	 
	 if(parseInt(reexpedido_id) > 0){		

		$("#divAnulacion").dialog({
		  title: 'Anulacion Manifiesto',
		  width: 450,
		  height: 280,
		  closeOnEscape:true
		 });
			
	 }else{
		alertJquery('Debe Seleccionar primero un Manifiesto','Anulacion');
	  }		
   }  
}

function disabledInputsFormReexpedido(forma){	
   $(forma).find("input,select,textarea").each(function(){
																				
		 if(this.type != 'button'){
			this.disabled = true;
		 }			
   });		
}

function enabledInputsFormReexpedido(forma){		
   $(forma).find("input,select,textarea").each(function(){
																				
		 if(this.type != 'button'){
			this.disabled = false;
		 }			
   });		
}

function setDivipolaOrigen(value,text,obj){	
	var ubicacion_id = value;
	var QueryString  = "ACTIONCONTROLER=setDivipolaOrigen&ubicacion_id="+ubicacion_id;
	
	$.ajax({
	  url        : "ReexpedidosClass.php?rand="+Math.random(),
	  data       : QueryString,
	  beforeSend : function(){
		 showDivLoading();
	  },
	  success    : function(resp){		  
		  var divipola = $.trim(resp);		  		  
		  $("#origen_divipola").val(divipola);		  
		  removeDivLoading();
	  }	  
   });	
}

function setDivipolaDestino(value,text,obj){	
	var ubicacion_id = value;
	var QueryString  = "ACTIONCONTROLER=setDivipolaDestino&ubicacion_id="+ubicacion_id;
	
	$.ajax({
	  url        : "ReexpedidosClass.php?rand="+Math.random(),
	  data       : QueryString,
	  beforeSend : function(){
		 showDivLoading();
	  },
	  success    : function(resp){
		  
		  var divipola = $.trim(resp);
		  		  
		  $("#destino_divipola").val(divipola);
		  
		  removeDivLoading();
	  }	  
   });	
}