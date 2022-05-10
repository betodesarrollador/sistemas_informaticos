

function setDataFormWithResponse() {
  RequiredRemove();

  FindRow(
    [{ campos: "posicion_id", valores: $("#posicion_id").val() }],
    document.forms[0],
    "posicionClass.php",
    null,
    function(resp) {
      try {

        if ($("#guardar")) $("#guardar").attr("disabled", "true");
        if ($("#actualizar")) $("#actualizar").attr("disabled", "");
        if ($("#borrar")) $("#borrar").attr("disabled", "");
        if ($("#limpiar")) $("#limpiar").attr("disabled", "");
      } catch (e) {
        alertJquery(resp, "Error :" + e);
      }
    }
  );
}

function posicionOnSaveOnUpdateonDelete(formulario, resp) {
  Reset(formulario);
  clearFind();

  $("#refresh_QUERYGRID_wms_posicion").click();

  if ($("#guardar")) $("#guardar").attr("disabled", "");
  if ($("#actualizar")) $("#actualizar").attr("disabled", "true");
  if ($("#borrar")) $("#borrar").attr("disabled", "true");
  if ($("#limpiar")) $("#limpiar").attr("disabled", "");

  var usuario_id = $("#usuario_id_static").val();
  $("#usuario_id").val(usuario_id);

  alertJquery(resp);
}
function posicionOnReset(formulario) {
  Reset(formulario);
  clearFind();
 var usuario_id = $("#usuario_id_static").val();
 $("#usuario_id").val(usuario_id);
  if ($("#guardar")) $("#guardar").attr("disabled", "");
  if ($("#actualizar")) $("#actualizar").attr("disabled", "true");
  if ($("#borrar")) $("#borrar").attr("disabled", "true");
  if ($("#limpiar")) $("#limpiar").attr("disabled", "");
}
