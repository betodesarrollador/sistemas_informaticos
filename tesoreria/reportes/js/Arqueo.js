function usuarioOnReset(formulario){
	
		$("#frameReporte").attr("src","/envipack/framework/tpl/blank.html");

	}

function all_oficce(){
	if(document.getElementById('all_oficina').checked==true){
		$('#all_oficina').val('SI');

		var objSelect = document.getElementById('oficina_id'); 
		var numOp     = objSelect.options.length -1;
	    objSelect.options[0].selected=false;
	   
	   for(var i = numOp; i > 0; i-- ){
		   
		  if(objSelect.options[i].value != 'NULL'){
			 objSelect.options[i].selected = true;
		  }else{
			   objSelect.options[i].selected = false;
			} 
		   
	   }
		 		 


	}else{
		$('#all_oficina').val('NO');
		var objSelect = document.getElementById('oficina_id'); 
		var numOp     = objSelect.options.length -1;

		 
	     for(var i = numOp; i > 0; i-- ){
		   
		   if(objSelect.options[i].value != 'NULL'){
			 objSelect.options[i].selected = false;
		   }else{
			   objSelect.options[i].selected = true;
			 } 
		   
	     } 		 

	}
	
}

function OnclickGenerar(formulario){
	
	if(ValidaRequeridos(formulario)){
		
		var oficina_id = $("#oficina_id").val();
		 var desde = $("#desde").val();
		 var hasta = $("#hasta").val();
		 
		 var QueryString = "ACTIONCONTROLER=setDocumentos";
	 
	 $.ajax({
	   url        : "/envipack/tesoreria/movimientos/clases/ArqueoCajaClass.php",
	   data       : QueryString,
	   beforeSend : function(){

	   },
	   success : function(response){
			   
		   var valor = response;
		   
		   if(valor!= '' ){
			  /* 
			   var lugar = document.getElementById("tabla1");
			   var sitio = document.createElement("input");
			   sitio.val(valor);
			   //sitio.innerHTML = valor;
			   
			   lugar.appendChild(sitio);
				//$("#documentos").val(valor);	
		  
		 
		 
		 
		 
		 
		 var complemento = '&opciones_centros=U&opciones_documentos=T&reporte=C&opciones_tercero=T&oficina_id='+oficina_id+'&tercero=NULL&tercero_id=NULL&agrupar=cuenta&desde='
			 +desde+'&hasta='+hasta;
			
			
			 var QueryString1 = "/envipack/tesoreria/movimientos/clases/LibrosAuxiliaresClass.php?ACTIONCONTROLER=onclickGenerarAuxiliar&"+FormSerialize(forma)+complemento;*/
			
		
		 var QueryString = "DetallesClass.php?"+FormSerialize(formulario);
		 $("#frameReporte").attr("src",QueryString);
		 showDivLoading();	 	   
		 $("#frameReporte").load(function(response){removeDivLoading();});
		 }  
		  }
		   
	 });
	}
	
}
	$(document).ready(function(){

		///INICIO VALIDACION FECHAS DE REPORTE
 
   $('#desde').change(function(){

    var fechah = $('#hasta').val();
    var fechad = $('#desde').val();
    var today = new Date();

    if ((Date.parse(fechah) < Date.parse(fechad)) || (Date.parse(fechad)>today)) {
     alertJquery('Esta fecha no puede ser mayor a la fecha final o mayor a hoy.');
     return this.value = $('#hasta').val();
    };
 });

 $('#hasta').change(function(){

    var fechah = $('#hasta').val();
    var fechad = $('#desde').val();
    var today = new Date();

    if ((Date.parse(fechah) < Date.parse(fechad)) || (Date.parse(fechah)>today)) {
     alertJquery('Esta fecha no puede ser menor a la fecha de inicio o mayor a hoy.');
     return this.value = $('#desde').val();
    };
 });
 
 ///FIN VALIDACION FECHAS DE REPORTE

		$("#generar_excel").click(function(){
		
		 var formulario = this.form;
		
			if(ValidaRequeridos(formulario)){
		 
			   var desde = $("#desde").val();
			   var hasta = $("#hasta").val();
			   var estado = $("#estado").val();
			   var oficina_id = $("#oficina_id").val();
			   
			   var QueryString = "DetallesClass.php?ACTIONCONTROLER=generateFileexcel&desde="+desde+"&hasta="+hasta+"&estado="+estado+"&oficina_id="+oficina_id+"&rand="+Math.random();
			   document.location.href = QueryString;						 
			
			}								
	});
});