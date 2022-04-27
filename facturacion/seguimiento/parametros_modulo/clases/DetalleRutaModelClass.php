<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetalleRutaModel extends Db{

  private $Permisos;
  
  public function getDetallesRuta($Conex){
  
    $ruta_id = $this -> requestData('ruta_id');
	
	if(is_numeric($ruta_id)){
	
	  $select  = "SELECT d.*,
	  IF(d.punto_referencia_id>0,(SELECT nombre FROM punto_referencia WHERE punto_referencia_id=d.punto_referencia_id ),(SELECT 
	  nombre FROM ubicacion WHERE ubicacion_id = d.ubicacion_id)) AS ubicacion,
	  
	  
	  IF(d.punto_referencia_id>0,(SELECT nombre FROM tipo_punto_referencia WHERE tipo_punto_referencia_id = (SELECT 
	  tipo_punto_referencia_id FROM punto_referencia WHERE punto_referencia_id = d.punto_referencia_id)), 
	  (SELECT nombre FROM tipo_ubicacion WHERE tipo_ubicacion_id = (SELECT tipo_ubicacion_id FROM ubicacion WHERE ubicacion_id 
	  = d.ubicacion_id))) AS refe,
	   
	  IF(d.ubicacion_id = (SELECT destino_id FROM ruta WHERE ruta_id = $ruta_id),'SI','NO') AS destino
	  FROM detalle_ruta d WHERE ruta_id = $ruta_id ORDER BY d.orden_det_ruta";
	
	  $result = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
	  }
	
	return $result;
  
  }
    
  public function Save($Campos,$Conex){
  
    $ruta_id            = $this -> requestDataForQuery('ruta_id','integer'); 
    $detalle_ruta_id    = $this -> requestDataForQuery('detalle_ruta_id','integer');
    $orden_det_ruta     = $this -> requestDataForQuery('orden_det_ruta','integer');
    $ubicacion_id       = $this -> requestDataForQuery('ubicacion_id','integer');
//    $distancia_det_ruta = $this -> requestDataForQuery('distancia_det_ruta','numeric'); 
//    $tiempo_det_ruta    = $this -> requestDataForQuery('tiempo_det_ruta','integer'); 
	$punto_referencia_id= $this -> requestDataForQuery('punto_referencia_id','integer');
	
    $detalle_ruta_id = $this -> DbgetMaxConsecutive("detalle_ruta","detalle_ruta_id",$Conex);	
	$detalle_ruta_id = ($detalle_ruta_id + 1);

    $insert = "INSERT INTO detalle_ruta (detalle_ruta_id,ruta_id,ubicacion_id,punto_referencia_id,/*tiempo_det_ruta,distancia_det_ruta,*/orden_det_ruta) 
	           VALUES ($detalle_ruta_id,$ruta_id,$ubicacion_id,$punto_referencia_id,/*$tiempo_det_ruta,$distancia_det_ruta,*/$orden_det_ruta)";
	
    $this -> query($insert,$Conex,true);
	
	return $detalle_ruta_id;

  }

  public function Update($Campos,$Conex){

    $ruta_id            = $this -> requestDataForQuery('ruta_id','integer'); 
    $detalle_ruta_id    = $this -> requestDataForQuery('detalle_ruta_id','integer');
    $orden_det_ruta     = $this -> requestDataForQuery('orden_det_ruta','integer');
    $ubicacion_id       = $this -> requestDataForQuery('ubicacion_id','integer');
//    $distancia_det_ruta = $this -> requestDataForQuery('distancia_det_ruta','numeric'); 
//    $tiempo_det_ruta    = $this -> requestDataForQuery('tiempo_det_ruta','integer'); 
	$punto_referencia_id= $this -> requestDataForQuery('punto_referencia_id','integer');

	
    $insert = "UPDATE detalle_ruta SET ruta_id = $ruta_id,ubicacion_id = $ubicacion_id,punto_referencia_id = $punto_referencia_id,/*tiempo_det_ruta = $tiempo_det_ruta,
	distancia_det_ruta = $distancia_det_ruta,*/orden_det_ruta = $orden_det_ruta WHERE detalle_ruta_id = $detalle_ruta_id";
	
    $this -> query($insert,$Conex,true);

  }

  public function Delete($Campos,$Conex){

     $detalle_ruta_id    = $this -> requestDataForQuery('detalle_ruta_id','integer');
	
    $delete = "DELETE FROM detalle_ruta WHERE detalle_ruta_id = $detalle_ruta_id";
	
    $this -> query($delete,$Conex,true);	

  }
 


   
}



?>