<?php

require_once "../../framework/clases/ViewClass.php";

final class DetallesLayout extends View
{

    private $fields;

    public function setReporteFP1($detalles)
    {
        $this->assign("DETALLES", $detalles);
    }

    public function setReporteVF_ALL($detalles)
    {
        $this->assign("DETALLES", $detalles);
    }

    public function setIncludes()
    {

        $this->TplInclude->IncludeCss("/application/framework/css/reset.css");
        $this->TplInclude->IncludeCss("/application/framework/css/general.css");
        $this->TplInclude->IncludeCss("/application/gerencia/css/detalles.css");
        $this->TplInclude->IncludeCss("/application/framework/css/jquery.autocomplete.css");
        $this->TplInclude->IncludeCss("/application/framework/css/jquery.alerts.css");

        $this->TplInclude->IncludeJs("/application/framework/js/jquery.js");
        $this->TplInclude->IncludeJs("/application/framework/js/jquery.autocomplete.js");
        $this->TplInclude->IncludeJs("/application/framework/js/funciones.js");
        $this->TplInclude->IncludeJs("/application/framework/js/funcionesDetalle.js");
        $this->TplInclude->IncludeJs("/application/framework/js/jquery.alerts.js");
        $this->TplInclude->IncludeJs("/application/framework/js/jquery.hotkeys.js");
        $this->TplInclude->IncludeJs("/application/gerencia/js/detalles.js");

        $this->assign("CSSSYSTEM", $this->TplInclude->GetCssInclude());
        $this->assign("JAVASCRIPT", $this->TplInclude->GetJsInclude());
        $this->assign("tipo", $_REQUEST['tipo']);
        $this->assign("desde", $_REQUEST['desde']);
        $this->assign("hasta", $_REQUEST['hasta']);
    }

    public function RenderMain()
    {

        $this->RenderLayout('detalles.tpl');

    }

}
