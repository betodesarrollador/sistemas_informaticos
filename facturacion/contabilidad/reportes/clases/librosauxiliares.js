// JavaScript Document
$(document).ready(function(){
  setWidthFrameReporte();
  setReporte();  					
  
  $("#opciones_tercero").change(function(){
    if(this.value == 'T'){
	 $("#defecto").attr("checked","true");
	 $("input[name=agrupar]").removeAttr("disabled");		
	 $("#tercero_hidden").removeClass("obligatorio");
	 $("#tercero").removeClass("requerido");	 	 
	 $("#tercero").attr("disabled","true");	 	 	 
	 $("#tercero,#tercero_hidden").val("");	 	 	 	 
    }else if(this.value == 'U'){
		 $("#defecto").attr("checked","true");
 		 $("input[name=agrupar]").attr("disabled","true");
		 $("#tercero_hidden").addClass("obligatorio");
	     $("#tercero").attr("disabled","");	 	 	 		 
      }						
  });  
  
  $("#documento").change(function(){
    if(this.value == 'T'){
	 $("#documentos").removeClass("obligatorio");
	 $("#documentos").removeClass("requerido");	 
    }else if(this.value == 'U'){
		 $("#documentos").addClass("obligatorio");
      }														  
  });
    
  $("#opciones_centros").click(function(){
     if(this.checked){
	   this.value = 'T';	 
	 }else{
		  this.value = 'U';
	   }
	   
     var objSelect = document.getElementById('centro_de_costo_id'); 
	 var numOp     = objSelect.options.length -1;
	   
     if(this.value == 'T'){
	   
	   for(var i = numOp; i > 0; i-- ){
		   
		  if(objSelect.options[i].value != 'NULL'){
			 objSelect.options[i].selected = true;
		  }else{
			   objSelect.options[i].selected = false;
			} 
		   
	   }
		 		 
	 }else{
		 
	     for(var i = numOp; i > 0; i-- ){
		   
		   if(objSelect.options[i].value != 'NULL'){
			 objSelect.options[i].selected = false;
		   }else{
			   objSelect.options[i].selected = true;
			 } 
		   
	     } 		 
		 
	  }
  });
  
  $("#centro_de_costo_id").change(function(){
     $("#opciones_centros").attr("checked","");								
     $("#opciones_centros").val("U");									 
  });  
  
  $("#opciones_documentos").click(function(){
     if(this.checked){
	   this.value = 'T';	 
	 }else{
		  this.value = 'U';
	   }
	   
     var objSelect = document.getElementById('documentos'); 
	 var numOp     = objSelect.options.length -1;
	   
     if(this.value == 'T'){
	   
	   for(var i = numOp; i > 0; i-- ){
		   
		  if(objSelect.options[i].value != 'NULL'){
			  objSelect.options[i].selected = true;
		  }else{
			    objSelect.options[i].selected = false;			  
			 } 
		   
	   }
		 		 
	 }else{
		 
	     for(var i = numOp; i > 0; i-- ){
		   
		   if(objSelect.options[i].value != 'NULL'){
			  objSelect.options[i].selected = false;
		   }else{
			    objSelect.options[i].selected = true;			  			   
			 } 
		   
	     } 		 
		 
	  }
  });
  
  
  $("#export").click(function(){
	
   var formulario = this.form;	
   
   if(ValidaRequeridos(formulario)){
     var QueryString = "LibrosAuxiliaresClass.php?ACTIONCONTROLER=onclickExport&"+FormSerialize(formulario);
     $("#frameReporte").attr("src",QueryString);
	   
   }	
	
  });
						   
});

function setReporte(){
	
  $("#oficina_id").css("display","none");	
	
  $("#reporte").change(function(){
								
      if(this.value == 'O'){
		  
	   $("#centro_de_costo_id").removeClass("obligatorio");
	   $("#centro_de_costo_id").removeClass("requerido");	 
	   $("#centro_de_costo_id").css("display","none");	 	   
	   
	   $("#oficina_id").addClass("obligatorio");
	   $("#oficina_id").css("display","");	 	   
	   
	   document.getElementById('centro_de_costo_id').value = 'NULL';	   
	   
	  }else{
		  
		 document.getElementById('reporte').value = 'C';
	     $("#oficina_id").removeClass("obligatorio");
	     $("#oficina_id").removeClass("requerido");	 
	     $("#oficina_id").css("display","none");	 	   
	   
	     $("#centro_de_costo_id").addClass("obligatorio"); 
	     $("#centro_de_costo_id").css("display","");
		 
	     document.getElementById('oficina_id').value = 'NULL';	   		 

        }								
								
  });	
	
}
function setWidthFrameReporte(){
  $("#frameReporte").css("height",($(parent.document.body).height() - 110));
}
function getReportParams(){
	
  $("#reporte").change(function(){
    if($.trim(this.value) != 'NULL'){
        getEmpresas(this.value);
    }
  });
  
}
function getEmpresas(reporte){
	
  var QueryString = "ACTIONCONTROLER=getEmpresas&reporte="+reporte;
  
  $.ajax({
    url        : "LibrosAuxiliaresClass.php",
	data       : QueryString,
	beforeSend : function(){
	},
	success    : function(response){
		
		if(reporte == 'E'){
		  $("#empresaReporte").html(response);
		  $("#oficinaReporte").html("");
		  $("#centroCostoReporte").html("");			
		}else if(reporte == 'O'){
		    $("#empresaReporte").html(response);
		    $("#oficinaReporte").html("<select name='oficina_id' id='oficina_id' disabled><option value='NULL'>( Seleccione )</option></select>");
		    $("#centroCostoReporte").html("");	
		  }else if(reporte == 'C'){
		     $("#empresaReporte").html(response);
		     $("#oficinaReporte").html("");
		     $("#centroCostoReporte").html("<select name='centro_de_costo' id='centro_de_costo' disabled><option value='NULL'>( Seleccione )</option></select>");	
		    }
			 
	  }
		 
  });
	
}
function onclickGenerarAuxiliar(formulario){
   if(ValidaRequeridos(formulario)){
     var QueryString = "LibrosAuxiliaresClass.php?ACTIONCONTROLER=onclickGenerarAuxiliar&"+FormSerialize(formulario);
     $("#frameReporte").attr("src",QueryString);
     showDivLoading();	 	   
     $("#frameReporte").load(function(response){removeDivLoading();});
	   
   }
}

function setCuentaHasta(Id,text,obj){
	
	$("#cuenta_hasta").val(text);
	$("#cuenta_hasta_hidden").val(Id);	
	
}
function beforePrint(formulario){
	
   if(ValidaRequeridos(formulario)){
     return true;
	   
   }else{
	    return false;
	}
}