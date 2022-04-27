<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class RndcModel extends Db{

  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  public function Update($Campos,$Conex){
    $this -> DbUpdateTable("rndc",$Campos,$Conex,true,false);

  }

  
	 	
  public function getActivo($Conex){
    $select = "SELECT *	FROM rndc";
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);

	$activo[0]=array(array(value=>'S',text=>'SI',selected=>$result[0]['activo_envio']),array(value=>'N',text=>'NO',selected=>$result[0]['activo_envio']));	
	$activo[1]=array(array(value=>'S',text=>'SI',selected=>$result[0]['activo_impresion']),array(value=>'N',text=>'NO',selected=>$result[0]['activo_impresion']));	
	$activo[2]=$result[0]['rndc_id'];
	return $activo;
  }
   
}

?>