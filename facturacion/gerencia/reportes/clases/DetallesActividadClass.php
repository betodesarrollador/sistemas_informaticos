<?php

require_once "../../../framework/clases/ControlerClass.php";
final class DetallesActividad extends Controler
{

    public function __construct()
    {
        parent::__construct(3);
    }

    public function Main($numero_identificacion, $email)
    {

        $this->noCache();

        require_once "DetallesActividadLayoutClass.php";
        require_once "DetallesActividadModelClass.php";

        $Layout = new DetallesActividadLayout();
        $Model = new DetallesActividadModel();

        $desde = $_REQUEST['desde'];
        $hasta = $_REQUEST['hasta'];
        $tipo = $_REQUEST['tipo'];
 

        if ($tipo == 'VF') {
			$consulta = "SELECT COUNT(factura_id) AS num_factura, SUM(valor) AS valor_facturado, 
            SUBSTRING_INDEX(DATABASE(), '_', -1) AS empresa FROM factura WHERE estado = 'C' AND fecha BETWEEN '$desde' AND '$hasta' HAVING COUNT(num_factura) > 1";
			
        } elseif ($tipo == 'IN') {

            $consulta = "SELECT SUM(rel_valor_abono) AS valor_ingreso, SUBSTRING_INDEX(DATABASE(), '_', -1) AS empresa FROM relacion_abono WHERE factura_id IN(SELECT factura_id FROM factura WHERE estado = 'C' AND fecha BETWEEN '$desde' AND '$hasta')"; //die($consulta);

        } elseif ($tipo == 'VP') {
            $consulta = "SELECT COUNT(factura_proveedor_id) AS num_factura,SUM(valor_factura_proveedor) AS valor_facturado, SUBSTRING_INDEX(DATABASE(), '_', -1) AS empresa FROM factura_proveedor WHERE estado_factura_proveedor = 'C' AND fecha_factura_proveedor BETWEEN '$desde' AND '$hasta' HAVING COUNT(num_factura) > 1";

        } elseif ($tipo == 'GA') {
            $consulta = "SELECT SUM(rel_valor_abono_factura) AS valor_gasto, SUBSTRING_INDEX(DATABASE(), '_', -1) AS empresa FROM relacion_abono_factura WHERE factura_proveedor_id IN (SELECT factura_proveedor_id FROM `factura_proveedor` WHERE estado_factura_proveedor = 'C' AND fecha_factura_proveedor BETWEEN '$desde' AND '$hasta')";
        }

        $Layout->setIncludes();

        $Layout -> setReporte($Model->getReporte($consulta, $this->getConex()));    

        $Layout->RenderMain();

    }


}

$DetallesActividad = new DetallesActividad();
