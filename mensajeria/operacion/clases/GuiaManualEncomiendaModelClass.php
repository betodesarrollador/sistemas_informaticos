<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class GuiaManualEncomiendaModel extends Db{

  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  
  //LISTA MENU
  public function getClientes($oficina_id,$Conex){
	  

	  $select1 = "SELECT cliente_id 
	  FROM oficina WHERE oficina_id = $oficina_id";
	  $result1 = $this -> DbFetchAll($select1,$Conex);

	  if($result1[0][cliente_id]>0){
		  $cliente_id=$result1[0][cliente_id];
		  $select = "SELECT cliente_id AS value,(SELECT CONCAT_WS(' ',razon_social,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido)
		   															  
		  FROM tercero WHERE tercero_id = c.tercero_id) AS text, $cliente_id AS selected FROM cliente c WHERE estado = 'D' AND   cliente_id= $cliente_id ORDER BY nombre_cliente ASC";
		  $result = $this -> DbFetchAll($select,$Conex);
	
	  }else{
		  $select = "SELECT cliente_id AS value,(SELECT CONCAT_WS(' ',razon_social,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido) 
		  FROM tercero WHERE tercero_id = c.tercero_id) AS text FROM cliente c WHERE estado = 'D'   ORDER BY nombre_cliente ASC";
		  $result = $this -> DbFetchAll($select,$Conex);
	  }
	  return $result;	  
	  
  }
  
  public function GetUnidadMedida($Conex){
	return $this -> DbFetchAll("SELECT medida_id AS value,medida AS text FROM medida ORDER BY medida",$Conex,$ErrDb = false);
  }
 
  public function getTipoEnvio1($destino_id,$Conex){ 
     $select = "SELECT tipo_envio_id FROM ubicacion WHERE ubicacion_id = $destino_id";
	 $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	 return $result[0]['tipo_envio_id'];    
  }  
  public function getTipoEnvioMetro($origen_id,$destino_id,$Conex){ 
     $select = "SELECT ubicacion_id FROM ubicacion WHERE ubicacion_id = $destino_id AND metropolitana_id=$origen_id";
	 $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	 if($result[0]['ubicacion_id']>0){
		 return true;    
	 }else{
		 return false;
	 }
  }  

 
   public function setInsertDetalleSolicitud($rowInsert,$oficina_id,$usuario_id,$Conex){
        
	  $this -> Begin($Conex);							
		
	  $guia_encomienda_id = $this -> DbgetMaxConsecutive("guia_encomienda","guia_encomienda_id",$Conex,false,1);
	  
	  $fecha_guia                 	= date('Y-m-d');
	  $numero_guia                 	= $rowInsert[GUIA];

	  $origen                 		= $rowInsert[ORIGEN];
      $doc_remitente             	= $rowInsert[DOC_REMITENTE];
	  $remitente                	= $rowInsert[REMITENTE];
	  $direccion_remitente       	= $rowInsert[DIRECCION_REMITENTE];
	  $telefono_remitente	        = $rowInsert[TELEFONO_REMITENTE];	

	  $destino                 		= $rowInsert[DESTINO];
      $doc_destinatario             = $rowInsert[DOC_DESTINATARIO];
	  $destinatario                 = $rowInsert[DESTINATARIO];
	  $direccion_destinatario       = $rowInsert[DIRECCION_DESTINATARIO];
	  $telefono_destinatario        = $rowInsert[TELEFONO_DESTINATARIO];	
	  
	  $descripcion_producto         = $rowInsert[PRODUCTO];	
	  $cantidad            			= $rowInsert[CANTIDAD];	
	  $peso	            			= $rowInsert[PESO];	
	  $valor	            		= $rowInsert[VALOR_DECLARADO];	
	  
	  $valor_flete            		= $rowInsert[VALOR_FLETE]>0 ? $rowInsert[VALOR_FLETE] : 'NULL';	
	  $valor_seguro            		= $rowInsert[VALOR_SEGURO]>0 ? $rowInsert[VALOR_SEGURO] : 'NULL';	
	  $valor_descuento         		= $rowInsert[VALOR_DESCUENTO]>0 ? $rowInsert[VALOR_DESCUENTO] : 'NULL';	
	  
	  $valor_total            		= $rowInsert[VALOR_TOTAL]>0 ? $rowInsert[VALOR_TOTAL] : 'NULL';	
	  
	  $PROCESO	            		= $rowInsert[PROCESO]!='' ? "'".$rowInsert[PROCESO]."'" : "NULL" ;	
	  $PEDIDO	            		= $rowInsert[PEDIDO]!='' ? "'".$rowInsert[PEDIDO]."'" : "NULL" ;		
	  $UNIDAD	            		= $rowInsert[UNIDAD]!='' ? "'".$rowInsert[UNIDAD]."'" : "NULL" ;			
	  
	  

	  //$select_clientet = "SELECT (SELECT cliente_id FROM cliente WHERE tercero_id=t.tercero_id) AS cliente_id FROM tercero t  WHERE numero_identificacion=$cliente";
	  //$result_clientet = $this -> DbFetchAll($select_clientet,$Conex);

	  /*
	  if($result_clientet[0][cliente_id]==''){
		  return "Cliente ".$cliente." No existe";
	  }else{
		  $cliente_id=$result_clientet[0][cliente_id];
	  }*/

	   /*$select_cliente = "SELECT (SELECT t.tipo_identificacion_id FROM  tercero t WHERE t.tercero_id=c.tercero_id)  AS tipo_identificacion_id,
	   			  (SELECT CONCAT_WS(' ',razon_social,primer_nombre,	segundo_nombre,primer_apellido,segundo_apellido) FROM tercero WHERE tercero_id=c.tercero_id) AS remitente,
				  (SELECT numero_identificacion FROM tercero WHERE tercero_id=c.tercero_id) AS doc_remitente,
				  IF((SELECT oficina_id FROM oficina WHERE cliente_id=c.cliente_id AND oficina_id=$oficina_id)>0,(SELECT direccion FROM oficina WHERE cliente_id=c.cliente_id AND oficina_id=$oficina_id), (SELECT direccion FROM tercero WHERE tercero_id=c.tercero_id) ) AS direccion_remitente,
				  IF((SELECT oficina_id FROM oficina WHERE cliente_id=c.cliente_id AND oficina_id=$oficina_id)>0,(SELECT telefono FROM oficina WHERE cliente_id=c.cliente_id AND oficina_id=$oficina_id), (SELECT telefono FROM tercero WHERE tercero_id=c.tercero_id) ) AS telefono_remitente,
				  IF((SELECT oficina_id FROM oficina WHERE cliente_id=c.cliente_id AND oficina_id=$oficina_id)>0,(SELECT ubicacion_id FROM oficina WHERE cliente_id=c.cliente_id AND oficina_id=$oficina_id), (SELECT ubicacion_id FROM tercero WHERE tercero_id=c.tercero_id) ) AS origen_id				  
	   			  FROM cliente c
	   			  WHERE c.cliente_id = $cliente_id ";

	  $result_cliente = $this -> DbFetchAll($select_cliente,$Conex);

	  if(count($result_cliente)==1){
		  $tipo_identificacion_id=$result_cliente[0][tipo_identificacion_id];
		  $tipo_identificacion_remitente_id=$result_cliente[0][tipo_identificacion_id];
		  $remitente= $rowInsert[REMITENTE]!='' ? $rowInsert[REMITENTE] : $result_cliente[0][remitente];
		  $doc_remitente=$result_cliente[0][doc_remitente];
		  $direccion_remitente=$result_cliente[0][direccion_remitente];
		  $telefono_remitente=$result_cliente[0][telefono_remitente];
	  }else{
		  return "No Existe Datos del Cliente";
	  }

	  if($peso>5000){
			exit ('El Peso de la Guia debe ser Inferior a 5.000 Gramos');	
	  }*/
		

	  if($peso<5000){
			exit ('El Peso de la Guia Encomienda debe ser Mayor a 5.1 kg (5.100 Gramos) ');	
	  }

	  if($valor_flete>0){
		 $si=1;
	  }else{
		 exit ('Una de los registros no tiene valor Flete!!');	 
	  }

	  if($valor_total>0){
		 $si=1;
	  }else{
		 exit ('Una de los registros no tiene valor Total');	 
	  }


	  $select_guia = "SELECT numero_guia FROM guia_encomienda WHERE numero_guia=$numero_guia AND prefijo='EM'";
	  $result_guia = $this -> DbFetchAll($select_guia,$Conex);
	  
	  if($result_guia[0][numero_guia]>0){
		  return "Guia ".$numero_guia." Ya existente";
	  }

	  $select_oficina = "SELECT ubicacion_id FROM oficina WHERE oficina_id=$oficina_id";
	  $result_oficina = $this -> DbFetchAll($select_oficina,$Conex);

	  $select_origen = "SELECT ubicacion_id FROM ubicacion WHERE TRIM(nombre) LIKE TRIM('$origen') AND tipo_ubicacion_id=3 AND estado_mensajeria = 1";
	  $result_origen = $this -> DbFetchAll($select_origen,$Conex);
	  
	  if($result_origen[0][ubicacion_id]=='' || $result_origen[0][ubicacion_id]==NULL || $result_origen[0][ubicacion_id]=='NULL'){
		  return "El Origen ".$origen." No Existe en la Base de datos. Guia: ".$numero_guia;
	  }else{
		  $origen_id=$result_origen[0][ubicacion_id];
	  }

	  if($result_oficina[0]['ubicacion_id']!=$result_origen[0]['ubicacion_id']) exit('El Origen '.$origen.' No coincide con la oficina generadora. Guia: '.$numero_guia);

	  $select_destino = "SELECT ubicacion_id FROM ubicacion WHERE TRIM(nombre) LIKE TRIM('$destino') AND tipo_ubicacion_id=3";
	  $result_destino = $this -> DbFetchAll($select_destino,$Conex);
	  
	  if($result_destino[0][ubicacion_id]=='' || $result_destino[0][ubicacion_id]==NULL || $result_destino[0][ubicacion_id]=='NULL'){
		  return "El Destino ".$destino." No Existe en la Base de datos. Guia: ".$numero_guia;
	  }else{
		  $destino_id=$result_destino[0][ubicacion_id];
	  }



	if($origen_id==$destino_id){ 
		$tipo_envio_id=2;
	}else{
		$tipo_envio_id=$this -> getTipoEnvio1($destino_id,$Conex);
	}

	if($this -> getTipoEnvioMetro($origen_id,$destino_id,$Conex) ) $tipo_envio_id=2;	

	  if($tipo_envio_id=='' || $tipo_envio_id==NULL || $tipo_envio_id=='NULL')
		  exit ("El Tipo de Envio Para el Destino ".$destino." No Existe en la Base de datos. Guia: ".$numero_guia);
	  

	  $insert = "INSERT INTO guia_encomienda (guia_encomienda_id,oficina_id,tipo_servicio_mensajeria_id,tipo_envio_id,forma_pago_mensajeria_id,crm,
						estado_mensajeria_id,estado_cliente,fecha_guia,numero_guia,prefijo,origen_id,destino_id,
						remitente,doc_remitente,direccion_remitente,telefono_remitente,
						destinatario,doc_destinatario,direccion_destinatario,telefono_destinatario,
						descripcion_producto,peso,medida_id,cantidad,valor,valor_flete,valor_seguro,valor_descuento,valor_total,manual,proceso,pedido,unidad,usuario_id) 
	  VALUES ($guia_encomienda_id,$oficina_id,5,$tipo_envio_id,1,1,
			  1,'EL','$fecha_guia',$numero_guia,'EM',$origen_id,$destino_id,
			  '$remitente','$doc_remitente','$direccion_remitente','$telefono_remitente',
			  '$destinatario','$doc_destinatario','$direccion_destinatario','$telefono_destinatario', 
			  '$descripcion_producto',$peso,38,$cantidad,$valor,$valor_flete,$valor_seguro,$valor_descuento,$valor_total,1,$PROCESO,$PEDIDO,$UNIDAD,$usuario_id);";
	  
	  $this -> query($insert,$Conex,true);


	 $this -> Commit($Conex);
   }
  
}


?>