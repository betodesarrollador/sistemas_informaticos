$(document).ready(function(){
						   
   $("#frameResult").attr("height","400");						   
   
   $("#opciones_placa").change(function(){

	   $("#placa,#placa_id_hidden").val("");
	   
       if(this.value == 'U'){
         document.getElementById("placa").disabled = false; 
	   }else{
           document.getElementById("placa").disabled = true;
		 }
										
   });
   
   $("#opciones_conductor").change(function(){

	   $("#conductor,#conductor_id_hidden").val("");
	   
       if(this.value == 'U'){
         document.getElementById("conductor").disabled = false; 
	   }else{
           document.getElementById("conductor").disabled = true;
		 }
										
   });   
   
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

  $("#opciones_documento").click(function(){

     if(this.checked){
	   this.value = 'T';	 
	 }else{
		  this.value = 'U';
	   }
	   
     var objSelect = document.getElementById('documento'); 
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

   $("#listar").click(function(){	
    var formulario = this.form;

     if(ValidaRequeridos(formulario)){
	  	/*showDivLoading();
	  	document.getElementById('frameResult').src = "DespachosClass.php?ACTIONCONTROLER=generateReport&"+Math.random()+FormSerialize(this.form);								
		removeDivLoading();*/
		
		 var QueryString = "DespachosClass.php?ACTIONCONTROLER=generateReport&"+Math.random()+FormSerialize(this.form);
		 $("#frameResult").attr("src",QueryString);
		 showDivLoading();	 	   
		 $("#frameResult").load(function(response){removeDivLoading();});

	 }
   });
   
   $("#generar").click(function(){	
	 var formulario = this.form;
     if(ValidaRequeridos(formulario)){
	  document.location.href = "DespachosClass.php?ACTIONCONTROLER=generateFile&"+Math.random()+FormSerialize(this.form);	
	  
	 }
   });   
						   
});