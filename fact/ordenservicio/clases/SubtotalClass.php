<?php

require_once "../../../framework/clases/ControlerClass.php";

final class Subtotal extends Controler
{

    public function __construct()
    {

        parent::__construct(3);

    }

    public function Main()
    {

        $this->noCache();

        require_once "SubtotalLayoutClass.php";
        require_once "SubtotalModelClass.php";

        $Layout = new SubtotalLayout();
        $Model = new SubtotalModel();
        $orden_servicio_id = $_REQUEST['orden_servicio_id'];
        $empresa_id = $this->getEmpresaId();
        $oficina_id = $this->getOficinaId();

        $Layout->setIncludes();
        $Layout->setDetalles($Model->getDetalles($orden_servicio_id, $empresa_id, $oficina_id, $this->getConex()));
        $Layout->RenderMain();

    }

    protected function onclickValidateRow()
    {
        require_once "../../../framework/clases/ValidateRowClass.php";
        $Data = new ValidateRow($this->getConex(), $this->Campos);
        $this->getArrayJSON($Data->GetData());
    }

}

$Subtotal = new Subtotal();
