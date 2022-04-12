<?php

require_once "../../../framework/clases/ViewClass.php";

final class DetallesLayout extends View
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

    public function setImputacionesContables($detalles)
    {

        $this->assign("DETALLES", $detalles);

    }

    public function setIncludes()
    {

        $this->TplInclude->IncludeCss("../../../framework/css/reset.css");
        $this->TplInclude->IncludeCss("../../../framework/css/general.css");
        $this->TplInclude->IncludeCss("../../../facturacion/nota_credito/css/detalles.css");
        $this->TplInclude->IncludeCss("../../../framework/css/jquery.autocomplete.css");
        $this->TplInclude->IncludeCss("../../../framework/css/jquery.alerts.css");

        $this->TplInclude->IncludeJs("../../../framework/jquery/jquery-3.5.1.min.js");
        $this->TplInclude->IncludeJs("../../../framework/js/jquery.autocomplete.js");
        $this->TplInclude->IncludeJs("../../../framework/js/funciones.js");
        $this->TplInclude->IncludeJs("../../../framework/js/funcionesDetalle.js");
        $this -> TplInclude -> IncludeJs("../../../framework/js/general.js");
        $this->TplInclude->IncludeJs("../../../facturacion/nota_credito/js/detalles.js");
        $this->TplInclude->IncludeJs("../../../framework/js/jquery.alerts.js");
        $this->TplInclude->IncludeJs("../../../framework/js/jquery.hotkeys.js");

        $this->assign("CSSSYSTEM", $this->TplInclude->GetCssInclude());
        $this->assign("JAVASCRIPT", $this->TplInclude->GetJsInclude());
        $this->assign("factura_id", $_REQUEST['factura_id']);
        $this->assign("fuente_facturacion_cod", $_REQUEST['fuente_facturacion_cod']);

    }

    public function RenderMain()
    {

        $this->RenderLayout('detalles.tpl');

    }

}
