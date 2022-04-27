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

        require_once "DetallesModelClass.php";

        $Model = new DetallesModel();

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
        require_once "DetallesModelClass.php";
        $Model = new DetallesModel();
        $Model->Update($this->Campos, $this->getConex());

        if (strlen(trim($Model->GetError())) > 0) {
            exit("Error : " . $Model->GetError());
        } else {
            exit("true");
        }

    }

    protected function onclickDelete()
    {

        require_once "DetallesModelClass.php";

        $Model = new DetallesModel();

        $Model->Delete($this->Campos, $this->getConex());

        if (strlen(trim($Model->GetError())) > 0) {
            exit("Error : " . $Model->GetError());
        } else {
            exit("true");
        }

    }

}

$Detalles = new Detalles();
