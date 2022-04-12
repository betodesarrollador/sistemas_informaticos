<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetalleDespachosUrbanosModel extends Db{

  private $Permisos;
  

  public function deleteDetalleDespacho($Campos,$Conex){  
	  
    $this -> Begin($Conex);
   
  	$detalle_despacho_id = $this -> requestDataForQuery('detalle_despacho_id','integer');     
	
	$update = "UPDATE remesa SET estado = 'PD' WHERE remesa_id = (SELECT remesa_id FROM detalle_despacho WHERE detalle_despacho_id 
	=  $detalle_despacho_id)";
	
	$result = $this -> query($update,$Conex,true);	
	
	$delete = "DELETE FROM detalle_despacho WHERE detalle_despacho_id = $detalle_despacho_id";
	
	$result = $this -> query($delete,$Conex,true);	
	
	$this -> Commit($Conex);
	  
  }
  
  
  
  public function getDetallesDespacho($Conex){
  
	$despachos_urbanos_id = $this -> requestDataForQuery('despachos_urbanos_id','integer');
	
	if(is_numeric($despachos_urbanos_id)){

		$select  = "SELECT d.detalle_despacho_id,d.despachos_urbanos_id,r.remesa_id,(SELECT t.tipo_remesa FROM tipo_remesa t WHERE 
		tipo_remesa_id = r.tipo_remesa_id) 
		tipo_remesa,r.numero_remesa,(SELECT CONCAT_WS(' ',primer_apellido,segundo_apellido,primer_nombre,segundo_nombre,razon_social) 
		FROM tercero WHERE tercero_id = (SELECT tercero_id FROM cliente WHERE cliente_id = r.cliente_id)) AS cliente,(SELECT nombre 
		FROM ubicacion WHERE ubicacion_id = r.origen_id) AS origen,(SELECT nombre FROM ubicacion WHERE ubicacion_id = r.destino_id) 
		AS destino,(SELECT e.empaque FROM empaque e WHERE  empaque_id = r.empaque_id) AS empaque,r.descripcion_producto AS producto,
		(SELECT n.naturaleza FROM naturaleza n WHERE naturaleza_id = r.naturaleza_id) 
		AS naturaleza,(SELECT m.medida FROM medida m WHERE medida_id = r.medida_id) AS medida,r.fecha_remesa 
		as fecha_rm 	,r.descripcion_producto as descrip_produc_rm,r.cantidad as cantidad_rm,r.peso as peso_neto_rm,r.peso_volumen 
		as peso_volumen_rm,r.valor as valor_declarado_rm,r.remitente as remitente_rm,'' as dependencia_remi_rm,r.doc_remitente 
		as doc_remitente_rm,r.direccion_remitente 
		as dir_remi_rm,r.telefono_remitente as tel_remi_rm,r.destinatario as destinatario_rm,r.doc_destinatario 
		as doc_destinatario_rm,r.direccion_destinatario as dir_dest_rm 	,r.telefono_destinatario as tel_dest_rm,'' as obser_rm, 
		(SELECT estado FROM despachos_urbanos WHERE despachos_urbanos_id=d.despachos_urbanos_id) AS estado
		FROM detalle_despacho d, remesa r WHERE d.despachos_urbanos_id = $despachos_urbanos_id 
					AND d.remesa_id=r.remesa_id ORDER BY r.numero_remesa ASC";

	  	$result = $this -> DbFetchAll($select,$Conex);
	  
	}else{
   	    $result = array();
	  }
	return $result;
  }
}



?>