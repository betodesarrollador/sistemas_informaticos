<?php

require_once "../../../framework/clases/ViewClass.php";

final class OrdenCargueLayout extends View
{

    private $fields;

    public function setGuardar($Permiso)
    {
        $this->Guardar = $Permiso;
    }

    public function setActualizar($Permiso)
    {
        $this->Actualizar = $Permiso;
    }

    public function setAnular($Permiso)
    {
        $this->Anular = $Permiso;
    }

    public function setLimpiar($Permiso)
    {
        $this->Limpiar = $Permiso;
    }

    public function setImprimir($Permiso)
    {
        $this->Imprimir = $Permiso;
    }

    public function setCampos($campos)
    {

        require_once "../../../framework/clases/FormClass.php";

        $Form1 = new Form("OrdenCargueClass.php", "OrdenCargueForm", "OrdenCargueForm");

        $this->fields = $campos;

        $this->TplInclude->IncludeCss("../../../framework/css/ajax-dynamic-list.css");
        $this->TplInclude->IncludeCss("../../../framework/css/reset.css");
        $this->TplInclude->IncludeCss("../../../framework/css/general.css");
        $this->TplInclude->IncludeCss("../../../framework/css/DatosBasicos.css");
        //$this -> TplInclude -> IncludeCss("../../../transporte/operacion/css/OrdenCargue.css");
        $this->TplInclude->IncludeCss("../../../framework/css/jquery.alerts.css");

        $this->TplInclude->IncludeJs("../../../framework/js/jquery.js");
        $this->TplInclude->IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker.js");
        $this->TplInclude->IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker-es.js");
        $this->TplInclude->IncludeJs("../../../framework/js/jqueryform.js");
        $this->TplInclude->IncludeJs("../../../framework/js/funciones.js");
        $this->TplInclude->IncludeJs("../../../framework/js/ajax-list.js");
        $this->TplInclude->IncludeJs("../../../framework/js/ajax-dynamic-list.js");
        $this->TplInclude->IncludeJs("../../../transporte/operacion/js/OrdenCargue.js");
        $this->TplInclude->IncludeJs("../../../framework/js/jquery.alerts.js");

        $this->assign("CSSSYSTEM", $this->TplInclude->GetCssInclude());
        $this->assign("JAVASCRIPT", $this->TplInclude->GetJsInclude());
        $this->assign("FORM1", $Form1->FormBegin());
        $this->assign("FORM1END", $Form1->FormEnd());
        $this->assign("BUSQUEDA", $this->objectsHtml->GetobjectHtml($this->fields[busqueda]));

        $this->assign("ORDENCARGUEID", $this->objectsHtml->GetobjectHtml($this->fields[orden_cargue_id]));
        $this->assign("CONSECUTIVO", $this->objectsHtml->GetobjectHtml($this->fields[consecutivo]));
        $this->assign("SOLICITUDID", $this->objectsHtml->GetobjectHtml($this->fields[detalle_ss_id]));
        $this->assign("DETSOLICITUD", $this->objectsHtml->GetobjectHtml($this->fields[detalle_solicitud]));
        $this->assign("FECHA", $this->objectsHtml->GetobjectHtml($this->fields[fecha]));
        $this->assign("OFICINAIDSTATIC", $this->objectsHtml->GetobjectHtml($this->fields[oficina_id_static]));
        $this->assign("OFICINAID", $this->objectsHtml->GetobjectHtml($this->fields[oficina_id]));
        $this->assign("USUARIOIDSTATIC", $this->objectsHtml->GetobjectHtml($this->fields[usuario_id_static]));
        $this->assign("USUARIOID", $this->objectsHtml->GetobjectHtml($this->fields[usuario_id]));
        $this->assign("FECHAINGRESOSTAT", $this->objectsHtml->GetobjectHtml($this->fields[fecha_ingreso_static]));
        $this->assign("FECHAINGRESO", $this->objectsHtml->GetobjectHtml($this->fields[fecha_ingreso]));
        $this->assign("ESTADO", $this->objectsHtml->GetobjectHtml($this->fields[estado]));

        $this->assign("CLIENTE", $this->objectsHtml->GetobjectHtml($this->fields[cliente]));
        $this->assign("CLIENTEID", $this->objectsHtml->GetobjectHtml($this->fields[cliente_id]));
        $this->assign("CLIENTENIT", $this->objectsHtml->GetobjectHtml($this->fields[cliente_nit]));
        $this->assign("CLIENTETEL", $this->objectsHtml->GetobjectHtml($this->fields[cliente_tel]));
        $this->assign("CLIENTEDIR", $this->objectsHtml->GetobjectHtml($this->fields[direccion_cargue]));
        $this->assign("CONTACTOID", $this->objectsHtml->GetobjectHtml($this->fields[contacto_id]));
        $this->assign("SERVICIO", $this->objectsHtml->GetobjectHtml($this->fields[tipo_servicio_id]));
        $this->assign("HORA", $this->objectsHtml->GetobjectHtml($this->fields[hora]));

        $this->assign("ORIGEN", $this->objectsHtml->GetobjectHtml($this->fields[origen]));
        $this->assign("ORIGENID", $this->objectsHtml->GetobjectHtml($this->fields[origen_id]));
        $this->assign("REMITENTE", $this->objectsHtml->GetobjectHtml($this->fields[remitente]));
        $this->assign("REMITENTEID", $this->objectsHtml->GetobjectHtml($this->fields[remitente_id]));
        $this->assign("DESTINO", $this->objectsHtml->GetobjectHtml($this->fields[destino]));
        $this->assign("DESTINOID", $this->objectsHtml->GetobjectHtml($this->fields[destino_id]));
        $this->assign("DESTINATARIO", $this->objectsHtml->GetobjectHtml($this->fields[destinatario]));
        $this->assign("DESTINATARIOID", $this->objectsHtml->GetobjectHtml($this->fields[destinatario_id]));
        $this->assign("PRODUCTO", $this->objectsHtml->GetobjectHtml($this->fields[producto]));
        $this->assign("PRODUCTOID", $this->objectsHtml->GetobjectHtml($this->fields[producto_id]));
        $this->assign("CANTIDAD", $this->objectsHtml->GetobjectHtml($this->fields[cantidad_cargue]));
        $this->assign("PESOCANT", $this->objectsHtml->GetobjectHtml($this->fields[peso]));
        $this->assign("VOLCANTI", $this->objectsHtml->GetobjectHtml($this->fields[peso_volumen]));
        $this->assign("OBSERVACIONESOC", $this->objectsHtml->GetobjectHtml($this->fields[observaciones]));
        $this->assign("ORDENDESPACHO", $this->objectsHtml->GetobjectHtml($this->fields[orden_despacho]));
        $this->assign("PLACAVEHICULO", $this->objectsHtml->GetobjectHtml($this->fields[placa]));
        $this->assign("PLACAVEHICULOID", $this->objectsHtml->GetobjectHtml($this->fields[placa_id]));
        $this->assign("REMOLQUE", $this->objectsHtml->GetobjectHtml($this->fields[remolque]));
        $this->assign("MARCAVEHICULO", $this->objectsHtml->GetobjectHtml($this->fields[marca]));
        $this->assign("LINEAVEHICULO", $this->objectsHtml->GetobjectHtml($this->fields[linea]));
        $this->assign("MODELOVEHICULO", $this->objectsHtml->GetobjectHtml($this->fields[modelo]));
        $this->assign("MODELOREPOTENCIADOVEHICULO", $this->objectsHtml->GetobjectHtml($this->fields[modelo_repotenciado]));
        $this->assign("SERIEVEHICULO", $this->objectsHtml->GetobjectHtml($this->fields[serie]));
        $this->assign("COLORVEHICULO", $this->objectsHtml->GetobjectHtml($this->fields[color]));
        $this->assign("CARROCERIAVEHICULO", $this->objectsHtml->GetobjectHtml($this->fields[carroceria]));
        $this->assign("REGISTRONALCARGAVEHICULO", $this->objectsHtml->GetobjectHtml($this->fields[registro_nacional_carga]));
        $this->assign("CONFIGURACIONVEHICULO", $this->objectsHtml->GetobjectHtml($this->fields[configuracion]));
        $this->assign("PESOVACIOVEHICULO", $this->objectsHtml->GetobjectHtml($this->fields[peso_vacio]));
        $this->assign("CAPACIDADVEHICULO", $this->objectsHtml->GetobjectHtml($this->fields[capacidad]));

        $this->assign("NUMEROSOATVEHICULO", $this->objectsHtml->GetobjectHtml($this->fields[numero_soat]));
        $this->assign("ASEGURADORASOATVEHICULO", $this->objectsHtml->GetobjectHtml($this->fields[nombre_aseguradora]));

        $this->assign("VENCIMIENTOSOATVEHICULO", $this->objectsHtml->GetobjectHtml($this->fields[vencimiento_soat]));

        $this->assign("PLACAREMOLQUE", $this->objectsHtml->GetobjectHtml($this->fields[placa_remolque]));
        $this->assign("PLACAREMOLQUEID", $this->objectsHtml->GetobjectHtml($this->fields[placa_remolque_id]));
        $this->assign("CONDUCTORID", $this->objectsHtml->GetobjectHtml($this->fields[conductor_id]));
        $this->assign("NUMEROIDENTIFICACION", $this->objectsHtml->GetobjectHtml($this->fields[numero_identificacion]));
        $this->assign("NOMBRECONDUCTOR", $this->objectsHtml->GetobjectHtml($this->fields[nombre]));

        $this->assign("DIRECCIONCONDUCTOR", $this->objectsHtml->GetobjectHtml($this->fields[direccion_conductor]));
        $this->assign("CATEGORIALICENCIACONDUCTOR", $this->objectsHtml->GetobjectHtml($this->fields[categoria_licencia_conductor]));
        $this->assign("LICENCIACONDUCTOR", $this->objectsHtml->GetobjectHtml($this->fields[numero_licencia_cond]));
        $this->assign("TELEFONOCONDUCTOR", $this->objectsHtml->GetobjectHtml($this->fields[telefono_conductor]));
        $this->assign("MOVILCONDUCTOR", $this->objectsHtml->GetobjectHtml($this->fields[movil_conductor]));
        $this->assign("CIUDADCONDUCTOR", $this->objectsHtml->GetobjectHtml($this->fields[ciudad_conductor]));

        $this->assign("PROPIETARIO", $this->objectsHtml->GetobjectHtml($this->fields[propietario]));
        $this->assign("DOCIDENTIFICACIONPROPIETARIO", $this->objectsHtml->GetobjectHtml($this->fields[numero_identificacion_propietario]));
        $this->assign("DIRECCIONPROPIETARIO", $this->objectsHtml->GetobjectHtml($this->fields[direccion_propietario]));
        $this->assign("TELEFONOPROPIETARIO", $this->objectsHtml->GetobjectHtml($this->fields[telefono_propietario]));
        $this->assign("CIUDADPROPIETARIO", $this->objectsHtml->GetobjectHtml($this->fields[ciudad_propietario]));

        $this->assign("TENEDOR", $this->objectsHtml->GetobjectHtml($this->fields[tenedor]));
        $this->assign("TENEDORID", $this->objectsHtml->GetobjectHtml($this->fields[tenedor_id]));

        $this->assign("TIPOLIQUIDACION", $this->objectsHtml->GetobjectHtml($this->fields[tipo_liquidacion]));
        $this->assign("VALORFACTURAR", $this->objectsHtml->GetobjectHtml($this->fields[valor_facturar]));
        $this->assign("VALORUNIDADFACTURAR", $this->objectsHtml->GetobjectHtml($this->fields[valor_unidad_facturar]));

        $this->assign("DOCIDENTIFICACIONTENEDOR", $this->objectsHtml->GetobjectHtml($this->fields[numero_identificacion_tenedor]));
        $this->assign("DIRECCIONTENEDOR", $this->objectsHtml->GetobjectHtml($this->fields[direccion_tenedor]));
        $this->assign("TELEFONOTENEDOR", $this->objectsHtml->GetobjectHtml($this->fields[telefono_tenedor]));
        $this->assign("CIUDADTENEDOR", $this->objectsHtml->GetobjectHtml($this->fields[ciudad_tenedor]));

        //ANULACION

        $this->assign("FECHALOG", $this->objectsHtml->GetobjectHtml($this->fields[anul_orden_cargue]));
        $this->assign("USUARIOANULID", $this->objectsHtml->GetobjectHtml($this->fields[anul_usuario_id]));
        $this->assign("OBSERVACIONES", $this->objectsHtml->GetobjectHtml($this->fields[desc_anul_orden_cargue]));

        if ($this->Guardar) {
            $this->assign("GUARDAR", $this->objectsHtml->GetobjectHtml($this->fields[guardar]));
        }

        if ($this->Actualizar) {
            $this->assign("ACTUALIZAR", $this->objectsHtml->GetobjectHtml($this->fields[actualizar]));
            $this->assign("GENERARDOC", $this->objectsHtml->GetobjectHtml($this->fields[generar_doc]));

        }

        if ($this->Anular) {
            $this->assign("ANULAR", $this->objectsHtml->GetobjectHtml($this->fields[anular]));
        }

        if ($this->Limpiar) {
            $this->assign("LIMPIAR", $this->objectsHtml->GetobjectHtml($this->fields[limpiar]));
        }

        if ($this->Imprimir) {
            $this->assign("IMPRIMIR", $this->objectsHtml->GetobjectHtml($this->fields[imprimir]));
        }

    }

//LISTA MENU

