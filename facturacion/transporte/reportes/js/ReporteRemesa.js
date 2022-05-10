$(document).ready(function(){
						   
   $("#frameResult").attr("height","400");						   
   
  $("#opciones_oficina").click(function(){

     if(this.checked){
	   this.value = 'T';	 
	 }else{
		  this.value = 'U';
	   }
	   
     var objSelect = document.getElementById('oficina_id'); 
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
   
   
  $("#opciones_estado").click(function(){

     if(this.checked){
	   this.value = 'T';	 
	 }else{
		  this.value = 'U';
	   }
	   
     var objSelect = document.getElementById('estado'); 
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
						   
   $("#generar").click(function(){
			
	  document.getElementById('frameResult').src = "ReporteRemesasClass.php?ACTIONCONTROLER=generateReport&"+Math.random()+FormSerialize(this.form);
								
   });						   
						   
});