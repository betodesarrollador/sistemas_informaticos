<?php

final class Imp_OrdenServicio
{

    private $Conex;

    public function __construct()
    {

         

    }

    public function printOut()
    {

        require_once "Imp_OrdenServicioLayoutClass.php";
        require_once "Imp_OrdenServicioModelClass.php";

        $Layout = new Imp_OrdenServicioLayout();
        $Model = new Imp_OrdenServicioModel();

        $Layout->setIncludes();

        $Layout->setOrdenServicio($Model->getOrdenServicio($this->Conex));
        $Layout->setitemOrdenServicio($Model->getitemOrdenServicio($this->Conex));
        $Layout->setliqOrdenServicio($Model->getliqOrdenServicio($this->Conex));

        $Layout->set_num_itemOrdenServicio($Model->get_num_itemOrdenServicio($this->Conex));
        $Layout->set_num_liqOrdenServicio($Model->get_num_liqOrdenServicio($this->Conex));

        $Layout->set_val_itemOrdenServicio($Model->get_val_itemOrdenServicio($this->Conex));
        $Layout->set_val_liqOrdenServicio($Model->get_val_liqOrdenServicio($this->Conex));

        $Layout->set_tot_pucServicio($Model->get_tot_pucServicio($this->Conex));
        $Layout->set_pucServicio($Model->get_pucServicio($this->Conex));

        $Layout->RenderMain();

    }

}

new Imp_OrdenServicio();
