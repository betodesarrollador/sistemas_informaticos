<?php

require_once "../../../framework/clases/ControlerClass.php";

final class DetallesContables extends Controler
{

    public function __construct()
    {

        parent::__construct(3);

    }

    public function Main()
    {

        $this->noCache();

        require_once "DetallesContablesLayoutClass.php";
        require_once "DetallesContablesModelClass.php";

        $Layout = new DetallesContablesLayout();
        $Model = new DetallesContablesModel();
        $factura_id = $_REQUEST['factura_id'];
        $encabezado_registro_id = $_REQUEST['encabezado_registro_id'];

        $empresa_id = $this->getEmpresaId();
        $oficina_id = $this->getOficinaId();

        $Layout->setIncludes();
        $Layout->setImputacionesContables($Model->getImputacionesContables($factura_id, $encabezado_registro_id,  $this->getConex()));

        $Layout->RenderMain();
    }

    protected function onclickValidateRow()
    {
        require_once "../../../framework/clases/ValidateRowClass.php";
        $Data = new ValidateRow($this->getConex(), $this->Campos);
        print json_encode($Data->GetData());
    }

}

$Detalles = new DetallesContables();
