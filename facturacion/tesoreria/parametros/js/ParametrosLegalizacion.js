// JavaScript Document

$(document).ready(function(){
						   

 autocompleteCodigoContable();

 $("a[name=saveDetalleRemesa]").click(function(){
   addRowProduct(this);
 });
 
   $("#guardar,#actualizar").click(function(){											
	  var formulario = this.form;	  
	  if(ValidaRequeridos(formulario)){ 

		 var parametros_legalizacion_caja_id    = $("#parametros_legalizacion_caja_id").val();
		 var empresa_id                = $("#empresa_id").val(); 
		 var oficina_id                = $("#oficina_id").val();
		 var tipo_documento_id         = $("#tipo_documento_id").val();
		 var naturaleza_contrapartida  = $("#naturaleza_contrapartida").val();
		 var contrapartida_id          = $("#contrapartida_id_hidden").val(); 
		 var nombre_contrapartida      = $("#nombre_contrapartida").val();   

	    if(this.id == 'guardar'){
			var QueryString = "ACTIONCONTROLER=onclickSave&parametros_legalizacion_caja_id="+parametros_legalizacion_caja_id+"&empresa_id="+empresa_id
			+"&oficina_id="+oficina_id+"&tipo_documento_id="+tipo_documento_id+"&naturaleza_contrapartida="+naturaleza_contrapartida
			+"&nombre_contrapartida="+nombre_contrapartida+"&contrapartida_id="+contrapartida_id;
			var numDetalle  = 0;		  
			$("#tableRemesas").find("*[name=remove]").each(function(){														
				var Row  = this.parentNode.parentNode.parentNode;				
				$(Row).find("input,select").each(function(){
					if(this.name=='puc_id' || this.name=='nombre_cuenta' || this.name=='naturaleza' || this.name=='detalle_parametros_legalizacion_caja_id'){									  
						QueryString += "&detalle_parametros_legalizacion_caja["+numDetalle+"]["+this.name+"]="+this.value;
					}
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
				alertJquery("Debe ingresar al menos un Costo","Validacion Parametros Legalizacion");
				return false;
			  }

		}else{
				var QueryString = "ACTIONCONTROLER=onclickUpdate&parametros_legalizacion_caja_id="+parametros_legalizacion_caja_id+"&empresa_id="+empresa_id
			+"&oficina_id="+oficina_id+"&tipo_documento_id="+tipo_documento_id+"&naturaleza_contrapartida="+naturaleza_contrapartida
			+"&nombre_contrapartida="+nombre_contrapartida+"&contrapartida_id="+contrapartida_id;
				var numDetalle  = 0;			  
				$("#tableRemesas").find("*[name=remove]").each(function(){															
					var Row  = this.parentNode.parentNode.parentNode;					
					$(Row).find("input,select").each(function(){
						if(this.name=='puc_id' || this.name=='nombre_cuenta' || this.name=='naturaleza' || this.name=='detalle_parametros_legalizacion_caja_id'){									  
							QueryString += "&detalle_parametros_legalizacion_caja["+numDetalle+"]["+this.name+"]="+this.value;
						}
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
					alertJquery("Debe ingresar almenos un Costo","Validacion Parametros Legalizacion");
					return false;
				  }	
			 }
	    }											
   }); 
});

function setDataFormWithResponse(parametros_legalizacion_caja_id){
	
	var forma 		= document.forms[0];	
	var QueryString = "ACTIONCONTROLER=onclickFind&parametros_legalizacion_caja_id="+parametros_legalizacion_caja_id;
	
	$.ajax({
	  url        : "ParametrosLegalizacionClass.php?rand="+Math.random(),
	  data       : QueryString,
	  beforeSend : function(){
		  showDivLoading();
	  },
	  success    : function(resp){
		  
        try{
			
		  var data                     = $.parseJSON(resp);
		  var parametros_legalizacion_caja  = data[0]['parametros_legalizacion_caja'];
		  var empresa_id               = parametros_legalizacion_caja[0]['empresa_id'];
		  var oficina_id               = parametros_legalizacion_caja[0]['oficina_id'];
		  
		  setOficinasCliente(empresa_id,oficina_id);		  
		  var detalle_parametros_legalizacion_caja = data[0]['detalle_parametros_legalizacion_caja'];		  
          setFormWithJSON(forma,parametros_legalizacion_caja);		  
		  var Tabla = document.getElementById('tableRemesas');
		
		  $(Tabla.rows).each(function(){
			if(this.rowIndex > 0){
			      $(this).remove();
			}
		  });				
						
		  for(var i = 0; i < detalle_parametros_legalizacion_caja.length; i++){
			  
			var newRow = insertaFilaAbajoClon(Tabla);
			var item   = parseInt(i);
            $(newRow).find("a[name=saveDetalleRemesa]").html('<img name="remove" src="/envipack/framework/media/images/grid/close.png" />')		
		
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
			
			for(var llave in detalle_parametros_legalizacion_caja[i]){				
				$(newRow).find("input[name="+llave+"]").val(detalle_parametros_legalizacion_caja[i][llave]);				
			}			  
		  }		  
		  
		if(i < 25){
			  
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
	      newLink.innerHTML = '<img name="remove" src="/envipack/framework/media/images/grid/close.png" />';
	      
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
