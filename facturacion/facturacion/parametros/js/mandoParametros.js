// JavaScript Document
function updateGrid() {
    $("#refresh_QUERYGRID_mandoParametros").click();
}


$(document).ready(function () {

    if (intervalo) {
        clearInterval(intervalo);
        var intervalo = window.setInterval(function () { updateGrid() }, 50000);
    } else {
        var intervalo = window.setInterval(function () { updateGrid() }, 50000);
    }

    var QueryString = "ACTIONCONTROLER=ProximosVencerElectronica";

    $.ajax({
        url: "mandoParametrosClass.php",
        data: QueryString,
        beforeSend: function () {
        },
        success: function (response) {

            var data = $.parseJSON(response);

            if (data != null) {

                var parametro = data[0]['parametro'];
                var consecutivo = data[0]['consecutivo'];
                
                var resolucion_dian = parametro[0]['resolucion_dian'];
                var rango_final = parametro[0]['rango_final'];
                var consecutivo_factura = consecutivo[0]['consecutivo_factura'];
                
                var diferencia = (rango_final-consecutivo_factura);
                /* if(diferencia < 3400){
                    //alertJquery("<h3>¡FALTAN  <p style='color: #e51920'>" + diferencia +"</p> CONSECUTIVOS PARA AGOTARSEN LOS PARAMETRIZADOS EN LA RESOLUCION <p style='color: #e51920'>"+resolucion_dian+"</p> PARA LAS FACTURAS ELECTRONICAS!</h3>", "Atención");
                        Swal.fire(
                            'Atención',
                            '<h4 style="font_size">¡Faltan  <p style="color: #e51920">' + diferencia + '</p> Consecutivos para agotarsen los parametrizados en la resolución <p style="color: #e51920">' + resolucion_dian + ' </p> Para las facturas ELECTRONICAS!</h4>',
                            'info'
                        ) 
                     
                } */

                var QueryString = "ACTIONCONTROLER=ProximosVencerDigital";

                $.ajax({
                    url: "mandoParametrosClass.php",
                    data: QueryString,
                    beforeSend: function () {
                    },
                    success: function (response) {

                        var data = $.parseJSON(response);

                        if (data != null) {

                            var parametroDigital = data[0]['parametroDigital'];
                            var consecutivoDigital = data[0]['consecutivoDigital'];

                            var resolucion_dian1 = parametroDigital[0]['resolucion_dian'];
                            var rango_final1 = parametroDigital[0]['rango_final'];
                            var consecutivo_factura1 = consecutivoDigital[0]['consecutivo_factura'];

                            var diferencia1 = (rango_final1 - consecutivo_factura1);

                            
                            if (diferencia < 500 && diferencia1 < 500) {
                                //alertJquery("<h3>¡FALTAN  <p style='color: #e51920'>" + diferencia +"</p> CONSECUTIVOS PARA AGOTARSEN LOS PARAMETRIZADOS EN LA RESOLUCION <p style='color: #e51920'>"+resolucion_dian+"</p> PARA LAS FACTURAS ELECTRONICAS!</h3>", "Atención");
                                Swal.fire(
                                    'Atención',
                                    '<h6 style="font-family:Arial, Helvetica, sans-serif">¡Faltan  <p style="color: #e51920">' + diferencia + '</p> Consecutivos para agotarsen los parametrizados en la resolución <p style="color: #e51920">' + resolucion_dian + ' </p> Para las facturas ELECTRONICAS  Y  <p style="color: #e51920">' + diferencia1 + '</p> Consecutivos para agotarsen los parametrizados en la resolución <p style="color: #e51920">' + resolucion_dian1 + ' </p> Para las facturas DIGITALES! </h6>',
                                    'info'
                                )

                            }else if (diferencia < 500) {
                                //alertJquery("<h3>¡FALTAN  <p style='color: #e51920'>" + diferencia +"</p> CONSECUTIVOS PARA AGOTARSEN LOS PARAMETRIZADOS EN LA RESOLUCION <p style='color: #e51920'>"+resolucion_dian+"</p> PARA LAS FACTURAS ELECTRONICAS!</h3>", "Atención");
                                Swal.fire(
                                    'Atención',
                                    '<h4 style="font-family:Arial, Helvetica, sans-serif">¡Faltan  <p style="color: #e51920">' + diferencia + '</p> Consecutivos para agotarsen los parametrizados en la resolución <p style="color: #e51920">' + resolucion_dian + ' </p> Para las facturas ELECTRONICAS!</h4>',
                                    'info'
                                )
                            }else if (diferencia1 < 500) {
                                //alertJquery("<h3>¡FALTAN  <p style='color: #e51920'>" + diferencia +"</p> CONSECUTIVOS PARA AGOTARSEN LOS PARAMETRIZADOS EN LA RESOLUCION <p style='color: #e51920'>"+resolucion_dian+"</p> PARA LAS FACTURAS ELECTRONICAS!</h3>", "Atención");
                                Swal.fire(
                                    'Atención',
                                    '<h4 style="font-family:Arial, Helvetica, sans-serif">¡Faltan  <p style="color: #e51920">' + diferencia1 + '</p> Consecutivos para agotarsen los parametrizados en la resolución <p style="color: #e51920">' + resolucion_dian1 + ' </p> Para las facturas DIGITALES!</h4>',
                                    'info'
                                )
                            }

                        }
                    }

                });


                
                
            }
        }

    });

});

function reloadGrid() {

    $("#refresh_QUERYGRID_mandoParametros").click();

}