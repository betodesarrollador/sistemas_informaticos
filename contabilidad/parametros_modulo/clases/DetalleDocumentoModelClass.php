<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");
final class DetalleDocumentoModel extends Db{
  private $Permisos;
    
  public function Save($Campos,$Conex){
  
        $this -> DbInsertTable("consecutivo_documento_oficina",$Campos,$Conex,true,false); 
		
		return $this -> getConsecutiveInsert();
  }
  public function Update($Campos,$Conex){
  
        $this -> DbUpdateTable("consecutivo_documento_oficina",$Campos,$Conex,true,false);  		
		
  }
  public function Delete($Campos,$Conex){	 
  	$this -> DbDeleteTable("consecutivo_documento_oficina",$Campos,$Conex,true,false);  
  }
    
  public function getOficinas($Conex){
  
    $select = "SELECT oficina_id AS value,CONCAT(codigo_centro,' - ',nombre) AS text FROM oficina ORDER BY codigo_centro ASC";
    $result = $this -> DbFetchAll($select,$Conex);
    return $result;	
  
  }
  
  public function getDetallesDocumento($Conex){
  
	$tipo_documento_id = $this -> requestDataForQuery('tipo_documento_id','integer');
	
	if(is_numeric($tipo_documento_id)){
	
		$select  = "SELECT consecutivo_documento_oficina_id,tipo_documento_id,oficina_id,consecutivo FROM  consecutivo_documento_oficina d 
		WHERE tipo_documento_id = $tipo_documento_id";	
	  	$result  = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
	  }
	return $result;
  }
  

   
}

?>