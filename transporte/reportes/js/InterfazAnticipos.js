$(document).ready(function(){
						   
   $("#generar").click(function(){

     var formulario = this.form;

     if(ValidaRequeridos(formulario)){
	 
       var desde = $("#desde").val();
	   var hasta = $("#hasta").val();
	   
       var QueryString = "InterfazAnticiposClass.php?ACTIONCONTROLER=generateFile&desde="+desde+"&hasta="+hasta+"&rand="+Math.random();
			 
	   document.location.href = QueryString;

	 }
								
   });						   
						   
});