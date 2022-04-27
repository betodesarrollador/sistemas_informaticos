<?php

require_once "../../../framework/clases/DbClass.php";
require_once "../../../framework/clases/PermisosFormClass.php";

final class Imp_OrdenServicioModel extends Db
{

    public function getOrdenServicio($Conex)
    {

        $orden_servicio_id = $this->requestData('orden_servicio_id', 'integer');

        if (is_numeric($orden_servicio_id)) {

            $empresa_id = $_SESSION['oficina']['empresa_id'];
            $oficina_id = $_REQUEST['oficina']['oficina_id'];

            $select = "SELECT (SELECT logo AS logos FROM empresa WHERE empresa_id = of.empresa_id) AS logo,(SELECT razon_social FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id)) AS razon_social,(SELECT sigla FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id)) AS sigla, (SELECT numero_identificacion FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id)) AS  numero_identificacion,(SELECT direccion FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id)) AS direccion,(SELECT nombre FROM ubicacion WHERE ubicacion_id = (SELECT ubicacion_id FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id))) AS ciudad,
		t.*,
		p.*,
		(SELECT  nombre_bien_servicio_factura FROM  tipo_bien_servicio_factura WHERE tipo_bien_servicio_factura_id=o.tipo_bien_servicio_factura_id ) AS servicio,
		(SELECT  nombre FROM  forma_compra_venta WHERE forma_compra_venta_id =o.forma_compra_venta_id ) AS forma_compra,
		(SELECT  nombre FROM  centro_de_costo WHERE centro_de_costo_id =o.centro_de_costo_id ) AS centro_costo,
		(SELECT  nombre FROM  ubicacion WHERE ubicacion_id =t.ubicacion_id ) AS ciudad,
		of.nombre AS nom_oficina,
		o.fecha_orden_servicio,
		o.descrip_orden_servicio,
		o.consecutivo,
		o.estado_orden_servicio
        FROM orden_servicio o, oficina of, cliente p, tercero t WHERE o.orden_servicio_id = $orden_servicio_id AND of.oficina_id=o.oficina_id AND p.cliente_id=o.cliente_id  AND t.tercero_id=p.tercero_id";

            $result = $this->DbFetchAll($select, $Conex);

        } else {
            $result = array();
        }
        return $result;
    }

    public function getitemOrdenServicio($Conex)
    {

        $orden_servicio_id = $this->requestData('orden_servicio_id', 'integer');

        if (is_numeric($orden_servicio_id)) {

            $select = "SELECT *
         FROM item_orden_servicio  WHERE orden_servicio_id = $orden_servicio_id ";

            $result = $this->DbFetchAll($select, $Conex);

        } else {
            $result = array();
        }
        return $result;
    }

    public function getliqOrdenServicio($Conex)
    {

        $orden_servicio_id = $this->requestData('orden_servicio_id', 'integer');

        if (is_numeric($orden_servicio_id)) {

            $select = "SELECT *
         FROM item_liquida_servicio  WHERE orden_servicio_id = $orden_servicio_id ";

            $result = $this->DbFetchAll($select, $Conex);

        } else {
            $result = array();
        }
        return $result;
    }

    public function get_num_itemOrdenServicio($Conex)
    {

        $orden_servicio_id = $this->requestData('orden_servicio_id', 'integer');

        if (is_numeric($orden_servicio_id)) {

            $select = "SELECT COUNT(*) AS total_item
         FROM item_orden_servicio  WHERE orden_servicio_id = $orden_servicio_id ";

            $result = $this->DbFetchAll($select, $Conex);

        } else {
            $result = array();
        }
        return $result;
    }

    public function get_num_liqOrdenServicio($Conex)
    {

        $orden_servicio_id = $this->requestData('orden_servicio_id', 'integer');

        if (is_numeric($orden_servicio_id)) {

            $select = "SELECT COUNT(*) AS total_liq
         FROM item_liquida_servicio  WHERE orden_servicio_id = $orden_servicio_id ";

            $result = $this->DbFetchAll($select, $Conex);

        } else {
            $result = array();
        }
        return $result;
    }

    public function get_val_itemOrdenServicio($Conex)
    {

        $orden_servicio_id = $this->requestData('orden_servicio_id', 'integer');

        if (is_numeric($orden_servicio_id)) {

            $select = "SELECT SUM(cant_item_orden_servicio*valoruni_item_orden_servicio) AS valor_item
         FROM item_orden_servicio  WHERE orden_servicio_id = $orden_servicio_id ";

            $result = $this->DbFetchAll($select, $Conex);

        } else {
            $result = array();
        }
        return $result;
    }

    public function get_val_liqOrdenServicio($Conex)
    {

        $orden_servicio_id = $this->requestData('orden_servicio_id', 'integer');

        if (is_numeric($orden_servicio_id)) {

            $select = "SELECT SUM(cant_item_liquida_servicio*valoruni_item_liquida_servicio) AS valor_liq
         FROM item_liquida_servicio  WHERE orden_servicio_id = $orden_servicio_id ";

            $result = $this->DbFetchAll($select, $Conex);

        } else {
            $result = array();
        }
        return $result;
    }

    public function get_tot_pucServicio($Conex)
    {

        $orden_servicio_id = $this->requestData('orden_servicio_id', 'integer');

        if (is_numeric($orden_servicio_id)) {

            $select = "SELECT COUNT(*) AS total_puc
         FROM  item_puc_liquida_servicio   WHERE orden_servicio_id = $orden_servicio_id ";

            $result = $this->DbFetchAll($select, $Conex);

        } else {
            $result = array();
        }
        return $result;
    }

    public function get_pucServicio($Conex)
    {

        $orden_servicio_id = $this->requestData('orden_servicio_id', 'integer');

        if (is_numeric($orden_servicio_id)) {

            $select = "SELECT c.despuc_bien_servicio_factura, c.contra_bien_servicio_factura, c.natu_bien_servicio_factura, (i.deb_item_puc_liquida+i.cre_item_puc_liquida) AS valor
         FROM  item_puc_liquida_servicio i, orden_servicio o,  codpuc_bien_servicio_factura c
		 WHERE o.orden_servicio_id = $orden_servicio_id AND i.orden_servicio_id=o.orden_servicio_id AND c.tipo_bien_servicio_factura_id=o.tipo_bien_servicio_factura_id AND c.puc_id=i.puc_id
		 ORDER BY i.item_puc_liquida_id";

            $result = $this->DbFetchAll($select, $Conex);

        } else {
            $result = array();
        }
        return $result;
    }

}
