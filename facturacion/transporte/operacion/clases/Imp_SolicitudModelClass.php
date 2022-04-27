<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class Imp_SolicitudModel extends Db{

  
  public function getOrdenCargue($Conex){
  
        $solicitud_id = $this -> requestDataForQuery('solicitud_id','integer');
		$ip_server = $this -> getIpServerPublic();

	if(is_numeric($solicitud_id)){
	
	    //(SELECT empresa_id FROM oficina WHERE oficina_id=s.oficina_id) = $_SESSION['oficina']['empresa_id'];
	    $oficina_id = $_REQUEST['oficina']['oficina_id'];
		
		//exit($_SESSION['oficina']."+++++++++++++++");
				
        $select = "SELECT (SELECT logo AS logos FROM empresa WHERE empresa_id = (SELECT empresa_id FROM oficina WHERE oficina_id=s.oficina_id)) AS logo,
							(SELECT razon_social FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = (SELECT empresa_id FROM oficina WHERE oficina_id=s.oficina_id))) AS razon_social,
							(SELECT sigla FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = (SELECT empresa_id FROM oficina WHERE oficina_id=s.oficina_id))) AS sigla,
							(SELECT numero_identificacion FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = (SELECT empresa_id FROM oficina WHERE oficina_id=s.oficina_id))) AS  numero_identificacion_emp,
							(SELECT direccion FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = (SELECT empresa_id FROM oficina WHERE oficina_id=s.oficina_id))) AS dir_oficina,
							(SELECT nombre FROM ubicacion WHERE ubicacion_id = (SELECT ubicacion_id FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = (SELECT empresa_id FROM oficina WHERE oficina_id=s.oficina_id)))) AS ciudad, 
							(SELECT ti.nombre FROM tercero t, tipo_identificacion ti WHERE t.tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = (SELECT empresa_id FROM oficina WHERE oficina_id=s.oficina_id)) AND ti.tipo_identificacion_id=t.tipo_identificacion_id) AS  tipo_identificacion_emp,
							 (SELECT direccion FROM oficina WHERE oficina_id=s.oficina_id) AS dir_oficna,
							(SELECT telefono FROM oficina WHERE oficina_id=s.oficina_id)  AS tel_oficina,
		 					(SELECT TRIM(nombre) FROM ubicacion WHERE ubicacion_id=(SELECT ubicacion_id FROM oficina WHERE oficina_id=s.oficina_id)) AS ciudad_ofi,
							(SELECT nombre FROM oficina WHERE oficina_id=s.oficina_id) AS nom_oficina,
							s.solicitud_id,s.fecha_ss,
							(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) as nom FROM tercero t, cliente c WHERE c.cliente_id=s.cliente_id AND t.tercero_id=c.tercero_id)as cliente_nombre,
							d.remitente,d.direccion_remitente,d.telefono_remitente,(SELECT nombre FROM ubicacion WHERE ubicacion_id=d.origen_id)as ciudad_remitente,
							d.destinatario,d.direccion_destinatario,d.telefono_destinatario,(SELECT nombre FROM ubicacion WHERE ubicacion_id=d.origen_id)as ciudad_destinatario,
							s.observaciones,d.valores_complementarios,d.descrip_val_comp
							
		
			
         			FROM solicitud_servicio s, detalle_solicitud_servicio d WHERE s.solicitud_id = $solicitud_id AND d.solicitud_id=s.solicitud_id ";		

	    $result = $this -> DbFetchAll($select,$Conex,true);

	  
	}else{
   	    $result = array();
	  }
	return $result;
  }
   
}


?>