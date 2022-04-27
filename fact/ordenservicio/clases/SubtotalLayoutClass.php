<?php

require_once "../../../framework/clases/ViewClass.php";

final class SubtotalLayout extends View
{

    private $fields;

    public function SetGuardar($Permiso)
    {
        $this->Guardar = $Permiso;
    }

    public function SetActualizar($Permiso)
    {
        $this->Actualizar = $Permiso;
    }

    public function SetBorrar($Permiso)
    {
        $this->Borrar = $Permiso;
    }

    public function SetLimpiar($Permiso)
    {
        $this->Limpiar = $Permiso;
    }

    public function setDetalles($detalles)
    {

        $this->assign("DETALLES", $detalles);

    }

    public function setIncludes()
    {

        $this->TplInclude->IncludeCss("../../../framework/css/reset.css");
        $this->TplInclude->IncludeCss("../../../framework/css/general.css");
        $this->TplInclude->IncludeCss("../../../facturacion/ordenservicio/css/subtotal.css");
        $this->TplInclude->IncludeCss("../../../framework/css/jquery.autocomplete.css");
        $this->TplInclude->IncludeCss("../../../framework/css/jquery.alerts.css");

        $this->TplInclude->IncludeJs("../../../framework/js/jquery.js");
        $this->TplInclude->IncludeJs("../../../framework/js/jquery.autocomplete.js");
        $this->TplInclude->IncludeJs("../../../framework/js/funciones.js");
        $this->TplInclude->IncludeJs("../../../framework/js/funcionesDetalle.js");
        $this->TplInclude->IncludeJs("../../../framework/js/jquery.alerts.js");
        $this->TplInclude->IncludeJs("../../../framework/js/jquery.hotkeys.js");

        $this->assign("CSSSYSTEM", $this->TplInclude->GetCssInclude());
        $this->assign("JAVASCRIPT", $this->TplInclude->GetJsInclude());
        $this->assign("orden_servicio_id", $_REQUEST['orden_servicio_id']);

    }

    public function RenderMain()
    {
        $this->RenderLayout('subtotal.tpl');
    }
}
