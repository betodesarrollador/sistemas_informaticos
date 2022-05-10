// JavaScript Document
$(document).ready(function () {
  $("#divAnulacion").css("display", "none");
  setWidthFrameReporte();

  $("#hasta").change(function () {
    var hasta = $("#hasta").val();
    var desde = $("#desde").val();

    if (hasta.substr(0, 4) != desde.substr(0, 4)) {
      $("#fecha_doc").val("");
      $("#hasta").val("");
      alertJquery(
        "Debe escoger una fecha dentro del mismo año<br> de la fecha inicial",
        "Cierre"
      );
    } else {
      $("#fecha_doc").val($("#hasta").val());
    }
  });

  $("#opciones_tercero").change(function () {
    if (this.value == "T") {
      $("#tercero_hidden").removeClass("obligatorio");
      $("#tercero").removeClass("requerido");
      $("#tercero").attr("disabled", "true");
      $("#tercero,#tercero_hidden").val("");
    } else if (this.value == "U") {
      $("#tercero_hidden").addClass("obligatorio");
      $("#tercero").attr("disabled", "");
    }
  });

  $("#opciones_centro").change(function () {
    if (this.value == "T") {
      $("#centro_de_costo_id").removeClass("obligatorio");
      $("#centro_de_costo").removeClass("requerido");
      $("#centro_de_costo").attr("disabled", "true");
      $("#centro_de_costo,#centro_de_costo_id").val("");
    } else if (this.value == "U") {
      $("#centro_de_costo_id").addClass("obligatorio");
      $("#centro_de_costo").attr("disabled", "");
    }
  });

  $("#export").click(function () {
    var formulario = this.form;

    if (ValidaRequeridos(formulario)) {
      var QueryString =
        "CierresClass.php?ACTIONCONTROLER=onclickExport&" +
        FormSerialize(formulario);
      $("#frameReporte").attr("src", QueryString);
    }
  });
});

function setWidthFrameReporte() {
  $("#frameReporte").css("height", $(parent.document.body).height() - 110);
}

function getReportParams() {
  $("#reporte").change(function () {
    if ($.trim(this.value) != "NULL") {
      getEmpresas(this.value);
    }
  });
}

function setDataFormWithResponse() {
  var encabezado_registro_id = $("#encabezado_registro_id").val();
  var QueryString =
    "CierresClass.php?ACTIONCONTROLER=Preimpresion&encabezado_registro_id=" +
    encabezado_registro_id;
  $("#frameReporte").attr("src", QueryString);

  if ($("#generar")) $("#generar").attr("disabled", "true");
  if ($("#imprimir")) $("#imprimir").attr("disabled", "");
  if ($("#anular")) $("#anular").attr("disabled", "");
  if ($("#limpiar")) $("#limpiar").attr("disabled", "");
}
function getEmpresas(reporte) {
  var QueryString = "ACTIONCONTROLER=getEmpresas&reporte=" + reporte;

  $.ajax({
    url: "CierresClass.php",
    data: QueryString,
    beforeSend: function () {},
    success: function (response) {
      if (reporte == "E") {
        $("#empresaReporte").html(response);
        $("#oficinaReporte").html("");
        $("#centroCostoReporte").html("");
      } else if (reporte == "O") {
        $("#empresaReporte").html(response);
        $("#oficinaReporte").html(
          "<select name='oficina_id' id='oficina_id' disabled><option value='NULL'>( Seleccione )</option></select>"
        );
        $("#centroCostoReporte").html("");
      } else if (reporte == "C") {
        $("#empresaReporte").html(response);
        $("#oficinaReporte").html("");
        $("#centroCostoReporte").html(
          "<select name='centro_de_costo' id='centro_de_costo' disabled><option value='NULL'>( Seleccione )</option></select>"
        );
      }
    },
  });
}

