// JavaScript Document
$(document).ready(function(){
  setWidthFrameReporte();
  getReportParams();  						   
						   
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
    url        : "LibroMayorClass.php",
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
function onclickGenerarBalance(formulario){
   if(ValidaRequeridos(formulario)){
     var QueryString = "LibroMayorClass.php?ACTIONCONTROLER=onclickGenerarBalance&"+FormSerialize(formulario);
     $("#frameReporte").attr("src",QueryString);
     showDivLoading();	 	   
     $("#frameReporte").load(function(response){removeDivLoading();});
	   
   }
}