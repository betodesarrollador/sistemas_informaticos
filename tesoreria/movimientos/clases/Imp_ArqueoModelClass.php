<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class Imp_ArqueoModel extends Db{

  
  public function getEncabezado($arqueo_caja_id,$Conex){
  
	
	if(is_numeric($arqueo_caja_id)){
		
       $select = "SELECT (SELECT logo FROM empresa WHERE empresa_id = of.empresa_id) AS logo, (SELECT razon_social FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id)) AS razon_social_emp,
		(SELECT sigla FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id)) AS sigla_emp, 
		(SELECT numero_identificacion FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id)) AS  numero_identificacion_emp,
		(SELECT ti.nombre FROM tercero te, tipo_identificacion ti WHERE te.tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id) AND ti.tipo_identificacion_id=te.tipo_identificacion_id) AS  tipo_identificacion_emp,
		(SELECT direccion FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id)) AS direccion_emp,
		(SELECT nombre FROM ubicacion WHERE ubicacion_id = (SELECT ubicacion_id FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id))) AS ciudad_emp,
		e.*,
		(SELECT CONCAT_WS(' ', t.razon_social, t.primer_nombre,t.primer_apellido) FROM usuario u, tercero t WHERE u.usuario_id=e.usuario_id AND t.tercero_id=u.tercero_id ) AS USUARIO,
		of.nombre AS nom_oficina
        FROM  arqueo_caja  e, oficina of WHERE e.arqueo_caja_id  = $arqueo_caja_id AND of.oficina_id=e.oficina_id ";			
	   $result = $this -> DbFetchAll($select,$Conex);	  
	   
	  
	}else{
   	    $result = array();
	  }
	return $result;
  }

  public function getMonedas($arqueo_caja_id,$Conex){
	
	if(is_numeric($arqueo_caja_id)){
				
        $select = "SELECT i.*,t.*				
         FROM   detalles_arqueo_caja i, tipo_dinero  t WHERE i.arqueo_caja_id = $arqueo_caja_id AND t.tipo_dinero_id=i.tipo_dinero_id AND t.tipo='M'  ";		
	
	    $result = $this -> DbFetchAll($select,$Conex);
	  
	}else{
   	    $result = array();
	  }
	return $result;
  }

  public function getBilletes($arqueo_caja_id,$Conex){
	
	if(is_numeric($arqueo_caja_id)){
				
        $select = "SELECT i.*,t.*				
         FROM   detalles_arqueo_caja i, tipo_dinero  t WHERE i.arqueo_caja_id = $arqueo_caja_id AND t.tipo_dinero_id=i.tipo_dinero_id AND t.tipo='B'  ";		
	
	    $result = $this -> DbFetchAll($select,$Conex);
	  
	}else{
   	    $result = array();
	  }
	return $result;
  }

  public function getEmpresa($oficina_id,$Conex){
	
	if(is_numeric($oficina_id)){
				
        $select = "SELECT empresa_id				
         FROM   oficina  WHERE oficina_id = $oficina_id  ";		
	
	    $result = $this -> DbFetchAll($select,$Conex);
	  
	}else{
   	    $result[0][empresa_id] ='';
	  }
	return  $result[0][empresa_id];
  }

}
?>