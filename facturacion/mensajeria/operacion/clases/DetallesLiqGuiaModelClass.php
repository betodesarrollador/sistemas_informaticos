<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetallesLiqGuiaModel extends Db{

	private $Permisos;

	public function getDetallesGuias($liquidacion_guias_cliente_id,$Conex){

		$select="SELECT
				s.guia_id,
				s.numero_guia,s.fecha_guia,s.valor_total,
				(SELECT em.nombre_estado FROM estado_mensajeria em WHERE em.estado_mensajeria_id=s.estado_mensajeria_id ) AS estado_mensajeria,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=s.origen_id) AS origen,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=s.destino_id) AS destino
			FROM guia s, detalle_liq_guias_cliente d
			WHERE d.liquidacion_guias_cliente_id=$liquidacion_guias_cliente_id AND s.guia_id=d.guia_id";

		$result = $this -> DbFetchAll($select,$Conex,true);
		if(empty($result)){
			$result = array();
		}
		return $result;
	}


	public function getDetallesGuiasVisual($cliente_id,$desde,$hasta,$Conex){

		$select="SELECT 
				s.guia_id,
				s.numero_guia,s.fecha_guia,s.valor_total,
				(SELECT em.nombre_estado FROM estado_mensajeria em WHERE em.estado_mensajeria_id=s.estado_mensajeria_id ) AS estado_mensajeria,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=s.origen_id) AS origen,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=s.destino_id) AS destino
			FROM guia s
			WHERE  s.cliente_id=$cliente_id AND s.fecha_guia BETWEEN '$desde' AND '$hasta' AND s.facturado = 0 AND (s.estado_mensajeria_id=6 OR s.estado_mensajeria_id=4)";
		$result = $this -> DbFetchAll($select,$Conex,true);

		if(empty($result)){
			$result = array();
		}
		return $result;
	}

	public function getDetallesGuiasVisualGuia($guias_id,$cliente_id,$desde,$hasta,$Conex){

		$select="SELECT 
				s.guia_id,
				s.numero_guia,s.fecha_guia,s.valor_total,
				(SELECT em.nombre_estado FROM estado_mensajeria em WHERE em.estado_mensajeria_id=s.estado_mensajeria_id ) AS estado_mensajeria,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=s.origen_id) AS origen,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=s.destino_id) AS destino
			FROM guia s
			WHERE  s.cliente_id=$cliente_id AND  s.fecha_guia BETWEEN '$desde' AND '$hasta' AND s.facturado = 0 AND s.guia_id IN ($guias_id) AND (s.estado_mensajeria_id=6 OR s.estado_mensajeria_id=4)";
		$result = $this -> DbFetchAll($select,$Conex,true);
		if(empty($result)){
			$result = array();
		}
		return $result;
	}
}
?>