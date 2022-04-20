<?php

require_once "../../../framework/clases/DbClass.php";
require_once "../../../framework/clases/PermisosFormClass.php";

final class SolicFacturasModel extends Db
{

    private $Permisos;

    public function getSolicFacturas($consul_emp, $empleados, $consul_fecha_desde, $consul_fecha_hasta, $consul_fechas, $Conex)
    {

        $select = "SELECT
					l.liquidacion_novedad_id,
					(SELECT CONCAT(prefijo,'-',numero_contrato) FROM contrato WHERE contrato_id=l.contrato_id) AS contrato,
					(SELECT CONCAT_WS(' ',t.numero_identificacion,'-',t.primer_nombre,t.primer_apellido)  FROM contrato c, empleado e, tercero t
					 WHERE c.contrato_id=l.contrato_id AND e.empleado_id=c.empleado_id AND t.tercero_id=e.tercero_id) AS empleado,
					l.consecutivo AS consecutivo_id,
					l.liquidacion_novedad_id,
					l.fecha_inicial,
					l.fecha_final,
					(d.debito+d.credito) AS valor_neto,
					(SELECT SUM(ra.rel_valor_abono_nomina) AS abonos FROM relacion_abono_nomina ra, abono_nomina ab
					WHERE ra.liquidacion_novedad_id=l.liquidacion_novedad_id AND ab.abono_nomina_id=ra.abono_nomina_id AND ab.estado_abono_nomina='A' )	AS abonos_nc,
					(SELECT SUM(ra.rel_valor_abono_nomina) AS abonos FROM relacion_abono_nomina ra, abono_nomina ab
					WHERE ra.liquidacion_novedad_id=l.liquidacion_novedad_id AND ab.abono_nomina_id=ra.abono_nomina_id AND ab.estado_abono_nomina='C' )	AS abonos,

					IF((SELECT SUM(ra.rel_valor_abono_nomina) AS abonos FROM  relacion_abono_nomina ra, abono_nomina ab
					WHERE ra.liquidacion_novedad_id=l.liquidacion_novedad_id AND ab.abono_nomina_id=ra.abono_nomina_id AND ab.estado_abono_nomina='C' ) IS NULL,
				   (d.debito+d.credito),
					((d.debito+d.credito)-(SELECT SUM(ra.rel_valor_abono_nomina) AS abonos FROM relacion_abono_nomina ra, abono_nomina ab
					WHERE ra.liquidacion_novedad_id=l.liquidacion_novedad_id AND ab.abono_nomina_id=ra.abono_nomina_id AND ab.estado_abono_nomina='C' ))
					)  AS saldo

					FROM liquidacion_novedad l, detalle_liquidacion_novedad d
					WHERE l.estado='C' AND d.liquidacion_novedad_id=l.liquidacion_novedad_id $consul_emp AND d.sueldo_pagar=1 $consul_fecha_desde $consul_fecha_hasta $consul_fechas  AND (d.debito+d.credito)>0
					AND ((d.debito+d.credito)  >	(SELECT SUM(ra.rel_valor_abono_nomina) AS abonos FROM  relacion_abono_nomina ra, abono_nomina ab
					WHERE ra.liquidacion_novedad_id=l.liquidacion_novedad_id AND ab.abono_nomina_id=ra.abono_nomina_id AND ab.estado_abono_nomina='C' )
					OR 	(SELECT SUM(ra.rel_valor_abono_nomina) AS abonos FROM  relacion_abono_nomina ra, abono_nomina ab
					WHERE ra.liquidacion_novedad_id=l.liquidacion_novedad_id AND ab.abono_nomina_id=ra.abono_nomina_id AND ab.estado_abono_nomina='C' ) IS NULL) ";

        $result = $this->DbFetchAll($select, $Conex, true);

        return $result;
    }

