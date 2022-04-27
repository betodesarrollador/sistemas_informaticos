<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class GuiaReenvioModel extends Db{

  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }

	public function selectGuiaPadre($id_padre,$Conex){

		// $dataGuia = array();
		$select = "SELECT
					g.*,
					(SELECT CONCAT_WS(' ',razon_social,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido) FROM tercero WHERE tercero_id = (SELECT tercero_id FROM cliente WHERE cliente_id = g.cliente_id)) AS cliente,
					(SELECT nombre FROM ubicacion WHERE ubicacion_id=g.origen_id) AS origen,
					(SELECT nombre FROM ubicacion WHERE ubicacion_id=g.destino_id) AS destino
				FROM 
					guia g
				WHERE
					TRIM(g.numero_guia) = TRIM('$id_padre') AND g.estado_mensajeria_id=7";
				// echo "$select";
		$result = $this -> DbFetchAll($select,$Conex,true);
		// $guia_id						= $result[0]['guia_id'];
		$result[0]['guia_id_padre']			= $result[0][guia_id];
		$result[0]['guia_id']				= '';
		$result[0]['numero_guia_padre']		= $result[0][numero_guia];
		$result[0]['numero_guia']			= '';
		$result[0]['estado_mensajeria_id']	= 1;
		$result[0]['solicitud_id']			= '';
		$result[0]['fecha_guia']			= date('Y-m-d');

		// $dataGuia[0]['guia']			= $result;
		// print_r($result);
		return $result;
	}

	public function getPermiso($ActividadId,$Permiso,$Conex){
		return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
	}
  
	public function Save($Campos,$oficina_id,$Conex){
		$guia_id = $this -> DbgetMaxConsecutive("guia","guia_id",$Conex,false,1);
		$this -> assignValRequest('guia_id',$guia_id);
		$this -> assignValRequest('oficina_id',$oficina_id);
		$this -> assignValRequest('estado_mensajeria_id',1);
		$select = "SELECT MAX(numero_guia) AS numero_guia FROM guia WHERE oficina_id = $oficina_id AND manual=0";
		$result = $this -> DbFetchAll($select,$Conex,true);
		$numero_guia = $result[0]['numero_guia'];

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
						$detalle_guia_id              = $this -> DbgetMaxConsecutive("detalle_guia","detalle_guia_id",$Conex,false,1);
						$detalle_ss_id                = $_REQUEST['detalle_guia'][$i]['detalle_ss_id'];
						$item                         = $_REQUEST['detalle_guia'][$i]['item'];
						$referencia_producto          = $_REQUEST['detalle_guia'][$i]['referencia_producto'];
						$descripcion_producto         = $_REQUEST['detalle_guia'][$i]['descripcion_producto'];
						$cantidad                     = str_replace(",",".",str_replace(".","",$_REQUEST['detalle_guia'][$i]['cantidad']));
						$peso                         = $_REQUEST['detalle_guia'][$i]['peso'];
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
							$insert = "INSERT INTO detalle_guia (detalle_guia_id,guia_id,detalle_ss_id,item,referencia_producto,descripcion_producto,peso_volumen,
							peso,cantidad,valor,guia_cliente,observaciones) VALUES ($detalle_guia_id,$guia_id,$detalle_ss_id,$item,'$referencia_producto',
							'$descripcion_producto',$peso_volumen,$peso,$cantidad,$valor,'$guia_cliente','$observaciones')";
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
					/*$contactos = explode(",",$_REQUEST['contacto_id']);
					for($i = 0; $i < count($contactos) && $contactos[$i] != 'NULL'; $i++){
						$contacto_id = $contactos[$i];
						$insert = "INSERT INTO contacto_guia (contacto_id,guia_id) VALUES ($contacto_id,$guia_id)";
						$this -> query($insert,$Conex,true);
						if($this -> GetNumError() > 0){
							return false;
						}
					}*/
				}
			}
		}
		$this -> Commit($Conex);	
		return $numero_guia;  
	}
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
					  $descripcion_producto         = $_REQUEST['detalle_guia'][$i]['descripcion_producto'];
				      $cantidad                     = str_replace(",",".",str_replace(".","",$_REQUEST['detalle_guia'][$i]['cantidad']));
				      $peso                         = $_REQUEST['detalle_guia'][$i]['peso'];
				      $valor                        = str_replace(",",".",str_replace(".","",$_REQUEST['detalle_guia'][$i]['valor']));
				      $peso_volumen                 = str_replace(",",".",str_replace(".","",$_REQUEST['detalle_guia'][$i]['peso_volumen']));
					  $guia_cliente                 = $_REQUEST['detalle_guia'][$i]['guia_cliente'];
					  $observaciones                = $_REQUEST['detalle_guia'][$i]['observaciones'];					  
					  $detalle_ss_id                = is_numeric($detalle_ss_id) ? $detalle_ss_id : 'NULL';					  
					  $insert = "UPDATE detalle_guia SET referencia_producto='$referencia_producto',descripcion_producto='$descripcion_producto',
					  peso_volumen=$peso_volumen,peso=$peso,cantidad=$cantidad,valor=$valor,guia_cliente='$guia_cliente',observaciones='$observaciones' 
					  WHERE detalle_guia_id=$detalle_guia_id";				  
				  }else{				  
						  $detalle_guia_id            = $this -> DbgetMaxConsecutive("detalle_guia","detalle_guia_id",$Conex,false,1);				
						  $detalle_ss_id                = $_REQUEST['detalle_guia'][$i]['detalle_ss_id'];				  
						  $item                         = $_REQUEST['detalle_guia'][$i]['item'];
						  $referencia_producto          = $_REQUEST['detalle_guia'][$i]['referencia_producto'];
						  $descripcion_producto         = $_REQUEST['detalle_guia'][$i]['descripcion_producto'];
				          $cantidad                     = str_replace(",",".",str_replace(".","",$_REQUEST['detalle_guia'][$i]['cantidad']));
				          $peso                         = $_REQUEST['detalle_guia'][$i]['peso'];
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
			/*	$contactos  = explode(",",$_REQUEST['contacto_id']);
				$guia_id  = $this -> requestDataForQuery('guia_id','integer');				
				$delete     = "DELETE FROM contacto_guia WHERE guia_id = $guia_id"; 
				$this -> query($delete,$Conex);				
				for($i = 0; $i < count($contactos) && $contactos[$i] != 'NULL'; $i++){				
					$contacto_id = $contactos[$i];				
					$insert      = "INSERT INTO contacto_guia (contacto_id,guia_id) VALUES ($contacto_id,$guia_id)";				
					$this -> query($insert,$Conex);				
					if($this -> GetNumError() > 0){
						return false;
					}
				 }*/
			  }				
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
     $update = "UPDATE guia SET estado = 'AN',causal_anulacion_id = $causal_anulacion_id,observacion_anulacion = $observacion_anulacion,
	 fecha_anulacion = NOW(),usuario_anulo_id = $usuario_anulo_id WHERE guia_id = $guia_id";	 
	 $this -> query($update,$Conex,true);	 
	 $update = "UPDATE detalle_solicitud_servicio SET estado = 'D' WHERE detalle_ss_id IN (SELECT detalle_ss_id FROM detalle_guia WHERE 
	 guia_id = $guia_id)";
	 $this -> query($update,$Conex,true);	 
   $this -> Commit($Conex);  
  }    

