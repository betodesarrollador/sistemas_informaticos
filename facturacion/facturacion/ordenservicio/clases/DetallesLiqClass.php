<?php

require_once "../../../framework/clases/ControlerClass.php";

final class DetallesLiq extends Controler
{

    public function __construct()
    {

        parent::__construct(3);

    }

    public function Main()
    {

        $this->noCache();

        require_once "DetallesLiqLayoutClass.php";
        require_once "DetallesLiqModelClass.php";

        $Layout = new DetallesLiqLayout();
        $Model = new DetallesLiqModel();
        $orden_servicio_id = $_REQUEST['orden_servicio_id'];

        $Layout->setIncludes();
        $Layout->setDetalles($Model->getDetalles($orden_servicio_id, $this->getConex()));

        $Layout->RenderMain();

    }

    protected function onclickValidateRow()
    {
        require_once "../../../framework/clases/ValidateRowClass.php";
        $Data = new ValidateRow($this->getConex(), $this->Campos);
        $this->getArrayJSON($Data->GetData());
    }

    protected function onclickSave()
    {

        require_once "DetallesLiqModelClass.php";

        $Model = new DetallesLiqModel();

        $return = $Model->Save($this->getUsuarioId(), $this->Campos, $this->getConex());

        if (strlen(trim($Model->GetError())) > 0) {
            exit("Error : " . $Model->GetError());
        } else {
            if (is_numeric($return)) {
                exit("$return");
            } else {
                exit('false');
            }
        }

    }

    protected function onclickUpdate()
    {
        require_once "DetallesLiqModelClass.php";
        $Model = new DetallesLiqModel();
        $Model->Update($this->Campos, $this->getConex());

        if (strlen(trim($Model->GetError())) > 0) {
            exit("Error : " . $Model->GetError());
        } else {
            exit("true");
        }

    }

    protected function onclickDelete()
    {

        require_once "DetallesLiqModelClass.php";

        $Model = new DetallesLiqModel();

        $Model->Delete($this->Campos, $this->getConex());

        if (strlen(trim($Model->GetError())) > 0) {
            exit("Error : " . $Model->GetError());
        } else {
            exit("true");
        }

    }

}

$DetallesLiq = new DetallesLiq();