    public function getSolicVacaciones($consul_emp, $empleados, $Conex)
    {

        $select = "SELECT
					l.liquidacion_vacaciones_id,
					(SELECT CONCAT(prefijo,'-',numero_contrato) FROM contrato WHERE contrato_id=l.contrato_id) AS contrato,
					(SELECT CONCAT_WS(' ',t.numero_identificacion,'-',t.primer_nombre,t.primer_apellido)  FROM contrato c, empleado e, tercero t
					 WHERE c.contrato_id=l.contrato_id AND e.empleado_id=c.empleado_id AND t.tercero_id=e.tercero_id) AS empleado,

					l.liquidacion_vacaciones_id AS consecutivo_id,

					l.fecha_liquidacion,

					(d.valor_liquida) AS valor_neto,

					(SELECT SUM(ra.rel_valor_abono_nomina) AS abonos FROM relacion_abono_nomina ra, abono_nomina ab
					WHERE ra.liquidacion_vacaciones_id=l.liquidacion_vacaciones_id AND ab.abono_nomina_id=ra.abono_nomina_id AND ab.estado_abono_nomina='A' )	AS abonos_nc,

					(SELECT SUM(ra.rel_valor_abono_nomina) AS abonos FROM relacion_abono_nomina ra, abono_nomina ab
					WHERE ra.liquidacion_vacaciones_id=l.liquidacion_vacaciones_id AND ab.abono_nomina_id=ra.abono_nomina_id AND ab.estado_abono_nomina='C' )	AS abonos,

					IF((SELECT SUM(ra.rel_valor_abono_nomina) AS abonos FROM  relacion_abono_nomina ra, abono_nomina ab
					WHERE ra.liquidacion_vacaciones_id=l.liquidacion_vacaciones_id AND ab.abono_nomina_id=ra.abono_nomina_id AND ab.estado_abono_nomina='C' ) IS NULL,
				   (d.valor_liquida),
					((d.valor_liquida)-(SELECT SUM(ra.rel_valor_abono_nomina) AS abonos FROM relacion_abono_nomina ra, abono_nomina ab
					WHERE ra.liquidacion_vacaciones_id=l.liquidacion_vacaciones_id AND ab.abono_nomina_id=ra.abono_nomina_id AND ab.estado_abono_nomina='C' ))
					)  AS saldo

					FROM liquidacion_vacaciones l, detalle_vacaciones_puc d

					WHERE  l.estado='C' AND

					d.liquidacion_vacaciones_id=l.liquidacion_vacaciones_id

					$consul_emp

					/* AND d.contrapartida=1 */

					AND d.valor_liquida >0

					AND (d.valor_liquida  >	(SELECT SUM(ra.rel_valor_abono_nomina) AS abonos FROM  relacion_abono_nomina ra, abono_nomina ab
					WHERE ra.liquidacion_vacaciones_id=l.liquidacion_vacaciones_id AND ab.abono_nomina_id=ra.abono_nomina_id AND ab.estado_abono_nomina='C' )

					OR 	(SELECT SUM(ra.rel_valor_abono_nomina) AS abonos FROM  relacion_abono_nomina ra, abono_nomina ab
					WHERE ra.liquidacion_vacaciones_id=l.liquidacion_vacaciones_id AND ab.abono_nomina_id=ra.abono_nomina_id AND ab.estado_abono_nomina='C' ) IS NULL) ";

        $result = $this->DbFetchAll($select, $Conex, true);

        //echo $select;

        return $result;
    }

    public function getSolicPrimas($consul_emp, $empleados, $Conex)
    {

        $select = "SELECT
				l.liquidacion_prima_id,
				(SELECT CONCAT(prefijo,'-',numero_contrato) FROM contrato WHERE contrato_id=l.contrato_id) AS contrato,
				(SELECT CONCAT_WS(' ',t.numero_identificacion,'-',t.primer_nombre,t.primer_apellido)  FROM contrato c, empleado e, tercero t
				 WHERE c.contrato_id=l.contrato_id AND e.empleado_id=c.empleado_id AND t.tercero_id=e.tercero_id) AS empleado,

				l.liquidacion_prima_id AS consecutivo_id,

				l.fecha_liquidacion,

				(d.valor_liquida) AS valor_neto,

				(SELECT SUM(ra.rel_valor_abono_nomina) AS abonos FROM relacion_abono_nomina ra, abono_nomina ab
				WHERE ra.liquidacion_prima_id=l.liquidacion_prima_id AND ab.abono_nomina_id=ra.abono_nomina_id AND ab.estado_abono_nomina='A' )	AS abonos_nc,

				(SELECT SUM(ra.rel_valor_abono_nomina) AS abonos FROM relacion_abono_nomina ra, abono_nomina ab
				WHERE ra.liquidacion_prima_id=l.liquidacion_prima_id AND ab.abono_nomina_id=ra.abono_nomina_id AND ab.estado_abono_nomina='C' )	AS abonos,

				IF((SELECT SUM(ra.rel_valor_abono_nomina) AS abonos FROM  relacion_abono_nomina ra, abono_nomina ab
				WHERE ra.liquidacion_prima_id=l.liquidacion_prima_id AND ab.abono_nomina_id=ra.abono_nomina_id AND ab.estado_abono_nomina='C' ) IS NULL,
			   (d.valor_liquida),
				((d.valor_liquida)-(SELECT SUM(ra.rel_valor_abono_nomina) AS abonos FROM relacion_abono_nomina ra, abono_nomina ab
				WHERE ra.liquidacion_prima_id=l.liquidacion_prima_id AND ab.abono_nomina_id=ra.abono_nomina_id AND ab.estado_abono_nomina='C' ))
				)  AS saldo

				FROM liquidacion_prima l, detalle_prima_puc d

				WHERE  l.estado='C' AND

				d.liquidacion_prima_id=l.liquidacion_prima_id

				$consul_emp AND

				d.contrapartida=1

				AND d.valor_liquida >0

				AND (d.valor_liquida  >	(SELECT SUM(ra.rel_valor_abono_nomina) AS abonos FROM  relacion_abono_nomina ra, abono_nomina ab
				WHERE ra.liquidacion_prima_id=l.liquidacion_prima_id AND ab.abono_nomina_id=ra.abono_nomina_id AND ab.estado_abono_nomina='C' )

				OR 	(SELECT SUM(ra.rel_valor_abono_nomina) AS abonos FROM  relacion_abono_nomina ra, abono_nomina ab
				WHERE ra.liquidacion_prima_id=l.liquidacion_prima_id AND ab.abono_nomina_id=ra.abono_nomina_id AND ab.estado_abono_nomina='C' ) IS NULL) ";

        $result = $this->DbFetchAll($select, $Conex, true);

        return $result;
    }

