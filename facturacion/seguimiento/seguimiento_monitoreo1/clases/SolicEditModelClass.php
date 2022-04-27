<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class SolicEditModel extends Db{

  private $Permisos;
  
  public function getSolicRemesa($trafico_id,$detalle_seg_id,$Conex){
	
	if(is_numeric($trafico_id) && is_numeric($detalle_seg_id)){		
		$select = "(
					SELECT 
					dr.detalle_seg_rem_id,
					t.trafico_id,
					r.remesa_id,
					r.numero_remesa,
					dr.obser_deta AS observaciones,
					'1' AS ingresado
				FROM trafico t,  remesa r, detalle_seguimiento d, detalle_seguimiento_remesa dr
				WHERE t.trafico_id=$trafico_id AND t.estado='T' AND d.trafico_id=t.trafico_id AND dr.detalle_seg_id=d.detalle_seg_id
				AND dr.detalle_seg_id=$detalle_seg_id AND r.remesa_id=dr.remesa_id AND dr.borrado=0
				)UNION(
					 SELECT 
					 	'' AS detalle_seg_rem_id,
						t.trafico_id,
						r.remesa_id,
						r.numero_remesa,
						'' AS observaciones,
						'0' AS ingresado
					FROM trafico t,  detalle_despacho d, remesa r
					WHERE t.trafico_id=$trafico_id AND t.estado='T' 
					AND ((d.despachos_urbanos_id=t.despachos_urbanos_id OR d.manifiesto_id=t.manifiesto_id) AND r.remesa_id=d.remesa_id
					AND r.remesa_id  NOT IN (SELECT dsr.remesa_id  FROM detalle_seguimiento_remesa dsr, detalle_seguimiento ds  WHERE ds.trafico_id=$trafico_id AND dsr.detalle_seg_id=ds.detalle_seg_id AND  dsr.borrado=0 AND ds.borrado=0 ))
				 
				 )
		"; 
		  $result = $this -> DbFetchAll($select,$Conex);


	  	$i=0;
	  	foreach($result as $items){

			$results[$i]=array(detalle_seg_rem_id=>$items[detalle_seg_rem_id],trafico_id=>$items[trafico_id],remesa_id=>$items[remesa_id],numero_remesa=>$items[numero_remesa],observaciones=>$items[observaciones],ingresado=>$items[ingresado]);	
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

  public function Update($Campos,$Conex){

	$detalle_seg_rem_id  = $this -> requestDataForQuery('detalle_seg_rem_id','integer');
    $detalle_seg_id      = $this -> requestDataForQuery('detalle_seg_id','integer');
    $remesa_id       	 = $this -> requestDataForQuery('remesa_id','integer');
    $observaciones     	 = $this -> requestDataForQuery('observaciones','text');
	$fecha_hora_registro = date('Y-m-d H:i');
	

    $update = "UPDATE detalle_seguimiento_remesa SET
				remesa_id=$remesa_id,
				obser_deta=$observaciones,
				detalle_seg_id=$detalle_seg_id ,
				fecha_hora_registro='$fecha_hora_registro'
				WHERE  	detalle_seg_rem_id=$detalle_seg_rem_id";
	
    $this -> query($update,$Conex);

 	if($this -> GetNumError() > 0){
    	return false;
	}else{
		return $detalle_seg_rem_id;
	}

  }

  public function Delete($Campos,$Conex){

	$detalle_seg_rem_id  = $this -> requestDataForQuery('detalle_seg_rem_id','integer');
	

    $delete = "UPDATE detalle_seguimiento_remesa SET
			 	borrado=1
				WHERE  	detalle_seg_rem_id=$detalle_seg_rem_id";
	
    $this -> query($delete,$Conex);

 	if($this -> GetNumError() > 0){
    	return false;
	}else{
		return $detalle_seg_rem_id;
	}

  }


}


?>