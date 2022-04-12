<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class RemesasModel extends Db{

  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  public function Save($Campos,$oficina_id,$Conex){  	
	$guia_id = $this -> DbgetMaxConsecutive("guia","guia_id",$Conex,false,1);
	$this -> assignValRequest('guia_id',$guia_id);	
	$this -> assignValRequest('oficina_id',$oficina_id);	
	$this -> assignValRequest('estado','PD');	
	$select = "SELECT MAX(numero_guia) AS numero_guia FROM remesa WHERE oficina_id = $oficina_id";
	$result = $this -> DbFetchAll($select,$Conex,true);	
	$numero_guia = $result[0]['numero_guia'];
	
	if(is_numeric($numero_guia)){	
	    $select           = "SELECT rango_guia_fin FROM rango_guia WHERE oficina_id = $oficina_id AND estado = 'A'";
	    $result           = $this -> DbFetchAll($select,$Conex,true);
		$rango_guia_fin = $result[0]['rango_guia_fin'];	
        $numero_guia += 1;		
		if($numero_guia > $rango_guia_fin){
		  print 'El numero de Guia para esta oficina a superado el limite definido<br>debe actualizar el rango de Guias asignado para esta oficina !!!';
		  return false;
		}
		
	}else{	
	    $select           = "SELECT rango_guia_ini FROM rango_guia WHERE oficina_id = $oficina_id AND estado = 'A'";
	    $result           = $this -> DbFetchAll($select,$Conex,true);
		$rango_guia_ini = $result[0]['rango_guia_ini'];		
		if(is_numeric($rango_guia_ini)){		
		  $numero_guia = $rango_guia_ini;
		}else{		
		    print 'Debe Definir un rango de Guias para la oficina!!!';
		    return false;		
		  }	
	  }			
	
	$this -> assignValRequest('numero_guia',$numero_guia);	
	$this -> Begin($Conex);	
		$this -> DbInsertTable("guia",$Campos,$Conex,true,false);
		if($this -> GetNumError() > 0){
			return false;
		}else{		
		    if($this -> GetNumError() > 0){
			  return false;
			}else{			
			  if(is_array($_REQUEST['detalle_guia'])){
                for($i = 0; $i < count($_REQUEST['detalle_guia']); $i++){				
				  $detalle_guia_id            = $this -> DbgetMaxConsecutive("detalle_guia","detalle_guia_id",$Conex,false,1);				
				  $detalle_ss_id                = $_REQUEST['detalle_guia'][$i]['detalle_ss_id'];				  
				  $item                         = $_REQUEST['detalle_guia'][$i]['item'];
				  $referencia_producto          = $_REQUEST['detalle_guia'][$i]['referencia_producto'];
				  $descripcion_producto         = $_REQUEST['detalle_guia'][$i]['descripcion_producto_detalle'];
				  $cantidad                     = str_replace(",",".",str_replace(".","",$_REQUEST['detalle_guia'][$i]['cantidad']));
				  $peso                         = str_replace(",",".",str_replace(".","",$_REQUEST['detalle_guia'][$i]['peso']));
				  $valor                        = str_replace(",",".",str_replace(".","",$_REQUEST['detalle_guia'][$i]['valor']));
				  $peso_volumen                 = str_replace(",",".",str_replace(".","",$_REQUEST['detalle_guia'][$i]['peso_volumen']));
				  $guia_cliente                 = $_REQUEST['detalle_guia'][$i]['guia_cliente'];
				  $observaciones                = $_REQUEST['detalle_guia'][$i]['observaciones'];				  
                  $detalle_ss_id                = is_numeric($detalle_ss_id) ? $detalle_ss_id : 'NULL';				  
				  if(!is_numeric($cantidad))     $cantidad     = 0;                    
				  if(!is_numeric($peso))         $peso         = 0;                    
				  if(!is_numeric($valor))        $valor        = 0;                    				  				  
				  if(!is_numeric($peso_volumen)) $peso_volumen = 0;				  
                  if(strlen(trim($referencia_producto)) > 0){                  
				     $insert = "INSERT INTO detalle_guia  
					 (detalle_guia_id,guia_id,detalle_ss_id,item,referencia_producto,descripcion_producto,peso_volumen,
				     peso,cantidad,valor,guia_cliente,observaciones) 
					 VALUES ($detalle_guia_id,$guia_id,$detalle_ss_id,$item,'$referencia_producto',
				     '$descripcion_producto',$peso_volumen,$peso,$cantidad,$valor,'$guia_cliente','$observaciones');";				  
				     $this -> query($insert,$Conex,true);					
				     if($this -> GetNumError() > 0){
					  return false;
				     }else{				  
						if(is_numeric($detalle_ss_id)){												   
						   $update = "UPDATE detalle_solicitud_servicio SET estado = 'R' WHERE detalle_ss_id = $detalle_ss_id";
						   $result = $this -> query($update,$Conex,true);						   
						   if($this -> GetNumError() > 0){
							 return false;
						   }						
						 }						
				      }					
				   }			  
			    }				
				
				$contactos = explode(",",$_REQUEST['contacto_id']);			
				for($i = 0; $i < count($contactos) && $contactos[$i] != 'NULL'; $i++){				
					$contacto_id = $contactos[$i];				
					$insert = "INSERT INTO contacto_guia (contacto_id,guia_id) VALUES ($contacto_id,$guia_id)";				
					$this -> query($insert,$Conex,true);
					 if($this -> GetNumError() > 0){
					   return false;
					 }					 
				 }				  
			  }				
		   }			
		}
	
	$this -> Commit($Conex);	
	return $numero_guia;  }
  public function Update($Campos,$Conex){	
	$this -> Begin($Conex);	
	    $guia_id = $_REQUEST['guia_id'];	
		$this -> DbUpdateTable("guia",$Campos,$Conex,true,false);
		if($this -> GetNumError() > 0){
			return false;
		}else{		   
		    if($this -> GetNumError() > 0){
			  return false;
			}else{			
			  if(is_array($_REQUEST['detalle_guia'])){			  
			    $detalles_guia_id = null;
                for($i = 0; $i < count($_REQUEST['detalle_guia']); $i++){				
				  $detalle_guia_id  = $_REQUEST['detalle_guia'][$i]['detalle_guia_id'];	
				  if(is_numeric(detalle_guia_id) > 0){				  
					  $detalle_ss_id                = $_REQUEST['detalle_guia'][$i]['detalle_ss_id'];				  
					  $item                         = $_REQUEST['detalle_guia'][$i]['item'];
					  $referencia_producto          = $_REQUEST['detalle_guia'][$i]['referencia_producto'];
					  $descripcion_producto         = $_REQUEST['detalle_guia'][$i]['descripcion_producto_detalle'];
				      $cantidad                     = str_replace(",",".",str_replace(".","",$_REQUEST['detalle_guia'][$i]['cantidad']));
				      $peso                         = str_replace(",",".",str_replace(".","",$_REQUEST['detalle_guia'][$i]['peso']));
				      $valor                        = str_replace(",",".",str_replace(".","",$_REQUEST['detalle_guia'][$i]['valor']));
				      $peso_volumen                 = str_replace(",",".",str_replace(".","",$_REQUEST['detalle_guia'][$i]['peso_volumen']));
					  $guia_cliente                 = $_REQUEST['detalle_guia'][$i]['guia_cliente'];
					  $observaciones                = $_REQUEST['detalle_guia'][$i]['observaciones'];					  
					  $detalle_ss_id                = is_numeric($detalle_ss_id) ? $detalle_ss_id : 'NULL';					  
					  $insert = "UPDATE detalle_guia SET referencia_producto='$referencia_producto',descripcion_producto='$descripcion_producto',
					  peso_volumen=$peso_volumen,peso=$peso,cantidad=$cantidad,valor=$valor,guia_cliente='$guia_cliente',observaciones='$observaciones' 
					  WHERE detalle_guia_id=$detalle_guia_id";				  
				  }else{				  
						  $detalle_guia_id            = $this -> DbgetMaxConsecutive("detalle_remesa","detalle_remesa_id",$Conex,false,1);				
						  $detalle_ss_id                = $_REQUEST['detalle_guia'][$i]['detalle_ss_id'];				  
						  $item                         = $_REQUEST['detalle_guia'][$i]['item'];
						  $referencia_producto          = $_REQUEST['detalle_guia'][$i]['referencia_producto'];
						  $descripcion_producto         = $_REQUEST['detalle_guia'][$i]['descripcion_producto_detalle'];
				          $cantidad                     = str_replace(",",".",str_replace(".","",$_REQUEST['detalle_guia'][$i]['cantidad']));
				          $peso                         = str_replace(",",".",str_replace(".","",$_REQUEST['detalle_guia'][$i]['peso']));
				          $valor                        = str_replace(",",".",str_replace(".","",$_REQUEST['detalle_guia'][$i]['valor']));
				          $peso_volumen                 = str_replace(",",".",str_replace(".","",$_REQUEST['detalle_guia'][$i]['peso_volumen']));				      
						  $guia_cliente                 = $_REQUEST['detalle_guia'][$i]['guia_cliente'];
						  $observaciones                = $_REQUEST['detalle_guia'][$i]['observaciones'];						  
						  $detalle_ss_id                = is_numeric($detalle_ss_id) ? $detalle_ss_id : 'NULL';						  
						  $insert = "INSERT INTO detalle_guia (detalle_guia_id,guia_id,detalle_ss_id,item,referencia_producto,descripcion_producto,peso_volumen,
						  peso,cantidad,valor,guia_cliente,observaciones) VALUES ($detalle_guia_id,$guia_id,$detalle_ss_id,$item,'$referencia_producto',
						  '$descripcion_producto',$peso_volumen,$peso,$cantidad,$valor,'$guia_cliente','$observaciones');";	
				    }				  
				  $this -> query($insert,$Conex);					
				  if($this -> GetNumError() > 0){
					return false;
				  }	
			      $detalle_guia_id .= "$detalle_guia_id,";			  
			    }				
				$detalle_guia_id = substr($detalle_guia_id,0,strlen($detalle_guia_id) - 1);				
				$delete = "DELETE FROM detalle_guia WHERE guia_id = $guia_id AND detalle_guia_id NOT IN ($detalle_guia_id)";				
				$this -> query($delete,$Conex);				
				if($this -> GetNumError() > 0){
				  return false;
				}	 				
				$contactos  = explode(",",$_REQUEST['contacto_id']);
				$remesa_id  = $this -> requestDataForQuery('guia_id','integer');				
				$delete     = "DELETE FROM contacto_guia WHERE guia_id = $guia_id"; 
				$this -> query($delete,$Conex);				
				for($i = 0; $i < count($contactos) && $contactos[$i] != 'NULL'; $i++){				
					$contacto_id = $contactos[$i];				
					$insert      = "INSERT INTO contacto_guia (contacto_id,guia_id) VALUES ($contacto_id,$guia_id)";				
					$this -> query($insert,$Conex);				
					if($this -> GetNumError() > 0){
						return false;
					}
				 }
			  }				
		   }		  
		}		
	$this -> Commit($Conex);
  }  

  public function Delete($Campos,$Conex){	  
	$this -> Begin($Conex);	
		$guia_id  = $this -> requestDataForQuery('guia_id','integer');		
		$delete     = "DELETE FROM contacto_guia WHERE guia_id = $guia_id"; 
		$this -> query($delete,$Conex);		
		$delete     = "DELETE FROM detalle_guia WHERE guia_id = $guia_id"; 
		$this -> query($delete,$Conex);		
		$this -> DbDeleteTable("guia",$Campos,$Conex,true,false);		
	$this -> Commit($Conex);
  }
  
  public function cancellation($guia_id,$causal_anulacion_id,$observacion_anulacion,$usuario_anulo_id,$Conex){  
   $this -> Begin($Conex);  
     $update = "UPDATE guia SET estado = 'AN',causal_anulacion_id = $causal_anulacion_id,observacion_anulacion = $observacion_anulacion,
	 fecha_anulacion = NOW(),usuario_anulo_id = $usuario_anulo_id WHERE guia_id = $guia_id";	 
	 $this -> query($update,$Conex,true);	 
	 $update = "UPDATE detalle_solicitud_servicio SET estado = 'D' WHERE detalle_ss_id IN (SELECT detalle_ss_id FROM detalle_guia WHERE 
	 guia_id = $guia_id)";
	 $this -> query($update,$Conex,true);	 
   $this -> Commit($Conex);  
  }    


