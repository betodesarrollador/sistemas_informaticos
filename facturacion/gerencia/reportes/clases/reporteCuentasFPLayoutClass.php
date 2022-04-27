<?php

require_once "../../framework/clases/ViewClass.php";

final class reporteCuentasFPLayout extends View
{

    private $fields;

    public function SetImprimir($Permiso)
    {
        $this->Imprimir = $Permiso;
    }

    public function SetCampos($campos)
    {

        require_once "../../framework/clases/FormClass.php";

        $Form1 = new Form("reporteCuentasFPClass.php", "reporteCuentasFPForm", "reporteCuentasFPForm");

        $this->fields = $campos;

        $this->TplInclude->IncludeCss("/application/framework/css/ajax-dynamic-list.css");
        $this->TplInclude->IncludeCss("/application/framework/css/reset.css");
        $this->TplInclude->IncludeCss("/application/framework/css/general.css");
        $this->TplInclude->IncludeCss("/application/framework/css/jquery.alerts.css");
        $this->TplInclude->IncludeCss("/application/gerencia/css/Reporte.css");
        $this->TplInclude->IncludeCss("/application/framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");

        $this->TplInclude->IncludeJs("/application/framework/js/jquery.js");
        $this->TplInclude->IncludeJs("/application/framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");
        $this->TplInclude->IncludeJs("/application/framework/js/ajaxupload.3.6.js");
        $this->TplInclude->IncludeJs("/application/framework/js/jqueryform.js");
        $this->TplInclude->IncludeJs("/application/framework/js/funciones.js");
        $this->TplInclude->IncludeJs("/application/framework/js/general.js");
        $this->TplInclude->IncludeJs("/application/framework/js/ajax-list.js");
        $this->TplInclude->IncludeJs("/application/framework/js/ajax-dynamic-list.js");
        $this->TplInclude->IncludeJs("/application/gerencia/js/Reporte.js");
        $this->TplInclude->IncludeJs("/application/framework/js/jqeffects/jquery.magnifier.js");
        $this->TplInclude->IncludeJs("/application/framework/js/jquery.alerts.js");
        $this->TplInclude->IncludeJs("/application/framework/js/jquery.filestyle.js");

        $this->assign("CSSSYSTEM", $this->TplInclude->GetCssInclude());
        $this->assign("JAVASCRIPT", $this->TplInclude->GetJsInclude());
        $this->assign("FORM1", $Form1->FormBegin());
        $this->assign("FORM1END", $Form1->FormEnd());

        $this->assign("OFICINA", $this->objectsHtml->GetobjectHtml($this->fields[oficina_id]));
        $this->assign("TIPO", $this->objectsHtml->GetobjectHtml($this->fields[tipo]));
        $this->assign("DESDE", $this->objectsHtml->GetobjectHtml($this->fields[desde]));
        $this->assign("HASTA", $this->objectsHtml->GetobjectHtml($this->fields[hasta]));
        $this->assign("CLIENTE", $this->objectsHtml->GetobjectHtml($this->fields[cliente]));
        $this->assign("CLIENTEID", $this->objectsHtml->GetobjectHtml($this->fields[cliente_id]));
        $this->assign("ALLOFFICE", $this->objectsHtml->GetobjectHtml($this->fields[all_oficina]));

        $this->assign("GENERAR", $this->objectsHtml->GetobjectHtml($this->fields[generar]));
        $this->assign("DESCARGAR", $this->objectsHtml->GetobjectHtml($this->fields[descargar]));
        $this->assign("EXCEL", $this->objectsHtml->GetobjectHtml($this->fields[generar_excel]));

        if ($this->Imprimir) {
            $this->assign("IMPRIMIR", $this->objectsHtml->GetobjectHtml($this->fields[imprimir]));
        }

    }

    public function SetOficina($oficina)
    {
        $this->fields[oficina_id]['options'] = $oficina;
        $this->assign("OFICINA", $this->objectsHtml->GetobjectHtml($this->fields[oficina_id]));
    }

    public function SetTipo($tipos)
    {
        $this->fields[tipo]['options'] = $tipos;
        $this->assign("TIPO", $this->objectsHtml->GetobjectHtml($this->fields[tipo]));
    }
    public function SetSi_Pro($Si_pro)
    {
        $this->fields[si_cliente]['options'] = $Si_pro;
        $this->assign("SI_CLI", $this->objectsHtml->GetobjectHtml($this->fields[si_cliente]));
    }

    public function RenderMain()
    {
        $this->RenderLayout('Reporte.tpl');
    }

}
