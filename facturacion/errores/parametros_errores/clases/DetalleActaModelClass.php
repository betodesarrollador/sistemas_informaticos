<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");
final class DetalleActaModel extends Db{
  private $Permisos;
    
  public function Save($Campos,$Conex){
/*
     	$temas_tratados_id       = $this -> DbgetMaxConsecutive("temas_tratados","temas_tratados_id",$Conex,true,true);
		$forma_pago_id             = $this -> requestDataForQuery('forma_pago_id','integer');		
		$puc_id                    = $this -> requestDataForQuery('puc_id','integer');
		$banco_id                  = $this -> requestDataForQuery('banco_id','integer');
		$temas_tratados_natu     = $this -> requestDataForQuery('temas_tratados_natu','text');
		
		$insert = "INSERT INTO temas_tratados (temas_tratados_id,forma_pago_id,puc_id,banco_id,temas_tratados_natu) 
		VALUES ($temas_tratados_id,$forma_pago_id,$puc_id,$banco_id,$temas_tratados_natu)";
		
		$result = $this -> query($insert,$Conex);
		
		return $temas_tratados_id;
*/
		$tema_id       = $this -> DbgetMaxConsecutive("temas_tratados","tema_id",$Conex,true,true);
		$this->assignValRequest('tema_id', $tema_id);
        $this -> DbInsertTable("temas_tratados",$Campos,$Conex,true,false); 
		
		return $this -> getConsecutiveInsert();
  }
  public function Update($Campos,$Conex){
  
     /*	$temas_tratados_id           = $this -> requestDataForQuery('temas_tratados_id','integer');
		$puc_id                        = $this -> requestDataForQuery('puc_id','integer');
		$banco_id                      = $this -> requestDataForQuery('banco_id','integer');
		$temas_tratados_natu         = $this -> requestDataForQuery('temas_tratados_natu','text');
		
		$update = "UPDATE temas_tratados SET puc_id = $puc_id,banco_id = $banco_id,temas_tratados_natu = $temas_tratados_natu 
		WHERE temas_tratados_id = $temas_tratados_id";
		
		$result = $this -> query($update,$Conex);*/
        $this -> DbUpdateTable("temas_tratados",$Campos,$Conex,true,false);  		
		
  }
  public function Delete($Campos,$Conex){	 
  	$this -> DbDeleteTable("temas_tratados",$Campos,$Conex,true,false);  
  }
    
  public function getBancos($Conex){
  
    $select = "SELECT banco_id AS value,nombre_banco AS text FROM banco WHERE estado = 1 ORDER BY nombre_banco ASC";
    $result = $this -> DbFetchAll($select,$Conex);
    return $result;	
  
  }
  
  public function getDetallesActa($Conex){
  
	$acta_id = $this -> requestDataForQuery('acta_id','integer');
	
	if(is_numeric($acta_id)){
	
		$select  = "SELECT * FROM  temas_tratados 
		WHERE acta_id = $acta_id";	
	  	$result  = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
	  }
	return $result;
  }
  

   
}

?>