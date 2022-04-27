<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetalleAlistamientoModel extends Db{

  private $Permisos;
  
  public function getDetallesAlistamiento($Conex){


   $alistamiento_salida_id = $_REQUEST['alistamiento_salida_id'];

   if(is_numeric($alistamiento_salida_id)){

    $select  = "SELECT d.alistamiento_salida_detalle_id,d.alistamiento_salida_id,d.cantidad,d.serial,(SELECT CONCAT(codigo,' - ',nombre) FROM wms_ubicacion_bodega WHERE ubicacion_bodega_id=d.ubicacion_bodega_id)AS ubicacion_bodega,(SELECT nombre FROM wms_producto_inv WHERE producto_id=d.producto_id)AS producto,d.producto_id,d.ubicacion_bodega_id

    FROM wms_alistamiento_salida_detalle d WHERE d.alistamiento_salida_id= $alistamiento_salida_id";

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
      p.cantidad,	
      (SELECT nombre FROM wms_producto_inv WHERE producto_id=p.producto_id)AS producto,		
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

public function Save($Campos,$Conex,$cantidad,$serial,$ubicacion_bodega_id,$alistamiento_salida_id,$producto_id){
 

  $alistamiento_salida_detalle_id = $this -> DbgetMaxConsecutive("wms_alistamiento_salida_detalle","alistamiento_salida_detalle_id",$Conex);  
  $alistamiento_salida_detalle_id = ($alistamiento_salida_detalle_id + 1);
  
  $insert = "INSERT INTO wms_alistamiento_salida_detalle 
  (alistamiento_salida_detalle_id,alistamiento_salida_id,producto_id, cantidad, serial, ubicacion_bodega_id) 
  VALUES ($alistamiento_salida_detalle_id,$alistamiento_salida_id,$producto_id,$cantidad,$serial,$ubicacion_bodega_id)";

  $this -> query($insert,$Conex);

  if(strlen(trim($this -> GetError())) > 0){
    exit($this-> GetError()."\n".$insert);
  }else{
    echo($alistamiento_salida_detalle_id);
  }

}

public function Update($Campos,$Conex,$producto_id,$cantidad,$serial,$ubicacion_bodega_id,$alistamiento_salida_id,$alistamiento_salida_detalle_id){


  $update = "UPDATE wms_alistamiento_salida_detalle SET 
  producto_id                        = $producto_id,
  cantidad                        = $cantidad,
  serial                          = '$serial',
  ubicacion_bodega_id             = $ubicacion_bodega_id
  
  WHERE alistamiento_salida_detalle_id = $alistamiento_salida_detalle_id";

  $this -> query($update,$Conex);

  if(strlen(trim($this -> GetError())) > 0)  exit($this-> GetError()."\n".$update);

}

public function Delete($Campos,$Conex,$alistamiento_salida_detalle_id){

  $delete = "DELETE FROM wms_alistamiento_salida_detalle WHERE alistamiento_salida_detalle_id = $alistamiento_salida_detalle_id";

  $this -> query($delete,$Conex);	

  if(strlen(trim($this -> GetError())) > 0)  exit($this-> GetError()."\n".$delete);

}

}



?>