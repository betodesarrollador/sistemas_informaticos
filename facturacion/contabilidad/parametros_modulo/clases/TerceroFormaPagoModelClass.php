<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");
final class TerceroFormaPagoModel extends Db{
  private $Permisos;
    
  public function Save($Campos,$Conex){
        $this -> DbInsertTable("forma_pago_tercero",$Campos,$Conex,true,false); 
		
		return $this -> getConsecutiveInsert();
  }
  public function Update($Campos,$Conex){
  
        $this -> DbUpdateTable("forma_pago_tercero",$Campos,$Conex,true,false);  		
		
  }
  public function Delete($Campos,$Conex){	 
  	$this -> DbDeleteTable("forma_pago_tercero",$Campos,$Conex,true,false);  
  }
    
  
  public function getTercerosFormaPago($Conex){
  
	$forma_pago_id  = $this -> requestDataForQuery('forma_pago_id','integer');
	
	if(is_numeric($forma_pago_id)){
	
		$select  = "SELECT (SELECT CONCAT_WS(' ',numero_identificacion,'-',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,razon_social) FROM tercero WHERE tercero_id = c.tercero_id) AS tercero,c.* FROM  forma_pago_tercero c 
		WHERE forma_pago_id  = $forma_pago_id  ";	
	  	$result  = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
	  }
	return $result;
  }
  

   
}

?>