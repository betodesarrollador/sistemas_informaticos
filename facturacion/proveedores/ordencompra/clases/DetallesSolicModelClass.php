<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetallesSolicModel extends Db{

  private $Permisos;
  
  public function getDetalles($pre_orden_compra_id,$Conex){
	   	
	if(is_numeric($pre_orden_compra_id)){
	
	  $select  = "SELECT  i.cant_item_pre_orden_compra,
				  i.item_pre_orden_compra_id,
				  i.desc_item_pre_orden_compra,
				  i.valoruni_item_pre_orden_compra,
				  (SELECT numero_remesa FROM remesa WHERE remesa_id=i.remesa_id ) AS remesa,
				  i.remesa_id,
				  o.estado_pre_orden_compra
				 FROM item_pre_orden_compra i, pre_orden_compra o 
				 WHERE i.pre_orden_compra_id = $pre_orden_compra_id AND o.pre_orden_compra_id=i.pre_orden_compra_id";
	
	  $result = $this -> DbFetchAll($select,$Conex,true);
	  if(count($result)==0){
		  $select="SELECT o.descrip_pre_orden_compra AS desc_item_pre_orden_compra, 'A' as estado_pre_orden_compra FROM pre_orden_compra o WHERE o.pre_orden_compra_id=$pre_orden_compra_id";
		  $result = $this -> DbFetchAll($select,$Conex,true);
	  }
	  
	}else{
   	    $result = array();
	}
	
	return $result;
  
  }
  
    
  public function Save($usuario_id,$Campos,$Conex){
	  	  
  	$this -> Begin($Conex);

      $pre_orden_compra_id 				= $this -> requestDataForQuery('pre_orden_compra_id','integer');
      $item_pre_orden_compra_id 		= $this -> DbgetMaxConsecutive("item_pre_orden_compra","item_pre_orden_compra_id",$Conex,true,1);
      $cant_item_pre_orden_compra  		= $this -> requestDataForQuery('cant_item_pre_orden_compra','numeric');	  
      $desc_item_pre_orden_compra 		= $this -> requestDataForQuery('desc_item_pre_orden_compra','alphanum');
      $valoruni_item_pre_orden_compra 	= $this -> requestDataForQuery('valoruni_item_pre_orden_compra','numeric');
	  $remesa_id 					= $this -> requestDataForQuery('remesa_id','integer');	 
	  
	
      $insert = "INSERT INTO item_pre_orden_compra 
	            (item_pre_orden_compra_id,cant_item_pre_orden_compra,desc_item_pre_orden_compra,valoruni_item_pre_orden_compra,pre_orden_compra_id,fecha_item_orden,usuario_id,remesa_id) 
	            VALUES  
				($item_pre_orden_compra_id,$cant_item_pre_orden_compra,$desc_item_pre_orden_compra,$valoruni_item_pre_orden_compra,$pre_orden_compra_id,'".date('Y-m-d H:m')."',$usuario_id,$remesa_id)";
      $this -> query($insert,$Conex,true);
	
	$this -> Commit($Conex);
	
	return $item_pre_orden_compra_id;

  }

  public function Update($Campos,$Conex){

  	$this -> Begin($Conex);

      $item_pre_orden_compra_id 		= $this -> requestDataForQuery('item_pre_orden_compra_id','integer');
      $cant_item_pre_orden_compra  		= $this -> requestDataForQuery('cant_item_pre_orden_compra','numeric');	  
      $desc_item_pre_orden_compra 		= $this -> requestDataForQuery('desc_item_pre_orden_compra','alphanum');
      $valoruni_item_pre_orden_compra 	= $this -> requestDataForQuery('valoruni_item_pre_orden_compra','numeric');	
	   $remesa_id 						= $this -> requestDataForQuery('remesa_id','integer');	 
	
      $update = "UPDATE item_pre_orden_compra SET cant_item_pre_orden_compra = $cant_item_pre_orden_compra,desc_item_pre_orden_compra = $desc_item_pre_orden_compra,valoruni_item_pre_orden_compra = $valoruni_item_pre_orden_compra,remesa_id=$remesa_id 
	  WHERE item_pre_orden_compra_id = $item_pre_orden_compra_id";
	
      $this -> query($update,$Conex,true);
	
	$this -> Commit($Conex);
	
	return $item_pre_orden_compra_id;

  }

  public function Delete($Campos,$Conex){

    $item_pre_orden_compra_id = $_REQUEST['item_pre_orden_compra_id'];
	
    $insert = "DELETE FROM item_pre_orden_compra WHERE item_pre_orden_compra_id = $item_pre_orden_compra_id";
    $this -> query($insert,$Conex,true);	

  }
  
}



?>