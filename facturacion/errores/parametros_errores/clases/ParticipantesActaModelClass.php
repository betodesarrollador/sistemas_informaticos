<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");
final class ParticipantesActaModel extends Db{
  private $Permisos;
    
  public function Save($Campos,$Conex){
        $this -> DbInsertTable("participantes_actas",$Campos,$Conex,true,false); 
		
		return $this -> getConsecutiveInsert();
  }
  public function Update($Campos,$Conex){
  
        $this -> DbUpdateTable("participantes_actas",$Campos,$Conex,true,false);  		
		
  }
  public function Delete($Campos,$Conex){	 
  	$this -> DbDeleteTable("participantes_actas",$Campos,$Conex,true,false);  
  }

    
  
  public function getTercerosActa($Conex){
  
	$acta_id  = $this -> requestDataForQuery('acta_id','integer');
	
	if(is_numeric($acta_id)){
	
		$select  = "SELECT * FROM  participantes_actas 
		WHERE acta_id  = $acta_id";	
	  	$result  = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
	  }
	return $result;
  }
  

   
}

?>