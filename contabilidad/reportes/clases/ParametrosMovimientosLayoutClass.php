<?php
require_once "../../../framework/clases/ViewClass.php";
final class ParametrosMovimientosLayout extends View
{
    private $fields;

    public function setCampos($campos)
    {
        require_once "../../../framework/clases/FormClass.php";

        $Form1 = new Form("ParametrosMovimientosClass.php", "ParametrosMovimientos", "ParametrosMovimientos");
        $this->fields = $campos;

        $this->TplInclude->IncludeCss("../../../framework/css/reset.css");
        $this->TplInclude->IncludeCss("../../../framework/css/general.css");
        $this->TplInclude->IncludeCss("../../../framework/css/jquery.alerts.css");
        $this->TplInclude->IncludeCss("../css/LibrosAuxiliares.css");
        $this->TplInclude->IncludeCss("../../../framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");
        $this->TplInclude->IncludeJs("../../../framework/js/jquery.js");
        $this->TplInclude->IncludeJs("../../../framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");
        $this->TplInclude->IncludeJs("../../../framework/js/jqueryform.js");
        $this->TplInclude->IncludeJs("../../../framework/js/funciones.js");
        $this->TplInclude->IncludeJs("../../../framework/js/jquery.alerts.js");
        $this->TplInclude->IncludeJs("../js/ParametrosMovimientos.js");

        $this->assign("CSSSYSTEM", $this->TplInclude->GetCssInclude());
        $this->assign("JAVASCRIPT", $this->TplInclude->GetJsInclude());
        $this->assign("FORM1", $Form1->FormBegin());
        $this->assign("FORM1END", $Form1->FormEnd());

        $this->assign("FECHAINICIAL", $this->objectsHtml->GetobjectHtml($this->fields[fecha_inicial]));
        $this->assign("FECHAFINAL", $this->objectsHtml->GetobjectHtml($this->fields[fecha_final]));
        $this->assign("GENERAR", $this->objectsHtml->GetobjectHtml($this->fields[generar]));
        $this->assign("CENTROSTODOS", $this->objectsHtml->GetobjectHtml($this->fields[opciones_centros]));

    }

    public function setCentrosCosto($centros)
    {
        $this->fields[centro_de_costo_id]['options'] = $centros;
        $this->assign("CENTROCOSTOID", $this->objectsHtml->GetobjectHtml($this->fields[centro_de_costo_id]));
    }
    public function RenderMain()
    {
        $this->RenderLayout('ParametrosMovimientosLayout.tpl');
    }
}
