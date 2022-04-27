$(document).ready(function(){
   
   document.getElementById('detallePresupuesto').height = '400';
   
	$("#todos").click(function(){
		
	   var checked = this.checked;
	   	
       $("input[type=checkbox]").each(function() {
         this.checked = checked; 
       });			
		
	});
	
	$("#consultar").click(function(){
		
      var presupuesto_id = document.getElementById('presupuesto_id').value;
      var QueryString    = 'ACTIONCONTROLER=getReportePresupuesto&presupuesto_id='+presupuesto_id;
	  var mesChecked     = false;
	  
	  $(".mes_contable:checked").each(function() {
        mesChecked = true;
      });
	  
	  if(presupuesto_id!= 'NULL' && mesChecked){
	  
	   $(".mes_contable").each(function(){
	      QueryString += "&"+this.name+"="+this.checked;
	   });

	   var ano = $("#presupuesto_id option:selected").text();
	  
        var src = 'DetalleReportePresupuestoClass.php?'+QueryString+"&ano="+ano;
		
		$("#detallePresupuesto").attr("src", src);
		showDivLoading();
		$("#detallePresupuesto").load(function (response) {
		  removeDivLoading();
		}); 

	  }else{
		  
		  if(presupuesto_id == 'NULL'){
			 alert('Debe Seleccionar un Presupuesto'); 
		  }else{
			  alert('Debe Seleccionar Por lo menos un Mes!');
			}

	   }

	});
    
});

function beforePrint(formulario){
	
      var presupuesto_id = document.getElementById('presupuesto_id').value;
      var QueryString    = 'ACTIONCONTROLER=getReportePresupuesto&presupuesto_id='+presupuesto_id;
	  var mesChecked     = false;
	  
	  $(".mes_contable:checked").each(function() {
        mesChecked = true;
      });
	  
	  if(presupuesto_id!= 'NULL' && mesChecked){
	  
	   $(".mes_contable").each(function(){
	      QueryString += "&"+this.name+"="+this.checked;
	   });
	  
	  }
	  
   if(ValidaRequeridos(formulario)){
     var QueryString = 'DetalleReportePresupuestoClass.php?'+QueryString; 
     popPup(QueryString,'Impresion Reporte',800,600);
    
   }
}

function descargarexcel(formulario){
	
      var presupuesto_id = document.getElementById('presupuesto_id').value;
      var QueryString    = 'ACTIONCONTROLER=getReportePresupuesto&download=true&presupuesto_id='+presupuesto_id;
	  var mesChecked     = false;
	  
	  $(".mes_contable:checked").each(function() {
        mesChecked = true;
      });
	  
	  if(presupuesto_id!= 'NULL' && mesChecked){
	  
	   $(".mes_contable").each(function(){
	      QueryString += "&"+this.name+"="+this.checked;
	   });
	  
	  }
	  
   if(ValidaRequeridos(formulario)){
     var QueryString = 'DetalleReportePresupuestoClass.php?'+QueryString; 
     popPup(QueryString,'Impresion Reporte',800,600);
    
   }

	
	 /* var presupuesto_id = document.getElementById('presupuesto_id').value;
      var QueryString    = 'ACTIONCONTROLER=onclickGenerarPresupuesto&download=true&presupuesto_id='+presupuesto_id;
	  var mesChecked     = false;
	  
	  $(".mes_contable:checked").each(function() {
        mesChecked = true;
      });
	  
	  if(presupuesto_id!= 'NULL' && mesChecked){
	  
	   $(".mes_contable").each(function(){
	      QueryString += "&"+this.name+"="+this.checked;
	   });
	  
	  }
	  

	if(ValidaRequeridos(formulario)){ 
		 var QueryString = "ReportePresupuestoClass.php?"+QueryString+FormSerialize(formulario);
		 $("#detallePresupuesto").attr("src",QueryString);
	}*/
}