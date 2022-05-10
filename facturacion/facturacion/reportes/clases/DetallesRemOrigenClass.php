<?php

require_once "../../../framework/clases/ControlerClass.php";
final class Detalles extends Controler
{

    public function __construct()
    {
        parent::__construct(3);
    }

    public function Main()
    {

        $this->noCache();

        require_once "DetallesRemOrigenLayoutClass.php";
        require_once "DetallesRemOrigenModelClass.php";

        $Layout = new DetallesRemOrigenLayout();
        $Model = new DetallesRemOrigenModel();
        $desde = $_REQUEST['desde'];
        $hasta = $_REQUEST['hasta'];
        $origen = $_REQUEST['origen_id'];

        $Layout->setIncludes();

        $Layout->setReporteRemOrigen($Model->getReporteRemOrigen($desde, $hasta, $origen, $this->getConex()));

        $download = $this->requestData('download');

        if ($download == 'true') {
            $Layout->exportToExcel('detallesRemOrigen.tpl');
        } else {
            $Layout->RenderMain();
        }

    }
}

$Detalles = new Detalles();
