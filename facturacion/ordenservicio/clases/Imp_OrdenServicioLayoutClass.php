<?php

require_once "../../../framework/clases/ViewClass.php";

final class Imp_OrdenServicioLayout extends View
{

    private $fields;

    public function setIncludes()
    {

        $this->TplInclude->IncludeCss("../../../framework/css/reset.css");

        $this->assign("CSSSYSTEM", $this->TplInclude->GetCssInclude());

    }

    public function setOrdenServicio($ordenservicio)
    {
        $this->assign("FECHA", date("Y-m-d"));
        $this->assign("DATOSORDENSERVICIO", $ordenservicio[0]);
    }

    public function setitemOrdenServicio($itemordenservicio)
    {
        $this->assign("ITEMORDENSERVICIO", $itemordenservicio);
    }
    public function setliqOrdenServicio($liqordenservicio)
    {
        $this->assign("LIQORDENSERVICIO", $liqordenservicio);
    }

    public function set_num_itemOrdenServicio($num_itemordenservicio)
    {
        $this->assign("NUMITEM_ORDENSERVICIO", $num_itemordenservicio[0]);
    }
    public function set_num_liqOrdenServicio($num_liqordenservicio)
    {
        $this->assign("NUMLIQ_ORDENSERVICIO", $num_liqordenservicio[0]);
    }

    public function set_val_itemOrdenServicio($val_itemordenservicio)
    {
        $this->assign("VALITEM_ORDENSERVICIO", $val_itemordenservicio[0]);
    }
    public function set_val_liqOrdenServicio($val_liqordenservicio)
    {
        $this->assign("VALLIQ_ORDENSERVICIO", $val_liqordenservicio[0]);
    }

    public function set_tot_pucServicio($tot_pucServicio)
    {
        $this->assign("TOTPUC_ORDENSERVICIO", $tot_pucServicio[0]);
    }

    public function set_pucServicio($pucServicio)
    {
        $this->assign("PUC_ORDENSERVICIO", $pucServicio);
    }

    public function RenderMain()
    {
        $this->RenderLayout('Imp_OrdenServicio.tpl');
        //$this -> exportToPdf('Imp_OrdenServicio.tpl','ordenCompra');

    }

}