    public function getSolicCesantias($consul_emp, $empleados, $Conex)
    {

        $select = "SELECT
				l.liquidacion_cesantias_id,
				(SELECT CONCAT(prefijo,'-',numero_contrato) FROM contrato WHERE contrato_id=l.contrato_id) AS contrato,
				(SELECT CONCAT_WS(' ',t.numero_identificacion,'-',t.primer_nombre,t.primer_apellido)  FROM contrato c, empleado e, tercero t
				 WHERE c.contrato_id=l.contrato_id AND e.empleado_id=c.empleado_id AND t.tercero_id=e.tercero_id) AS empleado,

				l.liquidacion_cesantias_id AS consecutivo_id,

				l.fecha_liquidacion,

				(d.valor_liquida) AS valor_neto,

				(SELECT SUM(ra.rel_valor_abono_nomina) AS abonos FROM relacion_abono_nomina ra, abono_nomina ab
				WHERE ra.liquidacion_cesantias_id=l.liquidacion_cesantias_id AND ab.abono_nomina_id=ra.abono_nomina_id AND ab.estado_abono_nomina='A' )	AS abonos_nc,

				(SELECT SUM(ra.rel_valor_abono_nomina) AS abonos FROM relacion_abono_nomina ra, abono_nomina ab
				WHERE ra.liquidacion_cesantias_id=l.liquidacion_cesantias_id AND ab.abono_nomina_id=ra.abono_nomina_id AND ab.estado_abono_nomina='C' )	AS abonos,

				IF((SELECT SUM(ra.rel_valor_abono_nomina) AS abonos FROM  relacion_abono_nomina ra, abono_nomina ab
				WHERE ra.liquidacion_cesantias_id=l.liquidacion_cesantias_id AND ab.abono_nomina_id=ra.abono_nomina_id AND ab.estado_abono_nomina='C' ) IS NULL,
			   (d.valor_liquida),
				((d.valor_liquida)-(SELECT SUM(ra.rel_valor_abono_nomina) AS abonos FROM relacion_abono_nomina ra, abono_nomina ab
				WHERE ra.liquidacion_cesantias_id=l.liquidacion_cesantias_id AND ab.abono_nomina_id=ra.abono_nomina_id AND ab.estado_abono_nomina='C' ))
				)  AS saldo

				FROM liquidacion_cesantias l, detalle_cesantias_puc d

				WHERE  l.estado='C' AND

				d.liquidacion_cesantias_id=l.liquidacion_cesantias_id

				$consul_emp AND

				d.contrapartida=1

				AND d.valor_liquida >0

				AND l.beneficiario=2

				AND (d.valor_liquida  >	(SELECT SUM(ra.rel_valor_abono_nomina) AS abonos FROM  relacion_abono_nomina ra, abono_nomina ab
				WHERE ra.liquidacion_cesantias_id=l.liquidacion_cesantias_id AND ab.abono_nomina_id=ra.abono_nomina_id AND ab.estado_abono_nomina='C' )

				OR 	(SELECT SUM(ra.rel_valor_abono_nomina) AS abonos FROM  relacion_abono_nomina ra, abono_nomina ab
				WHERE ra.liquidacion_cesantias_id=l.liquidacion_cesantias_id AND ab.abono_nomina_id=ra.abono_nomina_id AND ab.estado_abono_nomina='C' ) IS NULL) ";

        $result = $this->DbFetchAll($select, $Conex, true);

        return $result;
    }

