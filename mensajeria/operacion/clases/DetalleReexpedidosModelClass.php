<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetalleReexpedidosModel extends Db{

  private $Permisos;  

  public function deleteDetalleReexpedido($Campos,$Conex){  
	  
    $this -> Begin($Conex);   
  	$detalle_despacho_guia_id = $this -> requestDataForQuery('detalle_despacho_guia_id','integer');     
	
	$update = "UPDATE guia SET estado_mensajeria_id = 1 WHERE guia_id = (SELECT guia_id FROM detalle_despacho_guia WHERE detalle_despacho_guia_id 
	=  $detalle_despacho_guia_id)";	
	$result = $this -> query($update,$Conex,true);	
	
	$delete = "DELETE FROM detalle_despacho_guia WHERE detalle_despacho_guia_id = $detalle_despacho_guia_id";	
	$result = $this -> query($delete,$Conex,true);	
	
	$this -> Commit($Conex);	  
  }
  
    
  public function getDetallesReexpedido($Conex){
  
	$reexpedido_id = $this -> requestDataForQuery('reexpedido_id','integer');
	
	if(is_numeric($reexpedido_id)){
	
		$select  = "SELECT d.detalle_despacho_guia_id,d.reexpedido_id,
		r.numero_guia, r.valor_flete,
		(SELECT CONCAT_WS(' ',primer_apellido,segundo_apellido,primer_nombre,segundo_nombre,razon_social) FROM tercero WHERE tercero_id = (SELECT tercero_id FROM cliente WHERE     cliente_id = r.cliente_id)) AS cliente,
		(SELECT nombre FROM ubicacion WHERE ubicacion_id = r.origen_id) AS origen,(SELECT nombre FROM ubicacion WHERE ubicacion_id = r.destino_id) AS destino,
		r.fecha_guia as fecha_rm,r.descripcion_producto as descrip_produc_rm,r.cantidad as cantidad_rm,r.peso as peso_rm,
		r.peso_volumen as peso_volumen_rm,r.valor as valor_rm,r.remitente as remitente_rm,r.direccion_remitente as dir_remi_rm,r.telefono_remitente as tel_remi_rm,r.destinatario as 
		destinatario_rm,r.doc_destinatario as doc_destinatario_rm,r.direccion_destinatario as dir_dest_rm,r.telefono_destinatario as tel_dest_rm,
		r.observaciones as obser_rm, r.estado_mensajeria_id, m.estado as estado_man 
		FROM reexpedido m, detalle_despacho_guia d, guia r 
		WHERE m.reexpedido_id = $reexpedido_id AND m.reexpedido_id = d.reexpedido_id AND d.guia_id=r.guia_id ORDER BY r.numero_guia ASC";
	    //echo $select;
	  	$result = $this -> DbFetchAll($select,$Conex);
	  
	}else{
   	    $result = array();
	  }
	return $result;
  }
  
}

?>