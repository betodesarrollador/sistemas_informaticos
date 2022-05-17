<?php

require_once "../../../framework/clases/ControlerClass.php";

final class MySql extends Controler
{
    public function __construct()
    {
        parent::__construct(2);
    }

    public function Main()
    {
        $this->noCache();

        require_once "MySqlLayoutClass.php";

        require_once "MySqlModelClass.php";

        $Layout = new MySqlLayout($this->getTitleTab(), $this->getTitleForm());

        $Model = new MySqlModel();

        $Model->SetUsuarioId($this->getUsuarioId(), $this->getOficinaId());

        $Layout->setGuardar($Model->getPermiso($this->getActividadId(), 'INSERT', $this->getConex()));

        $Layout->setDB($Model->getDB($this->getConex()));

        //LISTA MENU

        $Layout->setCampos($this->Campos);

        //// GRID ////

        $Layout->RenderMain();
    }

    protected function ejecutarQuery()
    {
        require_once "MySqlModelClass.php";

        $Model = new MySqlModel();

        $data = $Model->ejecutarQuery($this->getConex(), $this->getUsuarioId());

        print $data;
    }

    protected function manejoEmpresa() {
        require_once "MySqlModelClass.php";

        $Model = new MySqlModel();

        $cliente_id         = $_REQUEST["cliente_id"];
        $estado_empresa     = $_REQUEST["estado_empresa"];

        $data = $Model->manejoEmpresa($this->getConex(), $cliente_id, $estado_empresa);

        print $data;


    }

    protected function setCampos()
    {
        //campos formulario

        //botones

        $this->Campos[ejecutar] = [
            name => 'ejecutar',

            id => 'ejecutar',

            type => 'button',

            value => 'EJECUTAR',

            onclick => 'ejecutarQuery()',
        ];

        $this->Campos[query] = [
            name => 'query',

            id => 'query',

            type => 'textarea',

            text_uppercase => 'no',

            cols => "120",

            rows => "20",
        ];

        $this->SetVarsValidate($this->Campos);
    }    
}

$tipo_campana = new MySql();

?>
