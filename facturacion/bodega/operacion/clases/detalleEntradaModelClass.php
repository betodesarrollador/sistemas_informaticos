<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class detalleEntradaModel extends Db{

  private $Permisos;
  
  public function getDetalles($recepcion_id,$oficina_id,$Conex){
	   	
	if(is_numeric($recepcion_id)){

	  $select  = "SELECT d.recepcion_detalle_id,
                         d.recepcion_id,
                         d.producto_id,
                         (SELECT p.nombre FROM wms_producto_inv p WHERE p.producto_id = d.producto_id)AS producto,
                         (SELECT p.codigo_barra FROM wms_producto_inv p WHERE p.producto_id = d.producto_id)AS codigo_barra,
                         d.serial,
                         d.cantidad,
                         e.estado 
	  		      FROM wms_recepcion_detalle d,wms_entrada e

              WHERE d.recepcion_id = e.recepcion_id AND e.recepcion_id = $recepcion_id AND e.estado!='A'";
      
      $result = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
	 }
	
	return $result;
  
  }

  public function getDetallesIngresados($entrada_id,$recepcion_id,$oficina_id,$Conex){
	   	
	if(is_numeric($entrada_id) AND is_numeric($recepcion_id) ){

	  $select  = "(SELECT   d.entrada_detalle_id,
                         d.entrada_id,
                         d.producto_id,
                         d.recepcion_detalle_id,
                         (SELECT p.nombre FROM wms_producto_inv p WHERE p.producto_id = d.producto_id)AS producto,
                         (SELECT p.codigo_barra FROM wms_producto_inv p WHERE p.producto_id = d.producto_id)AS codigo_barra,
                         d.serial,
                         d.cantidad,
                         e.estado,
                         (SELECT u.nombre FROM wms_ubicacion_bodega u WHERE u.ubicacion_bodega_id=d.ubicacion_bodega_id)AS ubicacion_bodega,
                         d.ubicacion_bodega_id,
                          (SELECT p.nombre FROM wms_posicion p WHERE p.posicion_id=d.posicion_id)AS posicion,
                         d.posicion_id,
                         (SELECT e.nombre FROM wms_estado_producto e WHERE e.estado_producto_id=d.estado_producto_id)AS estado_producto,
                         d.estado_producto_id
	  		        FROM wms_entrada_detalle d, wms_entrada e
                  WHERE d.entrada_id = e.entrada_id AND e.entrada_id = $entrada_id)
                  
                  UNION ALL

                  (SELECT 
                         '',
                         d.recepcion_id,
                         d.producto_id,
                         d.recepcion_detalle_id,
                         (SELECT p.nombre FROM wms_producto_inv p WHERE p.producto_id = d.producto_id)AS producto,
                         (SELECT p.codigo_barra FROM wms_producto_inv p WHERE p.producto_id = d.producto_id)AS codigo_barra,
                         d.serial,
                         d.cantidad,
                         e.estado,
                         '',
                         'NULL',
                         '',
                         'NULL' ,
                         '' ,
                         'NULL'       
	  		      FROM wms_recepcion_detalle d,wms_entrada e
              WHERE d.recepcion_id = e.recepcion_id AND e.recepcion_id = $recepcion_id AND e.estado!='A' AND d.serial NOT IN(SELECT serial FROM wms_entrada_detalle))";
      
      $result = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
	 }
	
	return $result;
  
  }

  public function getPendientes($entrada_id,$recepcion_id,$Conex){
	   	
	if(is_numeric($entrada_id) AND is_numeric($recepcion_id) ){

	  $select  = "(SELECT   d.entrada_detalle_id,
                         d.entrada_id,
                         d.producto_id,
                         d.recepcion_detalle_id,
                         (SELECT p.nombre FROM wms_producto_inv p WHERE p.producto_id = d.producto_id)AS producto,
                         (SELECT p.codigo_barra FROM wms_producto_inv p WHERE p.producto_id = d.producto_id)AS codigo_barra,
                         d.serial,
                         d.cantidad,
                         e.estado,
                         (SELECT u.nombre FROM wms_ubicacion_bodega u WHERE u.ubicacion_bodega_id=d.ubicacion_bodega_id)AS ubicacion_bodega,
                         d.ubicacion_bodega_id,
                          (SELECT p.nombre FROM wms_posicion p WHERE p.posicion_id=d.posicion_id)AS posicion,
                         d.posicion_id,
                         (SELECT e.nombre FROM wms_estado_producto e WHERE e.estado_producto_id=d.estado_producto_id)AS estado_producto,
                         d.estado_producto_id
	  		        FROM wms_entrada_detalle d, wms_entrada e
                  WHERE d.entrada_id = e.entrada_id AND e.entrada_id = $entrada_id)
                  
                  UNION ALL

                  (SELECT 
                         '0' AS entrada_detalle_id,
                         d.recepcion_id,
                         d.producto_id,
                         d.recepcion_detalle_id,
                         (SELECT p.nombre FROM wms_producto_inv p WHERE p.producto_id = d.producto_id)AS producto,
                         (SELECT p.codigo_barra FROM wms_producto_inv p WHERE p.producto_id = d.producto_id)AS codigo_barra,
                         d.serial,
                         d.cantidad,
                         e.estado,
                         '',
                         '0' AS ubicacion_bodega_id,
                         '',
                         'NULL' ,
                         '' ,
                         'NULL'       
	  		      FROM wms_recepcion_detalle d,wms_entrada e
              WHERE d.recepcion_id = e.recepcion_id AND e.recepcion_id = $recepcion_id AND e.estado!='A' AND d.serial NOT IN(SELECT serial FROM wms_entrada_detalle))";
      
      $result = $this -> DbFetchAll($select,$Conex,true);

      if($result>0){
        return $result;
      }else{
        return false;
      }
	  
	}else{
   	    $result = array();
	 }
	
  
  }

  public function getUbicaciones($Conex){
    $recepcion_id 			= $this -> requestDataForQuery('recepcion_id','integer');

    $select  = "SELECT u.ubicacion_bodega_id AS value, CONCAT_WS(' - ',u.codigo,u.nombre)AS ubicacion_bodega 
    FROM wms_ubicacion_bodega u, wms_muelle m, wms_enturnamiento e, wms_recepcion r 
    WHERE u.bodega_id = m.bodega_id AND m.muelle_id = e.muelle_id AND e.enturnamiento_id = r.enturnamiento_id AND u.estado = 'A' GROUP BY value";
    
	  $result = $this -> DbFetchAll($select,$Conex,true);
	  if($result>0){
        return $result;
    }else{
        return false;
    }
  }

  public function getPosiciones($Conex){
    $ubicacion_bodega_id 			= $this -> requestDataForQuery('ubicacion_bodega_id','integer');

    $select  = "SELECT p.posicion_id AS value, CONCAT_WS(' - ',p.codigo,p.nombre)AS posicion FROM wms_posicion p WHERE p.ubicacion_bodega_id = $ubicacion_bodega_id AND p.estado = 'D'";
	  $result = $this -> DbFetchAll($select,$Conex,true);
	  if($result>0){
        return $result;
    }else{
        return false;
    }
  }

  public function getEstados($Conex){
    $ubicacion_bodega_id 			= $this -> requestDataForQuery('ubicacion_bodega_id','integer');

    $select  = "SELECT e.estado_producto_id AS value, CONCAT_WS(' - ',e.codigo,e.descripcion)AS estado FROM wms_estado_producto e, wms_estado_ubicacion u WHERE e.estado_producto_id = u.estado_producto_id AND u.ubicacion_bodega_id = $ubicacion_bodega_id AND u.estado = 'A' AND e.estado ='A'";
	  $result = $this -> DbFetchAll($select,$Conex,true);
	  if($result>0){
        return $result;
    }else{
        return false;
    }
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
      
      $entrada_detalle_id 		= $this -> DbgetMaxConsecutive("wms_entrada_detalle","entrada_detalle_id",$Conex,true,1);
      $recepcion_detalle_id 	= $this -> requestDataForQuery('recepcion_detalle_id','integer');
      $entrada_id 			= $this -> requestDataForQuery('entrada_id','integer');
      $producto_id 	= $this -> requestDataForQuery('producto_id','integer');
      $serial  	= $this -> requestDataForQuery('serial','alphanum');	  
      $cantidad 	= $this -> requestDataForQuery('cantidad','integer');
      $ubicacion_bodega_id 	= $this -> requestDataForQuery('ubicacion_bodega_id','integer');
      $posicion_id 	= $this -> requestDataForQuery('posicion_id','integer');
      $estado_producto_id 	= $this -> requestDataForQuery('estado_producto_id','integer');
      $inventario_id 		= $this -> DbgetMaxConsecutive("wms_inventario","inventario_id",$Conex,true,1);
      
	  if($entrada_id > 0){
      
      $insert = "INSERT INTO wms_entrada_detalle 
	             (entrada_detalle_id,entrada_id,producto_id,recepcion_detalle_id,serial,cantidad,ubicacion_bodega_id,posicion_id,estado_producto_id) 
	             VALUES
                 ($entrada_detalle_id,$entrada_id,$producto_id,$recepcion_detalle_id,$serial,$cantidad,$ubicacion_bodega_id,$posicion_id,$estado_producto_id)";
                        
      $this -> query($insert,$Conex,true);
      
      $select="SELECT bodega_id FROM wms_ubicacion_bodega  WHERE ubicacion_bodega_id = $ubicacion_bodega_id";
      $result = $this-> DbFetchAll($select,$Conex);
      $bodega_id = $result[0]['bodega_id'];

        if($bodega_id>0){

          $insert = "INSERT INTO wms_inventario
                  (inventario_id,tipo,producto_id,bodega_id,cantidad,serial,detalle_entrada_producto_id,ubicacion_bodega_id,posicion_id,estado_producto_id) 
                  VALUES
                    ($inventario_id,'E',$producto_id,$bodega_id,$cantidad,$serial,$entrada_detalle_id,$ubicacion_bodega_id,$posicion_id,$estado_producto_id)";
          $this -> query($insert,$Conex,true);

          $update="UPDATE wms_entrada SET estado = 'IN' WHERE entrada_id = $entrada_id";
          $this -> query($update,$Conex,true);
        
          $update="UPDATE wms_recepcion SET estado = 'I' WHERE recepcion_id = (SELECT recepcion_id FROM wms_entrada WHERE entrada_id = $entrada_id AND estado != 'A')";
          $this -> query($update,$Conex,true); 

        }

      }else{
        exit("¡Debe guardar primero los campos superiores!");
      }

	$this -> Commit($Conex);
  return $entrada_detalle_id;
  }

