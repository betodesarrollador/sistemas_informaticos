<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class detallesDespachoModel extends Db{

  private $Permisos;
  
  public function getDetalles($alistamiento_salida_id,$oficina_id,$Conex){
	   	
	if(is_numeric($alistamiento_salida_id)){

    $select  = "SELECT d.alistamiento_salida_detalle_id,
                d.alistamiento_salida_id, 
                (SELECT p.nombre FROM wms_producto_inv p, wms_entrada_detalle e WHERE p.producto_id = e.producto_id AND e.serial = d.serial)AS producto,
                (SELECT p.codigo_barra FROM wms_producto_inv p, wms_entrada_detalle e WHERE p.producto_id = e.producto_id AND e.serial = d.serial)AS codigo_barra,    
                d.cantidad,
                d.serial,
                (SELECT CONCAT(codigo,' - ',nombre) FROM wms_ubicacion_bodega WHERE ubicacion_bodega_id=d.ubicacion_bodega_id)AS ubicacion_bodega,
                d.ubicacion_bodega_id,
                (SELECT estado FROM wms_despacho WHERE alistamiento_salida_id=d.alistamiento_salida_id AND estado != 'AN')AS estado
                FROM wms_alistamiento_salida_detalle d WHERE d.alistamiento_salida_id= $alistamiento_salida_id";
    
    $result = $this -> DbFetchAll($select,$Conex,true);
    
  }else{
    $result = array();
  }
	
	return $result;
  
  }

  public function getDetallesDespachados($alistamiento_salida_id,$oficina_id,$Conex){
	   	
	if(is_numeric($alistamiento_salida_id)){

	  $select  = "SELECT d.despacho_detalle_id,
                         d.despacho_id,
                         d.alistamiento_salida_detalle_id,
                         (SELECT p.nombre FROM wms_producto_inv p, wms_entrada_detalle e WHERE p.producto_id = e.producto_id AND e.serial = d.serial)AS producto,
                         (SELECT p.codigo_barra FROM wms_producto_inv p, wms_entrada_detalle e WHERE p.producto_id = e.producto_id AND e.serial = d.serial)AS codigo_barra,
                         r.estado,
                         d.serial,
                         d.cantidad,
                         (SELECT CONCAT(codigo,' - ',nombre) FROM wms_ubicacion_bodega WHERE ubicacion_bodega_id=d.ubicacion_bodega_id)AS ubicacion_bodega,
                d.ubicacion_bodega_id
	  		      FROM wms_despacho_detalle d,wms_despacho r
                  WHERE d.despacho_id = r.despacho_id AND r.estado != 'AN' AND r.alistamiento_salida_id = $alistamiento_salida_id";
      
      $result = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
	 }
	
	return $result;
  
  }

  public function getCodigo($Conex){
    $producto_id 			= $this -> requestDataForQuery('producto_id','integer');
    $select  = "SELECT codigo_barra FROM wms_producto_inv  WHERE producto_id = $producto_id";
	  $result = $this -> DbFetchAll($select,$Conex,true);
	  
	  return $result;
  }

  public function getProducto($Conex){
    $codigo_barra 			= $this -> requestDataForQuery('codigo_barra','alphanum');
    $select  = "SELECT producto_id, nombre FROM wms_producto_inv  WHERE producto_id = $codigo_barra";
    $result = $this -> DbFetchAll($select,$Conex,true);
	  
	  return $result;
  }

  public function setLeerCodigobar($Conex){
    $codigo_barra = $this -> requestDataForQuery('codigo_barra','alphanum');

		$select = "SELECT 
			p.producto_id,
			p.nombre,
			p.consecutivo,
            p.codigo_barra		
			FROM wms_producto_inv p 
			WHERE p.codigo_barra=$codigo_barra ORDER BY producto_id DESC";
			
    $result = $this-> DbFetchAll($select,$Conex);
    if($result>0){
     return $result;
    }
  }
  
  public function Save($Campos,$Conex){
	  	  
  	$this -> Begin($Conex);

      $despacho_detalle_id 		= $this -> DbgetMaxConsecutive("wms_despacho_detalle","despacho_detalle_id",$Conex,true,1);
      $alistamiento_salida_detalle_id 	= $this -> requestDataForQuery('alistamiento_salida_detalle_id','integer');
      $despacho_id 			= $this -> requestDataForQuery('despacho_id','integer');
     // $producto_id 	= $this -> requestDataForQuery('producto_id','integer');
      $serial  	= $this -> requestDataForQuery('serial','alphanum');	  
      $cantidad 	= $this -> requestDataForQuery('cantidad','integer');
      $ubicacion_id 	= $this -> requestDataForQuery('ubicacion_id','integer');
      
	  if($despacho_id > 0){
      $insert = "INSERT INTO wms_despacho_detalle 
	             (despacho_detalle_id,despacho_id,alistamiento_salida_detalle_id,cantidad,serial,ubicacion_bodega_id) 
	             VALUES
                ($despacho_detalle_id,$despacho_id,$alistamiento_salida_detalle_id,$cantidad,$serial,$ubicacion_id)";
     // echo $insert;
      $this -> query($insert,$Conex,true);

      $update="UPDATE wms_despacho SET estado = 'D' WHERE despacho_id = $despacho_id";
      $this -> query($update,$Conex,true);

      $update="UPDATE wms_alistamiento_salida SET estado = 'D' WHERE alistamiento_salida_id = (SELECT alistamiento_salida_id FROM wms_despacho WHERE despacho_id = $despacho_id AND estado !='AN')";
      $this -> query($update,$Conex,true);


      }else{
        exit("¡Debe guardar primero los campos superiores!");
      }

	$this -> Commit($Conex);
    return $despacho_detalle_id;
  }

  public function Update($Campos,$Conex){

  	$this -> Begin($Conex);

      $recepcion_detalle_id 		= $this -> DbgetMaxConsecutive("wms_recepcion_detalle","recepcion_detalle_id",$Conex,true,1);
      $enturnamiento_detalle_id 	= $this -> requestDataForQuery('enturnamiento_detalle_id','integer');
      $recepcion_id 			= $this -> requestDataForQuery('recepcion_id','integer');
      $producto_id 	= $this -> requestDataForQuery('producto_id','integer');
      $serial  	= $this -> requestDataForQuery('serial','alphanum');	  
      $cantidad 	= $this -> requestDataForQuery('cantidad','integer');	  

      $update = "UPDATE wms_recepcion_detalle SET enturnamiento_detalle_id = $enturnamiento_detalle_id,producto_id = $producto_id,serial = $serial,cantidad = $cantidad 
	     WHERE recepcion_detalle_id = $recepcion_detalle_id";
	  
      $this -> query($update,$Conex,true);
	
	  $this -> Commit($Conex);
	
	  return $recepcion_detalle_id;

  }

  public function Delete($Campos,$Conex){

    $recepcion_detalle_id 		= $this -> requestDataForQuery('recepcion_detalle_id','integer');
	
    $delete = "DELETE FROM wms_recepcion_detalle WHERE recepcion_detalle_id = $recepcion_detalle_id";
    $this -> query($delete,$Conex,true);	

  }
  
   
}



?>