var  row = '';
var  tipo_tarea_id = 1;
var  table = "";
var  table_avances="";
var  table_vencidas="";
var  table_actuales="";

$(document).ready(function () {

    /*  $.ajax({
 
         url: "datatable-panelTareas.ajax.php",
         
         success:function(respuesta){
             
             console.log("respuesta table : ", respuesta);
     
         }
     
     })   */

     tinymce.init({
        selector: '#observacion_cierre',
        entity_encoding: "raw",
        height : "500",
        plugins: 'image code'

    });

    $('#detalles').on('click', '.btn-info', function () {
        var actividad_id = $(this).parents("tr").find("#actividad_id").val();
        console.log('actividad_id : ', actividad_id);
        $("#actividad_id_modal").val(actividad_id);
    });

    $('#detalles').on('click', '.btn-danger', function () {
        var actividad_id = $(this).parents("tr").find("#actividad_id").val();
        $("#actividad_id_modal_cierre").val(actividad_id);
    });

    $("#guardar_observacion").click(function () {
        guardarObservacion();
    });

    $('#detalles').on('click', '.btn-primary', function () {
        var actividad_id = $(this).parents("tr").find("#actividad_id").val();

        $('#table_observacion tbody tr').remove();
        var QueryString = "ACTIONCONTROLER=getObservaciones&actividad_id=" + actividad_id;

        $.ajax({
            url: "PanelTareasClass.php",
            data: QueryString,
            success: function (resp) {

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

    $("#guardar_cierre").click(function () {
        guardarCierre();
    });

    $("#pendiente_socializar").click(function () {
        pendienteSocializar();
    });

    //Table Avances
    table_avances = $('#detalles_responsables').DataTable({
        //responsive: true,
        ordering: false,
        //"processing": true,
        "ajax": "datatable-panelTareas.ajax.php?detalles_responsables=true&tipo_tarea_id=" + tipo_tarea_id,
        "lengthMenu": [[5, 25, 50, -1], [5, 25, 50, "Todas"]],
        "language": {

            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }

        }
    });

    //Table tareas sin entregar
    table_vencidas = $('#tareas_vencidas').DataTable({
        //responsive: true,
        "lengthMenu": [[5, 25, 50, -1], [5, 25, 50, "Todas"]],
        ordering: false,
        //"processing": true,
        "ajax": "datatable-panelTareas.ajax.php?tareas_vencidas=true&tipo_tarea_id=" + tipo_tarea_id,
        "language": {

            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }

        }
    });

    //Table tareas finalizadas
    table_finalizadas = $('#tareas_finalizadas').DataTable({
        //responsive: true,
        "lengthMenu": [[5, 25, 50, -1], [5, 25, 50, "Todas"]],
        ordering: false,
        //"processing": true,
        "ajax": "datatable-panelTareas.ajax.php?tareas_finalizadas=true&tipo_tarea_id=" + tipo_tarea_id,
        "language": {

            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }

        }
    });

    //Table tareas pendientes por socializar
    table_pendientes_socializar = $('#tareas_pendiente_socializar').DataTable({
        //responsive: true,
        "lengthMenu": [[5, 25, 50, -1], [5, 25, 50, "Todas"]],
        ordering: false,
        //"processing": true,
        "ajax": "datatable-panelTareas.ajax.php?tareas_pendiente_socializar=true&tipo_tarea_id=" + tipo_tarea_id,
        "language": {

            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }

        }
    });


    //table tareas para entregar hoy
    table_actuales = $('#tareas_actuales').DataTable({
        //responsive: true,
        //"processing": true,
        "ajax": "datatable-panelTareas.ajax.php?tareas_actuales=true&tipo_tarea_id=" + tipo_tarea_id,
        "lengthMenu": [[5, 25, 50, -1], [5, 25, 50, "Todas"]],
        ordering: false,
        "language": {

            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }

        }
    });


    $('#detalles thead tr').clone(true).appendTo('#detalles thead');
    $('#detalles thead tr:eq(1) th').each(function (i) {

        var title = $(this).text();

        if ($.trim(title) == 'Estado' || $.trim(title) == 'Responsable' || $.trim(title) == 'Asiganada por' || $.trim(title) == 'Cliente') {

            $(this).html('<div class="row"><input type="text" class="form-control" style="width:100%" placeholder="Buscar" /></div>');

            $('input', this).on('keyup change', function () {

                if (table.column(i).search() !== this.value) {

                    table.column(i).search(this.value).draw();

                }
            });

        } else {

            $(this).html('<input type="hidden" style="display:none" />');

        }

    });


    var groupColumn = 8;

    //table principal panel
    table = $('#detalles').DataTable({
        //responsive: true,
        dom: "Bfrtip",
        fixedHeader: true,
        "lengthMenu": [[-1], ["Todas"]],
        buttons: [
        /* {
            extend: "copyHtml5",
            className: "btn-primary",
            text: '<i class="fa fa-files-o"></i>',
            titleAttr: "Copy",
            footer: true,
            exportOptions: {
                columns: ':visible'
            }
        },
        {
            extend: "excelHtml5",
            className: "btn-success",
            text: '<i class="fa fa-file-excel-o"></i>',
            titleAttr: "Excel",
            footer: true,
            visible: true,
            exportOptions: {
                columns: ':visible'
            }
        },
        {
            extend: "csvHtml5",
            className: "btn-info",
            text: '<i class="fa fa-file-text-o"></i>',
            titleAttr: "CSV",
            footer: true,
            exportOptions: {
                columns: ':visible'
            }
        },
        {
            extend: "pdfHtml5",
            className: "btn-danger",
            text: '<i class="fa fa-file-pdf-o"></i>',
            titleAttr: "PDF",
            footer: true,
            exportOptions: {
                columns: ':visible'
            }
        }, */
       /*  {
            extend   : 'colvisGroup',
            text     : 'Mostrar todas las columas',
            className: "btn-primary btn-sm",
            show     : ':hidden'
        },
        {
            extend    : 'colvisGroup',
            text      : 'Ocultar detalles',
            className : "btn-warning btn-sm",
            show      : [ 0,2,3,4,10,6,7,9],
            hide      : [ 1,8,5,11,12,13,14,15,16,17]
        } */
        ],

        "columnDefs": [
            { "visible": false, "targets": groupColumn }
        ],
        "order": [[ groupColumn, 'asc' ]],
        "displayLength": 25,
        "drawCallback": function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;
 
            api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
                if ( last !== group ) {
                    $(rows).eq( i ).before(
                        '<tr class="table-primary"><td colspan="100%"><b>'+group+'</b></td></tr>'
                    );
 
                    last = group;
                }
            } );
        },
        ordering: false,
        //"processing": true,
        "ajax": "datatable-panelTareas.ajax.php?detalles=true&tipo_tarea_id=" + tipo_tarea_id,
        "language": {

            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }

        }
    });

    setInterval(function () {
        /*   table.ajax.reload();
          table_avances.ajax.reload();
          table_vencidas.ajax.reload();
          table_actuales.ajax.reload(); */

        table.ajax.url('datatable-panelTareas.ajax.php?detalles=true&tipo_tarea_id=' + tipo_tarea_id).load();
        table_avances.ajax.url('datatable-panelTareas.ajax.php?detalles_responsables=true&tipo_tarea_id=' + tipo_tarea_id).load();
        table_vencidas.ajax.url('datatable-panelTareas.ajax.php?tareas_vencidas=true&tipo_tarea_id=' + tipo_tarea_id).load();
        table_finalizadas.ajax.url('datatable-panelTareas.ajax.php?tareas_finalizadas=true&tipo_tarea_id=' + tipo_tarea_id).load();
        table_pendientes_socializar.ajax.url('datatable-panelTareas.ajax.php?tareas_pendiente_socializar=true&tipo_tarea_id=' + tipo_tarea_id).load();
        table_actuales.ajax.url('datatable-panelTareas.ajax.php?tareas_actuales=true&tipo_tarea_id=' + tipo_tarea_id).load(); 

    }, 90000);

});

