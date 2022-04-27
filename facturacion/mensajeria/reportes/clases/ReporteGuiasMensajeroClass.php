<?php
require_once("../../../framework/clases/ControlerClass.php");

final class ReporteGuiasMensajero extends Controler{

	public function __construct(){
		parent::__construct(3);
	}


	public function Main(){

		$this -> noCache();
		require_once("ReporteGuiasMensajeroLayoutClass.php");
		require_once("ReporteGuiasMensajeroModelClass.php");

		$Layout   = new ReporteGuiasMensajeroLayout($this -> getTitleTab(),$this -> getTitleForm());
		$Model    = new ReporteGuiasMensajeroModel();
		$Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
		$Layout -> setImprimir($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));
		$Layout -> setCampos($this -> Campos);
			//LISTA MENU
		$Layout -> SetSi_Me ($Model -> GetSi_Me ($this -> getConex()));
		$Layout -> SetSi_Usu ($Model -> GetSi_Usu ($this -> getConex()));
		$Layout -> SetEstado ($Model -> GetEstado ($this -> getConex()));
		$Layout -> SetServicio ($Model -> GetServicio ($this -> getConex()));			
		$Layout -> SetOficina($Model -> GetOficina($this -> getOficinaId(),$this -> getEmpresaId(),$this -> getConex()));

