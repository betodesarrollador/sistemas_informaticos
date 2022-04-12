<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class CrearMuelleModel extends Db{

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

    $this -> assignValRequest('fecha_registro',date('Y-m-d H:i:s'));
    $this -> DbInsertTable("wms_muelle",$Campos,$Conex,true,false);	
  }


	
  public function Update($usuario_actualiza,$Campos,$Conex){	
    
    $this -> assignValRequest('fecha_actualiza',date('Y-m-d H:i:s'));
    $this -> assignValRequest('usuario_actualiza_id',$usuario_actualiza);

    $this -> DbUpdateTable("wms_muelle",$Campos,$Conex,true,false);	
  }
	
  public function Delete($Campos,$Conex){
  
  	$this -> DbDeleteTable("wms_muelle",$Campos,$Conex,true,false);
	
  }				 	
   
   public function selectCrearMuelle($Conex){
      
      $muelle_id = $this -> requestDataForQuery('muelle_id','integer');
      $select         = "SELECT t.muelle_id,t.nombre,t.bodega_id,t.codigo,t.estado,t.usuario_id,t.fecha_registro,t.usuario_actualiza_id,t.fecha_actualiza,(SELECT w.nombre FROM wms_bodega w WHERE w.bodega_id=t.bodega_id) AS bodega FROM wms_muelle t WHERE t.muelle_id = $muelle_id";	 
      $result         = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
   
      return $result;
      
   }

   public function getQueryCrearMuelleGrid(){
         
     $Query = "SELECT t.muelle_id,
                t.nombre,
                (SELECT w.nombre FROM wms_bodega w WHERE w.bodega_id=t.bodega_id) AS bodega,
                t.codigo,
                (SELECT CONCAT_WS(' ',te.primer_nombre,te.segundo_nombre,te.primer_apellido,te.segundo_apellido,te.razon_social)AS usuario_id FROM tercero te, usuario u WHERE te.tercero_id = u.tercero_id AND u.usuario_id=t.usuario_id)AS usuario,
                t.fecha_registro,
                IF(t.usuario_actualiza_id!=0,(SELECT CONCAT_WS(' ',te.primer_nombre,te.segundo_nombre,te.primer_apellido,te.segundo_apellido,te.razon_social)AS usuario_actualiza_id FROM tercero te, usuario u WHERE te.tercero_id = u.tercero_id AND u.usuario_id=t.usuario_actualiza_id),'N/A')AS usuario_actualiza_id,
                IF(t.fecha_actualiza!='',t.fecha_actualiza,'N/A')AS fecha_actualiza,
                IF(t.estado = 'A','ACTIVO','INACTIVO') AS estado
                FROM wms_muelle t  
                ORDER BY t.nombre ASC";
   
     return $Query;
   
   }
   

}


?>