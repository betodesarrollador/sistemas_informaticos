$(document).ready(function () {
    $("#link_video").removeClass('text_uppercase');
    
    $('#select_modulos').click(function(){
        
        var modulos = [];
        
        $('#select_modulos option:selected').each(function(){
            
            modulos.push($(this).text()); 
            
            $('#modulos').val(modulos);
        });
        
        setTimeout(function() { $('#modulos').val(modulos); }, 200);
        
    }); 
       

});

function getEmpresas(){
    
    var arrayDB = [];
        
    $("input[name=procesar]:checked").each(function () {
          
            var database = this.value;

            arrayDB.push(database);

            $('#empresas').val(arrayDB);
    });
    
    setTimeout(function() { $('#empresas').val(arrayDB); }, 600);
    
}

function check_all(obj) {

    $("input[name=procesar]").each(function () {

        if (obj.checked) {

            $(this).attr("checked", "true");

        } else {

            $(this).removeAttr("checked");

        }

    });
    
    getEmpresas();

}


function limpiar() {
    $("#mensaje").val('');
}


function AlertaOnSave(formulario,resp){
    
    alertJquery(resp);
    console.log(resp);
}


function all_modulo() {
    if (document.getElementById('all_modulos').checked == true) {
        $('#all_modulos').val('SI');

        var objSelect = document.getElementById('select_modulos');
        var numOp = objSelect.options.length - 1;


        for (var i = numOp; i > 0; i--) {

            if (objSelect.options[i].value != 'NULL') {
                objSelect.options[i].selected = true;
            } else {
                objSelect.options[i].selected = false;
            }
        }

    } else {
        $('#all_modulos').val('NO');
        var objSelect = document.getElementById('select_modulos');
        var numOp = objSelect.options.length - 1;


        for (var i = numOp; i > 0; i--) {

            if (objSelect.options[i].value != 'NULL') {
                objSelect.options[i].selected = false;
            } else {
                objSelect.options[i].selected = true;
            }
        }
    }
    
    $("#select_modulos").trigger('click');
}