//LISTA MENU
  public function getContactos($contacto_id,$Conex){
    $cliente_id  = $this -> requestDataForQuery('cliente_id','integer');  
    $select = "SELECT contacto_id AS value,nombre_contacto AS text,$contacto_id AS selected 
				FROM contacto 
				WHERE cliente_id =  $cliente_id";	
	$result = $this -> DbFetchAll($select,$Conex);	
	return $result;
  }
  
  public function getRemesasNumero($Conex,$oficina_id){  //guia
     $select = "SELECT guia_id AS value,numero_guia AS text,(SELECT MAX(guia_id) FROM guia WHERE oficina_id = $oficina_id) AS selected FROM guia 
	 WHERE oficina_id = $oficina_id ORDER BY numero_guia ASC";
	 $result = $this -> DbFetchAll($select,$Conex);	
	 return $result;    
  }

//BUSQUEDA
  public function selectRemesa($Conex){	//guia  
    $guiaid  = $this -> requestDataForQuery('guia_id','integer');
	$dataGuia = array();    				
    $select = "SELECT r.*,(SELECT CONCAT_WS(' ',razon_social,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido) FROM tercero WHERE tercero_id = 
	(SELECT tercero_id FROM cliente WHERE cliente_id = r.cliente_id)) AS cliente,(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) AS origen,
	(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino,(SELECT codigo FROM producto WHERE producto_id=r.producto_id) AS producto,		
	ht.* FROM guia r WHERE r.guia_id = $guia_id";				
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);			
	$dataGuia[0]['guia'] = $result;	
    $select = "SELECT item,detalle_guia_id,detalle_ss_id,referencia_producto,descripcion_producto AS descripcion_producto_detalle,cantidad AS cantidad_detalle,
	PESO as peso_detalle,valor AS valor_detalle,peso_volumen AS peso_volumen_detalle,guia_cliente,observaciones FROM detalle_guia WHERE guia_id = $guia_id";	
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);					
	$dataGuia[0]['detalle_guia'] = $result;		
	return $dataGuia;
  }
  
  public function selectRemesaComplemento($numero_guia,$Conex){	  
	$dataGuia = array();    				
    $select = "SELECT r.*,(SELECT CONCAT_WS(' ',razon_social,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido) FROM tercero WHERE tercero_id = 
	(SELECT tercero_id FROM cliente WHERE cliente_id = r.cliente_id)) AS cliente,(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) AS origen,
	(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino,(SELECT codigo FROM producto WHERE producto_id=r.producto_id) AS producto,
	r.propietario_mercancia AS propietario_mercancia_txt FROM guia r WHERE TRIM(r.numero_guia) = TRIM('$numero_guia')";				
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	$guia_id                         = $result[0]['guia_id'];	
	$result[0]['guia_id']            = null;
	$result[0]['numero_guia_padre']  = $result[0]['numero_guia'];
	$result[0]['numero_guia']        = null;						
	$dataGuia[0]['guia']           = $result;	
    $select = "SELECT item,detalle_guia_id,detalle_ss_id,referencia_producto,descripcion_producto AS descripcion_producto_detalle,cantidad AS cantidad_detalle,
	PESO as peso_detalle,valor AS valor_detalle,peso_volumen AS peso_volumen_detalle,guia_cliente,observaciones FROM detalle_guia WHERE guia_id = $guia_id";	
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);				
	$dataGuia[0]['detalle_guia'] = $result;		
	return $dataGuia;
  }  
  
  
  public function SelectContactosRemesa($Conex){	  
    $guia_id  = $this -> requestDataForQuery('guia_id','integer');  
    $select = "SELECT contacto_id FROM contacto_remesa WHERE guia_id = $guia_id";
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);	
	return $result;    
  }

