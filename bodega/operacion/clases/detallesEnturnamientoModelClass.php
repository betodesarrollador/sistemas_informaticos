<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class detallesEnturnamientoModel extends Db{

  private $Permisos;
  
  public function getDetalles($enturnamiento_id,$oficina_id,$Conex){
	   	
	if(is_numeric($enturnamiento_id)){

	  $select  = "SELECT d.enturnamiento_detalle_id,
                         d.enturnamiento_id,
                         d.producto_id,
                         (SELECT p.nombre FROM wms_producto_inv p WHERE p.producto_id = d.producto_id)AS producto,
                         (SELECT p.codigo_barra FROM wms_producto_inv p WHERE p.producto_id = d.producto_id)AS codigo_barra,
                         e.estado,
                         d.serial,
                         d.cantidad 
	  		      FROM wms_enturnamiento e, wms_enturnamiento_detalle d 
                  WHERE d.enturnamiento_id = e.enturnamiento_id AND d.enturnamiento_id = $enturnamiento_id";
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

      $enturnamiento_detalle_id 		= $this -> DbgetMaxConsecutive("wms_enturnamiento_detalle","enturnamiento_detalle_id",$Conex,true,1);
      $enturnamiento_id 			= $this -> requestDataForQuery('enturnamiento_id','integer');
      $producto_id 	= $this -> requestDataForQuery('producto_id','integer');
      $serial  	= $this -> requestDataForQuery('serial','integer');	  
      $cantidad 	= $this -> requestDataForQuery('cantidad','integer');

      $select="SELECT serial FROM wms_enturnamiento_detalle WHERE producto_id = $producto_id AND serial = $serial ORDER BY enturnamiento_detalle_id DESC LIMIT 1";
     
      $result = $this-> DbFetchAll($select,$Conex);
      $serial_existente = $result[0]['serial'];
      //exit("serial".$serial_existente."--".$serial);
      if($serial != $serial_existente){
      
        if($enturnamiento_id > 0){
        $insert = "INSERT INTO wms_enturnamiento_detalle 
                (enturnamiento_detalle_id,enturnamiento_id,producto_id,serial,cantidad) 
                VALUES
                  ($enturnamiento_detalle_id,$enturnamiento_id,$producto_id,'$serial',$cantidad)";
        //echo $insert;
        $this -> query($insert,$Conex,true);
        }else{
          exit("¡Debe guardar primero los campos superiores!");
        }
      }else{
         exit("¡Este producto con serial #".$serial." ya fue ingresado!");
      }

	$this -> Commit($Conex);
  return $enturnamiento_detalle_id;
  }

  public function Update($Campos,$Conex){

  	$this -> Begin($Conex);

      $enturnamiento_detalle_id 		= $this -> requestDataForQuery('enturnamiento_detalle_id','integer');
      $enturnamiento_id 		= $this -> requestDataForQuery('enturnamiento_id','integer');
      $producto_id  	= $this -> requestDataForQuery('producto_id','numeric');	  
      $serial		= $this -> requestDataForQuery('serial','alphanum');
      $cantidad = $this -> requestDataForQuery('cantidad','numeric');	  

      $update = "UPDATE wms_enturnamiento_detalle SET producto_id = $producto_id,serial = $serial,cantidad = $cantidad 
	     WHERE enturnamiento_detalle_id = $enturnamiento_detalle_id";
	  
      $this -> query($update,$Conex,true);
	
	  $this -> Commit($Conex);
	
	  return $enturnamiento_detalle_id;

  }

  public function Delete($Campos,$Conex){

    $enturnamiento_detalle_id 		= $this -> requestDataForQuery('enturnamiento_detalle_id','integer');
	
    $delete = "DELETE FROM wms_enturnamiento_detalle WHERE enturnamiento_detalle_id = $enturnamiento_detalle_id";
    $this -> query($delete,$Conex,true);	

  }
  
   
}



?>