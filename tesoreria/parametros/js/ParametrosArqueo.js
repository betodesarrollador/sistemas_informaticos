// JavaScript Document

$(document).ready(function(){

 autocompleteCodigoContable();

 $("a[name=saveDetalleRemesa]").click(function(){
   addRowProduct(this);
 });
 
   $("#guardar,#actualizar").click(function(){											
	  var formulario = this.form;	  
	  if(ValidaRequeridos(formulario)){ 
	  	    
	    if(this.id == 'guardar'){
			var QueryString = "ACTIONCONTROLER=onclickSave&"+FormSerialize(formulario);
			
			$.ajax({
			  url        : "ParametrosArqueoClass.php?rand="+Math.random(),
			  data       : QueryString,
			  beforeSend : function(){
				showDivLoading();
			  },
			  success    : function(resp){					  
				   parametrosLegalizacionOnSaveOnUpdateonDelete(formulario);					  
				  if($.trim(resp) == 'true'){
					alertJquery("Se ingreso correctamente el parametro !!","Parametros Arqueo");
				  }else{
					 alertJquery(resp,"Error :");
				   }					   
				   removeDivLoading();
			  }
			});
				

		}else{
				var QueryString = "ACTIONCONTROLER=onclickUpdate&"+FormSerialize(formulario);
			
				$.ajax({
				  url        : "ParametrosArqueoClass.php?rand="+Math.random(),
				  data       : QueryString,
				  beforeSend : function(){
					showDivLoading();
				  },
				  success    : function(resp){
				  
				   parametrosLegalizacionOnSaveOnUpdateonDelete(formulario);					  
				  
				  if($.trim(resp) == 'true'){
					alertJquery("Se actualizo correctamente el parametro !!","Parametros Legalizacion");
				  }else{
					 alertJquery(resp,"Error :");
				   }
				   
				   removeDivLoading();
				  
				  }
				});
			 }
	    }											
   }); 
});

function setDataFormWithResponse(parametros_legalizacion_arqueo_id){
	
	var forma 		= document.forms[0];	
	var QueryString = "ACTIONCONTROLER=onclickFind&parametros_legalizacion_arqueo_id="+parametros_legalizacion_arqueo_id;
	
	$.ajax({
	  url        : "ParametrosArqueoClass.php?rand="+Math.random(),
	  data       : QueryString,
	  beforeSend : function(){
		  showDivLoading();
	  },
	  success    : function(resp){
		  
        try{
			
		  var data                     = $.parseJSON(resp);
		  var parametros_legalizacion_arqueo  = data[0]['parametros_legalizacion_arqueo'];
		  var empresa_id               = parametros_legalizacion_arqueo[0]['empresa_id'];
		  var oficina_id               = parametros_legalizacion_arqueo[0]['oficina_id'];
		  
		  setOficinasCliente(empresa_id,oficina_id);		  
		  var detalle_parametros_legalizacion_arqueo = data[0]['detalle_parametros_legalizacion_arqueo'];		  
          setFormWithJSON(forma,parametros_legalizacion_arqueo);		  
		  
		  
		  
          autocompleteCodigoContable();		  
					  
		  if($('#guardar'))    $('#guardar').attr("disabled","true");
	 	  if($('#actualizar')) $('#actualizar').attr("disabled","");
		  if($('#borrar'))     $('#borrar').attr("disabled","");
		  if($('#limpiar'))    $('#limpiar').attr("disabled","");
			
		}catch(e){
			alertJquery(resp,"Error : "+e);
		  }	  		  
		 removeDivLoading(); 		  
      }	  
    });
}

function setNombreCuentaContrapartida(id,text,obj){   
  var nombre_puc = text.split("-");
  var row                  = obj.parentNode.parentNode.parentNode;  
  $(row).find("input[name=contrapartida]").val($.trim(nombre_puc[0]));  
  $(row).find("input[name=nombre_puc]").val($.trim(nombre_puc[1]));  
}

function setNombreCuenta(id,text,obj){ 
 var puc = text.split("-");
 var row = obj.parentNode.parentNode; 
 $(row).find("input[name=puc]").val($.trim(puc[0]));
 $(row).find("input[name=puc_id]").val(id);
 $(row).find("input[name=nombre_cuenta]").val($.trim(puc[1])); 	 
}

function parametrosLegalizacionOnSaveOnUpdateonDelete(formulario,resp){
   $("#refresh_QUERYGRID_parametros_legalizacion").click();
   parametrosLegalizacionOnReset(formulario);   
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");	
   alertJquery(resp,"parametros Arqueo");   
}

function parametrosLegalizacionOnReset(formulario){	
	Reset(formulario);
    clearFind();	
    setFocusFirstFieldForm(formulario);			
	$("#oficina_id option").each(function(){
      if(this.value != 'NULL'){
		  $(this).remove();
      }
    });	
	
	
	autocompleteCodigoContable();
		
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");	
}

function autocompleteCodigoContable(){	
  $("input[name=puc]").keypress(function(event){
      ajax_suggest(this,event,"cuentas_movimiento","null",setNombreCuenta,null,document.forms[0]);    
  });	
}


function setOficinasCliente(empresa_id,oficina_id){	
	var QueryString = "ACTIONCONTROLER=setOficinasCliente&empresa_id="+empresa_id+"&oficina_id="+oficina_id;	
	$.ajax({
		url     : "ParametrosArqueoClass.php?rand="+Math.random(),
		data    : QueryString,
		success : function(response){
			$("#oficina_id").parent().html(response);
		}
	});
}
