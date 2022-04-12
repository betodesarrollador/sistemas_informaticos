<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class Imp_RemesaModel extends Db{
  
  public function getRemesas($oficina_id,$Conex){
  
	$rango_desde = $_REQUEST['rango_desde'];
        $rango_hasta = $_REQUEST['rango_hasta'];
        $remesas     = array();
				
	$select = "SELECT r.fecha_remesa,r.valor_flete,r.valor_seguro,r.valor_otros,r.valor_total,(SELECT logo FROM empresa WHERE empresa_id = (SELECT empresa_id FROM oficina WHERE oficina_id = r.oficina_id)) AS logo,(SELECT pagina_web FROM empresa WHERE empresa_id = (SELECT empresa_id FROM oficina WHERE oficina_id = r.oficina_id)) AS pagina_web,(SELECT concat_ws(' ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,razon_social) FROM tercero WHERE tercero_id = 
	(SELECT tercero_id FROM empresa WHERE empresa_id = (SELECT empresa_id FROM oficina WHERE oficina_id = r.oficina_id))) AS empresa,(SELECT concat_ws('- ',numero_identificacion,digito_verificacion) FROM tercero WHERE tercero_id = 
	(SELECT tercero_id FROM empresa WHERE empresa_id = (SELECT empresa_id FROM oficina WHERE oficina_id = r.oficina_id))) AS numero_identificacion,(SELECT nombre FROM oficina WHERE 	oficina_id = r.oficina_id) AS oficina,(SELECT direccion FROM oficina WHERE oficina_id = r.oficina_id) AS direccion,(SELECT nombre FROM ubicacion WHERE ubicacion_id = (SELECT ubicacion_id FROM oficina WHERE oficina_id = r.oficina_id)) AS ciudad,(SELECT habilitacion FROM resolucion_habilitacion WHERE empresa_id = (SELECT empresa_id FROM oficina WHERE oficina_id = r.oficina_id)) AS resolucion_habilitacion,
	(SELECT fecha_habilitacion FROM resolucion_habilitacion WHERE empresa_id = (SELECT empresa_id FROM oficina WHERE oficina_id = r.oficina_id)) AS fecha_habilitacion,	
	(SELECT numero_resolucion FROM resolucion_habilitacion WHERE empresa_id = (SELECT empresa_id FROM oficina WHERE oficina_id = r.oficina_id)) AS resolucion_ministerio,
	(SELECT fecha_resolucion FROM resolucion_habilitacion WHERE empresa_id = (SELECT empresa_id FROM oficina WHERE oficina_id = r.oficina_id)) AS fecha_resolucion,	
		(SELECT rango_manif_ini FROM resolucion_habilitacion WHERE empresa_id = (SELECT empresa_id FROM oficina WHERE oficina_id = r.oficina_id)) AS rango_manif_ini,	
		(SELECT rango_manif_fin FROM resolucion_habilitacion WHERE empresa_id = (SELECT empresa_id FROM oficina WHERE oficina_id = r.oficina_id)) AS rango_manif_fin,
		(SELECT nombre FROM ubicacion WHERE ubicacion_id = r.origen_id) AS origen,(SELECT nombre FROM ubicacion WHERE ubicacion_id = r.destino_id) AS destino,(SELECT codigo FROM producto WHERE producto_id = r.producto_id) AS codigo,(SELECT naturaleza FROM naturaleza WHERE naturaleza_id = r.naturaleza_id) AS naturaleza,		
		(SELECT empaque FROM empaque WHERE empaque_id = r.empaque_id) AS empaque,(SELECT medida FROM medida WHERE medida_id = r.medida_id) AS medida,r.*,LPAD(r.numero_remesa,8,'0')  AS numero_remesa_bar,(SELECT CONCAT(' RESPONSABLE : ',nombre) FROM oficina WHERE oficina_id = r.oficina_id) AS oficina_responsable,r.estado FROM remesa r  WHERE r.oficina_id = $oficina_id AND r.remesa_id BETWEEN $rango_desde AND $rango_hasta ORDER BY r.remesa_id ASC";	
	
	$result  = $this -> DbFetchAll($select,$Conex);	
	$remesas = $result;
	
	
	for($i = 0; $i < count($remesas); $i++){
	
	  $remesa_id = $remesas[$i]['remesa_id'];
	  $estado    = $remesas[$i]['estado'];

	  $select                         = "SELECT * FROM detalle_remesa WHERE remesa_id = $remesa_id";
	  $result                         = $this -> DbFetchAll($select,$Conex);	
	  $remesas[$i]['detalles_remesa'] = $result;		  
	  
	  if($estado == 'M'){
	  
	     $select = "SELECT * FROM detalle_despacho WHERE remesa_id = $remesa_id";
	     $result = $this -> DbFetchAll($select,$Conex);			 
		 
		 if(count($result) > 0){
		 
		    $manifiesto_id      = $result[0]['manifiesto_id'];
		    $despachos_urbanos_id_id = $result[0]['despachos_urbanos_id_id'];			
			
			if(is_numeric($manifiesto_id)){
			
			  $select = "SELECT placa,manifiesto FROM manifiesto WHERE manifiesto_id = $manifiesto_id";
	          $result = $this -> DbFetchAll($select,$Conex);
			  
			  $remesas[$i]['manifiesto'] = $result[0]['manifiesto'];
			  $remesas[$i]['placa']      = $result[0]['placa'];		  					  
			
			}/*else if(is_numeric($despachos_urbanos_id_id)){
			
			    $select = "SELECT placa,manifiesto FROM manifiesto WHERE manifiesto_id = $manifiesto_id";
	            $result = $this -> DbFetchAll($select,$Conex);
			  
			    $remesas[$i]['manifiesto'] = $result[0]['manifiesto'];
			    $remesas[$i]['placa']      = $result[0]['placa'];				
			
			  }*/
		 
		 }
	  
	  }
	  
	}
			
	return $remesas;
	
  }
  
  public function getOficinas($empresa_id,$Conex){
  
     $select = "SELECT * FROM oficina WHERE empresa_id = $empresa_id"; 
     $result = $this -> DbFetchAll($select,$Conex);

     return $result;
  
  }
    
   
}


?>