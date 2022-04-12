$(document).ready(function(){
   
  $("input[name=cuenta_presupuestar]").click(function(){
    
    var puc_id       = this.value;
    var presupuestar = this.checked;  
    
    $.ajax({
        url  : "ParametrosModuloClass.php",
        data : {'ACTIONCONTROLER':'setCuentaPresupuestar','puc_id':puc_id,'presupuestar':presupuestar},
        beforeSend : function(){
            showDivLoading()
        },
        success : function(response){            
            
            removeDivLoading();
            
            if($.trim(response) == 'true'){
                alertJquery('Operacion Exitosa','Cuentas Presupuestar');
            }else{
                 alertJquery(response,'Cuentas Presupuestar');
            }
        }
    });
    
  }); 
    
});