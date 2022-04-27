<?php

require_once "../../../framework/clases/ControlerClass.php";

final class reporteActividad extends Controler
{

    public function __construct()
    {
        parent::__construct(2);
    }

    public function Main()
    {
        $this->noCache();

        require_once "reporteActividadLayoutClass.php";
        require_once "reporteActividadModelClass.php";

        $Layout = new reporteActividadLayout($this->getTitleTab(), $this->getTitleForm());
        $Model = new reporteActividadModel();

        $Model->SetUsuarioId($this->getUsuarioId(), $this->getOficinaId());

        $Layout->setGuardar($Model->getPermiso($this->getActividadId(), 'INSERT', $this->getConex()));

        $Layout->setDB($Model->getDB($this->getConex()));

        //LISTA MENU

        $Layout->setCampos($this->Campos);

        $Layout->SetTipo($Model->GetTipo($this->getConex()));

        //// GRID ////

        $Layout->RenderMain();

    }

    protected function OnclickGenerar()
    {
        die("sdff");
        require_once "reporteActividadModelClass.php";
        $Model = new reporteActividadModel();

        $desde = $_REQUEST['desde'];
        $hasta = $_REQUEST['hasta'];
        $tipo = $_REQUEST['tipo'];

        if ($tipo == 'VF') {
            $consulta = "SELECT factura_id, estado, fecha, SUM(valor) FROM `factura` WHERE estado = 'C' AND fecha BETWEEN '$desde' AND '$hasta'";
            die($tipo);
        }elseif ($tipo == 'IN') {
            $consulta = "SELECT SUM(rel_valor_abono) FROM `relacion_abono` WHERE factura_id IN(SELECT factura_id FROM `factura` WHERE estado = 'C' AND fecha BETWEEN '$desde' AND '$hasta')";
            die($tipo);

        }elseif($tipo == 'VP'){
            $consulta = "SELECT factura_proveedor_id, estado_factura_proveedor, fecha_factura_proveedor, SUM(valor_factura_proveedor) FROM `factura_proveedor` WHERE estado_factura_proveedor = 'C' AND fecha_factura_proveedor BETWEEN '$desde' AND '$hasta";
            die($tipo);

        }elseif($tipo == 'GA'){
            $consulta = "SELECT SUM(rel_valor_abono_factura) FROM `relacion_abono_factura` WHERE factura_proveedor_id IN (SELECT factura_proveedor_id FROM `factura_proveedor` WHERE estado_factura_proveedor = 'C' AND fecha_factura_proveedor BETWEEN '$desde' AND '$hasta')";
                die($tipo);

        }

        $data = $Model->getGenerar($this->getConex(), $this->getUsuarioId());

        print $data;
    }

    protected function setCampos()
    {

        //campos formulario

        //botones

        $this->Campos[generar] = array(
            name => 'generar',
            id => 'generar',
            type => 'button',
            value => 'Generar',
            onclick => 'OnclickGenerar(this.form)',
        );

        $this->Campos[descargar] = array(
            name => 'descargar',
            id => 'descargar',
            type => 'button',
            value => 'Descargar Excel Formato',
            //onclick => 'descargarexcel(this.form)',
        );

        $this->Campos[generar_excel] = array(
            name => 'generar_excel',
            id => 'generar_excel',
            type => 'button',
            value => 'Descargar Excel',
        );

        //campos

        $this->Campos[tipo] = array(
            name => 'tipo',
            id => 'tipo',
            type => 'select',
            options => null,
            selected => 0,
            required => 'yes',
        );

        $this->Campos[si_cliente] = array(
            name => 'si_cliente',
            id => 'si_cliente',
            type => 'select',
            options => null,
            selected => 0,
            //required => 'yes',
            onchange => 'Cliente_si();',
        );

        $this->Campos[cliente_id] = array(
            name => 'cliente_id',
            id => 'cliente_id',
            type => 'hidden',
            value => '',
            datatype => array(
                type => 'integer',
                length => '20'),
        );

        $this->Campos[cliente] = array(
            name => 'cliente',
            id => 'cliente',
            type => 'text',
            disabled => 'disabled',
            suggest => array(
                name => 'cliente',
                setId => 'cliente_id'),
        );

        $this->Campos[desde] = array(
            name => 'desde',
            id => 'desde',
            type => 'text',
            required => 'yes',
            datatype => array(
                type => 'date',
                length => '10'),
        );

        $this->Campos[hasta] = array(
            name => 'hasta',
            id => 'hasta',
            type => 'text',
            required => 'yes',
            datatype => array(
                type => 'date',
                length => '10'),
        );

        $this->SetVarsValidate($this->Campos);
    }

}

$reporteActividad = new reporteActividad();