function onclickGenerarAuxiliar(formulario) {
  if (ValidaRequeridos(formulario)) {
    var QueryString =
      "CierresClass.php?ACTIONCONTROLER=onclickGenerarAuxiliar&" +
      FormSerialize(formulario);
    $("#frameReporte").attr("src", QueryString);
    showDivLoading();
    $("#frameReporte").load(function (response) {
      removeDivLoading();

      if ($("#imprimir")) $("#imprimir").attr("disabled", "");
      if ($("#borrar")) $("#borrar").attr("disabled", "");
      if ($("#anular")) $("#anular").attr("disabled", "");
      if ($("#limpiar")) $("#limpiar").attr("disabled", "");

      var encabezado_registro_id = $("#frameReporte")
        .contents()
        .find("#encabezado_registro_id")
        .val();
      if (encabezado_registro_id > 0) {
        if ($("#generar")) $("#generar").attr("disabled", "true");
      } else {
        if ($("#generar")) $("#generar").attr("disabled", "");
      }
      console.log(encabezado_registro_id);
      $("#encabezado_registro_id").val(encabezado_registro_id);
    });
  }
}

function setCuentaHasta(Id, text, obj) {
  $("#cuenta_hasta").val(text);
  $("#cuenta_hasta_hidden").val(Id);
}

function MovimientosContablesOnReset() {
  clearFind();

  $("#frameReporte").attr("src", "../../../framework/tpl/blank.html");

  if ($("#generar")) $("#generar").attr("disabled", "");
  if ($("#imprimir")) $("#imprimir").attr("disabled", "true");
  if ($("#borrar")) $("#borrar").attr("disabled", "true");
  if ($("#anular")) $("#anular").attr("disabled", "true");
  if ($("#limpiar")) $("#limpiar").attr("disabled", "");
}

/************************************************************* */
function MovimientosContablesOnDelete(formulario, resp) {
  Reset(document.getElementById("MovimientosContablesForm"));
  MovimientosContablesOnReset();

  alertJquery(resp);
}

/******* onclickCancellation ***** */
function onclickCancellation(formulario) {
  if ($("#divAnulacion").is(":visible")) {
    var causal_anulacion_id = $("#causal_anulacion_id").val();
    var observaciones = $("#observaciones").val();

    if (ValidaRequeridos(formulario)) {
      var QueryString =
        "ACTIONCONTROLER=onclickCancellation&" +
        FormSerialize(formulario) +
        "&encabezado_registro_id=" +
        $("#encabezado_registro_id").val();

      $.ajax({
        url: "CierresClass.php",
        data: QueryString,
        beforeSend: function () {
          showDivLoading();
        },
        success: function (response) {
          if ($.trim(response) == "true") {
            alertJquery("Cierre Contable Anulado", "Anulado Exitosamente"); // alerta
            setDataFormWithResponse();
          } else {
            alertJquery(response, "Inconsistencia Anulando"); // alerta
          }

          removeDivLoading();
          $("#divAnulacion").dialog("close");
        },
      });
    }
  } else {
    var encabezado_registro_id = $("#encabezado_registro_id").val();
    var estado = $("#estado").val();

    if (parseInt(encabezado_registro_id) > 0) {
      var QueryString =
        "ACTIONCONTROLER=getEstadoEncabezadoRegistro&encabezado_registro_id=" +
        encabezado_registro_id;

      $.ajax({
        url: "CierresClass.php",
        data: QueryString,
        beforeSend: function () {
          showDivLoading();
        },
        success: function (response) {
          var estado = response;

          if ($.trim(estado) == "C") {
            $("#divAnulacion").dialog({
              title: "Anulacion Registro Contable",
              width: 450,
              height: 280,
              closeOnEscape: true,
            });
          } else {
            alertJquery(
              "Solo se permite anular movimientos en estado : <b>CONTABILIZADO</b>",
              "Anulacion" // alert
            );
          }

          removeDivLoading();
        },
      });
    } else {
      alertJquery(
        "Debe Seleccionar primero un movimiento contable",
        "Anulacion" // alert
      );
    }
  }
}

function beforePrint(formulario) {
  if (ValidaRequeridos(formulario)) {
    return true;
  } else {
    return false;
  }
}
