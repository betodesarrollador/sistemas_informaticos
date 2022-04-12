// JavaScript Document
function LlenarFormPlanCuentas(puc_id, text, objTxt) {
  var params = new Array({ campos: "puc_id", valores: puc_id });
  var formulario = document.forms[0];
  var url = "PlanCuentasClass.php";

  FindRow(params, formulario, url, null, function (response) {
    $("#movimiento").trigger("change");

    if ($("#guardar")) $("#guardar").attr("disabled","true");
    if ($("#actualizar")) $("#actualizar").removeAttr("disabled");;
    if ($("#borrar")) $("#borrar").removeAttr("disabled");
    if ($("#limpiar")) $("#limpiar").removeAttr("disabled");
  });
}
function PlanCuentasOnSaveUpdate(formulario, response) {
  getPlanCuentasTree($("#empresa_id").val());

  Reset(formulario);
  clearFind();
  setFocusFirstFieldForm(formulario);
  $("#refresh_QUERYGRID_PlanCuentas").click();
  if ($("#guardar")) $("#guardar").attr("disabled", "");
  if ($("#actualizar")) $("#actualizar").attr("disabled", "true");
  if ($("#borrar")) $("#borrar").attr("disabled", "true");
  if ($("#limpiar")) $("#limpiar").attr("disabled", "");
  Reset(formulario);
  PlanCuentasOnClear();
  alertJquery(response, "PlanCuentas");
}
function PlanCuentasOnDelete(formulario, response) {
  getPlanCuentasTree($("#empresa_id").val());
  Reset(formulario);
  clearFind();
  setFocusFirstFieldForm(formulario);
  $("#refresh_QUERYGRID_terceros").click();

  if ($("#guardar")) $("#guardar").attr("disabled", "");
  if ($("#actualizar")) $("#actualizar").attr("disabled", "true");
  if ($("#borrar")) $("#borrar").attr("disabled", "true");
  if ($("#limpiar")) $("#limpiar").attr("disabled", "");
  Reset(formulario);
  PlanCuentasOnClear();
  alertJquery(response, "PlanCuentas");
}

function PlanCuentasOnPrint() {
  var QueryString = "PlanCuentasClass.php?ACTIONCONTROLER=PlanCuentasOnPrint";
  document.location.href = QueryString;
}
function PlanCuentasOnClear(formulario) {
  $("#naturaleza option").each(function () {
    if (this.value == "D") this.selected = true;
  });

  $("#requiere_tercero option").each(function () {
    if (this.value == 0) this.selected = true;
  });

  $("#maneja_forma_pago option").each(function () {
    if (this.value == 0) this.selected = true;
  });

  $("#movimiento option").each(function () {
    if (this.value == 0) this.selected = true;
  });

  $("#movimiento").val("0");

  setFocusFirstFieldForm(formulario);
  clearFind();

  if ($("#guardar")) $("#guardar").removeAttr("disabled");
  if ($("#actualizar")) $("#actualizar").attr("disabled","true");
  if ($("#borrar")) $("#borrar").attr("disabled", "true");
  if ($("#limpiar")) $("#limpiar").removeAttr("disabled");
}
function getPlanCuentasTree(empresa_id) {
  if (empresa_id != "NULL") {
    $.ajax({
      url: "PlanCuentasClass.php",
      data: "ACTIONCONTROLER=getPlanCuentasTree&empresa_id=" + empresa_id,
      beforeSend: function () {
        $("#PlanCuentasTree").html(
          "<img src='../../../framework/media/images/desktop/blue-loading.gif' />"
        );
      },
      success: function (response) {
        $("#PlanCuentasTree").replaceWith(response);
        $("a[name=linkPlanCuentasTree]").click(function () {
          getPlanCuentasTree(this.id);
        });
        $("#print").click(function () {
          getPlanCuentasPrint();
        });
      },
    });
  }
}
function getPlanCuentasPrint() {
  var url = "PlanCuentasClass.php?ACTIONCONTROLER=getPlanCuentasPrint";
  popPup(url, "Plan de Cuentas");
}

