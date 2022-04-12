// JavaScript Document

$(document).ready(function(){

    $("#query").removeClass("text_uppercase");
    
    $('#query').keydown(function (e) {

      if (e.ctrlKey && e.keyCode == 13) {//ctrl + enter
                                         
        setTimeout(function() {

          ejecutarQuery();
              
            }, 200); 
      }
    });
   

});

function check_all(obj){
  
  $("input[name=procesar]").each(function (){

    var fila = this;

    if(obj.checked){

      $(this).attr("checked","true");

    }else{

      $(this).removeAttr("checked");

    }

  });

}


function limpiar(){
  $("#query").val('');
}



function ejecutarQuery(){

  var query         =  $("#query").val();

  var arrayDB       = [];

  var bandera       = false;

  $("input[name=procesar]").each(function (){

    if(this.checked){

      bandera = true;

      var database = this.value;

      arrayDB.push(database);

    }

  });

  var QueryString   = "ACTIONCONTROLER=ejecutarQuery&query="+encodeURIComponent(query)+"&databases="+arrayDB;

  if(query != "" && bandera){

    jConfirm("¿ Esta seguro que desea realizar este cambio en las bases de datos : <b>"+arrayDB+"</b> ?", "Validacion", 
					 
	 function(r) {  																				   
	 if(r) {  

      $.ajax({
        url        : "MySqlClass.php?rand="+Math.random(),
        type       : "POST",
        data       : QueryString,
        beforeSend : function(){
        showDivLoading();
        },
        success    : function(resp){
        try{
        
        removeDivLoading();

        alertJquery(resp);
      
        }catch(e){
        
        removeDivLoading();
        alertJquery("Se presento un error :"+e,"Error");
      
        }
        } 
      });				
								     
	} else { 
	 return false;
	}						   
	     }); 

  }else{
    alertJquery("Por favor Digite la accion a ejecutar junto con las bases de datos a afectar !!","Validacion");
  }

}