//////////////////////////////////////////

    public function GetTipoEnvio($Conex){
	$result = $this -> DbFetchAll("SELECT tipo_envio_id AS value,nombre AS text FROM tipo_envio ORDER BY nombre ASC",$Conex,false);
    return $result;
  }
  
    public function GetTipoServicio($Conex){
	$result = $this -> DbFetchAll("SELECT tipo_servicio_mensajeria_id AS value,nombre AS text FROM tipo_servicio_mensajeria ORDER BY nombre ASC",$Conex,false);
    return $result;
  }  

    public function GetClaseServicio($Conex){
	$result = $this -> DbFetchAll("SELECT clase_servicio_mensajeria_id AS value,nombre AS text FROM clase_servicio_mensajeria ORDER BY nombre ASC",$Conex,false);
    return $result;
  }  
  
    public function GetEstadoMensajeria($Conex){
	$result = $this -> DbFetchAll("SELECT estado_mensajeria_id AS value,nombre_estado AS text FROM estado_mensajeria ORDER BY nombre_estado ASC",$Conex,false);
    return $result;
  }   

    public function GetMotivoDevolucion($Conex){
	$result = $this -> DbFetchAll("SELECT motivo_devolucion_id AS value,nombre AS text FROM motivo_devolucion ORDER BY nombre ASC",$Conex,false);
    return $result;
  } 
  
    public function GetFormaPago($Conex){
	$result = $this -> DbFetchAll("SELECT forma_pago_mensajeria_id AS value,nombre AS text FROM forma_pago_mensajeria ORDER BY nombre ASC",$Conex,false);
    return $result;
  }     
  
    public function GetTipoIdentificacion($Conex){
	$result = $this -> DbFetchAll("SELECT tipo_identificacion_id AS value,nombre AS text FROM tipo_identificacion ORDER BY nombre ASC",$Conex,false);
    return $result;
  }    
