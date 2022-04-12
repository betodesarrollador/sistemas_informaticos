<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class ReporteElectronicaModel extends Db {

    private $UserId;
    private $Permisos;

    public function SetUsuarioId($UserId, $CodCId) {
        $this->Permisos = new PermisosForm();
        $this->Permisos->SetUsuarioId($UserId, $CodCId);
    }

    public function getPermiso($ActividadId, $Permiso, $Conex) {
        return $this->Permisos->getPermiso($ActividadId, $Permiso, $Conex);
    }

    public function GetSi_Pro($Conex) {
        $opciones = array(0 => array('value' => '1', 'text' => 'UNO'), 1 => array('value' => 'ALL', 'text' => 'TODOS'));
        return $opciones;
    }

    public function GetSi_Pro2($Conex) {
        $opciones = array(0 => array('value' => '1', 'text' => 'UNO'), 1 => array('value' => 'ALL', 'text' => 'TODOS'));
        return $opciones;
    }
	  

    public function getReporte($desde, $hasta,$empresa_id,$empleado_id='', $Conex) {

		$porEmpleado = ($empleado_id != '') ? "AND e.empleado_id=$empleado_id" : "" ;

		
		$select = "SELECT ln.*,
            (SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido)AS nombre_emp FROM empresa e, tercero t WHERE e.empresa_id = $empresa_id AND e.tercero_id=t.tercero_id) AS nombre_empresa,
            (SELECT CONCAT_WS(' - ',t.numero_identificacion,t.digito_verificacion)AS nit_emp FROM empresa e, tercero t WHERE e.empresa_id = $empresa_id AND e.tercero_id=t.tercero_id) AS nit_empresa,					
            (SELECT ti.codigo FROM  tipo_identificacion ti  WHERE  ti.tipo_identificacion_id=t.tipo_identificacion_id) AS tipoidentificacion, 
            t.numero_identificacion AS identificacion,  t.primer_nombre,t.segundo_nombre AS otros_nombres,t.primer_apellido,t.segundo_apellido,
            IF(u.divipola=11001,11,(SELECT ub.divipola FROM ubicacion ub WHERE ub.ubicacion_id=u.ubi_ubicacion_id )) AS departamento,
            u.divipola AS municipio,
            '' AS codtrabajador,
            of.direccion  AS lugar_trabajo,
            t.email AS email_trabajador,
            tc.codigo_electronica AS tipocontrato,
            tc.integral AS salariointegral,
            '0' AS altoRiesgopension,
            '00'  AS subtipoTrabajador,
            '01' AS tipoTrabajador,
            IF(u.divipola=11001,11,(SELECT ub.divipola FROM ubicacion ub WHERE ub.ubicacion_id=u.ubi_ubicacion_id )) AS depar_generacion,
            'es' AS idioma,
            u.divipola AS municipioGen,
            c.fecha_inicio AS fechaingreso,
            c.fecha_terminacion_real AS fecharetiro,
			TIMESTAMPDIFF(DAY, c.fecha_inicio, '$hasta') dias_trabajados,
            MAX(ln.fecha_registro) AS fechaEmision,
            CASE ln.periodicidad WHEN 'Q' THEN '4' WHEN 'M' THEN '5' WHEN 'S' THEN '1' WHEN 'T' THEN IF(DATEDIFF(ln.fecha_final, ln.fecha_inicial) BETWEEN 13 AND 16,'Q','M') END AS periodoNomina,
            (SELECT pn.prefijo FROM param_nomina_electronica pn WHERE pn.param_nom_electronica_id=ln.param_nom_electronica_id) prefijo_rango,
            (SELECT IF((SELECT consecutivo_nom
						FROM liquidacion_novedad 
						WHERE consecutivo_nom IS NOT NULL ORDER BY CAST(consecutivo_nom AS DECIMAL) DESC  LIMIT 1) IS NOT NULL, 
						(SELECT consecutivo_nom +1
						FROM liquidacion_novedad 
						WHERE consecutivo_nom IS NOT NULL ORDER BY CAST(consecutivo_nom AS DECIMAL) DESC  LIMIT 1),pn.rango_comienza+1)
			FROM param_nomina_electronica pn) num_rango,
			(SELECT pn.rango_inicial FROM param_nomina_electronica pn WHERE pn.param_nom_electronica_id=ln.param_nom_electronica_id) numini_rango,
            'COP' AS tipoMoneda,
            '' AS trm,
            '0.00' AS redondeo,
            IFNULL((SELECT GROUP_CONCAT(DISTINCT IF(fp.codigo_electronica IS NOT NULL, fp.codigo_electronica, '1') SEPARATOR '&') 
				FROM  abono_nomina an, relacion_abono_nomina ra, cuenta_tipo_pago ct, forma_pago fp, liquidacion_novedad ln2 
            WHERE ra.liquidacion_novedad_id = ln2.liquidacion_novedad_id AND an.abono_nomina_id=ra.abono_nomina_id AND ln2.contrato_id = ln.contrato_id AND ln2.estado = 'C' AND an.estado_abono_nomina='C' AND ct.cuenta_tipo_pago_id=an.cuenta_tipo_pago_id AND fp.forma_pago_id=ct.forma_pago_id AND ln2.fecha_inicial BETWEEN '$desde' AND '$hasta' AND ln2.fecha_final BETWEEN '$desde' AND '$hasta'),1) AS metododePago,
            '1' AS medioPago,
            (SELECT b.nombre_banco FROM banco b WHERE b.banco_id=c.banco_id) AS nombreBanco,
            (SELECT tc.nombre_tipo_cuenta FROM  tipo_cuenta tc WHERE tc.tipo_cta_id=c.tipo_cta_id) AS tipoCuenta,
            c.numcuenta_proveedor AS numeroCuenta,
            

            (SELECT GROUP_CONCAT(dl.fecha_final SEPARATOR '&') fecha_final 
		    FROM detalle_liquidacion_novedad dl,liquidacion_novedad liqn 
			WHERE liqn.liquidacion_novedad_id = dl.liquidacion_novedad_id AND dl.tercero_id = t.tercero_id 
			AND concepto like 'SALARIO%' AND dl.fecha_final >= '$desde' AND dl.fecha_final <= '$hasta' and liqn.estado = 'C') pagos_nomina,

			SUM(IF(dl.concepto='SUELDO PAGAR',dl.credito,0)) AS total_comprobante,	
			SUM(IF(dl.sueldo_pagar != 1,dl.credito,0)) AS total_deduccion,	

			IFNULL((SELECT SUM(lq.valor_pagos) FROM liquidacion_vacaciones lq WHERE lq.inicial = 0 AND lq.contrato_id = c.contrato_id AND lq.fecha_liquidacion>='$desde' AND lq.fecha_liquidacion<='$hasta'),0)+IFNULL((SELECT SUM(lq.valor) FROM liquidacion_vacaciones lq WHERE lq.inicial = 0 AND lq.contrato_id = c.contrato_id AND lq.fecha_liquidacion>='$desde' AND lq.fecha_liquidacion<='$hasta'),0)+IFNULL((SELECT SUM(valor_liquidacion) FROM liquidacion_cesantias WHERE estado = 'C' AND inicial = 0 AND contrato_id = c.contrato_id AND fecha_liquidacion BETWEEN '$desde' AND '$hasta'),0)+IFNULL((SELECT SUM(total) valor_prima FROM liquidacion_prima 
			WHERE contrato_id = c.contrato_id AND fecha_liquidacion >='$desde' AND fecha_liquidacion <= '$hasta' AND estado = 'C'),0)+(SELECT IFNULL((SELECT SUM(valor_liquidacion) FROM liquidacion_int_cesantias WHERE contrato_id = c.contrato_id AND inicial = 0 AND fecha_liquidacion BETWEEN '$desde' AND '$hasta'),0)) + SUM(IF(dl.sueldo_pagar != 1,dl.debito,0)) AS total_devengado,

			'102' AS tipo_documento, '0' AS  novedad, '' AS novedad_cune, '' AS tipo_nota, '' AS fecha_gen_pred, 
            '' AS cune_pred, '' AS numero_pred,
            SUM(IF(dl.concepto='SALARIO',dl.dias,0)) AS dias,
            SUM(IF(dl.concepto='SALARIO',dl.debito,0)) AS sueldo_trabajado,
						
			SUM(IF(dl.concepto = 'AUX TRANSPORTE',dl.debito,0)) AS auxilio_transporte,
			'' AS viatico_manu_alo_s,

			IFNULL((SELECT SUM(dlin.debito)-SUM(dlin.credito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 41),0) viatico_manu_alo_ns,

			SUM(IF(dl.concepto IN('SALUD'),dl.credito,0)) AS deduccion_salud,
			
			(SELECT dp.desc_emple_salud FROM datos_periodo dp
				INNER JOIN periodo_contable pc ON dp.periodo_contable_id = pc.periodo_contable_id
				WHERE anio = SUBSTRING('$desde', 1, 4)) porcentaje_salud,

			SUM(IF(dl.concepto IN('PENSION'),dl.credito,0)) AS deduccion_pension,
			
			(SELECT dp.desc_emple_pension FROM datos_periodo dp
				INNER JOIN periodo_contable pc ON dp.periodo_contable_id = pc.periodo_contable_id
				WHERE anio = SUBSTRING('$desde', 1, 4)) porcentaje_pension,

			SUM(IF(dl.concepto IN('FONDO PENSIONAL'),dl.credito,0)) AS deduccion_solidaridad_pensional,
			
			(SELECT desc_emple_fonpension FROM datos_periodo dp
				INNER JOIN periodo_contable pc ON dp.periodo_contable_id = pc.periodo_contable_id
				WHERE anio = SUBSTRING('$desde', 1, 4)) porcentaje_solidaridad_pensional,

			'' deduccion_subsistencia,'' porcentaje_subsistencia,

            (SELECT dias_liquidados FROM liquidacion_prima WHERE contrato_id = c.contrato_id AND estado = 'C' AND fecha_liquidacion BETWEEN '$desde' AND '$hasta' ) AS dias_prima,
						
			(SELECT total valor_prima FROM liquidacion_prima 
			WHERE contrato_id = c.contrato_id AND fecha_liquidacion >='$desde' AND fecha_liquidacion <= '$hasta' AND estado = 'C') pago_prima,

			'' prima_no_salarial,

			IFNULL((SELECT valor_liquidacion FROM liquidacion_cesantias WHERE estado = 'C' AND inicial = 0 AND contrato_id = c.contrato_id AND fecha_liquidacion BETWEEN '$desde' AND '$hasta'),'') pago_cesantias,

			IFNULL((SELECT valor_liquidacion FROM liquidacion_int_cesantias WHERE estado = 'C' AND inicial = 0 AND contrato_id = c.contrato_id AND fecha_liquidacion BETWEEN '$desde' AND '$hasta'),'') valor_intereses_cesantias,

			IF((SELECT valor_liquidacion FROM liquidacion_int_cesantias WHERE estado = 'C' AND inicial = 0 AND contrato_id = c.contrato_id AND fecha_liquidacion BETWEEN '$desde' AND '$hasta') > 1,(SELECT dp.desc_empre_int_cesantias FROM datos_periodo dp
			INNER JOIN periodo_contable pc ON dp.periodo_contable_id = pc.periodo_contable_id
			WHERE anio = SUBSTRING('$desde', 1, 4)),'') porcentaje_intereses_cesantias, 
				
			IFNULL((SELECT SUM(dlin.debito)-SUM(dlin.credito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 7),'') monto_comision, 
            
            '' horaInicio_extra_diurno, '' horaFin_extra_diurno,

            SUM(IF(dl.concepto = 'HORAS EXTRAS DIURNAS',dl.cant_horas_extras,0)) cantidad_horasE_diurnas,

            SUM(IF(dl.concepto = 'HORAS EXTRAS DIURNAS',dl.debito,0)) valor_horasE_diurnas,

			(SELECT dp.val_hr_ext_diurna-100 FROM datos_periodo dp
				INNER JOIN periodo_contable pc ON dp.periodo_contable_id = pc.periodo_contable_id
				WHERE anio = SUBSTRING('$desde', 1, 4)) porcentaje_extra_diurno,

            '' horaInicio_extra_nocturno, '' horaFin_extra_nocturno,

            SUM(IF(dl.concepto = 'HORAS EXTRAS NOCTURNAS',dl.cant_horas_extras,0)) cantidad_horasE_nocturno,

            SUM(IF(dl.concepto = 'HORAS EXTRAS NOCTURNAS',dl.debito,0)) valor_horasE_nocturno,
            
			(SELECT dp.val_hr_ext_nocturna-100 FROM datos_periodo dp
				INNER JOIN periodo_contable pc ON dp.periodo_contable_id = pc.periodo_contable_id
				WHERE anio = SUBSTRING('$desde', 1, 4)) porcentaje_extra_nocturno,
            
            '' horaInicio_recargo_nocturno, '' horaFin_recargo_nocturno,

            SUM(IF(dl.concepto = 'RECARGO NOCTURNO',dl.cant_horas_extras,0)) cantidad_horasR_nocturno,

            SUM(IF(dl.concepto = 'RECARGO NOCTURNO',dl.debito,0)) valor_horasR_nocturno,
					
			(SELECT dp.val_recargo_nocturna-100 FROM datos_periodo dp
				INNER JOIN periodo_contable pc ON dp.periodo_contable_id = pc.periodo_contable_id
				WHERE anio = SUBSTRING('$desde', 1, 4)) porcentaje_recargo_nocturno,
            
            '' horaInicio_Extra_diurnofes, '' horaFin_extra_diurnofes,

            SUM(IF(dl.concepto = 'HORAS EXTRAS FEST DIURNAS',dl.cant_horas_extras,0)) cantidad_horasE_diurnofes,

            SUM(IF(dl.concepto = 'HORAS EXTRAS FEST DIURNAS',dl.debito,0)) valor_horasE_diurnofes,
            
			(SELECT dp.val_hr_ext_festiva_diurna-100 FROM datos_periodo dp
				INNER JOIN periodo_contable pc ON dp.periodo_contable_id = pc.periodo_contable_id
				WHERE anio = SUBSTRING('$desde', 1, 4)) porcentaje_extra_diurnofes,

			'' horaInicio_recargo_diurnofes, '' horaFin_recargo_diurnofes,
			
			SUM(IF(dl.concepto = 'DOMINICALES FESTIVO',dl.cant_horas_extras,0)) cantidad_horasR_diurnofes,

			SUM(IF(dl.concepto = 'DOMINICALES FESTIVO',dl.debito,0)) valor_horasR_diurnofes,

			(SELECT dp.val_recargo_dominical-100 FROM datos_periodo dp
				INNER JOIN periodo_contable pc ON dp.periodo_contable_id = pc.periodo_contable_id
				WHERE anio = SUBSTRING('$desde', 1, 4)) porcentaje_recargo_diurnofes,

            '' horaInicio_Extra_nocturnofes, '' horaFin_extra_nocturnofes,

            SUM(IF(dl.concepto = 'HORAS EXTRAS FEST NOCTURNAS',dl.cant_horas_extras,0)) cantidad_horasE_nocturnofes,

            SUM(IF(dl.concepto = 'HORAS EXTRAS FEST NOCTURNAS',dl.debito,0)) valor_horasE_nocturnofes,
					
			(SELECT dp.val_hr_ext_festiva_nocturna-100 FROM datos_periodo dp
				INNER JOIN periodo_contable pc ON dp.periodo_contable_id = pc.periodo_contable_id
				WHERE anio = SUBSTRING('$desde', 1, 4)) porcentaje_extra_nocturnofes,

            '' horaInicio_recargo_nocturnofes, '' horaFin_recargo_nocturnofes,'0' cantidad_horasR_nocturnofes, '0' valor_horasR_nocturnofes,
            '0' porcentaje_recargo_nocturnofes,

            IFNULL((SELECT lq.fecha_dis_inicio FROM liquidacion_vacaciones lq 
                WHERE lq.inicial = 0 AND lq.contrato_id = c.contrato_id AND lq.fecha_liquidacion>='$desde' AND lq.fecha_liquidacion<='$hasta'),'') fecha_inicio_vacaciones,

            IFNULL((SELECT lq.fecha_reintegro FROM liquidacion_vacaciones lq 
                WHERE lq.inicial = 0 AND lq.contrato_id = c.contrato_id AND lq.fecha_liquidacion>='$desde' AND lq.fecha_liquidacion<='$hasta'),'') fecha_final_vacaciones,

            IFNULL((SELECT lq.dias FROM liquidacion_vacaciones lq 
                WHERE lq.inicial = 0 AND lq.contrato_id = c.contrato_id AND lq.fecha_liquidacion>='$desde' AND lq.fecha_liquidacion<='$hasta'),'') dias_vacaciones,

            IFNULL((SELECT lq.valor FROM liquidacion_vacaciones lq 
                WHERE lq.inicial = 0 AND lq.contrato_id = c.contrato_id AND lq.fecha_liquidacion>='$desde' AND lq.fecha_liquidacion<='$hasta'),'') valor_liquidacion_vacaciones,
            
            IF((SELECT lq.dias FROM liquidacion_vacaciones lq 
                WHERE lq.inicial = 0 AND lq.contrato_id = c.contrato_id AND lq.fecha_liquidacion>='$desde' AND lq.fecha_liquidacion<='$hasta')>1,'1','')  tipo_vacaciones,

            IFNULL((SELECT lq.dias_pagados FROM liquidacion_vacaciones lq 
                WHERE lq.inicial = 0 AND lq.contrato_id = c.contrato_id AND lq.fecha_liquidacion>='$desde' AND lq.fecha_liquidacion<='$hasta'),'') dias_compensados_vacaciones,

            IFNULL((SELECT lq.valor_pagos FROM liquidacion_vacaciones lq 
                WHERE lq.inicial = 0 AND lq.contrato_id = c.contrato_id AND lq.fecha_liquidacion>='$desde' AND lq.fecha_liquidacion<='$hasta'),'') valor_vacaciones_compensadas,

            IF((SELECT lq.dias_pagados FROM liquidacion_vacaciones lq 
                WHERE lq.inicial = 0 AND lq.contrato_id = c.contrato_id AND lq.fecha_liquidacion>='$desde' AND lq.fecha_liquidacion<='$hasta')>1,'2','')  tipo_vacaciones_compensadas,

			IFNULL((SELECT GROUP_CONCAT(dlil.fecha_inicial SEPARATOR '&') fecha_inicial
					FROM detalle_liquidacion_licencia dlil
					INNER JOIN licencia l ON dlil.licencia_id = l.licencia_id
					INNER JOIN detalle_liquidacion_novedad dliqn ON dlil.detalle_liquidacion_novedad_id = dliqn.detalle_liquidacion_novedad_id
					INNER JOIN liquidacion_novedad liqn ON dliqn.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN tipo_incapacidad ti ON l.tipo_incapacidad_id = ti.tipo_incapacidad_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND ti.parametros_envioNomina_id = 4
					AND liqn.contrato_id = c.contrato_id),'') fecha_inicio_licenciaM,

            IFNULL((SELECT GROUP_CONCAT(dlil.fecha_final SEPARATOR '&') fecha_final
					FROM detalle_liquidacion_licencia dlil
					INNER JOIN licencia l ON dlil.licencia_id = l.licencia_id
					INNER JOIN detalle_liquidacion_novedad dliqn ON dlil.detalle_liquidacion_novedad_id = dliqn.detalle_liquidacion_novedad_id
					INNER JOIN liquidacion_novedad liqn ON dliqn.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN tipo_incapacidad ti ON l.tipo_incapacidad_id = ti.tipo_incapacidad_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND ti.parametros_envioNomina_id = 4
					AND liqn.contrato_id = c.contrato_id),'') fecha_final_licenciaM,
            
            IFNULL((SELECT GROUP_CONCAT(dlil.dias_liquida SEPARATOR '&') dias
					FROM detalle_liquidacion_licencia dlil
					INNER JOIN licencia l ON dlil.licencia_id = l.licencia_id
					INNER JOIN detalle_liquidacion_novedad dliqn ON dlil.detalle_liquidacion_novedad_id = dliqn.detalle_liquidacion_novedad_id
					INNER JOIN liquidacion_novedad liqn ON dliqn.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN tipo_incapacidad ti ON l.tipo_incapacidad_id = ti.tipo_incapacidad_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND ti.parametros_envioNomina_id = 4
					AND liqn.contrato_id = c.contrato_id),'') dias_licenciaM,

            IFNULL((SELECT GROUP_CONCAT(dlil.valor_liquida SEPARATOR '&')
					FROM detalle_liquidacion_licencia dlil
					INNER JOIN licencia l ON dlil.licencia_id = l.licencia_id
					INNER JOIN detalle_liquidacion_novedad dliqn ON dlil.detalle_liquidacion_novedad_id = dliqn.detalle_liquidacion_novedad_id
					INNER JOIN liquidacion_novedad liqn ON dliqn.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN tipo_incapacidad ti ON l.tipo_incapacidad_id = ti.tipo_incapacidad_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND ti.parametros_envioNomina_id = 4
					AND liqn.contrato_id = c.contrato_id),'') valor_licenciaM,

			IFNULL((SELECT GROUP_CONCAT(dlil.fecha_inicial SEPARATOR '&') fecha_inicial
					FROM detalle_liquidacion_licencia dlil
					INNER JOIN licencia l ON dlil.licencia_id = l.licencia_id
					INNER JOIN detalle_liquidacion_novedad dliqn ON dlil.detalle_liquidacion_novedad_id = dliqn.detalle_liquidacion_novedad_id
					INNER JOIN liquidacion_novedad liqn ON dliqn.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN tipo_incapacidad ti ON l.tipo_incapacidad_id = ti.tipo_incapacidad_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND ti.parametros_envioNomina_id = 6
					AND liqn.contrato_id = c.contrato_id),'') fecha_inicio_licenciaR,
			
			IFNULL((SELECT GROUP_CONCAT(dlil.fecha_final SEPARATOR '&') fecha_final
					FROM detalle_liquidacion_licencia dlil
					INNER JOIN licencia l ON dlil.licencia_id = l.licencia_id
					INNER JOIN detalle_liquidacion_novedad dliqn ON dlil.detalle_liquidacion_novedad_id = dliqn.detalle_liquidacion_novedad_id
					INNER JOIN liquidacion_novedad liqn ON dliqn.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN tipo_incapacidad ti ON l.tipo_incapacidad_id = ti.tipo_incapacidad_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND ti.parametros_envioNomina_id = 6
					AND liqn.contrato_id = c.contrato_id),'') fecha_final_licenciaR,
			
			IFNULL((SELECT GROUP_CONCAT(dlil.dias_liquida SEPARATOR '&') dias
					FROM detalle_liquidacion_licencia dlil
					INNER JOIN licencia l ON dlil.licencia_id = l.licencia_id
					INNER JOIN detalle_liquidacion_novedad dliqn ON dlil.detalle_liquidacion_novedad_id = dliqn.detalle_liquidacion_novedad_id
					INNER JOIN liquidacion_novedad liqn ON dliqn.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN tipo_incapacidad ti ON l.tipo_incapacidad_id = ti.tipo_incapacidad_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND ti.parametros_envioNomina_id = 6
					AND liqn.contrato_id = c.contrato_id),'') dias_licenciaR,
			
			IFNULL((SELECT GROUP_CONCAT(dlil.valor_liquida SEPARATOR '&')
					FROM detalle_liquidacion_licencia dlil
					INNER JOIN licencia l ON dlil.licencia_id = l.licencia_id
					INNER JOIN detalle_liquidacion_novedad dliqn ON dlil.detalle_liquidacion_novedad_id = dliqn.detalle_liquidacion_novedad_id
					INNER JOIN liquidacion_novedad liqn ON dliqn.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN tipo_incapacidad ti ON l.tipo_incapacidad_id = ti.tipo_incapacidad_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND ti.parametros_envioNomina_id = 6
					AND liqn.contrato_id = c.contrato_id),'') valor_licenciaR,

			IFNULL((SELECT GROUP_CONCAT(dlil.fecha_inicial SEPARATOR '&') fecha_inicial
					FROM detalle_liquidacion_licencia dlil
					INNER JOIN licencia l ON dlil.licencia_id = l.licencia_id
					INNER JOIN detalle_liquidacion_novedad dliqn ON dlil.detalle_liquidacion_novedad_id = dliqn.detalle_liquidacion_novedad_id
					INNER JOIN liquidacion_novedad liqn ON dliqn.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN tipo_incapacidad ti ON l.tipo_incapacidad_id = ti.tipo_incapacidad_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND ti.parametros_envioNomina_id = 5
					AND liqn.contrato_id = c.contrato_id),'') fecha_inicio_licenciaNR,
            
			IFNULL((SELECT GROUP_CONCAT(dlil.fecha_final SEPARATOR '&') fecha_final
					FROM detalle_liquidacion_licencia dlil
					INNER JOIN licencia l ON dlil.licencia_id = l.licencia_id
					INNER JOIN detalle_liquidacion_novedad dliqn ON dlil.detalle_liquidacion_novedad_id = dliqn.detalle_liquidacion_novedad_id
					INNER JOIN liquidacion_novedad liqn ON dliqn.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN tipo_incapacidad ti ON l.tipo_incapacidad_id = ti.tipo_incapacidad_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND ti.parametros_envioNomina_id = 5
					AND liqn.contrato_id = c.contrato_id),'') fecha_final_licenciaNR,

			IFNULL((SELECT GROUP_CONCAT(dlil.dias_liquida SEPARATOR '&') dias
					FROM detalle_liquidacion_licencia dlil
					INNER JOIN licencia l ON dlil.licencia_id = l.licencia_id
					INNER JOIN detalle_liquidacion_novedad dliqn ON dlil.detalle_liquidacion_novedad_id = dliqn.detalle_liquidacion_novedad_id
					INNER JOIN liquidacion_novedad liqn ON dliqn.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN tipo_incapacidad ti ON l.tipo_incapacidad_id = ti.tipo_incapacidad_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND ti.parametros_envioNomina_id = 5
					AND liqn.contrato_id = c.contrato_id),'') dias_licenciaNR,

			IFNULL((SELECT GROUP_CONCAT(dlil.valor_liquida SEPARATOR '&')
					FROM detalle_liquidacion_licencia dlil
					INNER JOIN licencia l ON dlil.licencia_id = l.licencia_id
					INNER JOIN detalle_liquidacion_novedad dliqn ON dlil.detalle_liquidacion_novedad_id = dliqn.detalle_liquidacion_novedad_id
					INNER JOIN liquidacion_novedad liqn ON dliqn.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN tipo_incapacidad ti ON l.tipo_incapacidad_id = ti.tipo_incapacidad_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND ti.parametros_envioNomina_id = 5
					AND liqn.contrato_id = c.contrato_id),'') valor_licenciaNR,

				'' inicio_huelga,'' fin_huelga,'' cantidad_huelga,

			IFNULL((SELECT GROUP_CONCAT(dlil.fecha_inicial SEPARATOR '&') fecha_inicial
					FROM detalle_liquidacion_licencia dlil
					INNER JOIN licencia l ON dlil.licencia_id = l.licencia_id
					INNER JOIN detalle_liquidacion_novedad dliqn ON dlil.detalle_liquidacion_novedad_id = dliqn.detalle_liquidacion_novedad_id
					INNER JOIN liquidacion_novedad liqn ON dliqn.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN tipo_incapacidad ti ON l.tipo_incapacidad_id = ti.tipo_incapacidad_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND ti.parametros_envioNomina_id = 1
					AND liqn.contrato_id = c.contrato_id),'') fecha_inicio_IncapacidadGen,

			IFNULL((SELECT GROUP_CONCAT(dlil.fecha_final SEPARATOR '&') fecha_final
					FROM detalle_liquidacion_licencia dlil
					INNER JOIN licencia l ON dlil.licencia_id = l.licencia_id
					INNER JOIN detalle_liquidacion_novedad dliqn ON dlil.detalle_liquidacion_novedad_id = dliqn.detalle_liquidacion_novedad_id
					INNER JOIN liquidacion_novedad liqn ON dliqn.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN tipo_incapacidad ti ON l.tipo_incapacidad_id = ti.tipo_incapacidad_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND ti.parametros_envioNomina_id = 1
					AND liqn.contrato_id = c.contrato_id),'') fecha_final_incapacidadGen,

			IFNULL((SELECT GROUP_CONCAT(dlil.dias_liquida SEPARATOR '&') dias 
					FROM detalle_liquidacion_licencia dlil
					INNER JOIN licencia l ON dlil.licencia_id = l.licencia_id
					INNER JOIN detalle_liquidacion_novedad dliqn ON dlil.detalle_liquidacion_novedad_id = dliqn.detalle_liquidacion_novedad_id
					INNER JOIN liquidacion_novedad liqn ON dliqn.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN tipo_incapacidad ti ON l.tipo_incapacidad_id = ti.tipo_incapacidad_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND ti.parametros_envioNomina_id = 1
					AND liqn.contrato_id = c.contrato_id),'') dias_incapacidadGen,

			IFNULL((SELECT GROUP_CONCAT(dlil.valor_liquida SEPARATOR '&')
					FROM detalle_liquidacion_licencia dlil
					INNER JOIN licencia l ON dlil.licencia_id = l.licencia_id
					INNER JOIN detalle_liquidacion_novedad dliqn ON dlil.detalle_liquidacion_novedad_id = dliqn.detalle_liquidacion_novedad_id
					INNER JOIN liquidacion_novedad liqn ON dliqn.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN tipo_incapacidad ti ON l.tipo_incapacidad_id = ti.tipo_incapacidad_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND ti.parametros_envioNomina_id = 1
					AND liqn.contrato_id = c.contrato_id),'') valor_incapacidadGen,
            
            (SELECT GROUP_CONCAT('1' SEPARATOR '&')
					FROM detalle_liquidacion_licencia dlil
					INNER JOIN licencia l ON dlil.licencia_id = l.licencia_id
					INNER JOIN detalle_liquidacion_novedad dliqn ON dlil.detalle_liquidacion_novedad_id = dliqn.detalle_liquidacion_novedad_id
					INNER JOIN liquidacion_novedad liqn ON dliqn.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN tipo_incapacidad ti ON l.tipo_incapacidad_id = ti.tipo_incapacidad_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND ti.parametros_envioNomina_id = 1
					AND liqn.contrato_id = c.contrato_id) tipo_incapacidadGen,

			IFNULL((SELECT GROUP_CONCAT(dlil.fecha_inicial SEPARATOR '&') fecha_inicial
					FROM detalle_liquidacion_licencia dlil
					INNER JOIN licencia l ON dlil.licencia_id = l.licencia_id
					INNER JOIN detalle_liquidacion_novedad dliqn ON dlil.detalle_liquidacion_novedad_id = dliqn.detalle_liquidacion_novedad_id
					INNER JOIN liquidacion_novedad liqn ON dliqn.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN tipo_incapacidad ti ON l.tipo_incapacidad_id = ti.tipo_incapacidad_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND ti.parametros_envioNomina_id = 2
					AND liqn.contrato_id = c.contrato_id),'') fecha_inicio_IncapacidadProf,

			IFNULL((SELECT GROUP_CONCAT(dlil.fecha_final SEPARATOR '&') fecha_final
					FROM detalle_liquidacion_licencia dlil
					INNER JOIN licencia l ON dlil.licencia_id = l.licencia_id
					INNER JOIN detalle_liquidacion_novedad dliqn ON dlil.detalle_liquidacion_novedad_id = dliqn.detalle_liquidacion_novedad_id
					INNER JOIN liquidacion_novedad liqn ON dliqn.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN tipo_incapacidad ti ON l.tipo_incapacidad_id = ti.tipo_incapacidad_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND ti.parametros_envioNomina_id = 2
					AND liqn.contrato_id = c.contrato_id),'') fecha_final_incapacidadProf,

			IFNULL((SELECT GROUP_CONCAT(dlil.dias_liquida SEPARATOR '&') dias
					FROM detalle_liquidacion_licencia dlil
					INNER JOIN licencia l ON dlil.licencia_id = l.licencia_id
					INNER JOIN detalle_liquidacion_novedad dliqn ON dlil.detalle_liquidacion_novedad_id = dliqn.detalle_liquidacion_novedad_id
					INNER JOIN liquidacion_novedad liqn ON dliqn.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN tipo_incapacidad ti ON l.tipo_incapacidad_id = ti.tipo_incapacidad_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND ti.parametros_envioNomina_id = 2
					AND liqn.contrato_id = c.contrato_id),'') dias_incapacidadProf,

			IFNULL((SELECT GROUP_CONCAT(dlil.valor_liquida SEPARATOR '&')
					FROM detalle_liquidacion_licencia dlil
					INNER JOIN licencia l ON dlil.licencia_id = l.licencia_id
					INNER JOIN detalle_liquidacion_novedad dliqn ON dlil.detalle_liquidacion_novedad_id = dliqn.detalle_liquidacion_novedad_id
					INNER JOIN liquidacion_novedad liqn ON dliqn.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN tipo_incapacidad ti ON l.tipo_incapacidad_id = ti.tipo_incapacidad_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND ti.parametros_envioNomina_id = 2
					AND liqn.contrato_id = c.contrato_id),'') valor_incapacidadProf,
            
            (SELECT GROUP_CONCAT('2' SEPARATOR '&')
					FROM detalle_liquidacion_licencia dlil
					INNER JOIN licencia l ON dlil.licencia_id = l.licencia_id
					INNER JOIN detalle_liquidacion_novedad dliqn ON dlil.detalle_liquidacion_novedad_id = dliqn.detalle_liquidacion_novedad_id
					INNER JOIN liquidacion_novedad liqn ON dliqn.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN tipo_incapacidad ti ON l.tipo_incapacidad_id = ti.tipo_incapacidad_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND ti.parametros_envioNomina_id = 2
					AND liqn.contrato_id = c.contrato_id) tipo_incapacidadProf,

			IFNULL((SELECT GROUP_CONCAT(dlil.fecha_inicial SEPARATOR '&') fecha_inicial
					FROM detalle_liquidacion_licencia dlil
					INNER JOIN licencia l ON dlil.licencia_id = l.licencia_id
					INNER JOIN detalle_liquidacion_novedad dliqn ON dlil.detalle_liquidacion_novedad_id = dliqn.detalle_liquidacion_novedad_id
					INNER JOIN liquidacion_novedad liqn ON dliqn.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN tipo_incapacidad ti ON l.tipo_incapacidad_id = ti.tipo_incapacidad_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND ti.parametros_envioNomina_id = 3
					AND liqn.contrato_id = c.contrato_id),'') fecha_inicio_IncapacidadLab,

			IFNULL((SELECT GROUP_CONCAT(dlil.fecha_final SEPARATOR '&') fecha_final
					FROM detalle_liquidacion_licencia dlil
					INNER JOIN licencia l ON dlil.licencia_id = l.licencia_id
					INNER JOIN detalle_liquidacion_novedad dliqn ON dlil.detalle_liquidacion_novedad_id = dliqn.detalle_liquidacion_novedad_id
					INNER JOIN liquidacion_novedad liqn ON dliqn.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN tipo_incapacidad ti ON l.tipo_incapacidad_id = ti.tipo_incapacidad_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND ti.parametros_envioNomina_id = 3
					AND liqn.contrato_id = c.contrato_id),'') fecha_final_incapacidadLab,

			IFNULL((SELECT GROUP_CONCAT(dlil.dias_liquida SEPARATOR '&') dias
					FROM detalle_liquidacion_licencia dlil
					INNER JOIN licencia l ON dlil.licencia_id = l.licencia_id
					INNER JOIN detalle_liquidacion_novedad dliqn ON dlil.detalle_liquidacion_novedad_id = dliqn.detalle_liquidacion_novedad_id
					INNER JOIN liquidacion_novedad liqn ON dliqn.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN tipo_incapacidad ti ON l.tipo_incapacidad_id = ti.tipo_incapacidad_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND ti.parametros_envioNomina_id = 3
					AND liqn.contrato_id = c.contrato_id),'') dias_incapacidadLab,

			IFNULL((SELECT GROUP_CONCAT(dlil.valor_liquida SEPARATOR '&')
					FROM detalle_liquidacion_licencia dlil
					INNER JOIN licencia l ON dlil.licencia_id = l.licencia_id
					INNER JOIN detalle_liquidacion_novedad dliqn ON dlil.detalle_liquidacion_novedad_id = dliqn.detalle_liquidacion_novedad_id
					INNER JOIN liquidacion_novedad liqn ON dliqn.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN tipo_incapacidad ti ON l.tipo_incapacidad_id = ti.tipo_incapacidad_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND ti.parametros_envioNomina_id = 3
					AND liqn.contrato_id = c.contrato_id),'') valor_incapacidadLab,
            
            (SELECT GROUP_CONCAT('3' SEPARATOR '&')
					FROM detalle_liquidacion_licencia dlil
					INNER JOIN licencia l ON dlil.licencia_id = l.licencia_id
					INNER JOIN detalle_liquidacion_novedad dliqn ON dlil.detalle_liquidacion_novedad_id = dliqn.detalle_liquidacion_novedad_id
					INNER JOIN liquidacion_novedad liqn ON dliqn.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN tipo_incapacidad ti ON l.tipo_incapacidad_id = ti.tipo_incapacidad_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND ti.parametros_envioNomina_id = 3
					AND liqn.contrato_id = c.contrato_id) tipo_incapacidadLab,

			IFNULL((SELECT  SUM(dlin.debito)-SUM(dlin.credito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 8),0) montoAnticipo, 
			
			IFNULL((SELECT SUM(dlin.debito)-SUM(dlin.credito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 27),0) valor_pago_tercero_dev,

			IFNULL((SELECT SUM(dlin.debito)-SUM(dlin.credito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 33),0) apoyo_sostenimiento,

			'0' bonificacion_retiro, 
			
			'0' dotacion,

            (SELECT ldi.valor FROM liquidacion_definitiva ld 
					INNER JOIN liq_def_indemnizacion ldi ON ld.liquidacion_definitiva_id = ldi.liquidacion_definitiva_id
					WHERE ld.estado = 'C' AND ldi.fecha_fin BETWEEN '$desde' AND '$hasta' AND ld.contrato_id = c.contrato_id) valor_indemnizacion,

			IFNULL((SELECT SUM(dlin.debito)-SUM(dlin.credito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 9),0) reintegro_de_empresa,

			IFNULL((SELECT SUM(dlin.debito)-SUM(dlin.credito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 10),0) valor_teletrabajo, 

			IFNULL((SELECT SUM(dlin.debito)-SUM(dlin.credito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 11),0) auxilioS,

			IFNULL((SELECT SUM(dlin.debito)-SUM(dlin.credito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 12),0) auxilioNS,

			(SUM(IF(dl.concepto='INGRESO NO SALARIAL',dl.debito,0))+IFNULL((SELECT SUM(dlin.debito)-SUM(dlin.credito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 14),0)) AS bonificacion_no_salarial,

			IFNULL((SELECT SUM(dlin.debito)-SUM(dlin.credito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 13),0) bonificacionS,

			IFNULL((SELECT SUM(dlin.debito)-SUM(dlin.credito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 34),0) pAlimentacionNs,

			IFNULL((SELECT SUM(dlin.debito)-SUM(dlin.credito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 15),0) pAlimentacionS,

			IFNULL((SELECT SUM(dlin.debito)-SUM(dlin.credito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 35),0) pagosS,
						
			IFNULL((SELECT SUM(dlin.debito)-SUM(dlin.credito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 36),0) pagosNs,

			IFNULL((SELECT SUM(dlin.debito)-SUM(dlin.credito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 16),0) compensacion_ordinaria,
						
			IFNULL((SELECT SUM(dlin.debito)-SUM(dlin.credito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 17),0) compensacion_extraordinaria,

			IFNULL((SELECT dlin.concepto FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id IN (37,38)),0) descripcion_concepto,
						
			IFNULL((SELECT SUM(dlin.debito)-SUM(dlin.credito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 38),0) concepto_no_salarial,
						
			IFNULL((SELECT SUM(dlin.debito)-SUM(dlin.credito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 37),0) concepto_salarial,

			IFNULL((SELECT SUM(dlin.credito)-SUM(dlin.debito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 18),0) afc,
						
			IFNULL((SELECT SUM(dlin.credito)-SUM(dlin.debito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 19),0) cooperativa,
			
			IFNULL((SELECT SUM(dlin.credito)-SUM(dlin.debito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 20),0) deuda,
						
			IFNULL((SELECT SUM(dlin.credito)-SUM(dlin.debito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 21),0) educacion,
			
			IFNULL((SELECT SUM(dlin.credito)-SUM(dlin.debito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 22),0) embargo,	

			IFNULL((SELECT SUM(dlin.credito)-SUM(dlin.debito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 39),0)	pension_voluntaria,					

			IFNULL((SELECT SUM(dlin.credito)-SUM(dlin.debito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 23),0) plan_complementario_salud,
		
			IFNULL((SELECT SUM(dlin.credito)-SUM(dlin.debito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 24),0) reintegro_de_trabajador,

			(SUM(IF(dl.concepto='LIQUIDACION RETENCION',dl.debito,0)))+IFNULL((SELECT SUM(dlin.credito)-SUM(dlin.debito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 40),0) retencion_fuente,

			IFNULL((SELECT SUM(dlin.credito)-SUM(dlin.debito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 25),0) anticipo_nomina,

			IFNULL((SELECT SUM(dlin.credito)-SUM(dlin.debito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 26),0) deduccion_libranza,
					
			IFNULL((SELECT dlin.concepto FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 26),'') descripcion_libranza,

			IFNULL((SELECT SUM(dlin.credito)-SUM(dlin.debito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 32),0) pago_a_tercero,
						
			IFNULL((SELECT SUM(dlin.credito)-SUM(dlin.debito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 28),0) sancion_publica,

			IFNULL((SELECT SUM(dlin.credito)-SUM(dlin.debito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 29),0) sancion_privada,

			'' pago_sindicato,'' porcentaje_sindicato,

			IFNULL((SELECT SUM(dlin.credito)-SUM(dlin.debito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 31),0) otra_deduccion,


            
            '' AS dias_incapacidad,
            '' AS dias_licencia,
            (SELECT ca.nombre_cargo	FROM cargo ca  WHERE  c.cargo_id=ca.cargo_id) AS cargo, c.sueldo_base
            
            


            FROM liquidacion_novedad ln, contrato c, empleado e, tercero t, detalle_liquidacion_novedad dl, centro_de_costo cc, oficina of, ubicacion u, tipo_contrato tc
            WHERE ln.fecha_inicial BETWEEN '$desde' AND '$hasta' AND ln.fecha_final BETWEEN '$desde' AND '$hasta'
            AND dl.liquidacion_novedad_id=ln.liquidacion_novedad_id AND c.contrato_id=ln.contrato_id AND e.empleado_id=c.empleado_id 
            AND t.tercero_id=e.tercero_id AND cc.centro_de_costo_id=c.centro_de_costo_id AND of.oficina_id=cc.oficina_id AND tc.tipo_contrato_id=c.tipo_contrato_id
            AND u.ubicacion_id=of.ubicacion_id AND ln.estado = 'C' AND ln.reportado IS NULL
            GROUP BY ln.contrato_id
            ORDER BY CONCAT_WS(' ',t.primer_nombre, t.segundo_nombre,t.primer_apellido,t.segundo_apellido)   ASC, ln.fecha_final DESC";
		
		$result = $this -> DbFetchAll($select,$Conex,true);
		
		return $result;
    }
	
	
	public function getReporteEnviar($desde, $hasta,$empresa_id,$empleado_id='', $Conex) {
		
		$select = "SELECT ln.*,
            (SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido)AS nombre_emp FROM empresa e, tercero t WHERE e.empresa_id = $empresa_id AND e.tercero_id=t.tercero_id) AS nombre_empresa,
            (SELECT CONCAT_WS(' - ',t.numero_identificacion,t.digito_verificacion)AS nit_emp FROM empresa e, tercero t WHERE e.empresa_id = $empresa_id AND e.tercero_id=t.tercero_id) AS nit_empresa,					
            (SELECT ti.codigo FROM  tipo_identificacion ti  WHERE  ti.tipo_identificacion_id=t.tipo_identificacion_id) AS tipoidentificacion, 
            t.numero_identificacion AS identificacion,  t.primer_nombre,t.segundo_nombre AS otros_nombres,t.primer_apellido,t.segundo_apellido,
            IF(u.divipola=11001,11,(SELECT ub.divipola FROM ubicacion ub WHERE ub.ubicacion_id=u.ubi_ubicacion_id )) AS departamento,
            u.divipola AS municipio,
            '' AS codtrabajador,
            of.direccion  AS lugar_trabajo,
            t.email AS email_trabajador,
            tc.codigo_electronica AS tipocontrato,
            tc.integral AS salariointegral,
            '0' AS altoRiesgopension,
            '00'  AS subtipoTrabajador,
            '01' AS tipoTrabajador,
            IF(u.divipola=11001,11,(SELECT ub.divipola FROM ubicacion ub WHERE ub.ubicacion_id=u.ubi_ubicacion_id )) AS depar_generacion,
            'es' AS idioma,
            u.divipola AS municipioGen,
            c.fecha_inicio AS fechaingreso,
            c.fecha_terminacion_real AS fecharetiro,
			TIMESTAMPDIFF(DAY, c.fecha_inicio, '$hasta') dias_trabajados,
            MAX(ln.fecha_registro) AS fechaEmision,
            CASE ln.periodicidad WHEN 'Q' THEN '4' WHEN 'M' THEN '5' WHEN 'S' THEN '1' WHEN 'T' THEN IF(DATEDIFF(ln.fecha_final, ln.fecha_inicial) BETWEEN 13 AND 16,'Q','M') END AS periodoNomina,
			(SELECT pn.prefijo FROM param_nomina_electronica pn WHERE pn.param_nom_electronica_id=ln.param_nom_electronica_id) prefijo_rango,
            (SELECT IF((SELECT consecutivo_nom
						FROM liquidacion_novedad 
						WHERE consecutivo_nom IS NOT NULL ORDER BY CAST(consecutivo_nom AS DECIMAL) DESC  LIMIT 1) IS NOT NULL, 
						(SELECT consecutivo_nom+1
						FROM liquidacion_novedad 
						WHERE consecutivo_nom IS NOT NULL ORDER BY CAST(consecutivo_nom AS DECIMAL) DESC  LIMIT 1),pn.rango_comienza+1)
			FROM param_nomina_electronica pn) num_rango,
			(SELECT pn.rango_inicial FROM param_nomina_electronica pn WHERE pn.param_nom_electronica_id=ln.param_nom_electronica_id) numini_rango,
            'COP' AS tipoMoneda,
            '' AS trm,
            '0.00' AS redondeo,
            IFNULL((SELECT GROUP_CONCAT(DISTINCT IF(fp.codigo_electronica IS NOT NULL, fp.codigo_electronica, '1') SEPARATOR '&') 
				FROM  abono_nomina an, relacion_abono_nomina ra, cuenta_tipo_pago ct, forma_pago fp, liquidacion_novedad ln2 
            WHERE ra.liquidacion_novedad_id = ln2.liquidacion_novedad_id AND an.abono_nomina_id=ra.abono_nomina_id AND ln2.contrato_id = ln.contrato_id AND ln2.estado = 'C' AND an.estado_abono_nomina='C' AND ct.cuenta_tipo_pago_id=an.cuenta_tipo_pago_id AND fp.forma_pago_id=ct.forma_pago_id AND ln2.fecha_inicial BETWEEN '$desde' AND '$hasta' AND ln2.fecha_final BETWEEN '$desde' AND '$hasta'),1) AS metododePago,
            '1' AS medioPago,
            (SELECT b.nombre_banco FROM banco b WHERE b.banco_id=c.banco_id) AS nombreBanco,
            (SELECT tc.nombre_tipo_cuenta FROM  tipo_cuenta tc WHERE tc.tipo_cta_id=c.tipo_cta_id) AS tipoCuenta,
            c.numcuenta_proveedor AS numeroCuenta,
            

            (SELECT GROUP_CONCAT(dl.fecha_final SEPARATOR '&') fecha_final 
		    FROM detalle_liquidacion_novedad dl,liquidacion_novedad liqn 
			WHERE liqn.liquidacion_novedad_id = dl.liquidacion_novedad_id AND dl.tercero_id = t.tercero_id 
			AND concepto like 'SALARIO%' AND dl.fecha_final >= '$desde' AND dl.fecha_final <= '$hasta' and liqn.estado = 'C') pagos_nomina,

			SUM(IF(dl.concepto='SUELDO PAGAR',dl.credito,0)) AS total_comprobante,	
			SUM(IF(dl.sueldo_pagar != 1,dl.credito,0)) AS total_deduccion,	

			IFNULL((SELECT SUM(lq.valor_pagos) FROM liquidacion_vacaciones lq WHERE lq.inicial = 0 AND lq.contrato_id = c.contrato_id AND lq.fecha_liquidacion>='$desde' AND lq.fecha_liquidacion<='$hasta'),0)+IFNULL((SELECT SUM(lq.valor) FROM liquidacion_vacaciones lq WHERE lq.inicial = 0 AND lq.contrato_id = c.contrato_id AND lq.fecha_liquidacion>='$desde' AND lq.fecha_liquidacion<='$hasta'),0)+IFNULL((SELECT SUM(valor_liquidacion) FROM liquidacion_cesantias WHERE estado = 'C' AND inicial = 0 AND contrato_id = c.contrato_id AND fecha_liquidacion BETWEEN '$desde' AND '$hasta'),0)+IFNULL((SELECT SUM(total) valor_prima FROM liquidacion_prima 
			WHERE contrato_id = c.contrato_id AND fecha_liquidacion >='$desde' AND fecha_liquidacion <= '$hasta' AND estado = 'C'),0)+(SELECT IFNULL((SELECT SUM(valor_liquidacion) FROM liquidacion_int_cesantias WHERE contrato_id = c.contrato_id AND inicial = 0 AND fecha_liquidacion BETWEEN '$desde' AND '$hasta'),0)) + SUM(IF(dl.sueldo_pagar != 1,dl.debito,0)) AS total_devengado,

			'102' AS tipo_documento, '0' AS  novedad, '' AS novedad_cune, '' AS tipo_nota, 'null' AS fecha_gen_pred, 
            '' AS cune_pred, '' AS numero_pred,
            SUM(IF(dl.concepto='SALARIO',dl.dias,0)) AS dias,
            SUM(IF(dl.concepto='SALARIO',dl.debito,0)) AS sueldo_trabajado,
						
			SUM(IF(dl.concepto = 'AUX TRANSPORTE',dl.debito,0)) AS auxilio_transporte,
			'0' AS viatico_manu_alo_s,

			IFNULL((SELECT SUM(dlin.debito)-SUM(dlin.credito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 41),0) viatico_manu_alo_ns,

			SUM(IF(dl.concepto IN('SALUD'),dl.credito,0)) AS deduccion_salud,
			
			(SELECT dp.desc_emple_salud FROM datos_periodo dp
				INNER JOIN periodo_contable pc ON dp.periodo_contable_id = pc.periodo_contable_id
				WHERE anio = SUBSTRING('$desde', 1, 4)) porcentaje_salud,

			SUM(IF(dl.concepto IN('PENSION'),dl.credito,0)) AS deduccion_pension,
			
			(SELECT dp.desc_emple_pension FROM datos_periodo dp
				INNER JOIN periodo_contable pc ON dp.periodo_contable_id = pc.periodo_contable_id
				WHERE anio = SUBSTRING('$desde', 1, 4)) porcentaje_pension,

			SUM(IF(dl.concepto IN('FONDO PENSIONAL'),dl.credito,0)) deduccion_solidaridad_pensional,
			
			(SELECT desc_emple_fonpension FROM datos_periodo dp
				INNER JOIN periodo_contable pc ON dp.periodo_contable_id = pc.periodo_contable_id
				WHERE anio = SUBSTRING('$desde', 1, 4)) porcentaje_solidaridad_pensional,	

			'' deduccion_subsistencia,'' porcentaje_subsistencia,

            IFNULL((SELECT dias_liquidados FROM liquidacion_prima WHERE contrato_id = c.contrato_id AND estado = 'C' AND fecha_liquidacion BETWEEN '$desde' AND '$hasta' ),'0') AS dias_prima,
						
			IFNULL((SELECT total valor_prima FROM liquidacion_prima 
			WHERE contrato_id = c.contrato_id AND fecha_liquidacion >= '$desde' AND fecha_liquidacion <= '$hasta' AND estado = 'C'),'0') pago_prima,

			'0' prima_no_salarial,

			IFNULL((SELECT valor_liquidacion FROM liquidacion_cesantias WHERE estado = 'C' AND inicial = 0 AND contrato_id = c.contrato_id AND fecha_liquidacion BETWEEN '$desde' AND '$hasta'),'0') pago_cesantias,

			IFNULL((SELECT valor_liquidacion FROM liquidacion_int_cesantias WHERE estado = 'C' AND inicial = 0 AND contrato_id = c.contrato_id AND fecha_liquidacion BETWEEN '$desde' AND '$hasta'),'0') valor_intereses_cesantias,

			IF((SELECT valor_liquidacion FROM liquidacion_int_cesantias WHERE estado = 'C' AND inicial = 0 AND contrato_id = c.contrato_id AND fecha_liquidacion BETWEEN '$desde' AND '$hasta') > 1,(SELECT dp.desc_empre_int_cesantias FROM datos_periodo dp
			INNER JOIN periodo_contable pc ON dp.periodo_contable_id = pc.periodo_contable_id
			WHERE anio = SUBSTRING('$desde', 1, 4)),'') porcentaje_intereses_cesantias, 
				
				IFNULL((SELECT SUM(dlin.debito)-SUM(dlin.credito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 7),0) monto_comision, 
            
            '' horaInicio_extra_diurno, '' horaFin_extra_diurno,

            SUM(IF(dl.concepto = 'HORAS EXTRAS DIURNAS',dl.cant_horas_extras,0)) cantidad_horasE_diurnas,

            SUM(IF(dl.concepto = 'HORAS EXTRAS DIURNAS',dl.debito,0)) valor_horasE_diurnas,

			(SELECT dp.val_hr_ext_diurna-100 FROM datos_periodo dp
				INNER JOIN periodo_contable pc ON dp.periodo_contable_id = pc.periodo_contable_id
				WHERE anio = SUBSTRING('$desde', 1, 4)) porcentaje_extra_diurno,

            '' horaInicio_extra_nocturno, '' horaFin_extra_nocturno,

            SUM(IF(dl.concepto = 'HORAS EXTRAS NOCTURNAS',dl.cant_horas_extras,0)) cantidad_horasE_nocturno,

            SUM(IF(dl.concepto = 'HORAS EXTRAS NOCTURNAS',dl.debito,0)) valor_horasE_nocturno,
            
			(SELECT dp.val_hr_ext_nocturna-100 FROM datos_periodo dp
				INNER JOIN periodo_contable pc ON dp.periodo_contable_id = pc.periodo_contable_id
				WHERE anio = SUBSTRING('$desde', 1, 4)) porcentaje_extra_nocturno,
            
             '' horaInicio_recargo_nocturno, '' horaFin_recargo_nocturno,

            SUM(IF(dl.concepto = 'RECARGO NOCTURNO',dl.cant_horas_extras,0)) cantidad_horasR_nocturno,

            SUM(IF(dl.concepto = 'RECARGO NOCTURNO',dl.debito,0)) valor_horasR_nocturno,
					
			(SELECT dp.val_recargo_nocturna-100 FROM datos_periodo dp
				INNER JOIN periodo_contable pc ON dp.periodo_contable_id = pc.periodo_contable_id
				WHERE anio = SUBSTRING('$desde', 1, 4)) porcentaje_recargo_nocturno,
            
			'' horaInicio_Extra_diurnofes, '' horaFin_extra_diurnofes,

			SUM(IF(dl.concepto = 'HORAS EXTRAS FEST DIURNAS',dl.cant_horas_extras,0)) cantidad_horasE_diurnofes,

			SUM(IF(dl.concepto = 'HORAS EXTRAS FEST DIURNAS',dl.debito,0)) valor_horasE_diurnofes,

			(SELECT dp.val_hr_ext_festiva_diurna-100 FROM datos_periodo dp
				INNER JOIN periodo_contable pc ON dp.periodo_contable_id = pc.periodo_contable_id
				WHERE anio = SUBSTRING('$desde', 1, 4)) porcentaje_extra_diurnofes,

            '' horaInicio_recargo_diurnofes, '' horaFin_recargo_diurnofes,
			
			SUM(IF(dl.concepto = 'DOMINICALES FESTIVO',dl.cant_horas_extras,0)) cantidad_horasR_diurnofes,

			SUM(IF(dl.concepto = 'DOMINICALES FESTIVO',dl.debito,0)) valor_horasR_diurnofes,

			(SELECT dp.val_recargo_dominical-100 FROM datos_periodo dp
				INNER JOIN periodo_contable pc ON dp.periodo_contable_id = pc.periodo_contable_id
				WHERE anio = SUBSTRING('$desde', 1, 4)) porcentaje_recargo_diurnofes,

			'' horaInicio_Extra_nocturnofes, '' horaFin_extra_nocturnofes,

			SUM(IF(dl.concepto = 'HORAS EXTRAS FEST NOCTURNAS',dl.cant_horas_extras,0)) cantidad_horasE_nocturnofes,

			SUM(IF(dl.concepto = 'HORAS EXTRAS FEST NOCTURNAS',dl.debito,0)) valor_horasE_nocturnofes,
					
			(SELECT dp.val_hr_ext_festiva_nocturna-100 FROM datos_periodo dp
				INNER JOIN periodo_contable pc ON dp.periodo_contable_id = pc.periodo_contable_id
				WHERE anio = SUBSTRING('$desde', 1, 4)) porcentaje_extra_nocturnofes,

            '' horaInicio_recargo_nocturnofes, '' horaFin_recargo_nocturnofes,	'0' cantidad_horasR_nocturnofes,		
			'0' valor_horasR_nocturnofes,
            '' porcentaje_recargo_nocturnofes,

            IFNULL((SELECT lq.fecha_dis_inicio FROM liquidacion_vacaciones lq 
                WHERE lq.inicial = 0 AND lq.contrato_id = c.contrato_id AND lq.fecha_liquidacion>='$desde' AND lq.fecha_liquidacion<='$hasta'),'null') fecha_inicio_vacaciones,

            IFNULL((SELECT lq.fecha_reintegro FROM liquidacion_vacaciones lq 
                WHERE lq.inicial = 0 AND lq.contrato_id = c.contrato_id AND lq.fecha_liquidacion>='$desde' AND lq.fecha_liquidacion<='$hasta'),'null') fecha_final_vacaciones,

            IFNULL((SELECT lq.dias FROM liquidacion_vacaciones lq 
                WHERE lq.inicial = 0 AND lq.contrato_id = c.contrato_id AND lq.fecha_liquidacion>='$desde' AND lq.fecha_liquidacion<='$hasta'),'0') dias_vacaciones,

            IFNULL((SELECT lq.valor FROM liquidacion_vacaciones lq 
                WHERE lq.inicial = 0 AND lq.contrato_id = c.contrato_id AND lq.fecha_liquidacion>='$desde' AND lq.fecha_liquidacion<='$hasta'),'0') valor_liquidacion_vacaciones,
            
            IF((SELECT lq.dias FROM liquidacion_vacaciones lq 
                WHERE lq.inicial = 0 AND lq.contrato_id = c.contrato_id AND lq.fecha_liquidacion>='$desde' AND lq.fecha_liquidacion<='$hasta')>1,'1','1')  tipo_vacaciones,

            IFNULL((SELECT lq.dias_pagados FROM liquidacion_vacaciones lq 
                WHERE lq.inicial = 0 AND lq.contrato_id = c.contrato_id AND lq.fecha_liquidacion>='$desde' AND lq.fecha_liquidacion<='$hasta'),'0') dias_compensados_vacaciones,

            IFNULL((SELECT lq.valor_pagos FROM liquidacion_vacaciones lq 
                WHERE lq.inicial = 0 AND lq.contrato_id = c.contrato_id AND lq.fecha_liquidacion>='$desde' AND lq.fecha_liquidacion<='$hasta'),'0') valor_vacaciones_compensadas,

            IF((SELECT lq.dias_pagados FROM liquidacion_vacaciones lq 
                WHERE lq.inicial = 0 AND lq.contrato_id = c.contrato_id AND lq.fecha_liquidacion>='$desde' AND lq.fecha_liquidacion<='$hasta')>1,'2','2')  tipo_vacaciones_compensadas,

				IFNULL((SELECT GROUP_CONCAT(dlil.fecha_inicial SEPARATOR '&') fecha_inicial
					FROM detalle_liquidacion_licencia dlil
					INNER JOIN licencia l ON dlil.licencia_id = l.licencia_id
					INNER JOIN detalle_liquidacion_novedad dliqn ON dlil.detalle_liquidacion_novedad_id = dliqn.detalle_liquidacion_novedad_id
					INNER JOIN liquidacion_novedad liqn ON dliqn.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN tipo_incapacidad ti ON l.tipo_incapacidad_id = ti.tipo_incapacidad_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND ti.parametros_envioNomina_id = 4
					AND liqn.contrato_id = c.contrato_id),'null') fecha_inicio_licenciaM,

            IFNULL((SELECT GROUP_CONCAT(dlil.fecha_final SEPARATOR '&') fecha_final
					FROM detalle_liquidacion_licencia dlil
					INNER JOIN licencia l ON dlil.licencia_id = l.licencia_id
					INNER JOIN detalle_liquidacion_novedad dliqn ON dlil.detalle_liquidacion_novedad_id = dliqn.detalle_liquidacion_novedad_id
					INNER JOIN liquidacion_novedad liqn ON dliqn.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN tipo_incapacidad ti ON l.tipo_incapacidad_id = ti.tipo_incapacidad_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND ti.parametros_envioNomina_id = 4
					AND liqn.contrato_id = c.contrato_id),'null') fecha_final_licenciaM,
            
            IFNULL((SELECT GROUP_CONCAT(dlil.dias_liquida SEPARATOR '&') dias
					FROM detalle_liquidacion_licencia dlil
					INNER JOIN licencia l ON dlil.licencia_id = l.licencia_id
					INNER JOIN detalle_liquidacion_novedad dliqn ON dlil.detalle_liquidacion_novedad_id = dliqn.detalle_liquidacion_novedad_id
					INNER JOIN liquidacion_novedad liqn ON dliqn.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN tipo_incapacidad ti ON l.tipo_incapacidad_id = ti.tipo_incapacidad_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND ti.parametros_envioNomina_id = 4
					AND liqn.contrato_id = c.contrato_id),'0') dias_licenciaM,

            IFNULL((SELECT GROUP_CONCAT(dlil.valor_liquida SEPARATOR '&')
					FROM detalle_liquidacion_licencia dlil
					INNER JOIN licencia l ON dlil.licencia_id = l.licencia_id
					INNER JOIN detalle_liquidacion_novedad dliqn ON dlil.detalle_liquidacion_novedad_id = dliqn.detalle_liquidacion_novedad_id
					INNER JOIN liquidacion_novedad liqn ON dliqn.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN tipo_incapacidad ti ON l.tipo_incapacidad_id = ti.tipo_incapacidad_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND ti.parametros_envioNomina_id = 4
					AND liqn.contrato_id = c.contrato_id),'0') valor_licenciaM,

			IFNULL((SELECT GROUP_CONCAT(dlil.fecha_inicial SEPARATOR '&') fecha_inicial
					FROM detalle_liquidacion_licencia dlil
					INNER JOIN licencia l ON dlil.licencia_id = l.licencia_id
					INNER JOIN detalle_liquidacion_novedad dliqn ON dlil.detalle_liquidacion_novedad_id = dliqn.detalle_liquidacion_novedad_id
					INNER JOIN liquidacion_novedad liqn ON dliqn.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN tipo_incapacidad ti ON l.tipo_incapacidad_id = ti.tipo_incapacidad_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND ti.parametros_envioNomina_id = 6
					AND liqn.contrato_id = c.contrato_id),'null') fecha_inicio_licenciaR,
			
			IFNULL((SELECT GROUP_CONCAT(dlil.fecha_final SEPARATOR '&') fecha_final
					FROM detalle_liquidacion_licencia dlil
					INNER JOIN licencia l ON dlil.licencia_id = l.licencia_id
					INNER JOIN detalle_liquidacion_novedad dliqn ON dlil.detalle_liquidacion_novedad_id = dliqn.detalle_liquidacion_novedad_id
					INNER JOIN liquidacion_novedad liqn ON dliqn.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN tipo_incapacidad ti ON l.tipo_incapacidad_id = ti.tipo_incapacidad_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND ti.parametros_envioNomina_id = 6
					AND liqn.contrato_id = c.contrato_id),'null') fecha_final_licenciaR,
			
			IFNULL((SELECT GROUP_CONCAT(dlil.dias_liquida SEPARATOR '&') dias
					FROM detalle_liquidacion_licencia dlil
					INNER JOIN licencia l ON dlil.licencia_id = l.licencia_id
					INNER JOIN detalle_liquidacion_novedad dliqn ON dlil.detalle_liquidacion_novedad_id = dliqn.detalle_liquidacion_novedad_id
					INNER JOIN liquidacion_novedad liqn ON dliqn.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN tipo_incapacidad ti ON l.tipo_incapacidad_id = ti.tipo_incapacidad_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND ti.parametros_envioNomina_id = 6
					AND liqn.contrato_id = c.contrato_id),'0') dias_licenciaR,
			
			IFNULL((SELECT GROUP_CONCAT(dlil.valor_liquida SEPARATOR '&')
					FROM detalle_liquidacion_licencia dlil
					INNER JOIN licencia l ON dlil.licencia_id = l.licencia_id
					INNER JOIN detalle_liquidacion_novedad dliqn ON dlil.detalle_liquidacion_novedad_id = dliqn.detalle_liquidacion_novedad_id
					INNER JOIN liquidacion_novedad liqn ON dliqn.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN tipo_incapacidad ti ON l.tipo_incapacidad_id = ti.tipo_incapacidad_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND ti.parametros_envioNomina_id = 6
					AND liqn.contrato_id = c.contrato_id),'0') valor_licenciaR,

			IFNULL((SELECT GROUP_CONCAT(dlil.fecha_inicial SEPARATOR '&') fecha_inicial
					FROM detalle_liquidacion_licencia dlil
					INNER JOIN licencia l ON dlil.licencia_id = l.licencia_id
					INNER JOIN detalle_liquidacion_novedad dliqn ON dlil.detalle_liquidacion_novedad_id = dliqn.detalle_liquidacion_novedad_id
					INNER JOIN liquidacion_novedad liqn ON dliqn.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN tipo_incapacidad ti ON l.tipo_incapacidad_id = ti.tipo_incapacidad_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND ti.parametros_envioNomina_id = 5
					AND liqn.contrato_id = c.contrato_id),'null') fecha_inicio_licenciaNR,
            
			IFNULL((SELECT GROUP_CONCAT(dlil.fecha_final SEPARATOR '&') fecha_final
					FROM detalle_liquidacion_licencia dlil
					INNER JOIN licencia l ON dlil.licencia_id = l.licencia_id
					INNER JOIN detalle_liquidacion_novedad dliqn ON dlil.detalle_liquidacion_novedad_id = dliqn.detalle_liquidacion_novedad_id
					INNER JOIN liquidacion_novedad liqn ON dliqn.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN tipo_incapacidad ti ON l.tipo_incapacidad_id = ti.tipo_incapacidad_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND ti.parametros_envioNomina_id = 5
					AND liqn.contrato_id = c.contrato_id),'null') fecha_final_licenciaNR,

			IFNULL((SELECT GROUP_CONCAT(dlil.dias_liquida SEPARATOR '&') dias
					FROM detalle_liquidacion_licencia dlil
					INNER JOIN licencia l ON dlil.licencia_id = l.licencia_id
					INNER JOIN detalle_liquidacion_novedad dliqn ON dlil.detalle_liquidacion_novedad_id = dliqn.detalle_liquidacion_novedad_id
					INNER JOIN liquidacion_novedad liqn ON dliqn.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN tipo_incapacidad ti ON l.tipo_incapacidad_id = ti.tipo_incapacidad_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND ti.parametros_envioNomina_id = 5
					AND liqn.contrato_id = c.contrato_id),'0') dias_licenciaNR,

			IFNULL((SELECT GROUP_CONCAT(dlil.valor_liquida SEPARATOR '&')
					FROM detalle_liquidacion_licencia dlil
					INNER JOIN licencia l ON dlil.licencia_id = l.licencia_id
					INNER JOIN detalle_liquidacion_novedad dliqn ON dlil.detalle_liquidacion_novedad_id = dliqn.detalle_liquidacion_novedad_id
					INNER JOIN liquidacion_novedad liqn ON dliqn.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN tipo_incapacidad ti ON l.tipo_incapacidad_id = ti.tipo_incapacidad_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND ti.parametros_envioNomina_id = 5
					AND liqn.contrato_id = c.contrato_id),'0') valor_licenciaNR,

				'null' inicio_huelga,'null' fin_huelga,'0' cantidad_huelga,

			IFNULL((SELECT GROUP_CONCAT(dlil.fecha_inicial SEPARATOR '&') fecha_inicial
					FROM detalle_liquidacion_licencia dlil
					INNER JOIN licencia l ON dlil.licencia_id = l.licencia_id
					INNER JOIN detalle_liquidacion_novedad dliqn ON dlil.detalle_liquidacion_novedad_id = dliqn.detalle_liquidacion_novedad_id
					INNER JOIN liquidacion_novedad liqn ON dliqn.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN tipo_incapacidad ti ON l.tipo_incapacidad_id = ti.tipo_incapacidad_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND ti.parametros_envioNomina_id = 1
					AND liqn.contrato_id = c.contrato_id),'null') fecha_inicio_IncapacidadGen,

			IFNULL((SELECT GROUP_CONCAT(dlil.fecha_final SEPARATOR '&') fecha_final
					FROM detalle_liquidacion_licencia dlil
					INNER JOIN licencia l ON dlil.licencia_id = l.licencia_id
					INNER JOIN detalle_liquidacion_novedad dliqn ON dlil.detalle_liquidacion_novedad_id = dliqn.detalle_liquidacion_novedad_id
					INNER JOIN liquidacion_novedad liqn ON dliqn.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN tipo_incapacidad ti ON l.tipo_incapacidad_id = ti.tipo_incapacidad_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND ti.parametros_envioNomina_id = 1
					AND liqn.contrato_id = c.contrato_id),'null') fecha_final_incapacidadGen,

			IFNULL((SELECT GROUP_CONCAT(dlil.dias_liquida SEPARATOR '&') dias 
					FROM detalle_liquidacion_licencia dlil
					INNER JOIN licencia l ON dlil.licencia_id = l.licencia_id
					INNER JOIN detalle_liquidacion_novedad dliqn ON dlil.detalle_liquidacion_novedad_id = dliqn.detalle_liquidacion_novedad_id
					INNER JOIN liquidacion_novedad liqn ON dliqn.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN tipo_incapacidad ti ON l.tipo_incapacidad_id = ti.tipo_incapacidad_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND ti.parametros_envioNomina_id = 1
					AND liqn.contrato_id = c.contrato_id),'0') dias_incapacidadGen,

			IFNULL((SELECT GROUP_CONCAT(dlil.valor_liquida SEPARATOR '&')
					FROM detalle_liquidacion_licencia dlil
					INNER JOIN licencia l ON dlil.licencia_id = l.licencia_id
					INNER JOIN detalle_liquidacion_novedad dliqn ON dlil.detalle_liquidacion_novedad_id = dliqn.detalle_liquidacion_novedad_id
					INNER JOIN liquidacion_novedad liqn ON dliqn.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN tipo_incapacidad ti ON l.tipo_incapacidad_id = ti.tipo_incapacidad_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND ti.parametros_envioNomina_id = 1
					AND liqn.contrato_id = c.contrato_id),'0') valor_incapacidadGen,
            
            (SELECT GROUP_CONCAT('1' SEPARATOR '&')
					FROM detalle_liquidacion_licencia dlil
					INNER JOIN licencia l ON dlil.licencia_id = l.licencia_id
					INNER JOIN detalle_liquidacion_novedad dliqn ON dlil.detalle_liquidacion_novedad_id = dliqn.detalle_liquidacion_novedad_id
					INNER JOIN liquidacion_novedad liqn ON dliqn.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN tipo_incapacidad ti ON l.tipo_incapacidad_id = ti.tipo_incapacidad_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND ti.parametros_envioNomina_id = 1
					AND liqn.contrato_id = c.contrato_id) tipo_incapacidadGen,

			IFNULL((SELECT GROUP_CONCAT(dlil.fecha_inicial SEPARATOR '&') fecha_inicial
					FROM detalle_liquidacion_licencia dlil
					INNER JOIN licencia l ON dlil.licencia_id = l.licencia_id
					INNER JOIN detalle_liquidacion_novedad dliqn ON dlil.detalle_liquidacion_novedad_id = dliqn.detalle_liquidacion_novedad_id
					INNER JOIN liquidacion_novedad liqn ON dliqn.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN tipo_incapacidad ti ON l.tipo_incapacidad_id = ti.tipo_incapacidad_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND ti.parametros_envioNomina_id = 2
					AND liqn.contrato_id = c.contrato_id),'null') fecha_inicio_IncapacidadProf,

			IFNULL((SELECT GROUP_CONCAT(dlil.fecha_final SEPARATOR '&') fecha_final
					FROM detalle_liquidacion_licencia dlil
					INNER JOIN licencia l ON dlil.licencia_id = l.licencia_id
					INNER JOIN detalle_liquidacion_novedad dliqn ON dlil.detalle_liquidacion_novedad_id = dliqn.detalle_liquidacion_novedad_id
					INNER JOIN liquidacion_novedad liqn ON dliqn.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN tipo_incapacidad ti ON l.tipo_incapacidad_id = ti.tipo_incapacidad_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND ti.parametros_envioNomina_id = 2
					AND liqn.contrato_id = c.contrato_id),'null') fecha_final_incapacidadProf,

			IFNULL((SELECT GROUP_CONCAT(dlil.dias_liquida SEPARATOR '&') dias
					FROM detalle_liquidacion_licencia dlil
					INNER JOIN licencia l ON dlil.licencia_id = l.licencia_id
					INNER JOIN detalle_liquidacion_novedad dliqn ON dlil.detalle_liquidacion_novedad_id = dliqn.detalle_liquidacion_novedad_id
					INNER JOIN liquidacion_novedad liqn ON dliqn.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN tipo_incapacidad ti ON l.tipo_incapacidad_id = ti.tipo_incapacidad_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND ti.parametros_envioNomina_id = 2
					AND liqn.contrato_id = c.contrato_id),'0') dias_incapacidadProf,

			IFNULL((SELECT GROUP_CONCAT(dlil.valor_liquida SEPARATOR '&')
					FROM detalle_liquidacion_licencia dlil
					INNER JOIN licencia l ON dlil.licencia_id = l.licencia_id
					INNER JOIN detalle_liquidacion_novedad dliqn ON dlil.detalle_liquidacion_novedad_id = dliqn.detalle_liquidacion_novedad_id
					INNER JOIN liquidacion_novedad liqn ON dliqn.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN tipo_incapacidad ti ON l.tipo_incapacidad_id = ti.tipo_incapacidad_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND ti.parametros_envioNomina_id = 2
					AND liqn.contrato_id = c.contrato_id),'0') valor_incapacidadProf,
            
            (SELECT GROUP_CONCAT('2' SEPARATOR '&')
					FROM detalle_liquidacion_licencia dlil
					INNER JOIN licencia l ON dlil.licencia_id = l.licencia_id
					INNER JOIN detalle_liquidacion_novedad dliqn ON dlil.detalle_liquidacion_novedad_id = dliqn.detalle_liquidacion_novedad_id
					INNER JOIN liquidacion_novedad liqn ON dliqn.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN tipo_incapacidad ti ON l.tipo_incapacidad_id = ti.tipo_incapacidad_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND ti.parametros_envioNomina_id = 2
					AND liqn.contrato_id = c.contrato_id) tipo_incapacidadProf,

			IFNULL((SELECT GROUP_CONCAT(dlil.fecha_inicial SEPARATOR '&') fecha_inicial
					FROM detalle_liquidacion_licencia dlil
					INNER JOIN licencia l ON dlil.licencia_id = l.licencia_id
					INNER JOIN detalle_liquidacion_novedad dliqn ON dlil.detalle_liquidacion_novedad_id = dliqn.detalle_liquidacion_novedad_id
					INNER JOIN liquidacion_novedad liqn ON dliqn.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN tipo_incapacidad ti ON l.tipo_incapacidad_id = ti.tipo_incapacidad_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND ti.parametros_envioNomina_id = 3
					AND liqn.contrato_id = c.contrato_id),'null') fecha_inicio_IncapacidadLab,

			IFNULL((SELECT GROUP_CONCAT(dlil.fecha_final SEPARATOR '&') fecha_final
					FROM detalle_liquidacion_licencia dlil
					INNER JOIN licencia l ON dlil.licencia_id = l.licencia_id
					INNER JOIN detalle_liquidacion_novedad dliqn ON dlil.detalle_liquidacion_novedad_id = dliqn.detalle_liquidacion_novedad_id
					INNER JOIN liquidacion_novedad liqn ON dliqn.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN tipo_incapacidad ti ON l.tipo_incapacidad_id = ti.tipo_incapacidad_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND ti.parametros_envioNomina_id = 3
					AND liqn.contrato_id = c.contrato_id),'null') fecha_final_incapacidadLab,

			IFNULL((SELECT GROUP_CONCAT(dlil.dias_liquida SEPARATOR '&') dias
					FROM detalle_liquidacion_licencia dlil
					INNER JOIN licencia l ON dlil.licencia_id = l.licencia_id
					INNER JOIN detalle_liquidacion_novedad dliqn ON dlil.detalle_liquidacion_novedad_id = dliqn.detalle_liquidacion_novedad_id
					INNER JOIN liquidacion_novedad liqn ON dliqn.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN tipo_incapacidad ti ON l.tipo_incapacidad_id = ti.tipo_incapacidad_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND ti.parametros_envioNomina_id = 3
					AND liqn.contrato_id = c.contrato_id),'0') dias_incapacidadLab,

			IFNULL((SELECT GROUP_CONCAT(dlil.valor_liquida SEPARATOR '&')
					FROM detalle_liquidacion_licencia dlil
					INNER JOIN licencia l ON dlil.licencia_id = l.licencia_id
					INNER JOIN detalle_liquidacion_novedad dliqn ON dlil.detalle_liquidacion_novedad_id = dliqn.detalle_liquidacion_novedad_id
					INNER JOIN liquidacion_novedad liqn ON dliqn.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN tipo_incapacidad ti ON l.tipo_incapacidad_id = ti.tipo_incapacidad_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND ti.parametros_envioNomina_id = 3
					AND liqn.contrato_id = c.contrato_id),'0') valor_incapacidadLab,
            
            (SELECT GROUP_CONCAT('3' SEPARATOR '&')
					FROM detalle_liquidacion_licencia dlil
					INNER JOIN licencia l ON dlil.licencia_id = l.licencia_id
					INNER JOIN detalle_liquidacion_novedad dliqn ON dlil.detalle_liquidacion_novedad_id = dliqn.detalle_liquidacion_novedad_id
					INNER JOIN liquidacion_novedad liqn ON dliqn.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN tipo_incapacidad ti ON l.tipo_incapacidad_id = ti.tipo_incapacidad_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND ti.parametros_envioNomina_id = 3
					AND liqn.contrato_id = c.contrato_id) tipo_incapacidadLab,

			IFNULL((SELECT SUM(dlin.debito)-SUM(dlin.credito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 8),0) montoAnticipo, 
			
			IFNULL((SELECT SUM(dlin.debito)-SUM(dlin.credito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 27),0) valor_pago_tercero_dev,

			IFNULL((SELECT SUM(dlin.debito)-SUM(dlin.credito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 33),0) apoyo_sostenimiento,

            '0' bonificacion_retiro, '0' dotacion,

            (SELECT ldi.valor FROM liquidacion_definitiva ld 
					INNER JOIN liq_def_indemnizacion ldi ON ld.liquidacion_definitiva_id = ldi.liquidacion_definitiva_id
					WHERE ld.estado = 'C' AND ldi.fecha_fin BETWEEN '$desde' AND '$hasta' AND ld.contrato_id = c.contrato_id) valor_indemnizacion,

            IFNULL((SELECT SUM(dlin.debito)-SUM(dlin.credito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 9),0) reintegro_de_empresa,

			IFNULL((SELECT SUM(dlin.debito)-SUM(dlin.credito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 10),0) valor_teletrabajo, 

			IFNULL((SELECT SUM(dlin.debito)-SUM(dlin.credito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 11),0) auxilioS,

			IFNULL((SELECT SUM(dlin.debito)-SUM(dlin.credito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 12),0) auxilioNS,

			(SUM(IF(dl.concepto='INGRESO NO SALARIAL',dl.debito,0))+IFNULL((SELECT SUM(dlin.debito)-SUM(dlin.credito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 14),0)) AS bonificacion_no_salarial,

			IFNULL((SELECT SUM(dlin.debito)-SUM(dlin.credito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 13),0) bonificacionS,

			IFNULL((SELECT SUM(dlin.debito)-SUM(dlin.credito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 34),0) pAlimentacionNs,

			IFNULL((SELECT SUM(dlin.debito)-SUM(dlin.credito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 15),0) pAlimentacionS,

			IFNULL((SELECT SUM(dlin.debito)-SUM(dlin.credito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 35),0) pagosS,
						
			IFNULL((SELECT SUM(dlin.debito)-SUM(dlin.credito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 36),0) pagosNs,

			IFNULL((SELECT SUM(dlin.debito)-SUM(dlin.credito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 16),0) compensacion_ordinaria,
						
			IFNULL((SELECT SUM(dlin.debito)-SUM(dlin.credito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 17),0) compensacion_extraordinaria,

			IFNULL((SELECT dlin.concepto FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id IN (37,38)),0) descripcion_concepto,
						
			IFNULL((SELECT SUM(dlin.debito)-SUM(dlin.credito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 38),0) concepto_no_salarial,
						
			IFNULL((SELECT SUM(dlin.debito)-SUM(dlin.credito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 37),0) concepto_salarial,

			IFNULL((SELECT SUM(dlin.credito)-SUM(dlin.debito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 18),0) afc,
						
			IFNULL((SELECT SUM(dlin.credito)-SUM(dlin.debito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 19),0) cooperativa,
			
			IFNULL((SELECT SUM(dlin.credito)-SUM(dlin.debito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 20),0) deuda,
						
			IFNULL((SELECT SUM(dlin.credito)-SUM(dlin.debito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 21),0) educacion,
			
			IFNULL((SELECT SUM(dlin.credito)-SUM(dlin.debito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 22),0) embargo,	

			IFNULL((SELECT SUM(dlin.credito)-SUM(dlin.debito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 39),0)	pension_voluntaria,					

			IFNULL((SELECT SUM(dlin.credito)-SUM(dlin.debito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 23),0) plan_complementario_salud,
		
			IFNULL((SELECT SUM(dlin.credito)-SUM(dlin.debito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 24),0) reintegro_de_trabajador,

			(SUM(IF(dl.concepto='LIQUIDACION RETENCION',dl.debito,0)))+IFNULL((SELECT SUM(dlin.credito)-SUM(dlin.debito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 40),0) retencion_fuente,

			IFNULL((SELECT SUM(dlin.credito)-SUM(dlin.debito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 25),0) anticipo_nomina,	

			IFNULL((SELECT SUM(dlin.credito)-SUM(dlin.debito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 26),0) deduccion_libranza,
												
												
			IFNULL((SELECT dlin.concepto FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 26),'') descripcion_libranza,

			IFNULL((SELECT SUM(dlin.credito)-SUM(dlin.debito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 32),0) pago_a_tercero,
						
			IFNULL((SELECT SUM(dlin.credito)-SUM(dlin.debito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 28),0) sancion_publica,


			IFNULL((SELECT SUM(dlin.credito)-SUM(dlin.debito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 29),0) sancion_privada,

					'' pago_sindicato,'' porcentaje_sindicato,

			IFNULL((SELECT SUM(dlin.credito)-SUM(dlin.debito) valor FROM detalle_liquidacion_novedad dlin
					INNER JOIN liquidacion_novedad liqn ON  dlin.liquidacion_novedad_id = liqn.liquidacion_novedad_id
					INNER JOIN concepto_area coa ON dlin.concepto_area_id = coa.concepto_area_id
					WHERE liqn.estado = 'C' AND liqn.fecha_inicial BETWEEN '$desde' AND '$hasta' 
					AND liqn.fecha_final BETWEEN '$desde' AND '$hasta' AND liqn.contrato_id = c.contrato_id 
					AND coa.parametros_envioNomina_id = 31),0) otra_deduccion,


            
            '' AS dias_incapacidad,
            '' AS dias_licencia,
            (SELECT ca.nombre_cargo	FROM cargo ca  WHERE  c.cargo_id=ca.cargo_id) AS cargo, c.sueldo_base
            
            


            FROM liquidacion_novedad ln, contrato c, empleado e, tercero t, detalle_liquidacion_novedad dl, centro_de_costo cc, oficina of, ubicacion u, tipo_contrato tc
            WHERE ln.fecha_inicial BETWEEN '$desde' AND '$hasta' AND ln.fecha_final BETWEEN '$desde' AND '$hasta'
            AND dl.liquidacion_novedad_id=ln.liquidacion_novedad_id AND c.contrato_id=ln.contrato_id AND e.empleado_id=c.empleado_id 
            AND t.tercero_id=e.tercero_id AND cc.centro_de_costo_id=c.centro_de_costo_id AND of.oficina_id=cc.oficina_id AND tc.tipo_contrato_id=c.tipo_contrato_id
            AND u.ubicacion_id=of.ubicacion_id AND e.empleado_id=$empleado_id AND ln.estado = 'C' AND ln.reportado IS NULL
            GROUP BY ln.contrato_id
            ORDER BY CONCAT_WS(' ',t.primer_nombre, t.segundo_nombre,t.primer_apellido,t.segundo_apellido)   ASC, ln.fecha_final DESC";
		//exit($select);
		$result = $this -> DbFetchAll($select,$Conex,true);
		
		return $result;
    }
    
	public function getEmpleado($identificacion,$Conex) {
	
		$select = "SELECT empleado_id FROM empleado emp
		INNER JOIN tercero terc ON emp.tercero_id = terc.tercero_id
		WHERE terc.numero_identificacion = $identificacion";
		
		$result = $this -> DbFetchAll($select,$Conex,true);
				
		return $result;
	
	}

	public function getToken($Conex){

		$select = "SELECT tokenenterprise,tokenautorizacion FROM param_nomina_electronica";
		
		$result = $this -> DbFetchAll($select,$Conex,true);
				
		return $result;

	}

	
	public function getNitEmpresa($empresa_id,$Conex){

		$select = "SELECT numero_identificacion FROM empresa e
				INNER JOIN tercero t ON e.tercero_id = t.tercero_id 
				WHERE e.empresa_id = $empresa_id";
		
		$result = $this -> DbFetchAll($select,$Conex,true);
				
		return $result;
	}

	public function getUrlNominaElectronica($Conex){
	
		$select = "SELECT wsdl_prueba FROM param_nomina_electronica WHERE estado = 1 LIMIT 1";

		$result  = $this -> DbFetchAll($select,$Conex,true);

		return $result[0][wsdl_prueba];

	}

	

	public function actualizaDatosReporte($respuesta,$fechaEmision,$desde,$hasta,$contrato_id,$consecutivo,$liquidacion_novedad_id,$Conex){

		try 
		{
			$this -> Begin($Conex);

			if ($respuesta -> codigo == "200") {

				$update = "UPDATE liquidacion_novedad SET consecutivo_nom=$consecutivo,reportado = 1, cune = '".$respuesta->cune."', fecha_ultimo_reporte = '".$fechaEmision."' WHERE estado = 'C' AND fecha_inicial BETWEEN '$desde' AND '$hasta' AND fecha_final BETWEEN '$desde' AND '$hasta' AND contrato_id = $contrato_id;";

				$this -> query($update,$Conex,true);

			}else {

				if ($respuesta -> reglasNotificacionesTFHKA != '') {
					
					$error = $respuesta -> reglasRechazoTFHKA;
					
				}
				
				if ($respuesta -> reglasNotificacionesDIAN != '') {

					$error = $respuesta -> reglasRechazoDIAN;

				}
				
				/* if ($respuesta -> reglasRechazoTFHKA != '') {
					
					$error = $respuesta -> reglasRechazoTFHKA;

				}elseif ($respuesta -> reglasRechazoDIAN != '') {
					
					$error = $respuesta -> reglasRechazoDIAN;

				} */

				for ($i=0; $i < count($error); $i++) { 
					$messageError .= $error[$i]."<br>";
				}
				
				$update = "UPDATE liquidacion_novedad SET ultimo_error_reportado='".$error."' WHERE estado = 'C' AND fecha_inicial BETWEEN '$desde' AND '$hasta' AND fecha_final BETWEEN '$desde' AND '$hasta' AND contrato_id = $contrato_id";

				
				$this -> query($update,$Conex,true);

			}

			$this -> Commit($Conex);

			return $respuesta -> mensaje."<br>".$messageError;

		} 
		catch (Exception $ex) 
		{
			$this -> Rollback($Conex); 
			return $ex;      
		}

		

	}

	//// GRID ////   
	public function getQueryNominaElectronicaGrid(){
	 
		$Query = "SELECT CONCAT('','<a href=\"javascript:void(0)\" onClick=\"viewDoc(''',CONCAT(pn.prefijo,ln.consecutivo_nom),''')\">',CONCAT(pn.prefijo,ln.consecutivo_nom),'</a>' ) consecutivo,t.numero_identificacion,
					CONCAT_WS(' ',t.primer_apellido,t.segundo_apellido,t.primer_nombre,t.segundo_nombre) nombre,ln.fecha_inicial,ln.fecha_final,
					cune
				FROM liquidacion_novedad ln
				INNER JOIN param_nomina_electronica pn ON pn.param_nom_electronica_id = ln.param_nom_electronica_id
				INNER JOIN contrato c ON c.contrato_id = ln.contrato_id
				INNER JOIN empleado e ON c.empleado_id = e.empleado_id
				INNER JOIN tercero t ON e.tercero_id = t.tercero_id
				WHERE reportado = 1 AND ln.estado = 'C'
				ORDER BY CAST(ln.consecutivo_nom AS DECIMAL) DESC";
		
		return $Query;
	  }
	  
}

?>