<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class CambioFechasModel extends Db{

  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  public function Update($Campos,$Conex){	
    
    $guia_id = $this -> requestDataForQuery('guia_id','integer');
	$oficina_id = $this -> requestDataForQuery('oficina_id','integer');
	$estado_mensajeria_id = $this -> requestDataForQuery('estado_mensajeria_id','text');
    $fecha_guia = $this -> requestDataForQuery('fecha_guia','date');
	$fecha_envio = $this -> requestDataForQuery('fecha_envio','date');
	$fecha_puente = $this -> requestDataForQuery('fecha_puente','date');
	$fecha_ofc_entrega = $this -> requestDataForQuery('fecha_ofc_entrega','date');
	$hora_ent = $this -> requestDataForQuery('hora_ent','time');
	$fecha_entrega = $this -> requestDataForQuery('fecha_entrega','date');
	$hora_entrega = $this -> requestDataForQuery('hora_entrega','time');
	$origen = $this -> requestDataForQuery('origen','text');
	$origen_id = $this -> requestDataForQuery('origen_id','integer');
	$destino = $this -> requestDataForQuery('destino','text');
	$destino_id = $this -> requestDataForQuery('destino_id','integer');
	$nombre_remitente = $this -> requestDataForQuery('nombre_remitente','text');
	$nombre_destinatario = $this -> requestDataForQuery('nombre_destinatario','text');
	$telefono_remitente = $this -> requestDataForQuery('telefono_remitente','text');
	$telefono_destinatario = $this -> requestDataForQuery('telefono_destinatario','text');
	$direccion_remitente = $this -> requestDataForQuery('direccion_remitente','text');
	$direccion_destinatario = $this -> requestDataForQuery('direccion_destinatario','text');
	
	$this -> Begin($Conex);	
	   
	 $select = "SELECT r.reexpedido_id,
	           (SELECT ep.entrega_parcial_id FROM entrega_parcial ep, detalle_entrega_parcial dep WHERE ep.entrega_parcial_id=dep.entrega_parcial_id AND dep.guia_id=g.guia_id ORDER BY dep.detalle_entrega_parcial_id DESC LIMIT 1) AS entrega_parcial_id,
			   (SELECT eo.entrega_oficina_id FROM entrega_oficina eo, detalle_entrega_oficina deo WHERE eo.entrega_oficina_id=deo.entrega_oficina_id AND deo.guia_id=g.guia_id LIMIT 1) AS entrega_oficina_id,
			   (SELECT e.entrega_id FROM entrega e, detalle_entrega de WHERE e.entrega_id=de.entrega_id AND de.guia_id=g.guia_id LIMIT 1) AS entrega_id
			   
	            FROM reexpedido r, detalle_despacho_guia dg, guia g 
				WHERE r.reexpedido_id=dg.reexpedido_id AND dg.guia_id=g.guia_id AND g.guia_id=$guia_id ORDER BY reexpedido_id LIMIT 1"; 
				
	 $result = $this -> DbFetchAll($select,$Conex,true);	
	 $reexpedido_id = $result[0]['reexpedido_id'];
	 $entrega_parcial_id = $result[0]['entrega_parcial_id'];
	 $entrega_oficina_id = $result[0]['entrega_oficina_id'];
	 $entrega_id = $result[0]['entrega_id'];
	
	 
    
	$update1 = "UPDATE guia 
	           SET fecha_guia=$fecha_guia, remitente=$nombre_remitente, destinatario=$nombre_destinatario, origen_id=$origen_id, 
			   destino_id=$destino_id, direccion_remitente=$direccion_remitente, direccion_destinatario=$direccion_destinatario,
			   telefono_remitente=$telefono_remitente, telefono_destinatario=$telefono_destinatario
			   WHERE guia_id=$guia_id";  
	   
	$this -> query($update1,$Conex,true); 
	
	if(count($reexpedido_id)>0){	
	
	$update = "UPDATE reexpedido SET fecha_rxp=$fecha_envio WHERE reexpedido_id=$reexpedido_id";   
	   
	$this -> query($update,$Conex,true); 
	
	}
	
	if($entrega_parcial_id != NULL){
	      $update = "UPDATE entrega_parcial SET fecha_ent=$fecha_puente WHERE entrega_parcial_id=$entrega_parcial_id";  
		  $this -> query($update,$Conex,true);
	}
	
	if($entrega_oficina_id != NULL){
	      $update = "UPDATE entrega_oficina SET fecha_ent=$fecha_ofc_entrega, hora_ent=$hora_ent WHERE entrega_oficina_id=$entrega_oficina_id"; 
	      $this -> query($update,$Conex,true);
	}
	
	if($entrega_id != NULL){
	      $update = "UPDATE entrega SET fecha_ent=$fecha_entrega, hora_ent=$hora_entrega WHERE entrega_id=$entrega_id"; 
	      $this -> query($update,$Conex,true);
	}
	
	
	$this -> Commit($Conex);
  }  


  public function UpdateEnc($Campos,$Conex){	
    
    $guia_encomienda_id = $this -> requestDataForQuery('guia_id','integer');
	$oficina_id = $this -> requestDataForQuery('oficina_id','integer');
	$estado_mensajeria_id = $this -> requestDataForQuery('estado_mensajeria_id','text');
    $fecha_guia = $this -> requestDataForQuery('fecha_guia','date');
	$fecha_envio = $this -> requestDataForQuery('fecha_envio','date');
	$fecha_puente = $this -> requestDataForQuery('fecha_puente','date');
	$fecha_ofc_entrega = $this -> requestDataForQuery('fecha_ofc_entrega','date');
	$hora_ent = $this -> requestDataForQuery('hora_ent','time');
	$fecha_entrega = $this -> requestDataForQuery('fecha_entrega','date');
	$hora_entrega = $this -> requestDataForQuery('hora_entrega','time');
	$origen = $this -> requestDataForQuery('origen','text');
	$origen_id = $this -> requestDataForQuery('origen_id','integer');
	$destino = $this -> requestDataForQuery('destino','text');
	$destino_id = $this -> requestDataForQuery('destino_id','integer');
	$nombre_remitente = $this -> requestDataForQuery('nombre_remitente','text');
	$nombre_destinatario = $this -> requestDataForQuery('nombre_destinatario','text');
	$telefono_remitente = $this -> requestDataForQuery('telefono_remitente','text');
	$telefono_destinatario = $this -> requestDataForQuery('telefono_destinatario','text');
	$direccion_remitente = $this -> requestDataForQuery('direccion_remitente','text');
	$direccion_destinatario = $this -> requestDataForQuery('direccion_destinatario','text');
	
	$this -> Begin($Conex);	
	   
	 $select = "SELECT r.reexpedido_id,
	           (SELECT ep.entrega_parcial_id FROM entrega_parcial ep, detalle_entrega_parcial dep WHERE ep.entrega_parcial_id=dep.entrega_parcial_id AND dep.guia_encomienda_id=g.guia_encomienda_id ORDER BY dep.detalle_entrega_parcial_id DESC LIMIT 1) AS entrega_parcial_id,
			   (SELECT eo.entrega_oficina_id FROM entrega_oficina eo, detalle_entrega_oficina deo WHERE eo.entrega_oficina_id=deo.entrega_oficina_id AND deo.guia_encomienda_id=g.guia_encomienda_id LIMIT 1) AS entrega_oficina_id,
			   (SELECT e.entrega_id FROM entrega e, detalle_entrega de WHERE e.entrega_id=de.entrega_id AND de.guia_encomienda_id=g.guia_encomienda_id) AS entrega_id
			   
	            FROM reexpedido r, detalle_despacho_guia dg, guia_encomienda g 
				WHERE r.reexpedido_id=dg.reexpedido_id AND dg.guia_encomienda_id=g.guia_encomienda_id AND g.guia_encomienda_id=$guia_encomienda_id ORDER BY reexpedido_id LIMIT 1"; 
				
	 $result = $this -> DbFetchAll($select,$Conex,true);	
	 $reexpedido_id = $result[0]['reexpedido_id'];
	 $entrega_parcial_id = $result[0]['entrega_parcial_id'];
	 $entrega_oficina_id = $result[0]['entrega_oficina_id'];
	 $entrega_id = $result[0]['entrega_id'];
	
	 
    
	$update1 = "UPDATE guia_encomienda 
	           SET fecha_guia=$fecha_guia, remitente=$nombre_remitente, destinatario=$nombre_destinatario, origen_id=$origen_id, 
			   destino_id=$destino_id, direccion_remitente=$direccion_remitente, direccion_destinatario=$direccion_destinatario,
			   telefono_remitente=$telefono_remitente, telefono_destinatario=$telefono_destinatario
			   WHERE guia_encomienda_id=$guia_encomienda_id";  
	   
	$this -> query($update1,$Conex,true); 
	
	if(count($reexpedido_id)>0){	
	
	$update = "UPDATE reexpedido SET fecha_rxp=$fecha_envio WHERE reexpedido_id=$reexpedido_id";   
	   
	$this -> query($update,$Conex,true); 
	
	}
	
	if($entrega_parcial_id != NULL){
	      $update = "UPDATE entrega_parcial SET fecha_ent=$fecha_puente WHERE entrega_parcial_id=$entrega_parcial_id";  
		  $this -> query($update,$Conex,true);
	}
	
	if($entrega_oficina_id != NULL){
	      $update = "UPDATE entrega_oficina SET fecha_ent=$fecha_ofc_entrega, hora_ent=$hora_ent WHERE entrega_oficina_id=$entrega_oficina_id"; 
	      $this -> query($update,$Conex,true);
	}
	
	if($entrega_id != NULL){
	      $update = "UPDATE entrega SET fecha_ent=$fecha_entrega, hora_ent=$hora_entrega WHERE entrega_id=$entrega_id"; 
	      $this -> query($update,$Conex,true);
	}
	
	
	$this -> Commit($Conex);
  }  

//LISTA MENU
  
  public function getGuiaNumero($Conex,$oficina_id){ 
     $select = "SELECT guia_id AS value,numero_guia AS text,(SELECT MAX(guia_id) FROM guia WHERE oficina_id = $oficina_id) AS selected 
	 FROM guia WHERE oficina_id = $oficina_id ORDER BY numero_guia ASC";
	 $result = $this -> DbFetchAll($select,$Conex);	
	 return $result;    
  }

  public function chequear($oficina_id,$Conex){ 
     $select = "SELECT o.*,
				(SELECT t.tipo_identificacion_id FROM  tercero t, cliente c WHERE c.cliente_id=o.cliente_id AND t.tercero_id=c.tercero_id)  AS tipo_identificacion_remitente_id,
	   			(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t, cliente c WHERE c.cliente_id=o.cliente_id AND t.tercero_id=c.tercero_id) AS remitente,
				(SELECT t.numero_identificacion FROM tercero t, cliente c WHERE c.cliente_id=o.cliente_id AND t.tercero_id=c.tercero_id) AS doc_remitente,
				IF(o.cliente_id>0,o.direccion, (SELECT t.direccion FROM tercero t, cliente c  WHERE c.cliente_id=o.cliente_id AND t.tercero_id=c.tercero_id) ) AS direccion_remitente,
				IF(o.cliente_id>0,o.telefono, (SELECT t.telefono FROM tercero t, cliente c  WHERE c.cliente_id=o.cliente_id AND t.tercero_id=c.tercero_id) ) AS telefono_remitente,
				IF(o.cliente_id>0,o.ubicacion_id, (SELECT t.ubicacion_id FROM tercero t, cliente c  WHERE c.cliente_id=o.cliente_id AND t.tercero_id=c.tercero_id) ) AS origen_id,				  				
			    IF(o.cliente_id>0,(SELECT nombre FROM ubicacion WHERE ubicacion_id=o.ubicacion_id), (SELECT (SELECT nombre FROM ubicacion WHERE ubicacion_id=t.ubicacion_id) FROM tercero t, cliente c  WHERE c.cliente_id=o.cliente_id AND t.tercero_id=c.tercero_id) ) AS origen			  

	 FROM oficina o WHERE o.oficina_id = $oficina_id ";
	 $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	 return $result;    
  }  

 



//BUSQUEDA
  public function selectGuia($Conex){  
    $guia_id  = $this -> requestDataForQuery('guia_id','integer');
	$dataGuia = array();    				
    $select = "SELECT r.guia_id,CONCAT_WS('',r.prefijo,r.numero_guia) AS numero_guia, r.estado_mensajeria_id, r.fecha_guia,
	          (SELECT re.fecha_rxp FROM reexpedido re, detalle_despacho_guia dg WHERE re.reexpedido_id=dg.reexpedido_id AND dg.guia_id=r.guia_id ORDER BY dg.detalle_despacho_guia_id DESC LIMIT 1) AS fecha_envio,
	          (SELECT ep.fecha_ent FROM entrega_parcial ep, detalle_entrega_parcial dep WHERE ep.entrega_parcial_id=dep.entrega_parcial_id AND dep.guia_id=r.guia_id ORDER BY dep.detalle_entrega_parcial_id DESC LIMIT 1) AS fecha_puente,
			  (SELECT eo.fecha_ent FROM entrega_oficina eo, detalle_entrega_oficina deo WHERE eo.entrega_oficina_id=deo.entrega_oficina_id AND deo.guia_id=r.guia_id ORDER BY deo.entrega_oficina_id DESC LIMIT 1) AS fecha_ofc_entrega,
			  (SELECT eo.hora_ent FROM entrega_oficina eo, detalle_entrega_oficina deo WHERE eo.entrega_oficina_id=deo.entrega_oficina_id AND deo.guia_id=r.guia_id ORDER BY deo.entrega_oficina_id DESC LIMIT 1) AS hora_ent,
			  (SELECT e.fecha_ent FROM entrega e, detalle_entrega de WHERE e.entrega_id=de.entrega_id AND de.guia_id=r.guia_id ORDER BY de.detalle_entrega_id DESC LIMIT 1) AS fecha_entrega,
			  (SELECT e.hora_ent FROM entrega e, detalle_entrega de WHERE e.entrega_id=de.entrega_id AND de.guia_id=r.guia_id ORDER BY de.detalle_entrega_id DESC LIMIT 1) AS hora_entrega,
			   r.remitente AS nombre_remitente,
			   r.destinatario AS nombre_destinatario,
			  (SELECT u.nombre FROM ubicacion u WHERE u.ubicacion_id=r.origen_id)AS origen,
			   r.origen_id,
			   r.destino_id,
			  (SELECT u.nombre FROM ubicacion u WHERE u.ubicacion_id=r.destino_id)AS destino,
			   r.direccion_remitente AS direccion_remitente,
			   r.direccion_destinatario AS direccion_destinatario,
			   r.telefono_remitente AS telefono_remitente,
			   r.telefono_destinatario AS telefono_destinatario
	           FROM guia r WHERE r.guia_id = $guia_id";	
			//    echo($select);
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false); 
	$dataGuia[0]['guia'] = $result;	
	return $dataGuia;
  }
    
  public function selectGuiaEncomienda($Conex){  
    $guia_id  = $this -> requestDataForQuery('guia_id','integer');
	$dataGuia = array();    				
    $select = "SELECT r.guia_encomienda_id AS guia_id,CONCAT_WS('',r.prefijo,r.numero_guia) AS numero_guia, r.estado_mensajeria_id, r.fecha_guia,
	          (SELECT re.fecha_rxp FROM reexpedido re, detalle_despacho_guia dg WHERE re.reexpedido_id=dg.reexpedido_id AND dg.guia_encomienda_id=r.guia_encomienda_id ORDER BY dg.detalle_despacho_guia_id DESC LIMIT 1) AS fecha_envio,
	          (SELECT ep.fecha_ent FROM entrega_parcial ep, detalle_entrega_parcial dep WHERE ep.entrega_parcial_id=dep.entrega_parcial_id AND dep.guia_encomienda_id=r.guia_encomienda_id ORDER BY dep.detalle_entrega_parcial_id DESC LIMIT 1) AS fecha_puente,
			  (SELECT eo.fecha_ent FROM entrega_oficina eo, detalle_entrega_oficina deo WHERE eo.entrega_oficina_id=deo.entrega_oficina_id AND deo.guia_encomienda_id=r.guia_encomienda_id) AS fecha_ofc_entrega,
			  (SELECT eo.hora_ent FROM entrega_oficina eo, detalle_entrega_oficina deo WHERE eo.entrega_oficina_id=deo.entrega_oficina_id AND deo.guia_encomienda_id=r.guia_encomienda_id) AS hora_ent,
			  (SELECT e.fecha_ent FROM entrega e, detalle_entrega de WHERE e.entrega_id=de.entrega_id AND de.guia_encomienda_id=r.guia_encomienda_id) AS fecha_entrega,
			  (SELECT e.hora_ent FROM entrega e, detalle_entrega de WHERE e.entrega_id=de.entrega_id AND de.guia_encomienda_id=r.guia_encomienda_id) AS hora_entrega,
			   r.remitente AS nombre_remitente,
			   r.destinatario AS nombre_destinatario,
			  (SELECT u.nombre FROM ubicacion u WHERE u.ubicacion_id=r.origen_id)AS origen,
			   r.origen_id,
			   r.destino_id,
			  (SELECT u.nombre FROM ubicacion u WHERE u.ubicacion_id=r.destino_id)AS destino,
			   r.direccion_remitente AS direccion_remitente,
			   r.direccion_destinatario AS direccion_destinatario,
			   r.telefono_remitente AS telefono_remitente,
			   r.telefono_destinatario AS telefono_destinatario
	           FROM guia_encomienda r WHERE r.guia_encomienda_id = $guia_id";	
			   //echo $select;
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false); 
	$dataGuia[0]['guia'] = $result;	
	return $dataGuia;
  }
    
  
  public function GetEstadoMensajeria($Conex){
	$result = $this -> DbFetchAll("SELECT estado_mensajeria_id AS value,nombre_estado AS text FROM estado_mensajeria ORDER BY nombre_estado ASC",$Conex,false);
    return $result;
  }   

	
}

?>