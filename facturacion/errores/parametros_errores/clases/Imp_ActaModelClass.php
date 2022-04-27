<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");
final class Imp_ActaModel extends Db{
  
  public function getEncabezado($acta_id,$Conex){
  
	
	if(is_numeric($acta_id)){
	
				
        $select = "SELECT a.*,(SELECT logo FROM empresa WHERE empresa_id=1)AS logo,(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido)as empresa FROM empresa e, tercero t WHERE e.tercero_id=t.tercero_id AND empresa_id=1)AS empresa,(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido)as cliente FROM cliente e, tercero t WHERE e.tercero_id=t.tercero_id AND e.cliente_id=a.cliente_id)AS cliente,(SELECT CONCAT(u.nombre,' - ',(SELECT ubi.nombre FROM ubicacion ubi WHERE u.ubi_ubicacion_id=ubi.ubicacion_id))nombre FROM ubicacion u WHERE u.ubicacion_id=a.ubicacion_id)AS ubicacion
        FROM actas a WHERE a.acta_id = $acta_id";
	    $result = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
	  }
	return $result;
  }

  public function getimputaciones($acta_id,$Conex){
  
	
	if(is_numeric($acta_id)){
				
        $select = "SELECT *				
         FROM  temas_tratados WHERE acta_id = $acta_id ";		
	
	    $result = $this -> DbFetchAll($select,$Conex);
	  
	}else{
   	    $result = array();
	  }
	return $result;
  }

  public function getTotal($acta_id,$Conex){
  
    $acta_id = $this -> requestDataForQuery('acta_id','integer');
	
	if(is_numeric($acta_id)){
				
        $select = "SELECT *		
         FROM acuerdos_compromisos WHERE acta_id = $acta_id ";		
	
	    $result = $this -> DbFetchAll($select,$Conex);
	  
	}else{
   	    $result = array();
	  }
	return $result;
  }
  public function getTotales($acta_id,$Conex){
  
    $acta_id = $this -> requestDataForQuery('acta_id','integer');
	
	if(is_numeric($acta_id)){
				
        $select = "SELECT *,IF(tipo_participante='C','CLIENTE','PROVEEDOR')AS tipo_participante		
         FROM participantes_actas WHERE acta_id = $acta_id";	
	
	    $result = $this -> DbFetchAll($select,$Conex);
	  
	}else{
   	    $result = array();
	  }
	return $result;
  }
}

?>