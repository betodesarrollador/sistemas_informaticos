<?php

require_once "../../framework/clases/ControlerClass.php";

final class reporteCuentasFP extends Controler
{

    public function __construct()
    {

        parent::__construct(3);

    }

    public function Main()
    {

        $this->noCache();

        require_once "reporteCuentasFPLayoutClass.php";
        require_once "reporteCuentasFPModelClass.php";

        $Layout = new reporteCuentasFPLayout($this->getTitleTab(), $this->getTitleForm());
        $Model = new reporteCuentasFPModel();

        $Model->SetUsuarioId($this->getUsuarioId(), $this->getOficinaId());

        $Layout->setImprimir($Model->getPermiso($this->getActividadId(), 'PRINT', $this->getConex()));

        $Layout->SetCampos($this->Campos);
        //LISTA MENU
        $Layout->SetOficina($Model->GetOficina($this->getConex()));
        $Layout->SetTipo($Model->GetTipo($this->getConex()));
        $Layout->SetSi_Pro($Model->GetSi_Pro($this->getConex()));

        $Layout->RenderMain();

    }

    protected function generateFileexcel()
    {

        require_once "reporteCuentasFPModelClass.php";

        $Model = new reporteCuentasFPModel();
        $desde = $_REQUEST['desde'];
        $hasta = $_REQUEST['hasta'];
        $tipo = $_REQUEST['tipo'];
        $oficina_id = $_REQUEST['oficina_id'];
        $si_cliente = $_REQUEST['si_cliente'];
        $si_comercial = $_REQUEST['si_comercial'];
        $cliente_id = $_REQUEST['cliente_id'];
        $all_oficina = $_REQUEST['all_oficina'];
        $saldos = $_REQUEST['saldos'];
        $fecha_corte = $_REQUEST['fecha_corte'];
        if ($saldos == 'S') {
            $saldos = " AND ab.fecha BETWEEN '" . $desde . "'  AND  '" . $hasta . "' ";
            $fecha_corte = "(SELECT DATEDIFF('" . $fecha_corte . "',f.vencimiento)) as dias,";
        } else {
            $saldos = '';
            $fecha_corte = '';
        }

        if ($tipo == 'FP') {
            $nombre = 'Fac_Pend' . date('Ymd');
        } elseif ($tipo == 'RF') {
            $nombre = 'Rel_Fac' . date('Ymd');
        } elseif ($tipo == 'EC') {
            $nombre = 'Est_Car' . date('Ymd');
        } elseif ($tipo == 'PE') {
            $nombre = 'Car_Edad' . date('Ymd');
        } elseif ($tipo == 'RE') {
            $nombre = 'Rec_audos' . date('Ymd');
        }

        if ($tipo == 'FP' && $si_cliente == 1) {
            $data = $Model->getReporteFP1($oficina_id, $desde, $hasta, $cliente_id, $saldos, $this->getConex());
        } elseif ($tipo == 'RF' && $si_cliente == 1) {
            $data = $Model->getReporteRF1($oficina_id, $desde, $hasta, $cliente_id, $saldos, $this->getConex());
        } elseif ($tipo == 'RE' && $si_cliente == 1) {
            $data = $Model->getReporteRE1($oficina_id, $desde, $hasta, $cliente_id, $saldos, $this->getConex());
        } elseif ($tipo == 'EC' && $si_cliente == 1) {
            $data = $Model->getReporteEC1($oficina_id, $desde, $hasta, $cliente_id, $saldos, $this->getConex());
        } elseif ($tipo == 'PE' && $si_cliente == 1) {
            $data = $Model->getReportePE1($oficina_id, $desde, $hasta, $cliente_id, $saldos, $this->getConex());
        }

//----------------------------------FILTRO COMERCIAL INICIO
        elseif ($tipo == 'FP' && $si_comercial == 1) {
            $data = $Model->getReporteFP1($oficina_id, $desde, $hasta, $comercial_id, $saldos, $this->getConex());
        } elseif ($tipo == 'RF' && $si_comercial == 1) {
            $data = $Model->getReporteRF1($oficina_id, $desde, $hasta, $comercial_id, $saldos, $this->getConex());
        } elseif ($tipo == 'RE' && $si_comercial == 1) {
            $data = $Model->getReporteRE1($oficina_id, $desde, $hasta, $comercial_id, $saldos, $this->getConex());
        } elseif ($tipo == 'PE' && $si_comercial == 1) {
            $data = $Model->getReportePE1($oficina_id, $desde, $hasta, $comercial_id, $saldos, $this->getConex());
        }

//-------------------------------FILTRO COMERCIAL FIN
        elseif ($tipo == 'FP' && $si_cliente == 'ALL') {
            $data = $Model->getReporteFP_ALL($oficina_id, $desde, $hasta, $saldos, $this->getConex());
        } elseif ($tipo == 'RF' && $si_cliente == 'ALL') {
            $data = $Model->getReporteRF_ALL($oficina_id, $desde, $hasta, $saldos, $this->getConex());
        } elseif ($tipo == 'EC' && $si_cliente == 'ALL') {
            $data = $Model->getReporteEC_ALL($oficina_id, $desde, $hasta, $saldos, $this->getConex());
        } elseif ($tipo == 'PE' && $si_cliente == 'ALL') {
            $data = $Model->getReportePE_ALL($oficina_id, $desde, $hasta, $saldos, $this->getConex());
        } elseif ($tipo == 'RE' && $si_cliente == 'ALL') {
            $data = $Model->getReporteRE_ALL($oficina_id, $desde, $hasta, $saldos, $this->getConex());
        }

        $ruta = $this->arrayToExcel("reporteCuentasFP", $tipo, $data, null);

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
            required => 'yes',
            multiple => 'yes',
        );

        $this->Campos[tipo] = array(
            name => 'tipo',
            id => 'tipo',
            type => 'select',
            options => null,
            required => 'yes',
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

        $this->Campos[si_cliente] = array(
            name => 'si_cliente',
            id => 'si_cliente',
            type => 'select',
            options => null,
            selected => 0,
            required => 'yes',
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

        $this->Campos[all_oficina] = array(
            name => 'all_oficina',
            id => 'all_oficina',
            type => 'checkbox',
            onclick => 'all_oficce();',
            value => 'NO',
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
            value => 'Descargar Excel Formato',
            onclick => 'descargarexcel(this.form)',
        );

        $this->Campos[generar_excel] = array(
            name => 'generar_excel',
            id => 'generar_excel',
            type => 'button',
            value => 'Descargar Excel',
        );

        $this->Campos[imprimir] = array(
            name => 'imprimir',
            id => 'imprimir',
            type => 'print',
            disabled => 'disabled',
            value => 'Imprimir',
            displayoptions => array(
                form => 0,
                beforeprint => 'beforePrint',
                title => 'Impresion Reporte',
                width => '800',
                height => '600',
            ));

        $this->SetVarsValidate($this->Campos);
    }

}

$reporteCuentasFP = new reporteCuentasFP();
