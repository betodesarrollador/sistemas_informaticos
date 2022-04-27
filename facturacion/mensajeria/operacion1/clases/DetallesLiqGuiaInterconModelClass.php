<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetallesLiqGuiaInterconModel extends Db{

	private $Permisos;

	public function getDetallesGuias($liquidacion_guias_interconexion_id,$Conex){

		$select="SELECT
				s.guia_interconexion_id,
				s.numero_guia,s.fecha_guia,s.valor_total,
				(SELECT em.nombre_estado FROM estado_mensajeria em WHERE em.estado_mensajeria_id=s.estado_mensajeria_id ) AS estado_mensajeria,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=s.origen_id) AS origen,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=s.destino_id) AS destino
			FROM guia_interconexion s, detalle_liq_guias_interconexion d
			WHERE d.liquidacion_guias_interconexion_id=$liquidacion_guias_interconexion_id AND s.guia_interconexion_id=d.guia_interconexion_id";

		$result = $this -> DbFetchAll($select,$Conex,true);
		if(empty($result)){
			$result = array();
		}
		return $result;
	}


	public function getDetallesGuiasVisual($cliente_id,$desde,$hasta,$Conex){

		$select="SELECT 
				s.guia_interconexion_id,
				s.numero_guia,s.fecha_guia,s.valor_total,
				(SELECT em.nombre_estado FROM estado_mensajeria em WHERE em.estado_mensajeria_id=s.estado_mensajeria_id ) AS estado_mensajeria,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=s.origen_id) AS origen,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=s.destino_id) AS destino
			FROM guia_interconexion s
			WHERE  s.cliente_id=$cliente_id AND s.fecha_guia BETWEEN '$desde' AND '$hasta' AND s.facturado = 0 AND (s.estado_mensajeria_id=6 OR s.estado_mensajeria_id=4 OR s.estado_mensajeria_id=1)";
		$result = $this -> DbFetchAll($select,$Conex,true);

		if(empty($result)){
			$result = array();
		}
		return $result;
	}

	public function getDetallesGuiasVisualGuia($guias_interconexion_id,$cliente_id,$desde,$hasta,$Conex){

		$select="SELECT 
				s.guia_interconexion_id,
				s.numero_guia,s.fecha_guia,s.valor_total,
				(SELECT em.nombre_estado FROM estado_mensajeria em WHERE em.estado_mensajeria_id=s.estado_mensajeria_id ) AS estado_mensajeria,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=s.origen_id) AS origen,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=s.destino_id) AS destino
			FROM guia_interconexion s
			WHERE  s.cliente_id=$cliente_id AND  s.fecha_guia BETWEEN '$desde' AND '$hasta' AND s.facturado = 0 AND s.guia_interconexion_id IN ($guias_interconexion_id) AND (s.estado_mensajeria_id=6 OR s.estado_mensajeria_id=4 OR s.estado_mensajeria_id=1)";
		$result = $this -> DbFetchAll($select,$Conex,true);
		if(empty($result)){
			$result = array();
		}
		return $result;
	}
}
?>