    public function SetTiposServicio($TiposServicio)
    {
        $this->fields[tipo_servicio_id][options] = $TiposServicio;
        $this->assign("SERVICIO", $this->objectsHtml->GetobjectHtml($this->fields[tipo_servicio_id]));
    }
    public function SetUnidadesVolumen($TiposVolumen)
    {
        $this->fields[unidad_volumen_id][options] = $TiposVolumen;
        $this->assign("VOLUMEN", $this->objectsHtml->GetobjectHtml($this->fields[unidad_volumen_id]));
    }

    public function SetTipoEmpaque($TipoEmpaque)
    {
        $this->fields[empaque_id]['options'] = $TipoEmpaque;
        $this->assign("UNIDADEMPAQUE", $this->objectsHtml->GetobjectHtml($this->fields[empaque_id]));
    }
    public function SetUnidades($TiposUnidades)
    {
        $this->fields[unidad_peso_id][options] = $TiposUnidades;
        $this->assign("PESO", $this->objectsHtml->GetobjectHtml($this->fields[unidad_peso_id]));
    }

//// GRID ////
    public function SetGridOrdenCargue($Attributes, $Titles, $Cols, $Query)
    {
        require_once "../../../framework/clases/grid/JqGridClass.php";
        $TableGrid = new JqGrid();
        $TableGrid->SetJqGrid($Attributes, $Titles, $Cols, $Query);
        $this->assign("GRIDOrdenCargue", $TableGrid->RenderJqGrid());
        $this->assign("TABLEGRIDCSS", $TableGrid->GetJqGridCss());
        $this->assign("TABLEGRIDJS", $TableGrid->GetJqGridJs());
    }

    public function RenderMain()
    {
        $this->RenderLayout('OrdenCargue.tpl');
    }
}
