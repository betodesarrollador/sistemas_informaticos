$(document).ready(function(){
  
  removeField();
  
});


function removeField(){
  
  
  $("*[name=removeField]").click(function(){
    
    var Fila = this.parentNode.parentNode;
    
    $(Fila).remove();
    
    
  });
  
  
}