    public function getSolicIntCesantias($consul_emp, $empleados, $Conex)
    {

        $select = "SELECT
				l.liquidacion_int_cesantias_id,
				(SELECT CONCAT(prefijo,'-',numero_contrato) FROM contrato WHERE contrato_id=l.contrato_id) AS contrato,
				(SELECT CONCAT_WS(' ',t.numero_identificacion,'-',t.primer_nombre,t.primer_apellido)  FROM contrato c, empleado e, tercero t
				 WHERE c.contrato_id=l.contrato_id AND e.empleado_id=c.empleado_id AND t.tercero_id=e.tercero_id) AS empleado,

				l.liquidacion_int_cesantias_id AS consecutivo_id,

				l.fecha_liquidacion,

				(d.valor_liquida) AS valor_neto,

				(SELECT SUM(ra.rel_valor_abono_nomina) AS abonos FROM relacion_abono_nomina ra, abono_nomina ab
				WHERE ra.liquidacion_int_cesantias_id=l.liquidacion_int_cesantias_id AND ab.abono_nomina_id=ra.abono_nomina_id AND ab.estado_abono_nomina='A' )	AS abonos_nc,

				(SELECT SUM(ra.rel_valor_abono_nomina) AS abonos FROM relacion_abono_nomina ra, abono_nomina ab
				WHERE ra.liquidacion_int_cesantias_id=l.liquidacion_int_cesantias_id AND ab.abono_nomina_id=ra.abono_nomina_id AND ab.estado_abono_nomina='C' )	AS abonos,

				IF((SELECT SUM(ra.rel_valor_abono_nomina) AS abonos FROM  relacion_abono_nomina ra, abono_nomina ab
				WHERE ra.liquidacion_int_cesantias_id=l.liquidacion_int_cesantias_id AND ab.abono_nomina_id=ra.abono_nomina_id AND ab.estado_abono_nomina='C' ) IS NULL,
			   (d.valor_liquida),
				((d.valor_liquida)-(SELECT SUM(ra.rel_valor_abono_nomina) AS abonos FROM relacion_abono_nomina ra, abono_nomina ab
				WHERE ra.liquidacion_int_cesantias_id=l.liquidacion_int_cesantias_id AND ab.abono_nomina_id=ra.abono_nomina_id AND ab.estado_abono_nomina='C' ))
				)  AS saldo

				FROM liquidacion_int_cesantias l, detalle_int_cesantias_puc d

				WHERE  l.estado='C' AND

				d.liquidacion_int_cesantias_id = l.liquidacion_int_cesantias_id

				$consul_emp AND

				d.contrapartida=1

				AND d.valor_liquida >0

				AND l.beneficiario=2

				AND (d.valor_liquida  >	(SELECT SUM(ra.rel_valor_abono_nomina) AS abonos FROM  relacion_abono_nomina ra, abono_nomina ab
				WHERE ra.liquidacion_int_cesantias_id=l.liquidacion_int_cesantias_id AND ab.abono_nomina_id=ra.abono_nomina_id AND ab.estado_abono_nomina='C' )

				OR 	(SELECT SUM(ra.rel_valor_abono_nomina) AS abonos FROM  relacion_abono_nomina ra, abono_nomina ab
				WHERE ra.liquidacion_int_cesantias_id=l.liquidacion_int_cesantias_id AND ab.abono_nomina_id=ra.abono_nomina_id AND ab.estado_abono_nomina='C' ) IS NULL) ";

        $result = $this->DbFetchAll($select, $Conex, true);

        return $result;
    }

