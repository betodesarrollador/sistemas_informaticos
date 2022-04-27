<?php

require_once "../../../framework/clases/ViewClass.php";

final class reporteActividadLayout extends View
{

    private $fields;
    private $Guardar;

    public function setGuardar($Permiso)
    {
        $this->Guardar = $Permiso;
    }

    public function setCampos($campos)
    {
        

        require_once "../../../framework/clases/FormClass.php";

        $Form1 = new Form("reporteActividadClass.php", "reporteActividadForm", "reporteActividadForm");

        $this->fields = $campos;

        $this->TplInclude->IncludeCss("../../../framework/css/ajax-dynamic-list.css");
        $this->TplInclude->IncludeCss("../../../framework/css/reset.css");
        $this->TplInclude->IncludeCss("../../../framework/css/general.css");
        $this->TplInclude->IncludeCss("../../../framework/css/jquery.alerts.css");
        $this->TplInclude->IncludeCss("../css/reporteActividad.css");
        $this->TplInclude->IncludeCss("../../../framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");
        $this->TplInclude->IncludeJs("../../../framework/js/jquery.js");
        $this->TplInclude->IncludeJs("../../../framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");
        $this->TplInclude->IncludeJs("../../../framework/js/jqueryform.js");
        $this->TplInclude->IncludeJs("../../../framework/js/ajax-list.js");
        $this->TplInclude->IncludeJs("../../../framework/js/ajax-dynamic-list.js");
        $this->TplInclude->IncludeJs("../../../framework/js/funciones.js");
        $this->TplInclude->IncludeJs("../../../framework/js/jquery.alerts.js");
        $this->TplInclude->IncludeJs("../js/reporteActividad.js");


        $this->assign("CSSSYSTEM", $this->TplInclude->GetCssInclude());
        $this->assign("JAVASCRIPT", $this->TplInclude->GetJsInclude());
        $this->assign("FORM1", $Form1->FormBegin());
        $this->assign("FORM1END", $Form1->FormEnd());

        $this->assign("TIPO", $this->objectsHtml->GetobjectHtml($this->fields[tipo]));
        $this->assign("CLIENTE", $this->objectsHtml->GetobjectHtml($this->fields[cliente]));
        $this->assign("CLIENTEID", $this->objectsHtml->GetobjectHtml($this->fields[cliente_id]));
        $this->assign("SI_CLI", $this->objectsHtml->GetobjectHtml($this->fields[si_cliente]));

       $this->assign("DESDE", $this->objectsHtml->GetobjectHtml($this->fields[desde]));
        $this->assign("HASTA", $this->objectsHtml->GetobjectHtml($this->fields[hasta]));
    

        $this->assign("GENERAR", $this->objectsHtml->GetobjectHtml($this->fields[generar]));
        $this->assign("DESCARGAR", $this->objectsHtml->GetobjectHtml($this->fields[descargar]));
        $this->assign("EXCEL", $this->objectsHtml->GetobjectHtml($this->fields[generar_excel]));

    

    }

    
    public function SetTipo($tipos){
	  $this -> fields[tipo]['options'] = $tipos;
      $this -> assign("TIPO",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo]));
    }
    
    public function setDB($db)
    {
        $this->assign("DATABASES", $db);
    }
    

    public function RenderMain()
    {
        $this->RenderLayout('reporteActividad.tpl');
    }

}
