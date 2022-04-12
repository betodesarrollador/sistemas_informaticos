function Vehiculo_si(){
	if($('#si_vehiculo').val()==1){
		
		  if($('#vehiculo'))    $('#vehiculo').attr("disabled","");
	
	}else if($('#si_vehiculo').val()=='ALL'){
		
		  if($('#vehiculo'))    $('#vehiculo').attr("disabled","true");
		  $('#vehiculo').val('');
		  $('#vehiculo_id').val('');
	}
}

function Tenedor_si(){
	if($('#si_tenedor').val()==1){
		
		  if($('#tenedor'))    $('#tenedor').attr("disabled","");
	
	}else if($('#si_tenedor').val()=='ALL'){
		
		  if($('#tenedor'))    $('#tenedor').attr("disabled","true");
		  $('#tenedor').val('');
		  $('#tenedor_id').val('');
	}
}

function all_oficce(){
	if(document.getElementById('all_oficina').checked==true){
		$('#all_oficina').val('SI');

		var objSelect = document.getElementById('oficina_id'); 
		var numOp     = objSelect.options.length -1;
	   
	   
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
		 var QueryString = "DetallesAnticiposClass.php?"+FormSerialize(formulario);
		 $("#frameReporte").attr("src",QueryString);
		 showDivLoading();	 	   
		 $("#frameReporte").load(function(response){removeDivLoading();});		
	}
	
 $("#generar_excel").click(function(){

     var formulario = this.form;

     if(ValidaRequeridos(formulario)){
	 
       var desde		 = $("#desde").val();
	   var hasta		 = $("#hasta").val();
	   var all_oficina	 = $("#all_oficina").val();
       var oficina_id	 = $("#oficina_id").val();
	   var si_tenedor 	 = $("#si_tenedor").val();	 
	   var tenedor_id 	 = $("#tenedor_id").val();
	   var tipo 		 = $("#tipo").val();	
	   var si_vehiculo   = $("#si_vehiculo").val();	 
	   var vehiculo_id   = $("#vehiculo_id").val();		   
	   
       var QueryString = "reporteAnticiposClass.php?ACTIONCONTROLER=generateFileexcel&desde="+desde+"&hasta="+hasta+"&oficina_id="+oficina_id+
	                     "&si_tenedor="+si_tenedor+"&all_oficina="+all_oficina+"&tenedor_id="+tenedor_id+"&tipo="+tipo+
						 "&si_vehiculo="+si_vehiculo+"&vehiculo_id="+vehiculo_id+"&rand="+Math.random();
						 
	   document.location.href = QueryString;	
	 }								
   });	
}

$(document).keypress(function(e){
	if(e.which == 13){
		var form = document.forms[0];
		OnclickGenerar(form);
	}
});