    public function getSolicLiqFinal($consul_emp, $empleados, $Conex)
    {

        $select = "SELECT
				l.liquidacion_definitiva_id,
				(SELECT CONCAT(prefijo,'-',numero_contrato) FROM contrato WHERE contrato_id=l.contrato_id) AS contrato,

				(SELECT CONCAT_WS(' ',t.numero_identificacion,'-',t.primer_nombre,t.primer_apellido)  FROM contrato c, empleado e, tercero t
				 WHERE c.contrato_id=l.contrato_id AND e.empleado_id=c.empleado_id AND t.tercero_id=e.tercero_id) AS empleado,

				l.liquidacion_definitiva_id AS consecutivo_id,

				l.fecha_inicio,
				l.fecha_final,

				/* (d.valor_liquida) AS valor_neto, */
				(d.valor) AS valor_neto,

				(SELECT SUM(ra.rel_valor_abono_nomina) AS abonos FROM relacion_abono_nomina ra, abono_nomina ab
				WHERE ra.liquidacion_definitiva_id=l.liquidacion_definitiva_id AND ab.abono_nomina_id=ra.abono_nomina_id AND ab.estado_abono_nomina='A' )	AS abonos_nc,

				(SELECT SUM(ra.rel_valor_abono_nomina) AS abonos FROM relacion_abono_nomina ra, abono_nomina ab
				WHERE ra.liquidacion_definitiva_id=l.liquidacion_definitiva_id AND ab.abono_nomina_id=ra.abono_nomina_id AND ab.estado_abono_nomina='C' )	AS abonos,

				IF((SELECT SUM(ra.rel_valor_abono_nomina) AS abonos FROM  relacion_abono_nomina ra, abono_nomina ab
				WHERE ra.liquidacion_definitiva_id=l.liquidacion_definitiva_id AND ab.abono_nomina_id=ra.abono_nomina_id AND ab.estado_abono_nomina='C' ) IS NULL,
			   (d.valor),
				((d.valor)-(SELECT SUM(ra.rel_valor_abono_nomina) AS abonos FROM relacion_abono_nomina ra, abono_nomina ab
				WHERE ra.liquidacion_definitiva_id=l.liquidacion_definitiva_id AND ab.abono_nomina_id=ra.abono_nomina_id AND ab.estado_abono_nomina='C' ))
				)  AS saldo

				FROM liquidacion_definitiva l, liq_def_puc d

				WHERE  l.estado='C' AND

				d.liquidacion_definitiva_id = l.liquidacion_definitiva_id

				$consul_emp

				/* AND d.contrapartida=1 */
			    AND d.credito > 0

				AND d.valor >0

				AND (d.valor  >	(SELECT SUM(ra.rel_valor_abono_nomina) AS abonos FROM  relacion_abono_nomina ra, abono_nomina ab
				WHERE ra.liquidacion_definitiva_id=l.liquidacion_definitiva_id AND ab.abono_nomina_id=ra.abono_nomina_id AND ab.estado_abono_nomina='C' )

				OR 	(SELECT SUM(ra.rel_valor_abono_nomina) AS abonos FROM  relacion_abono_nomina ra, abono_nomina ab
				WHERE ra.liquidacion_definitiva_id=l.liquidacion_definitiva_id AND ab.abono_nomina_id=ra.abono_nomina_id AND ab.estado_abono_nomina='C' ) IS NULL) ";

        $result = $this->DbFetchAll($select, $Conex, true);

        return $result;
    }

	public function getSolicNovDoc($empleado_id, $desde, $hasta, $Conex)
    {
		$consul_empleado = ($empleado_id != '') ? " AND c.empleado_id = $empleado_id " : "" ;

        $select = "SELECT er.encabezado_registro_id,er.consecutivo AS consecutivo_documento,CONCAT_WS('-',c.prefijo,c.numero_contrato) AS contrato,
			CONCAT_WS('-',t.numero_identificacion,CONCAT_WS(' ',t.primer_nombre,t.primer_apellido)) AS empleado,er.fecha,
			ic.credito AS valor_neto,ic.credito AS saldo,0 AS abono,ic.credito AS valor_pagar
			FROM novedad_fija nf
			INNER JOIN concepto_area ca ON nf.concepto_area_id =  ca.concepto_area_id 
			INNER JOIN encabezado_de_registro er ON nf.encabezado_registro_id = er.encabezado_registro_id AND nf.tipo_documento_id = er.tipo_documento_id
			INNER JOIN contrato c ON nf.contrato_id = c.contrato_id 
			INNER JOIN tercero t ON nf.tercero_id = t.tercero_id
			INNER JOIN imputacion_contable ic ON er.encabezado_registro_id = ic.encabezado_registro_id AND ca.puc_contra_id = ic.puc_id
			WHERE ca.contabiliza = 'SI' AND er.estado = 'C' AND er.fecha BETWEEN '$desde' AND '$hasta' 
			AND ca.tipo_novedad_documento = 'V' AND nf.por_pagar = 1 ".$consul_empleado;

        $result = $this->DbFetchAll($select, $Conex, true);

        return $result;
    }

}
