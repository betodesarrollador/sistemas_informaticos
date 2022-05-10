<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

	final class SolicServToGuiaIndModel extends Db{

		private $Permisos;
		private $guia_id;
		private $datalle_guia_id;

		//// GRID ////
		public function getQuerySolicServToGuiaIndGrid($cliente_id,$desde,$hasta,$oficina_id){
			$oficina_id=$oficina_id>0 ? " AND s.oficina_id=".$oficina_id : $oficina_id="";
			//	$oficinaId = $_REQUEST['OFICINAID'];
			$Query = "SELECT 
				CONCAT('<input type=\"checkbox\" value=\"',s.guia_id,'\" onClick=\"chequear(this);\" />') AS link,
				s.numero_guia,s.fecha_guia,
				(SELECT em.nombre_estado FROM estado_mensajeria em WHERE em.estado_mensajeria_id=s.estado_mensajeria_id ) AS estado_mensajeria,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=s.origen_id) AS origen,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=s.destino_id) AS destino,				
				(SELECT concat_ws(' ',razon_social,sigla,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido) FROM tercero WHERE tercero_id = (SELECT tercero_id FROM cliente WHERE cliente_id = s.cliente_id)) AS cliente,
				(SELECT numero_identificacion  FROM tercero WHERE tercero_id = (SELECT tercero_id FROM cliente WHERE cliente_id = s.cliente_id)) AS  nit
			FROM guia s
			WHERE  s.cliente_id=$cliente_id AND s.fecha_guia BETWEEN '$desde' AND '$hasta' AND s.facturado = 0 AND s.estado_mensajeria_id IN (1,4,6,7) $oficina_id";

			return $Query; 
		}
	}
?>