<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class GuiaModel extends Db{

  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }

  public function Anular($guia_id,$Conex){
  	$sql ="UPDATE guia SET estado_mensajeria_id = '8' WHERE guia_id = $guia_id";
  	$this -> query($sql,$Conex);
  }
  
  public function Save($Campos,$oficina_id,$usuario_id,$Conex){  	
	$guia_id = $this -> DbgetMaxConsecutive("guia","guia_id",$Conex,false,1);
	$this -> assignValRequest('guia_id',$guia_id);	
	$this -> assignValRequest('oficina_id',$oficina_id);	
	$this -> assignValRequest('estado_mensajeria_id',1);
	$this -> assignValRequest('usuario_id',$usuario_id);
	$select = "SELECT MAX(numero_guia) AS numero_guia FROM guia WHERE  manual=0 AND crm=0";
	$result = $this -> DbFetchAll($select,$Conex,true);	
	$numero_guia = $result[0]['numero_guia'];
	$peso   = $_REQUEST['peso'];	

	if($peso>5000){
		exit ('El Peso de la Guia debe ser Inferior a 5.000 Gramos');	
	}
	
	
	if(is_numeric($numero_guia)){	
	    $select = "SELECT rango_guia_fin FROM rango_guia WHERE  estado = 'A'";
	    $result = $this -> DbFetchAll($select,$Conex,true);
		$rango_guia_fin = $result[0]['rango_guia_fin'];	
        $numero_guia += 1;		
		if($numero_guia > $rango_guia_fin){
		  print 'El numero de Guia para esta oficina a superado el limite definido<br>debe actualizar el rango de Guias asignado para esta oficina !!!';
		  return false;
		}
		
	}else{	
	    $select = "SELECT rango_guia_ini FROM rango_guia WHERE  estado = 'A'";
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
  }
  public function Update($Campos,$Conex){	
	$this -> Begin($Conex);	
	    $guia_id = $_REQUEST['guia_id'];
		$oficina_id  = $this -> requestDataForQuery('oficina_id','integer');
		//$this -> assignValRequest('oficina_id',$oficina_id);	
		$this -> DbUpdateTable("guia",$Campos,$Conex,true,false);
		$peso   = $_REQUEST['peso'];	

		if($peso>5000){
			exit ('El Peso de la Guia debe ser Inferior a 5.000 Gramos');	
		}
		
		if($this -> GetNumError() > 0){
			return false;
		}else{		   
		    if($this -> GetNumError() > 0){
			  return false;
		    }		  
		}		
	$this -> Commit($Conex);
  }  

  public function Delete($Campos,$Conex){	  
	$this -> Begin($Conex);	
		$guia_id  = $this -> requestDataForQuery('guia_id','integer');		
//		$delete     = "DELETE FROM contacto_guia WHERE guia_id = $guia_id"; 
//		$this -> query($delete,$Conex);		
		$delete     = "DELETE FROM detalle_guia WHERE guia_id = $guia_id"; 
		$this -> query($delete,$Conex);		
		$this -> DbDeleteTable("guia",$Campos,$Conex,true,false);		
	$this -> Commit($Conex);
  }
  
	public function cancellation($guia_id,$causal_anulacion_id,$observacion_anulacion,$usuario_anulo_id,$Conex){
		$this -> Begin($Conex);
			$update = "UPDATE guia SET estado_mensajeria_id = '8',causal_anulacion_id = $causal_anulacion_id,observacion_anulacion = $observacion_anulacion,
			fecha_anulacion = NOW(),usuario_anulo_id = $usuario_anulo_id WHERE guia_id = $guia_id";
			$this -> query($update,$Conex,true);
			// echo $update;
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

 

  public function getCalcularTarifaCliente($cliente_id,$tipo_servicio_mensajeria_id,$tabla,$tipo_envio_id,$anio,$Conex,$oficina_id){ 
  	
     $select = "SELECT * FROM tarifas_mensajeria_cliente
	 WHERE tipo_envio_id = $tipo_envio_id AND tipo_servicio_mensajeria_id = $tipo_servicio_mensajeria_id AND cliente_id=$cliente_id
	 AND periodo=(SELECT periodo_contable_id FROM periodo_contable WHERE anio=$anio LIMIT 1)"; 
	 $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	 return $result;    
  }  

  public function getCalcularTarifa($tipo_servicio_mensajeria_id,$tabla,$tipo_envio_id,$anio,$Conex,$oficina_id){ 
  	
     $select = "SELECT * FROM tarifas_mensajeria
	 WHERE tipo_envio_id = $tipo_envio_id AND tipo_servicio_mensajeria_id = $tipo_servicio_mensajeria_id 
	 AND periodo=(SELECT periodo_contable_id FROM periodo_contable WHERE anio=$anio LIMIT 1)";
	 $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false); 
	 return $result;    
  }  

  public function getCalcularTarifaMasivoCliente($cliente_id,$tipo_servicio_mensajeria_id,$tabla,$tipo_envio_id,$anio,$Conex,$oficina_id){ 
  	
     $select = "SELECT * FROM tarifas_masivo_cliente WHERE tipo_envio_id = $tipo_envio_id AND tipo_servicio_mensajeria_id = $tipo_servicio_mensajeria_id  AND cliente_id=$cliente_id
	  AND periodo=(SELECT periodo_contable_id FROM periodo_contable WHERE anio=$anio LIMIT 1)";
	 $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	 return $result;    
  }  

  public function getCalcularTarifaMasivo($tipo_servicio_mensajeria_id,$tabla,$tipo_envio_id,$anio,$Conex,$oficina_id){ 
  	
     $select = "SELECT * FROM tarifas_masivo WHERE tipo_envio_id = $tipo_envio_id AND tipo_servicio_mensajeria_id = $tipo_servicio_mensajeria_id 
	  AND periodo=(SELECT periodo_contable_id FROM periodo_contable WHERE anio=$anio LIMIT 1)";
	 $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	 return $result;    
  }  

  public function getCalcularCosto($destino_id,$anio,$Conex,$oficina_id){ 
     $select = "SELECT * FROM tarifas_destino WHERE ubicacion_id = $destino_id AND periodo=$anio";
	 $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	 return $result;    
  }  

  public function getTipoEnvio1($destino_id,$Conex){ 
     $select = "SELECT tipo_envio_id FROM ubicacion WHERE ubicacion_id = $destino_id";
	 $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	 return $result[0]['tipo_envio_id'];    
  }  


//BUSQUEDA
  public function selectGuia($Conex){  
    $guia_id  = $this -> requestDataForQuery('guia_id','integer');
	$dataGuia = array();    				
    $select = "SELECT r.*,
	(SELECT CONCAT_WS(' ',razon_social,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido) FROM tercero WHERE tercero_id = 
	(SELECT tercero_id FROM remitente_destinatario WHERE remitente_destinatario_id = r.remitente_id AND remitente_destinatario_id = r.destinatario_id)) AS cliente,
	(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) AS origen,
	(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino FROM guia r WHERE r.guia_id = $guia_id";				
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false); 
	$dataGuia[0]['guia'] = $result;	
	return $dataGuia;
  }
  
  public function selectGuiaComplemento($numero_guia,$Conex){	  
	$dataGuia = array();    				
    $select = "SELECT r.*,(SELECT CONCAT_WS(' ',razon_social,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido) FROM tercero WHERE tercero_id = 
	(SELECT tercero_id FROM remitente_destinatario WHERE remitente_destinatario_id = r.remitente_id AND remitente_destinatario_id = r.destinatario_id)) AS cliente,
	(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) AS origen,
	(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino FROM guia r WHERE TRIM(r.numero_guia) = TRIM('$numero_guia')";				
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	$guia_id                         = $result[0]['guia_id'];	
	$result[0]['guia_id']            = null;
	$result[0]['numero_guia']  		 = $result[0]['numero_guia'];
//	$result[0]['numero_guia_padre']  = null;						
	$dataGuia[0]['guia']             = $result;	
	return $dataGuia;
  }    
  
//////////////////////////////////////////

  public function getClientes($oficina_id,$Conex){
	  

	  $select1 = "SELECT cliente_id 
	  FROM oficina WHERE oficina_id = $oficina_id";
	  $result1 = $this -> DbFetchAll($select1,$Conex);

	  if($result1[0][cliente_id]>0){
		  $cliente_id=$result1[0][cliente_id];
		  $select = "SELECT cliente_id AS value,(SELECT CONCAT_WS(' ',razon_social,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido)
		   															  
		  FROM tercero WHERE tercero_id = c.tercero_id) AS text, $cliente_id AS selected		 FROM cliente c WHERE estado = 'D' AND   cliente_id= $cliente_id ORDER BY nombre_cliente ASC";
		  $result = $this -> DbFetchAll($select,$Conex);
	
	  }else{
		  $select = "SELECT cliente_id AS value,(SELECT CONCAT_WS(' ',razon_social,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido) 
		  FROM tercero WHERE tercero_id = c.tercero_id) AS text FROM cliente c WHERE estado = 'D'   ORDER BY nombre_cliente ASC";
		  $result = $this -> DbFetchAll($select,$Conex);
	  }
	  return $result;	  
	  
  }

    public function GetTipoEnvio($Conex){
	$result = $this -> DbFetchAll("SELECT tipo_envio_id AS value,nombre AS text FROM tipo_envio ORDER BY nombre ASC",$Conex,false);
    return $result;
  }

   public function GetTipoMedida($Conex){
	$result = $this -> DbFetchAll("SELECT medida_id AS value,medida AS text FROM medida WHERE mensajeria=1 ORDER BY medida ASC",$Conex,false);
    return $result;
  }
    public function GetTipoServicio($Conex){
	$result = $this -> DbFetchAll("SELECT tipo_servicio_mensajeria_id AS value,nombre AS text FROM tipo_servicio_mensajeria ORDER BY nombre ASC",$Conex,false);
    return $result;
  }  
