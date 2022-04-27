<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

	final class SolicServToGuiaPaqueteoModel extends Db{

		private $Permisos;
		private $guia_id;
		private $datalle_guia_id;

		//// GRID ////
		public function getQuerySolicServToGuiaPaqueteoGrid($cliente_id,$desde,$hasta){

			//	$oficinaId = $_REQUEST['OFICINAID'];
			$Query = "SELECT
				CONCAT('<input type=\"checkbox\" value=\"',s.solicitud_id,'\" />') AS link,
				s.solicitud_id,
				s.fecha_ss AS fecha,
				(SELECT concat_ws(' ',razon_social,sigla,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido) FROM tercero WHERE tercero_id = (SELECT tercero_id FROM cliente WHERE cliente_id = s.cliente_id)) AS cliente,
				(SELECT numero_identificacion  FROM tercero WHERE tercero_id = (SELECT tercero_id FROM cliente WHERE cliente_id = s.cliente_id)) AS  nit,
				(SELECT COUNT(g.guia_id) FROM guia g WHERE g.solicitud_id=s.solicitud_id AND g.facturado=0) AS guia
			FROM solicitud_servicio_guia s
			WHERE s.fecha_ss BETWEEN '$desde' AND '$hasta' AND s.facturado = 0 AND s.cliente_id=$cliente_id";
			return $Query;
		}
	}
?>