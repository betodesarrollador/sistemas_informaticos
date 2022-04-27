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

  /*public function Anular($guia_id,$Conex){
  	$sql ="UPDATE guia SET estado_mensajeria_id = '8' WHERE guia_id = $guia_id";
  	$this -> query($sql,$Conex);
  }*/
  
 /* public function Save($Campos,$oficina_id,$Conex){  	
	$guia_id = $this -> DbgetMaxConsecutive("guia","guia_id",$Conex,false,1);
	$this -> assignValRequest('guia_id',$guia_id);	
	$this -> assignValRequest('oficina_id',$oficina_id);	
	$this -> assignValRequest('estado_mensajeria_id',1);
	$select = "SELECT MAX(numero_guia) AS numero_guia FROM guia WHERE oficina_id = $oficina_id  AND manual=0 AND crm=0";
	$result = $this -> DbFetchAll($select,$Conex,true);	
	$numero_guia = $result[0]['numero_guia'];
	$peso   = $_REQUEST['peso'];	

	if($peso>5000){
		exit ('El Peso de la Guia debe ser Inferior a 5.000 Gramos');	
	}
	
	
	if(is_numeric($numero_guia)){	
	    $select = "SELECT rango_guia_fin FROM rango_guia WHERE oficina_id = $oficina_id AND estado = 'A'";
	    $result = $this -> DbFetchAll($select,$Conex,true);
		$rango_guia_fin = $result[0]['rango_guia_fin'];	
        $numero_guia += 1;		
		if($numero_guia > $rango_guia_fin){
		  print 'El numero de Guia para esta oficina a superado el limite definido<br>debe actualizar el rango de Guias asignado para esta oficina !!!';
		  return false;
		}
		
	}else{	
	    $select = "SELECT rango_guia_ini FROM rango_guia WHERE oficina_id = $oficina_id AND estado = 'A'";
	    $result = $this -> DbFetchAll($select,$Conex,true);
		$rango_guia_ini = $result[0]['rango_guia_ini'];		
		if(is_numeric($rango_guia_ini)){		
		  $numero_guia = $rango_guia_ini;
		}else{		
		    print 'Debe Definir un rango de Guias para la oficina!!!';
		    return false;		
		  }	
	  }			
	if($_REQUEST['tipo_servicio_mensajeria_id']!=2){
		$origen_id=$_REQUEST['origen_id'];
		$destino_id=$_REQUEST['destino_id'];
	
		if($origen_id==$destino_id){ 
			$tipo_envio_id=2;
		}else{
			$tipo_envio_id=$this -> getTipoEnvio1($destino_id,$Conex);
		}
		$tipo_envio_id=$tipo_envio_id>0 ? $tipo_envio_id : 'NULL';
		$this -> assignValRequest('tipo_envio_id',$tipo_envio_id);	
	}
	$this -> assignValRequest('numero_guia',$numero_guia);	
	$this -> Begin($Conex);	
		$this -> DbInsertTable("guia",$Campos,$Conex,true,false);
		if($this -> GetNumError() > 0){
			return false;
		}else{		
		    if($this -> GetNumError() > 0){
			  return false;

		   }			
		}
	
	$this -> Commit($Conex);	
	return $numero_guia;  
  }*/
  
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
			   (SELECT eo.entrega_oficina_id FROM entrega_oficina eo, detalle_entrega_oficina deo WHERE eo.entrega_oficina_id=deo.entrega_oficina_id AND deo.guia_id=g.guia_id) AS entrega_oficina_id,
			   (SELECT e.entrega_id FROM entrega e, detalle_entrega de WHERE e.entrega_id=de.entrega_id AND de.guia_id=g.guia_id) AS entrega_id
			   
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

  /*public function Delete($Campos,$Conex){	  
	$this -> Begin($Conex);	
		$guia_id  = $this -> requestDataForQuery('guia_id','integer');		
//		$delete     = "DELETE FROM contacto_guia WHERE guia_id = $guia_id"; 
//		$this -> query($delete,$Conex);		
		$delete     = "DELETE FROM detalle_guia WHERE guia_id = $guia_id"; 
		$this -> query($delete,$Conex);		
		$this -> DbDeleteTable("guia",$Campos,$Conex,true,false);		
	$this -> Commit($Conex);
  }*/
  
	/*public function cancellation($guia_id,$causal_anulacion_id,$observacion_anulacion,$usuario_anulo_id,$Conex){
		$this -> Begin($Conex);
			$update = "UPDATE guia SET estado_mensajeria_id = '8',causal_anulacion_id = $causal_anulacion_id,observacion_anulacion = $observacion_anulacion,
			fecha_anulacion = NOW(),usuario_anulo_id = $usuario_anulo_id WHERE guia_id = $guia_id";
			$this -> query($update,$Conex,true);
			// echo $update;
		$this -> Commit($Conex);
	}*/

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

 

 /* public function getCalcularTarifaCliente($cliente_id,$tipo_servicio_mensajeria_id,$tabla,$tipo_envio_id,$anio,$Conex,$oficina_id){ 
  	
     $select = "SELECT * FROM tarifas_mensajeria_cliente
	 WHERE tipo_envio_id = $tipo_envio_id AND tipo_servicio_mensajeria_id = $tipo_servicio_mensajeria_id AND cliente_id=$cliente_id
	 AND periodo=(SELECT periodo_contable_id FROM periodo_contable WHERE anio=$anio LIMIT 1)"; 
	 $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	 return $result;    
  }*/  

 /* public function getCalcularTarifa($tipo_servicio_mensajeria_id,$tabla,$tipo_envio_id,$anio,$Conex,$oficina_id){ 
  	
     $select = "SELECT * FROM tarifas_mensajeria
	 WHERE tipo_envio_id = $tipo_envio_id AND tipo_servicio_mensajeria_id = $tipo_servicio_mensajeria_id 
	 AND periodo=(SELECT periodo_contable_id FROM periodo_contable WHERE anio=$anio LIMIT 1)";
	 $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false); 
	 return $result;    
  }  

  public function getTipoEnvio1($destino_id,$Conex){ 
     $select = "SELECT tipo_envio_id FROM ubicacion WHERE ubicacion_id = $destino_id";
	 $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	 return $result[0]['tipo_envio_id'];    
  } */ 


