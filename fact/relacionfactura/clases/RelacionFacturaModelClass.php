<?php

	require_once("../../../framework/clases/DbClass.php");
	require_once("../../../framework/clases/PermisosFormClass.php");

	final class RelacionFacturaModel extends Db{

		private $usuario_id;
		private $Permisos;

		public function SetUsuarioId($usuario_id,$oficina_id){
			$this -> Permisos = new PermisosForm();
			$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
		}

		public function getPermiso($ActividadId,$Permiso,$Conex){
			return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
		}


		public function generateReporte($empresa_id,$fecha_inicio,$fecha_final,$solicitud_id,$numero_remesas,$Conex){
			
		if($numero_remesas !=''){
			 	$remesas = " numero_remesa IN ($numero_remesas) ";
			}else{
				$remesas = null;
	 	 }	
		 
		 
		 if($solicitud_id !=''){
			 	$solicitud = " solicitud_id = $solicitud_id ";
			}else{
				$solicitud = null;
	 	 }	
		 
		 
		 if($fecha_inicio !='' && $fecha_final !=''){
			 	$fechas = " s.fecha_remesa BETWEEN '$fecha_inicio' AND '$fecha_final' ";
			}else{
				$fechas = null;
	 	 }	
			
		$consulta = '';	
		 if(strlen($remesas)>0 && $fecha_inicio !='' && $fecha_final !='' && $solicitud_id !=''){
			 	$consulta=$fechas.'AND'.$remesas.'AND'.$solicitud;
			 }else if(strlen($solicitud)>0 && $fecha_inicio !='' && $fecha_final !=''){
				 $consulta=$fechas.'AND'.$solicitud;
				 }else if(strlen($remesas)>0 && $fecha_inicio !='' && $fecha_final !=''){
					 $consulta=$fechas.'AND'.$remesas;
					 }else if(strlen($remesas)>0 && strlen($solicitud)>0){
						 $consulta=$solicitud.'AND'.$remesas;
						 }else if($fecha_inicio !='' && $fecha_final !=''){
							 $consulta=$fechas;
							 }else if(strlen($remesas)>0){
								 	$consulta=$remesas;
								 }else if(strlen($solicitud)>0){
									 $consulta=$solicitud;
									 }
				$select = "SELECT
							s.remesa_id,
							s.numero_remesa,
							s.fecha_remesa,
							(CASE s.paqueteo WHEN 0 THEN 'MASIVO' WHEN 1 THEN 'PAQUETEO' ELSE 'CONTRA ENTREGA' END )AS paqueteo,
							(SELECT (CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido)) FROM tercero t, cliente c WHERE t.tercero_id=c.tercero_id AND c.cliente_id=s.cliente_id) AS cliente_remesa,
							IF((SELECT f.factura_id FROM factura f, detalle_factura d WHERE f.factura_id=d.factura_id AND d.remesa_id=s.remesa_id ORDER BY remesa_id DESC LIMIT 1)>0,(SELECT f.consecutivo_factura FROM factura f, detalle_factura d WHERE f.factura_id=d.factura_id AND d.remesa_id=s.remesa_id ORDER BY remesa_id DESC LIMIT 1),'N/A') AS factura_remesa,
							(CASE s.estado WHEN 'PD' THEN 'PENDIENTE' WHEN 'PC' THEN 'PROCESANDO' WHEN 'MF' THEN 'MANIFESTADO' WHEN 'LQ' THEN 'LIQUIDADO' ELSE 'FACTURADO' END )AS estado
					FROM remesa s
					WHERE $consulta AND estado NOT IN('FT','AN') ORDER BY s.fecha_remesa DESC";
				$data = $this -> DbFetchAll($select,$Conex,true);
			return $data;
		}


	public function Asociar($empresa_id,$usuario_id,$oficina_id,$modifica,$Conex){
		
		$remesas = substr($_REQUEST['remesas'], 1);
		
		$this -> Begin($Conex);
		
		$relacion_factura = $_REQUEST['relacion_factura_id'];
	
		$remesa_id = explode(',',$remesas);

		if($remesas!=''){
			
			
			foreach($remesa_id as $remesas){
			
			if($remesas!=''){
			
			$select = "SELECT
							r.remesa_id,
							r.numero_remesa,
							r.origen_id,
							r.destino_id,
							r.producto_id,
							r.descripcion_producto,
							r.cantidad,
							r.valor_facturar,
							r.valor_costo,
							r.conductor_id,
							r.estado,
							
							
							(SELECT t.tercero_id FROM detalle_despacho d,  tenedor  t 
							 WHERE d.remesa_id=r.remesa_id AND t.tenedor_id=IF(d.manifiesto_id>0,
							(SELECT tenedor_id FROM manifiesto WHERE manifiesto_id=d.manifiesto_id AND estado!='A') ,
							(SELECT tenedor_id FROM  despachos_urbanos  WHERE despachos_urbanos_id=d.despachos_urbanos_id AND estado!='A')) LIMIT 1 ) AS tercero_id,
							(SELECT df.factura_id FROM detalle_factura df, factura f WHERE df.remesa_id=r.remesa_id AND  f.factura_id!=$relacion_factura AND f.estado!='I' AND df.factura_id=f.factura_id AND df.remesa_id IS NOT NULL LIMIT 1) AS facturado
							FROM remesa r
							WHERE r.remesa_id=$remesas";

				$result = $this -> DbFetchAll($select,$Conex,true);
				$detalle_factura_id 	= $this -> DbgetMaxConsecutive("detalle_factura","detalle_factura_id",$Conex,true,1);
				
			    foreach($result as $resultado){
					
					if($resultado[estado] == 'AN' || $resultado[estado] == 'FT'){
						$this -> Rollback($Conex);
						exit("La remesa ".$resultado[numero_remesa]." No puede estar en estado FACTURADO o ANULADO");
						
					}

					if($resultado[estado] == 'PC' || $resultado[estado] == 'PD' || $resultado[estado] == 'MF'){
						$this -> Rollback($Conex);
						exit("La remesa ".$resultado[numero_remesa]."debe ser liquidada primero antes de asociarla a la factura");
						
					}
					
					if($resultado[facturado]>0){
						$this -> Rollback($Conex);
						exit("La remesa ".$resultado[numero_remesa]." esta asociada a otra Factura NO ANULADA. Por favor comuniquese con el Administrador");
						
					}
					
						$insert = "INSERT INTO detalle_factura  (detalle_factura_id,factura_id,remesa_id,origen_id,destino_id,producto_id,descripcion,cantidad,valor) 
									VALUES ($detalle_factura_id,$relacion_factura,$resultado[remesa_id],$resultado[origen_id],$resultado[destino_id],$resultado[producto_id],'SERVICIO FLETE $resultado[descripcion_producto]',$resultado[cantidad],'$resultado[valor_facturar]');"; 
	
						$this -> query($insert,$Conex,true);
	
						if(!strlen(trim($this -> GetError())) > 0){
							$update = "UPDATE remesa SET estado='FT' WHERE remesa_id = $resultado[remesa_id];";
							$this -> query($update,$Conex,true);
	
						}
				}
			
			}
				
			}
	
			$this -> Commit($Conex);
			return 'si';
				
	
		}else{
			$this -> Rollback($Conex);
			exit("No selecciono Ninguna Remesa");	
		}
	}

	}
	
?>
