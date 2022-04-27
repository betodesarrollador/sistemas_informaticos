<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetallesLiqModel extends Db{

  private $Permisos;
  
  public function getDetalles($orden_compra_id,$Conex){
	    	
	 if(is_numeric($orden_compra_id)){
		 $select      = "SELECT COUNT(*) AS movimientos FROM item_liquida_orden WHERE orden_compra_id=$orden_compra_id";
		 $result      = $this -> DbFetchAll($select,$Conex);
		 $movimientos = $result[0]['movimientos'];
	 
	 	 if($movimientos ==0){
			 $select_cic      = "SELECT item_orden_compra_id FROM item_orden_compra WHERE orden_compra_id=$orden_compra_id";
			 $result_cic      = $this -> DbFetchAll($select_cic,$Conex);
			 foreach($result_cic as $item_id){
			    $item_liquida_orden_id 		= $this -> DbgetMaxConsecutive("item_liquida_orden","item_liquida_orden_id",$Conex,true,1);
				 
				$insert="INSERT INTO item_liquida_orden (item_liquida_orden_id,orden_compra_id,cant_item_liquida_orden,desc_item_liquida_orden,valoruni_item_liquida_orden,fecha_item_liquida,usuario_id,remesa_id)
						SELECT $item_liquida_orden_id,orden_compra_id,cant_item_orden_compra,desc_item_orden_compra,valoruni_item_orden_compra,fecha_item_orden,usuario_id,remesa_id  FROM item_orden_compra WHERE item_orden_compra_id=$item_id[item_orden_compra_id]"; 
				$this -> DbFetchAll($insert,$Conex,true);
		 	}
		 }

		  $select  = "SELECT  i.cant_item_liquida_orden,
					  i.item_liquida_orden_id,
					  i.desc_item_liquida_orden,
					  i.valoruni_item_liquida_orden,
					  (SELECT numero_remesa FROM remesa WHERE remesa_id=i.remesa_id ) AS remesa,
					  i.remesa_id,
					  o.estado_orden_compra
					 FROM item_liquida_orden i, orden_compra o 
					 WHERE i.orden_compra_id = $orden_compra_id AND o.orden_compra_id=i.orden_compra_id";

	     $result = $this -> DbFetchAll($select,$Conex);
		
	}else{
   	    $result = array();
	}
	
	return $result;
  
  }
  
    
  public function Save($usuario_id,$Campos,$Conex){
	  	  
  	$this -> Begin($Conex);

      $orden_compra_id 				= $this -> requestDataForQuery('orden_compra_id','integer');
      $item_liquida_orden_id 		= $this -> DbgetMaxConsecutive("item_liquida_orden","item_liquida_orden_id",$Conex,true,1);
      $cant_item_liquida_orden 		= $this -> requestDataForQuery('cant_item_liquida_orden','numeric');	  
      $desc_item_liquida_orden 		= $this -> requestDataForQuery('desc_item_liquida_orden','alphanum');
      $valoruni_item_liquida_orden 	= $this -> requestDataForQuery('valoruni_item_liquida_orden','numeric');	
	   $remesa_id 						= $this -> requestDataForQuery('remesa_id','integer');	 
	  
	
      $insert = "INSERT INTO item_liquida_orden 
	            (item_liquida_orden_id,cant_item_liquida_orden,desc_item_liquida_orden,valoruni_item_liquida_orden,orden_compra_id,fecha_item_liquida,usuario_id,remesa_id ) 
	            VALUES  
				($item_liquida_orden_id,$cant_item_liquida_orden,$desc_item_liquida_orden,$valoruni_item_liquida_orden,$orden_compra_id,'".date('Y-m-d H:m')."',$usuario_id,$remesa_id)";
      $this -> query($insert,$Conex);
	$this -> Commit($Conex);
	
	return $item_liquida_orden_id;

  }

  public function Update($Campos,$Conex){

  	$this -> Begin($Conex);

      $item_liquida_orden_id 		= $this -> requestDataForQuery('item_liquida_orden_id','integer');
      $cant_item_liquida_orden  	= $this -> requestDataForQuery('cant_item_liquida_orden','numeric');	  
      $desc_item_liquida_orden 		= $this -> requestDataForQuery('desc_item_liquida_orden','alphanum');
      $valoruni_item_liquida_orden 	= $this -> requestDataForQuery('valoruni_item_liquida_orden','numeric');
	    $remesa_id 						= $this -> requestDataForQuery('remesa_id','integer');	 
	
      $update = "UPDATE item_liquida_orden SET cant_item_liquida_orden = $cant_item_liquida_orden,desc_item_liquida_orden = $desc_item_liquida_orden,valoruni_item_liquida_orden = $valoruni_item_liquida_orden , remesa_id=$remesa_id
	  WHERE item_liquida_orden_id = $item_liquida_orden_id";
	
      $this -> query($update,$Conex);
	
	$this -> Commit($Conex);
	
	return $item_liquida_orden_id;

  }

  public function Delete($Campos,$Conex){

    $item_liquida_orden_id = $_REQUEST['item_liquida_orden_id'];
	
    $insert = "DELETE FROM item_liquida_orden WHERE item_liquida_orden_id = $item_liquida_orden_id";
    $this -> query($insert,$Conex);	

  }
  
}



?>