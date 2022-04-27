<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class ProtocolosModel extends Db{

  private $usuario_id;
  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
	
  public function Update($Conex,$ruta_video,$ruta_archivo){		
                                         
   $protocolo_id = $_REQUEST['protocolo_id'];
   $descripcion  = $_REQUEST['descripcion'];
   $nombre       = $_REQUEST['nombre'];

   $update_ruta  = $ruta_video == "" ? ""    : ", video = '$ruta_video'";
   $ruta_archivo = $ruta_archivo == "" ? ""  : ", archivo = '$ruta_archivo'";
   
   $update = "UPDATE protocolos SET descripcion = '$descripcion', nombre = '$nombre' $update_ruta $ruta_archivo WHERE protocolo_id = $protocolo_id";

   $this -> query($update,$Conex,true);
    
  }

  public function Save($Conex,$ruta_video,$ruta_archivo){

    $descripcion  = $_REQUEST['descripcion'];
    $nombre       = $_REQUEST['nombre'];

    $protocolo_id = $this -> DbgetMaxConsecutive("protocolos","protocolo_id",$Conex,true,1);
    
    $insert = "INSERT INTO protocolos(protocolo_id, descripcion,nombre,archivo, video) 
               VALUES ($protocolo_id,'$descripcion','$nombre','$ruta_archivo','$ruta_video')";
 
    $this -> query($insert,$Conex,true);

    return $protocolo_id;
    
  }
		 	
   
   public function selectProtocolos($Conex){
      
      $select         = "SELECT * FROM protocolos";	 
      
      $result         = $this -> DbFetchAll($select,$Conex,true);
   
      return $result;
      
   }
   

}


?>