/*
    public function GetClaseServicio($Conex){
	$result = $this -> DbFetchAll("SELECT clase_servicio_mensajeria_id AS value,nombre AS text FROM clase_servicio_mensajeria ORDER BY nombre ASC",$Conex,false);
    return $result;
  }*/  
  
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
	$result = $this -> DbFetchAll("SELECT tipo_identificacion_id AS value, nombre AS text FROM tipo_identificacion ORDER BY nombre ASC",$Conex,false);
    return $result;
  }   

   public function getTabla($tipo_servicio_mensajeria_id,$Conex){	   
	  $select = "SELECT tabla FROM  tipo_servicio_mensajeria   WHERE tipo_servicio_mensajeria_id=$tipo_servicio_mensajeria_id";
	  $result = $this -> DbFetchAll($select,$Conex);	
	  return $result;
   
   }

   public function selectTipoEnvio($TipoServicioId,$Conex){	   
	   if($TipoServicioId == 1){
	      $select = "SELECT tm.tipo_envio_id AS value, nombre AS text FROM tipo_envio tm";
	      $result = $this -> DbFetchAll($select,$Conex);	
	   }elseif($TipoServicioId == 2){
		    //$select = "SELECT tc.tipo_envio_id AS value,(SELECT nombre FROM tipo_envio WHERE tipo_envio_id = tc.tipo_envio_id) AS text FROM tarifas_carga tc";
	      	$select = "SELECT tm.tipo_envio_id AS value, nombre AS text FROM tipo_envio tm";
			$result = $this -> DbFetchAll($select,$Conex);		
		}else{
			 $select = "SELECT te.tipo_envio_id AS value, nombre AS text FROM tipo_envio te";
	         $result = $this -> DbFetchAll($select,$Conex);	
	    }		 
	   return $result;	   
   }  
  
   public function selectTipoEnvioSelected($TipoServicioId,$TipoEnvioId,$Conex){	   
	   if($TipoServicioId == 1){
	      $select = "SELECT tm.tipo_envio_id AS value,(SELECT nombre FROM tipo_envio WHERE tipo_envio_id = tm.tipo_envio_id) AS text FROM tarifas_mensajeria tm";
	      $result = $this -> DbFetchAll($select,$Conex);	
	   }
	    elseif($TipoServicioId == 2){
			
		      // $select = "SELECT tc.tipo_envio_id AS value,(SELECT nombre FROM tipo_envio WHERE tipo_envio_id = tc.tipo_envio_id) AS text FROM tarifas_carga tc";
			   $select = "SELECT tm.tipo_envio_id AS value,(SELECT nombre FROM tipo_envio WHERE tipo_envio_id = tm.tipo_envio_id) AS text FROM tarifas_mensajeria tm";			   
	           $result = $this -> DbFetchAll($select,$Conex);		
		}
		 else{
			 $select = "SELECT tco.tipo_envio_id AS value,(SELECT nombre FROM convencion WHERE convencion_id = tco.tipo_envio_id) AS text FROM tarifas_correo_24_horas tco";
	         $result = $this -> DbFetchAll($select,$Conex);	
	     }		 
	   return $result;	 	   
   }  

  public function selectDataRemitenteDestinatario($remitente_destinatario_id,$Conex){
  
    $select = "SELECT r.*,CONCAT_WS(' ',nombre,primer_apellido,segundo_apellido) AS remitente_destinatario,(SELECT nombre FROM ubicacion WHERE ubicacion_id = r.ubicacion_id) AS ubicacion 
	FROM remitente_destinatario r WHERE remitente_destinatario_id 	= $remitente_destinatario_id";
	
	$result = $this -> DbFetchAll($select,$Conex,true);
	
	return $result; 
  
  }

  
   public function getCausalesAnulacion($Conex){		
		$select = "SELECT causal_anulacion_id AS value,nombre AS text FROM causal_anulacion ORDER BY nombre";
		$result = $this -> DbFetchAll($select,$Conex);		
		return $result;				
    }  
  
//////////////////////////////////////////
//// GRID ////
  public function getQueryGuiaOficinasGrid($oficina_id){
     $Query = "SELECT r.numero_guia AS guia,
	 			r.orden_despacho,
				r.fecha_guia,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) AS origen,
			  (SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino,
			  r.remitente,
			  r.destinatario,
			  r.telefono_destinatario,
			  r.direccion_destinatario,
			  r.referencia_producto,
			  r.cantidad,
			  r.peso,
			  r.peso_volumen,
			  r.observaciones,
			  (SELECT nombre_estado FROM estado_mensajeria WHERE estado_mensajeria_id = r.estado_mensajeria_id) AS estado
			  FROM guia r,  oficina o 
			  WHERE r.oficina_id = $oficina_id  AND r.oficina_id = o.oficina_id AND r.crm=0 ORDER BY r.numero_guia DESC LIMIT 0,300";	 
     return $Query;
  }
   
	
}

?>