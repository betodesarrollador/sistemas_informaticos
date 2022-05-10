<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class RemesasModel extends Db{

  
  public function clienteEstaReportadoMinisterio($cliente_id,$Conex){
  
    $select = "SELECT reportado_ministerio FROM remitente_destinatario WHERE cliente_id = $cliente_id";
	$result = $this -> DbFetchAll($select,$Conex,true);					
	
	 if($result[0]['reportado_ministerio'] == 1){
	   return true;
	 }else{
		 return false;
	   }
  
  }  
  
  public function selectDataRemitente($remitente_destinatario_id,$Conex){
  
    $select = "SELECT r.*,nombre AS remitente_destinatario,(SELECT nombre FROM ubicacion WHERE ubicacion_id = r.ubicacion_id) AS 
	origen,r.ubicacion_id AS origen_id FROM remitente_destinatario r WHERE remitente_destinatario_id 	= 
	$remitente_destinatario_id";
	
	$result = $this -> DbFetchAll($select,$Conex,true);
	
	return $result; 
  
  }  
  
  public function selectDataDestinatario($remitente_destinatario_id,$Conex){
  
    $select = "SELECT r.*,nombre AS remitente_destinatario,(SELECT nombre FROM ubicacion WHERE ubicacion_id = r.ubicacion_id) AS 
	destino,r.ubicacion_id AS destino_id FROM remitente_destinatario r WHERE remitente_destinatario_id 	= 
	$remitente_destinatario_id";
	
	$result = $this -> DbFetchAll($select,$Conex,true);
	
	return $result; 
  
  }
  
  public function remitenteDestinatarioEstaReportadoMinisterio($remitente_destinatario_id,$Conex){
  
     $select = "SELECT reportado_ministerio FROM remitente_destinatario WHERE remitente_destinatario_id = 
	            $remitente_destinatario_id";
				
	 $result = $this -> DbFetchAll($select,$Conex,true);				
	 
	 if($result[0]['reportado_ministerio'] == 1){
	   return true;
	 }else{
	     return false;
	   }
  
  }     
  
  public function informacionCargaFueReportada($remesa_id,$Conex){
  
    $select = "SELECT reportado_ministerio FROM remesa WHERE remesa_id = $remesa_id";
    $result = $this -> DbFetchAll($select,$Conex,true);	
	
	if($result[0]['reportado_ministerio'] == 1){
	  return true;
	}else{
	    return false;
	  }
  
  }  

  
  public function Save($Campos,$oficina_id,$Conex){
  	
	$remesa_id = $this -> DbgetMaxConsecutive("remesa","remesa_id",$Conex,false,1);

	$this -> assignValRequest('remesa_id',$remesa_id);	
	$this -> assignValRequest('oficina_id',$oficina_id);	
	$this -> assignValRequest('estado','PD');		
	$this -> assignValRequest('fecha_registro',date("Y-m-d"));			
	
	$select = "SELECT MAX(numero_remesa) AS numero_remesa FROM remesa WHERE oficina_id = $oficina_id";
	$result = $this -> DbFetchAll($select,$Conex,true);
	
	$numero_remesa = $result[0]['numero_remesa'];
	
	if(is_numeric($numero_remesa)){
	
	    $select           = "SELECT rango_remesa_fin FROM rango_remesa WHERE oficina_id = $oficina_id AND estado = 'A'";
	    $result           = $this -> DbFetchAll($select,$Conex,true);
		$rango_remesa_fin = $result[0]['rango_remesa_fin'];	
	
        $numero_remesa += 1;
		
		if($numero_remesa > $rango_remesa_fin){
		  print 'El numero de remesa para esta oficina a superado el limite definido<br>debe actualizar el rango de remesas asignado para esta oficina !!!';
		  return false;
		}
		
	}else{
	
	    $select           = "SELECT rango_remesa_ini FROM rango_remesa WHERE oficina_id = $oficina_id AND estado = 'A'";
	    $result           = $this -> DbFetchAll($select,$Conex,true);
		$rango_remesa_ini = $result[0]['rango_remesa_ini'];
		
		if(is_numeric($rango_remesa_ini)){
		
		  $numero_remesa = $rango_remesa_ini;

		}else{
		
		    print 'Debe Definir un rango de remesas para la oficina!!!';
		    return false;		   
		
		  }
	
	  }		
	
	
	$this -> assignValRequest('numero_remesa',$numero_remesa);
	
	$this -> Begin($Conex);
	
		$this -> DbInsertTable("remesa",$Campos,$Conex,true,false);
		
		if($this -> GetNumError() > 0){
			return false;
		}else{
		
		
		    if($this -> GetNumError() > 0){
			  return false;
			}else{
			
			  if(is_array($_REQUEST['detalle_remesa'])){

                for($i = 0; $i < count($_REQUEST['detalle_remesa']); $i++){
				
				  $detalle_remesa_id            = $this -> DbgetMaxConsecutive("detalle_remesa","detalle_remesa_id",$Conex,false,1);				
				  $detalle_ss_id                = $_REQUEST['detalle_remesa'][$i]['detalle_ss_id'];				  
				  $item                         = $_REQUEST['detalle_remesa'][$i]['item'];
				  $referencia_producto          = $_REQUEST['detalle_remesa'][$i]['referencia_producto'];
				  $descripcion_producto         = $_REQUEST['detalle_remesa'][$i]['descripcion_producto_detalle'];
				  $cantidad                     = str_replace(",",".",str_replace(".","",$_REQUEST['detalle_remesa'][$i]['cantidad_detalle']));
				  $peso                         = str_replace(",",".",str_replace(".","",$_REQUEST['detalle_remesa'][$i]['peso_detalle']));
				  $valor                        = str_replace(",",".",str_replace(".","",$_REQUEST['detalle_remesa'][$i]['valor_detalle']));
				  $peso_volumen                 = str_replace(",",".",str_replace(".","",$_REQUEST['detalle_remesa'][$i]['peso_volumen_detalle']));
				  $guia_cliente                 = $_REQUEST['detalle_remesa'][$i]['guia_cliente'];
				  $observaciones                = $_REQUEST['detalle_remesa'][$i]['observaciones'];
				  
                  $detalle_ss_id                = is_numeric($detalle_ss_id) ? $detalle_ss_id : 'NULL';		
				  
				  if(!is_numeric($cantidad))     $cantidad     = 0;                    
				  if(!is_numeric($peso))         $peso         = 0;                    
				  if(!is_numeric($valor))        $valor        = 0;                    				  				  
				  if(!is_numeric($peso_volumen)) $peso_volumen = 0;                    				  				  				  
				  
                  if(strlen(trim($referencia_producto)) > 0){       
                  
				     $insert = "INSERT INTO detalle_remesa  
					 (detalle_remesa_id,remesa_id,detalle_ss_id,item,referencia_producto,descripcion_producto,peso_volumen,
				     peso,cantidad,valor,guia_cliente,observaciones) 
					 VALUES ($detalle_remesa_id,$remesa_id,$detalle_ss_id,$item,'$referencia_producto',
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
				
					$insert = "INSERT INTO contacto_remesa (contacto_id,remesa_id) VALUES ($contacto_id,$remesa_id)";
				
					$this -> query($insert,$Conex,true);
					
					 if($this -> GetNumError() > 0){
					   return false;
					 }
					 
				 }					
				
			  
			  }
						
			
		   }
			
		}

	
	$this -> Commit($Conex);
	
	return $numero_remesa;
  }

  public function Update($Campos,$Conex){
	
	$this -> assignValRequest('fecha_registro',date("Y-m-d"));			
		
	$this -> Begin($Conex);
	
	    $remesa_id = $_REQUEST['remesa_id'];
	
		$this -> DbUpdateTable("remesa",$Campos,$Conex,true,false);

		if($this -> GetNumError() > 0){
			return false;
		}else{
			   
		   
		    if($this -> GetNumError() > 0){
			  return false;
			}else{
			
			  if(is_array($_REQUEST['detalle_remesa'])){
			  
			    $detalles_remesa_id = null;

                for($i = 0; $i < count($_REQUEST['detalle_remesa']); $i++){
				
				  $detalle_remesa_id  = $_REQUEST['detalle_remesa'][$i]['detalle_remesa_id'];				  
				  				  
				  if(is_numeric($detalle_remesa_id) > 0){				  
				  
					  $detalle_ss_id                = $_REQUEST['detalle_remesa'][$i]['detalle_ss_id'];				  
					  $item                         = $_REQUEST['detalle_remesa'][$i]['item'];
					  $referencia_producto          = $_REQUEST['detalle_remesa'][$i]['referencia_producto'];
					  $descripcion_producto         = $_REQUEST['detalle_remesa'][$i]['descripcion_producto_detalle'];
				      $cantidad                     = str_replace(",",".",str_replace(".","",$_REQUEST['detalle_remesa'][$i]['cantidad_detalle']));
				      $peso                         = str_replace(",",".",str_replace(".","",$_REQUEST['detalle_remesa'][$i]['peso_detalle']));
				      $valor                        = str_replace(",",".",str_replace(".","",$_REQUEST['detalle_remesa'][$i]['valor_detalle']));
				      $peso_volumen                 = str_replace(",",".",str_replace(".","",$_REQUEST['detalle_remesa'][$i]['peso_volumen_detalle']));
					  $guia_cliente                 = $_REQUEST['detalle_remesa'][$i]['guia_cliente'];
					  $observaciones                = $_REQUEST['detalle_remesa'][$i]['observaciones'];
					  
					  $detalle_ss_id                = is_numeric($detalle_ss_id) ? $detalle_ss_id : 'NULL';
					  
					  $insert = "UPDATE detalle_remesa SET referencia_producto='$referencia_producto',descripcion_producto='$descripcion_producto',
					  peso_volumen=$peso_volumen,peso=$peso,cantidad=$cantidad,valor=$valor,guia_cliente='$guia_cliente',observaciones='$observaciones' 
					  WHERE detalle_remesa_id=$detalle_remesa_id";
				  
				  }else{
				  
						  $detalle_remesa_id            = $this -> DbgetMaxConsecutive("detalle_remesa","detalle_remesa_id",$Conex,false,1);				
						  $detalle_ss_id                = $_REQUEST['detalle_remesa'][$i]['detalle_ss_id'];				  
						  $item                         = $_REQUEST['detalle_remesa'][$i]['item'];
						  $referencia_producto          = $_REQUEST['detalle_remesa'][$i]['referencia_producto'];
						  $descripcion_producto         = $_REQUEST['detalle_remesa'][$i]['descripcion_producto_detalle'];
				          $cantidad                     = str_replace(",",".",str_replace(".","",$_REQUEST['detalle_remesa'][$i]['cantidad_detalle']));
				          $peso                         = str_replace(",",".",str_replace(".","",$_REQUEST['detalle_remesa'][$i]['peso_detalle']));
				          $valor                        = str_replace(",",".",str_replace(".","",$_REQUEST['detalle_remesa'][$i]['valor_detalle']));
				          $peso_volumen                 = str_replace(",",".",str_replace(".","",$_REQUEST['detalle_remesa'][$i]['peso_volumen_detalle']));				      $guia_cliente                 = $_REQUEST['detalle_remesa'][$i]['guia_cliente'];
						  $observaciones                = $_REQUEST['detalle_remesa'][$i]['observaciones'];
						  
						  $detalle_ss_id                = is_numeric($detalle_ss_id) ? $detalle_ss_id : 'NULL';
						  
						  $insert = "INSERT INTO detalle_remesa (detalle_remesa_id,remesa_id,detalle_ss_id,item,referencia_producto,descripcion_producto,peso_volumen,
						  peso,cantidad,valor,guia_cliente,observaciones) VALUES ($detalle_remesa_id,$remesa_id,$detalle_ss_id,$item,'$referencia_producto',
						  '$descripcion_producto',$peso_volumen,$peso,$cantidad,$valor,'$guia_cliente','$observaciones');";				      
				  
				    }
				  
				  $this -> query($insert,$Conex);
					
				  if($this -> GetNumError() > 0){
					return false;
				  }				  
			  
			      $detalles_remesa_id .= "$detalle_remesa_id,";
			  
			    }
				
				$detalles_remesa_id = substr($detalles_remesa_id,0,strlen($detalles_remesa_id) - 1);
				
				$delete = "DELETE FROM detalle_remesa WHERE remesa_id = $remesa_id AND detalle_remesa_id NOT IN ($detalles_remesa_id)";
				
				$this -> query($delete,$Conex);
					
				if($this -> GetNumError() > 0){
				  return false;
				}	 
				
				
				$contactos  = explode(",",$_REQUEST['contacto_id']);
				$remesa_id  = $this -> requestDataForQuery('remesa_id','integer');
				
				$delete     = "DELETE FROM contacto_remesa WHERE remesa_id = $remesa_id"; 
				$this -> query($delete,$Conex);
				
				for($i = 0; $i < count($contactos) && $contactos[$i] != 'NULL'; $i++){
				
					$contacto_id = $contactos[$i];
				
					$insert      = "INSERT INTO contacto_remesa (contacto_id,remesa_id) VALUES ($contacto_id,$remesa_id)";
				
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
	
		$remesa_id  = $this -> requestDataForQuery('remesa_id','integer');
		
		$delete     = "DELETE FROM contacto_remesa WHERE remesa_id = $remesa_id"; 
		$this -> query($delete,$Conex);
		
		$delete     = "DELETE FROM detalle_remesa WHERE remesa_id = $remesa_id"; 
		$this -> query($delete,$Conex);
		
		$this -> DbDeleteTable("remesa",$Campos,$Conex,true,false);
		
	$this -> Commit($Conex);
  }
  
  public function cancellation($remesa_id,$causal_anulacion_id,$observacion_anulacion,$usuario_anulo_id,$Conex){
  
   $this -> Begin($Conex);
  
     $update = "UPDATE remesa SET estado = 'AN',causal_anulacion_id = $causal_anulacion_id,observacion_anulacion = $observacion_anulacion,
	 fecha_anulacion = NOW(),usuario_anulo_id = $usuario_anulo_id WHERE remesa_id = $remesa_id";
	 
	 $this -> query($update,$Conex,true);
	 
	 $update = "UPDATE detalle_solicitud_servicio SET estado = 'D' WHERE detalle_ss_id IN (SELECT detalle_ss_id FROM detalle_remesa WHERE 
	 remesa_id = $remesa_id)";
	 $this -> query($update,$Conex,true);	 	  	 
	 
   $this -> Commit($Conex);
  
  }    


//LISTA MENU
  public function GetTiposRemesa($Conex){
  
    $select = "SELECT tipo_remesa_id AS value,tipo_remesa AS text,'1' AS selected, descripcion_tipo_remesa AS title 
	           FROM tipo_remesa ORDER BY tipo_remesa";			      			   
  
	$result =  $this  -> DbFetchAll($select,$Conex,true);
	
	return $result;
  }

  public function GetNaturaleza($Conex){
	return $this -> DbFetchAll("SELECT naturaleza_id AS value,naturaleza AS text,'1' AS selected FROM naturaleza ORDER BY naturaleza",$Conex,true);
  }
  
  public function getCodTipoRemesa($tipo_remesa_id,$Conex){
  
     $select = "SELECT codigo FROM tipo_remesa WHERE tipo_remesa_id = $tipo_remesa_id";
   	 $result = $this  -> DbFetchAll($select,$Conex,true);
	 
	 return $result[0]['codigo'];  
  
  }	  
    
  public function getTipoEmpaque($Conex,$tipo_remesa_id='NULL'){
  
    $codTipoRemesa = $this -> getCodTipoRemesa($tipo_remesa_id,$Conex);
	
	if($codTipoRemesa == 'C' || $codTipoRemesa == 'V'){
	
      $select = "SELECT empaque_id AS value,empaque AS text,'1' AS selected,CONCAT_WS(' ',descrip_empaque,' \n\nPESO VACIO MINIMO :',peso_vacio_minimo,' PESO VACIO MAXIMO :',peso_vacio_maximo) AS title FROM empaque WHERE contenedor = 1 ORDER BY empaque";  
	
	  $result =  $this -> DbFetchAll($select,$Conex,true);	
	
	}else{
	
      $select = "SELECT empaque_id AS value,empaque AS text,'1' AS selected,descrip_empaque AS title FROM empaque WHERE contenedor != 1 ORDER BY empaque";  
	
	  $result =  $this -> DbFetchAll($select,$Conex,true);	
	
	  }
	
	return $result;	
	
  }
  
  public function selectPesoVacioMinimoContenedor($empaque_id,$Conex){
  
    $select = "SELECT peso_vacio_minimo FROM empaque WHERE empaque_id = $empaque_id";
	$result =  $this -> DbFetchAll($select,$Conex,true);		
	
	return $result[0]['peso_vacio_minimo'];
  
  }
  
  public function GetUnidadMedida($Conex){
	return $this -> DbFetchAll("SELECT medida_id AS value,medida AS text,'77' AS selected FROM medida WHERE ministerio = 1 ORDER BY medida",$Conex,$ErrDb = false);
  }  

  public function getContactos($contacto_id,$Conex){

    $cliente_id  = $this -> requestDataForQuery('cliente_id','integer');
  
    $select = "SELECT contacto_id AS value,nombre_contacto AS text,$contacto_id AS selected 
				FROM contacto 
				WHERE cliente_id =  $cliente_id";
	
	$result = $this -> DbFetchAll($select,$Conex);
	
	return $result;
  }
  
  public function getRemesasNumero($Conex,$oficina_id){
  
     $select = "SELECT remesa_id AS value,numero_remesa AS text,(SELECT MAX(remesa_id) FROM remesa WHERE oficina_id = $oficina_id) AS selected FROM remesa 
	 WHERE oficina_id = $oficina_id ORDER BY numero_remesa ASC";
	 $result = $this -> DbFetchAll($select,$Conex);
	
	 return $result;  
  
  }
    
   
  public function getDataSeguroPoliza($Conex,$empresa_id){
  
     $select = "SELECT aseguradora_id, numero AS numero_poliza,fecha_vencimiento  FROM poliza_empresa p WHERE estado = 'A'";
	 $result = $this -> DbFetchAll($select,$Conex);
	
	 return $result;   
  
  }
  
  
  
  public function getCiudadIdRemitenteDestinatario($remitente_destinatario_id,$Conex){
  
    $select = "SELECT ubicacion_id FROM remitente_destinatario WHERE remitente_destinatario_id = $remitente_destinatario_id";
	$result = $this -> DbFetchAll($select,$Conex);
	
	return $result;   
	
  } 
  
  public function getAseguradoras($Conex,$empresa_id){
  
	$select = "SELECT aseguradora_id AS value,nombre_aseguradora AS text, (SELECT aseguradora_id  FROM poliza_empresa WHERE empresa_id = $empresa_id AND estado = 'A') 
	AS selected FROM aseguradora a";
	
	$result = $this -> DbFetchAll($select,$Conex);
   
	return $result;       
 
 }


  
  public function selectRemesaComplemento($numero_remesa,$Conex){
	  
	$dataRemesa = array();
    				
    $select = "SELECT r.*,(SELECT CONCAT_WS(' ',razon_social,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido) FROM tercero WHERE tercero_id = 
	(SELECT tercero_id FROM cliente WHERE cliente_id = r.cliente_id)) AS cliente,(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) AS origen,
	(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino,(SELECT codigo FROM producto WHERE producto_id=r.producto_id) AS producto,r.propietario_mercancia AS propietario_mercancia_txt FROM remesa r WHERE TRIM(r.numero_remesa) = TRIM('$numero_remesa')";
				
	$result = $this -> DbFetchAll($select,$Conex,true);

	$remesa_id                         = $result[0]['remesa_id'];	
	$result[0]['remesa_id']            = null;
	$result[0]['numero_remesa_padre']  = $result[0]['numero_remesa'];
	$result[0]['numero_remesa']        = null;						
	$dataRemesa[0]['remesa']           = $result;
	
    $select = "SELECT item,detalle_remesa_id,detalle_ss_id,referencia_producto,descripcion_producto AS descripcion_producto_detalle,cantidad AS cantidad_detalle,PESO as    peso_detalle,valor AS valor_detalle,peso_volumen AS peso_volumen_detalle,guia_cliente,observaciones FROM detalle_remesa WHERE remesa_id = $remesa_id";
	
	$result = $this -> DbFetchAll($select,$Conex,true);	
				
	$dataRemesa[0]['detalle_remesa'] = $result;	
	
	return $dataRemesa;
  }  
  
  //BUSQUEDA
  public function selectRemesa(){
	  
    $remesa_id  = $this -> requestDataForQuery('remesa_id','integer');
	$dataRemesa = array();
    				
    $select = "SELECT r.*,(SELECT GROUP_CONCAT(manifiesto) 
	 FROM manifiesto WHERE manifiesto_id IN (SELECT manifiesto_id FROM detalle_despacho WHERE remesa_id = r.remesa_id)) AS manifiestos,(SELECT CONCAT_WS(' ',razon_social,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido) FROM tercero WHERE tercero_id = 
	(SELECT tercero_id FROM cliente WHERE cliente_id = r.cliente_id)) AS cliente,(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) AS origen,
	(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino,(SELECT codigo FROM producto WHERE producto_id=r.producto_id) AS producto FROM remesa  WHERE r.remesa_id = $remesa_id";
				
	$result = $this -> DbFetchAll($select,$Conex,true);
			
	$dataRemesa[0]['remesa'] = $result;
	
    $select = "SELECT item,detalle_remesa_id,detalle_ss_id,referencia_producto,descripcion_producto AS descripcion_producto_detalle,cantidad AS cantidad_detalle,PESO as    peso_detalle,valor AS valor_detalle,peso_volumen AS peso_volumen_detalle,guia_cliente,observaciones FROM detalle_remesa WHERE remesa_id = $remesa_id";
	
	$result = $this -> DbFetchAll($select,$Conex,true);	
				
	$dataRemesa[0]['detalle_remesa'] = $result;	
	
	return $dataRemesa;
  }
  
  
  
  public function esRemesaPrincipal($numero_remesa,$Conex){
  
    $select = "SELECT * FROM remesa WHERE TRIM(numero_remesa_padre) = TRIM('$numero_remesa')";
	$result = $this -> DbFetchAll($select,$Conex,true);
	
	if(count($result) > 0){
	  return true;
	}else{
	     return false;
	  }
  
  }

  public function SelectContactosRemesa($Conex){
	  
    $remesa_id  = $this -> requestDataForQuery('remesa_id','integer');
  
    $select = "SELECT contacto_id FROM contacto_remesa WHERE remesa_id = $remesa_id";

	$result = $this -> DbFetchAll($select,$Conex,true);
	
	return $result;  
  
  }


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
  
  
  public function validaValorMaximoPoliza($empresa_id,$valor,$Conex){
  
  
     $select = "SELECT valor_maximo_despacho FROM poliza_empresa WHERE empresa_id = $empresa_id AND estado = 'A'";
     $result = $this -> DbFetchAll($select,$Conex,true);
	
     if(count($result) > 0){
       return $result[0]['valor_maximo_despacho'];      
     }else{
         return null;
       }
     
  
  }
  
  public function selectDataPropietario($tercero_id,$Conex){
  
    $select = "SELECT tercero_id AS propietario_mercancia_id,  
    CONCAT_WS(' ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,sigla) AS propietario_mercancia_txt,    
    (SELECT codigo FROM tipo_identificacion WHERE tipo_identificacion_id = t.tipo_identificacion_id) AS tipo_identificacion_propietario_mercancia,
    numero_identificacion AS numero_identificacion_propietario_mercancia FROM tercero t WHERE tercero_id = $tercero_id";
    
    $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);  
    
    return $result;
  
  }
  
  public function selectDataPropietarioCliente($cliente_id,$Conex){
  
    $select = "SELECT tercero_id AS propietario_mercancia_id, 
					CONCAT_WS(' ',(CONCAT_WS('-',numero_identificacion,digito_verificacion)),primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,razon_social) AS propietario_mercancia,
    CONCAT_WS(' ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,sigla) AS propietario_mercancia_txt,    
    (SELECT codigo FROM tipo_identificacion WHERE tipo_identificacion_id = t.tipo_identificacion_id) AS tipo_identificacion_propietario_mercancia,
    numero_identificacion AS numero_identificacion_propietario_mercancia FROM tercero t WHERE tercero_id = (SELECT tercero_id FROM cliente WHERE cliente_id = $cliente_id)";
    
    $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);  
    
    return $result;  
  
  }
  
    public function selectDataClienteRemitente($cliente_id,$Conex){
  
     $select = "SELECT r.*, nombre AS remitente_destinatario,(SELECT nombre FROM ubicacion WHERE ubicacion_id = r.ubicacion_id) AS origen, r.ubicacion_id AS origen_id FROM remitente_destinatario r WHERE tercero_id = 
	 (SELECT tercero_id FROM cliente WHERE cliente_id = $cliente_id)";
	 
	 $result = $this -> DbFetchAll($select,$Conex,true);
	
	 return $result;   
  
  }  
  
	public function getCausalesAnulacion($Conex){
		
		$select = "SELECT causal_anulacion_id AS value,nombre AS text FROM causal_anulacion ORDER BY nombre";
		$result = $this -> DbFetchAll($select,$Conex);
		
		return $result;		
		
    }  
	
	public function getProductos($Conex){
	
	   $select = "SELECT producto_id AS value,CONCAT(SUBSTRING(producto_empresa,1,45),' - ',codigo) AS text, producto AS title FROM
	    producto WHERE mostrar = 1 /*OR producto_id IN (SELECT distinct producto_id FROM remesa WHERE estado != 'A')*/ ORDER BY 
		producto_empresa ASC";
		
	   $result = $this -> DbFetchAll($select,$Conex);
		
	   return $result;			
	   
	}
 
   
}
?>