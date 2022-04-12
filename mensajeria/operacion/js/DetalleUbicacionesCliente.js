$(document).ready(function(){

   addRow();
   removeRow();  
  
});

function addRow(){
	
	$("*[name=add]").click(function(){
	
	  var Row     = this.parentNode.parentNode;
	  var Table   = this.parentNode.parentNode.parentNode;
      var newRow  = Table.insertRow(Table.rows.length);

      $(newRow).html($("#clon").html()); 
	  
	  addRow();
	  
	  $(Row).find("*[name=add]").each(function(){
         $(this).replaceWith('<img name="remove" src="../../../framework/media/images/grid/close.png" />');	
		 removeRow();
      });
									
    });
	
}


function removeRow(){
	
	$("*[name=remove]").click(function(){
	
	  var Fila = this.parentNode.parentNode;
	  
	  $(Fila).remove();
									
    });	
	
}