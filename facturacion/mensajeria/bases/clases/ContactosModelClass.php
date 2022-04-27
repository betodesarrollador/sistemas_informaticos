<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class ContactosModel extends Db{

  private $Permisos;
  
  public function getContactos($Conex){
  
    $cliente_id = $_REQUEST['cliente_id'];
	
	$select  = "SELECT c.*, e.estado_contacto
				FROM contacto c, estado_contacto e
				WHERE cliente_id = $cliente_id 
				AND c.estado_contacto_id=e.estado_contacto_id";
	
	$result = $this -> DbFetchAll($select,$Conex);
	
	return $result;
  
  }
    
  public function Save($Campos,$Conex){
  
    $cliente_id          = $_REQUEST['cliente_id'];
    $contacto_id         = $_REQUEST['contacto_id'];
    $nombre_contacto     = $_REQUEST['nombre_contacto'];
    $cargo_contacto      = $_REQUEST['cargo_contacto'];
    $dir_contacto        = $_REQUEST['dir_contacto'];
    $tel_contacto        = $_REQUEST['tel_contacto'];
    $cel_contacto        = $_REQUEST['cel_contacto'];
    $email_contacto      = $_REQUEST['email_contacto'];
    $estado_contacto_id  = $_REQUEST['estado_contacto_id'];
	
    $contacto_id = $this -> DbgetMaxConsecutive("contacto","contacto_id",$Conex,true,1);	

    $insert = "INSERT INTO contacto (cliente_id,contacto_id,nombre_contacto,cargo_contacto,dir_contacto,tel_contacto,cel_contacto,email_contacto,estado_contacto_id)
	           VALUES ($cliente_id,$contacto_id,'$nombre_contacto','$cargo_contacto','$dir_contacto','$tel_contacto','$cel_contacto','$email_contacto',$estado_contacto_id)";
	
    $this -> query($insert,$Conex,true);
	
	return $contacto_id;

  }

  public function Update($Campos,$Conex){
  
    $cliente_id          = $_REQUEST['cliente_id'];
    $contacto_id         = $_REQUEST['contacto_id'];
    $nombre_contacto     = $_REQUEST['nombre_contacto'];
    $cargo_contacto      = $_REQUEST['cargo_contacto'];
    $dir_contacto        = $_REQUEST['dir_contacto'];
    $tel_contacto        = $_REQUEST['tel_contacto'];
    $cel_contacto        = $_REQUEST['cel_contacto'];
    $email_contacto      = $_REQUEST['email_contacto'];
    $estado_contacto_id  = $_REQUEST['estado_contacto_id'];
	
    $update = "UPDATE contacto 
				SET cliente_id = $cliente_id, nombre_contacto = '$nombre_contacto', cargo_contacto = '$cargo_contacto', 
					dir_contacto = '$dir_contacto', tel_contacto = '$tel_contacto', cel_contacto = '$cel_contacto',
					email_contacto = '$email_contacto', estado_contacto_id = $estado_contacto_id 
				WHERE contacto_id = $contacto_id";
	
    $this -> query($update,$Conex);

  }

  public function Delete($Campos,$Conex){

    $contacto_id = $_REQUEST['contacto_id'];
	
    $delete = "DELETE FROM contacto WHERE contacto_id = $contacto_id";
	
    $this -> query($delete,$Conex);	

  }
  
  public function getEstadosContacto($Conex){
  
    $select = "SELECT estado_contacto_id AS value,estado_contacto AS text  FROM estado_contacto ORDER BY estado_contacto";
	$result = $this -> DbFetchAll($select,$Conex);
	
	return $result;	
  
  }
    
}

?>