		$Layout -> RenderMain();
	}


	protected function generateReport(){

		require_once("ReporteGuiasMensajeroLayoutClass.php");
		require_once("ReporteGuiasMensajeroModelClass.php");

		$Layout					= new ReporteGuiasMensajeroLayout($this -> getTitleTab(),$this -> getTitleForm());
		$Model					= new ReporteGuiasMensajeroModel();

		$Conex					= $this -> getConex();
		$allguia				= $_REQUEST['allguia'];
		$allreexpedido			= $_REQUEST['allreexpedido'];
		$consolidado			= $_REQUEST['consolidado'];
		$download				= $_REQUEST['download'];
		$formato				= $_REQUEST['formato'];
		$peso					= $_REQUEST['peso'];
		$guia					= $_REQUEST['guia'];
		$placa					= $_REQUEST['placa'];

		if ($allguia=='N' AND $allreexpedido=='N'){

			$origen							= $_REQUEST['origen'];
			$origen_id						= $_REQUEST['origen_id'];
			$destino						= $_REQUEST['destino'];
			$destino_id						= $_REQUEST['destino_id'];
			$mensajero_id					= $_REQUEST['mensajero_id'];
			$usuario_id						= $_REQUEST['usuario_id'];

			$si_mensajero			= $_REQUEST['si_mensajero'];
			$si_usuario				= $_REQUEST['si_usuario'];				
			$all_estado				= $_REQUEST['all_estado'];
			$all_servicio			= $_REQUEST['all_servicio'];


			if ($origen=='' || $origen=='NULL' || $origen==NULL){
				$consulta_origen=" ";
			}else{
				$consulta_origen=" AND g.origen_id=".$origen_id;
			} 

			if ($destino=='' || $destino=='NULL' || $destino==NULL){
				$consulta_destino=" ";
			}else{
				$consulta_destino=" AND g.destino_id=".$destino_id;
			}
			
			if ($si_mensajero=='' || $si_mensajero=='NULL' || $si_mensajero==NULL || $si_mensajero=='ALL'){
				$consulta_mensajero=" ";
			}else {
				$consulta_mensajero=" AND g.guia_encomienda_id IN (SELECT dd.guia_encomienda_id FROM reexpedido r, detalle_despacho_guia dd WHERE  r.proveedor_id =".$mensajero_id." AND dd.reexpedido_id=r.reexpedido_id)";
			}
			if ($si_usuario=='' || $si_usuario=='NULL' || $si_usuario==NULL || $si_usuario=='ALL'){
				$consulta_usuario=" ";
			}else {
				$consulta_usuario=" AND g.usuario_id =".$usuario_id;
			}


		}



		if($guia == 'M'){

			$tabla = 'guia g';

			$id= 'guia_id';

			$union="";

			$tipo_guia='MENSAJERIA';

		}else if($guia == 'E'){ 
			
			$tabla = 'guia_encomienda g';

			$id= 'guia_encomienda_id';

			$union="";

			$tipo_guia='ENCOMIENDA';

		}else{

			$tabla = 'guia g';

			$id= 'guia_id';

			$tipo_guia='MENSAJERIA';

			$union="
			UNION ALL

			SELECT 
			'ENCOMIENDA' AS tipo_guia,
			g.numero_guia,
			g.solicitud_id,							
			g.numero_guia_padre,							
			g.fecha_guia,
			(SELECT o.nombre FROM oficina o WHERE o.oficina_id=g.oficina_id ) AS oficina,
			(SELECT em.nombre_estado FROM estado_mensajeria em WHERE em.estado_mensajeria_id=g.estado_mensajeria_id ) AS estado_mensajeria,
			
			(SELECT GROUP_CONCAT(r.fecha_rxp) FROM reexpedido r , detalle_despacho_guia dd WHERE r.reexpedido_id=dd.reexpedido_id AND g.guia_encomienda_id=dd.guia_encomienda_id AND r.estado!='A' ORDER BY r.fecha_rxp DESC LIMIT 1) AS fecha_recibe,
			
			(SELECT GROUP_CONCAT(CONCAT_WS(' ',t.razon_social,t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido)) As nombre FROM detalle_despacho_guia dg, reexpedido r, proveedor p, tercero t WHERE  dg.guia_encomienda_id = g.guia_encomienda_id AND dg.reexpedido_id = r.reexpedido_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A' LIMIT 1) AS mensajero_recibe,
			
			(SELECT GROUP_CONCAT(CONCAT_WS(' ',t.numero_identificacion)) As nombre FROM detalle_despacho_guia dg, reexpedido r, proveedor p, tercero t WHERE  dg.guia_encomienda_id = g.guia_encomienda_id AND dg.reexpedido_id = r.reexpedido_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A' LIMIT 1) AS mensajero_recibe_doc,
			
			
			(SELECT GROUP_CONCAT(r.reexpedido) FROM detalle_despacho_guia dg, reexpedido r WHERE g.guia_encomienda_id=dg.guia_encomienda_id AND r.reexpedido_id=dg.reexpedido_id AND r.estado!='A') AS reexpedido,
			
			(SELECT GROUP_CONCAT(r.placa) FROM detalle_despacho_guia dg, reexpedido r WHERE g.guia_encomienda_id=dg.guia_encomienda_id AND r.reexpedido_id=dg.reexpedido_id AND r.estado!='A' ORDER BY r.fecha_rxp DESC LIMIT 1) AS placa,
			
			(SELECT GROUP_CONCAT(r.interno) FROM detalle_despacho_guia dg, reexpedido r WHERE g.guia_encomienda_id=dg.guia_encomienda_id AND r.reexpedido_id=dg.reexpedido_id AND r.estado!='A') AS interno,
			
			(SELECT d.fecha_dev FROM devolucion d, detalle_devolucion dd  WHERE  g.guia_encomienda_id=dd.guia_encomienda_id AND dd.devolucion_id=d.devolucion_id AND d.estado!='A' LIMIT 1) AS fecha_devuelve,
			
			(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido) As nombre FROM detalle_devolucion dg, devolucion r, proveedor p, tercero t WHERE  dg.guia_encomienda_id = g.guia_encomienda_id AND dg.devolucion_id = r.devolucion_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A' LIMIT 1) AS mensajero_devuelve,
			
			(SELECT CONCAT_WS(' ',t.numero_identificacion) As nombre FROM detalle_devolucion dg, devolucion r, proveedor p, tercero t WHERE  dg.guia_encomienda_id = g.guia_encomienda_id AND dg.devolucion_id = r.devolucion_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A' LIMIT 1) AS mensajero_devuelve_doc,
			
			(SELECT c.causal FROM causal_devolucion c, devolucion d, detalle_devolucion dd WHERE g.guia_encomienda_id=dd.guia_encomienda_id AND dd.devolucion_id=d.devolucion_id AND dd.causal_devolucion_id=c.causal_devolucion_id AND d.estado!='A') AS causal_devolucion,

			(SELECT d.fecha_ree FROM reenvio d, detalle_reenvio dd  WHERE  g.guia_encomienda_id=dd.guia_encomienda_id AND dd.reenvio_id=d.reenvio_id AND d.estado!='A' LIMIT 1) AS fecha_reenvio,
			
			(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido) As nombre FROM detalle_reenvio dg, reenvio r, proveedor p, tercero t WHERE  dg.guia_encomienda_id = g.guia_encomienda_id AND dg.reenvio_id = r.reenvio_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A' LIMIT 1) AS mensajero_reenvio,
			
			(SELECT CONCAT_WS(' ',t.numero_identificacion) As nombre FROM detalle_reenvio dg, reenvio r, proveedor p, tercero t WHERE  dg.guia_encomienda_id = g.guia_encomienda_id AND dg.reenvio_id = r.reenvio_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A' LIMIT 1) AS mensajero_reenvio_doc,

			(SELECT m.fecha_ent FROM  entrega_oficina m, detalle_entrega_oficina dd WHERE dd.guia_encomienda_id=g.guia_encomienda_id AND m.entrega_oficina_id=dd.entrega_oficina_id AND m.estado!='A' ORDER BY m.fecha_ent  DESC LIMIT 0,1) AS fecha_destino,
			
			(SELECT e.usuario_registra FROM entrega_oficina e, detalle_entrega_oficina de  WHERE  g.guia_encomienda_id=de.guia_encomienda_id AND de.entrega_oficina_id=e.entrega_oficina_id AND e.estado!='A' LIMIT 1) AS usuario_destino,							

			(SELECT fecha_ent FROM entrega e, detalle_entrega de  WHERE  g.guia_encomienda_id=de.guia_encomienda_id AND de.entrega_id=e.entrega_id AND e.estado!='A' LIMIT 1) AS fecha_entrega,
			
			(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido) As nombre FROM detalle_entrega dg, entrega r, proveedor p, tercero t WHERE  dg.guia_encomienda_id = g.guia_encomienda_id AND dg.entrega_id = r.entrega_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A' LIMIT 1) AS mensajero_entrega,
			
			(SELECT CONCAT_WS(' ',t.numero_identificacion) As nombre FROM detalle_entrega dg, entrega r, proveedor p, tercero t WHERE  dg.guia_encomienda_id = g.guia_encomienda_id AND dg.entrega_id = r.entrega_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A' LIMIT 1) AS mensajero_entrega_doc,
			
			(SELECT u.nombre FROM ubicacion u WHERE u.ubicacion_id=g.origen_id) AS origen,
			(SELECT u.nombre FROM ubicacion u WHERE u.ubicacion_id=g.destino_id) AS destino,
			(SELECT t.nombre FROM tipo_servicio_mensajeria t WHERE t.tipo_servicio_mensajeria_id=g.tipo_servicio_mensajeria_id) AS tipo_servicio_mensajeria,							
			g.doc_remitente,
			g.remitente,
			g.telefono_remitente,
			g.direccion_remitente,
			g.destinatario,
			g.direccion_destinatario,
			g.descripcion_producto,
			(SELECT medida FROM medida WHERE medida_id=g.medida_id) AS medida,
			(SELECT nombre FROM tipo_envio WHERE tipo_envio_id=g.tipo_envio_id)AS tipo_envio,
			g.peso,
			g.largo,
			g.orden_despacho,
			g.alto,
			g.ancho,
			g.cantidad,
			g.tipo_liquidacion,
			g.observaciones
			FROM
			guia_encomienda g, reexpedido r, detalle_despacho_guia dg
			WHERE
			$documento
			ORDER BY
			g.numero_guia";

		}


		if ($allreexpedido=='S' || $allguia=='S') {

			if ($allguia=='S') {
				$guia_ids = str_replace(",","','",$guia_id);
				$documento=" CONCAT_WS('',g.prefijo,g.numero_guia) IN ('".$guia_ids."')";
				$arrayReporte=$Model -> getReporte3($tipo_guia,$union,$tabla,$id,$documento,$reexpedido,$Conex); 
			}elseif ($allreexpedido=='S') {
				
				if ($placa=='' || $placa=='NULL' || $placa==NULL){
					$consulta_placa=" ";
				}else{
					$consulta_placa=" AND r.placa = $placa";
				}
				
				if($consolidado=='S'){

					$reexpedido				= $_REQUEST['reexpedido'];

					$documento="g.$id=dg.$id AND g.estado_mensajeria_id=4 AND r.reexpedido_id=dg.reexpedido_id AND r.reexpedido=".$reexpedido." ".$consulta_placa;
					$transito=$Model -> getReporte4($tipo_guia,$union,$tabla,$id,$documento,$reexpedido,$Conex); 

					$documento="g.$id=dg.$id AND g.estado_mensajeria_id=6 AND r.reexpedido_id=dg.reexpedido_id AND r.reexpedido=".$reexpedido." ".$consulta_placa;
					$entregado=$Model -> getReporte4($tipo_guia,$union,$tabla,$id,$documento,$Conex); 

					$documento="g.$id=dg.$id AND g.estado_mensajeria_id=7 AND r.reexpedido_id=dg.reexpedido_id AND r.reexpedido=".$reexpedido." ".$consulta_placa;
					$devuelto=$Model -> getReporte4($tipo_guia,$union,$tabla,$id,$documento,$reexpedido,$Conex); 
				}else{

					$reexpedido				= $_REQUEST['reexpedido'];

					$documento="g.$id=dg.$id AND r.reexpedido_id=dg.reexpedido_id AND r.reexpedido=".$reexpedido." ".$consulta_placa;
					$arrayReporte=$Model -> getReporte2($tipo_guia,$union,$tabla,$id,$documento,$reexpedido,$Conex); 
				}
			}
		}else{

			if($peso=='N'){
				$consulta_peso=" AND g.peso <= 5000";
			}elseif($peso=='T'){
				$consulta_peso=" ";
			}else{
				$consulta_peso=" AND g.peso > 5000";
			}


			$tipo_servicio_mensajeria_id1=$_REQUEST['tipo_servicio_mensajeria_id'];

			$oficina1						= $_REQUEST['oficina_id'];

			$estado_id1						= $_REQUEST['estado_id'];	

			$desde						= $_REQUEST['desde'];

			$hasta						= $_REQUEST['hasta'];

			$guia_id						= $_REQUEST['guia_id'];	


			$tipo_servicio_mensajeria_id 	    = $tipo_servicio_mensajeria_id1 != 'null' 	   ? "AND g.tipo_servicio_mensajeria_id IN ($tipo_servicio_mensajeria_id1) "     : "";

			$oficina 	    	= $oficina1 != 'null' 	   ? " AND g.oficina_id IN($oficina1) "     : "";

			$estado_id 	    	= $estado_id1 != 'null'    ? " AND g.estado_mensajeria_id IN ($estado_id1) "     : "";

			$desde1 	    		= $desde!='NULL' 	   	   ? " AND DATE(g.fecha_guia)>= '".$desde."'"     : "";

			$hasta1 	    		= $hasta!='NULL'          ? " AND DATE(g.fecha_guia)<= '".$hasta."'"      : "";

			$numero_guia 	    = $guia_id > 0             ? " AND  g.numero_guia = $guia_id "      : "";



			if($guia == 'M'){

				$tabla = 'guia g';

				$id= 'guia_id';

				$union_all="";

				$tipo_guia='MENSAJERIA';

			}else if($guia == 'E'){  

				$tabla = 'guia_encomienda g';

				$id= 'guia_encomienda_id';

				$union_all="";

				$tipo_guia='ENCOMIENDA';

			}else{

				$tabla = 'guia g';

				$id= 'guia_id';

				$tipo_guia='MENSAJERIA';
				
				if ($placa=='' || $placa=='NULL' || $placa==NULL){
					$consulta_placa=" ";
				}else{
					$consulta_placa=" AND g.guia_encomienda_id IN (SELECT dd.guia_encomienda_id FROM reexpedido r, detalle_despacho_guia dd WHERE  r.placa = '$placa' AND dd.reexpedido_id=r.reexpedido_id)";
				}

				$union_all="UNION
				SELECT 
				'ENCOMIENDA' AS tipo_guia,
				CONCAT_WS('',g.prefijo,g.numero_guia) AS numero_guia,
				g.solicitud_id,
				g.numero_guia_padre,
				g.fecha_guia,
				(SELECT o.nombre FROM oficina o WHERE o.oficina_id=g.oficina_id ) AS oficina,
				(SELECT em.nombre_estado FROM estado_mensajeria em WHERE em.estado_mensajeria_id=g.estado_mensajeria_id ) AS estado_mensajeria,
				
				(SELECT GROUP_CONCAT(r.fecha_rxp) FROM reexpedido r , detalle_despacho_guia dd WHERE r.reexpedido_id=dd.reexpedido_id AND g.guia_encomienda_id=dd.guia_encomienda_id AND r.estado!='A' ORDER BY r.fecha_rxp DESC LIMIT 1) AS fecha_recibe,
				
				(SELECT GROUP_CONCAT(CONCAT_WS(' ',t.razon_social,t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido)) As nombre FROM detalle_despacho_guia dg, reexpedido r, proveedor p, tercero t WHERE  dg.guia_encomienda_id = g.guia_encomienda_id AND dg.reexpedido_id = r.reexpedido_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A' LIMIT 1) AS mensajero_recibe,
				
				(SELECT GROUP_CONCAT(CONCAT_WS(' ',t.numero_identificacion)) As nombre FROM detalle_despacho_guia dg, reexpedido r, proveedor p, tercero t WHERE  dg.guia_encomienda_id = g.guia_encomienda_id AND dg.reexpedido_id = r.reexpedido_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A' LIMIT 1) AS mensajero_recibe_doc,	
									
				(SELECT GROUP_CONCAT(r.reexpedido) FROM detalle_despacho_guia dg, reexpedido r WHERE g.guia_encomienda_id=dg.guia_encomienda_id AND r.reexpedido_id=dg.reexpedido_id AND r.estado!='A') AS reexpedido,
				
				(SELECT GROUP_CONCAT(r.placa) FROM detalle_despacho_guia dg, reexpedido r WHERE g.guia_encomienda_id=dg.guia_encomienda_id AND r.reexpedido_id=dg.reexpedido_id AND r.estado!='A' ORDER BY r.fecha_rxp DESC LIMIT 1) AS placa,
				
				(SELECT GROUP_CONCAT(r.interno) FROM detalle_despacho_guia dg, reexpedido r WHERE g.guia_encomienda_id=dg.guia_encomienda_id AND r.reexpedido_id=dg.reexpedido_id AND r.estado!='A') AS interno,		
				
									
				(SELECT d.fecha_dev FROM devolucion d, detalle_devolucion dd  WHERE  g.guia_encomienda_id=dd.guia_encomienda_id AND dd.devolucion_id=d.devolucion_id AND d.estado!='A' LIMIT 1) AS fecha_devuelve,
				
				(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido) As nombre FROM detalle_devolucion dg, devolucion r, proveedor p, tercero t WHERE  dg.guia_encomienda_id = g.guia_encomienda_id AND dg.devolucion_id = r.devolucion_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A' LIMIT 1) AS mensajero_devuelve,
				
				(SELECT CONCAT_WS(' ',t.numero_identificacion) As nombre FROM detalle_devolucion dg, devolucion r, proveedor p, tercero t WHERE  dg.guia_encomienda_id = g.guia_encomienda_id AND dg.devolucion_id = r.devolucion_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A' LIMIT 1) AS mensajero_devuelve_doc,
				
				(SELECT DISTINCT(c.causal) FROM causal_devolucion c, devolucion d, detalle_devolucion dd WHERE g.guia_encomienda_id=dd.guia_encomienda_id AND dd.devolucion_id=d.devolucion_id AND dd.causal_devolucion_id=c.causal_devolucion_id AND d.estado!='A') AS causal_devolucion,


				(SELECT d.fecha_ree FROM reenvio d, detalle_reenvio dd  WHERE  g.guia_encomienda_id=dd.guia_encomienda_id AND dd.reenvio_id=d.reenvio_id AND d.estado!='A' LIMIT 1) AS fecha_reenvio,
				
				(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido) As nombre FROM detalle_reenvio dg, reenvio r, proveedor p, tercero t WHERE  dg.guia_encomienda_id = g.guia_encomienda_id AND dg.reenvio_id = r.reenvio_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A' LIMIT 1) AS mensajero_reenvio,
				
				(SELECT CONCAT_WS(' ',t.numero_identificacion) As nombre FROM detalle_reenvio dg, reenvio r, proveedor p, tercero t WHERE  dg.guia_encomienda_id = g.guia_encomienda_id AND dg.reenvio_id = r.reenvio_id AND r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A' LIMIT 1) AS mensajero_reenvio_doc,

				(SELECT m.fecha_ent FROM entrega_oficina m INNER JOIN detalle_entrega_oficina dd ON m.entrega_oficina_id=dd.entrega_oficina_id WHERE m.estado!='A' ORDER BY m.fecha_ent DESC LIMIT 1) AS fecha_destino,

				(SELECT e.usuario_registra FROM entrega_oficina e, detalle_entrega_oficina de  WHERE  g.guia_encomienda_id=de.guia_encomienda_id AND de.entrega_oficina_id=e.entrega_oficina_id AND e.estado!='A' LIMIT 1) AS usuario_destino,							

				(SELECT fecha_ent FROM entrega e, detalle_entrega de  WHERE  g.guia_encomienda_id=de.guia_encomienda_id AND de.entrega_id=e.entrega_id AND e.estado!='A' LIMIT 1) AS fecha_entrega,
				
				
				(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido) FROM proveedor p, tercero t WHERE r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A' LIMIT 1) AS mensajero_entrega, 

				(SELECT t.numero_identificacion FROM proveedor p, tercero t WHERE  r.proveedor_id = p.proveedor_id AND p.tercero_id = t.tercero_id AND r.estado!='A' LIMIT 1) AS mensajero_entrega_doc,
				
				
				(SELECT e.usuario_registra_numero_identificacion FROM entrega e, detalle_entrega de  WHERE  g.guia_encomienda_id=de.guia_encomienda_id AND de.entrega_id=e.entrega_id AND e.estado!='A' LIMIT 1) AS usuario_entrega_doc,
				(SELECT e.usuario_registra FROM entrega e, detalle_entrega de  WHERE  g.guia_encomienda_id=de.guia_encomienda_id AND de.entrega_id=e.entrega_id AND e.estado!='A' LIMIT 1) AS usuario_entrega,							
				(SELECT u.nombre FROM ubicacion u WHERE u.ubicacion_id=g.origen_id) AS origen,
				(SELECT u.nombre FROM ubicacion u WHERE u.ubicacion_id=g.destino_id) AS destino,
				(SELECT t.nombre FROM tipo_servicio_mensajeria t WHERE t.tipo_servicio_mensajeria_id=g.tipo_servicio_mensajeria_id) AS tipo_servicio_mensajeria,							
				g.doc_remitente,
				g.remitente,
				g.telefono_remitente,
				g.direccion_remitente,
				g.destinatario,
				g.direccion_destinatario,
				g.descripcion_producto,
				(SELECT medida FROM medida WHERE medida_id=g.medida_id) AS medida,
				(SELECT nombre FROM tipo_envio WHERE tipo_envio_id=g.tipo_envio_id)AS tipo_envio,
				g.peso,
				g.peso_volumen,
				g.largo,
				g.orden_despacho,
				g.alto,
				g.ancho,
				g.cantidad,
				if(g.estado_mensajeria_id = 8,0,g.valor_flete) AS valor_flete,
				if(g.estado_mensajeria_id = 8,0,g.valor_seguro) AS valor_seguro,
				if(g.estado_mensajeria_id = 8,0,g.valor_otros) AS valor_otros,
				if(g.estado_mensajeria_id = 8,0,g.valor_descuento) AS valor_descuento,
				if(g.estado_mensajeria_id = 8,0,g.valor_total) AS valor_total,						
				g.tipo_liquidacion,
				g.observaciones

				FROM guia_encomienda g
       
       			LEFT JOIN detalle_entrega dg ON dg.guia_encomienda_id = g.guia_encomienda_id
       			LEFT JOIN entrega r  ON dg.entrega_id = r.entrega_id
        		LEFT JOIN detalle_entrega_oficina dd  ON dd.guia_encomienda_id=g.guia_encomienda_id
				WHERE g.guia_encomienda_id >0 $numero_guia $estado_id $tipo_servicio_mensajeria_id $oficina $desde1 $hasta1 $consulta_origen $consulta_destino $consulta_usuario $consulta_peso $consulta_mensajero $consulta_placa";
			}

			
			if ($placa=='' || $placa=='NULL' || $placa==NULL){
				$consulta_placa=" ";
			}else{
				$consulta_placa=" AND g.$id IN (SELECT dd.$id FROM reexpedido r, detalle_despacho_guia dd WHERE  r.placa = '$placa' AND dd.reexpedido_id=r.reexpedido_id)";
			}
			
			$arrayReporte=$Model -> getReporte1($tipo_guia,$union_all,$tabla,$id,$numero_guia,$desde1,$hasta1,$oficina,$estado_id,$tipo_servicio_mensajeria_id,$consulta_origen,$consulta_destino,$consulta_usuario,$consulta_peso,$consulta_mensajero,$consulta_placa,$this -> getConex());

		}

		$Layout -> setCssInclude("/velotax/framework/css/reset.css");
		$Layout -> setCssInclude("/velotax/mensajeria/reportes/css/reportes.css");
		$Layout -> setCssInclude("/velotax/mensajeria/reportes/css/detalles.css");
		$Layout -> setCssInclude("/velotax/mensajeria/reportes/css/reportes.css","print");
		$Layout -> setJsInclude("/velotax/framework/js/jquery-1.4.4.min.js");
		$Layout -> setJsInclude("/velotax/framework/js/funciones.js");
		$Layout -> setJsInclude("/velotax/mensajeria/reportes/js/ReporteGuiasMensajero.js");
		$Layout -> assign("CSSSYSTEM",$Layout -> getCssInclude());
		$Layout -> assign("JAVASCRIPT",$Layout -> getJsInclude());
		$Layout -> setVar('EMPRESA',$empresa);
		$Layout -> setVar('NIT',$nitEmpresa);

		$Layout -> setVar('DESDE',$desde);
		$Layout -> setVar('HASTA',$hasta);
		$Layout -> setVar('ORIGEN',$origen);
		$Layout -> setVar('ESTADO', $estado_id);
		$Layout -> setVar('SERVICIO', $tipo_servicio_mensajeria_id);			
		$Layout -> setVar('DESTINO', $destino_id);
		$Layout -> setVar('MENSAJERO', $mensajero_id);
		$Layout -> setVar('USUARIO', $usuario_id);
		$Layout -> setVar('TRANSITO', $transito);
		$Layout -> setVar('ENTREGADO', $entregado);
		$Layout -> setVar('DEVUELTO', $devuelto);
		$Layout -> setVar('DETALLES', $arrayReporte); 
		$Layout -> setVar('PESO', $peso);

		if($download == 'true'){
			if($formato=='SI'){
				if($_REQUEST['filtrado']=='SI'){
					$Layout -> exportToExcel('DetallesReporteGuiasMensajero1filtro.tpl');
				}else{
					$Layout -> exportToExcel('DetallesReporteGuiasMensajero1.tpl');						
				}
			}else{
				$Layout -> exportToExcel('DetallesReporteGuiasMensajero.tpl');
			}
		}else{ 
			$Layout -> RenderLayout('DetallesReporteGuiasMensajero.tpl');
		}
	}


		//DEFINICION CAMPOS DE FORMULARIO
	protected function setCampos(){

		$this -> Campos[desde] = array(
			name	=>'desde',
			id		=>'desde',
			type	=>'text',
			required=>'yes',
			datatype=>array(
				type	=>'date',
				length	=>'10')
		);
		$this -> Campos[hasta] = array(
			name	=>'hasta',
			id		=>'hasta',
			type	=>'text',
			required=>'yes',
			datatype=>array(
				type	=>'date',
				length	=>'10')
		);

		$this -> Campos[estado_id] = array(
			name	=>'estado_id',
			id		=>'estado_id',
			type	=>'select',
			required=>'yes',
			multiple=>'yes'
		);	
		$this -> Campos[all_estado] = array(
			name	=>'all_estado',
			id		=>'all_estado',
			type	=>'checkbox',
			onclick =>'all_estados();',
			value	=>'NO'
		);	

		$this -> Campos[tipo_servicio_mensajeria_id] = array(
			name	=>'tipo_servicio_mensajeria_id',
			id		=>'tipo_servicio_mensajeria_id',
			type	=>'select',
			required=>'yes',
			multiple=>'yes'
		);	

		$this -> Campos[guia] = array(
			name	=>'guia',
			id		=>'guia',
			type	=>'select',
			selected=>'T',
			required=>'yes',
			multiple=>'yes',
			options =>array(array(value=>'E',text=>'ENCOMIENDA'),array(value=>'M',text=>'MENSAJERIA'))
		);

		$this -> Campos[all_servicio] = array(
			name	=>'all_servicio',
			id		=>'all_servicio',
			type	=>'checkbox',
			onclick =>'all_servicios();',
			value	=>'NO'
		);

		$this -> Campos[all_guia] = array(
			name	=>'all_guia',
			id		=>'all_guia',
			type	=>'checkbox',
			onclick =>'all_guias();',
			value	=>'NO'
		);

		$this -> Campos[si_mensajero] = array(
			name	=>'si_mensajero',
			id		=>'si_mensajero',
			type	=>'select',
			options	=>null,
			selected=>0,
			required=>'yes',
			onchange=>'Mensajero_si();'
		);

		$this -> Campos[peso] = array(
			name	=>'peso',
			id		=>'peso',
			type	=>'select',
			selected=>'T',
				//required=>'yes',
			options =>array(array(value=>'N',text=>'MENOR A 5000grs'),array(value=>'S',text=>'MAYOR A 5000grs'),array(value=>'T',text=>'TODOS'))
		);

		$this -> Campos[mensajero_id] = array(
			name	=>'mensajero_id',
			id		=>'mensajero_id',
			type	=>'hidden',
			value	=>'',
			datatype=>array(
				type	=>'integer',
				length	=>'20')
		);

		$this -> Campos[mensajero] = array(
			name	=>'mensajero',
			id		=>'mensajero',
			type	=>'text',
			disabled=>'disabled',
			suggest=>array(
				name	=>'mensajero',
				setId	=>'mensajero_id')
		);	
		
		$this -> Campos[placa] = array(
			name	=>'placa',
			id		=>'placa',
			type	=>'text',
			size    => '9',
			datatype=>array(
				type	=>'text',
				length	=>'6')
		);	

		$this -> Campos[si_usuario] = array(
			name	=>'si_usuario',
			id		=>'si_usuario',
			type	=>'select',
			options	=>null,
			selected=>0,
			required=>'yes',
			onchange=>'Usuario_si();'
		);
		$this -> Campos[usuario_id] = array(
			name	=>'usuario_id',
			id		=>'usuario_id',
			type	=>'hidden',
			value	=>'',
			datatype=>array(
				type	=>'integer',
				length	=>'20')
		);
		$this -> Campos[usuario] = array(
			name	=>'usuario',
			id		=>'usuario',
			type	=>'text',
			disabled=>'disabled',
			suggest=>array(
				name	=>'usuario_disponible',
				setId	=>'usuario_id')
		);	


		$this -> Campos[origen] = array(
			name=>'origen',
			id=>'origen',
			type=>'text',
			size=>16,
			suggest=>array(
				name=>'ciudad',
				setId=>'origen_id')
		); 
		$this -> Campos[origen_id] = array(
			name=>'origen_id',
			id=>'origen_id',
			type=>'hidden',
				// required=>'yes',	
			datatype=>array(
				type=>'integer',
				length=>'20')
		);



		$this -> Campos[guia_id] = array(
			name=>'guia_id',
			id=>'guia_id',
				// required=>'yes',
			type=>'text',
			disabled=>'true'
		); 
		$this -> Campos[allguia] = array(
			name	=>'allguia',
			id		=>'allguia',
			type	=>'select',
			onchange=>'sologuia();',
			selected=>'N',
			required=>'yes',
			options =>array(array(value=>'S',text=>'SI'),array(value=>'N',text=>'NO'))
		);



		$this -> Campos[reexpedido] = array(
			name=>'reexpedido',
			id=>'reexpedido',
				// required=>'yes',
			type=>'text',
			disabled=>'true',
			datatype=>array(
				type=>'integer',
				length=>'20')
		); 

		$this -> Campos[allreexpedido] = array(
			name	=>'allreexpedido',
			id		=>'allreexpedido',
			type	=>'select',
			onchange=>'soloreexpedido();',
			selected=>'N',
			required=>'yes',
			options =>array(array(value=>'S',text=>'SI'),array(value=>'N',text=>'NO'))
		); 

		$this -> Campos[consolidado] = array(
			name	=>'consolidado',
			id		=>'consolidado',
			type	=>'select',
			selected=>'N',
			required=>'yes',
			disabled=>'true',
			options =>array(array(value=>'S',text=>'SI'),array(value=>'N',text=>'NO'))
		);	



		$this -> Campos[destino] = array(
			name=>'destino',
			id=>'destino',
			type=>'text',
			size=>16,
			suggest=>array(
				name=>'ciudad',
				setId=>'destino_id')
		);
		$this -> Campos[destino_id] = array(
			name=>'destino_id',
			id=>'destino_id',
			type=>'hidden',
			value=>'',
				// required=>'yes',
			datatype=>array(
				type=>'integer',
				length=>'20')
		);

		$this -> Campos[oficina_id] = array(
			name	=>'oficina_id',
			id		=>'oficina_id',
			type	=>'select',
			required=>'yes',
			multiple=>'yes'
		);	

		$this -> Campos[all_oficina] = array(
			name	=>'all_oficina',
			id		=>'all_oficina',
			type	=>'checkbox',
			onclick =>'all_oficce();',
			value	=>'NO'
		);	



			/////// BOTONES 

		$this -> Campos[generar] = array(
			name	=>'generar',
			id		=>'generar',
			type	=>'button',
			value	=>'Generar',
			onclick =>'OnclickGenerar(this.form)'
		);		

		$this -> Campos[generar_excel] = array(
			name	=>'generar_excel',
			id		=>'generar_excel',
			type	=>'button',
			value	=>'Generar Excel',
			onclick =>'OnclickGenerarExcel(this.form)'
		);

		$this -> Campos[excel_formato1] = array(
			name	=>'excel_formato1',
			id		=>'excel_formato1',
			type	=>'button',
			value	=>'Generar Excel Filtrado',
			onclick =>'OnclickGenerarExcelFiltrado(this.form)'
		);


		$this -> Campos[imprimir] = array(
			name   =>'imprimir',
			id   =>'imprimir',
			type   =>'button',
			value   =>'Imprimir',
			onclick =>'beforePrint(this.form)'
		);
		$this -> SetVarsValidate($this -> Campos);
	}
}
$ReporteGuiasMensajero = new ReporteGuiasMensajero();
?>