<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class LiquidarRemesasModel extends Db{

  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }

  public function selectDataManifiestoDespacho($tipo,$manifiesto_despacho_id,$Conex){
  
     if($tipo == 'MANIFIESTO'){
	 
	  $select = "SELECT fecha_mc AS fecha,placa,(SELECT nombre FROM ubicacion WHERE ubicacion_id = m.origen_id) AS origen,(SELECT nombre FROM ubicacion WHERE 
	             ubicacion_id = m.destino_id) AS destino FROM manifiesto m WHERE manifiesto_id = $manifiesto_despacho_id";
				 
      $result = $this -> DbFetchAll($select,$Conex,true);				 	 
	  
	 }else{
	 
	    $select = "SELECT fecha_du AS fecha,placa,(SELECT nombre FROM ubicacion WHERE ubicacion_id = m.origen_id) AS origen,(SELECT nombre FROM ubicacion WHERE 
	             ubicacion_id = m.destino_id) AS destino FROM despachos_urbanos m WHERE despachos_urbanos_id = $manifiesto_despacho_id";
				 
        $result = $this -> DbFetchAll($select,$Conex,true);				 	 	 
	 
	   }
	   
    return $result;	   
  
  }  

}


?>