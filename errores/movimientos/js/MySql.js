// JavaScript Document

$(document).ready(function () {

  $('#detalles').DataTable({
    "lengthMenu": [[-1, 10, 25], ["Todos", 10, 25]],
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

function clearInputsModal(modal,query){

  $("#"+modal).find("input").each(function(){

    $(this).val('');

  })

  $("#query").val(query).focus();

}


function setCamposCrearLinea(){

  var marca        = $.trim($("#form_crear_linea").find("#marca").val());
  var linea        = $.trim($("#form_crear_linea").find("#linea").val());
  var codigo_linea = $.trim($("#form_crear_linea").find("#codigo_linea").val());
  
  var query = "INSERT INTO linea(marca_id, linea, codigo_marca, codigo_linea) VALUES ((SELECT marca_id FROM marca WHERE marca LIKE '"+marca+"'),'"+linea+"',(SELECT codigo FROM marca WHERE marca LIKE '"+marca+"'),'"+codigo_linea+"');";

  clearInputsModal('form_crear_linea',query);

}

function setCamposEliminarNc(){

  var consecutivo = $("#form_eliminar_nc").find("#consecutivo").val();

  var encabezado_registro_id = "(SELECT encabezado_registro_id FROM encabezado_de_registro WHERE consecutivo = "+consecutivo+" AND tipo_documento_id = 18)";
  
  var query = "DELETE FROM item_abono WHERE abono_factura_id = (SELECT abono_factura_id FROM abono_factura WHERE encabezado_registro_id = "+encabezado_registro_id+"); \n DELETE FROM relacion_abono WHERE abono_factura_id = (SELECT abono_factura_id FROM abono_factura WHERE encabezado_registro_id = "+encabezado_registro_id+");\nDELETE FROM abono_factura WHERE encabezado_registro_id = "+encabezado_registro_id+";\nDELETE FROM imputacion_contable WHERE encabezado_registro_id = "+encabezado_registro_id+";\nDELETE FROM encabezado_de_registro WHERE  consecutivo = 23 AND tipo_documento_id = 18;";

  clearInputsModal('form_eliminar_nc',query);

}

function setCamposDeleteTrafico(){

  var trafico_id = $("#form_borrar_trafico").find("#trafico_id").val();
  
  var query = "DELETE FROM detalle_seguimiento WHERE trafico_id IN ("+trafico_id+");\nDELETE FROM trafico WHERE trafico_id IN ("+trafico_id+");";

  clearInputsModal('form_borrar_trafico',query);

}

function setCamposDeleteFactura(){

  var factura_id = $("#form_delete_factura").find("#factura_id").val();
  
  var query = "UPDATE factura SET encabezado_registro_id = NULL WHERE factura_id = "+factura_id+";\nDELETE FROM imputacion_contable WHERE encabezado_registro_id = (SELECT encabezado_registro_id FROM factura WHERE factura_id = "+factura_id+" );\nDELETE FROM encabezado_de_registro WHERE encabezado_registro_id = (SELECT encabezado_registro_id FROM factura WHERE factura_id = "+factura_id+" );\nUPDATE remesa SET estado = 'LQ' WHERE remesa_id IN (SELECT remesa_id FROM detalle_factura WHERE factura_id = "+factura_id+" );\nDELETE FROM detalle_remesa_puc WHERE remesa_id IN (SELECT remesa_id FROM detalle_factura WHERE factura_id = "+factura_id+" );\nDELETE FROM detalle_factura_puc WHERE factura_id = "+factura_id+";\nDELETE FROM detalle_factura WHERE factura_id = "+factura_id+";\nDELETE FROM factura WHERE factura_id = "+factura_id+";";

  clearInputsModal('form_delete_factura',query);

}

function setCamposReclasificarCuentas(){

  var new_codigo_puc = $("#form_reclasificar_cuentas").find("#new_codigo_puc").val();
  var old_codigo_puc = $("#form_reclasificar_cuentas").find("#old_codigo_puc").val();
  var fecha_desde    = $("#form_reclasificar_cuentas").find("#fecha_desde").val();
  var fecha_hasta    = $("#form_reclasificar_cuentas").find("#fecha_hasta").val();
  
  var query = "UPDATE imputacion_contable i, encabezado_de_registro e SET i.puc_id = (SELECT p.puc_id FROM puc p WHERE p.codigo_puc LIKE '"+new_codigo_puc+"' ) WHERE e.encabezado_registro_id=i.encabezado_registro_id AND e.fecha >= '"+fecha_desde+"' AND e.fecha <= '"+fecha_hasta+"' AND i.puc_id = (SELECT p.puc_id FROM puc p WHERE p.codigo_puc LIKE '"+old_codigo_puc+"' );";

  clearInputsModal('form_reclasificar_cuentas',query);

}

function setCamposTerceroImputacion(){

  var numero_identificacion = $("#form_actualizar_tercero").find("#numero_identificacion").val();
  var consecutivo           = $("#form_actualizar_tercero").find("#consecutivo").val();
  var nombre                = $("#form_actualizar_tercero").find("#nombre").val();
  var tercero_id            = "(SELECT t.tercero_id FROM tercero t WHERE t.numero_identificacion = '"+numero_identificacion+"')";
  var tipo_documento_id     = "(SELECT tipo_documento_id  FROM tipo_de_documento WHERE nombre LIKE '"+nombre+"')";
  
  var query = "UPDATE imputacion_contable i, encabezado_de_registro e  SET i.tercero_id = "+tercero_id+",i.numero_identificacion = '"+numero_identificacion+"', e.tercero_id = "+tercero_id+" WHERE i.encabezado_registro_id = e.encabezado_registro_id AND e.consecutivo = "+consecutivo+" AND e.tipo_documento_id = "+tipo_documento_id+";";

  clearInputsModal('form_actualizar_tercero',query);

}

function setCamposFechaRemesa(){

  var fecha_remesa  = $("#form_actualizar_fecha").find("#fecha_remesa").val();
  var numero_remesa = $("#form_actualizar_fecha").find("#numero_remesa").val();
  
  var query = "UPDATE remesa SET fecha_remesa = '"+fecha_remesa+"' WHERE numero_remesa = "+numero_remesa+";";

  clearInputsModal('form_actualizar_fecha',query);

}

function setCamposDescuadre(){

  var query = "";

  var array = $("#form_descuadres").find("#encabezado_registro_id").val().split(',');

  for (var i = 0; i < array.length; i++) {

    var encabezado_registro_id = array[i];

    query += "\n\nUPDATE imputacion_contable i, (SELECT ABS(SUM(credito)-SUM(debito)) AS diferencia_abs FROM imputacion_contable WHERE encabezado_registro_id = "+encabezado_registro_id+") AS d1,(SELECT SUM(credito)-SUM(debito) AS diferencia FROM imputacion_contable WHERE encabezado_registro_id = "+encabezado_registro_id+") AS d2,(SELECT imputacion_contable_id FROM imputacion_contable WHERE encabezado_registro_id = "+encabezado_registro_id+" LIMIT 1) AS l SET i.credito = IF((d2.diferencia > 0 AND d1.diferencia_abs = 1), i.credito -1 , i.credito),i.debito      = IF((d2.diferencia < 0 AND d1.diferencia_abs = 1), i.debito-1 , i.debito) WHERE i.encabezado_registro_id = "+encabezado_registro_id+" AND i.imputacion_contable_id = l.imputacion_contable_id;";

  }

  clearInputsModal('form_descuadres',query);

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

function manejoEmpresa(cliente_id,db,estado_empresa,btn) {
  var QueryString         = "ACTIONCONTROLER=manejoEmpresa&cliente_id=" + cliente_id + "&estado_empresa=" + estado_empresa;
  var mensajeConfirmacion = "";
  var colorBtn            = "";

  if(estado_empresa == "A") {
    mensajeConfirmacion = `¿ Esta seguro que desea suspender la empresa <b>${db}</b> ?`;
  } else {
    mensajeConfirmacion = `¿ Esta seguro que desea habilitar la empresa <b>${db}</b> ?`;
  }

  Swal.fire({
    html: mensajeConfirmacion,
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
            }).then(() => {
              location.reload();
            });



            // if(estado_empresa == "A") {
            //   $(`#${btn}`).removeClass("btn-danger");
            //   $(`#${btn}`).addClass("btn-info");
            //   $(`#${btn}`).html("Habilitar");
            // } else {
            //   $(`#${btn}`).removeClass("btn-info");
            //   $(`#${btn}`).addClass("btn-danger");
            //   $(`#${btn}`).html("Suspender");
            // }


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
  });
}