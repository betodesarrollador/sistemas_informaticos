<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetalleFormaPagoModel extends Db{

  private $Permisos;
    
  public function Save($Campos,$Conex){	  
		$this -> DbInsertTable("cuenta_tipo_pago",$Campos,$Conex,true,false); 		
		return $this -> getConsecutiveInsert();	  
}

  public function Update($Campos,$Conex){  
        $this -> DbUpdateTable("cuenta_tipo_pago",$Campos,$Conex,true,false);  			
  }

  public function Delete($Campos,$Conex){	 
  	$this -> DbDeleteTable("cuenta_tipo_pago",$Campos,$Conex,true,false);  
  }
    
  public function getBancos($Conex){  
    $select = "SELECT banco_id AS value,nombre_banco AS text FROM banco WHERE estado = 1 ORDER BY nombre_banco ASC";
    $result = $this -> DbFetchAll($select,$Conex);
    return $result;	  
  }
  
  public function getOficinas($Conex){  
    $select = "SELECT oficina_id AS value,nombre AS text FROM oficina ORDER BY oficina_id ASC";
    $result = $this -> DbFetchAll($select,$Conex);
    return $result;	  
  }  

  public function getDetallesFormaPago($Conex){  
	$forma_pago_id = $this -> requestDataForQuery('forma_pago_id','integer');	
	if(is_numeric($forma_pago_id)){	
		
		$select  = "SELECT (SELECT CONCAT(codigo_puc,' - ',nombre) FROM puc WHERE puc_id = c.puc_id) AS puc,c.*,(SELECT o.nombre FROM oficina o WHERE o.oficina_id = c.oficina_id) AS oficina
		FROM cuenta_tipo_pago c WHERE forma_pago_id = $forma_pago_id";	
	  	$result  = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
	  }
	return $result;
  }
   
}

?>