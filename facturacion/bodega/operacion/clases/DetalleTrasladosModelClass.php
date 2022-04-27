<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetalleTrasladosModel extends Db{

  private $Permisos;
  
  public function getDetallesTraslados($Conex){


   $traslado_id = $_REQUEST['traslado_id'];

   if(is_numeric($traslado_id)){

    $select  = "SELECT d.traslado_detalle_id,d.traslado_id,d.cantidad,d.entrada_id AS entrada,d.serial,(SELECT CONCAT(codigo,' - ',nombre) FROM wms_ubicacion_bodega WHERE ubicacion_bodega_id=d.ubicacion_bodega_id)AS ubicacion_bodega,d.ubicacion_bodega_id

    FROM wms_traslado_detalle d WHERE d.traslado_id= $traslado_id";

    $result = $this -> DbFetchAll($select,$Conex,true);
    
  }else{
    $result = array();
  }
  
  return $result;

}

public function selectOficina($Conex){
  $select         = "SELECT oficina_id , nombre  FROM oficina";
  $result         = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
  return $result;
}  

 public function setLeerCodigobar($Conex){
    $serial = $this -> requestDataForQuery('serial','alphanum');

		$select_salida = "SELECT 
			p.serial
      FROM wms_alistamiento_salida_detalle p 
			WHERE p.serial=$serial";
			
    $result_salida = $this-> DbFetchAll($select_salida,$Conex,true);
    // $serial_salida = $result_salida[0]['serial'];

  if ($result_salida>0) {
    Exit('Este serial #'.$serial.' Ya se encuentra en una salida de alistamiento.');
  }else{
    $select = "SELECT 
      p.producto_id,
      p.serial,
      p.entrada_id,
      p.cantidad,		
      p.ubicacion_bodega_id,
     (SELECT CONCAT(codigo,' - ',nombre) FROM wms_ubicacion_bodega WHERE ubicacion_bodega_id=p.ubicacion_bodega_id)AS ubicacion_bodega	
      FROM wms_entrada_detalle p 
      WHERE p.serial=$serial";
      
    $result = $this-> DbFetchAll($select,$Conex,true);

  }

    if($result>0){
     return $result;
    }
  }

public function Save($Campos,$Conex,$cantidad,$serial,$ubicacion_bodega_id,$traslado_id,$entrada_id){
 

  $traslado_detalle_id = $this -> DbgetMaxConsecutive("wms_traslado_detalle","traslado_detalle_id",$Conex);  
  $traslado_detalle_id = ($traslado_detalle_id + 1);

  $insert = "INSERT INTO wms_traslado_detalle 
  (traslado_detalle_id,traslado_id, cantidad, serial, ubicacion_bodega_id,entrada_id) 
  VALUES ($traslado_detalle_id,$traslado_id,$cantidad,$serial,$ubicacion_bodega_id,$entrada_id)";

  $this -> query($insert,$Conex);

  if(strlen(trim($this -> GetError())) > 0){
    exit($this-> GetError()."\n".$insert);
  }else{
    echo($traslado_detalle_id);
  }

}

public function Update($Campos,$Conex,$cantidad,$serial,$ubicacion_bodega_id,$traslado_id,$traslado_detalle_id,$entrada_id){


  $update = "UPDATE wms_traslado_detalle SET 
  cantidad                        = $cantidad,
  serial                          = '$serial',
  ubicacion_bodega_id             = $ubicacion_bodega_id,
  entrada_id                      = $entrada_id
  
  WHERE traslado_detalle_id = $traslado_detalle_id";

  $this -> query($update,$Conex);

  if(strlen(trim($this -> GetError())) > 0)  exit($this-> GetError()."\n".$update);

}

public function Delete($Campos,$Conex,$traslado_detalle_id){

  $delete = "DELETE FROM wms_traslado_detalle WHERE traslado_detalle_id = $traslado_detalle_id";

  $this -> query($delete,$Conex);	

  if(strlen(trim($this -> GetError())) > 0)  exit($this-> GetError()."\n".$delete);

}

}



?>