//LISTA MENU
  public function getGuiaReenvioNumero($Conex,$oficina_id){ 
     $select = "SELECT guia_id AS value,numero_guia AS text,(SELECT MAX(guia_id) FROM guia WHERE oficina_id = $oficina_id) AS selected 
	 FROM guia WHERE oficina_id = $oficina_id ORDER BY numero_guia ASC";
	 $result = $this -> DbFetchAll($select,$Conex);	
	 return $result;    
  }


	// public function getCalcularTarifa($tabla,$tipo_envio_id,$anio,$Conex,$oficina_id){ 
	// 	$select = "SELECT * FROM $tabla WHERE tipo_envio_id = $tipo_envio_id AND periodo=$anio";
	// 	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	// 	return $result;
	// }

  public function getCalcularCosto($destino_id,$anio,$Conex,$oficina_id){ 
     $select = "SELECT * FROM tarifas_destino WHERE ubicacion_id = $destino_id AND periodo=$anio";
	 $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	 return $result;    
  }  

//BUSQUEDA
  public function selectGuiaReenvio($Conex){  
    $guia_id  = $this -> requestDataForQuery('guia_id','integer');
	$dataGuiaReenvio = array();    				
    $select = "SELECT r.*,
	(SELECT CONCAT_WS(' ',razon_social,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido) FROM tercero WHERE tercero_id = 
	(SELECT tercero_id FROM remitente_destinatario WHERE remitente_destinatario_id = r.remitente_id AND remitente_destinatario_id = r.destinatario_id)) AS cliente,
	(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) AS origen,
	(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino FROM guia r WHERE r.guia_id = $guia_id";				
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false); 
	$dataGuiaReenvio[0]['guia'] = $result;	
    $select = "SELECT item,detalle_guia_id,detalle_ss_id,referencia_producto,descripcion_producto AS descripcion_producto,cantidad AS cantidad,
	peso as peso,valor AS valor,peso_volumen AS peso_volumen,guia_cliente,observaciones FROM detalle_guia WHERE guia_id = $guia_id";	
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);					
	$dataGuiaReenvio[0]['detalle_guia'] = $result;	
	return $dataGuiaReenvio;
  }
  
  public function selectGuiaReenvioComplemento($numero_guia,$Conex){	  
	$dataGuiaReenvio = array();    				
    $select = "SELECT r.*,(SELECT CONCAT_WS(' ',razon_social,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido) FROM tercero WHERE tercero_id = 
	(SELECT tercero_id FROM remitente_destinatario WHERE remitente_destinatario_id = r.remitente_id AND remitente_destinatario_id = r.destinatario_id)) AS cliente,
	(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) AS origen,
	(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino FROM guia r WHERE TRIM(r.numero_guia) = TRIM('$numero_guia')";				
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	$guia_id                         = $result[0]['guia_id'];	
	$result[0]['guia_id']            = null;
	$result[0]['numero_guia']  		 = $result[0]['numero_guia'];
//	$result[0]['id_padre']  = null;						
	$dataGuiaReenvio[0]['guia']             = $result;	
    $select = "SELECT item,detalle_guia_id,detalle_ss_id,referencia_producto,descripcion_producto AS descripcion_producto,cantidad AS cantidad,
	PESO as peso,valor AS valor,peso_volumen AS peso_volumen,guia_cliente,observaciones FROM detalle_guia WHERE guia_id = $guia_id";	
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);				
	$dataGuiaReenvio[0]['detalle_guia'] = $result;		
	return $dataGuiaReenvio;
  }    
  
