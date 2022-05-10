// JavaScript Document
$(document).ready(function(){

  setWidthFrameReporte();
				
  
  $("#opciones_tercero").change(function(){
    if(this.value == 'T'){

	 $("#tercero_hidden").removeClass("obligatorio");
	 $("#tercero").removeClass("requerido");	 	 
	 $("#tercero").attr("disabled","true");	 	 	 
	 $("#tercero,#tercero_hidden").val("");	 	 	 	 
    }else if(this.value == 'U'){
		 $("#tercero_hidden").addClass("obligatorio");
	     $("#tercero").attr("disabled","");	 	 	 		 
      }						
  });  
  
    
  
  $("#export").click(function(){
	
   var formulario = this.form;	
   
   if(ValidaRequeridos(formulario)){

     var QueryString = "TrasladosClass.php?ACTIONCONTROLER=onclickExport&"+FormSerialize(formulario);
     $("#frameReporte").attr("src",QueryString);
	   
   }	
	
  });
						   
});



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
    url        : "TrasladosClass.php",
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

     var QueryString = "TrasladosClass.php?ACTIONCONTROLER=onclickGenerarAuxiliar&"+FormSerialize(formulario);
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