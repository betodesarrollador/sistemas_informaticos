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
			var numDetalle  = 0;
		  
			$("#tableRemesas").find("*[name=remove]").each(function(){
														
				var Row  = this.parentNode.parentNode.parentNode;																
				
				$(Row).find("input,select").each(function(){
					QueryString += "&detalle_parametros_legalizacion["+numDetalle+"]["+this.name+"]="+this.value;
				});									
														
				numDetalle++;											
																
			});
			
			if(parseInt(numDetalle) > 0){
			
			
				$.ajax({
				  url        : "ParametrosLegalizacionClass.php?rand="+Math.random(),
				  data       : QueryString,
				  beforeSend : function(){
				    showDivLoading();
				  },
				  success    : function(resp){				   
					  
					   parametrosLegalizacionOnSaveOnUpdateonDelete(formulario);					  
					  
					  if($.trim(resp) == 'true'){
					    alertJquery("Se ingreso correctamente el parametro !!","Parametros Legalizacion");
					  }else{
					     alertJquery(resp,"Error :");
					   }
					   
					   removeDivLoading();

				  }
				});
				
			}else{
				alertJquery("Debe ingresar almenos una cuenta de gastos de viaje","Validacion Parametros Legalizacion");
				return false;
			  }


		}else{

				var QueryString = "ACTIONCONTROLER=onclickUpdate&"+FormSerialize(formulario);
				var numDetalle  = 0;
			  
				$("#tableRemesas").find("*[name=remove]").each(function(){
															
					var Row  = this.parentNode.parentNode.parentNode;																
					
					$(Row).find("input,select").each(function(){
						QueryString += "&detalle_parametros_legalizacion["+numDetalle+"]["+this.name+"]="+this.value;
					});									
															
					numDetalle++;											
																	
				});
				
				
				if(parseInt(numDetalle) > 0){
				
				
					$.ajax({
					  url        : "ParametrosLegalizacionClass.php?rand="+Math.random(),
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
					
				}else{
					alertJquery("Debe ingresar almenos una cuenta de gastos de viaje","Validacion Parametros Legalizacion");
					return false;
				  }		


		  }
	  }											
											
   }); 

});

