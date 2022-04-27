<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class reporteTrazabilidadModel extends Db{

	private $Permisos;

	public function SetUsuarioId($UserId,$CodCId){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($UserId,$CodCId);
	}

	public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
	}

	public function GetOficina($Conex){
		return $this -> DbFetchAll("SELECT oficina_id AS value,nombre AS text FROM oficina",$Conex,$ErrDb = false);
	}

	public function GetEstado($Conex){
		$opciones=array(0=>array('value'=>'MC','text'=>'MANIFIESTO DE CARGA(MC)'),1=>array('value'=>'DU','text'=>'DESPACHO URBANO(DU)'));
		return $opciones;
	}

	public function GetTrazabilidad($Conex){
		$opciones=array(0=>array('value'=>'OP','text'=>'OPERATIVA'),1=>array('value'=>'FI','text'=>'FINANCIERA'));
		return $opciones;
	}

	public function GetSi_Pro($Conex){
		$opciones=array(0=>array('value'=>'1','text'=>'UNO'),1=>array('value'=>'ALL','text'=>'TODOS'));
		return $opciones;
	}  


	public function getReporte1($oficina_id,$desde,$hasta,$condicion_cliente,$Conex){

		$select = "SELECT
						m.manifiesto AS orden_despacho,
						m.fecha_mc AS fecha,
						(SELECT GROUP_CONCAT(r.numero_remesa) FROM remesa r, detalle_despacho dd WHERE m.manifiesto_id = dd.manifiesto_id AND dd.remesa_id = r.remesa_id AND r.fecha_remesa BETWEEN '$desde' AND '$hasta' AND r.oficina_id IN($oficina_id)) AS numero_remesa,
						(SELECT nombre FROM ubicacion WHERE ubicacion_id = m.origen_id) AS origen,
						(SELECT nombre FROM ubicacion WHERE ubicacion_id = m.destino_id) AS destino,
						(SELECT v.placa FROM vehiculo v WHERE m.placa_id = v.placa_id) AS placa,
						(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM tercero t,tenedor te WHERE te.tenedor_id=m.tenedor_id AND t.tercero_id = te.tercero_id) AS tenedor,
						(SELECT GROUP_CONCAT(DISTINCT(CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social))) FROM tercero t,cliente c,remesa r,detalle_despacho dd WHERE dd.remesa_id = r.remesa_id AND m.manifiesto_id = dd.manifiesto_id AND c.cliente_id = r.cliente_id AND c.tercero_id = t.tercero_id) AS cliente,	
						(SELECT IF(m.valor_flete >= 0,m.valor_flete,0)) AS valor_flete,
						(SELECT GROUP_CONCAT(am.valor) FROM anticipos_manifiesto am WHERE am.manifiesto_id = m.manifiesto_id AND m.fecha_mc BETWEEN '$desde' AND '$hasta' AND am.oficina_id IN($oficina_id)) AS anticipo,
						(SELECT GROUP_CONCAT(am.consecutivo) FROM anticipos_manifiesto am WHERE am.manifiesto_id = m.manifiesto_id AND m.fecha_mc BETWEEN '$desde' AND '$hasta' AND m.oficina_id IN($oficina_id)) AS numegreso,
						(SELECT GROUP_CONCAT(im.valor) FROM impuestos_manifiesto im WHERE im.manifiesto_id = m.manifiesto_id) AS retefuente,
						m.saldo_por_pagar AS saldo_pagar,
						(SELECT GROUP_CONCAT(ld.valor_sobre_flete) FROM liquidacion_despacho ld WHERE ld.manifiesto_id = m.manifiesto_id AND m.fecha_mc BETWEEN '$desde' AND '$hasta' AND m.oficina_id IN($oficina_id)) AS sobreflete,
						(SELECT GROUP_CONCAT(dm.valor) FROM descuentos_manifiesto dm WHERE dm.manifiesto_id = m.manifiesto_id AND dm.nombre LIKE '%PAPELERIA%') AS dto_papeleria,
						(SELECT GROUP_CONCAT(dm.valor) FROM descuentos_manifiesto dm WHERE dm.manifiesto_id = m.manifiesto_id AND dm.nombre LIKE '%SEGURO%') AS dto_seguro,
						(SELECT GROUP_CONCAT(dm.valor) FROM descuentos_manifiesto dm WHERE dm.manifiesto_id = m.manifiesto_id AND dm.nombre LIKE '%FALTANTES Y AVERIAS%') AS dto_averias,
						(SELECT GROUP_CONCAT(dm.valor) FROM descuentos_manifiesto dm WHERE dm.manifiesto_id = m.manifiesto_id AND dm.nombre LIKE '%NO REPORTES%') AS dto_noreportes,
						(SELECT GROUP_CONCAT(dm.valor) FROM descuentos_manifiesto dm WHERE dm.manifiesto_id = m.manifiesto_id AND dm.nombre LIKE '%MORA EN CUMPLIDOS%') AS dto_mora,
						(SELECT GROUP_CONCAT(er.consecutivo) FROM liquidacion_despacho ld, encabezado_de_registro er WHERE er.encabezado_registro_id = ld.encabezado_registro_id AND ld.manifiesto_id = m.manifiesto_id AND m.fecha_mc BETWEEN '$desde' AND '$hasta') AS numeroegreso,
						(SELECT GROUP_CONCAT(DISTINCT(f.consecutivo_factura)) FROM factura f, detalle_factura df, detalle_despacho dd WHERE dd.manifiesto_id = m.manifiesto_id AND df.remesa_id = dd.remesa_id AND df.factura_id = f.factura_id) AS numfactura,
						(SELECT GROUP_CONCAT(DISTINCT(f.fecha)) FROM factura f, detalle_factura df, detalle_despacho dd WHERE dd.manifiesto_id = m.manifiesto_id AND df.remesa_id = dd.remesa_id AND df.factura_id = f.factura_id) AS fecfactura,
						(SELECT SUM(df.valor) FROM factura f, detalle_factura df, detalle_despacho dd WHERE dd.manifiesto_id = m.manifiesto_id AND df.remesa_id = dd.remesa_id AND df.factura_id = f.factura_id) AS valfactura
					FROM
						manifiesto m 
					WHERE
						m.fecha_mc BETWEEN '$desde' AND '$hasta' AND
						m.oficina_id IN($oficina_id)
						$condicion_cliente
					ORDER BY
						m.manifiesto
					";
		$results = $this -> DbFetchAll($select,$Conex);

		$i=0;
		foreach($results as $items){
			$result[$i]=array(numero_remesa=>$items[numero_remesa],fecha=>$items[fecha],orden_despacho=>$items[orden_despacho],cliente=>$items[cliente],
			origen=>$items[origen],destino=>$items[destino],placa=>$items[placa],tenedor=>$items[tenedor],valor_flete=>$items[valor_flete],sobreflete=>$items[sobreflete],
			retefuente=>$items[retefuente],saldo_pagar=>$items[saldo_pagar],anticipo=>$items[anticipo],numegreso=>$items[numegreso],dto_papeleria=>$items[dto_papeleria],
			dto_seguro=>$items[dto_seguro],dto_averias=>$items[dto_averias],dto_noreportes=>$items[dto_noreportes],dto_mora=>$items[dto_mora],ne_pago=>$items[ne_pago],
			numfactura=>$items[numfactura],fecfactura=>$items[fecfactura],valfactura=>$items[valfactura],estado=>$items[estado],clase=>$items[clase],
			numeroegreso=>$items[numeroegreso],numabonofac=>$items[numabonofac],fecabonofac=>$items[fecabonofac],valabonofac=>$items[valabonofac]);	
			$i++;
		}

		return $result;
	}

	public function getReporte2($oficina_id,$desde,$hasta,$condicion_cliente1,$Conex){

		$select = "SELECT
					m.despacho AS orden_despacho,
					m.fecha_du AS fecha,
					(SELECT GROUP_CONCAT(r.numero_remesa) FROM remesa r, detalle_despacho dd WHERE m.despachos_urbanos_id = dd.despachos_urbanos_id AND dd.remesa_id = r.remesa_id AND r.fecha_remesa BETWEEN '$desde' AND '$hasta' AND r.oficina_id IN($oficina_id)) AS numero_remesa,
					(SELECT nombre FROM ubicacion WHERE ubicacion_id = m.origen_id) AS origen,(SELECT nombre FROM ubicacion WHERE ubicacion_id = m.destino_id) AS destino,
					(SELECT v.placa FROM vehiculo v WHERE m.placa_id = v.placa_id) AS placa,
					(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM tercero t,tenedor te WHERE te.tenedor_id=m.tenedor_id AND t.tercero_id = te.tercero_id) AS tenedor,
					(SELECT GROUP_CONCAT(DISTINCT(CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social))) FROM tercero t,cliente c,remesa r,detalle_despacho dd WHERE dd.remesa_id = r.remesa_id AND m.despachos_urbanos_id = dd.despachos_urbanos_id AND c.cliente_id = r.cliente_id AND c.tercero_id = t.tercero_id) AS cliente,
					(SELECT IF(m.valor_flete >= 0,m.valor_flete,0)) AS valor_flete,
					(SELECT GROUP_CONCAT(am.valor) FROM anticipos_despacho am WHERE am.despachos_urbanos_id = m.despachos_urbanos_id AND m.fecha_du BETWEEN '$desde' AND '$hasta' AND am.oficina_id IN($oficina_id)) AS anticipo,
					(SELECT GROUP_CONCAT(am.consecutivo) FROM anticipos_despacho am WHERE am.despachos_urbanos_id = m.despachos_urbanos_id AND m.fecha_du BETWEEN '$desde' AND '$hasta' AND m.oficina_id IN($oficina_id)) AS numegreso,
					(SELECT GROUP_CONCAT(im.valor) FROM impuestos_despacho im WHERE im.despachos_urbanos_id = m.despachos_urbanos_id) AS retefuente,
					m.saldo_por_pagar AS saldo_pagar,
					(SELECT GROUP_CONCAT(ld.valor_sobre_flete) FROM liquidacion_despacho ld WHERE ld.despachos_urbanos_id = m.despachos_urbanos_id AND m.fecha_du BETWEEN '$desde' AND '$hasta' AND m.oficina_id IN($oficina_id)) AS sobreflete,	
					(SELECT GROUP_CONCAT(dm.valor) FROM descuentos_despacho dm WHERE dm.despachos_urbanos_id = m.despachos_urbanos_id AND dm.nombre LIKE '%PAPELERIA%') AS dto_papeleria,
					(SELECT GROUP_CONCAT(dm.valor) FROM descuentos_despacho dm WHERE dm.despachos_urbanos_id = m.despachos_urbanos_id AND dm.nombre LIKE '%SEGURO%') AS dto_seguro,
					(SELECT GROUP_CONCAT(dm.valor) FROM descuentos_despacho dm WHERE dm.despachos_urbanos_id = m.despachos_urbanos_id AND dm.nombre LIKE '%FALTANTES Y AVERIAS%') AS dto_averias,
					(SELECT GROUP_CONCAT(dm.valor) FROM descuentos_despacho dm WHERE dm.despachos_urbanos_id = m.despachos_urbanos_id AND dm.nombre LIKE '%NO REPORTES%') AS dto_noreportes,
					(SELECT GROUP_CONCAT(dm.valor) FROM descuentos_despacho dm WHERE dm.despachos_urbanos_id = m.despachos_urbanos_id AND dm.nombre LIKE '%MORA EN CUMPLIDOS%') AS dto_mora,
					(SELECT GROUP_CONCAT(er.consecutivo) FROM liquidacion_despacho ld, encabezado_de_registro er WHERE er.encabezado_registro_id = ld.encabezado_registro_id AND ld.despachos_urbanos_id = m.despachos_urbanos_id AND m.fecha_du BETWEEN '$desde' AND '$hasta') AS numeroegreso,
					(SELECT GROUP_CONCAT(DISTINCT(f.consecutivo_factura)) FROM factura f, detalle_factura df, detalle_despacho dd WHERE dd.despachos_urbanos_id = m.despachos_urbanos_id AND df.remesa_id = dd.remesa_id AND df.factura_id = f.factura_id) AS numfactura,
					(SELECT GROUP_CONCAT(DISTINCT(f.fecha)) FROM factura f, detalle_factura df, detalle_despacho dd WHERE dd.despachos_urbanos_id = m.despachos_urbanos_id AND df.remesa_id = dd.remesa_id AND df.factura_id = f.factura_id) AS fecfactura,
					(SELECT SUM(df.valor) FROM factura f, detalle_factura df, detalle_despacho dd WHERE dd.despachos_urbanos_id = m.despachos_urbanos_id AND df.remesa_id = dd.remesa_id AND df.factura_id = f.factura_id) AS valfactura
				FROM
					despachos_urbanos m 
				WHERE
					m.fecha_du BETWEEN '$desde' AND '$hasta' AND
					m.oficina_id IN($oficina_id)
					$condicion_cliente1
				ORDER BY
					m.despachos_urbanos_id
				";
		$results = $this -> DbFetchAll($select,$Conex);

		$i=0;
		foreach($results as $items){
			$result[$i]=array(numero_remesa=>$items[numero_remesa],fecha=>$items[fecha],orden_despacho=>$items[orden_despacho],cliente=>$items[cliente],
			origen=>$items[origen],destino=>$items[destino],placa=>$items[placa],tenedor=>$items[tenedor],valor_flete=>$items[valor_flete],sobreflete=>$items[sobreflete],
			retefuente=>$items[retefuente],saldo_pagar=>$items[saldo_pagar],anticipo=>$items[anticipo],numegreso=>$items[numegreso],dto_papeleria=>$items[dto_papeleria],
			dto_seguro=>$items[dto_seguro],dto_averias=>$items[dto_averias],dto_noreportes=>$items[dto_noreportes],dto_mora=>$items[dto_mora],ne_pago=>$items[ne_pago],
			numfactura=>$items[numfactura],fecfactura=>$items[fecfactura],valfactura=>$items[valfactura],estado=>$items[estado],clase=>$items[clase],
			numeroegreso=>$items[numeroegreso],numabonofac=>$items[numabonofac],fecabonofac=>$items[fecabonofac],valabonofac=>$items[valabonofac]);	
			$i++;
		}

		return $result;
	}

	public function getReporte3($oficina_id,$desde,$hasta,$condicion_cliente,$condicion_cliente1,$Conex){ 

		$select = "(SELECT
						m.manifiesto AS orden_despacho,
						m.fecha_mc AS fecha,
						(SELECT GROUP_CONCAT(r.numero_remesa) FROM remesa r, detalle_despacho dd WHERE m.manifiesto_id = dd.manifiesto_id AND dd.remesa_id = r.remesa_id AND r.fecha_remesa BETWEEN '$desde' AND '$hasta' AND r.oficina_id IN($oficina_id)) AS numero_remesa,
						(SELECT nombre FROM ubicacion WHERE ubicacion_id = m.origen_id) AS origen,
						(SELECT nombre FROM ubicacion WHERE ubicacion_id = m.destino_id) AS destino,
						(SELECT v.placa FROM vehiculo v WHERE m.placa_id = v.placa_id) AS placa,
						(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM tercero t,tenedor te WHERE te.tenedor_id=m.tenedor_id AND t.tercero_id = te.tercero_id) AS tenedor,
						(SELECT GROUP_CONCAT(DISTINCT(CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social))) FROM tercero t,cliente c,remesa r,detalle_despacho dd WHERE dd.remesa_id = r.remesa_id AND m.manifiesto_id = dd.manifiesto_id AND c.cliente_id = r.cliente_id AND c.tercero_id = t.tercero_id) AS cliente,	
						(SELECT IF(m.valor_flete >= 0,m.valor_flete,0)) AS valor_flete,
						(SELECT GROUP_CONCAT(am.valor) FROM anticipos_manifiesto am WHERE am.manifiesto_id = m.manifiesto_id AND m.fecha_mc BETWEEN '$desde' AND '$hasta' AND am.oficina_id IN($oficina_id)) AS anticipo,
						(SELECT GROUP_CONCAT(am.consecutivo) FROM anticipos_manifiesto am WHERE am.manifiesto_id = m.manifiesto_id AND m.fecha_mc BETWEEN '$desde' AND '$hasta' AND m.oficina_id IN($oficina_id)) AS numegreso,
						(SELECT GROUP_CONCAT(im.valor) FROM impuestos_manifiesto im WHERE im.manifiesto_id = m.manifiesto_id) AS retefuente,
						m.saldo_por_pagar AS saldo_pagar,
						(SELECT GROUP_CONCAT(ld.valor_sobre_flete) FROM liquidacion_despacho ld WHERE ld.manifiesto_id = m.manifiesto_id AND m.fecha_mc BETWEEN '$desde' AND '$hasta' AND m.oficina_id IN($oficina_id)) AS sobreflete,
						(SELECT GROUP_CONCAT(dm.valor) FROM descuentos_manifiesto dm WHERE dm.manifiesto_id = m.manifiesto_id AND dm.nombre LIKE '%PAPELERIA%') AS dto_papeleria,
						(SELECT GROUP_CONCAT(dm.valor) FROM descuentos_manifiesto dm WHERE dm.manifiesto_id = m.manifiesto_id AND dm.nombre LIKE '%SEGURO%') AS dto_seguro,
						(SELECT GROUP_CONCAT(dm.valor) FROM descuentos_manifiesto dm WHERE dm.manifiesto_id = m.manifiesto_id AND dm.nombre LIKE '%FALTANTES Y AVERIAS%') AS dto_averias,
						(SELECT GROUP_CONCAT(dm.valor) FROM descuentos_manifiesto dm WHERE dm.manifiesto_id = m.manifiesto_id AND dm.nombre LIKE '%NO REPORTES%') AS dto_noreportes,
						(SELECT GROUP_CONCAT(dm.valor) FROM descuentos_manifiesto dm WHERE dm.manifiesto_id = m.manifiesto_id AND dm.nombre LIKE '%MORA EN CUMPLIDOS%') AS dto_mora,
						(SELECT GROUP_CONCAT(er.consecutivo) FROM liquidacion_despacho ld, encabezado_de_registro er WHERE er.encabezado_registro_id = ld.encabezado_registro_id AND ld.manifiesto_id = m.manifiesto_id AND m.fecha_mc BETWEEN '$desde' AND '$hasta') AS numeroegreso,
						(SELECT GROUP_CONCAT(DISTINCT(f.consecutivo_factura)) FROM factura f, detalle_factura df, detalle_despacho dd WHERE dd.manifiesto_id = m.manifiesto_id AND df.remesa_id = dd.remesa_id AND df.factura_id = f.factura_id) AS numfactura,
						(SELECT GROUP_CONCAT(DISTINCT(f.fecha)) FROM factura f, detalle_factura df, detalle_despacho dd WHERE dd.manifiesto_id = m.manifiesto_id AND df.remesa_id = dd.remesa_id AND df.factura_id = f.factura_id) AS fecfactura,
						(SELECT SUM(df.valor) FROM factura f, detalle_factura df, detalle_despacho dd WHERE dd.manifiesto_id = m.manifiesto_id AND df.remesa_id = dd.remesa_id AND df.factura_id = f.factura_id) AS valfactura
					FROM
						manifiesto m 
					WHERE
						m.fecha_mc BETWEEN '$desde' AND '$hasta' AND
						m.oficina_id IN($oficina_id)
						$condicion_cliente)

					UNION ALL(
					SELECT
						m.despacho AS orden_despacho,
						m.fecha_du AS fecha,
						(SELECT GROUP_CONCAT(r.numero_remesa) FROM remesa r, detalle_despacho dd WHERE m.despachos_urbanos_id = dd.despachos_urbanos_id AND dd.remesa_id = r.remesa_id AND r.fecha_remesa BETWEEN '$desde' AND '$hasta' AND r.oficina_id IN($oficina_id)) AS numero_remesa,
						(SELECT nombre FROM ubicacion WHERE ubicacion_id = m.origen_id) AS origen,(SELECT nombre FROM ubicacion WHERE ubicacion_id = m.destino_id) AS destino,
						(SELECT v.placa FROM vehiculo v WHERE m.placa_id = v.placa_id) AS placa,
						(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM tercero t,tenedor te WHERE te.tenedor_id=m.tenedor_id AND t.tercero_id = te.tercero_id) AS tenedor,
						(SELECT GROUP_CONCAT(DISTINCT(CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social))) FROM tercero t,cliente c,remesa r,detalle_despacho dd WHERE dd.remesa_id = r.remesa_id AND m.despachos_urbanos_id = dd.despachos_urbanos_id AND c.cliente_id = r.cliente_id AND c.tercero_id = t.tercero_id) AS cliente,
						(SELECT IF(m.valor_flete >= 0,m.valor_flete,0)) AS valor_flete,
						(SELECT GROUP_CONCAT(am.valor) FROM anticipos_despacho am WHERE am.despachos_urbanos_id = m.despachos_urbanos_id AND m.fecha_du BETWEEN '$desde' AND '$hasta' AND am.oficina_id IN($oficina_id)) AS anticipo,
						(SELECT GROUP_CONCAT(am.consecutivo) FROM anticipos_despacho am WHERE am.despachos_urbanos_id = m.despachos_urbanos_id AND m.fecha_du BETWEEN '$desde' AND '$hasta' AND m.oficina_id IN($oficina_id)) AS numegreso,
						(SELECT GROUP_CONCAT(im.valor) FROM impuestos_despacho im WHERE im.despachos_urbanos_id = m.despachos_urbanos_id) AS retefuente,
						m.saldo_por_pagar AS saldo_pagar,
						(SELECT GROUP_CONCAT(ld.valor_sobre_flete) FROM liquidacion_despacho ld WHERE ld.despachos_urbanos_id = m.despachos_urbanos_id AND m.fecha_du BETWEEN '$desde' AND '$hasta' AND m.oficina_id IN($oficina_id)) AS sobreflete,	
						(SELECT GROUP_CONCAT(dm.valor) FROM descuentos_despacho dm WHERE dm.despachos_urbanos_id = m.despachos_urbanos_id AND dm.nombre LIKE '%PAPELERIA%') AS dto_papeleria,
						(SELECT GROUP_CONCAT(dm.valor) FROM descuentos_despacho dm WHERE dm.despachos_urbanos_id = m.despachos_urbanos_id AND dm.nombre LIKE '%SEGURO%') AS dto_seguro,
						(SELECT GROUP_CONCAT(dm.valor) FROM descuentos_despacho dm WHERE dm.despachos_urbanos_id = m.despachos_urbanos_id AND dm.nombre LIKE '%FALTANTES Y AVERIAS%') AS dto_averias,
						(SELECT GROUP_CONCAT(dm.valor) FROM descuentos_despacho dm WHERE dm.despachos_urbanos_id = m.despachos_urbanos_id AND dm.nombre LIKE '%NO REPORTES%') AS dto_noreportes,
						(SELECT GROUP_CONCAT(dm.valor) FROM descuentos_despacho dm WHERE dm.despachos_urbanos_id = m.despachos_urbanos_id AND dm.nombre LIKE '%MORA EN CUMPLIDOS%') AS dto_mora,
						(SELECT GROUP_CONCAT(er.consecutivo) FROM liquidacion_despacho ld, encabezado_de_registro er WHERE er.encabezado_registro_id = ld.encabezado_registro_id AND ld.despachos_urbanos_id = m.despachos_urbanos_id AND m.fecha_du BETWEEN '$desde' AND '$hasta') AS numeroegreso,
						(SELECT GROUP_CONCAT(DISTINCT(f.consecutivo_factura)) FROM factura f, detalle_factura df, detalle_despacho dd WHERE dd.despachos_urbanos_id = m.despachos_urbanos_id AND df.remesa_id = dd.remesa_id AND df.factura_id = f.factura_id) AS numfactura,
						(SELECT GROUP_CONCAT(DISTINCT(f.fecha)) FROM factura f, detalle_factura df, detalle_despacho dd WHERE dd.despachos_urbanos_id = m.despachos_urbanos_id AND df.remesa_id = dd.remesa_id AND df.factura_id = f.factura_id) AS fecfactura,
						(SELECT SUM(df.valor) FROM factura f, detalle_factura df, detalle_despacho dd WHERE dd.despachos_urbanos_id = m.despachos_urbanos_id AND df.remesa_id = dd.remesa_id AND df.factura_id = f.factura_id) AS valfactura
					FROM
						despachos_urbanos m 
					WHERE
						m.fecha_du BETWEEN '$desde' AND '$hasta' AND
						m.oficina_id IN($oficina_id)
						$condicion_cliente1
					ORDER BY
						m.despachos_urbanos_id)";

		$results = $this -> DbFetchAll($select,$Conex);

		$i=0;
		foreach($results as $items){
			$result[$i]=array(numero_remesa=>$items[numero_remesa],fecha=>$items[fecha],orden_despacho=>$items[orden_despacho],cliente=>$items[cliente],
			origen=>$items[origen],destino=>$items[destino],placa=>$items[placa],tenedor=>$items[tenedor],valor_flete=>$items[valor_flete],sobreflete=>$items[sobreflete],
			retefuente=>$items[retefuente],saldo_pagar=>$items[saldo_pagar],anticipo=>$items[anticipo],numegreso=>$items[numegreso],dto_papeleria=>$items[dto_papeleria],
			dto_seguro=>$items[dto_seguro],dto_averias=>$items[dto_averias],dto_noreportes=>$items[dto_noreportes],dto_mora=>$items[dto_mora],ne_pago=>$items[ne_pago],
			numfactura=>$items[numfactura],fecfactura=>$items[fecfactura],valfactura=>$items[valfactura],estado=>$items[estado],clase=>$items[clase],
			numeroegreso=>$items[numeroegreso],numabonofac=>$items[numabonofac],fecabonofac=>$items[fecabonofac],valabonofac=>$items[valabonofac]);	
			$i++;
		}

		return $result;
	}

	public function getReporte4($oficina_id,$desde,$hasta,$condicion_cliente,$Conex){ 

		$select =	"SELECT
						r.numero_remesa,
						r.fecha_remesa,
						(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) AS origen,
						(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino,
						m.placa,
						r.estado,
						(SELECT GROUP_CONCAT(nombre) FROM oficina WHERE oficina_id = r.oficina_id) AS oficina,
						(SELECT GROUP_CONCAT(DISTINCT(CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social))) FROM tercero t, cliente c, remesa r, detalle_despacho dd WHERE dd.remesa_id=r.remesa_id AND m.manifiesto_id = dd.manifiesto_id AND c.cliente_id = r.cliente_id AND c.tercero_id = t.tercero_id) AS cliente,	
						(SELECT GROUP_CONCAT(DISTINCT(f.consecutivo_factura)) FROM factura f, detalle_factura df, detalle_despacho dd WHERE dd.remesa_id = r.remesa_id AND df.remesa_id = dd.remesa_id AND df.factura_id = f.factura_id AND f.estado!='I') AS numfactura,
						(SELECT GROUP_CONCAT(DISTINCT(f.fecha)) FROM factura f, detalle_factura df, detalle_despacho dd WHERE dd.remesa_id = r.remesa_id AND df.remesa_id = dd.remesa_id AND df.factura_id = f.factura_id AND f.estado!='I') AS fecfactura,
						(SELECT SUM(df.valor) FROM factura f, detalle_factura df, detalle_despacho dd WHERE dd.remesa_id = r.remesa_id AND df.remesa_id = dd.remesa_id AND df.factura_id = f.factura_id AND f.estado!='I') AS valfactura,
						(SELECT GROUP_CONCAT(DISTINCT(CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewDocument(',er.encabezado_registro_id,')\">', er.consecutivo, '</a>'))) FROM abono_factura ab, relacion_abono ra, encabezado_de_registro er, factura f, detalle_factura df, detalle_despacho dd WHERE dd.remesa_id=r.remesa_id AND df.remesa_id=dd.remesa_id AND f.factura_id=df.factura_id AND  ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND er.encabezado_registro_id=ab.encabezado_registro_id AND ab.estado_abono_factura!='I') AS relacion_pago,
						(SELECT GROUP_CONCAT(DISTINCT(er.fecha)) FROM abono_factura ab, relacion_abono ra, encabezado_de_registro er, factura f, detalle_factura df, detalle_despacho dd WHERE dd.remesa_id=r.remesa_id AND df.remesa_id=dd.remesa_id AND f.factura_id=df.factura_id AND  ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND er.encabezado_registro_id=ab.encabezado_registro_id AND ab.estado_abono_factura!='I') AS fecha_relacion_pago,
						(SELECT GROUP_CONCAT(er.valor) FROM abono_factura ab, relacion_abono ra, encabezado_de_registro er, factura f, detalle_factura df, detalle_despacho dd WHERE dd.remesa_id=r.remesa_id AND df.remesa_id=dd.remesa_id AND f.factura_id=df.factura_id AND  ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND er.encabezado_registro_id=ab.encabezado_registro_id AND ab.estado_abono_factura!='I') AS valor_relacion_pago,
						m.manifiesto AS numero_planilla,
						'MC'AS es,
						m.fecha_mc AS fecha,
						(SELECT IF(r.estado!='AN',r.valor_costo,0)) AS valor_costo,
						(SELECT IF(ld.valor_sobre_flete>0,ld.valor_sobre_flete,m.valor_sobre_flete)) AS valor_sflete,
						(SELECT GROUP_CONCAT(DISTINCT(CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewDocument1(',oc.orden_compra_id,')\">',oc.consecutivo,'</a>'))) FROM item_liquida_orden ilo, orden_compra oc WHERE ilo.remesa_id=r.remesa_id AND ilo.orden_compra_id=oc.orden_compra_id AND oc.estado_orden_compra!='I') AS ordenes_compras,
						(SELECT GROUP_CONCAT(oc.fecha_orden_compra) FROM item_liquida_orden ilo, orden_compra oc WHERE ilo.remesa_id=r.remesa_id AND ilo.orden_compra_id=oc.orden_compra_id AND oc.estado_orden_compra!='I') AS fecha_ordenes_compras,
						(SELECT SUM(ilo.valoruni_item_liquida_orden) FROM item_liquida_orden ilo, orden_compra oc WHERE ilo.remesa_id=r.remesa_id AND ilo.orden_compra_id=oc.orden_compra_id AND oc.estado_orden_compra!='I') AS valor_orden_compra
					FROM	manifiesto m, detalle_despacho dd, remesa r, liquidacion_despacho ld
					WHERE
						r.fecha_remesa BETWEEN '$desde' AND '$hasta' AND
						ld.manifiesto_id=m.manifiesto_id AND
						r.oficina_id IN($oficina_id) AND
						dd.manifiesto_id=m.manifiesto_id AND
						r.remesa_id=dd.remesa_id AND ld.estado_liquidacion!='A'
						$condicion_cliente
					ORDER BY
						r.numero_remesa
					"; 
		$results = $this -> DbFetchAll($select,$Conex);
		return $results;
	}

	public function getReporte5($oficina_id,$desde,$hasta,$condicion_cliente,$Conex){ 

		$select =	"SELECT
						r.numero_remesa,
						r.fecha_remesa,
						(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) AS origen,
						(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino,
						m.placa,
						r.estado,
						(SELECT GROUP_CONCAT(nombre) FROM oficina WHERE oficina_id = r.oficina_id) AS oficina,
	    				(SELECT GROUP_CONCAT(DISTINCT(CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social))) FROM tercero t, cliente c, remesa r, detalle_despacho dd WHERE dd.remesa_id=r.remesa_id AND m.despachos_urbanos_id = dd.despachos_urbanos_id AND c.cliente_id = r.cliente_id AND c.tercero_id = t.tercero_id) AS cliente,	
						(SELECT GROUP_CONCAT(DISTINCT(f.consecutivo_factura)) FROM factura f, detalle_factura df, detalle_despacho dd WHERE dd.remesa_id = r.remesa_id AND df.remesa_id = dd.remesa_id AND df.factura_id = f.factura_id AND f.estado!='I') AS numfactura,
						(SELECT GROUP_CONCAT(DISTINCT(f.fecha)) FROM factura f, detalle_factura df, detalle_despacho dd WHERE dd.remesa_id = r.remesa_id AND df.remesa_id = dd.remesa_id AND df.factura_id = f.factura_id AND f.estado!='I') AS fecfactura,
						(SELECT SUM(df.valor) FROM factura f, detalle_factura df, detalle_despacho dd WHERE dd.remesa_id = r.remesa_id AND df.remesa_id = dd.remesa_id AND df.factura_id = f.factura_id AND f.estado!='I') AS valfactura,
						(SELECT GROUP_CONCAT(DISTINCT(CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewDocument(',er.encabezado_registro_id,')\">', er.consecutivo, '</a>'))) FROM abono_factura ab, relacion_abono ra, encabezado_de_registro er, factura f, detalle_factura df, detalle_despacho dd WHERE dd.remesa_id=r.remesa_id AND df.remesa_id=dd.remesa_id AND f.factura_id=df.factura_id AND  ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND er.encabezado_registro_id=ab.encabezado_registro_id AND ab.estado_abono_factura!='I') AS relacion_pago,
						(SELECT GROUP_CONCAT(DISTINCT( er.fecha)) FROM abono_factura ab, relacion_abono ra, encabezado_de_registro er, factura f, detalle_factura df, detalle_despacho dd WHERE dd.remesa_id=r.remesa_id AND df.remesa_id=dd.remesa_id AND f.factura_id=df.factura_id AND  ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND er.encabezado_registro_id=ab.encabezado_registro_id AND ab.estado_abono_factura!='I') AS fecha_relacion_pago,
						(SELECT GROUP_CONCAT(er.valor) FROM abono_factura ab, relacion_abono ra, encabezado_de_registro er, factura f, detalle_factura df, detalle_despacho dd WHERE dd.remesa_id=r.remesa_id AND df.remesa_id=dd.remesa_id AND f.factura_id=df.factura_id AND  ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND er.encabezado_registro_id=ab.encabezado_registro_id AND ab.estado_abono_factura!='I') AS valor_relacion_pago,
						m.despacho AS numero_planilla,
						'DU' AS es,
						m.fecha_du AS fecha,
						(SELECT IF(r.estado!='AN',r.valor_costo,0)) AS valor_costo,
						(SELECT GROUP_CONCAT(DISTINCT(CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewDocument1(',oc.orden_compra_id,')\">',oc.consecutivo,'</a>'))) FROM item_liquida_orden ilo, orden_compra oc WHERE ilo.remesa_id=r.remesa_id AND ilo.orden_compra_id=oc.orden_compra_id AND oc.estado_orden_compra!='I') AS ordenes_compras,
						(SELECT GROUP_CONCAT(oc.fecha_orden_compra) FROM item_liquida_orden ilo, orden_compra oc WHERE ilo.remesa_id=r.remesa_id AND ilo.orden_compra_id=oc.orden_compra_id AND oc.estado_orden_compra!='I') AS fecha_ordenes_compras,
						(SELECT SUM(ilo.valoruni_item_liquida_orden) FROM item_liquida_orden ilo, orden_compra oc WHERE ilo.remesa_id=r.remesa_id AND ilo.orden_compra_id=oc.orden_compra_id AND oc.estado_orden_compra!='I') AS valor_orden_compra
					FROM
						despachos_urbanos m, detalle_despacho dd, remesa r
					WHERE
						r.fecha_remesa BETWEEN '$desde' AND '$hasta' AND
						r.oficina_id IN($oficina_id)  AND dd.despachos_urbanos_id=m.despachos_urbanos_id AND r.remesa_id=dd.remesa_id
						$condicion_cliente
					ORDER BY

						r.numero_remesa
					"; 
		$results = $this -> DbFetchAll($select,$Conex);
		return $results;
	}

	public function getReporte6($oficina_id,$desde,$hasta,$condicion_cliente,$Conex){ 

		$select =	"(SELECT
						r.numero_remesa,
						r.fecha_remesa,
						(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) AS origen,
						(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino,
						m.placa,
						r.estado,
						(SELECT GROUP_CONCAT(nombre) FROM oficina WHERE oficina_id = r.oficina_id) AS oficina,
						
						(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social)as cli FROM tercero t, cliente c WHERE c.cliente_id = r.cliente_id AND c.tercero_id = t.tercero_id) AS cliente,
							
						(SELECT GROUP_CONCAT(DISTINCT(f.consecutivo_factura)) FROM factura f, detalle_factura df, detalle_despacho dd WHERE dd.remesa_id = r.remesa_id AND df.remesa_id = dd.remesa_id AND df.factura_id = f.factura_id AND f.estado!='I') AS numfactura,
						(SELECT GROUP_CONCAT(DISTINCT(f.fecha)) FROM factura f, detalle_factura df, detalle_despacho dd WHERE dd.remesa_id = r.remesa_id AND df.remesa_id = dd.remesa_id AND df.factura_id = f.factura_id AND f.estado!='I') AS fecfactura,
						(SELECT SUM(df.valor) FROM factura f, detalle_factura df, detalle_despacho dd WHERE dd.remesa_id = r.remesa_id AND df.remesa_id = dd.remesa_id AND df.factura_id = f.factura_id AND f.estado!='I') AS valfactura,
						(SELECT GROUP_CONCAT(DISTINCT(CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewDocument(',er.encabezado_registro_id,')\">', er.consecutivo, '</a>'))) FROM abono_factura ab, relacion_abono ra, encabezado_de_registro er, factura f, detalle_factura df, detalle_despacho dd WHERE dd.remesa_id=r.remesa_id AND df.remesa_id=dd.remesa_id AND f.factura_id=df.factura_id AND  ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND er.encabezado_registro_id=ab.encabezado_registro_id AND ab.estado_abono_factura!='I') AS relacion_pago,
						(SELECT GROUP_CONCAT(DISTINCT( er.fecha)) FROM abono_factura ab, relacion_abono ra, encabezado_de_registro er, factura f, detalle_factura df, detalle_despacho dd WHERE dd.remesa_id=r.remesa_id AND df.remesa_id=dd.remesa_id AND f.factura_id=df.factura_id AND  ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND er.encabezado_registro_id=ab.encabezado_registro_id AND ab.estado_abono_factura!='I') AS fecha_relacion_pago,
						(SELECT GROUP_CONCAT(er.valor) FROM abono_factura ab, relacion_abono ra, encabezado_de_registro er, factura f, detalle_factura df, detalle_despacho dd WHERE dd.remesa_id=r.remesa_id AND df.remesa_id=dd.remesa_id AND f.factura_id=df.factura_id AND  ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND er.encabezado_registro_id=ab.encabezado_registro_id AND ab.estado_abono_factura!='I') AS valor_relacion_pago,
						m.manifiesto AS numero_planilla,
						'MC' AS es,
						m.fecha_mc AS fecha,
						(SELECT IF(r.estado!='AN',r.valor_costo,0)) AS valor_costo,
						(SELECT GROUP_CONCAT(DISTINCT(CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewDocument1(',oc.orden_compra_id,')\">',oc.consecutivo,'</a>'))) FROM item_liquida_orden ilo, orden_compra oc WHERE ilo.remesa_id=r.remesa_id AND ilo.orden_compra_id=oc.orden_compra_id AND oc.estado_orden_compra!='I') AS ordenes_compras,
						(SELECT GROUP_CONCAT(oc.fecha_orden_compra) FROM item_liquida_orden ilo, orden_compra oc WHERE ilo.remesa_id=r.remesa_id AND ilo.orden_compra_id=oc.orden_compra_id AND oc.estado_orden_compra!='I') AS fecha_ordenes_compras,
						(SELECT SUM(ilo.valoruni_item_liquida_orden) FROM item_liquida_orden ilo, orden_compra oc WHERE ilo.remesa_id=r.remesa_id AND ilo.orden_compra_id=oc.orden_compra_id AND oc.estado_orden_compra!='I') AS valor_orden_compra
					FROM
						manifiesto m , detalle_despacho dd, remesa r
					WHERE
						r.fecha_remesa BETWEEN '$desde' AND '$hasta' AND
						r.oficina_id IN($oficina_id) AND dd.manifiesto_id=m.manifiesto_id AND r.remesa_id=dd.remesa_id
						$condicion_cliente) 
						
					UNION ALL
						
					(SELECT
						r.numero_remesa,
						r.fecha_remesa,
						(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) AS origen,
						(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino,
						m.placa,
						r.estado,
						(SELECT GROUP_CONCAT(nombre) FROM oficina WHERE oficina_id = r.oficina_id) AS oficina,
						
						(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social)as cli FROM tercero t, cliente c WHERE c.cliente_id = r.cliente_id AND c.tercero_id = t.tercero_id) AS cliente,
							
						(SELECT GROUP_CONCAT(DISTINCT(f.consecutivo_factura)) FROM factura f, detalle_factura df, detalle_despacho dd WHERE dd.remesa_id = r.remesa_id AND df.remesa_id = dd.remesa_id AND df.factura_id = f.factura_id AND f.estado!='I') AS numfactura,
						(SELECT GROUP_CONCAT(DISTINCT(f.fecha)) FROM factura f, detalle_factura df, detalle_despacho dd WHERE dd.remesa_id = r.remesa_id AND df.remesa_id = dd.remesa_id AND df.factura_id = f.factura_id AND f.estado!='I') AS fecfactura,
						(SELECT SUM(df.valor) FROM factura f, detalle_factura df, detalle_despacho dd WHERE dd.remesa_id = r.remesa_id AND df.remesa_id = dd.remesa_id AND df.factura_id = f.factura_id AND f.estado!='I') AS valfactura,
						(SELECT GROUP_CONCAT(DISTINCT(CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewDocument(',er.encabezado_registro_id,')\">', er.consecutivo, '</a>'))) FROM abono_factura ab, relacion_abono ra, encabezado_de_registro er, factura f, detalle_factura df, detalle_despacho dd WHERE dd.remesa_id=r.remesa_id AND df.remesa_id=dd.remesa_id AND f.factura_id=df.factura_id AND  ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND er.encabezado_registro_id=ab.encabezado_registro_id AND ab.estado_abono_factura!='I') AS relacion_pago,
						(SELECT GROUP_CONCAT(DISTINCT( er.fecha)) FROM abono_factura ab, relacion_abono ra, encabezado_de_registro er, factura f, detalle_factura df, detalle_despacho dd WHERE dd.remesa_id=r.remesa_id AND df.remesa_id=dd.remesa_id AND f.factura_id=df.factura_id AND  ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND er.encabezado_registro_id=ab.encabezado_registro_id AND ab.estado_abono_factura!='I') AS fecha_relacion_pago,
						(SELECT GROUP_CONCAT(er.valor) FROM abono_factura ab, relacion_abono ra, encabezado_de_registro er, factura f, detalle_factura df, detalle_despacho dd WHERE dd.remesa_id=r.remesa_id AND df.remesa_id=dd.remesa_id AND f.factura_id=df.factura_id AND  ra.factura_id=f.factura_id AND ab.abono_factura_id=ra.abono_factura_id AND er.encabezado_registro_id=ab.encabezado_registro_id AND ab.estado_abono_factura!='I') AS valor_relacion_pago,
						m.despacho AS numero_planilla,
						'DU' AS es,
						m.fecha_du AS fecha,
						(SELECT IF(r.estado!='AN',r.valor_costo,0)) AS valor_costo,
						(SELECT GROUP_CONCAT(DISTINCT(CONCAT_WS('','<a href=\"javascript:void(0)\" onClick=\"viewDocument1(',oc.orden_compra_id,')\">',oc.consecutivo,'</a>'))) FROM item_liquida_orden ilo, orden_compra oc WHERE ilo.remesa_id=r.remesa_id AND ilo.orden_compra_id=oc.orden_compra_id AND oc.estado_orden_compra!='I') AS ordenes_compras,
						(SELECT GROUP_CONCAT(oc.fecha_orden_compra) FROM item_liquida_orden ilo, orden_compra oc WHERE ilo.remesa_id=r.remesa_id AND ilo.orden_compra_id=oc.orden_compra_id AND oc.estado_orden_compra!='I') AS fecha_ordenes_compras,
						(SELECT SUM(ilo.valoruni_item_liquida_orden) FROM item_liquida_orden ilo, orden_compra oc WHERE ilo.remesa_id=r.remesa_id AND ilo.orden_compra_id=oc.orden_compra_id AND oc.estado_orden_compra!='I') AS valor_orden_compra
					FROM
						despachos_urbanos m, detalle_despacho dd, remesa r
					WHERE
						r.fecha_remesa BETWEEN '$desde' AND '$hasta' AND
						r.oficina_id IN($oficina_id)  AND dd.despachos_urbanos_id=m.despachos_urbanos_id AND r.remesa_id=dd.remesa_id
						$condicion_cliente
					ORDER BY
						m.despachos_urbanos_id)"; 
		$results = $this -> DbFetchAll($select,$Conex);
		
		//echo $select;

		return $results;
	}
}
?>