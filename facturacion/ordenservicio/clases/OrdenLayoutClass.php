<?php

require_once "../../../framework/clases/ViewClass.php";

final class OrdenLayout extends View
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
    public function SetAnular($Permiso)
    {
        $this->Anular = $Permiso;
    }

    public function SetLiquidar($Permiso)
    {
        $this->Liquidar = $Permiso;
    }
    public function setImprimir($Permiso)
    {
        $this->Imprimir = $Permiso;
    }

    public function SetCampos($campos)
    {

        require_once "../../../framework/clases/FormClass.php";

        $Form1 = new Form("OrdenClass.php", "OrdenForm", "OrdenForm");

        $this->fields = $campos;

        $this->TplInclude->IncludeCss("../../../framework/css/ajax-dynamic-list.css");
        $this->TplInclude->IncludeCss("../../../framework/css/reset.css");
        $this->TplInclude->IncludeCss("../../../framework/css/general.css");
        $this->TplInclude->IncludeCss("../../../framework/css/jquery.alerts.css");
        $this->TplInclude->IncludeCss("../../../facturacion/ordenservicio/css/orden.css");
        $this->TplInclude->IncludeCss("../../../framework/css/bootstrap1.css");
        $this->TplInclude->IncludeCss("../../../framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");

        $this->TplInclude->IncludeJs("../../../framework/js/jquery.js");
        $this->TplInclude->IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker.js");
        $this->TplInclude->IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker-es.js");
        $this->TplInclude->IncludeJs("../../../framework/js/ajaxupload.3.6.js");
        $this->TplInclude->IncludeJs("../../../framework/js/jqueryform.js");
        $this->TplInclude->IncludeJs("../../../framework/js/funciones.js");
        $this->TplInclude->IncludeJs("../../../framework/js/general.js");
        $this->TplInclude->IncludeJs("../../../framework/js/ajax-list.js");
        $this->TplInclude->IncludeJs("../../../framework/js/ajax-dynamic-list.js");
        $this->TplInclude->IncludeJs("../../../facturacion/ordenservicio/js/orden.js");
        $this->TplInclude->IncludeJs("../../../framework/js/jqeffects/jquery.magnifier.js");
        $this->TplInclude->IncludeJs("../../../framework/js/jquery.alerts.js");
        $this->TplInclude->IncludeJs("../../../framework/js/jquery.filestyle.js");
        $this->TplInclude->IncludeJs("../../../framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");

        $this->assign("CSSSYSTEM", $this->TplInclude->GetCssInclude());
        $this->assign("JAVASCRIPT", $this->TplInclude->GetJsInclude());
        $this->assign("FORM1", $Form1->FormBegin());
        $this->assign("FORM1END", $Form1->FormEnd());
        $this->assign("BUSQUEDA", $this->objectsHtml->GetobjectHtml($this->fields[busqueda]));
        $this->assign("ORDENID", $this->objectsHtml->GetobjectHtml($this->fields[orden_servicio_id]));
        $this->assign("CONSECUTIVO", $this->objectsHtml->GetobjectHtml($this->fields[consecutivo]));
        $this->assign("FECHA", $this->objectsHtml->GetobjectHtml($this->fields[fecha_orden_servicio]));
        $this->assign("CLIENTEID", $this->objectsHtml->GetobjectHtml($this->fields[cliente_id]));
        $this->assign("CLIENTENOM", $this->objectsHtml->GetobjectHtml($this->fields[cliente]));
        $this->assign("CLIENTETEL", $this->objectsHtml->GetobjectHtml($this->fields[cliente_tele]));
        $this->assign("CLIENTEDIR", $this->objectsHtml->GetobjectHtml($this->fields[cliente_direccion]));
        $this->assign("CLIENTECIU", $this->objectsHtml->GetobjectHtml($this->fields[cliente_ciudad]));
        $this->assign("CLIENTECON", $this->objectsHtml->GetobjectHtml($this->fields[cliente_contacto]));
        $this->assign("CLIENTECORREO", $this->objectsHtml->GetobjectHtml($this->fields[cliente_correo]));
        $this->assign("TIPOSERVICIO", $this->objectsHtml->GetobjectHtml($this->fields[tiposervicio]));
        $this->assign("TIPOSERVICIOID", $this->objectsHtml->GetobjectHtml($this->fields[tipo_bien_servicio_factura_id]));
        $this->assign("DESCRIPCION", $this->objectsHtml->GetobjectHtml($this->fields[descrip_orden_servicio]));
        $this->assign("PAGO", $this->objectsHtml->GetobjectHtml($this->fields[forma_compra_venta_id]));
        $this->assign("ESTADO", $this->objectsHtml->GetobjectHtml($this->fields[estado_orden_servicio]));
        $this->assign("FECHAINGRESO", $this->objectsHtml->GetobjectHtml($this->fields[ingreso_orden_servicio]));

        /***********************
        Anulacion Registro
         ***********************/

        $this->assign("FECHALOG", $this->objectsHtml->GetobjectHtml($this->fields[anul_orden_servicio]));
        $this->assign("OBSERVACIONES", $this->objectsHtml->GetobjectHtml($this->fields[desc_anul_orden_servicio]));

        /***********************
        Liquidar Registro
         ***********************/

        $this->assign("FECHALOG1", $this->objectsHtml->GetobjectHtml($this->fields[fec_liq_orden_servicio]));
        $this->assign("OBSERVACIONES1", $this->objectsHtml->GetobjectHtml($this->fields[descrip_liq_orden_servicio]));

        if ($this->Liquidar) {
            $this->assign("LIQUIDAR", $this->objectsHtml->GetobjectHtml($this->fields[liquidar]));
        }

        if ($this->Guardar) {
            $this->assign("GUARDAR", $this->objectsHtml->GetobjectHtml($this->fields[guardar]));
        }

        if ($this->Actualizar) {
            $this->assign("ACTUALIZAR", $this->objectsHtml->GetobjectHtml($this->fields[actualizar]));
        }

        if ($this->Borrar) {
            $this->assign("BORRAR", $this->objectsHtml->GetobjectHtml($this->fields[borrar]));
        }

        if ($this->Limpiar) {
            $this->assign("LIMPIAR", $this->objectsHtml->GetobjectHtml($this->fields[limpiar]));
        }

        if ($this->Anular) {
            $this->assign("ANULAR", $this->objectsHtml->GetobjectHtml($this->fields[anular]));
        }

        if ($this->Imprimir) {
            $this->assign("IMPRIMIR", $this->objectsHtml->GetobjectHtml($this->fields[imprimir]));
        }

    }

    public function SetTiposPago($TiposPago)
    {
        $this->fields[forma_compra_venta_id]['options'] = $TiposPago;
        $this->assign("PAGO", $this->objectsHtml->GetobjectHtml($this->fields[forma_compra_venta_id]));
    }

    public function setCausalesAnulacion($causales)
    {
        $this->fields[causal_anulacion_id]['options'] = $causales;
        $this->assign("CAUSALESID", $this->objectsHtml->GetobjectHtml($this->fields[causal_anulacion_id]));
    }
    public function setCentroCosto($centrocosto)
    {
        $this->fields[centro_de_costo_id]['options'] = $centrocosto;
        $this->assign("CENTROCOSTOID", $this->objectsHtml->GetobjectHtml($this->fields[centro_de_costo_id]));
    }

    public function setUsuarioId($usuario, $oficina)
    {
        $this->fields[oficina_id]['value'] = $oficina;
        $this->assign("OFICINAID", $this->objectsHtml->GetobjectHtml($this->fields[oficina_id]));
        $this->fields[anul_oficina_id]['value'] = $oficina;
        $this->assign("ANULOFICINAID", $this->objectsHtml->GetobjectHtml($this->fields[anul_oficina_id]));

        $this->fields[anul_usuario_id]['value'] = $usuario;
        $this->assign("USUARIOID", $this->objectsHtml->GetobjectHtml($this->fields[anul_usuario_id]));
        $this->fields[usuario_id]['value'] = $usuario;
        $this->assign("INSUSUARIOID", $this->objectsHtml->GetobjectHtml($this->fields[usuario_id]));

        $this->fields[liq_usuario_id]['value'] = $usuario;
        $this->assign("INSUSUARIOID1", $this->objectsHtml->GetobjectHtml($this->fields[liq_usuario_id]));

    }

    public function SetGridOrden($Attributes, $Titles, $Cols, $Query)
    {
        require_once "../../../framework/clases/grid/JqGridClass.php";
        $TableGrid = new JqGrid();
        $TableGrid->SetJqGrid($Attributes, $Titles, $Cols, $Query);

        $head = "'<head>" .

        $TableGrid->GetJqGridJs() . " " .

        $TableGrid->GetJqGridCss() . "

     </head>";

        $body = "<body>" . $TableGrid->RenderJqGrid() . "</body>";

        return "<html>" . $head . " " . $body . "</html>";

    }

    public function RenderMain()
    {
        $this->RenderLayout('orden.tpl');
    }

}
