<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class SolicRemesaModel extends Db{

  private $Permisos;
  
  public function getSolicRemesa($trafico_id,$detalle_seg_id,$Conex){
	
	if(is_numeric($trafico_id) && is_numeric($detalle_seg_id)){		
		$select = "SELECT 
					t.trafico_id,
					r.remesa_id,
					r.numero_remesa
				FROM trafico t,  detalle_despacho d, remesa r
				WHERE t.trafico_id=$trafico_id AND t.estado='T' 
				AND ((d.despachos_urbanos_id=t.despachos_urbanos_id OR d.manifiesto_id=t.manifiesto_id) AND r.remesa_id=d.remesa_id
				AND r.remesa_id  NOT IN (SELECT dsr.remesa_id  FROM detalle_seguimiento_remesa dsr, detalle_seguimiento ds  WHERE ds.trafico_id=$trafico_id AND dsr.detalle_seg_id=ds.detalle_seg_id AND  dsr.borrado=0 AND ds.borrado=0 ))";
		  $result = $this -> DbFetchAll($select,$Conex);


	  	$i=0;
	  	foreach($result as $items){
			$saldo=intval($items[valor_neto])-intval($items[abonos]); 
			$results[$i]=array(trafico_id=>$items[trafico_id],remesa_id=>$items[remesa_id],numero_remesa=>$items[numero_remesa]);	
			$i++;
		}
	}else{
   	    $results = array();
	 }
	
	return $results;
  }
  

  public function Save($Campos,$Conex){

    $detalle_seg_id      = $this -> requestDataForQuery('detalle_seg_id','integer');
    $remesa_id       	 = $this -> requestDataForQuery('remesa_id','integer');
    $observaciones     	 = $this -> requestDataForQuery('observaciones','text');
	$fecha_hora_registro = date('Y-m-d H:i');
	

	
    $detalle_seg_rem_id = $this -> DbgetMaxConsecutive("detalle_seguimiento_remesa","detalle_seg_rem_id",$Conex,true,1);	

    $insert = "INSERT INTO detalle_seguimiento_remesa 
					(detalle_seg_rem_id,remesa_id,obser_deta,detalle_seg_id,fecha_hora_registro) 
	           VALUES 
			   		($detalle_seg_rem_id,$remesa_id,$observaciones,$detalle_seg_id,'$fecha_hora_registro')";
	
    $this -> query($insert,$Conex);

 	if($this -> GetNumError() > 0){
    	return false;
	}else{
		return $detalle_seg_rem_id;
	}

  }

}


?>