/*  public function SelectContactosGuiaReenvio($Conex){	  
    $guia_id  = $this -> requestDataForQuery('guia_id','integer');  
    $select = "SELECT contacto_id FROM contacto_guia WHERE guia_id = $guia_id";
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);	
	return $result;    
  }*/
//////////////////////////////////////////

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
	      $select = "SELECT tm.tipo_envio_id AS value,(SELECT nombre FROM tipo_envio WHERE tipo_envio_id = tm.tipo_envio_id) AS text FROM tarifas_mensajeria tm";
	      $result = $this -> DbFetchAll($select,$Conex);	
	   }
	    elseif($TipoServicioId == 2){
		       $select = "SELECT tc.tipo_envio_id AS value,(SELECT nombre FROM tipo_envio WHERE tipo_envio_id = tc.tipo_envio_id) AS text FROM tarifas_carga tc";
	           $result = $this -> DbFetchAll($select,$Conex);		
		}
		 else{
			 $select = "SELECT tco.tipo_envio_id AS value,(SELECT nombre FROM convencion WHERE convencion_id = tco.tipo_envio_id) AS text FROM tarifas_correo_24_horas tco";
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
		       $select = "SELECT tc.tipo_envio_id AS value,(SELECT nombre FROM tipo_envio WHERE tipo_envio_id = tc.tipo_envio_id) AS text FROM tarifas_carga tc";
	           $result = $this -> DbFetchAll($select,$Conex);		
		}
		 else{
			 $select = "SELECT tco.tipo_envio_id AS value,(SELECT nombre FROM convencion WHERE convencion_id = tco.tipo_envio_id) AS text FROM tarifas_correo_24_horas tco";
	         $result = $this -> DbFetchAll($select,$Conex);	
	     }		 
	   return $result;	 	   
   }  
   
//////////////////////////////////////////
//// GRID ////
  public function getQueryGuiaReenvioOficinasGrid($oficina_id){
     $Query = "SELECT r.numero_guia AS guia,r.orden_despacho,r.fecha_guia,(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) AS origen,
			  (SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino,r.remitente,r.destinatario,r.telefono_destinatario,r.direccion_destinatario,d.referencia_producto,
			  d.cantidad,d.peso,d.peso_volumen,r.observaciones,
			  (SELECT nombre_estado FROM estado_mensajeria WHERE estado_mensajeria_id = r.estado_mensajeria_id) AS estado
			  FROM guia r, detalle_guia d, oficina o 
			  WHERE r.oficina_id = $oficina_id AND r.guia_id = d.guia_id AND r.oficina_id = o.oficina_id ORDER BY r.numero_guia";	 
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
	
/*	public function getProductos($Conex){	
	   $select = "SELECT producto_id AS value,CONCAT(SUBSTRING(producto_empresa,1,45),' - ',codigo) AS text FROM producto WHERE mostrar = 1 
	   OR producto_id IN (SELECT distinct producto_id FROM guia WHERE estado != 'A') ORDER BY producto_empresa ASC";
	   $result = $this -> DbFetchAll($select,$Conex);		
	   return $result;			   
	}  */
}

?>