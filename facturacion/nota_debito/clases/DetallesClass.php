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

        require_once "DetallesLayoutClass.php";
        require_once "DetallesModelClass.php";

        $Layout = new DetallesLayout();
        $Model = new DetallesModel();
        $factura_id = $_REQUEST['factura_id'];
        $fuente_facturacion_cod = $_REQUEST['fuente_facturacion_cod'];

        $empresa_id = $this->getEmpresaId();
        $oficina_id = $this->getOficinaId();

        $Layout->setIncludes();
        $Layout->setImputacionesContables($Model->getImputacionesContables($factura_id, $fuente_facturacion_cod, $empresa_id, $oficina_id, $this->getConex()));

        $Layout->RenderMain();

    }

    protected function onclickValidateRow()
    {
        require_once "../../../framework/clases/ValidateRowClass.php";
        $Data = new ValidateRow($this->getConex(), $this->Campos);
        print json_encode($Data->GetData());
    }

}

$Detalles = new Detalles();
