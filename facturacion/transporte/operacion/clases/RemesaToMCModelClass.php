<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class RemesaToMCModel extends Db{

  private $Permisos;
  
   public function OrigDest($Campos,$Conex){
    
	  $manifiesto_id = $this -> requestDataForQuery('manifiesto_id','integer');
	  $remesa_id     = $this -> requestDataForQuery('remesa_id','integer');
	  $origen_id     = $this -> requestDataForQuery('origen_id','integer');
	  $destino_id     = $this -> requestDataForQuery('destino_id','integer');
      $select_mc 	= "SELECT origen_id, destino_id FROM manifiesto WHERE manifiesto_id=$manifiesto_id ";	
      $result       = $this  -> DbFetchAll($select_mc,$Conex,true);
  
	 
	  $origen_mc    = $origen_id;
	  $destino_mc	= $destino_id;

      $select_rm 	= "SELECT origen_id, destino_id FROM remesa WHERE remesa_id=$remesa_id ";	
      $result       = $this  -> DbFetchAll($select_rm,$Conex,true);
	  $origen_rm    = $result[0]['origen_id'];	
	  $destino_rm	= $result[0]['destino_id'];	  
	   
	  if($origen_rm==$origen_mc && $destino_rm==$destino_mc){
		  $resp[0]=array(origen=>1,destino=>1);
	  }else	if($origen_rm==$origen_mc && $destino_rm!=$destino_mc){
		  $resp[0]=array(origen=>1,destino=>0);
	  }else	if($origen_rm!=$origen_mc && $destino_rm==$destino_mc){
		  $resp[0]=array(origen=>0,destino=>1);
	  }else{	
	  	  $resp[0]=array(destino=>0,origen=>0);
	  }
	return $resp;
  }

  public function Save($Campos,$Conex){
  
    $this -> Begin($Conex);
  
	  $manifiesto_id = $this -> requestDataForQuery('manifiesto_id','integer');
	  $remesa_id     = $this -> requestDataForQuery('remesa_id','integer');
	
      $insert = "INSERT INTO detalle_despacho (manifiesto_id,remesa_id)  VALUES ($manifiesto_id,$remesa_id)";	
      $this -> query($insert,$Conex);
	
	  $update = "UPDATE remesa SET estado = 'PC' WHERE remesa_id = $remesa_id";
      $this -> query($update,$Conex,true);		  
	  
	  $select        = "SELECT cliente_id FROM remesa WHERE remesa_id = $remesa_id";
   	  $result        = $this  -> DbFetchAll($select,$Conex,true);
	  $cliente_id    = $result[0]['cliente_id'];
	
	  $select        = "SELECT * FROM tiempos_clientes_remesas WHERE cliente_id = $cliente_id AND manifiesto_id = $manifiesto_id";
   	  $result        = $this  -> DbFetchAll($select,$Conex,true);	
	
	  if(!count($result) > 0){
	  
        $tiempos_clientes_remesas_id=$this->DbgetMaxConsecutive("tiempos_clientes_remesas","tiempos_clientes_remesas_id",$Conex,true,1);	
		
	    $insert = "INSERT INTO tiempos_clientes_remesas (tiempos_clientes_remesas_id,manifiesto_id,placa_id,cliente_id) 
		           VALUES ($tiempos_clientes_remesas_id,$manifiesto_id,(SELECT placa_id FROM manifiesto WHERE manifiesto_id 
				           = $manifiesto_id),$cliente_id)";
						   
        $this -> query($insert,$Conex,true);		  
	  
	  }	  
	  
	
	$this -> Commit($Conex);
	
	return $remesa_id;

  }

//// GRID ////
  public function getQueryRemesaToMCGrid($oficina_id){
	  
	   $manifiesto_id = $this -> requestDataForQuery('manifiesto_id','integer');
	
     $Query = "(SELECT 
				CONCAT('<input type=\"checkbox\" value=\"',r.remesa_id,'\" />') 
				AS link,r.numero_remesa	AS remesa,(SELECT CONCAT_WS(' ',razon_social,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido)
				FROM tercero WHERE tercero_id = (SELECT tercero_id FROM cliente c WHERE c.cliente_id = r.cliente_id)) AS cliente,(SELECT nombre 
				FROM ubicacion WHERE ubicacion_id=r.origen_id) AS origen,(SELECT nombre 
				FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino,r.descripcion_producto AS mercancia,r.fecha_remesa  AS fecha, r.fecha_recogida_ss AS fecha_recogida_ss,
				r.hora_recogida_ss AS hora_recogida_ss FROM 
				remesa r WHERE /*reportado_ministerio = 1 AND */ r.oficina_id = $oficina_id AND r.estado = 'PD' AND r.planilla = 1 AND r.desbloqueada = 0
				AND r.fecha_recogida_ss BETWEEN (DATE_SUB((SELECT fecha_entrega_mcia_mc FROM manifiesto WHERE manifiesto_id = $manifiesto_id), INTERVAL 15 DAY))AND (SELECT fecha_entrega_mcia_mc FROM manifiesto WHERE manifiesto_id = $manifiesto_id)) UNION (SELECT 
				CONCAT('<input type=\"checkbox\" value=\"',r.remesa_id,'\" />') 
				AS link,r.numero_remesa	AS remesa,(SELECT CONCAT_WS(' ',razon_social,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido)
				FROM tercero WHERE tercero_id = (SELECT tercero_id FROM cliente c WHERE c.cliente_id = r.cliente_id)) AS cliente,(SELECT nombre 
				FROM ubicacion WHERE ubicacion_id=r.origen_id) AS origen,(SELECT nombre 
				FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino,r.descripcion_producto AS mercancia,r.fecha_remesa  AS fecha, r.fecha_recogida_ss AS fecha_recogida_ss,
				r.hora_recogida_ss AS hora_recogida_ss FROM 
				remesa r WHERE /*reportado_ministerio = 1 AND  */ r.desbloqueada = 1 AND r.oficina_desbloquea_id = $oficina_id AND r.estado = 'PD' AND r.planilla = 1
				AND r.fecha_recogida_ss BETWEEN (DATE_SUB((SELECT fecha_entrega_mcia_mc FROM manifiesto WHERE manifiesto_id = $manifiesto_id), INTERVAL 15 DAY))AND (SELECT fecha_entrega_mcia_mc FROM manifiesto WHERE manifiesto_id = $manifiesto_id))";
   
     return $Query;
   }
   
}



?>