function onclickValidateRow() {
  $("#codigo_puc").blur(function () {
    var codigo_puc = this.value;
    var QueryString =
      "ACTIONCONTROLER=onclickValidateRow&codigo_puc=" + codigo_puc;
    var formulario = this.form;
    var formulario = document.getElementById("PlanCuentasForm");

    $.ajax({
      url: "PlanCuentasClass.php?rand=" + Math.random(),
      data: QueryString,
      beforeSend: function () {
        showDivLoading();
      },
      success: function (resp) {
        try {
          var puc_id = parseInt(resp);

          if (isNaN(puc_id)) {
            alertJquery(resp, "Error :");
          } else {
            if (puc_id > 0) {
              var QueryString =
                "ACTIONCONTROLER=getDataCuentaPuc&puc_id=" + puc_id;

              $.ajax({
                url: "PlanCuentasClass.php?rand=" + Math.random(),
                data: QueryString,
                beforeSend: function () {
                  showDivLoading();
                },
                success: function (resp) {
                  setFormWithJSON(formulario, resp, false, function () {
                    removeDivLoading();
                  });
                },
              });
            }
          }
        } catch (e) {
          alertJquery(resp, "Error :");
        }
        removeDivLoading();
      },
    });
  });
}

// Validar nivel 2, 3, 4 y 5 campo superior
function sugerirNivelSuperior(nivel) {
  var codigo_puc = $("#codigo_puc").val();
  if (nivel == 2) {
    var res = codigo_puc.substring(0, 1);
  } else if (nivel == 3) {
    var res = codigo_puc.substring(0, 2);
  } else if (nivel == 4) {
    var res = codigo_puc.substring(0, 4);
  } else if (nivel == 5) {
    var res = codigo_puc.substring(0, 6);
  } else {
    var res = codigo_puc;
  }

  var QueryString =
    "ACTIONCONTROLER=sugerirNivelSuperior&codigo_puc=" +
    res +
    "&nivel=" +
    nivel; // sugerirNivelSuperior planCuentasClass.php

  var formulario = document.getElementById("PlanCuentasForm"); // Ver el resultado en campo superior

  $.ajax({
    url: "PlanCuentasClass.php?rand=" + Math.random(),
    data: QueryString,
    beforeSend: function () {
      showDivLoading();
    },
    success: function (resp) {
      try {
        var puc_id = parseInt(resp);
        ////////////////////////////////////////////////////////////////
        if (isNaN(puc_id) || puc_id == "") {
          if ($("#guardar")) $("#guardar").attr("disabled", "true");

          Swal.fire({
            type: "warning",
            title: "Advertencia!",
            text: "El nivel superior de esta cuenta no existe!",
            /*showConfirmButton:false,
            /*timer:2000*/
            animation: false,
            customClass: {
              popup: "animated bounceIn",
            },
          });

          //$("#puc_puc").val("El nivel Superior de esta Cuenta no Existe!");
        } else {
          if (puc_id > 0) {
            var QueryString = "ACTIONCONTROLER=getPucSuperior&puc_id=" + puc_id;

            $.ajax({
              url: "PlanCuentasClass.php?rand=" + Math.random(),
              data: QueryString,
              beforeSend: function () {
                showDivLoading();
              },
              success: function (resp) {
                var puc = $.parseJSON(resp);
               // console.log(puc);
                if ($("#guardar")) $("#guardar").removeAttr("disabled");
                $("#puc_puc").val(puc[0]["puc_puc"]);
                $("#puc_puc_id").val(puc[0]["puc_puc_id"]);

                removeDivLoading();
              },
            });
          }
        }
      } catch (e) {
        alertJquery(resp, "Error :");
      }
      removeDivLoading();
    },
  });
}

