<?php

require_once "../../../framework/clases/ControlerClass.php";

final class Reportes extends Controler
{

    public function __construct()
    {

        parent::__construct(3);

    }

    public function Main()
    {

        $this->noCache();

        require_once "ReportesRemOrigenLayoutClass.php";
        require_once "ReportesRemOrigenModelClass.php";

        $Layout = new ReportesRemOrigenLayout($this->getTitleTab(), $this->getTitleForm());
        $Model = new ReportesRemOrigenModel();

        $Model->SetUsuarioId($this->getUsuarioId(), $this->getOficinaId());
        $Layout->setLimpiar($Model->getPermiso($this->getActividadId(), 'CLEAR', $this->getConex()));
        $Layout->setImprimir($Model->getPermiso($this->getActividadId(), 'PRINT', $this->getConex()));

        $Layout->SetCampos($this->Campos);

        $Layout->RenderMain();

    }

/*
protected function onclickPrint(){
require_once("Imp_DocumentoClass.php");
$print = new Imp_Documento();
$print -> printOut($this -> getConex());

}*/

    protected function generateFileexcel()
    {

        require_once "ReportesRemOrigenModelClass.php";

        $Model = new ReportesRemOrigenModel();
        $desde = $_REQUEST['desde'];
        $hasta = $_REQUEST['hasta'];
        if ($saldos == 'S') {
            $saldos = " AND ab.fecha BETWEEN '" . $desde . "'  AND  '" . $hasta . "' ";
        } else {
            $saldos = '';
        }

        if ($tipo == 'FP') {
            $nombre = 'Fac_Pend' . date('Ymd');
        } elseif ($tipo == 'RF') {
            $nombre = 'Rel_Fac' . date('Ymd');
        } elseif ($tipo == 'EC') {
            $nombre = 'Est_Car' . date('Ymd');
        } elseif ($tipo == 'PE') {
            $nombre = 'Car_Edad' . date('Ymd');
        }

        if ($tipo == 'FP' && $si_cliente == 1) {
            $data = $Model->getReporteFP1($oficina_id, $desde, $hasta, $cliente_id, $saldos, $this->getConex());
        } elseif ($tipo == 'RF' && $si_cliente == 1) {
            $data = $Model->getReporteRF1($oficina_id, $desde, $hasta, $cliente_id, $saldos, $this->getConex());
        } elseif ($tipo == 'EC' && $si_cliente == 1) {
            $data = $Model->getReporteEC1($oficina_id, $desde, $hasta, $cliente_id, $saldos, $this->getConex());
        } elseif ($tipo == 'PE' && $si_cliente == 1) {
            $data = $Model->getReportePE1($oficina_id, $desde, $hasta, $cliente_id, $saldos, $this->getConex());
        } elseif ($tipo == 'FP' && $si_cliente == 'ALL') {
            $data = $Model->getReporteFP_ALL($oficina_id, $desde, $hasta, $saldos, $this->getConex());
        } elseif ($tipo == 'RF' && $si_cliente == 'ALL') {
            $data = $Model->getReporteRF_ALL($oficina_id, $desde, $hasta, $saldos, $this->getConex());
        } elseif ($tipo == 'EC' && $si_cliente == 'ALL') {
            $data = $Model->getReporteEC_ALL($oficina_id, $desde, $hasta, $saldos, $this->getConex());
        } elseif ($tipo == 'PE' && $si_cliente == 'ALL') {
            $data = $Model->getReportePE_ALL($oficina_id, $desde, $hasta, $saldos, $this->getConex());
        }

        $ruta = $this->arrayToExcel("Reportes", $tipo, $data, null, "string");

        $this->ForceDownload($ruta, $nombre . '.xls');

    }

    protected function SetCampos()
    {

        /********************
        Campos causar
         ********************/

        $this->Campos[oficina_id] = array(
            name => 'oficina_id',
            id => 'oficina_id',
            type => 'select',
            Boostrap => 'si',
            required => 'yes',
            multiple => 'yes',
        );

        $this->Campos[desde] = array(
            name => 'desde',
            id => 'desde',
            type => 'text',
            Boostrap => 'si',
            required => 'yes',
            datatype => array(
                type => 'date',
                length => '10'),
        );

        $this->Campos[hasta] = array(
            name => 'hasta',
            id => 'hasta',
            type => 'text',
            Boostrap => 'si',
            required => 'yes',
            datatype => array(
                type => 'date',
                length => '10'),
        );

        $this->Campos[origen] = array(
            name => 'origen',
            id => 'origen',
            type => 'text',
            Boostrap => 'si',
            suggest => array(
                name => 'ciudad',
                setId => 'origen_hidden',
                onclick => 'setObservaciones'),
        );

        $this->Campos[origen_id] = array(
            name => 'origen_id',
            id => 'origen_hidden',
            type => 'hidden',
            required => 'yes',
            value => '',
            datatype => array(
                type => 'integer',
                length => '20'),
            transaction => array(
                table => array('remesa'),
                type => array('column')),
        );

        /**********************************
        Botones
         **********************************/

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
            value => 'Descargar Excel',
            onclick => 'descargarexcel(this.form)',
        );

        $this->Campos[limpiar] = array(
            name => 'limpiar',
            id => 'limpiar',
            type => 'reset',
            value => 'Limpiar',
            //tabindex=>'22',
            onclick => 'usuarioOnReset(this.form)',
        );

        $this->Campos[imprimir] = array(
            name => 'imprimir',
            id => 'imprimir',
            type => 'button',
            value => 'Imprimir',
            onclick => 'beforePrint(this.form)',
        );

        $this->SetVarsValidate($this->Campos);
    }

}

$Reportes = new Reportes();
