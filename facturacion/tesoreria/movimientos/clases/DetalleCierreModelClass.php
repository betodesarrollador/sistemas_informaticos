<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetalleCierreModel extends Db{

  private $Permisos;
  

  public function deleteDetalleManifiesto($Campos,$Conex){  
	  
    $this -> Begin($Conex);
   
  	$detalle_cierre_contado_id = $this -> requestDataForQuery('detalle_cierre_contado_id','integer');     

	$select  = "SELECT 
		(SELECT COUNT(*) AS mov  
		FROM cierre_contado c,detalle_cierre_contado dd 
		WHERE dd.remesa_id=d.remesa_id AND dd.detalle_cierre_contado_id = $detalle_cierre_contado_id 
		AND c.cierre_contado_id=dd.cierre_contado_id AND c.estado!='A' ) AS mov
	FROM detalle_cierre_contado d
	WHERE d.detalle_cierre_contado_id = $detalle_cierre_contado_id ";
	$result = $this -> DbFetchAll($select,$Conex);

	if(is_numeric($resul[0]['mov']) && $resul[0]['mov']>0 ){
		exit('La Remesa que intenta liberar de este Cierre,  esta asociado en otro Cierre Activo!!');	
	}else{
		$update = "UPDATE remesa SET cierre = 0 WHERE remesa_id = (SELECT remesa_id FROM detalle_cierre_contado 
		WHERE detalle_cierre_contado_id 	=  $detalle_cierre_contado_id)";
		$result = $this -> query($update,$Conex,true);	
		
		$delete = "DELETE FROM detalle_cierre_contado WHERE detalle_cierre_contado_id = $detalle_cierre_contado_id";
		$result = $this -> query($delete,$Conex,true);	
		
	}
	$this -> Commit($Conex);
	  
  }
  
  
  
  public function getDetallesManifiesto($Conex){
  
	$cierre_contado_id = $this -> requestDataForQuery('cierre_contado_id','integer');
	
	if(is_numeric($cierre_contado_id)){
	
		$select  = "SELECT d.detalle_cierre_contado_id,d.cierre_contado_id,r.remesa_id,
		IF(r.paqueteo=2,'CONTADO','CONTRAENTREGA') AS tipo,
		(SELECT nombre FROM oficina WHERE oficina_id=r.oficina_id) AS oficina,
		r.orden_despacho,CONCAT_WS('-',r.prefijo_tipo,r.prefijo_oficina,r.numero_remesa) AS numero_remesa,(SELECT CONCAT_WS(' ',primer_apellido,segundo_apellido,primer_nombre,segundo_nombre,razon_social) 
		FROM tercero WHERE tercero_id = (SELECT tercero_id FROM cliente WHERE cliente_id = r.cliente_id)) AS cliente,(SELECT nombre 
		FROM ubicacion WHERE ubicacion_id = r.origen_id) AS origen,(SELECT nombre FROM ubicacion WHERE ubicacion_id = r.destino_id) 
		AS destino,(SELECT e.empaque FROM empaque e WHERE  empaque_id = r.empaque_id) AS empaque,r.descripcion_producto AS producto,
		(SELECT n.naturaleza FROM naturaleza n WHERE naturaleza_id = r.naturaleza_id) 
		AS naturaleza,(SELECT m.medida FROM medida m WHERE medida_id = r.medida_id) AS medida,r.fecha_remesa 
		as fecha_rm,r.descripcion_producto as descrip_produc_rm,r.cantidad as cantidad_rm,r.peso as peso_neto_rm,r.peso_volumen 
		as peso_volumen_rm,r.valor as valor_declarado_rm,r.remitente as remitente_rm,'' as dependencia_remi_rm,r.doc_remitente 
		as doc_remitente_rm,r.direccion_remitente as dir_remi_rm,r.telefono_remitente as tel_remi_rm,r.destinatario as 
		destinatario_rm,r.doc_destinatario as doc_destinatario_rm,r.direccion_destinatario as dir_dest_rm 	,r.telefono_destinatario as tel_dest_rm,
		'' as obser_rm, m.estado,
		(SELECT valor_liquida FROM detalle_remesa_puc WHERE remesa_id=r.remesa_id AND contra=1 LIMIT 1) as valor_cobrado
		FROM cierre_contado m,detalle_cierre_contado d, remesa r 
		WHERE m.cierre_contado_id = $cierre_contado_id AND m.cierre_contado_id = d.cierre_contado_id 
		AND d.remesa_id=r.remesa_id ORDER BY r.numero_remesa ASC";

	  	$result = $this -> DbFetchAll($select,$Conex);
	  
	}else{
   	    $result = array();
	  }
	return $result;
  }
 

//BUSQUEDA
   
}



?>