function CuentaSuperior() {
  var codigo_puc = $("#codigo_puc").val();
  var QueryString = "ACTIONCONTROLER=validasuperior&codigo_puc=" + codigo_puc;
  var formulario = this.form;
  //var formulario = document.getElementById("PlanCuentasForm");

  $.ajax({
    url: "PlanCuentasClass.php?rand=" + Math.random(),
    data: QueryString,
    beforeSend: function () {
      showDivLoading();
    },
    success: function (resp) {
      try {
        var nivel = parseInt(resp);

        if (nivel > 1) {
          alertJquery("s");
          $("#puc_puc").addClass("obligatorio");
        }
      } catch (e) {
        alertJquery(resp, "Error :");
      }

      removeDivLoading();
    },
  });
}

function cargardiv() {
  var puc_id = $("#puc_id").val();
  var QueryString = "ACTIONCONTROLER=validarNivel&puc_id=" + puc_id;

  $.ajax({
    url: "PlanCuentasClass.php?rand=" + Math.random(),
    data: QueryString,
    beforeSend: function () {
      showDivLoading();
    },
    success: function (resp) {
      var json = $.parseJSON(resp);

      if (json != "") {
        var nivel = json[0]["nivel"];

        if (nivel == 5) {
          if (parseInt(puc_id) > 0) {
            $("#iframeSolicitud").attr(
              "src",
              "DetallesParametrosClass.php?puc_id=" +
                puc_id +
                "&rand=" +
                Math.random()
            );
            $("#divSolicitudFormatos").dialog({
              title: "Formato",
              width: 950,
              height: 395,
              closeOnEscape: true,
              show: "scale",
              hide: "scale",
            });
          } else {
            alertJquery("Por Favor Seleccione una cuenta", "Formato");
          }
        } else {
          alertJquery("Por favor seleccione una cuenta de nivel 5");
        }
      }

      removeDivLoading();
    },
  });
}

function closeDialog() {
  $("#divSolicitudFormatos").dialog("close");
}

/* Desactivar select naturaleza segun su codigo de inicio*/
function validarNaturaleza() {
  var codigo_puc = $("#codigo_puc").val();
  if (codigo_puc.startsWith(1)) {
    $("#naturaleza").attr("disabled", "true");
    $("#naturaleza").val("D");
  } else if (codigo_puc.startsWith(5)) {
    $("#naturaleza").attr("disabled", "true");
    $("#naturaleza").val("D");
  } else if (codigo_puc.startsWith(6)) {
    $("#naturaleza").attr("disabled", "true");
    $("#naturaleza").val("D");
  } else if (codigo_puc.startsWith(7)) {
    $("#naturaleza").attr("disabled", "true");
    $("#naturaleza").val("D");
  } else if (codigo_puc.startsWith(2)) {
    $("#naturaleza").attr("disabled", "true");
    $("#naturaleza").val("C");
  } else if (codigo_puc.startsWith(3)) {
    $("#naturaleza").attr("disabled", "true");
    $("#naturaleza").val("C");
  } else if (codigo_puc.startsWith(4)) {
    $("#naturaleza").attr("disabled", "true");
    $("#naturaleza").val("C");
  } else {
    console.log("Error en la selección");
  }
}

