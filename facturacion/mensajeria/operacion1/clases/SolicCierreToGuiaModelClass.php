<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class SolicCierreToGuiaModel extends Db{

	private $Permisos;
	private $guia_id;
	private $datalle_guia_id;

	  public function Save($Campos,$Conex){
	  
	   $this -> Begin($Conex);
	  
		$cierre_crm_id = $this -> requestDataForQuery('cierre_crm_id','integer');
		$guia_id     = $this -> requestDataForQuery('guia_id','integer');
	
		$insert = "INSERT INTO detalle_cierre_crm (detalle_cierre_crm_id,cierre_crm_id,guia_id) VALUES ($detalle_cierre_crm_id,$cierre_crm_id,$guia_id)";	
		$this -> query($insert,$Conex);
		
		$update = "UPDATE guia SET cierre_crm = 1 WHERE guia_id = $guia_id";
		$this -> query($update,$Conex,true);	
		
		$this -> Commit($Conex);
		
		return $guia_id;
	  }


	//// GRID ////
	public function getQuerySolicCierreToGuiaGrid($oficina_id,$desde,$hasta){

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
		WHERE  s.fecha_guia BETWEEN '$desde' AND '$hasta' AND s.facturado = 1 AND crm=1 AND cierre_crm=0 AND s.oficina_id=$oficina_id";
		return $Query; 
	}
}
?>