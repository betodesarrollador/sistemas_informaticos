$(document).ready(function(){
						   
   $("#generar").click(function(){

     var formulario = this.form;

     if(ValidaRequeridos(formulario)){
	 
       var desde = $("#desde").val();
	   var hasta = $("#hasta").val();
	   var tipo = $("#tipo").val();
	   
       var QueryString = "InterfazMinClass.php?ACTIONCONTROLER=generateFile&desde="+desde+"&hasta="+hasta+"&tipo="+tipo+"&rand="+Math.random();
			 
	   document.location.href = QueryString;

	 }
								
   });						   

   $("#generar_excel").click(function(){

     var formulario = this.form;

     if(ValidaRequeridos(formulario)){
	 
       var desde = $("#desde").val();
	   var hasta = $("#hasta").val();
	   var tipo = $("#tipo").val();
	   
       var QueryString = "InterfazMinClass.php?ACTIONCONTROLER=generateFileexcel&desde="+desde+"&hasta="+hasta+"&tipo="+tipo+"&rand="+Math.random();
			 
	   document.location.href = QueryString;

	 }
								
   });						   

});