/*     public function SaveInventario($Campos,$Conex){
	  	  
  	$this -> Begin($Conex);

      $inventario_id 		= $this -> DbgetMaxConsecutive("wms_inventario","inventario_id",$Conex,true,1);
      $entrada_id 	= $this -> requestDataForQuery('entrada_id','integer');
      $entrada_detalle_id 			= $this -> requestDataForQuery('entrada_detalle_id','integer');
      $producto_id 	= $this -> requestDataForQuery('producto_id','integer');
      $serial  	= $this -> requestDataForQuery('serial','alphanum');	  
      $cantidad 	= $this -> requestDataForQuery('cantidad','integer');
      $ubicacion_bodega_id 	= $this -> requestDataForQuery('ubicacion_bodega_id','integer');
      $posicion_id 	= $this -> requestDataForQuery('posicion_id','integer');
      $estado_producto_id 	= $this -> requestDataForQuery('estado_producto_id','integer');
      
	  if($entrada_detalle_id > 0){
      
      $select="SELECT bodega_id FROM wms_ubicacion_bodega  WHERE ubicacion_bodega_id = $ubicacion_bodega_id";
      $result = $this-> DbFetchAll($select,$Conex);
      $bodega_id = $result[0]['bodega_id'];

      $insert = "INSERT INTO wms_inventario
	             (inventario_id,tipo,producto_id,bodega_id,cantidad,serial,detalle_entrada_producto_id,ubicacion_bodega_id,posicion_id,estado_producto_id) 
	             VALUES
                 ($inventario_id,'E',$producto_id,$bodega_id,$cantidad,$serial,$entrada_detalle_id,$ubicacion_bodega_id,$posicion_id,$estado_producto_id)";
      $this -> query($insert,$Conex,true);

      $update="UPDATE wms_entrada SET estado = 'IN' WHERE entrada_id = $entrada_id";
      $this -> query($update,$Conex,true);

      }else{
        exit("¡Debe guardar primero los campos superiores!");
      }

	$this -> Commit($Conex);
  return $inventario_id;
  } */

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