function setDataFormWithResponse(parametros_legalizacion_id){
	
	var forma 		= document.forms[0];	
	var QueryString = "ACTIONCONTROLER=onclickFind&parametros_legalizacion_id="+parametros_legalizacion_id;
	
	$.ajax({
	  url        : "ParametrosLegalizacionClass.php?rand="+Math.random(),
	  data       : QueryString,
	  beforeSend : function(){
		  showDivLoading();
	  },
	  success    : function(resp){
		  
        try{
			
		  var data                     = $.parseJSON(resp);
		  var parametros_legalizacion  = data[0]['parametros_legalizacion'];
		  var empresa_id               = parametros_legalizacion[0]['empresa_id'];
		  var oficina_id               = parametros_legalizacion[0]['oficina_id'];
		  
		  setOficinasCliente(empresa_id,oficina_id);
		  
		  var detalle_parametros_legalizacion = data[0]['detalle_parametros_legalizacion'];
		  
          setFormWithJSON(forma,parametros_legalizacion);
		  
		  var Tabla = document.getElementById('tableRemesas');
		
		  $(Tabla.rows).each(function(){
			if(this.rowIndex > 0){
			      $(this).remove();
			}
		  });	
			
						
		  for(var i = 0; i < detalle_parametros_legalizacion.length; i++){
			  
			var newRow = insertaFilaAbajoClon(Tabla);
			var item   = parseInt(i);
		
            $(newRow).find("a[name=saveDetalleRemesa]").html('<img name="remove" src="../../../framework/media/images/grid/close.png" />')		
		
			$(newRow).find("input[name=item]").val(item);    
			  
			$(newRow).find("a[name=saveDetalleRemesa]").focus(function(){
			  $(this).parent().addClass("focusSaveRow");
			});
			
			$(newRow).find("a[name=saveDetalleRemesa]").blur(function(){
			  $(this).parent().removeClass("focusSaveRow");
			});	
			
			$(newRow).find("a[name=saveDetalleRemesa]").click(function(){
			  removeRowProduct(this);
			});		  
			
			
			for(var llave in detalle_parametros_legalizacion[i]){
				
				$(newRow).find("input[name="+llave+"]").val(detalle_parametros_legalizacion[i][llave]);
				
			}
			  
		  }
		  
		  
		if(i < 7){
			  
			  var newRow = insertaFilaAbajoClon(Tabla);
			  var item   = parseInt(i) + 1;
		
			  $(newRow).find("input[name=item]").val(item);    
			  
			  $(newRow).find("a[name=saveDetalleRemesa]").focus(function(){
			    $(this).parent().addClass("focusSaveRow");
			  });
			  
			  $(newRow).find("a[name=saveDetalleRemesa]").blur(function(){
			    $(this).parent().removeClass("focusSaveRow");
			  });	
			  
			  $(newRow).find("a[name=saveDetalleRemesa]").click(function(){
			    addRowProduct(this);
			  }); 			  
			  
			  
		  }
		  
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
  
  var nombre_contrapartida = text.split("-");
  var row                  = obj.parentNode.parentNode.parentNode;
  
  $(row).find("input[name=contrapartida]").val($.trim(nombre_contrapartida[0]));  
  $(row).find("input[name=nombre_contrapartida]").val($.trim(nombre_contrapartida[1]));
  
}

function setNombreCuentaDiferenciaConductor(id,text,obj){ 
  
  var nombre_diferencia = text.split("-");
  var row               = obj.parentNode.parentNode.parentNode;

  $(row).find("input[name=diferencia_favor_conductor]").val($.trim(nombre_diferencia[0]));  
  $(row).find("input[name=nombre_diferencia_favor_conductor]").val($.trim(nombre_diferencia[1]));
  
}

function setNombreCuentaDiferenciaEmpresa(id,text,obj){ 
  
  var nombre_diferencia = text.split("-");
  var row               = obj.parentNode.parentNode.parentNode;

  $(row).find("input[name=diferencia_favor_empresa]").val($.trim(nombre_diferencia[0]));  
  $(row).find("input[name=nombre_diferencia_favor_empresa]").val($.trim(nombre_diferencia[1]));
  
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
	
   alertJquery(resp,"parametros Legalizacion");
   
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
	
    var Tabla = document.getElementById('tableRemesas');
  
    $(Tabla.rows).each(function(){
	  if(this.rowIndex > 0){
	    $(this).remove();
 	  }
    });	
	
    var newRow = insertaFilaAbajoClon(Tabla);
    var item   = 1;

    $(newRow).find("input[name=item]").val(item);    
	  
    $(newRow).find("a[name=saveDetalleRemesa]").focus(function(){
      $(this).parent().addClass("focusSaveRow");
    });
    
    $(newRow).find("a[name=saveDetalleRemesa]").blur(function(){
      $(this).parent().removeClass("focusSaveRow");
    });	
    
    $(newRow).find("a[name=saveDetalleRemesa]").click(function(){
      addRowProduct(this);
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

function addRowProduct(obj){  	
       
      var Tabla    = obj.parentNode.parentNode.parentNode;	                  
      var Fila     = obj.parentNode.parentNode;
      var item     = 1;
      var tam      = Tabla.rows.length;
      var numRows  = tam - 1;
      var actmayor = 0;
      var cont     = 0;
      
	  var vector   = new Array(tam);
	  
	  $(Tabla).find("input[name=item]").each(function(){
	    
	    vector[cont] = this.value;
	    if( parseInt(vector[cont]) > parseInt(actmayor)) actmayor = vector[cont];
	    
	  });

	  item       = parseInt(actmayor) + parseInt(1);            
	  var newRow = insertaFilaAbajoClon(Tabla);

	  $(newRow).find("input[name=item]").val(item);    
		
	  $(newRow).find("a[name=saveDetalleRemesa]").focus(function(){
	    $(this).parent().addClass("focusSaveRow");
	  });
	  
	  $(newRow).find("a[name=saveDetalleRemesa]").blur(function(){
	    $(this).parent().removeClass("focusSaveRow");
	  });	
	  
	  $(newRow).find("a[name=saveDetalleRemesa]").click(function(){
	    addRowProduct(this);
	  });      
	  
	  
	  var newLink           = document.createElement("a");
	      newLink.href      = "javascript:void(0)";
	      newLink.name      = "saveDetalleRemesa";
	      newLink.innerHTML = '<img name="remove" src="../../../framework/media/images/grid/close.png" />';
	      
	      $(newLink).focus(function(){
		$(this).parent().addClass("focusSaveRow");
	      });
	      
	      $(newLink).blur(function(){
		$(this).parent().removeClass("focusSaveRow");
	      });		  
	      
	      $(newLink).click(function(){
	      removeRowProduct(this);
	      });
	  
	      $(obj).parent().removeClass("focusSaveRow");      
	      
	      var celda = obj.parentNode;
	      
	      $(obj).remove();
	      
	      $(celda).html(newLink);
	      
           autocompleteCodigoContable();

}

function removeRowProduct(obj){
  
  var Tabla  = obj.parentNode.parentNode.parentNode;
  var numAdd = 0;
  
  $(Tabla).find("img[name=add]").each(function(){
    numAdd++;
  });
    
  $(obj.parentNode.parentNode).remove();    
  
  var valorTotal = 0;  
  var Tabla      = document.getElementById('tableRemesas');

  $(Tabla).find("input[name=cantidad_detalle]").each(function(){ valorTotal += (this.value * 1) });	   
  
  $("#cantidad").val(valorTotal);
     
  var pesoTotal = 0;
  var Tabla     = document.getElementById('tableRemesas');

  $(Tabla).find("input[name=peso_detalle]").each(function(){ pesoTotal += (this.value * 1) });	   
  
  $("#peso").val(pesoTotal);
    
  var valorTotal = 0;
  var Tabla      = document.getElementById('tableRemesas');

  $(Tabla).find("input[name=valor_detalle]").each(function(){ valorTotal += (this.value * 1) });	   
  
  $("#valor").val(valorTotal);    
  
  
}

function setOficinasCliente(empresa_id,oficina_id){
	
	var QueryString = "ACTIONCONTROLER=setOficinasCliente&empresa_id="+empresa_id+"&oficina_id="+oficina_id;
	
	$.ajax({
		url     : "ParametrosLegalizacionClass.php?rand="+Math.random(),
		data    : QueryString,
		success : function(response){
			$("#oficina_id").parent().html(response);
		}
	});
}