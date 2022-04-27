$(document).ready(function(){
						   
  $("*[name=guardar]").click(function(){

     var row              = this.parentNode.parentNode;
	 var producto_id      = $(row).find("input[name=producto_id]").val();
	 var producto_empresa = $(row).find("input[name=producto_empresa]").val();
	 var mostrar          = $(row).find("input[name=mostrar]").attr("checked") == false ? 0 : 1;	 
     var QueryString      = "ACTIONCONTROLER=onclickSave&producto_id="+producto_id+"&producto_empresa="+producto_empresa+"&mostrar="+mostrar;							   
	 	 
	 $.ajax({
	   url        : "ProductosClass.php?rand="+producto_id,
	   data       : QueryString,
	   beforeSend : function(){
		  showDivLoading();
	   },
	   success    : function(resp){
		   						
			if($.trim(resp) == 'true'){
			  alertJquery("Producto Cambio Exitosamente!!","Productos Empresa");
			}else{
				alertJquery(resp,"Error :");
		      }
			  
		    removeDivLoading();
	   }
	 });
							   
  });

});