<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class GuiaInterconexionModel extends Db{

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

 
   public function setInsertDetalleSolicitud($rowInsert,$oficina_id,$Conex){
        
	  $this -> Begin($Conex);							
		
	  $guia_interconexion_id 		= $this -> DbgetMaxConsecutive("guia_interconexion","guia_interconexion_id",$Conex,false,1);
	  
	  $fecha_guia                 	= date('Y-m-d');
	  $numero_guia                 	= $rowInsert[GUIA];
	  $destino                 		= $rowInsert[DESTINO];
	  $origen                 		= $rowInsert[ORIGEN];	  
      $destinatario                 = $rowInsert[DESTINATARIO];
	  $direccion_destinatario       = $rowInsert[DIRECCION_DESTINATARIO];
	  $telefono_destinatario        = $rowInsert[TELEFONO_DESTINATARIO];	
	  $descripcion_producto         = $rowInsert[PRODUCTO];	
	  $cantidad            			= $rowInsert[CANTIDAD];	
	  $peso	            			= $rowInsert[PESO];	
	  $tipo_servicio_mensajeria_id	= $rowInsert[TIPO];		  
	  $cliente	            		= $rowInsert[CLIENTE];	
  	  $observaciones           		= $rowInsert[ORDEN_SERVICIO];	
	  $guia_cliente	            	= $rowInsert[CEDULA];	
	  $valor	            		= $rowInsert[VALOR_DECLARADO];	
	  
	  $NIT_DESTINATARIO        		= $rowInsert[NIT_DESTINATARIO]!='' ? "'".$rowInsert[NIT_DESTINATARIO]."'" : "NULL" ;	
	  $PROCESO	            		= $rowInsert[PROCESO]!='' ? "'".$rowInsert[PROCESO]."'" : "NULL" ;	
	  $PEDIDO	            		= $rowInsert[PEDIDO]!='' ? "'".$rowInsert[PEDIDO]."'" : "NULL" ;		
	  $UNIDAD	            		= $rowInsert[UNIDAD]!='' ? "'".$rowInsert[UNIDAD]."'" : "NULL" ;			
	  $FACTURAS	            		= $rowInsert[FACTURAS]!='' ? "'".$rowInsert[FACTURAS]."'" : "NULL" ;	
	  $TIPO_SER_CLIENTE	            = $rowInsert[TIPO_SER_CLIENTE]!='' ? "'".$rowInsert[TIPO_SER_CLIENTE]."'" : "NULL" ;	
	  
	   

	  $select_clientet = "SELECT (SELECT cliente_id FROM cliente WHERE tercero_id=t.tercero_id) AS cliente_id FROM tercero t  WHERE numero_identificacion=$cliente";
	  $result_clientet = $this -> DbFetchAll($select_clientet,$Conex);

	  if($peso>5000){
			exit ('El Peso de la Guia debe ser Inferior a 5.000 Gramos');	
	  }
		
	  if($result_clientet[0][cliente_id]==''){
		  return "Cliente ".$cliente." No existe";
	  }else{
		  $cliente_id=$result_clientet[0][cliente_id];
	  }

	  $select_guia = "SELECT numero_guia FROM guia_interconexion WHERE numero_guia='$numero_guia'";
	  $result_guia = $this -> DbFetchAll($select_guia,$Conex);
	  
	  if($result_guia[0]['numero_guia']!='' && $result_guia[0]['numero_guia']!=NULL && $result_guia[0]['numero_guia']!='NULL'){
		  return "Guia ".$numero_guia." Ya existente";
	  }
	  
	  $select_origen = "SELECT ubicacion_id FROM ubicacion WHERE TRIM(nombre) LIKE TRIM('$origen') AND tipo_ubicacion_id=3";
	  $result_origen = $this -> DbFetchAll($select_origen,$Conex);
	  
	  if($result_origen[0][ubicacion_id]=='' || $result_origen[0][ubicacion_id]==NULL || $result_origen[0][ubicacion_id]=='NULL'){
		  return "El Origen ".$origen." No Existe en la Base de datos. Guia: ".$numero_guia;
	  }else{
		  $origen_id=$result_origen[0][ubicacion_id];
	  }	  

	  $select_destino = "SELECT ubicacion_id FROM ubicacion WHERE TRIM(nombre) LIKE TRIM('$destino') AND tipo_ubicacion_id=3";
	  $result_destino = $this -> DbFetchAll($select_destino,$Conex);
	  
	  if($result_destino[0][ubicacion_id]=='' || $result_destino[0][ubicacion_id]==NULL || $result_destino[0][ubicacion_id]=='NULL'){
		  return "El Destino ".$destino." No Existe en la Base de datos. Guia: ".$numero_guia;
	  }else{
		  $destino_id=$result_destino[0][ubicacion_id];
	  }


	   $select_cliente = "SELECT (SELECT t.tipo_identificacion_id FROM  tercero t WHERE t.tercero_id=c.tercero_id)  AS tipo_identificacion_id,
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

	if($origen_id==$destino_id){ 
		$tipo_envio_id=2;
	}else{
		$tipo_envio_id=$this -> getTipoEnvio1($destino_id,$Conex);
	}

	if($this -> getTipoEnvioMetro($origen_id,$destino_id,$Conex) ) $tipo_envio_id=2;	

	  $insert = "INSERT INTO guia_interconexion (guia_interconexion_id,oficina_id,tipo_servicio_mensajeria_id,tipo_envio_id,forma_pago_mensajeria_id,
						estado_mensajeria_id,estado_cliente,fecha_guia,numero_guia,cliente_id,origen_id,destino_id,tipo_servicio_cliente,observaciones,guia_cliente,
						tipo_identificacion_id,remitente,tipo_identificacion_remitente_id,doc_remitente,direccion_remitente,telefono_remitente,
						destinatario,direccion_destinatario,telefono_destinatario,descripcion_producto,peso,medida_id,cantidad,valor,manual,doc_destinatario,proceso,pedido,unidad,facturas) 
	  VALUES ($guia_interconexion_id,$oficina_id,$tipo_servicio_mensajeria_id,$tipo_envio_id,2,
			  1,'EL','$fecha_guia','$numero_guia',$cliente_id,$origen_id,$destino_id,$TIPO_SER_CLIENTE,'$observaciones','$guia_cliente',
			  $tipo_identificacion_id,'$remitente',$tipo_identificacion_remitente_id,'$doc_remitente','$direccion_remitente','$telefono_remitente',
			  '$destinatario','$direccion_destinatario','$telefono_destinatario', '$descripcion_producto',$peso,38,$cantidad,$valor,1,$NIT_DESTINATARIO,$PROCESO,$PEDIDO,$UNIDAD,$FACTURAS);";
	  
	  $this -> query($insert,$Conex,true);


	 $this -> Commit($Conex);
   }
  
}


?>