//BUSQUEDA
  public function selectGuia($Conex){  
    $guia_id  = $this -> requestDataForQuery('guia_id','integer');
	$dataGuia = array();    				
    $select = "SELECT r.guia_id,r.numero_guia, r.estado_mensajeria_id, r.fecha_guia,
	          (SELECT re.fecha_rxp FROM reexpedido re, detalle_despacho_guia dg WHERE re.reexpedido_id=dg.reexpedido_id AND dg.guia_id=r.guia_id ORDER BY dg.detalle_despacho_guia_id DESC LIMIT 1) AS fecha_envio,
	          (SELECT ep.fecha_ent FROM entrega_parcial ep, detalle_entrega_parcial dep WHERE ep.entrega_parcial_id=dep.entrega_parcial_id AND dep.guia_id=r.guia_id ORDER BY dep.detalle_entrega_parcial_id DESC LIMIT 1) AS fecha_puente,
			  (SELECT eo.fecha_ent FROM entrega_oficina eo, detalle_entrega_oficina deo WHERE eo.entrega_oficina_id=deo.entrega_oficina_id AND deo.guia_id=r.guia_id) AS fecha_ofc_entrega,
			  (SELECT eo.hora_ent FROM entrega_oficina eo, detalle_entrega_oficina deo WHERE eo.entrega_oficina_id=deo.entrega_oficina_id AND deo.guia_id=r.guia_id) AS hora_ent,
			  (SELECT e.fecha_ent FROM entrega e, detalle_entrega de WHERE e.entrega_id=de.entrega_id AND de.guia_id=r.guia_id) AS fecha_entrega,
			  (SELECT e.hora_ent FROM entrega e, detalle_entrega de WHERE e.entrega_id=de.entrega_id AND de.guia_id=r.guia_id) AS hora_entrega,
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
			   
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false); 
	$dataGuia[0]['guia'] = $result;	
	return $dataGuia;
  }
    
//////////////////////////////////////////
  
  public function GetEstadoMensajeria($Conex){
	$result = $this -> DbFetchAll("SELECT estado_mensajeria_id AS value,nombre_estado AS text FROM estado_mensajeria ORDER BY nombre_estado ASC",$Conex,false);
    return $result;
  }   

    /*public function GetMotivoDevolucion($Conex){
	$result = $this -> DbFetchAll("SELECT motivo_devolucion_id AS value,nombre AS text FROM motivo_devolucion ORDER BY nombre ASC",$Conex,false);
    return $result;
  } 
  
   public function getCausalesAnulacion($Conex){		
		$select = "SELECT causal_anulacion_id AS value,nombre AS text FROM causal_anulacion ORDER BY nombre";
		$result = $this -> DbFetchAll($select,$Conex);		
		return $result;				
    } */ 
  
//////////////////////////////////////////   
	
}

?>