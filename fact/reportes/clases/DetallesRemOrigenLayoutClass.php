<?php

require_once "../../../framework/clases/ViewClass.php";

final class DetallesRemOrigenLayout extends View
{

    private $fields;

    public function setReporteRemOrigen($detalles)
    {
        $this->assign("DETALLES", $detalles);
    }

    public function setIncludes()
    {

        $this->TplInclude->IncludeCss("../../../framework/css/reset.css");
        $this->TplInclude->IncludeCss("../../../framework/css/general.css");
        $this->TplInclude->IncludeCss("../../../facturacion/reportes/css/detalles.css");
        $this->TplInclude->IncludeCss("../../../framework/css/jquery.autocomplete.css");
        $this->TplInclude->IncludeCss("../../../framework/css/jquery.alerts.css");

        $this->TplInclude->IncludeJs("../../../framework/js/jquery.js");
        $this->TplInclude->IncludeJs("../../../framework/js/jquery.autocomplete.js");
        $this->TplInclude->IncludeJs("../../../framework/js/funciones.js");
        $this->TplInclude->IncludeJs("../../../framework/js/funcionesDetalle.js");
        $this->TplInclude->IncludeJs("../../../framework/js/jquery.alerts.js");
        $this->TplInclude->IncludeJs("../../../framework/js/jquery.hotkeys.js");
        $this->TplInclude->IncludeJs("../../../facturacion/reportes/js/detalles.js");

        $this->assign("CSSSYSTEM", $this->TplInclude->GetCssInclude());
        $this->assign("JAVASCRIPT", $this->TplInclude->GetJsInclude());
        $this->assign("desde", $_REQUEST['desde']);
        $this->assign("hasta", $_REQUEST['hasta']);
    }

    public function RenderMain()
    {

        $this->RenderLayout('detallesRemOrigen.tpl');

    }

}
