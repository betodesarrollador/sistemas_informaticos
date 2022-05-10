<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class reporteFletesGeneradoresModel extends Db{

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

	public function GetSi_Pro($Conex){
		$opciones=array(0=>array('value'=>'1','text'=>'UNO'),1=>array('value'=>'ALL','text'=>'TODOS'));
		return $opciones;
	}  

	public function getReporte4($oficina_id,$desde,$hasta,$condicion_cliente,$Conex){ 

		$select =	"SELECT
						r.numero_remesa,
						r.fecha_remesa,
						(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) AS origen,
						(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino,
						m.placa,
						(SELECT descripcion_config FROM configuracion c, vehiculo v WHERE c.configuracion=v.configuracion AND v.placa_id=m.placa_id) AS configuracion,
						(SELECT tr.tipo_remesa FROM tipo_remesa tr WHERE tr.tipo_remesa_id=r.tipo_remesa_id) AS tipo_remesa,
						r.aprobacion_ministerio2 AS aprobacion,
						(SELECT GROUP_CONCAT(DISTINCT(CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social))) FROM tercero t, cliente c, remesa r, detalle_despacho dd WHERE dd.remesa_id=r.remesa_id AND m.manifiesto_id = dd.manifiesto_id AND c.cliente_id = r.cliente_id AND c.tercero_id = t.tercero_id) AS cliente,
						r.tipo_liquidacion,
						(SELECT GROUP_CONCAT(DISTINCT(f.consecutivo_factura)) FROM factura f, detalle_factura df, detalle_despacho dd WHERE dd.remesa_id = r.remesa_id AND df.remesa_id = dd.remesa_id AND df.factura_id = f.factura_id AND f.estado!='I') AS numfactura,
						(SELECT GROUP_CONCAT(DISTINCT(f.fecha)) FROM factura f, detalle_factura df, detalle_despacho dd WHERE dd.remesa_id = r.remesa_id AND df.remesa_id = dd.remesa_id AND df.factura_id = f.factura_id AND f.estado!='I') AS fecfactura,
						(SELECT SUM(df.valor) FROM factura f, detalle_factura df, detalle_despacho dd WHERE dd.remesa_id = r.remesa_id AND df.remesa_id = dd.remesa_id AND df.factura_id = f.factura_id AND f.estado!='I') AS valfactura,
						'MC'AS es
					FROM
						manifiesto m, detalle_despacho dd, remesa r, liquidacion_despacho ld
					WHERE
						r.fecha_remesa BETWEEN '$desde' AND '$hasta' AND
						ld.manifiesto_id=m.manifiesto_id AND
						r.oficina_id IN($oficina_id) AND
						dd.manifiesto_id=m.manifiesto_id AND
						r.remesa_id=dd.remesa_id
						$condicion_cliente
					ORDER BY
						r.numero_remesa
					";
					// echo "$select";
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
						(SELECT descripcion_config FROM configuracion c, vehiculo v WHERE c.configuracion=v.configuracion AND v.placa_id=m.placa_id) AS configuracion,
						(SELECT tr.tipo_remesa FROM tipo_remesa tr WHERE tr.tipo_remesa_id=r.tipo_remesa_id) AS tipo_remesa,
						r.aprobacion_ministerio2 AS aprobacion,
	    				(SELECT GROUP_CONCAT(DISTINCT(CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social))) FROM tercero t, cliente c, remesa r, detalle_despacho dd WHERE dd.remesa_id=r.remesa_id AND m.despachos_urbanos_id = dd.despachos_urbanos_id AND c.cliente_id = r.cliente_id AND c.tercero_id = t.tercero_id) AS cliente,
						r.tipo_liquidacion,
						(SELECT GROUP_CONCAT(DISTINCT(f.consecutivo_factura)) FROM factura f, detalle_factura df, detalle_despacho dd WHERE dd.remesa_id = r.remesa_id AND df.remesa_id = dd.remesa_id AND df.factura_id = f.factura_id AND f.estado!='I') AS numfactura,
						(SELECT GROUP_CONCAT(DISTINCT(f.fecha)) FROM factura f, detalle_factura df, detalle_despacho dd WHERE dd.remesa_id = r.remesa_id AND df.remesa_id = dd.remesa_id AND df.factura_id = f.factura_id AND f.estado!='I') AS fecfactura,
						(SELECT SUM(df.valor) FROM factura f, detalle_factura df, detalle_despacho dd WHERE dd.remesa_id = r.remesa_id AND df.remesa_id = dd.remesa_id AND df.factura_id = f.factura_id AND f.estado!='I') AS valfactura,
						'DU' AS es
					FROM
						despachos_urbanos m, detalle_despacho dd, remesa r, liquidacion_despacho ld
					WHERE
						r.fecha_remesa BETWEEN '$desde' AND '$hasta' AND
						ld.despachos_urbanos_id=m.despachos_urbanos_id AND
						r.oficina_id IN($oficina_id)  AND
						dd.despachos_urbanos_id=m.despachos_urbanos_id AND
						r.remesa_id=dd.remesa_id
						$condicion_cliente
					ORDER BY
						r.numero_remesa
					";
					// echo "$select";
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
						(SELECT descripcion_config FROM configuracion c, vehiculo v WHERE c.configuracion=v.configuracion AND v.placa_id=m.placa_id) AS configuracion,
						(SELECT tr.tipo_remesa FROM tipo_remesa tr WHERE tr.tipo_remesa_id=r.tipo_remesa_id) AS tipo_remesa,
						r.aprobacion_ministerio2 AS aprobacion,
						(SELECT GROUP_CONCAT(DISTINCT(CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social))) FROM tercero t, cliente c, remesa r, detalle_despacho dd WHERE dd.remesa_id=r.remesa_id AND m.manifiesto_id = dd.manifiesto_id AND c.cliente_id = r.cliente_id AND c.tercero_id = t.tercero_id) AS cliente,
						r.tipo_liquidacion,
						(SELECT GROUP_CONCAT(DISTINCT(f.consecutivo_factura)) FROM factura f, detalle_factura df, detalle_despacho dd WHERE dd.remesa_id = r.remesa_id AND df.remesa_id = dd.remesa_id AND df.factura_id = f.factura_id AND f.estado!='I') AS numfactura,
						(SELECT GROUP_CONCAT(DISTINCT(f.fecha)) FROM factura f, detalle_factura df, detalle_despacho dd WHERE dd.remesa_id = r.remesa_id AND df.remesa_id = dd.remesa_id AND df.factura_id = f.factura_id AND f.estado!='I') AS fecfactura,
						(SELECT SUM(df.valor) FROM factura f, detalle_factura df, detalle_despacho dd WHERE dd.remesa_id = r.remesa_id AND df.remesa_id = dd.remesa_id AND df.factura_id = f.factura_id AND f.estado!='I') AS valfactura,
						'MC'AS es
					FROM
						manifiesto m, detalle_despacho dd, remesa r, liquidacion_despacho ld
					WHERE
						r.fecha_remesa BETWEEN '$desde' AND '$hasta' AND
						ld.manifiesto_id=m.manifiesto_id AND
						r.oficina_id IN($oficina_id) AND
						dd.manifiesto_id=m.manifiesto_id AND
						r.remesa_id=dd.remesa_id
						$condicion_cliente
					ORDER BY
						r.numero_remesa) 
						
					UNION ALL
						
					(SELECT
						r.numero_remesa,
						r.fecha_remesa,
						(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) AS origen,
						(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino,
						m.placa,
						(SELECT descripcion_config FROM configuracion c, vehiculo v WHERE c.configuracion=v.configuracion AND v.placa_id=m.placa_id) AS configuracion,
						(SELECT tr.tipo_remesa FROM tipo_remesa tr WHERE tr.tipo_remesa_id=r.tipo_remesa_id) AS tipo_remesa,
						r.aprobacion_ministerio2 AS aprobacion,
	    				(SELECT GROUP_CONCAT(DISTINCT(CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social))) FROM tercero t, cliente c, remesa r, detalle_despacho dd WHERE dd.remesa_id=r.remesa_id AND m.despachos_urbanos_id = dd.despachos_urbanos_id AND c.cliente_id = r.cliente_id AND c.tercero_id = t.tercero_id) AS cliente,
						r.tipo_liquidacion,
						(SELECT GROUP_CONCAT(DISTINCT(f.consecutivo_factura)) FROM factura f, detalle_factura df, detalle_despacho dd WHERE dd.remesa_id = r.remesa_id AND df.remesa_id = dd.remesa_id AND df.factura_id = f.factura_id AND f.estado!='I') AS numfactura,
						(SELECT GROUP_CONCAT(DISTINCT(f.fecha)) FROM factura f, detalle_factura df, detalle_despacho dd WHERE dd.remesa_id = r.remesa_id AND df.remesa_id = dd.remesa_id AND df.factura_id = f.factura_id AND f.estado!='I') AS fecfactura,
						(SELECT SUM(df.valor) FROM factura f, detalle_factura df, detalle_despacho dd WHERE dd.remesa_id = r.remesa_id AND df.remesa_id = dd.remesa_id AND df.factura_id = f.factura_id AND f.estado!='I') AS valfactura,
						'DU' AS es
					FROM
						despachos_urbanos m, detalle_despacho dd, remesa r, liquidacion_despacho ld
					WHERE
						r.fecha_remesa BETWEEN '$desde' AND '$hasta' AND
						ld.despachos_urbanos_id=m.despachos_urbanos_id AND
						r.oficina_id IN($oficina_id)  AND
						dd.despachos_urbanos_id=m.despachos_urbanos_id AND
						r.remesa_id=dd.remesa_id
						$condicion_cliente
					ORDER BY
						r.numero_remesa)
					ORDER BY
						numero_remesa";
		$results = $this -> DbFetchAll($select,$Conex);

		return $results;
	}
}
?>