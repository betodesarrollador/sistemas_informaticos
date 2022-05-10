<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class posicionModel extends Db{

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

	  $this -> assignValRequest('fecha_registro',date('Y-m-d : h:i:s'));
	 
    $this -> DbInsertTable("wms_posicion",$Campos,$Conex,true,false);	
  }
	
  public function Update($Campos,$Conex, $usuario_actualiza_id){		

    $this -> assignValRequest('fecha_actualiza',date('Y-m-d : h:i:s' ));
    $this -> assignValRequest('usuario_actualiza_id',$usuario_actualiza_id);

    $this -> DbUpdateTable("wms_posicion",$Campos,$Conex,true,false);	
  }
	
  public function Delete($Campos,$Conex){
  
  	$this -> DbDeleteTable("wms_posicion",$Campos,$Conex,true,false);
	
  }				 	
   
   public function selectposicion($Conex){
      
      $posicion_id = $this -> requestDataForQuery('posicion_id','integer');
      $select         = "SELECT p.*,(SELECT u.nombre FROM wms_ubicacion_bodega u WHERE u.ubicacion_bodega_id=p.ubicacion_bodega_id) AS ubicacion_bodega 
	  FROM wms_posicion p WHERE posicion_id = $posicion_id";	 
      $result         = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
   
      return $result;
      
   }

   public function getQueryposicionGrid(){
         
     $Query = "SELECT p.codigo, p.nombre, IF(p.estado='B','BLOQUEADO','DISPONIBLE')AS estado, (SELECT u.nombre FROM wms_ubicacion_bodega u WHERE u.ubicacion_bodega_id=p.ubicacion_bodega_id) AS ubicacion, 

			(SELECT CONCAT_WS( ' ' ,t.primer_nombre,t.primer_apellido) FROM tercero t WHERE t.tercero_id=(SELECT u.tercero_id FROM usuario u WHERE u.usuario_id=p.usuario_id) ) AS usuario_registra,
      
      p.fecha_registro,

			(SELECT CONCAT_WS(' ' ,t.primer_nombre,t.primer_apellido) FROM tercero t WHERE t.tercero_id=(SELECT u.tercero_id FROM usuario u WHERE u.usuario_id=p.usuario_actualiza_id) ) AS usuario_actualiza, 

			 p.usuario_actualiza_id, p.fecha_actualiza FROM wms_posicion p";
   
     return $Query;
   
   }
   

}


?>