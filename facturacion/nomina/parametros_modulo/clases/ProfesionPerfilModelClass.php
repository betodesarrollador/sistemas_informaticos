<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class ProfesionPerfilModel extends Db{

  private $Permisos;
    
  public function Save($Campos,$Conex){
  
        $this -> DbInsertTable("profesion_perfil",$Campos,$Conex,true,false); 
		
		return $this -> getConsecutiveInsert();

  }

  public function Update($Campos,$Conex){
  
        $this -> DbUpdateTable("profesion_perfil",$Campos,$Conex,true,false);  		
		
  }

  public function Delete($Campos,$Conex){	 
  	$this -> DbDeleteTable("profesion_perfil",$Campos,$Conex,true,false);  
  }
    
  public function getProfesiones($Conex){
  
    // $select = "SELECT oficina_id AS value,CONCAT(codigo_centro,' - ',nombre) AS text FROM oficina ORDER BY codigo_centro ASC";
    $select = "SELECT profesion_id AS value,nombre AS text FROM profesion ORDER BY nombre ASC";
    $result = $this -> DbFetchAll($select,$Conex);

    return $result;	
  
  }

  
  public function getProfesionPerfil($Conex){
  
	// $perfil_id = $this -> requestDataForQuery('perfil_id','integer');

  if ($_REQUEST['perfil_id'] == "-1")
  {
    $perfil_id = $this -> DbgetMaxConsecutive("perfil","perfil_id",$Conex,true);
    $_REQUEST['perfil_id'] = $perfil_id;
    echo '<script languaje="JavaScript">var varjs="'.$perfil_id.'"</script>';
  }
  
  $perfil_id = $_REQUEST['perfil_id'];  
	
	if(is_numeric($perfil_id)){
	
		// $select  = "SELECT consecutivo_documento_oficina_id,tipo_documento_id,oficina_id,consecutivo FROM  consecutivo_documento_oficina d 
		// WHERE tipo_documento_id = $tipo_documento_id";	
    $select = "SELECT * FROM profesion_perfil WHERE perfil_id = $perfil_id";
	  	$result  = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
	  }
	return $result;
  }
  


   
}



?>