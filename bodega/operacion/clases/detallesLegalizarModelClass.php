<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class detallesLegalizarModel extends Db{

  private $Permisos;
  
  public function getDetalles($recepcion_id,$oficina_id,$Conex){
	   	
	if(is_numeric($recepcion_id)){

	  $select  = "SELECT d.enturnamiento_detalle_id,
                         d.enturnamiento_id,
                         d.producto_id,
                         (SELECT p.nombre FROM wms_producto_inv p WHERE p.producto_id = d.producto_id)AS producto,
                         (SELECT p.codigo_barra FROM wms_producto_inv p WHERE p.producto_id = d.producto_id)AS codigo_barra,
                         r.estado,
                         d.serial,
                         d.cantidad 
	  		      FROM wms_enturnamiento e, wms_enturnamiento_detalle d, wms_recepcion r
                  WHERE d.enturnamiento_id = e.enturnamiento_id AND e.enturnamiento_id=r.enturnamiento_id AND r.recepcion_id = $recepcion_id";
      
      $result = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
	 }
	
	return $result;
  
  }

  public function getDetallesLegalizados($recepcion_id,$oficina_id,$Conex){
	   	
	if(is_numeric($recepcion_id)){

	  $select  = "SELECT d.enturnamiento_detalle_id,
                         d.recepcion_id,
                         d.producto_id,
                         (SELECT p.nombre FROM wms_producto_inv p WHERE p.producto_id = d.producto_id)AS producto,
                         (SELECT p.codigo_barra FROM wms_producto_inv p WHERE p.producto_id = d.producto_id)AS codigo_barra,
                         r.estado,
                         d.serial,
                         d.cantidad 
	  		      FROM wms_recepcion_detalle d, wms_recepcion r
                  WHERE d.recepcion_id = r.recepcion_id AND r.recepcion_id = $recepcion_id";
      
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

      $recepcion_detalle_id 		= $this -> DbgetMaxConsecutive("wms_recepcion_detalle","recepcion_detalle_id",$Conex,true,1);
      $enturnamiento_detalle_id 	= $this -> requestDataForQuery('enturnamiento_detalle_id','integer');
      $recepcion_id 			= $this -> requestDataForQuery('recepcion_id','integer');
      $producto_id 	= $this -> requestDataForQuery('producto_id','integer');
      $serial  	= $this -> requestDataForQuery('serial','alphanum');	  
      $cantidad 	= $this -> requestDataForQuery('cantidad','integer');
      
	  if($recepcion_id > 0){
      $insert = "INSERT INTO wms_recepcion_detalle 
	             (recepcion_detalle_id,recepcion_id,enturnamiento_detalle_id,producto_id,serial,cantidad) 
	             VALUES
                 ($recepcion_detalle_id,$recepcion_id,$enturnamiento_detalle_id,$producto_id,$serial,$cantidad)";
      //echo $insert;
      $this -> query($insert,$Conex,true);

      $update="UPDATE wms_recepcion SET estado = 'L' WHERE recepcion_id = $recepcion_id";
      $this -> query($update,$Conex,true);

      $update="UPDATE wms_enturnamiento SET estado = 'L' WHERE enturnamiento_id = (SELECT enturnamiento_id FROM wms_recepcion WHERE recepcion_id = $recepcion_id AND estado != 'A')";
      $this -> query($update,$Conex,true);

      }else{
        exit("¡Debe guardar primero los campos superiores!");
      }

	$this -> Commit($Conex);
  return $recepcion_detalle_id;
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