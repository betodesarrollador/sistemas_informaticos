// JavaScript Document

$(document).ready(function () {

  $('#detalles').DataTable({
    "lengthMenu": [[-1, 25, 50], ["Todos", 10, 25, 50]],
    "language": {

      "sProcessing": "Procesando...",
      "sZeroRecords": "No se encontraron resultados",
      "sEmptyTable": "Ningún dato disponible en esta tabla",
      "sInfo": "Mostrando registros del Inicio al Final de un total de _TOTAL_",
      "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0",
      "sInfoFiltered": "(filtrado de un total de MAX registros)",
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

  $('#query').keydown(function (e) {


    if (e.ctrlKey && e.keyCode == 13) {//ctrl + enter



      setTimeout(function () {



        ejecutarQuery();



      }, 200);

    }

  });



});



function check_all(obj) {



  $("input[name=procesar]").each(function () {



    var fila = this;



    if (obj.checked) {



      $(this).attr("checked", "true");



    } else {



      $(this).removeAttr("checked");



    }



  });



}





function limpiar() {

  $("#query").val('');

}







function ejecutarQuery() {

  var query = $("#query").val();

  var arrayDB = [];

  var bandera = false;

  $("input[name=procesar]").each(function () {

    if (this.checked) {

      bandera = true;
      var database = this.value;
      arrayDB.push(database);

    }

  });


  var QueryString = "ACTIONCONTROLER=ejecutarQuery&query=" + encodeURIComponent(query) + "&databases=" + arrayDB;

  if (query != "" && bandera) {

    Swal.fire({
      html: "¿ Esta seguro que desea realizar este cambio en las bases de datos : <b>" + arrayDB + "</b> ?",
      showDenyButton: true,
      showCancelButton: true,
      confirmButtonText: 'Ejecutar',
      denyButtonText: `Cancelar`,
    }).then((result) => {
      
      if (result.value) {

        $.ajax({

          url: "MySqlClass.php?rand=" + Math.random(),

          type: "POST",

          data: QueryString,

          beforeSend: function () {

            Swal.fire({
              title: "Cargando ..."
            });

            Swal.showLoading()
          },

          success: function (resp) {

            console.log('resp : ', resp);

            Swal.close();

            try {

              Swal.fire({
                icon: 'success',
                title: 'Respuesta',
                html: resp
              })

              //alertJquery("<div style='overflow:auto; max-height:500px;'>" + resp + "</div>", "Respuesta");

            } catch (e) {

              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                html: e
              })


            }

          }

        });
      } 
    })


  } else {

    Swal.fire({
      icon: 'warning',
      html: "Por favor Digite la accion a ejecutar junto con las bases de datos a afectar !!"
    })

  }


}