function openModalCierre(obj) {

    row = obj.parentNode.parentNode;

    console.log('row : ', row);

    $('#exampleModalCierre').modal('show');

}

function detalles() {

    $('#detalles tbody tr').remove();
    var QueryString = "ACTIONCONTROLER=getActividades";

    $.ajax({
        url: "PanelTareasClass.php",
        data: QueryString,
        success: function (resp) {

            var data = $.parseJSON(resp);

            if (data != null) {

                for (var i = 0; i < data.length; i++) {

                    var actividad_programada_id = data[i]['actividad_programada_id'];
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
                        '<td><input type="hidden" id="actividad_id" value="' + actividad_programada_id + '">' + cliente + '</td>' +
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

function cargaNewPanel(radio) {

    tipo_tarea_id = radio.id;

    Swal.fire({
        title: "Cargando panel ..."
    });

    Swal.showLoading();

    table.ajax.url('datatable-panelTareas.ajax.php?detalles=true&tipo_tarea_id=' + tipo_tarea_id).load();
    table_avances.ajax.url('datatable-panelTareas.ajax.php?detalles_responsables=true&tipo_tarea_id=' + tipo_tarea_id).load();
    table_vencidas.ajax.url('datatable-panelTareas.ajax.php?tareas_vencidas=true&tipo_tarea_id=' + tipo_tarea_id).load();
    table_finalizadas.ajax.url('datatable-panelTareas.ajax.php?tareas_finalizadas=true&tipo_tarea_id=' + tipo_tarea_id).load();
    table_pendientes_socializar.ajax.url('datatable-panelTareas.ajax.php?tareas_pendiente_socializar=true&tipo_tarea_id=' + tipo_tarea_id).load();
    table_actuales.ajax.url('datatable-panelTareas.ajax.php?tareas_actuales=true&tipo_tarea_id=' + tipo_tarea_id).load();

    setTimeout(function () {
        Swal.close();
    }, 2000);

}

function guardarObservacion() {

    var actividad_id = $("#actividad_id_modal").val();
    var observacion = $("#observacion").val();

    if (observacion != '') {

        var QueryString = "ACTIONCONTROLER=guardarObservacion&actividad_id=" + actividad_id + "&observacion=" + observacion;

        $.ajax({
            url: "PanelTareasClass.php",
            data: QueryString,
            success: function (resp) {

                if (resp > 0) {

                    Swal.fire('¡Se guardo exitosamente la observación!');
                    $("#observacion").val('');

                } else {

                    Swal.fire({
                        icon: 'error',
                        title: 'Atención',
                        html: resp,
                    })

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
    var observacion_cierre = tinymce.get('observacion_cierre').getContent();
    var commit = $("#commit").val();
    var justificacion_git = $("#justificacion_git").val();

    if (fecha_cierre_real != '') {

        var QueryString = "ACTIONCONTROLER=guardarCierre&actividad_id=" + actividad_id + "&observacion_cierre=" + observacion_cierre + "&fecha_cierre_real=" + fecha_cierre_real + "&commit=" + commit + "&justificacion_git=" + justificacion_git;

        console.log('QueryString : ', QueryString);

        $.ajax({
            url: "PanelTareasClass.php",
            data: QueryString,
            type: 'POST',
            beforeSend: function () {

                Swal.fire({
                    title: "Cargando cierre.."
                });

                Swal.showLoading()

            },
            success: function (resp) {

                if (resp == 'true') {

                    Swal.fire('¡Se cerró exitosamente la tarea!');
                    $("#fecha_cierre,#commit,#justificacion_git").val('');
                    tinymce.get('observacion_cierre').setContent('');

                    var table = $('#detalles').DataTable();

                    table.row(row).remove().draw();


                } else {

                    Swal.fire({
                        icon: 'error',
                        title: 'Atención',
                        html: resp,
                    })
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

function Finalizar(actividad_id){

    var QueryString = "ACTIONCONTROLER=finalizar&actividad_id=" + actividad_id;

    $.ajax({
        url: "PanelTareasClass.php",
        data: QueryString,
        beforeSend: function () {

            Swal.fire({
                title: "Cargando cierre.."
            });

            Swal.showLoading()

        },
        success: function (resp) {

            if (resp == 'true') {

                Swal.fire('¡Tarea finalizada con exito !');

                table_pendientes_socializar.ajax.url('datatable-panelTareas.ajax.php?tareas_pendiente_socializar=true&tipo_tarea_id=' + tipo_tarea_id).load();

                table_finalizadas.ajax.url('datatable-panelTareas.ajax.php?tareas_finalizadas=true&tipo_tarea_id=' + tipo_tarea_id).load();

            } else {

                Swal.fire({
                    icon: 'error',
                    title: 'Atención',
                    html: resp,
                })
            }

        }

    });

}

function pendienteSocializar() {

    var actividad_id = $("#actividad_id_modal_cierre").val();
    var fecha_cierre_real = $("#fecha_cierre").val();
    var observacion_cierre = $("#observacion_cierre").val();
    var commit = $("#commit").val();
    var justificacion_git = $("#justificacion_git").val();

    if (fecha_cierre_real != '') {

        var QueryString = "ACTIONCONTROLER=pendienteSocializar&actividad_id=" + actividad_id + "&observacion_cierre=" + observacion_cierre + "&fecha_cierre_real=" + fecha_cierre_real + "&commit=" + commit + "&justificacion_git=" + justificacion_git;

        $.ajax({
            url: "PanelTareasClass.php",
            data: QueryString,
            beforeSend: function () {

                Swal.fire({
                    title: "Cargando cierre.."
                });

                Swal.showLoading()

            },
            success: function (resp) {

                if (resp == 'true') {

                    Swal.fire('¡Se cambio el estado de la tarea [Pendiente por socializar]!');
                    $("#observacion_cierre,#fecha_cierre,#commit,#justificacion_git").val('');

                    var table = $('#detalles').DataTable();

                    table.row(row).remove().draw();

                    table_pendientes_socializar.ajax.url('datatable-panelTareas.ajax.php?tareas_pendiente_socializar=true&tipo_tarea_id=' + tipo_tarea_id).load();

                } else {

                    Swal.fire({
                        icon: 'error',
                        title: 'Atención',
                        html: resp,
                    })
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