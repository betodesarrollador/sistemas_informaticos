<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class ManifiestoModel extends Db{

	private $Permisos;

	public function SetUsuarioId($usuario_id,$oficina_id){
		$this -> Permisos = new PermisosForm();
		$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
	}

	public function getPermiso($ActividadId,$Permiso,$Conex){
		return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
	}

	public function selectDivipolaUbicacion($ubicacion_id,$Conex){  
		$select = "SELECT divipola FROM ubicacion WHERE ubicacion_id = $ubicacion_id";
		$result = $this -> DbFetchAll($select,$Conex,true);		
		return $result[0]['divipola'];  
	}

	public function GetCiudad($oficina_id,$Conex){		
		$select = "SELECT u.ubicacion_id ,u.nombre FROM oficina o, ubicacion u WHERE o.oficina_id=$oficina_id AND u.ubicacion_id=o.ubicacion_id ";
		$result = $this -> DbFetchAll($select,$Conex);		
		return $result;				
	} 

/////  
	public function Delete($Campos,$Conex){
		$this -> Begin($Conex);

		$this -> DbDeleteTable("reexpedido_id",$Campos,$Conex,true,false);	
		$this -> DbDeleteTable("reexpedido",$Campos,$Conex,true,false);	

		$this -> Commit($Conex);
	} 

  ////

	public function SelectSolicitud($solicitud,$Conex){
		$select = "SELECT r.guia_id, r.numero_guia, r.estado_mensajeria_id FROM guia r 	WHERE r.solicitud_id=$solicitud";
		$result = $this-> DbFetchAll($select,$Conex,true);  
		return $result;
	}



	public function seleccionar_remesa($guia_id,$reexpedido_id,$Conex){
		$this -> Begin($Conex);
		$detalle_despacho_guia_id = $this -> DbgetMaxConsecutive("detalle_despacho_guia","detalle_despacho_guia_id",$Conex,true,1);	
		$insert = "INSERT INTO detalle_despacho_guia (detalle_despacho_guia_id,guia_id,reexpedido_id)
		VALUES ($detalle_despacho_guia_id,$guia_id,$reexpedido_id)";
		$this -> query($insert,$Conex,true);						  

		$update = "UPDATE guia SET estado_mensajeria_id=4 WHERE guia_id=$guia_id ";
		$this -> query($update,$Conex,true);
		$this -> Commit($Conex);
	}

	public function seleccionar_remesa_encomienda($guia_encomienda_id,$reexpedido_id,$Conex){
		$this -> Begin($Conex);
		$detalle_despacho_guia_id = $this -> DbgetMaxConsecutive("detalle_despacho_guia","detalle_despacho_guia_id",$Conex,true,1);	
		$insert = "INSERT INTO detalle_despacho_guia (detalle_despacho_guia_id,guia_encomienda_id,reexpedido_id)
		VALUES ($detalle_despacho_guia_id,$guia_encomienda_id,$reexpedido_id)";
		$this -> query($insert,$Conex,true);						  

		$update = "UPDATE guia_encomienda SET estado_mensajeria_id=4 WHERE guia_encomienda_id=$guia_encomienda_id ";
		$this -> query($update,$Conex,true);
		$this -> Commit($Conex);
	}


	public function seleccionar_remesa_inter($guia_interconexion_id,$reexpedido_id,$Conex){
		$this -> Begin($Conex);
		$detalle_despacho_guia_id = $this -> DbgetMaxConsecutive("detalle_despacho_guia","detalle_despacho_guia_id",$Conex,true,1);	
		$insert = "INSERT INTO detalle_despacho_guia (detalle_despacho_guia_id,guia_interconexion_id,reexpedido_id)
		VALUES ($detalle_despacho_guia_id,$guia_interconexion_id,$reexpedido_id)";
		$this -> query($insert,$Conex,true);						  

		$update = "UPDATE guia_interconexion SET estado_mensajeria_id=4 WHERE guia_interconexion_id=$guia_interconexion_id ";
		$this -> query($update,$Conex,true);
		$this -> Commit($Conex);
	}

	public function retirar_remesa($guia_id,$reexpedido_id,$Conex){
		$this -> Begin($Conex);

	//$select = "DELETE FROM detalle_despacho_guia WHERE guia_id=$guia_id AND reexpedido_id=$reexpedido_id ";
	//$this -> query($insert,$Conex,true);						  

		$insert = "DELETE FROM detalle_despacho_guia WHERE guia_id=$guia_id AND reexpedido_id=$reexpedido_id ";
		$this -> query($insert,$Conex,true);						  

		$update = "UPDATE guia SET estado_mensajeria_id=1 WHERE guia_id=$guia_id ";
		$this -> query($update,$Conex,true);
		$this -> Commit($Conex);
	}  

	public function retirar_remesa_encomienda($guia_encomienda_id,$reexpedido_id,$Conex){
		$this -> Begin($Conex);

	//$select = "DELETE FROM detalle_despacho_guia WHERE guia_id=$guia_id AND reexpedido_id=$reexpedido_id ";
	//$this -> query($insert,$Conex,true);						  

		$insert = "DELETE FROM detalle_despacho_guia WHERE guia_encomienda_id=$guia_encomienda_id AND reexpedido_id=$reexpedido_id ";
		$this -> query($insert,$Conex,true);						  

		$update = "UPDATE guia_encomienda SET estado_mensajeria_id=1 WHERE guia_encomienda_id=$guia_encomienda_id ";
		$this -> query($update,$Conex,true);
		$this -> Commit($Conex);
	}  

	public function retirar_remesa_inter($guia_interconexion_id,$reexpedido_id,$Conex){
		$this -> Begin($Conex);

	//$select = "DELETE FROM detalle_despacho_guia WHERE guia_id=$guia_id AND reexpedido_id=$reexpedido_id ";
	//$this -> query($insert,$Conex,true);						  

		$insert = "DELETE FROM detalle_despacho_guia WHERE guia_interconexion_id=$guia_interconexion_id AND reexpedido_id=$reexpedido_id ";
		$this -> query($insert,$Conex,true);						  

		$update = "UPDATE guia_interconexion SET estado_mensajeria_id=1 WHERE guia_interconexion_id=$guia_interconexion_id ";
		$this -> query($update,$Conex,true);
		$this -> Commit($Conex);
	}  


	public function getEstadoReex($reexpedido_id,$Conex){
		$select = "SELECT 
		estado
		FROM reexpedido r 
		WHERE r.reexpedido_id=$reexpedido_id";

		$result = $this-> DbFetchAll($select,$Conex,true);
		return $result[0][estado];
	}

	public function getEstadoDisReex($reexpedido_id,$Conex){
		$select = "SELECT 
		COUNT(*) AS movimientos
		FROM reexpedido r, detalle_despacho_guia dg, guia g
		WHERE r.reexpedido_id=$reexpedido_id AND dg.reexpedido_id=r.reexpedido_id 
		AND g.guia_id=dg.guia_id AND g.estado_mensajeria_id != 4 ";

		$result = $this-> DbFetchAll($select,$Conex,true);
		return $result[0][movimientos]!='' ? $result[0][movimientos] : 0;
	}

	public function getEstadoDis2Reex($reexpedido_id,$Conex){
		$select = "SELECT 
		COUNT(*) AS movimientos
		FROM reexpedido r, detalle_despacho_guia dg, guia_encomienda g
		WHERE r.reexpedido_id=$reexpedido_id AND dg.reexpedido_id=r.reexpedido_id 
		AND g.guia_encomienda_id=dg.guia_encomienda_id AND g.estado_mensajeria_id != 4 ";

		$result = $this-> DbFetchAll($select,$Conex,true);
		return $result[0][movimientos]!='' ? $result[0][movimientos] : 0;
	}


	public function getEstadoDis1Reex($reexpedido_id,$Conex){
		$select = "SELECT 
		COUNT(*) AS movimientos
		FROM reexpedido r, detalle_despacho_guia dg, guia_interconexion g
		WHERE r.reexpedido_id=$reexpedido_id AND dg.reexpedido_id=r.reexpedido_id 
		AND g.guia_interconexion_id=dg.guia_interconexion_id AND g.estado_mensajeria_id != 4 ";

		$result = $this-> DbFetchAll($select,$Conex,true);
		return $result[0][movimientos]!='' ? $result[0][movimientos] : 0;
	}

	public function setLeerCodigobar($guia,$reexpedido_id,$Conex){
		$select = "SELECT 
		g.guia_id,
		CONCAT_WS('',g.prefijo,g.numero_guia) AS numero_guia,
		g.remitente,
		g.destinatario,
		g.descripcion_producto,
		g.peso,
		g.cantidad, 
		(SELECT GROUP_CONCAT(d.reexpedido) AS reexp FROM detalle_despacho_guia dd, reexpedido d WHERE dd.guia_id=g.guia_id AND   d.reexpedido_id=dd.reexpedido_id AND d.estado='M' ) AS reexped,
		g.estado_mensajeria_id
		FROM guia g 
		WHERE CONCAT_WS('',g.prefijo,g.numero_guia)='$guia' 
		";

		$result = $this-> DbFetchAll($select,$Conex,true);
		return $result;
	}

	public function setLeerCodigobar1($guia,$reexpedido_id,$Conex){
		$select = "SELECT 
		g.guia_id,
		CONCAT_WS('',g.prefijo,g.numero_guia) AS numero_guia,
		g.remitente,
		g.destinatario,
		g.descripcion_producto,
		g.peso,
		g.cantidad, 
		(SELECT GROUP_CONCAT(d.reexpedido) AS reexp FROM detalle_despacho_guia dd, reexpedido d WHERE dd.guia_id=g.guia_id AND   d.reexpedido_id=dd.reexpedido_id AND d.estado='M' ) AS reexped,
		g.estado_mensajeria_id
		FROM guia g 
		WHERE CONCAT_WS('',g.prefijo,g.numero_guia)='$guia' ";

		$result = $this-> DbFetchAll($select,$Conex,true);
		return $result;
	} 

	public function setLeerCodigobar2($guia,$reexpedido_id,$Conex){
		$select = "SELECT 
		g.guia_interconexion_id,
		g.numero_guia,
		g.remitente,
		g.destinatario,
		g.descripcion_producto,
		g.peso,
		g.cantidad, 
		(SELECT GROUP_CONCAT(d.reexpedido) AS reexp FROM detalle_despacho_guia dd, reexpedido d WHERE dd.guia_interconexion_id=g.guia_interconexion_id AND   d.reexpedido_id=dd.reexpedido_id AND d.estado='M' ) AS reexped,
		g.estado_mensajeria_id
		FROM guia_interconexion g 
		WHERE g.numero_guia='$guia' 
		";

		$result = $this-> DbFetchAll($select,$Conex,true);
		return $result;
	}

	public function setLeerCodigobar3($guia,$reexpedido_id,$Conex){
		$select = "SELECT 
		g.guia_interconexion_id,
		g.numero_guia,
		g.remitente,
		g.destinatario,
		g.descripcion_producto,
		g.peso,
		g.cantidad, 
		(SELECT GROUP_CONCAT(d.reexpedido) AS reexp FROM detalle_despacho_guia dd, reexpedido d WHERE dd.guia_interconexion_id=g.guia_interconexion_id AND   d.reexpedido_id=dd.reexpedido_id AND d.estado='M' ) AS reexped,
		g.estado_mensajeria_id
		FROM guia_interconexion g 
		WHERE g.numero_guia='$guia'";

		$result = $this-> DbFetchAll($select,$Conex,true);
		return $result;
	}


	public function setLeerCodigobar4($guia,$reexpedido_id,$Conex){
		$select = "SELECT 
		g.guia_encomienda_id,
		CONCAT_WS('',g.prefijo,g.numero_guia) AS numero_guia,
		g.remitente,
		g.destinatario,
		g.descripcion_producto,
		g.peso,
		g.cantidad, 
		(SELECT GROUP_CONCAT(d.reexpedido) AS reexp FROM detalle_despacho_guia dd, reexpedido d WHERE dd.guia_encomienda_id=g.guia_encomienda_id AND   d.reexpedido_id=dd.reexpedido_id AND d.estado='M' ) AS reexped,
		g.estado_mensajeria_id
		FROM guia_encomienda g 
		WHERE CONCAT_WS('',g.prefijo,g.numero_guia)='$guia' "; 

		$result = $this-> DbFetchAll($select,$Conex,true);
		return $result;
	}

	public function setLeerCodigobar5($guia,$reexpedido_id,$Conex){
		$select = "SELECT 
		g.guia_encomienda_id,
		CONCAT_WS('',g.prefijo,g.numero_guia) AS numero_guia,
		g.remitente,
		g.destinatario,
		g.descripcion_producto,
		g.peso,
		g.cantidad, 
		(SELECT GROUP_CONCAT(d.reexpedido) AS reexp FROM detalle_despacho_guia dd, reexpedido d WHERE dd.guia_encomienda_id=g.guia_encomienda_id AND   d.reexpedido_id=dd.reexpedido_id AND d.estado='M' ) AS reexped,
		g.estado_mensajeria_id
		FROM guia_encomienda g 
		WHERE CONCAT_WS('',g.prefijo,g.numero_guia)='$guia' ";

		$result = $this-> DbFetchAll($select,$Conex,true);
		return $result;
	}

	public function cancellation($reexpedido_id,$causal_anulacion_id,$observacion_anulacion,$usuario_anulo_id,$Conex){ 

		$select = "SELECT d.guia_id FROM detalle_despacho_guia d 
		WHERE d.reexpedido_id = $reexpedido_id AND 
		(d.guia_id IN (SELECT dd.guia_id FROM detalle_devolucion dd, devolucion dv WHERE dv.estado='D' AND dd.devolucion_id=dv.devolucion_id )
		OR d.guia_id IN (SELECT dd.guia_id FROM detalle_entrega dd, entrega dv WHERE dv.estado='E' AND dd.entrega_id=dv.entrega_id ))";
		$result = $this -> DbFetchAll($select,$Conex,true);	
		if($result[0][guia_id]>0){
			exit('No puede Anular el manifiesto, <br>debido a que una o varias de las guias estan relacionadas<br> en una devoluci&oacute;n o entrega Activa');
		}

		$this -> Begin($Conex);  

		$update = "UPDATE reexpedido SET estado = 'A',causal_anulacion_id = $causal_anulacion_id,observacion_anulacion = $observacion_anulacion,
		fecha_anulacion = NOW(),usuario_anulo_id = $usuario_anulo_id WHERE reexpedido_id = $reexpedido_id";	 
		$this -> query($update,$Conex,true);	

		$update = "UPDATE guia SET estado_mensajeria_id=1 WHERE guia_id IN (SELECT guia_id FROM detalle_despacho_guia WHERE reexpedido_id = $reexpedido_id)";
		$this -> query($update,$Conex,true);

		$update = "UPDATE guia_encomienda SET estado_mensajeria_id=1 WHERE guia_encomienda_id IN (SELECT guia_encomienda_id FROM detalle_despacho_guia WHERE reexpedido_id = $reexpedido_id)";
		$this -> query($update,$Conex,true);		


		$this -> Commit($Conex);
	}   

	public function getCausalesAnulacion($Conex){		
		$select = "SELECT causal_anulacion_id AS value,nombre AS text FROM causal_anulacion ORDER BY nombre";
		$result = $this -> DbFetchAll($select,$Conex);		
		return $result;			
	}	  


	public function getConsecutivoDespacho($oficina_id,$Conex){	  

		$select     = "SELECT MAX(reexpedido) AS reexpedido FROM reexpedido ";
		$result     = $this -> DbFetchAll($select,$Conex,true);    
		$reexpedido = $result[0]['reexpedido'];

		if(is_numeric($reexpedido)){	

			$select  = "SELECT rango_rxp_fin FROM rango_rxp WHERE  estado = 'A'";
			$result           = $this -> DbFetchAll($select,$Conex,true);
			$rango_rxp_fin  = $result[0]['rango_rxp_fin'];	

			$reexpedido += 1;

			if($reexpedido > $rango_rxp_fin){
				exit('El numero de reexpedido para esta oficina a superado el limite definido<br>debe actualizar el rango de reexpedidos asignado para esta oficina !!!');
			}	  		  
		}else{			
			$select           = "SELECT rango_rxp_ini FROM rango_rxp WHERE  estado = 'A'";				 
			$result           = $this -> DbFetchAll($select,$Conex,true);
			$rango_rxp_ini  = $result[0]['rango_rxp_ini'];

			if(is_numeric($rango_rxp_ini)){
				$reexpedido = $rango_rxp_ini;
			}else{		
				exit('Debe Definir un rango de Manifiestos Mensajero para la oficina!!!');
			}
		}

		return $reexpedido;
	}

	public function Update($usuario_id,$oficina_id,$empresa_id,$usuarioNombres,$usuario_numero_identificacion,$Campos,$Conex){ 

		$reexpedido_id = $this -> requestDataForQuery('reexpedido_id','integer');   
		$obser_rxp     = $this -> requestDataForQuery('obser_rxp','text');  
		$fecha_rxp     = $this -> requestDataForQuery('fecha_rxp',date('Y-m-d'));
		$destino_id    = $this -> requestDataForQuery('destino_id','integer');
		$proveedor_id  = $this -> requestDataForQuery('proveedor_id','integer');
		$placa         = $this -> requestDataForQuery('placa','text');
		$this -> Begin($Conex);

		$update = "UPDATE reexpedido SET obser_rxp=$obser_rxp, fecha_rxp=$fecha_rxp, destino_id=$destino_id, proveedor_id=$proveedor_id, placa = $placa WHERE reexpedido_id = $reexpedido_id";
		
		$this -> query($update,$Conex,true);	

		$this -> Commit($Conex);	 
	}

	public function Save($usuario_id,$oficina_id,$empresa_id,$usuarioNombres,$usuario_numero_identificacion,$Campos,$Conex){

		$reexpedido_id = $this -> DbgetMaxConsecutive("reexpedido","reexpedido_id",$Conex,true,1);	
		$reexpedido    = $this -> getConsecutivoDespacho($oficina_id,$Conex);

		$this -> assignValRequest('empresa_id',$empresa_id);
		$this -> assignValRequest('oficina_id',$oficina_id);
		$this -> assignValRequest('usuario_id',$usuario_id);
		$this -> assignValRequest('usuario_registra',$usuarioNombres);
		$this -> assignValRequest('usuario_registra_numero_identificacion',$usuario_numero_identificacion);		
		$this -> assignValRequest('fecha_registro',date('Y-m-d'));		

		$this -> assignValRequest('reexpedido_id',$reexpedido_id);
		$this -> assignValRequest('reexpedido',$reexpedido);


		$this -> Begin($Conex);    

		$this -> assignValRequest('estado','M');		    					
		$this -> DbInsertTable("reexpedido",$Campos,$Conex,true,false);

		$this -> Commit($Conex);

		return array(array(reexpedido_id=>$reexpedido_id,reexpedido=>$reexpedido));
	}

//BUSQUEDA
	public function selectReexpedidos($reexpedido_id,$Conex){

		$select = "SELECT r.*,
		(SELECT COUNT(*) FROM detalle_despacho_guia dd WHERE dd.reexpedido_id = $reexpedido_id) AS n_guias,
		r.fecha_rxp,r.proveedor_id,(SELECT (CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social)) 
		FROM tercero t, proveedor p WHERE r.proveedor_id=p.proveedor_id AND t.tercero_id=p.tercero_id) AS proveedor, r.origen_id,
		(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) AS origen,r.destino_id,(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino 
		FROM reexpedido r WHERE r.reexpedido_id=$reexpedido_id";

		$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);	
		return $result;
	}



//// GRID ////
	public function getQueryManifiestoGrid(){

		$Query = "SELECT r.reexpedido,r.fecha_rxp,
		(SELECT (CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social)) FROM tercero t, proveedor p 
		WHERE r.proveedor_id=p.proveedor_id AND t.tercero_id=p.tercero_id) AS proveedor,
		(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) AS origen,
		(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino,
		CASE r.estado WHEN 'P' THEN 'PENDIENTE' WHEN 'M' THEN 'MANIFESTADO' WHEN 'L' THEN 'LEGALIZADO' ELSE 'ANULADO' END AS estado,
		obser_rxp,placa
		FROM reexpedido r";

		return $Query;
	}   
}

?>