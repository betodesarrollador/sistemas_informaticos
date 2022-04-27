<?php

require_once "../../../framework/clases/DbClass.php";
require_once "../../../framework/clases/PermisosFormClass.php";

final class SolicFacturasModel extends Db
{

    private $Permisos;
    //facturas de venta
    public function getSolicFacturas($cliente_id, $Conex)
    {

        if (is_numeric($cliente_id)) {
            $select = "SELECT
				f.factura_id,
				IF(f.encabezado_registro_id>0,(SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id=f.encabezado_registro_id),f.consecutivo_factura) AS consecutivo_id,
				CASE f.fuente_facturacion_cod WHEN 'OS' THEN 'Orden de Servicio' ELSE 'Remesas' END AS tipo,
				f.fecha,
				f.vencimiento,
				f.valor,
				(SELECT IF(valor_liquida>0,TRUNCATE(valor_liquida,0),TRUNCATE((deb_item_factura+cre_item_factura),0)) AS neto  FROM detalle_factura_puc WHERE  factura_id=f.factura_id AND contra_factura=1) AS valor_neto,
				(SELECT SUM(ra.rel_valor_abono) AS abonos FROM  relacion_abono ra, abono_factura ab
				WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='A')	AS abonos_nc,
				(SELECT SUM(ra.rel_valor_abono) AS abonos FROM  relacion_abono ra, abono_factura ab
				WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C')	AS abonos
				FROM factura f
				WHERE f.cliente_id=$cliente_id AND f.estado='C'
				AND ((SELECT IF(valor_liquida>0,TRUNCATE(valor_liquida,0),TRUNCATE((deb_item_factura+cre_item_factura),0)) AS neto  FROM detalle_factura_puc WHERE  factura_id=f.factura_id AND contra_factura=1) >	(SELECT TRUNCATE(SUM(ra.rel_valor_abono),0) AS abonos FROM relacion_abono ra, abono_factura ab
				WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C')
				OR 	(SELECT TRUNCATE(SUM(ra.rel_valor_abono),0) AS abonos FROM  relacion_abono ra, abono_factura ab
				WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C') IS NULL)";
           
            $result = $this->DbFetchAll($select, $Conex,true);

            $i = 0;
            foreach ($result as $items) {
                $saldo = floatval($items[valor_neto]) - floatval($items[abonos]);
                $results[$i] = array(factura_id => $items[factura_id], consecutivo_id => $items[consecutivo_id], tipo => $items[tipo], fecha => $items[fecha], vencimiento => $items[vencimiento], valor => $items[valor], valor_neto => $items[valor_neto], abonos_nc => $items[abonos_nc], abonos => $items[abonos], saldo => $saldo);
                $i++;
            }
        } else {
            $results = array();
        }

        return $results;
    }

    //NOTAS DEBITO
    public function getSolicNotasDebito($cliente_id, $Conex)
    {

        if (is_numeric($cliente_id)) {
            $select = "SELECT
                nd.nota_debito_id,
                IF(nd.encabezado_registro_id > 0,
                    (SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id = nd.encabezado_registro_id),
                    (SELECT f.consecutivo_factura FROM factura f WHERE f.factura_id = nd.factura_id)) AS consecutivo_id,
                (SELECT f.consecutivo_factura FROM factura f WHERE f.factura_id = nd.factura_id) AS consecutivo_factura,
                'NOTA DEBITO' AS tipo,
                nd.fecha,
                nd.valor_nota_debito AS valor,
                (SELECT (deb_item_nota + cre_item_nota) AS neto FROM item_nota_debito WHERE nota_debito_id = nd.nota_debito_id AND contrapartida = 1) AS valor_neto,
                (SELECT SUM(ra.rel_valor_abono) AS abonos FROM relacion_abono ra, abono_factura ab WHERE ra.nota_debito_id = nd.nota_debito_id AND ab.abono_factura_id = ra.abono_factura_id AND ab.estado_abono_factura = 'A') AS abonos_nc,
                (SELECT SUM(ra.rel_valor_abono) AS abonos FROM relacion_abono ra, abono_factura ab WHERE ra.nota_debito_id = nd.nota_debito_id AND ab.abono_factura_id = ra.abono_factura_id AND ab.estado_abono_factura = 'C') AS abonos
          
            FROM
                nota_debito nd
            WHERE
                nd.factura_id IN (SELECT factura_id FROM factura WHERE cliente_id = $cliente_id) AND 
                nd.estado_nota_debito = 'C' AND
                (
                    (SELECT (deb_item_nota + cre_item_nota) AS neto FROM item_nota_debito WHERE nota_debito_id = nd.nota_debito_id AND contrapartida = 1) > (SELECT SUM(ra.rel_valor_abono) AS abonos FROM relacion_abono ra, abono_factura ab WHERE ra.nota_debito_id = nd.nota_debito_id AND ab.abono_factura_id = ra.abono_factura_id AND ab.estado_abono_factura = 'C') OR 
                    (SELECT SUM(ra.rel_valor_abono) AS abonos FROM relacion_abono ra, abono_factura ab WHERE ra.nota_debito_id = nd.nota_debito_id AND ab.abono_factura_id = ra.abono_factura_id AND ab.estado_abono_factura = 'C') IS NULL
                )";
            $result = $this->DbFetchAll($select, $Conex);

            $i = 0;
            foreach ($result as $items) {
                $saldo = floatval($items[valor_neto]) - floatval($items[abonos]);
                $results[$i] = array(nota_debito_id => $items[nota_debito_id], consecutivo_id => $items[consecutivo_id], consecutivo_factura => $items[consecutivo_factura], tipo => $items[tipo], fecha => $items[fecha], valor => $items[valor], valor_neto => $items[valor_neto], abonos_nc => $items[abonos_nc], abonos => $items[abonos], saldo => $saldo);
                $i++;
            }
        } else {
            $results = array();
        }

        return $results;
    }

    public function selectImpuesto($puc_id, $base, $periodo_contable_id, $factura_id, $Conex)
    {

        $select = "SELECT ip.naturaleza,imp.* FROM  impuesto ip, impuesto_periodo_contable imp
		  WHERE imp.periodo_contable_id = $periodo_contable_id AND imp.impuesto_id = (SELECT impuesto_id FROM impuesto WHERE puc_id = $puc_id)
		  AND imp.impuesto_id = ip.impuesto_id AND ip.puc_id IN (SELECT df.puc_id FROM detalle_factura_puc df WHERE df.factura_id=$factura_id )";

        $impuesto = $this->DbFetchAll($select, $Conex, true);
        if (count($impuesto) > 0) {
            $porcentaje = $impuesto[0]['porcentaje'];
            $impuesto_id = $impuesto[0]['impuesto_id'];
            $naturaleza = $impuesto[0]['naturaleza'];
            $formula = $impuesto[0]['formula'];
            $base = str_replace(",", ".", str_replace(".", "", $base));

            $calculo = str_replace("BASE", $base, $formula);
            $calculo = str_replace("PORCENTAJE", $porcentaje, $calculo);

            $select = "SELECT $calculo AS valor_total";
            $result = $this->DbFetchAll($select, $Conex, true);
            $valorTotal = round($result[0]['valor_total']);

            return $valorTotal;
        } else {
            return 0;
        }

    }

    public function getDescuentos($oficina_id, $Conex)
    {

        $select = "SELECT
					p.parametros_descuento_factura_id,
					p.naturaleza,
					p.nombre
				FROM parametros_descuento_factura p
				WHERE p.estado=1 AND p.oficina_id=$oficina_id";

        $result = $this->DbFetchAll($select, $Conex, true);

        return $result;

    }

    public function getMayor($oficina_id, $Conex)
    {
        $select = "SELECT
					p.parametros_descuento_factura_id,
					p.naturaleza,
					p.puc_id,
					p.nombre
				FROM parametros_descuento_factura p
				WHERE p.estado=1 AND p.oficina_id=$oficina_id AND naturaleza='C'";

        $result = $this->DbFetchAll($select, $Conex);

        return $result;
    }

}
