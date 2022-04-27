$(document).ready(function() {

    $('#panel tbody tr').remove();
    var QueryString = "ACTIONCONTROLER=getValores";

    $.ajax({
        url: "PanelClass.php",
        data: QueryString,
        success: function(resp) {

            var data = $.parseJSON(resp);

            if (data != null) {

                for (var i = 0; i < data.length; i++) {

                    var cliente = data[i]['cliente'];
                    var cliente_id = data[i]['cliente_id'];
                    var nombre = data[i]['nombre'];
                    var fase = data[i]['fase'];
                    var actividad = data[i]['actividad'];
                    var avance = data[i]['avance'];
                    var usuario = data[i]['usuario'];

                    var htmlTags = '<tr>' +
                        '<td>' + '<div id="left"><a href="javascript:detalles(' + cliente_id + ')" class="panel_desliza">' + cliente + '</a></div></td>' +
                        '<td>' + nombre + '</td>' +
                        '<td>' + fase + '</td>' +
                        '<td>' + actividad + '</td>' +
                        '<td>' + '<div class="progress">' +
                        '<div class="progress-bar" style="width:' + avance + '%">' + parseInt(avance) + '%</div>' +
                        '</div></td>' +
                        '<td>' + usuario + '</td>' +
                        '</tr>';

                    $('#panel tbody').append(htmlTags);
                }

            }
        }

    });

    $("#cerrar").click(function() {
        $('#detalle_actividad').hide();
    });

    $('#detalles').on('click', '.btn-info', function() {
        var actividad_id = $(this).parents("tr").find("#actividad_id").val();
        $("#actividad_id_modal").val(actividad_id);
    });

    $('#detalles').on('click', '.btn-danger', function() {
        var actividad_id = $(this).parents("tr").find("#actividad_id").val();
        $("#actividad_id_modal_cierre").val(actividad_id);
    });

    $("#guardar_observacion").click(function() {
        guardarObservacion();
    });

    $('#detalles').on('click', '.btn-primary', function() {
        var actividad_id = $(this).parents("tr").find("#actividad_id").val();

        $('#table_observacion tbody tr').remove();
        var QueryString = "ACTIONCONTROLER=getObservaciones&actividad_id=" + actividad_id;

        $.ajax({
            url: "PanelClass.php",
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

});

function detalles(cliente_id) {
    $('#detalle_actividad').show();

    //$('#cliente').val(cliente);
    if (cliente_id > 0) {

        $('#detalles tbody tr').remove();
        var QueryString = "ACTIONCONTROLER=getActividades&cliente_id=" + cliente_id;

        $.ajax({
            url: "PanelClass.php",
            data: QueryString,
            success: function(resp) {

                var data = $.parseJSON(resp);

                if (data != null) {

                    var cliente = data[0]['cliente'];
                    var proyecto = data[0]['proyecto'];

                    $("#cliente").val(cliente);
                    $("#proyecto").val(proyecto);

                    for (var i = 0; i < data.length; i++) {

                        var actividad_id = data[i]['actividad_id'];
                        var nombre = data[i]['nombre'];
                        var estado = data[i]['estado'];
                        var responsable = data[i]['responsable'];
                        var descripcion = data[i]['descripcion'];
                        var fecha_inicial = data[i]['fecha_inicial'];
                        var fecha_inicial_real = data[i]['fecha_inicial_real'];
                        var fecha_final = data[i]['fecha_final'];
                        var fecha_final_real = data[i]['fecha_final_real'];
                        var fase = data[i]['fase'];

                        if (estado == 'ACTIVO') {
                            var estado = '<td style="background-color:#71f793">' + estado + '</td>';
                        } else if (estado == 'INACTIVO') {
                            var estado = '<td style="background-color:#fffea5">' + estado + '</td>';
                        } else {
                            var estado = '<td style="background-color:#f95a5a">' + estado + '</td>';
                        }

                        var htmlTags = '<tr>' +
                            '<td><input type="hidden" id="actividad_id" value="' + actividad_id + '">' + nombre + '</td>' +
                            '<td>' + fase + '</td>' +
                            estado +
                            '<td><strong>' + responsable + '</strong></td>' +
                            '<td>' + descripcion + '<br><button type="button" class="btn btn-primary" id="ver_observacion" data-toggle="modal" data-target="#exampleModalObservacion"><i class="fa fa-eye" aria-hidden="true"></i></button></td>' +
                            '<td>' + fecha_inicial + '</td>' +
                            '<td>' + fecha_inicial_real + '</td>' +
                            '<td>' + fecha_final + '</td>' +
                            '<td>' + fecha_final_real + '</td>' +
                            '<td><button type="button" class="btn btn-info" id="add_observacion" data-toggle="modal" data-target="#exampleModal" ><i class="fa fa-commenting" aria-hidden="true"></i></button></td>' +
                            '<td><button type="button" class="btn btn-danger" id="cerrar" data-toggle="modal" data-target="#exampleModalCierre"><i class="fa fa-check-square" aria-hidden="true"></i></button></td>' +
                            '</tr>';

                        $('#detalles tbody').append(htmlTags);

                    }
                }
            }

        });

    }
}

function guardarObservacion() {

    var actividad_id = $("#actividad_id_modal").val();
    var observacion = $("#observacion").val();

    if (observacion != '') {

        var QueryString = "ACTIONCONTROLER=guardarObservacion&actividad_id=" + actividad_id + "&observacion=" + observacion;

        $.ajax({
            url: "PanelClass.php",
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

    var actividad_id = $("#actividad_id_modal_cierre").val();
    var fecha_cierre_real = $("#fecha_cierre").val();
    var observacion_cierre = $("#observacion_cierre").val();

    if (fecha_cierre_real != '') {

        var QueryString = "ACTIONCONTROLER=guardarCierre&actividad_id=" + actividad_id + "&observacion_cierre=" + observacion_cierre + "&fecha_cierre_real=" + fecha_cierre_real;

        $.ajax({
            url: "PanelClass.php",
            data: QueryString,
            success: function(resp) {
                console.log(resp);
                if (resp > 0) {

                    Swal.fire('¡Se cerró exitosamente la actividad!');
                    $("#observacion_cierre").val('');
                    $("#fecha_cierre").val('');

                    setTimeout(function() {
                        location.reload();
                    }, 3000);

                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Atención',
                        text: '¡Esta actividad ya se encuentra cerrada!',
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