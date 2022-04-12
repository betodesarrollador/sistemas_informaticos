<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetallePuntosModel extends Db{

  private $Permisos;
  
  public function getDetallesPuntos($Conex){
  
    $trafico_id = $_REQUEST['trafico_id'];
	$ruta_id 	= $_REQUEST['ruta_id'];
	$ordenar 	= $_REQUEST['ordenar'];
	
	if(is_numeric($trafico_id) && is_numeric($ruta_id)){
	
	  $select  = "SELECT d.*,(SELECT nombre FROM ubicacion WHERE ubicacion_id = d.ubicacion_id) AS ubicacion, @curRow  := @curRow  
	  + 1  AS orden,
      IF(d.punto_referencia_id>0,(SELECT tr.nombre FROM punto_referencia pr, tipo_punto_referencia  tr WHERE 
	  pr.punto_referencia_id=d.punto_referencia_id AND pr.tipo_punto_referencia_id=tr.tipo_punto_referencia_id),'CIUDAD') 
	  AS punto_referencia

	  FROM detalle_ruta d JOIN (SELECT @curRow := 0) r
	  WHERE d.ruta_id = $ruta_id  
	  ORDER BY d.orden_det_ruta $ordenar  ";
	  
	  $result = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
	  }
	
	return $result;
  
  }

  public function getultimoPuntos($Conex){
  
    $trafico_id = $_REQUEST['trafico_id'];
	
	if(is_numeric($trafico_id)){
	
		$select="SELECT MAX(orden_det_ruta) as orden FROM detalle_seguimiento WHERE trafico_id=$trafico_id AND borrado=0";
		$result= $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
	  }
	
	return $result;
  
  }


  public function Save($Campos,$Conex){

    $trafico_id      	 = $this -> requestDataForQuery('trafico_id','integer');
    $detalle_ruta_id     = $this -> requestDataForQuery('detalle_ruta_id','integer');
	$orden_det_ruta		 = $this -> requestDataForQuery('orden_det_ruta','integer');
	$ubicacion_id        = $this -> requestDataForQuery('ubicacion_id','integer');
	$punto_referencia 	 = $this -> requestDataForQuery('punto_referencia','text');
	$punto_referencia_id = $this -> requestDataForQuery('punto_referencia_id','integer');
	
    $detalle_seg_id = $this -> DbgetMaxConsecutive("detalle_seguimiento","detalle_seg_id",$Conex,true,1);	


    $insert = "INSERT INTO detalle_seguimiento 
					(detalle_seg_id,trafico_id,detalle_ruta_id,ubicacion_id,punto_referencia,punto_referencia_id,orden_det_ruta) 
	           VALUES 
			   		($detalle_seg_id,$trafico_id,$detalle_ruta_id,$ubicacion_id,$punto_referencia,$punto_referencia_id,$orden_det_ruta)";

	$this -> query($insert,$Conex,true);
	

	return $detalle_seg_id;

  }



   
}



?>