$(document).ready(function () {
  
  /*$("#empresa_id").change(function () {
    $("#puc_puc,#puc_puc_id").val("");
    getPlanCuentasTree(this.value);
  });*/

  $("#puc_puc").keyup(function () {
    if (!$.trim(this.value).length > 0) {
      $("#puc_puc_id").val("");
    }
  });

  $("#codigo_puc").keyup(function () {
    CuentaSuperior();

    if ($.trim(this.value).length == 1) {
      $("#nivel").val("1");
      $("#puc_puc_id").val("");
      $("#puc_puc").val("");
      $("#puc_puc").attr("disabled", "true");
      $("#puc_puc").removeClass("obligatorio");
      $("#requiere_sucursal").val(0);
      validarNaturaleza();
    }
    if ($.trim(this.value).length > 1) {
      $("#puc_puc").attr("disabled", "");
      $("#puc_puc").addClass("obligatorio");
      $("#movimiento").val("0");
      $("#requiere_sucursal").val(0);
    }

    if ($.trim(this.value).length == 2) {
      $("#nivel").val("2");
      $("#requiere_tercero").attr("disabled", "true");
      $("#requiere_centro_costo").attr("disabled", "true");
      $("#requiere_centro_costo").val(0);
      $("#requiere_tercero").val(0);
      $("#requiere_sucursal").val(0);
      sugerirNivelSuperior(2);
    }
    if ($.trim(this.value).length == 3) {
      $("#nivel").val("");
      $("#requiere_tercero").attr("disabled", "true");
      $("#requiere_centro_costo").attr("disabled", "true");
      $("#requiere_centro_costo").val(0);
      $("#requiere_tercero").val(0);
      $("#requiere_sucursal").val(0);
    }

    if ($.trim(this.value).length == 4) {
      $("#nivel").val("3");
      $("#requiere_tercero").attr("disabled", "true");
      $("#requiere_centro_costo").attr("disabled", "true");
      $("#requiere_centro_costo").val(0);
      $("#requiere_tercero").val(0);
      $("#requiere_sucursal").val(0);
      sugerirNivelSuperior(3);
    }
    if ($.trim(this.value).length == 5) {
      $("#nivel").val("");
      $("#requiere_tercero").attr("disabled", "true");
      $("#requiere_centro_costo").attr("disabled", "true");
      $("#requiere_centro_costo").val(0);
      $("#requiere_tercero").val(0);
      $("#requiere_sucursal").val(0);
    }

    if ($.trim(this.value).length == 6) {
      $("#nivel").val("4");
      $("#requiere_tercero").attr("disabled", "true");
      $("#requiere_centro_costo").attr("disabled", "true");
      $("#requiere_centro_costo").val(0);
      $("#requiere_tercero").val(0);
      $("#requiere_sucursal").val(0);
      sugerirNivelSuperior(4);
    }
    if ($.trim(this.value).length == 7) {
      $("#nivel").val("");
      $("#requiere_tercero").attr("disabled", "true");
      $("#requiere_centro_costo").attr("disabled", "true");
      $("#requiere_centro_costo").val(0);

      $("#requiere_tercero").val(0);
      $("#requiere_sucursal").val(0);
    }

    if ($.trim(this.value).length == 8) {
      $("#nivel").val("5");
      $("#movimiento").val("1");
      $("#requiere_centro_costo").val("1");
      $("#requiere_tercero").removeAttr("disabled");
      $("#requiere_sucursal").attr("disabled", "");
      $("#requiere_centro_costo").attr("disabled", "");
      sugerirNivelSuperior(5);
    }
    if ($.trim(this.value).length > 8) {
      $("#nivel").val("");
      $("#requiere_tercero").attr("disabled", "true");
      $("#requiere_centro_costo").attr("disabled", "true");
      $("#requiere_centro_costo").val(0);

      $("#requiere_tercero").val(0);
      $("#requiere_sucursal").val(0);
    }
  });

  $("#movimiento").change(function () {
    var disableddElement = this.value != 1 ? true : false;
    $(
      "#codigo_dian,#requiere_centro_costo,#requiere_tercero,#requiere_sucursal"
    ).each(function () {
      this.disabled = disableddElement;
    });
  });

  $("#movimiento").blur(function () {
    var disableddElement = this.value != 1 ? true : false;
    $(
      "#codigo_dian,#requiere_centro_costo,#requiere_tercero,#requiere_sucursal"
    ).each(function () {
      this.disabled = disableddElement;
    });
  });

  $("#print").click(function () {
    getPlanCuentasPrint();
  });

  $("a[name=linkPlanCuentasTree]").click(function () {
    getPlanCuentasTree(this.id);
  });

  onclickValidateRow();

  $("#exogena").click(function () {
    var puc_id = $("#puc_id").val();

    if (puc_id > 0) {
      cargardiv();
    } else {
      alertJquery("Debe de buscar primero una cuenta!");
    }
  });

  $("#divSolicitudFormatos").css("display", "none");
});
