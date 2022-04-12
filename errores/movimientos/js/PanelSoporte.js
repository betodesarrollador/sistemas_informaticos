$(document).ready(function() {


    //detalles();




    $('#detalles').on('click', '.btn-info', function() {
        var soporte_id = $(this).parents("tr").find("#soporte_id").val();
        $("#soporte_id_modal").val(soporte_id);
    });

    $('#detalles').on('click', '.btn-danger', function() {
        var soporte_id = $(this).parents("tr").find("#soporte_id").val();
        $("#soporte_id_modal_cierre").val(soporte_id);
    });

    $("#guardar_observacion").click(function() {
        guardarObservacion();
    });

    $('#detalles').on('click', '.btn-primary', function() {
        var soporte_id = $(this).parents("tr").find("#soporte_id").val();

        $('#table_observacion tbody tr').remove();
        var QueryString = "ACTIONCONTROLER=getObservaciones&soporte_id=" + soporte_id;

        $.ajax({
            url: "PanelSoporteClass.php",
            data: QueryString,
            success: function(resp) {

                var data = $.parseJSON(resp);

                if (data != null) {

                    for (var i = 0; i < data.length; i++) {
                        var observacion = data[i]['observacion'];

                        var htmlTags = '<tr>' +
                            '<td>' + observacion + '</td>' +
                            '</tr>';

                        $('#table_observacion tbody').append(htmlTags);
                    }

                }

            }

        });
    });

    $("#guardar_cierre").click(function() {
        guardarCierre();
    });

    $('#detalles_responsables').DataTable({
        responsive: true
    });

    $('#detalles').DataTable({
        responsive: true
    });

});

function detalles() {

    $('#detalles tbody tr').remove();
    var QueryString = "ACTIONCONTROLER=getActividades";

    $.ajax({
        url: "PanelSoporteClass.php",
        data: QueryString,
        success: function(resp) {

            var data = $.parseJSON(resp);

            if (data != null) {

                for (var i = 0; i < data.length; i++) {

                    var soporte_id = data[i]['soporte_id'];
                    var cliente = data[i]['cliente'];
                    var responsable = data[i]['responsable'];
                    var nombre = data[i]['nombre'];
                    var estado = data[i]['estado'];
                    var descripcion = data[i]['descripcion'];
                    var fecha_inicial = data[i]['fecha_inicial'];
                    var fecha_inicial_real = data[i]['fecha_inicial_real'];
                    var fecha_final = data[i]['fecha_final'];
                    var fecha_final_real = data[i]['fecha_final_real'];
                    var fecha_cierre_real = data[i]['fecha_cierre_real'];

                    if (estado == 'ACTIVO') {
                        var estado = '<td style="background-color:#71f793">' + estado + '</td>';
                    } else if (estado == 'INACTIVO') {
                        var estado = '<td style="background-color:#fffea5">' + estado + '</td>';
                    } else {
                        var estado = '<td style="background-color:#f95a5a">' + estado + '</td>';
                    }

                    if (cliente == '') {
                        cliente = "N/A";
                    }

                    var htmlTags = '<tr>' +
                        '<td><input type="hidden" id="soporte_id" value="' + soporte_id + '">' + cliente + '</td>' +
                        '<td>' + nombre + '</td>' +
                        '<td><strong>' + responsable + '</strong></td>' +
                        estado +
                        '<td><div style=" width: 250px; height: 200px;overflow: scroll;">' + descripcion + '</div><br><button type="button" class="btn btn-primary" id="ver_observacion" data-toggle="modal" data-target="#exampleModalObservacion"><i class="fa fa-eye" aria-hidden="true"></i></button></td>' +
                        '<td>' + fecha_inicial + '</td>' +
                        '<td>' + fecha_inicial_real + '</td>' +
                        '<td>' + fecha_final + '</td>' +
                        '<td>' + fecha_final_real + '</td>' +
                        '<td>' + fecha_cierre_real + '</td>' +
                        '<td><button type="button" class="btn btn-info" id="add_observacion" data-toggle="modal" data-target="#exampleModal" ><i class="fa fa-commenting" aria-hidden="true"></i></button></td>' +
                        '<td><button type="button" class="btn btn-danger" id="cerrar" data-toggle="modal" data-target="#exampleModalCierre"><i class="fa fa-check-square" aria-hidden="true"></i></button></td>' +
                        '</tr>';

                    $('#detalles tbody').append(htmlTags);

                }

            }
        }

    });



}

function guardarObservacion() {

    var soporte_id = $("#soporte_id_modal").val();
    var observacion = $("#observacion").val();

    if (observacion != '') {

        var QueryString = "ACTIONCONTROLER=guardarObservacion&soporte_id=" + soporte_id + "&observacion=" + observacion;

        $.ajax({
            url: "PanelSoporteClass.php",
            data: QueryString,
            success: function(resp) {

                var data = $.parseJSON(resp);

                if (data > 0) {

                    Swal.fire('¡Se guardo exitosamente la observación!');
                    $("#observacion").val('');

                }

            }

        });
    } else {


        Swal.fire({
            icon: 'error',
            title: 'Atención',
            text: '¡Por favor digita una observacion!',
        })
    }




}

function guardarCierre() {

    var soporte_id = $("#soporte_id_modal_cierre").val();
    var fecha_cierre_real = $("#fecha_cierre").val();
    var observacion_cierre = $("#observacion_cierre").val();

    if (fecha_cierre_real != '') {

        var QueryString = "ACTIONCONTROLER=guardarCierre&soporte_id=" + soporte_id + "&observacion_cierre=" + observacion_cierre + "&fecha_cierre_real=" + fecha_cierre_real;

        $.ajax({
            url: "PanelSoporteClass.php",
            data: QueryString,
            success: function(resp) {
                console.log(resp);
                if (resp > 0) {

                    Swal.fire('¡Se cerró exitosamente la tarea!');
                    $("#observacion_cierre").val('');
                    $("#fecha_cierre").val('');

                    setTimeout(function() {
                        location.reload();
                    }, 3000);

                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Atención',
                        text: '¡Esta tarea ya se encuentra cerrada!\n\nSi la tarea no está cerrada puede que usted esté ingresando caracteres no aceptados.\n\nNo colocar código de ningún tipo para evitar este inconveniente.',
                    })
                    $("#observacion_cierre").val('');
                    $("#fecha_cierre").val('');
                }

            }

        });
    } else {


        Swal.fire({
            icon: 'error',
            title: 'Atención',
            text: '¡Por favor digita una fecha!',
        })
    }
}