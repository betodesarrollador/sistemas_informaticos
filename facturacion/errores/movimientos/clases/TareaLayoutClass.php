<?php

require_once "../../../framework/clases/ViewClass.php";

final class TareaLayout extends View
{

    private $fields;
    private $Guardar;
    private $Actualizar;
    private $Borrar;
    private $Limpiar;

    public function setGuardar($Permiso)
    {
        $this->Guardar = $Permiso;
    }

    public function setActualizar($Permiso)
    {
        $this->Actualizar = $Permiso;
    }

    public function setBorrar($Permiso)
    {
        $this->Borrar = $Permiso;
    }

    public function setLimpiar($Permiso)
    {
        $this->Limpiar = $Permiso;
    }

    public function setActividadProgramadaId($actividad_programada_id)
    {

        $this->fields[actividad_programada_id][value] = $actividad_programada_id;
        $this->assign("PARAMID", $this->objectsHtml->GetobjectHtml($this->fields[actividad_programada_id]));

    }

    public function setCampos($campos)
    {

        require_once "../../../framework/clases/FormClass.php";

        $Form1 = new Form("TareaClass.php", "TareaForm", "TareaForm");

        $this->fields = $campos;

        $this->TplInclude->IncludeCss("../../../framework/css/ajax-dynamic-list.css");
        $this->TplInclude->IncludeCss("../../../framework/css/reset.css");
        $this->TplInclude->IncludeCss("../../../framework/css/general.css");
        $this->TplInclude->IncludeCss("../../../framework/css/jquery.alerts.css");

        $this->TplInclude->IncludeJs("../../../framework/js/jquery.js");
        $this->TplInclude->IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker.js");
        $this->TplInclude->IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker-es.js");

        $this->TplInclude->IncludeJs("../../../framework/js/jqueryform.js");
        $this->TplInclude->IncludeJs("../../../framework/js/funciones.js");
        //$this -> TplInclude -> IncludeJs("/talpaprueba/framework/js/generalterceros.js");
        $this->TplInclude->IncludeJs("../../../framework/js/ajax-list.js");
        $this->TplInclude->IncludeJs("../../../framework/js/ajax-dynamic-list.js");

        $this->TplInclude->IncludeJs("../../../errores/movimientos/js/Tarea.js");
        $this->TplInclude->IncludeJs("../../../framework/js/jquery.alerts.js");

        $this->assign("CSSSYSTEM", $this->TplInclude->GetCssInclude());
        $this->assign("JAVASCRIPT", $this->TplInclude->GetJsInclude());
        $this->assign("FORM1", $Form1->FormBegin());
        $this->assign("FORM1END", $Form1->FormEnd());
        $this->assign("BUSQUEDA", $this->objectsHtml->GetobjectHtml($this->fields[busqueda]));
        $this->assign("PARAMID", $this->objectsHtml->GetobjectHtml($this->fields[actividad_programada_id]));
        $this->assign("NOMBRE", $this->objectsHtml->GetobjectHtml($this->fields[nombre]));
        $this->assign("ALLCLIENTES", $this->objectsHtml->GetobjectHtml($this->fields[all_clientes]));
        $this->assign("RESPONSABLE", $this->objectsHtml->GetobjectHtml($this->fields[responsable]));
        $this->assign("RESPONSABLEID", $this->objectsHtml->GetobjectHtml($this->fields[responsable_id]));
        $this->assign("DESCRIPCION", $this->getObjectHtml($this->fields[descripcion]));
        $this->assign("FECHAINI", $this->getObjectHtml($this->fields[fecha_inicial]));
        $this->assign("FECHAFIN", $this->getObjectHtml($this->fields[fecha_final]));
        $this->assign("FECHACIERRE", $this->getObjectHtml($this->fields[fecha_cierre]));
        $this->assign("FECHAINIREAL", $this->getObjectHtml($this->fields[fecha_inicial_real]));
        $this->assign("FECHAFINREAL", $this->getObjectHtml($this->fields[fecha_final_real]));
        $this->assign("ARCHIVO", $this->objectsHtml->GetobjectHtml($this->fields[archivo]));
        $this->assign("ESTADO", $this->getObjectHtml($this->fields[estado]));
        $this->assign("FECHAREGISTRO", $this->getObjectHtml($this->fields[fecha_registro]));
        $this->assign("PRIORIDAD", $this->objectsHtml->GetobjectHtml($this->fields[prioridad]));
        $this->assign("USUARIOID", $this->objectsHtml->GetobjectHtml($this->fields[usuario_id]));
        $this->assign("USUARIOCIERRE", $this->objectsHtml->GetobjectHtml($this->fields[usuario_cierre_id]));
        $this->assign("FECHACIERREREAL", $this->getObjectHtml($this->fields[fecha_cierre_real]));
        $this->assign("OBSERVACION", $this->getObjectHtml($this->fields[observacion_cierre]));
        $this->assign("FECHAACT", $this->objectsHtml->GetobjectHtml($this->fields[fecha_actualiza]));
        $this->assign("USUARIOACT", $this->objectsHtml->GetobjectHtml($this->fields[usuario_actualiza_id]));
        $this->assign("CREADOR", $this->objectsHtml->GetobjectHtml($this->fields[creador]));
        $this->assign("CREADORID", $this->objectsHtml->GetobjectHtml($this->fields[creador_id]));
        $this->assign("EMAIL_CLIENTE", $this->objectsHtml->GetobjectHtml($this->fields[email_cliente]));
        $this->assign("ACTA_ID", $this->objectsHtml->GetobjectHtml($this->fields[acta_id]));

        if ($this->Guardar) {
            $this->assign("GUARDAR", $this->objectsHtml->GetobjectHtml($this->fields[guardar]));
        }

        if ($this->Actualizar) {
            $this->assign("ACTUALIZAR", $this->objectsHtml->GetobjectHtml($this->fields[actualizar]));
            $this->assign("CERRAR", $this->objectsHtml->GetobjectHtml($this->fields[cerrar]));
            $this->assign("ENVIAR_EMAIL_FINALIZACION", $this->objectsHtml->GetobjectHtml($this->fields[enviar_email_finalizacion]));
            $this->assign("ENVIAR_EMAIL_INICIO", $this->objectsHtml->GetobjectHtml($this->fields[enviar_email_inicio]));
        }

        if ($this->Borrar) {
            $this->assign("BORRAR", $this->objectsHtml->GetobjectHtml($this->fields[borrar]));
        }

        if ($this->Limpiar) {
            $this->assign("LIMPIAR", $this->objectsHtml->GetobjectHtml($this->fields[limpiar]));
        }

    }

    public function SetGridTarea($Attributes, $Titles, $Cols, $Query)
    {
        require_once "../../../framework/clases/grid/JqGridClass.php";
        $TableGrid = new JqGrid();
        $TableGrid->SetJqGrid($Attributes, $Titles, $Cols, $Query);
        $this->assign("GRIDTarea", $TableGrid->RenderJqGrid());
        $this->assign("TABLEGRIDCSS", $TableGrid->GetJqGridCss());
        $this->assign("TABLEGRIDJS", $TableGrid->GetJqGridJs());
    }

    public function SetCliente($cliente_id)
    {
        $this->fields[cliente_id]['options'] = $cliente_id;
        $this->assign("CLIENTE_ID", $this->getObjectHtml($this->fields[cliente_id]));
    }

    public function SetTipo($tipo_tarea_id)
    {
        $this->fields[tipo_tarea_id]['options'] = $tipo_tarea_id;
        $this->assign("TIPO_TAREA_ID", $this->getObjectHtml($this->fields[tipo_tarea_id]));
    }

    public function RenderMain()
    {
        $this->RenderLayout('Tarea.tpl');
    }

}
