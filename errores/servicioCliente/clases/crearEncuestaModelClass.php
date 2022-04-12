<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class crearEncuestaModel extends Db{
  
  private $usuario_id;
  private $Permisos;
  public function SetUsuarioId($usuario_id,$oficina_id){	  
    $this -> Permisos = new PermisosForm();
    $this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
    
  }
  
  public function getPermiso($crearEncuestaId,$Permiso,$Conex){
    echo('El permiso es el siguiente:'.$Permiso.'Crear encuesta id'.$crearEncuestaId.'<br>');
    return $this -> Permisos -> getPermiso($crearEncuestaId,$Permiso,$Conex);
  }
  



}


?>