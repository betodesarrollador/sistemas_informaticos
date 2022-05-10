<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

	final class SolicServToGuiaPaqueteoModel extends Db{

		private $Permisos;
		private $guia_id;
		private $datalle_guia_id;

		//// GRID ////
		public function getQuerySolicAnulToSolicitudGrid($solicitud_id,$desde,$hasta){

			//	$oficinaId = $_REQUEST['OFICINAID'];
			$Query = "SELECT					 
				s.solicitud_id,
				s.fecha_ss AS fecha_ss,
				(SELECT concat_ws(' ',razon_social,sigla,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido) FROM tercero WHERE tercero_id = (SELECT tercero_id FROM cliente WHERE cliente_id = s.cliente_id)) AS cliente,
				(SELECT numero_identificacion  FROM tercero WHERE tercero_id = (SELECT tercero_id FROM cliente WHERE cliente_id = s.cliente_id)) AS  nit,
				(SELECT COUNT(solicitud_id) FROM remesa r WHERE r.solicitud_id=s.solicitud_id) AS numero_guias
			FROM solicitud_servicio s
			WHERE s.fecha_ss BETWEEN '$desde' AND '$hasta'";
			return $Query;
		}
	}
?>