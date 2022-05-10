<?php

require_once "../../framework/clases/DbClass.php";
require_once "../../framework/clases/PermisosFormClass.php";

final class reporteCuentasFPModel extends Db
{

    private $UserId;
    private $Permisos;

    public function SetUsuarioId($UserId, $CodCId)
    {
        $this->Permisos = new PermisosForm();
        $this->Permisos->SetUsuarioId($UserId, $CodCId);
    }

    public function getPermiso($ActividadId, $Permiso, $Conex)
    {
        return $this->Permisos->getPermiso($ActividadId, $Permiso, $Conex);
    }

    public function GetOficina($Conex)
    {
        return $this->DbFetchAll("SELECT oficina_id AS value,nombre AS text FROM oficina", $Conex,
            $ErrDb = false);
    }

    public function GetTipo($Conex)
    {
        $opciones = array(0 => array('value' => 'VF', 'text' => 'Valor Facturado'));
        return $opciones;
	} 
	
	/*    public function GetTipo($Conex){
	$opciones=array(0 => array ( 'value' => 'FP', 'text' => 'Facturas Pendientes' ), 1 => array ( 'value' => 'RF', 'text' => 'Relaci&oacute;n Facturas'), 2 => array ( 'value' => 'EC', 'text' => 'Estado Cartera'), 3 => array ( 'value' => 'PE', 'text' => 'Cartera Por Edades'), 4 => array ( 'value' => 'RP', 'text' => 'Remesas Pendientes'),5 => array ( 'value' => 'CP', 'text' => 'Contado Pendientes') ,6 => array ( 'value' => 'CC', 'text' => 'Contado Con cierre'));
	return $opciones;
   } */

    public function GetSi_Pro($Conex)
    {
        $opciones = array(0 => array('value' => '1', 'text' => 'UNO'), 1 => array('value' => 'ALL', 'text' => 'TODOS'));
        return $opciones;
    }

