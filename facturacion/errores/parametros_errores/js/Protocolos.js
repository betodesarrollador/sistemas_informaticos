// JavaScript Document
var table;
$(document).ready(function () {

  $.ajax({
 
    url: "datatable-protocolos.ajax.php",
    
    success:function(respuesta){
        
        console.log("respuesta table : ", respuesta);

    }

}) 

  table = $('#table_protolocos').DataTable({

    "ajax": "datatable-protocolos.ajax.php",
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

});

function save(obj) {

  var row = obj.parentNode.parentNode;

  var protocolo_id = $(row).find("#protocolo_id").val();
  var descripcion  = $(row).find("#descripcion").val();
  var nombre       = $(row).find("#nombre").val();

  var data = new FormData();

  jQuery.each($(row).find("#video")[0].files, function (i, file) {

    data.append('video', file);

  });

  jQuery.each($(row).find("#archivo")[0].files, function (i, file) {

    data.append('archivo', file);

  });

  data.append('protocolo_id', protocolo_id);
  data.append('descripcion', descripcion);
  data.append('nombre', nombre);

  console.log('protocolo_id : ', protocolo_id);

  if (protocolo_id > 0) {

    data.append('ACTIONCONTROLER', 'onclickUpdate');

    console.log('data:', data);

    $.ajax({

      url: "ProtocolosClass.php?rand=" + Math.random(),
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      type: 'POST',
      success: function (resp) {

        if (resp == 'true') {

          var table = $('#table_protolocos').DataTable();

          table.ajax.reload();

          Swal.fire('¡Actualizacion exitosa!');

        } else {

          Swal.fire({
            icon: 'error',
            title: 'Error',
            html: resp,
          })

        }
      }

    });

  } else {

    if (descripcion != '') {

      $(row).find("#descripcion").css("boxShadow", "none");

      data.append('ACTIONCONTROLER', 'onclickSave');

      console.log('data:', data);

      $.ajax({

        url: "ProtocolosClass.php?rand=" + Math.random(),
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function (resp) {

          console.log('resp : ', resp);

          if (resp > 0) {

            var table = $('#table_protolocos').DataTable();

            table.ajax.reload()

            Swal.fire('Carga exitosa!');

          } else {

            Swal.fire({
              icon: 'error',
              title: 'Error',
              html: resp,
            })

          }
        }

      });

    } else {

      $(row).find("#descripcion").css("boxShadow", "0 0 5px 1px red");

    }



  }

}


