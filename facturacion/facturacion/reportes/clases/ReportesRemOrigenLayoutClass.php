<?php

require_once "../../../framework/clases/ViewClass.php";

final class ReportesRemOrigenLayout extends View
{

    private $fields;

    public function SetImprimir($Permiso)
    {
        $this->Imprimir = $Permiso;
    }

    public function setLimpiar($Permiso)
    {
        $this->Limpiar = $Permiso;
    }

    public function SetCampos($campos)
    {

        require_once "../../../framework/clases/FormClass.php";

        $Form1 = new Form("ReportesRemOrigenClass.php", "ReportesForm", "ReportesForm");

        $this->fields = $campos;

        $this->TplInclude->IncludeCss("../../../framework/css/ajax-dynamic-list.css");
        $this->TplInclude->IncludeCss("../../../framework/css/reset.css");
        $this->TplInclude->IncludeCss("../../../framework/css/general.css");
        $this->TplInclude->IncludeCss("../../../framework/css/jquery.alerts.css");
        $this->TplInclude->IncludeCss("../../../facturacion/reportes/css/Reporte.css");
        $this->TplInclude->IncludeCss("../../../framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");

        $this->TplInclude->IncludeJs("../../../framework/js/jquery.js");
        $this->TplInclude->IncludeJs("../../../framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");
        $this->TplInclude->IncludeJs("../../../framework/js/ajaxupload.3.6.js");
        $this->TplInclude->IncludeJs("../../../framework/js/jqueryform.js");
        $this->TplInclude->IncludeJs("../../../framework/js/funciones.js");
        $this->TplInclude->IncludeJs("../../../framework/js/general.js");
        $this->TplInclude->IncludeJs("../../../framework/js/ajax-list.js");
        $this->TplInclude->IncludeJs("../../../framework/js/ajax-dynamic-list.js");
        $this->TplInclude->IncludeJs("../../../facturacion/reportes/js/ReporteRemOrigen.js");
        $this->TplInclude->IncludeJs("../../../framework/js/jqeffects/jquery.magnifier.js");
        $this->TplInclude->IncludeJs("../../../framework/js/jquery.alerts.js");
        $this->TplInclude->IncludeJs("../../../framework/js/jquery.filestyle.js");

        $this->assign("CSSSYSTEM", $this->TplInclude->GetCssInclude());
        $this->assign("JAVASCRIPT", $this->TplInclude->GetJsInclude());
        $this->assign("FORM1", $Form1->FormBegin());
        $this->assign("FORM1END", $Form1->FormEnd());

        $this->assign("OFICINA", $this->objectsHtml->GetobjectHtml($this->fields[oficina_id]));
        $this->assign("DESDE", $this->objectsHtml->GetobjectHtml($this->fields[desde]));
        $this->assign("HASTA", $this->objectsHtml->GetobjectHtml($this->fields[hasta]));
        $this->assign("ORIGEN", $this->objectsHtml->GetobjectHtml($this->fields[origen]));
        $this->assign("ORIGENID", $this->objectsHtml->GetobjectHtml($this->fields[origen_id]));

        $this->assign("GENERAR", $this->objectsHtml->GetobjectHtml($this->fields[generar]));
        $this->assign("DESCARGAR", $this->objectsHtml->GetobjectHtml($this->fields[descargar]));

        if ($this->Imprimir) {
            $this->assign("IMPRIMIR", $this->objectsHtml->GetobjectHtml($this->fields[imprimir]));
        }

        if ($this->Limpiar) {
            $this->assign("LIMPIAR", $this->objectsHtml->GetobjectHtml($this->fields[limpiar]));
        }

    }

    public function RenderMain()
    {
        $this->RenderLayout('ReporteRemOrigen.tpl');
    }

}
