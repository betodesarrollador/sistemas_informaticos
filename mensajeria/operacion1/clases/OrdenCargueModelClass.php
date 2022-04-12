<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class OrdenCargueModel extends Db{

  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  public function Save($oficina_id,$Campos,$Conex){
	
    $select = "SELECT (MAX(consecutivo)+1) AS conse FROM orden_cargue WHERE oficina_id=$oficina_id";
    $result = $this -> DbFetchAll($select,$Conex);
	$consecutivo= $result[0][conse]>0 ? $result[0][conse]:1;

    $orden_cargue_id    = $this -> DbgetMaxConsecutive("orden_cargue","orden_cargue_id",$Conex,true,1);	
    $this -> assignValRequest('orden_cargue_id',$orden_cargue_id);
	$this -> assignValRequest('consecutivo',$consecutivo);
    $this -> Begin($Conex);
      $this -> DbInsertTable("orden_cargue",$Campos,$Conex,true,false);
    $this -> Commit($Conex);
    return array(array(orden_cargue_id=>$orden_cargue_id,consecutivo=>$consecutivo));
  }
  
  public function Update($Campos,$Conex){ 

    $this -> Begin($Conex);
     $this -> DbUpdateTable("orden_cargue",$Campos,$Conex,true,false);
    $this -> Commit($Conex);
	 
  }
  


//LISTA MENU


  public function getUnidadesVolumen($Conex){

    $select = "SELECT medida_id AS value,medida AS text FROM medida WHERE tipo_unidad_medida_id = 11 ORDER BY medida ASC";
    $result = $this -> DbFetchAll($select,$Conex);

    return $result;

  }
  
  public function getUnidades($Conex){

    $select = "SELECT medida_id AS value,medida AS text FROM medida WHERE ministerio = 1 ORDER BY medida ASC";
    $result = $this -> DbFetchAll($select,$Conex);

    return $result;

  }

  public function GetTiposServicio($Conex){
	return $this  -> DbFetchAll("SELECT tipo_servicio_id AS value,tipo_servicio AS text FROM tipo_servicio ORDER BY tipo_servicio",$Conex,$ErrDb = false);  
	
  }
  
  
  
  public function selectVehiculo($placa_id,$Conex){
  
    $select = "SELECT (SELECT marca FROM marca WHERE marca_id = v.marca_id) AS marca,(SELECT linea FROM linea WHERE linea_id = v.linea_id) AS linea,modelo_vehiculo AS modelo,modelo_repotenciado,(SELECT color FROM color WHERE color_id = v.color_id) AS color,(SELECT carroceria FROM carroceria WHERE carroceria_id = v.carroceria_id) AS carroceria,registro_nacional_carga,configuracion,peso_vacio,numero_soat,(SELECT nombre_aseguradora FROM aseguradora WHERE aseguradora_id = v.aseguradora_soat_id) AS nombre_aseguradora,vencimiento_soat,placa_id,(SELECT placa_remolque FROM remolque WHERE placa_remolque_id = v.placa_remolque_id) AS placa_remolque,placa_remolque_id,
	(SELECT CONCAT_WS(' ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,sigla) FROM tercero WHERE tercero_id = v.propietario_id) AS propietario,(SELECT direccion FROM tercero WHERE tercero_id = v.propietario_id) AS numero_identificacion_propietario,(SELECT direccion FROM tercero WHERE tercero_id = v.propietario_id) AS direccion_propietario,(SELECT  numero_identificacion FROM tercero WHERE tercero_id = v.propietario_id) AS numero_identificacion_propietario,(SELECT telefono FROM tercero WHERE tercero_id = v.propietario_id) AS telefono_propietario,(SELECT nombre FROM ubicacion WHERE ubicacion_id = (SELECT ubicacion_id FROM tercero WHERE tercero_id = v.propietario_id)) AS ciudad_propietario,(SELECT CONCAT_WS(' ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,sigla) FROM tercero WHERE tercero_id = (SELECT tercero_id FROM tenedor WHERE tenedor_id = v.tenedor_id)) AS tenedor,v.tenedor_id,(SELECT numero_identificacion FROM tercero WHERE tercero_id = (SELECT tercero_id FROM tenedor WHERE 	tenedor_id = v.tenedor_id))
 	AS numero_identificacion_tenedor,	
	(SELECT numero_identificacion FROM tercero WHERE tercero_id = (SELECT tercero_id FROM tenedor WHERE tenedor_id = v.tenedor_id)) AS direccion_tenedor,	
	(SELECT numero_identificacion FROM tercero WHERE tercero_id = (SELECT tercero_id FROM tenedor WHERE tenedor_id = v.tenedor_id)) AS numero_identificacion_tenedor,
	(SELECT telefono FROM tercero WHERE tercero_id = (SELECT tercero_id FROM tenedor WHERE tenedor_id = v.tenedor_id)) AS telefono_tenedor,(SELECT nombre FROM ubicacion WHERE ubicacion_id = (SELECT ubicacion_id FROM tercero WHERE tercero_id = (SELECT tercero_id FROM tenedor WHERE tenedor_id = v.tenedor_id))) AS ciudad_tenedor,conductor_id,(SELECT numero_identificacion FROM tercero WHERE tercero_id = (SELECT tercero_id FROM conductor WHERE conductor_id = v.conductor_id)) AS
	numero_identificacion,(SELECT CONCAT_WS(' ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido) FROM tercero WHERE tercero_id = (SELECT tercero_id FROM conductor WHERE conductor_id = v.conductor_id)) AS nombre,(SELECT direccion FROM tercero WHERE tercero_id = (SELECT tercero_id FROM conductor WHERE conductor_id = v.conductor_id)) AS direccion_conductor,(SELECT telefono FROM tercero WHERE tercero_id = (SELECT tercero_id FROM conductor WHERE conductor_id = v.conductor_id)) AS 
	telefono_conductor,(SELECT nombre FROM ubicacion WHERE ubicacion_id = (SELECT ubicacion_id FROM tercero WHERE tercero_id = 
	(SELECT tercero_id FROM conductor 
			WHERE conductor_id = v.conductor_id))) AS ciudad_conductor,
			(SELECT categoria FROM categoria_licencia WHERE categoria_id = (SELECT categoria_id FROM conductor WHERE conductor_id = v.conductor_id)) AS categoria_licencia_conductor,
			(SELECT numero_licencia_cond FROM conductor WHERE conductor_id = v.conductor_id) numero_licencia_cond,
			chasis AS serie,(SELECT remolque FROM tipo_vehiculo WHERE tipo_vehiculo_id = v.tipo_vehiculo_id) AS remolque FROM vehiculo v WHERE placa_id = $placa_id ";	  
			
	$result = $this -> DbFetchAll($select,$Conex,false);
	
	return $result; 
  
  } 
  
  public function selectConductor($conductor_id,$Conex){
  
     $select = "SELECT c.conductor_id,concat_ws(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) AS nombre,t.numero_identificacion,
     (SELECT categoria FROM categoria_licencia WHERE categoria_id = c.categoria_id) AS categoria_licencia_conductor,t.direccion AS direccion_conductor,t.telefono AS  
	  telefono_conductor,c.numero_licencia_cond,(SELECT nombre FROM ubicacion WHERE ubicacion_id = t.ubicacion_id) AS ciudad_conductor FROM conductor c, tercero t  WHERE 
	  t.tercero_id = c.tercero_id AND c.conductor_id = $conductor_id";
	  
	 $result = $this -> DbFetchAll($select,$Conex,false);
	
	 return $result; 
  
  }  

//BUSQUEDA
  public function selectorden_cargue($orden_cargue_id,$Conex){
    				
    $select = "SELECT o.orden_cargue_id,o.detalle_ss_id,o.detalle_solicitud,o.consecutivo, o.fecha,	o.cliente_id,o.cliente,o.cliente_nit,o.cliente_tel,o.direccion_cargue,o.tipo_servicio_id,
					o.estado, o.hora,o.origen_id,o.destino_id,o.producto,o.producto_id,o.unidad_peso_id,o.unidad_volumen_id,o.peso,o.peso_volumen,o.cantidad_cargue,
					o.placa_id,o.placa,o.placa_remolque_id,o.marca,o.linea,o.modelo,o.modelo_repotenciado,o.serie,o.color,o.carroceria,o.registro_nacional_carga,
					o.configuracion,o.peso_vacio,o.numero_soat,o.nombre_aseguradora,o.vencimiento_soat,o.placa_remolque,o.tenedor_id,o.tenedor,o.numero_identificacion_tenedor,
					o.direccion_tenedor,o.telefono_tenedor,o.ciudad_tenedor,o.propietario,o.numero_identificacion_propietario,o.direccion_propietario,o.telefono_propietario,
					o.ciudad_propietario,o.conductor_id,o.numero_identificacion,o.nombre,o.direccion_conductor,o.telefono_conductor,o.ciudad_conductor,o.categoria_licencia_conductor,
					(SELECT nombre FROM ubicacion WHERE ubicacion_id=o.origen_id) AS origen,
					(SELECT nombre FROM ubicacion WHERE ubicacion_id=o.destino_id) AS destino					
				FROM orden_cargue o  WHERE o.orden_cargue_id=$orden_cargue_id";				
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	
	return $result;
  }
  
  
  public function getDataCliente($cliente_id,$Conex){

    $select = "SELECT  tr.telefono AS cliente_tel,
	 					tr.direccion AS direccion_cargue, 
						tr.numero_identificacion AS cliente_nit,
						CONCAT_WS(' ',tr.primer_nombre,tr.segundo_nombre,tr.primer_apellido,tr.segundo_apellido,tr.razon_social) AS cliente
	 FROM cliente p, tercero tr WHERE p.cliente_id = $cliente_id AND tr.tercero_id = p.tercero_id";
     $result = $this -> DbFetchAll($select,$Conex,false);
     return $result;

  }

  public function getDataSolicitud($detalle_ss_id,$Conex){

     $select = "SELECT  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) AS nombre FROM cliente c, tercero t WHERE c.cliente_id=s.cliente_id AND t.tercero_id=c.tercero_id) AS cliente,
						(SELECT t.numero_identificacion FROM cliente c, tercero t WHERE c.cliente_id=s.cliente_id AND t.tercero_id=c.tercero_id) AS cliente_nit,
						s.cliente_id,
						s.tipo_servicio_id,
						s.fecha_recogida_ss AS fecha,
						s.hora_recogida_ss AS hora,
						d.direccion_remitente AS direccion_cargue,
						d.telefono_remitente  AS cliente_tel,
						d.origen_id,
						d.destino_id,
						(SELECT nombre FROM ubicacion WHERE ubicacion_id=d.origen_id) AS origen,
						(SELECT nombre FROM ubicacion WHERE ubicacion_id=d.destino_id) AS destino,
						d.unidad_peso_id,
						d.unidad_volumen_id,
						d.cantidad AS cantidad_cargue,
						d.descripcion_producto AS producto,
						d.peso,
						d.peso_volumen
	 FROM detalle_solicitud_servicio d, solicitud_servicio s WHERE d.detalle_ss_id = $detalle_ss_id AND s.solicitud_id=d.solicitud_id";
     $result = $this -> DbFetchAll($select,$Conex,false);
     return $result;

  }

  public function getContactos($ClienteId,$orden_cargue_id,$Conex){
  
    $select = "SELECT contacto_id AS value,nombre_contacto AS text,(SELECT contacto_id FROM orden_cargue WHERE orden_cargue_id = '$orden_cargue_id') AS selected 
				FROM contacto 
				WHERE cliente_id =  $ClienteId"; 
	
	$result = $this -> DbFetchAll($select,$Conex);
	
	return $result;
  
  }
  
  function selectDataTitular($tenedor_id,$Conex){
  	
  	  $select = "SELECT tn.tercero_id AS titular_manifiesto_id,UPPER(CONCAT_WS(' ',
	  t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.sigla)) AS titular_manifiesto,t.numero_identificacion 
	  AS numero_identificacion_titular_manifiesto,t.direccion AS direccion_titular_manifiesto,t.telefono AS telefono_titular_manifiesto,
     (SELECT nombre FROM ubicacion WHERE ubicacion_id = t.ubicacion_id) AS ciudad_titular_manifiesto,(SELECT divipola FROM ubicacion 
     WHERE ubicacion_id = t.ubicacion_id) AS ciudad_titular_manifiesto_divipola FROM tenedor tn, tercero t WHERE 
     tn.tenedor_id = $tenedor_id AND tn.tercero_id = t.tercero_id";
     
     $result = $this -> DbFetchAll($select,$Conex,false);
     
     return $result;  	
  	
  	}

	public function cancellation($Conex){
	 
	
	$this -> Begin($Conex);
	
	  $orden_cargue_id 			= $this -> requestDataForQuery('orden_cargue_id','integer');
	  $anul_orden_cargue    	= $this -> requestDataForQuery('anul_orden_cargue','text');
	  $desc_anul_orden_cargue   = $this -> requestDataForQuery('desc_anul_orden_cargue','text');
	  $anul_usuario_id          = $this -> requestDataForQuery('anul_usuario_id','integer');	
	  
	  $update = "UPDATE orden_cargue SET estado= 'A',
					anul_orden_cargue=$anul_orden_cargue,
					desc_anul_orden_cargue =$desc_anul_orden_cargue,
					anul_usuario_id=$anul_usuario_id
				WHERE orden_cargue_id=$orden_cargue_id";	
	  $this -> query($update,$Conex);		  
	
	  if(strlen($this -> GetError()) > 0){
		$this -> Rollback($Conex);
	  }else{		
		$this -> Commit($Conex);			
	  }  
	}


//// GRID ////   
  public function getQueryOrdenCargueGrid($oficina_id){
	   	   
     $Query = "SELECT 
	 				o.consecutivo,
					(SELECT solicitud_id FROM detalle_solicitud_servicio WHERE  detalle_ss_id=o.detalle_ss_id) AS  solicitud_id,
					o.fecha,
					(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) AS cliente_nom  FROM cliente c, tercero t WHERE c.cliente_id=o.cliente_id AND t.tercero_id=c.tercero_id) AS cliente,
					(SELECT nombre_contacto  FROM contacto WHERE contacto_id=o.contacto_id) AS contacto,
					o.direccion_cargue,
					(SELECT tipo_servicio FROM tipo_servicio WHERE tipo_servicio_id=o.tipo_servicio_id ) AS tipo_servicio,					
					(SELECT nombre FROM ubicacion WHERE ubicacion_id=o.origen_id) AS origen,
					(SELECT nombre FROM ubicacion WHERE ubicacion_id=o.destino_id) AS destino,
					o.producto,	
					o.cantidad_cargue,
					o.peso,
					(SELECT medida FROM medida WHERE medida_id=o.unidad_peso_id) AS unidad_peso,
					o.peso_volumen,
					(SELECT medida FROM medida WHERE medida_id=o.unidad_volumen_id) AS unidad_volumen,
					o.placa,
					o.tenedor,
					o.propietario,
					o.nombre,
					(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) AS usuario_nom FROM usuario u, tercero t WHERE u.usuario_id=o.usuario_id AND t.tercero_id=u.tercero_id) AS usuario,
					(SELECT nombre FROM oficina WHERE oficina_id=o.oficina_id) AS oficina,
					o.fecha_ingreso,
					CASE o.estado WHEN 'E' THEN 'ESPERA' WHEN 'A' THEN 'ANULADO' WHEN 'R' THEN 'REALIZADO' END
	 			FROM orden_cargue o
				WHERE o.oficina_id=$oficina_id
				ORDER BY o.orden_cargue_id DESC";

     return $Query;
   }
   
}



?>