    public function getReporteFP1($oficina_id, $desde, $hasta, $cliente_id, $saldos, $Conex)
    { //ok

        $select = "SELECT
		  CASE f.fuente_facturacion_cod WHEN 'RM' THEN 'Remesas' WHEN 'OS' THEN 'Orden de Servicio'  ELSE 'Despacho Particular' END AS tipo,
		  (SELECT nombre FROM oficina WHERE oficina_id=f.oficina_id) AS oficina,
		  DATEDIFF(CURDATE(),f.vencimiento) AS dias,
		  f.consecutivo_factura, f.fecha, f.vencimiento, ROUND(f.valor,0) AS valor,
		  (SELECT ROUND((deb_item_factura+cre_item_factura)) AS neto  FROM detalle_factura_puc WHERE factura_id=f.factura_id AND contra_factura=1) AS valor_neto,
		  (SELECT ROUND(SUM(ra.rel_valor_abono)) AS abonos FROM  relacion_abono ra, abono_factura ab
		  WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos ) AS abonos,
		  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social,' - ',t.numero_identificacion) AS cliente_nombre
		  FROM cliente c, tercero t WHERE c.cliente_id=f.cliente_id AND t.tercero_id=c.tercero_id) AS cliente_nombre
		  FROM factura f
		  WHERE f.cliente_id=$cliente_id AND f.estado='C' AND f.fecha BETWEEN '$desde' AND '$hasta' AND f.oficina_id IN ($oficina_id)
		  AND ((SELECT ROUND((deb_item_factura+cre_item_factura)) AS neto  FROM detalle_factura_puc WHERE factura_id=f.factura_id AND contra_factura=1) >
		  (SELECT ROUND(SUM(ra.rel_valor_abono)) AS abonos FROM  relacion_abono ra, abono_factura ab WHERE ra.factura_id=f.factura_id
		  AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos) OR (SELECT ROUND(SUM(ra.rel_valor_abono)) AS abonos FROM relacion_abono ra,abono_factura ab
		  WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos) IS NULL)
		  ORDER BY f.cliente_id ASC, f.oficina_id ASC, f.consecutivo_factura ASC ";
        ////echo $select;
        $results = $this->DbFetchAll($select, $Conex);
        return $results;
    }

    public function getReporteRF1($oficina_id, $desde, $hasta, $cliente_id, $saldos, $Conex)
    { //ok

        $select = "SELECT
		CASE f.fuente_facturacion_cod WHEN 'RM' THEN 'Remesas' WHEN 'OS' THEN 'Orden de Servicio'  ELSE 'Despacho Particular' END AS tipo,
		(SELECT nombre FROM oficina WHERE oficina_id=f.oficina_id) AS oficina,
		(SELECT d.codigo_centro_costo FROM detalle_factura_puc d WHERE d.factura_id=f.factura_id AND d.codigo_centro_costo IS NOT NULL LIMIT 0,1) AS centro,
		f.consecutivo_factura,
		f.fecha,
		f.vencimiento,
		ROUND(f.valor) AS valor,
		CASE f.estado WHEN 'I' THEN 'ANULADA' WHEN 'C' THEN 'CONTABILIZADA' ELSE 'EDICION' END AS estado,

		(SELECT GROUP_CONCAT(CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewDocument(',er.encabezado_registro_id,')\">',er.consecutivo,'</a>' ))
		FROM abono_factura ab, relacion_abono ra, encabezado_de_registro er
		WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos AND er.encabezado_registro_id=ab.encabezado_registro_id) AS relacion_pago,

		(SELECT ROUND((deb_item_factura+cre_item_factura)) AS neto  FROM detalle_factura_puc WHERE  factura_id=f.factura_id AND contra_factura=1) AS valor_neto,

		(SELECT ROUND(SUM(ra.rel_valor_abono)) AS abonos FROM  relacion_abono ra, abono_factura ab
		WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos )	AS abonos,

		(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social,' - ',t.numero_identificacion) AS cliente_nombre FROM cliente c, tercero t WHERE c.cliente_id=f.cliente_id AND t.tercero_id=c.tercero_id) AS cliente_nombre

		FROM factura f
		WHERE f.cliente_id=$cliente_id AND f.fecha BETWEEN '$desde' AND '$hasta' AND f.oficina_id IN ($oficina_id)
		ORDER BY f.cliente_id ASC, f.oficina_id ASC, f.consecutivo_factura ASC";

        $results = $this->DbFetchAll($select, $Conex, true);
        return $results;
    }

    public function getReporteEC1($oficina_id, $desde, $hasta, $cliente_id, $saldos, $Conex)
    {

        $select = "SELECT * FROM factura_proveedor f WHERE f.factura_proveedor_id=$factura_proveedor_id AND i.orden_compra_id=f.orden_compra_id";
        $result = $this->DbFetchAll($select, $Conex);
        return $result;
    }
    public function getReporteCP1($oficina_id, $desde, $hasta, $cliente_id, $saldos, $Conex)
    {

        $select = "SELECT IF(r.paqueteo=2,'CONTADO','CONTRAENTREGA') AS tipo_remesa,
	(SELECT nombre FROM oficina WHERE oficina_id=r.oficina_id) AS oficina_remesa,
	(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) AS origen,
	(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino,
	r.*,
	(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM cliente c, tercero t  WHERE c.cliente_id=r.cliente_id AND c.tercero_id=t.tercero_id)  AS cliente,
	r.valor_total AS valor_facturar   FROM remesa r
		  WHERE r.fecha_remesa BETWEEN '$desde' AND '$hasta' AND r.cliente_id=$cliente_id AND r.paqueteo IN(2,3) AND r.cierre=0 AND r.estado !='AN'
		  ORDER BY r.cliente_id,r.oficina_id ASC
		  ";
        $result = $this->DbFetchAll($select, $Conex);
        //echo $select;
        return $result;

    }
    public function getReporteCC1($oficina_id, $desde, $hasta, $cliente_id, $saldos, $Conex)
    {

        $select = "SELECT IF(r.paqueteo=2,'CONTADO','CONTRAENTREGA') AS tipo_remesa,
	(SELECT nombre FROM oficina WHERE oficina_id=r.oficina_id) AS oficina_remesa,
	(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) AS origen,
	(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino,
	r.*,
	(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM cliente c, tercero t  WHERE c.cliente_id=r.cliente_id AND c.tercero_id=t.tercero_id)  AS cliente,
	r.valor_total AS valor_facturar   FROM remesa r
		  WHERE r.fecha_remesa BETWEEN '$desde' AND '$hasta' AND r.cliente_id=$cliente_id AND r.paqueteo IN(2,3) AND r.cierre=1 AND r.estado !='AN'
		  ORDER BY r.cliente_id,r.oficina_id ASC
		  ";
        $result = $this->DbFetchAll($select, $Conex);
        //echo $select;
        return $result;

    }
    public function getReportePE1($oficina_id, $desde, $hasta, $cliente_id, $saldos, $Conex)
    { //ok

        $select = "SELECT
		  CASE f.fuente_facturacion_cod WHEN 'RM' THEN 'Remesas' WHEN 'OS' THEN 'Orden de Servicio'  ELSE 'Despacho Particular' END AS tipo,
		  (SELECT nombre FROM oficina WHERE oficina_id=f.oficina_id) AS oficina,
		  IF(DATEDIFF(CURDATE(),f.vencimiento)>0,DATEDIFF(CURDATE(),f.vencimiento),DATEDIFF(CURDATE(),f.vencimiento)) AS dias,
		  f.consecutivo_factura,
		  f.fecha,
		  f.vencimiento,
		  ROUND(f.valor) AS valor,
		  (SELECT ROUND(deb_item_factura+cre_item_factura) AS neto  FROM detalle_factura_puc WHERE  factura_id=f.factura_id AND contra_factura=1) AS valor_neto,
		  (SELECT ROUND(SUM(ra.rel_valor_abono)) AS abonos FROM  relacion_abono ra, abono_factura ab
		  WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos )	AS abonos,
		  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social,' - ',t.numero_identificacion) AS cliente_nombre FROM cliente c, tercero t WHERE c.cliente_id=f.cliente_id AND t.tercero_id=c.tercero_id) AS cliente_nombre
		  FROM factura f
		  WHERE f.cliente_id=$cliente_id AND f.estado='C' AND f.fecha BETWEEN '$desde' AND '$hasta' AND f.oficina_id IN ($oficina_id)
		  AND ((SELECT ROUND(deb_item_factura+cre_item_factura) AS neto  FROM detalle_factura_puc WHERE  factura_id=f.factura_id AND contra_factura=1) >
		 (SELECT ROUND(SUM(ra.rel_valor_abono)) AS abonos FROM  relacion_abono ra, abono_factura ab
		  WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos )
		  OR (SELECT ROUND(SUM(ra.rel_valor_abono)) AS abonos FROM  relacion_abono ra, abono_factura ab
		  WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos ) IS NULL)
		  ORDER BY f.cliente_id ASC, f.oficina_id ASC, f.consecutivo_factura ASC";

        $results = $this->DbFetchAll($select, $Conex);
        return $results;

    }

    public function getReporteRP1($oficina_id, $desde, $hasta, $cliente_id, $saldos, $Conex)
    { //ok

        $select = "
			SELECT
			(SELECT GROUP_CONCAT(m.manifiesto) FROM detalle_despacho dd, manifiesto m WHERE dd.remesa_id=r.remesa_id AND m.manifiesto_id=dd.manifiesto_id AND m.estado!='A') AS planilla,
			(SELECT GROUP_CONCAT(m.fecha_mc) FROM detalle_despacho dd, manifiesto m WHERE dd.remesa_id=r.remesa_id AND m.manifiesto_id=dd.manifiesto_id AND m.estado!='A') AS fecha_planilla,
			(SELECT nombre FROM oficina WHERE oficina_id=r.oficina_id) AS oficina_remesa,
			r.numero_remesa,
			IF(r.paqueteo=1,'PAQUETEO','MASIVO') AS tipo_remesa,
			CASE r.estado WHEN 'P' THEN 'PENDIENTE' WHEN 'PD' THEN 'PENDIENTE' WHEN 'PC' THEN 'PROCESANDO' WHEN 'MF' THEN 'MANIFESTADO'
			WHEN 'LQ' THEN 'LIQUIDADA' WHEN 'FT' THEN 'FACTURADA' WHEN 'ET' THEN 'ENTREGADA' WHEN 'AN' THEN 'ANULADA' ELSE 'PENDIENTE' END AS estado,
			IF(r.clase_remesa = 'NN','NORMAL',IF(r.clase_remesa = 'DV','DEVOLUCION',IF(r.clase_remesa = 'CP','COMPLEMENTO',IF(r.clase_remesa = 'AL','ALMACEN','SUMINISTRO')))) AS clase,
			r.fecha_remesa,
			(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM cliente c, tercero t  WHERE c.cliente_id=r.cliente_id AND c.tercero_id=t.tercero_id)  AS cliente,
			(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) AS origen,
			r.remitente,
			(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino,
			r.destinatario,
			r.orden_despacho,
		  (SELECT codigo FROM producto WHERE producto_id=r.producto_id) AS codigo,
		  r.descripcion_producto,
		  (SELECT naturaleza FROM naturaleza WHERE naturaleza_id=r.naturaleza_id) AS naturaleza,
		  (SELECT empaque FROM empaque WHERE empaque_id=r.empaque_id) AS empaque,
		  (SELECT medida FROM medida WHERE medida_id=r.medida_id) AS medida,
		  r.cantidad,
		  r.peso,
		  r.peso_volumen,
		  r.valor as valor_mercancia,
		  r.valor_flete,
		  r.valor_seguro,
		  r.valor_otros,
		  r.valor_total,
		  r.valor_liq_flete,
		  r.valor_liq_seguro,
		  r.valor_liq_otros,
		  r.valor_liq_total,
		  IF(r.valor_facturar>0,r.valor_facturar,r.valor_total) AS valor_facturar,
		  r.observacion_anulacion,
		  (SELECT nombre FROM causal_anulacion WHERE r.causal_anulacion_id = causal_anulacion_id) AS causal_anulacion,
		  r.fecha_anulacion,
		  (SELECT CONCAT_WS(' ',t.primer_nombre,t.primer_apellido) FROM usuario u, tercero t  WHERE r.usuario_anulo_id = u.usuario_id  AND u.tercero_id  = t.tercero_id)  AS usuario_anulacion,
		  (SELECT GROUP_CONCAT(f.consecutivo_factura) FROM factura f,detalle_factura df WHERE r.remesa_id = df.remesa_id AND f.factura_id = df.factura_id AND f.estado!='I') AS numero_factura,
		  (SELECT GROUP_CONCAT(f.fecha) FROM factura f,detalle_factura df WHERE r.remesa_id = df.remesa_id AND f.factura_id = df.factura_id AND f.estado!='I') AS fecha_factura,
		  (SELECT GROUP_CONCAT(df.valor) FROM factura f,detalle_factura df WHERE df.remesa_id = r.remesa_id AND f.factura_id=df.factura_id AND f.estado!='I') AS valor_facturado
		  FROM remesa r
		  WHERE r.fecha_remesa BETWEEN '$desde' AND '$hasta'
		  AND r.oficina_id IN($oficina_id) AND r.estado !='AN' AND r.estado !='FT' AND r.clase_remesa IN ('NN','DV','CP')  AND r.cliente_id=$cliente_id AND r.paqueteo NOT IN(2,3)

		  ORDER BY cliente";

        $results = $this->DbFetchAll($select, $Conex);
        return $results;

    }

    public function getReporteFP_ALL($oficina_id, $desde, $hasta, $saldos, $Conex)
    { //ok

        $select = "SELECT
					CASE f.fuente_facturacion_cod WHEN 'RM' THEN 'Remesas' WHEN 'OS' THEN 'Orden de Servicio'  ELSE 'Despacho Particular' END AS tipo,
					(SELECT nombre FROM oficina WHERE oficina_id=f.oficina_id) AS oficina,
					DATEDIFF(CURDATE(),f.vencimiento) AS dias,
					f.consecutivo_factura,
					f.fecha,
					f.vencimiento,
					ROUND(f.valor) AS valor,
					(SELECT ROUND(deb_item_factura+cre_item_factura) AS neto  FROM detalle_factura_puc WHERE  factura_id=f.factura_id AND contra_factura=1) AS valor_neto,
					(SELECT ROUND(SUM(ra.rel_valor_abono)) AS abonos FROM  relacion_abono ra, abono_factura ab
					WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos ) AS abonos,
					(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social,' - ',t.numero_identificacion) AS cliente_nombre FROM cliente c, tercero t WHERE c.cliente_id=f.cliente_id AND t.tercero_id=c.tercero_id) AS cliente_nombre
				FROM factura f
				WHERE  f.estado='C' AND f.fecha BETWEEN '$desde' AND '$hasta' AND f.oficina_id IN ($oficina_id)
				AND ((SELECT ROUND(deb_item_factura+cre_item_factura) AS neto FROM detalle_factura_puc WHERE factura_id=f.factura_id AND contra_factura=1) >
				(SELECT ROUND(SUM(ra.rel_valor_abono)) AS abonos FROM relacion_abono ra, abono_factura ab
				WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos )
				OR (SELECT ROUND(SUM(ra.rel_valor_abono)) AS abonos FROM  relacion_abono ra, abono_factura ab
				WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos ) IS NULL)
				ORDER BY f.cliente_id ASC, f.oficina_id ASC, f.consecutivo_factura ASC ";

        $results = $this->DbFetchAll($select, $Conex);
        return $results;
    }

    public function getReporteRF_ALL($oficina_id, $desde, $hasta, $saldos, $Conex)
    { //ok

        $select = "SELECT
		CASE f.fuente_facturacion_cod WHEN 'RM' THEN 'Remesas' WHEN 'OS' THEN 'Orden de Servicio'  ELSE 'Despacho Particular' END AS tipo,
		(SELECT nombre FROM oficina WHERE oficina_id=f.oficina_id) AS oficina,
		(SELECT d.codigo_centro_costo FROM   detalle_factura_puc d WHERE d.factura_id=f.factura_id AND d.codigo_centro_costo IS NOT NULL LIMIT 0,1) AS centro,
		f.consecutivo_factura,
		f.fecha,
		f.vencimiento,
		ROUND(f.valor) AS valor,
		CASE f.estado WHEN 'I' THEN 'ANULADA' WHEN 'C' THEN 'CONTABILIZADA' ELSE 'EDICION' END AS estado,
		(SELECT GROUP_CONCAT(CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewDocument(',er.encabezado_registro_id,')\">',er.consecutivo,'</a>' ))
		FROM abono_factura ab, relacion_abono ra, encabezado_de_registro er
		WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos AND er.encabezado_registro_id=ab.encabezado_registro_id) AS relacion_pago,
		(SELECT ROUND(deb_item_factura+cre_item_factura) AS neto FROM detalle_factura_puc WHERE factura_id=f.factura_id AND contra_factura=1) AS valor_neto,
		(SELECT ROUND(SUM(ra.rel_valor_abono)) AS abonos FROM relacion_abono ra, abono_factura ab
		WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos)	AS abonos,
		(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social,' - ',t.numero_identificacion) AS cliente_nombre FROM cliente c, tercero t WHERE c.cliente_id=f.cliente_id AND t.tercero_id=c.tercero_id) AS cliente_nombre
		FROM factura f
		WHERE  f.fecha BETWEEN '$desde' AND '$hasta' AND f.oficina_id IN ($oficina_id)
		ORDER BY f.cliente_id ASC, f.oficina_id ASC, f.consecutivo_factura ASC ";

        $results = $this->DbFetchAll($select, $Conex);
        return $results;
    }

    public function getReporteCP_ALL($oficina_id, $desde, $hasta, $saldos, $Conex)
    {

        $select = "SELECT IF(r.paqueteo=2,'CONTADO','CONTRAENTREGA') AS tipo_remesa,
	(SELECT nombre FROM oficina WHERE oficina_id=r.oficina_id) AS oficina_remesa,
	(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) AS origen,
	(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino,r.*
	r.valor_total AS valor_facturar,
	(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM cliente c, tercero t  WHERE c.cliente_id=r.cliente_id AND c.tercero_id=t.tercero_id)  AS cliente
	FROM remesa r
		  WHERE r.fecha_remesa BETWEEN '$desde' AND '$hasta'  AND r.paqueteo IN(2,3) AND r.cierre=0 AND r.estado !='AN' AND r.oficina_id IN ($oficina_id)
		  ORDER BY r.cliente_id, r.oficina_id ASC";
        $result = $this->DbFetchAll($select, $Conex);
        //echo $select;
        return $result;

    }
    public function getReporteCC_ALL($oficina_id, $desde, $hasta, $saldos, $Conex)
    {

        $select = "SELECT IF(r.paqueteo=2,'CONTADO','CONTRAENTREGA') AS tipo_remesa,
	(SELECT nombre FROM oficina WHERE oficina_id=r.oficina_id) AS oficina_remesa,
	(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) AS origen,
	(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino,r.*
	r.valor_total AS valor_facturar,
	(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM cliente c, tercero t  WHERE c.cliente_id=r.cliente_id AND c.tercero_id=t.tercero_id)  AS cliente
	FROM remesa r
		  WHERE r.fecha_remesa BETWEEN '$desde' AND '$hasta'  AND r.paqueteo IN(2,3) AND r.cierre=1 AND r.estado !='AN' AND r.oficina_id IN ($oficina_id)
		  ORDER BY r.cliente_id, r.oficina_id ASC";
        $result = $this->DbFetchAll($select, $Conex);
        //echo $select;
        return $result;

    }

    public function getReporteEC_ALL($oficina_id, $desde, $hasta, $saldos, $Conex)
    { ///haciendo

        $select = "SELECT
		  CASE f.fuente_facturacion_cod WHEN 'RM' THEN 'Remesas' WHEN 'OS' THEN 'Orden de Servicio'  ELSE 'Despacho Particular' END AS tipo,
		  (SELECT nombre FROM oficina WHERE oficina_id=f.oficina_id) AS oficina,
		  IF(DATEDIFF(CURDATE(),f.vencimiento)>0,DATEDIFF(CURDATE(),f.vencimiento),0) AS dias,
		  f.consecutivo_factura,
		  f.fecha,
		  f.vencimiento,
		  ROUND(f.valor) AS valor,
		  (SELECT ROUND(deb_item_factura+cre_item_factura) AS neto FROM detalle_factura_puc WHERE factura_id=f.factura_id AND contra_factura=1) AS valor_neto,
		  (SELECT ROUND(SUM(ra.rel_valor_abono)) AS abonos FROM  relacion_abono ra, abono_factura ab
		  WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos) AS abonos,
		  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social,' - ',t.numero_identificacion) AS cliente_nombre FROM cliente c, tercero t WHERE c.cliente_id=f.cliente_id AND t.tercero_id=c.tercero_id) AS cliente_nombre
		  FROM factura f
		  WHERE  f.estado='C' AND f.fecha BETWEEN '$desde' AND '$hasta' AND f.oficina_id IN ($oficina_id)
		  AND ((SELECT ROUND(deb_item_factura+cre_item_factura) AS neto FROM detalle_factura_puc WHERE factura_id=f.factura_id AND contra_factura=1) >
		  (SELECT ROUND(SUM(ra.rel_valor_abono)) AS abonos FROM relacion_abono ra, abono_factura ab
		  WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos )
		  OR  (SELECT ROUND(SUM(ra.rel_valor_abono)) AS abonos FROM  relacion_abono ra, abono_factura ab
		  WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos ) IS NULL)
		  ORDER BY f.cliente_id ASC, f.oficina_id ASC";

        $results = $this->DbFetchAll($select, $Conex);
        return $results;
    }

    public function getReportePE_ALL($oficina_id, $desde, $hasta, $saldos, $Conex)
    { //ok

        $select = "SELECT
		CASE f.fuente_facturacion_cod WHEN 'RM' THEN 'Remesas' WHEN 'OS' THEN 'Orden de Servicio'  ELSE 'Despacho Particular' END AS tipo,
		(SELECT nombre FROM oficina WHERE oficina_id=f.oficina_id) AS oficina,
		IF(DATEDIFF(CURDATE(),f.vencimiento)>0,DATEDIFF(CURDATE(),f.vencimiento),DATEDIFF(CURDATE(),f.vencimiento)) AS dias,
		f.consecutivo_factura,
		f.fecha,
		f.vencimiento,
		ROUND(f.valor) AS valor,
		(SELECT ROUND(deb_item_factura+cre_item_factura) AS neto  FROM detalle_factura_puc WHERE  factura_id=f.factura_id AND contra_factura=1) AS valor_neto,
		(SELECT ROUND(SUM(ra.rel_valor_abono)) AS abonos FROM  relacion_abono ra, abono_factura ab
		WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos ) AS abonos,
		(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social,' - ',t.numero_identificacion) AS cliente_nombre FROM cliente c, tercero t WHERE c.cliente_id=f.cliente_id AND t.tercero_id=c.tercero_id) AS cliente_nombre
		FROM factura f
		WHERE f.estado='C' AND f.fecha BETWEEN '$desde' AND '$hasta' AND f.oficina_id IN ($oficina_id)
		AND ((SELECT ROUND(SUM(deb_item_factura+cre_item_factura)) AS neto FROM detalle_factura_puc WHERE factura_id=f.factura_id AND contra_factura=1) >
		(SELECT ROUND(SUM(ra.rel_valor_abono)) AS abonos FROM  relacion_abono ra, abono_factura ab
		WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos )
		OR (SELECT ROUND(SUM(ra.rel_valor_abono)) AS abonos FROM  relacion_abono ra, abono_factura ab
		WHERE ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND ab.estado_abono_factura='C' $saldos ) IS NULL)
		ORDER BY f.cliente_id ASC, f.oficina_id ASC, f.consecutivo_factura ASC ";

        $results = $this->DbFetchAll($select, $Conex);
        return $results;
    }

    public function getReporteRP_ALL($oficina_id, $desde, $hasta, $saldos, $Conex)
    { //ok

        $select = "
			SELECT
			(SELECT GROUP_CONCAT(m.manifiesto) FROM detalle_despacho dd, manifiesto m WHERE dd.remesa_id=r.remesa_id AND m.manifiesto_id=dd.manifiesto_id AND m.estado!='A') AS planilla,
			(SELECT GROUP_CONCAT(m.fecha_mc) FROM detalle_despacho dd, manifiesto m WHERE dd.remesa_id=r.remesa_id AND m.manifiesto_id=dd.manifiesto_id AND m.estado!='A') AS fecha_planilla,
			(SELECT nombre FROM oficina WHERE oficina_id=r.oficina_id) AS oficina_remesa,
			r.numero_remesa,
			IF(r.paqueteo=1,'PAQUETEO','MASIVO') AS tipo_remesa,
			CASE r.estado WHEN 'P' THEN 'PENDIENTE' WHEN 'PD' THEN 'PENDIENTE' WHEN 'PC' THEN 'PROCESANDO' WHEN 'MF' THEN 'MANIFESTADO'
			WHEN 'LQ' THEN 'LIQUIDADA' WHEN 'FT' THEN 'FACTURADA' WHEN 'ET' THEN 'ENTREGADA' WHEN 'AN' THEN 'ANULADA' ELSE 'PENDIENTE' END AS estado,
			IF(r.clase_remesa = 'NN','NORMAL',IF(r.clase_remesa = 'DV','DEVOLUCION',IF(r.clase_remesa = 'CP','COMPLEMENTO',IF(r.clase_remesa = 'AL','ALMACEN','SUMINISTRO')))) AS clase,
			r.fecha_remesa,
			(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM cliente c, tercero t  WHERE c.cliente_id=r.cliente_id AND c.tercero_id=t.tercero_id)  AS cliente,
			(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) AS origen,
			r.remitente,
			(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino,
			r.destinatario,
			r.orden_despacho,
		  (SELECT codigo FROM producto WHERE producto_id=r.producto_id) AS codigo,
		  r.descripcion_producto,
		  (SELECT naturaleza FROM naturaleza WHERE naturaleza_id=r.naturaleza_id) AS naturaleza,
		  (SELECT empaque FROM empaque WHERE empaque_id=r.empaque_id) AS empaque,
		  (SELECT medida FROM medida WHERE medida_id=r.medida_id) AS medida,
		  r.cantidad,
		  r.peso,
		  r.peso_volumen,
		  r.valor as valor_mercancia,
		  r.valor_flete,
		  r.valor_seguro,
		  r.valor_otros,
		  r.valor_total,
		  r.valor_liq_flete,
		  r.valor_liq_seguro,
		  r.valor_liq_otros,
		  r.valor_liq_total,
  		  IF(r.valor_facturar>0,r.valor_facturar,r.valor_total) AS valor_facturar,
		  r.observacion_anulacion,
		  (SELECT nombre FROM causal_anulacion WHERE r.causal_anulacion_id = causal_anulacion_id) AS causal_anulacion,
		  r.fecha_anulacion,
		  (SELECT CONCAT_WS(' ',t.primer_nombre,t.primer_apellido) FROM usuario u, tercero t  WHERE r.usuario_anulo_id = u.usuario_id  AND u.tercero_id  = t.tercero_id)  AS usuario_anulacion,
		  (SELECT GROUP_CONCAT(f.consecutivo_factura) FROM factura f,detalle_factura df WHERE r.remesa_id = df.remesa_id AND f.factura_id = df.factura_id AND f.estado!='I') AS numero_factura,
		  (SELECT GROUP_CONCAT(f.fecha) FROM factura f,detalle_factura df WHERE r.remesa_id = df.remesa_id AND f.factura_id = df.factura_id AND f.estado!='I') AS fecha_factura,
		  (SELECT GROUP_CONCAT(df.valor) FROM factura f,detalle_factura df WHERE df.remesa_id = r.remesa_id AND f.factura_id=df.factura_id AND f.estado!='I') AS valor_facturado
		  FROM remesa r
		  WHERE r.fecha_remesa BETWEEN '$desde' AND '$hasta'
		  AND r.oficina_id IN($oficina_id) AND r.estado !='AN' AND r.estado !='FT' AND r.clase_remesa IN ('NN','DV','CP') AND r.paqueteo NOT IN(2,3)
		  ORDER BY cliente";

        $results = $this->DbFetchAll($select, $Conex);

        return $results;

    }

}
