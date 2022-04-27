$(document).ready(function(){
   
   calcularTotales();
    
});

function calcularTotales(){
        
   $("input[type=text]").keyup(function(){

      var row          = this.parentNode.parentNode;
      var celda        = this.name;
      var total_cuenta = 0;
      var totalColumna = 0;
      var total        = 0;
      
      $("input[name="+celda+"]").each(function(){        
        totalColumna = (totalColumna*1)+(removeFormatCurrency(this.value)*1);        
      });
      
      $("#total_"+celda).val(setFormatCurrency(totalColumna));
      
      total_cuenta = (total_cuenta*1)+(removeFormatCurrency($(row).find("input[name=enero]").val())*1);
      total_cuenta = (total_cuenta*1)+(removeFormatCurrency($(row).find("input[name=febrero]").val())*1);
      total_cuenta = (total_cuenta*1)+(removeFormatCurrency($(row).find("input[name=marzo]").val())*1);
      total_cuenta = (total_cuenta*1)+(removeFormatCurrency($(row).find("input[name=abril]").val())*1);
      total_cuenta = (total_cuenta*1)+(removeFormatCurrency($(row).find("input[name=mayo]").val())*1);
      total_cuenta = (total_cuenta*1)+(removeFormatCurrency($(row).find("input[name=junio]").val())*1);
      total_cuenta = (total_cuenta*1)+(removeFormatCurrency($(row).find("input[name=julio]").val())*1);
      total_cuenta = (total_cuenta*1)+(removeFormatCurrency($(row).find("input[name=agosto]").val())*1);
      total_cuenta = (total_cuenta*1)+(removeFormatCurrency($(row).find("input[name=septiembre]").val())*1);
      total_cuenta = (total_cuenta*1)+(removeFormatCurrency($(row).find("input[name=octubre]").val())*1);
      total_cuenta = (total_cuenta*1)+(removeFormatCurrency($(row).find("input[name=noviembre]").val())*1);   
      total_cuenta = (total_cuenta*1)+(removeFormatCurrency($(row).find("input[name=diciembre]").val())*1);
      
      $(row).find("input[name=total_cuenta]").val(setFormatCurrency(total_cuenta));
      
      $("input[name=total_cuenta]").each(function(){
         total = (total*1)+(removeFormatCurrency(this.value)*1);
      });                                                                    
    
      $("#total").val(setFormatCurrency(total));
    
   }); 
    
} 

function setDetallePresupuesto(){
    
    var presupuesto_id = $("#presupuesto_id").val(); 
    var presupuesto    = '{"presupuesto":{';
    var i              = 0;
    
    $(".presupuesto").each(function(){
       
        presupuesto += '"'+i+'":{';
        
        $(this).find(".detalle_presupuesto").each(function(){
           
           var value = removeFormatCurrency(this.value); 
           var valor = (value*1) > 0 ? value : 0; 
           presupuesto += '"'+this.name+'":"'+valor+'",'    
        })
            
        presupuesto = presupuesto.substring(0,presupuesto.length - 1)+'},';
        i++;
    });
    
    presupuesto = presupuesto.substring(0,presupuesto.length - 1)+'}}';
    
    var QueryString = "ACTIONCONTROLER=setDetallePresupuesto&presupuesto_id="+presupuesto_id+"&presupuesto="+presupuesto; 
    
    $.ajax({
        url  : "DetallePresupuestoClass.php?rand="+Math.random(),
        data : QueryString,
        type : 'POST',
        beforeSend : function(){
            showDivLoading();
        },
        success : function(resp){
            
            removeDivLoading();
            
            if($.trim(resp) == 'true'){
                alertJquery('Guardado Exitosamente','Cuentas Presupuesto');                
            }else{
                 alertJquery(resp,'Error:');
            }
        }
        
    });    
        
}

function deleteRow(obj,detalle_presupuesto_id){

  var QueryString = "ACTIONCONTROLER=deleteRow&detalle_presupuesto_id="+detalle_presupuesto_id;
  
  $.ajax({
    url  : "DetallePresupuestoClass.php?rand="+Math.random(),
    type : 'POST',
    data : QueryString,
    beforeSend: function(){
      showDivLoading();
    },
    success : function(response){
    
      removeDivLoading();
      
      if($.trim(response) == 'true'){
        $(obj.parentNode.parentNode).remove();
      }else{
        alert(response);
      }
    
    }
  });

}