//////////////////////////////////////////

//// GRID ////
  public function getQueryRemesasOficinasGrid($oficina_id){
     $Query = "
	           (SELECT IF(dp.manifiesto_id > 0,(SELECT manifiesto FROM manifiesto WHERE manifiesto_id = dp.manifiesto_id),(SELECT despacho FROM despachos_urbanos 
				WHERE despachos_urbanos_id = dp.despachos_urbanos_id)) AS planilla,IF(dp.manifiesto_id > 0,(SELECT placa FROM manifiesto WHERE manifiesto_id =  
				dp.manifiesto_id),(SELECT placa FROM despachos_urbanos WHERE despachos_urbanos_id = dp.despachos_urbanos_id)) AS placa,IF(dp.manifiesto_id > 0,
				(SELECT nombre FROM manifiesto WHERE manifiesto_id = dp.manifiesto_id),(SELECT nombre FROM despachos_urbanos WHERE despachos_urbanos_id = dp.despachos_urbanos_id))					
				AS conductor,IF(dp.manifiesto_id > 0,(SELECT fecha_mc FROM manifiesto WHERE manifiesto_id = dp.manifiesto_id),(SELECT fecha_du FROM despachos_urbanos 
				WHERE despachos_urbanos_id = dp.despachos_urbanos_id)) AS fecha_planilla,r.numero_remesa,r.fecha_remesa,(SELECT 
				CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM cliente c, tercero t WHERE c.cliente_id=r.cliente_id
				AND c.tercero_id=t.tercero_id) AS cliente,(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) AS origen,
				r.remitente,(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino,r.destinatario,r.orden_despacho,d.referencia_producto,
				d.cantidad,(SELECT codigo FROM producto WHERE producto_id=r.producto_id) AS codigo,r.descripcion_producto,(SELECT naturaleza FROM naturaleza 
				WHERE naturaleza_id=r.naturaleza_id) AS naturaleza,(SELECT empaque FROM empaque WHERE empaque_id=r.empaque_id) AS empaque,
				(SELECT medida FROM medida WHERE medida_id=r.medida_id) AS medida,d.peso_volumen,d.peso FROM remesa r,detalle_remesa d, detalle_despacho dp, oficina o WHERE 
				r.oficina_id = $oficina_id AND r.remesa_id = d.remesa_id AND r.remesa_id = dp.remesa_id AND r.oficina_id = o.oficina_id ORDER BY numero_remesa DESC) 
				
				UNION ALL				
				
				(SELECT '' AS planilla,'' AS placa,'' AS conductor,'' AS fecha_planilla,r.numero_remesa,r.fecha_remesa,(SELECT 
				CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM cliente c, tercero t WHERE c.cliente_id=r.cliente_id
				 AND c.tercero_id=t.tercero_id) AS cliente,(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) AS origen,
				r.remitente,(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino,r.destinatario,r.orden_despacho,d.referencia_producto,d.cantidad,					
				(SELECT codigo FROM producto WHERE producto_id=r.producto_id) AS codigo,r.descripcion_producto,(SELECT naturaleza FROM naturaleza WHERE 
				naturaleza_id=r.naturaleza_id) AS naturaleza,(SELECT empaque FROM empaque WHERE empaque_id=r.empaque_id) AS empaque,(SELECT medida FROM medida WHERE 
				medida_id=r.medida_id) AS medida,d.peso_volumen,
					d.peso
					
	 			FROM remesa r,detalle_remesa d, oficina o WHERE r.oficina_id = $oficina_id AND r.remesa_id = d.remesa_id AND r.oficina_id = o.oficina_id AND r.remesa_id 
				NOT IN (SELECT remesa_id FROM detalle_despacho)	ORDER BY numero_remesa DESC)
				
				";	 
     return $Query;
  }
   
    public function selectDataClienteRemitente($cliente_id,$Conex){  
     $select = "SELECT r.*, nombre AS remitente_destinatario FROM remitente_destinatario r WHERE tercero_id = (SELECT tercero_id FROM cliente WHERE cliente_id = $cliente_id)";	 
	 $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);	
	 return $result;     
  }  
  
	public function getCausalesAnulacion($Conex){		
		$select = "SELECT causal_anulacion_id AS value,nombre AS text FROM causal_anulacion ORDER BY nombre";
		$result = $this -> DbFetchAll($select,$Conex);		
		return $result;				
    }  
	
	public function getProductos($Conex){	
	   $select = "SELECT producto_id AS value,CONCAT(SUBSTRING(producto_empresa,1,45),' - ',codigo) AS text FROM producto WHERE mostrar = 1 
	   OR producto_id IN (SELECT distinct producto_id FROM remesa WHERE estado != 'A') ORDER BY producto_empresa ASC";
	   $result = $this -> DbFetchAll($select,$Conex);		
	   return $result;			   
	}    
}

?>