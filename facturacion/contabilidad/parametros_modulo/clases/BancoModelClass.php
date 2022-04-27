<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");
final class BancoModel extends Db{
  private $usuario_id;
  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  		
  public function Save($Campos,$Conex){	

    $codigo_entidad = $_REQUEST['codigo_entidad'];

    $select="SELECT banco_id,nombre_banco FROM banco WHERE codigo_entidad = $codigo_entidad";
    $result = $this -> DbFetchAll($select,$Conex);

    $banco_id = $result[0]['banco_id'];
    $nombre_banco = $result[0]['nombre_banco'];
   
      if($banco_id>0){
        return $nombre_banco;
      }else{
        $this -> DbInsertTable("banco",$Campos,$Conex,true,false);	
      }
  }
	
  public function Update($Campos,$Conex){		
    $this -> DbUpdateTable("banco",$Campos,$Conex,true,false);	
  }
	
  public function Delete($Campos,$Conex){
  
  	$this -> DbDeleteTable("banco",$Campos,$Conex,true,false);
	
  }				 	
   
   public function selectBanco($Conex){
      $banco_id = $this -> requestDataForQuery("banco_id","integer");   
      $select   = "SELECT * FROM banco WHERE banco_id = $banco_id";	 
      $result   = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
   
      return $result;
      
   }
      
   
   public function getQueryBancoGrid(){
	   	   
     $Query = "SELECT nombre_banco,nit_banco,codigo_interno,codigo_entidad,IF(estado = 0,'INACTIVO','ACTIVO') AS estado FROM banco ORDER BY nombre_banco ASC";
   
     return $Query;
	 
   }
   
}

?>