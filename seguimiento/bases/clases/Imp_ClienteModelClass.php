<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class Imp_ClienteModel extends Db{

  
  public function getCliente($cliente_id,$Conex){
	
	if(is_numeric($cliente_id)){
	
	    $empresa_id = $_SESSION['oficina']['empresa_id'];
	    $oficina_id = $_REQUEST['oficina']['oficina_id'];
				
       $select = "SELECT t.*,c.*,
	   				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.ubicacion_id) AS ciudad,
					(SELECT nombre_tipo_cuenta FROM tipo_cuenta WHERE tipo_cta_id=c.tipo_cta_id) AS cuenta,
					(SELECT nombre_banco FROM banco WHERE banco_id=c.banco_id) AS banco,
					(SELECT nombre FROM regimen WHERE regimen_id=t.regimen_id) AS regimen,
					(SELECT nombre FROM ubicacion WHERE ubicacion_id=c.rep_ubicacion_id) AS ciudad_rep,
					(SELECT nombre FROM  tipo_identificacion WHERE tipo_identificacion_id=t.tipo_identificacion_id) AS tipo_identificacion,
					(SELECT nombre FROM  tipo_persona  WHERE tipo_persona_id=t.tipo_persona_id) AS tipo_per,
					CASE c.autoret_cliente_factura WHEN 'N' THEN 'NO' ELSE 'SI' END AS autoretenedor,
					CASE c.retei_cliente_factura WHEN 'N' THEN 'NO' ELSE 'SI' END AS reteica
	               FROM tercero t, cliente c  WHERE c.cliente_id = $cliente_id AND t.tercero_id=c.tercero_id";		

	    $result = $this -> DbFetchAll($select,$Conex);

	  
	}else{
   	    $result = array();
	  }
	return $result;
  }
  
  public function getLegal($cliente_id,$Conex){

    $select  = "SELECT c.*, (SELECT nombre FROM ubicacion WHERE ubicacion_id=c.ubicacion_id) AS origen_socio
    FROM cliente_factura_socio c WHERE c.cliente_id = $cliente_id";

    $result = $this -> DbFetchAll($select,$Conex);  

    return $result;  
  
  }
  
  
  public function getOperativa($cliente_id,$Conex){
  
	$select  = "SELECT c.*, (SELECT nombre FROM ubicacion WHERE ubicacion_id=c.ubicacion_id) AS origen_operativa
	FROM cliente_factura_operativa c WHERE c.cliente_id = $cliente_id";

	$result = $this -> DbFetchAll($select,$Conex);  
    return $result;    
  
  }  
  
   
}


?>