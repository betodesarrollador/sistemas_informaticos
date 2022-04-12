<?php
require_once "../../../framework/clases/DbClass.php";
require_once "../../../framework/clases/PermisosFormClass.php";

final class SubtotalModel extends Db
{

    private $Permisos;

    public function getDetalles($orden_servicio_id, $empresa_id, $oficina_id, $Conex)
    {

        if (is_numeric($orden_servicio_id)) {
            $total_pagar = 0;
            $parcial = '';
            $contra = 0;
            $impuesto = 0;
            $subtotal = 0;
            $i = 0;

            $select = "SELECT COUNT(*) AS movimientos FROM item_liquida_servicio  WHERE orden_servicio_id = $orden_servicio_id";
            $result = $this->DbFetchAll($select, $Conex);
            $totalitem = $result[0]['movimientos'];

            $select_puc = "SELECT COUNT(*) AS movimientos FROM item_puc_liquida_servicio  WHERE orden_servicio_id = $orden_servicio_id";
            $result_puc = $this->DbFetchAll($select_puc, $Conex);
            $totalitem_puc = $result_puc[0]['movimientos'];

            if ($totalitem_puc > 0) {

                $select = "SELECT c.despuc_bien_servicio_factura, c.contra_bien_servicio_factura, c.natu_bien_servicio_factura, c.puc_id,
					(SELECT autoret_cliente_factura FROM cliente WHERE cliente_id=o.cliente_id ) AS autorete,
					(SELECT retei_cliente_factura FROM cliente WHERE cliente_id=o.cliente_id ) AS retei,
					(SELECT exentos FROM impuesto WHERE puc_id=c.puc_id AND empresa_id=$empresa_id ) AS exento,
					(i.deb_item_puc_liquida+i.cre_item_puc_liquida) AS total,
					(SELECT ipc.porcentaje FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc
					WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id
					AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS porcentaje,
					(SELECT  ipc.monto FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc
					WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id
					AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS monto,
					(SELECT ipc.formula FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc
					WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id
					AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS formula
					FROM  item_puc_liquida_servicio i, orden_servicio o,  codpuc_bien_servicio_factura c
					WHERE o.orden_servicio_id = $orden_servicio_id AND i.orden_servicio_id=o.orden_servicio_id AND c.tipo_bien_servicio_factura_id=o.tipo_bien_servicio_factura_id AND c.puc_id=i.puc_id
					ORDER BY i.item_puc_liquida_id";

            } elseif ($totalitem > 0) {

                $select = "SELECT  c.despuc_bien_servicio_factura,
					c.natu_bien_servicio_factura,
					c.contra_bien_servicio_factura,
					c.puc_id,
					(SELECT autoret_cliente_factura FROM cliente WHERE cliente_id=o.cliente_id ) AS autorete,
					(SELECT retei_cliente_factura FROM cliente WHERE cliente_id=o.cliente_id ) AS retei,
					(SELECT exentos FROM impuesto WHERE puc_id=c.puc_id AND empresa_id=$empresa_id ) AS exento,
					(SELECT ipc.porcentaje FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc
					WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id
					AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS porcentaje,
					(SELECT  ipc.monto FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc
					WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id
					AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS monto,
					(SELECT ipc.formula FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc
					WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id
					AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS formula,
					(SELECT SUM(valoruni_item_liquida_servicio*cant_item_liquida_servicio) AS total FROM  item_liquida_servicio   WHERE orden_servicio_id=o.orden_servicio_id) AS total
					FROM codpuc_bien_servicio_factura  c, orden_servicio o
					WHERE o.orden_servicio_id = $orden_servicio_id AND c.tipo_bien_servicio_factura_id=o.tipo_bien_servicio_factura_id AND c.activo=1 ORDER BY c.contra_bien_servicio_factura";
            } else {
                $select = "SELECT  c.despuc_bien_servicio_factura,
					c.natu_bien_servicio_factura,
					c.contra_bien_servicio_factura,
					c.puc_id,
					(SELECT autoret_cliente_factura FROM cliente WHERE cliente_id=o.cliente_id ) AS autorete,
					(SELECT retei_cliente_factura FROM cliente WHERE cliente_id=o.cliente_id ) AS retei,
					(SELECT exentos FROM impuesto WHERE puc_id=c.puc_id AND empresa_id=$empresa_id ) AS exento,
					(SELECT ipc.porcentaje FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc
					WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id
					AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS porcentaje,
					(SELECT  ipc.monto FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc
					WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id
					AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS monto,
					(SELECT ipc.formula FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc
					WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id
					AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS formula,
					(SELECT SUM(valoruni_item_orden_servicio*cant_item_orden_servicio) AS total FROM  item_orden_servicio  WHERE orden_servicio_id=o.orden_servicio_id) AS total
					FROM codpuc_bien_servicio_factura  c, orden_servicio o
					WHERE o.orden_servicio_id = $orden_servicio_id AND c.tipo_bien_servicio_factura_id=o.tipo_bien_servicio_factura_id AND c.activo=1 ORDER BY c.contra_bien_servicio_factura";
            }

            $result = $this->DbFetchAll($select, $Conex);

            if ($totalitem_puc > 0) {
                foreach ($result as $resultado) {

                    $results[$i] = array(despuc_bien_servicio_factura => $resultado[despuc_bien_servicio_factura], valor => $resultado[total], natu_bien_servicio_factura => $resultado[natu_bien_servicio_factura], puc_id => $resultado[puc_id], contra_bien_servicio_factura => $resultado[contra_bien_servicio_factura]);
                    $i++;
                }
            } else {
                foreach ($result as $resultado) {
                    if (($resultado[porcentaje] == '' || $resultado[porcentaje] == null) && $resultado[contra_bien_servicio_factura] != 1) {

                        $parcial = $resultado[total];
                        $subtotal++;

                        if ($resultado[natu_bien_servicio_factura] == 'D' && $resultado[contra_bien_servicio_factura] != 1) {
                            $total_pagar = $total_pagar - $parcial;
                        } elseif ($resultado[natu_bien_servicio_factura] == 'C' && $resultado[contra_bien_servicio_factura] != 1) {
                            $total_pagar = $total_pagar + $parcial;
                        }
                        $parcial = number_format($parcial, 2, '.', '');
                        $descripcion = $resultado[despuc_bien_servicio_factura];
                        $results[$i] = array(despuc_bien_servicio_factura => $descripcion, valor => $parcial, natu_bien_servicio_factura => $resultado[natu_bien_servicio_factura], puc_id => $resultado[puc_id], contra_bien_servicio_factura => $resultado[contra_bien_servicio_factura]);
                        $i++;

                    } elseif ($resultado[porcentaje] > 0 && $resultado[contra_bien_servicio_factura] != 1 && $resultado[monto] <= $resultado[total] && (($resultado[exento] == 'RT' && $resultado[autorete] == 'N') || ($resultado[exento] == 'IC' && $resultado[retei] == 'N') || ($resultado[exento] == 'NN') || ($resultado[exento] == 'IV') || ($resultado[exento] == 'RIV') || ($resultado[exento] == 'RIC' && $resultado[retei] == 'N') || ($resultado[exento] == 'IV') || ($resultado[exento] == 'RIV') || ($resultado[exento] == 'RIC' && $resultado[retei] == 'N'))) {

                        $base = $resultado[total];
                        $formula = $resultado[formula];
                        $porcentaje = $resultado[porcentaje];
                        $calculo = str_replace("BASE", $base, $formula);
                        $calculo = str_replace("PORCENTAJE", $porcentaje, $calculo);
                        $select1 = "SELECT $calculo AS valor_total";
                        $result1 = $this->DbFetchAll($select1, $Conex);
                        $parcial = $result1[0]['valor_total'];
                        $impuesto++;
                        if ($resultado[natu_bien_servicio_factura] == 'D' && $resultado[contra_bien_servicio_factura] != 1) {
                            $total_pagar = $total_pagar - $parcial;
                        } elseif ($resultado[natu_bien_servicio_factura] == 'C' && $resultado[contra_bien_servicio_factura] != 1) {
                            $total_pagar = $total_pagar + $parcial;
                        }
                        $parcial = number_format($parcial, 2, '.', '');
                        $descripcion = $resultado[despuc_bien_servicio_factura];
                        $results[$i] = array(despuc_bien_servicio_factura => $descripcion, valor => $parcial, natu_bien_servicio_factura => $resultado[natu_bien_servicio_factura], puc_id => $resultado[puc_id], contra_bien_servicio_factura => $resultado[contra_bien_servicio_factura]);
                        $i++;

                    } elseif ($resultado[contra_bien_servicio_factura] == 1) {
                        $parcial = $total_pagar;
                        $contra++;
                        if ($resultado[natu_bien_servicio_factura] == 'D' && $resultado[contra_bien_servicio_factura] != 1) {
                            $total_pagar = $total_pagar + $parcial;
                        } elseif ($resultado[natu_bien_servicio_factura] == 'C' && $resultado[contra_bien_servicio_factura] != 1) {
                            $total_pagar = $total_pagar - $parcial;
                        }
                        $parcial = number_format($parcial, 2, '.', '');
                        $descripcion = $resultado[despuc_bien_servicio_factura];
                        $results[$i] = array(despuc_bien_servicio_factura => $descripcion, valor => $parcial, natu_bien_servicio_factura => $resultado[natu_bien_servicio_factura], puc_id => $resultado[puc_id], contra_bien_servicio_factura => $resultado[contra_bien_servicio_factura]);
                        $i++;

                    }
                }
            }

        } else {
            return array();
        }

        if (($subtotal == 1 && $impuesto >= 0 && $contra == 1) || $totalitem_puc > 0) {
            return $results;
        } else {
            return array();
        }

    }

}
