<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");
final class DetalleFormaPagoModel extends Db{
  private $Permisos;
    
  public function Save($Campos,$Conex){
/*
     	$cuenta_tipo_pago_id       = $this -> DbgetMaxConsecutive("cuenta_tipo_pago","cuenta_tipo_pago_id",$Conex,true,true);
		$forma_pago_id             = $this -> requestDataForQuery('forma_pago_id','integer');		
		$puc_id                    = $this -> requestDataForQuery('puc_id','integer');
		$banco_id                  = $this -> requestDataForQuery('banco_id','integer');
		$cuenta_tipo_pago_natu     = $this -> requestDataForQuery('cuenta_tipo_pago_natu','text');
		
		$insert = "INSERT INTO cuenta_tipo_pago (cuenta_tipo_pago_id,forma_pago_id,puc_id,banco_id,cuenta_tipo_pago_natu) 
		VALUES ($cuenta_tipo_pago_id,$forma_pago_id,$puc_id,$banco_id,$cuenta_tipo_pago_natu)";
		
		$result = $this -> query($insert,$Conex);
		
		return $cuenta_tipo_pago_id;
*/
        $this -> DbInsertTable("cuenta_tipo_pago",$Campos,$Conex,true,false); 
		
		return $this -> getConsecutiveInsert();
  }
  public function Update($Campos,$Conex){
  
     /*	$cuenta_tipo_pago_id           = $this -> requestDataForQuery('cuenta_tipo_pago_id','integer');
		$puc_id                        = $this -> requestDataForQuery('puc_id','integer');
		$banco_id                      = $this -> requestDataForQuery('banco_id','integer');
		$cuenta_tipo_pago_natu         = $this -> requestDataForQuery('cuenta_tipo_pago_natu','text');
		
		$update = "UPDATE cuenta_tipo_pago SET puc_id = $puc_id,banco_id = $banco_id,cuenta_tipo_pago_natu = $cuenta_tipo_pago_natu 
		WHERE cuenta_tipo_pago_id = $cuenta_tipo_pago_id";
		
		$result = $this -> query($update,$Conex);*/
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
  
  public function getDetallesFormaPago($Conex){
  
	$forma_pago_id = $this -> requestDataForQuery('forma_pago_id','integer');
	
	if(is_numeric($forma_pago_id)){
	
		$select  = "SELECT (SELECT CONCAT(codigo_puc,' - ',nombre) FROM puc WHERE puc_id = c.puc_id) AS puc,c.* FROM  cuenta_tipo_pago c 
		WHERE forma_pago_id = $forma_pago_id";	
	  	$result  = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
	  }
	return $result;
  }
  

   
}

?>