<?php

	require_once("../../../framework/clases/DbClass.php");
	require_once("../../../framework/clases/PermisosFormClass.php");

	final class reporteMINTICModel extends Db{

		private $Permisos;

		public function SetUsuarioId($usuario_id,$oficina_id){
			$this -> Permisos = new PermisosForm();
			$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
		}
	  
		public function GetPermiso($ActividadId,$Permiso,$Conex){
			return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
		}

		public function GetOficina($oficina_id,$empresa_id,$Conex){
		
			$select = "SELECT oficina_id AS value, nombre AS text,'$oficina_id' AS selected FROM oficina WHERE empresa_id = $empresa_id";
			$result = $this -> DbFetchAll($select,$Conex);
				  
			return $result;	  	  
		
		}

		public function GetSi_Cli($Conex){
			$opciones=array(0=>array('value'=>'1','text'=>'UNO'),1=>array('value'=>'ALL','text'=>'TODOS'));
			return $opciones;
		}

		public function getReporte($Conex){
			$opciones=array(
				0=>array('value'=>'1','text'=>'Ingresos por servicios de mensajería'),
				1=>array('value'=>'2','text'=>'Tiempos de entrega'),
				2=>array('value'=>'3','text'=>'Porcentaje de entrega buen estado'),
				// 3=>array('value'=>'4','text'=>'Ingresos por servicio de correo'),
				3=>array('value'=>'5','text'=>'Envíos de los servicios de mensajería'),
				4=>array('value'=>'7','text'=>'Ingresos y envios mensajeria expresa')
			);
			return $opciones;
		}

		public function getUbicacion($ubicacion,$Conex){

			$select="SELECT
				(SELECT tu.tipo_ubicacion_id FROM tipo_ubicacion tu WHERE u.tipo_ubicacion_id=tu.tipo_ubicacion_id) AS tipo_ubicacion,
			FROM 
				ubicacion u
			WHERE
				u.ubicacion_id=$ubicacion
			";

			// echo $select;
			$result = $this -> DbFetchAll($select,$Conex);
			return $result;
		}

		public function getReporte1($desde,$hasta,$consulta_origen,$consulta_destino,$consulta_cliente,$consulta_oficina,$Conex){ 

			$select="SELECT
						(SELECT year(g.fecha_guia)) AS anio,
						IF((SELECT month(g.fecha_guia)) BETWEEN 1 AND 3,1,
							IF((SELECT month(g.fecha_guia)) BETWEEN 4 AND 6,2,
								IF((SELECT month(g.fecha_guia)) BETWEEN 7 AND 9,3,4)
						)	) AS trimestre,
						(SELECT month(g.fecha_guia)) AS mes_trimestre,
						IF(((SELECT dg.peso FROM detalle_guia dg WHERE dg.guia_id=g.guia_id)/1000) > 2,2,1) AS tipo_servicio,
						IF(g.solicitud_id IS NULL,1,2) AS tipo_envio,
						IF(g.origen_id = g.destino_id,1,2) AS ambito,
						IF(((SELECT dg.peso FROM detalle_guia dg WHERE dg.guia_id=g.guia_id)/1000) BETWEEN 4.1 AND 5,
							5,IF(((SELECT dg.peso FROM detalle_guia dg WHERE dg.guia_id=g.guia_id)/1000) BETWEEN 3.1 AND 4,
								4,IF(((SELECT dg.peso FROM detalle_guia dg WHERE dg.guia_id=g.guia_id)/1000) BETWEEN 2.1 AND 3,
									3,IF(((SELECT dg.peso FROM detalle_guia dg WHERE dg.guia_id=g.guia_id)/1000) BETWEEN 1.1 AND 2,2,1)
						)	)	) AS rango_peso,
						SUM(g.valor_total) AS ingresos,
						SUM(((SELECT dg.peso FROM detalle_guia dg WHERE dg.guia_id=g.guia_id)/1000)) AS peso_total,
						COUNT(g.guia_id) AS cant_ingresos
					FROM guia g
					WHERE g.facturado=1 AND g.fecha_guia>='$desde' AND
						(0 <(SELECT  dlg.guia_id FROM factura f, detalle_factura df, liquidacion_guias_cliente lgc, detalle_liq_guias_cliente dlg WHERE dlg.guia_id=g.guia_id AND
						f.factura_id=df.factura_id AND f.estado!='I' AND  df.liquidacion_guias_cliente_id=lgc.liquidacion_guias_cliente_id AND dlg.liquidacion_guias_cliente_id=lgc.liquidacion_guias_cliente_id
						AND lgc.estado='F'  AND f.fecha BETWEEN '$desde' AND '$hasta' LIMIT 1)
						OR 0 < (SELECT dts.solicitud_id FROM factura f, detalle_factura df, liquidacion_sol_serv_guia lss, detalle_liq_sol_serv_guia dts WHERE 
						dts.solicitud_id=g.solicitud_id AND f.factura_id=df.factura_id AND lss.liquidacion_id=dts.liquidacion_id
						AND f.estado!='I' AND df.liquidacion_id=lss.liquidacion_id AND lss.estado='F' AND f.fecha BETWEEN '$desde' AND '$hasta' LIMIT 1))
						$consulta_origen $consulta_destino $consulta_cliente $consulta_oficina 
					GROUP BY rango_peso, ambito, tipo_envio, tipo_servicio, mes_trimestre, trimestre, anio
					ORDER BY anio, trimestre, mes_trimestre, tipo_servicio, tipo_envio, ambito, rango_peso
					";
					 /*echo $select;
					 exit();*/
			$result = $this -> DbFetchAll($select,$Conex);
			return $result;
		}

		public function getReporte2($desde,$hasta,$consulta_origen,$consulta_destino,$consulta_cliente,$consulta_oficina,$Conex){ 

			$select="SELECT 
						(SELECT year(g.fecha_guia)) AS anio,
						IF((SELECT month(g.fecha_guia)) BETWEEN 1 AND 3,1,
							IF((SELECT month(g.fecha_guia)) BETWEEN 4 AND 6,2,
								IF((SELECT month(g.fecha_guia)) BETWEEN 7 AND 9,3,4)
						)	) AS trimestre,
						IF(g.solicitud_id IS NULL,1,2) AS tipo_envio,
						IF(g.origen_id = g.destino_id,1,2) AS ambito,
						(SELECT DATEDIFF(
							(SELECT e.fecha_ent FROM entrega e, detalle_entrega de WHERE de.guia_id=g.guia_id AND e.entrega_id=de.entrega_id AND e.estado='E' ORDER BY e.fecha_ent DESC LIMIT 1),
							g.fecha_guia)
						*24) AS tiempo_entrega,
						COUNT(
							(SELECT DATEDIFF(
								(SELECT e.fecha_ent FROM entrega e, detalle_entrega de WHERE de.guia_id=g.guia_id AND e.entrega_id=de.entrega_id AND e.estado='E' ORDER BY e.fecha_ent DESC LIMIT 1),
								g.fecha_guia)
							*24)
						) AS cant_tiempo_entrega
					FROM guia g
					WHERE
						g.estado_mensajeria_id=6
						AND g.fecha_guia BETWEEN '$desde' AND '$hasta'
					GROUP BY IF(tiempo_entrega<96.1,tiempo_entrega,''), ambito, tipo_envio, trimestre, anio
					ORDER BY tiempo_entrega, anio, trimestre, tipo_envio, ambito
					";

			// echo $select;
			$result = $this -> DbFetchAll($select,$Conex);
			return $result;
		}
		
		public function getReporteIngresosEnviosMensajeria($desde,$hasta,$consulta_origen,$consulta_destino,$consulta_cliente,$consulta_oficina,$Conex){ 
																																						
			$peso_mayor = "IF(g.peso > IFNULL((g.peso_volumen * 1000),0), g.peso,(g.peso_volumen * 1000))";

			$select="SELECT g.fecha_guia,
			
			(SELECT year(g.fecha_guia)) AS anio,

			 IF((SELECT month(g.fecha_guia)) BETWEEN 1 AND 3,1, 
			   
			   IF((SELECT month(g.fecha_guia)) BETWEEN 4 AND 6,2,
				  
				  IF((SELECT month(g.fecha_guia)) BETWEEN 7 AND 9,3,4) ) ) AS trimestre, 
				  
			   (CASE
				WHEN  (SELECT month(g.fecha_guia)) ='1' THEN '1'
				WHEN  (SELECT month(g.fecha_guia)) ='2' THEN '2'
				WHEN  (SELECT month(g.fecha_guia)) ='3' THEN '3'
				WHEN  (SELECT month(g.fecha_guia)) ='4' THEN '1'
				WHEN  (SELECT month(g.fecha_guia)) ='5' THEN '2'
				WHEN  (SELECT month(g.fecha_guia)) ='6' THEN '3'
				WHEN  (SELECT month(g.fecha_guia)) ='7' THEN '1'
				WHEN  (SELECT month(g.fecha_guia)) ='8' THEN '2'
				WHEN  (SELECT month(g.fecha_guia)) ='9' THEN '3'
				WHEN  (SELECT month(g.fecha_guia)) ='10' THEN '1'
				WHEN  (SELECT month(g.fecha_guia)) ='11' THEN '2'
				  
				ELSE '3'
				END) AS numero_mes,
				
				(SELECT divipola FROM ubicacion WHERE ubicacion_id = g.origen_id)AS codigo_municipio_origen,
				
				(SELECT divipola FROM ubicacion WHERE ubicacion_id = g.destino_id)AS codigo_municipio_destino,
				
				'41206' AS codigo_pais,
				
				(CASE
				WHEN  $peso_mayor BETWEEN 0    AND 200  THEN '101'
				WHEN  $peso_mayor BETWEEN 200  AND 1000 THEN '102'
				WHEN  $peso_mayor BETWEEN 1000 AND 2000 THEN '103'
				WHEN  $peso_mayor BETWEEN 2000 AND 3000 THEN '104'
				WHEN  $peso_mayor BETWEEN 3000 AND 4000 THEN '105'
				WHEN  $peso_mayor BETWEEN 4000 AND 5000 THEN '106'
				ELSE 'FUERA DEL RANGO'
				
				END) AS rango_peso,
									
				SUM(g.valor_total) AS ingresos,
				  
				IF(g.solicitud_id IS NULL,1,2) AS tipo_envio, 
				  
				IF(g.origen_id = g.destino_id,1,2) AS ambito,
				
				COUNT(*) AS numero_total_envios, 

				GROUP_CONCAT(g.guia_id),
				
				(CASE
				WHEN  g.tipo = '2' THEN 'OTROS'
				WHEN  g.tipo = '1' THEN 'DOCUMENTOS'
				ELSE 'N/A'
				END) AS tipo_objeto
				  
				FROM guia g WHERE g.fecha_guia BETWEEN '$desde' AND '$hasta' AND g.estado_mensajeria_id!=8
				
				$consulta_origen  $consulta_destino  $consulta_cliente  $consulta_oficina
				
				GROUP BY fecha_guia,anio,trimestre,numero_mes,codigo_municipio_origen,codigo_municipio_destino,rango_peso,tipo_envio,ambito,tipo_objeto";

			$result = $this -> DbFetchAll($select,$Conex,true);
			
			return $result;
		}

		public function getReporte3($desde,$hasta,$consulta_origen,$consulta_destino,$consulta_cliente,$consulta_oficina,$Conex){ 

			$select = "(SELECT 
						(SELECT year(g.fecha_guia)) AS anio,
						IF((SELECT month(g.fecha_guia)) BETWEEN 1 AND 3,1,
							IF((SELECT month(g.fecha_guia)) BETWEEN 4 AND 6,2,
								IF((SELECT month(g.fecha_guia)) BETWEEN 7 AND 9,3,4)
						)	) AS trimestre,
						IF(g.solicitud_id IS NULL,1,2) AS tipo_envio,
						IF(g.origen_id = g.destino_id,1,2) AS ambito,
						COUNT(g.guia_id) AS enviados,
						'' AS entregados,
						'' AS noentregados
					FROM
						guia g
					WHERE
						g.estado_mensajeria_id IN (1,2,3,4,5) AND g.fecha_guia BETWEEN '$desde' AND '$hasta' $consulta_origen $consulta_destino $consulta_cliente $consulta_oficina
					GROUP BY ambito, tipo_envio, trimestre, anio)

					UNION ALL

					(SELECT 
						(SELECT year(g.fecha_guia)) AS anio,
						IF((SELECT month(g.fecha_guia)) BETWEEN 1 AND 3,1,
							IF((SELECT month(g.fecha_guia)) BETWEEN 4 AND 6,2,
								IF((SELECT month(g.fecha_guia)) BETWEEN 7 AND 9,3,4)
						)	) AS trimestre,
						IF(g.solicitud_id IS NULL,1,2) AS tipo_envio,
						IF(g.origen_id = g.destino_id,1,2) AS ambito,
						'' AS enviados,
						COUNT(g.guia_id) AS entregados,
						'' AS noentregados
					FROM
						guia g
					WHERE
						g.estado_mensajeria_id=6 AND g.fecha_guia BETWEEN '$desde' AND '$hasta' $consulta_origen $consulta_destino $consulta_cliente $consulta_oficina
					GROUP BY ambito, tipo_envio, trimestre, anio)

					UNION ALL

					(SELECT 
						(SELECT year(g.fecha_guia)) AS anio,
						IF((SELECT month(g.fecha_guia)) BETWEEN 1 AND 3,1,
							IF((SELECT month(g.fecha_guia)) BETWEEN 4 AND 6,2,
								IF((SELECT month(g.fecha_guia)) BETWEEN 7 AND 9,3,4)
						)	) AS trimestre,
						IF(g.solicitud_id IS NULL,1,2) AS tipo_envio,
						IF(g.origen_id = g.destino_id,1,2) AS ambito,
						'' AS enviados,
						'' AS entregados,
						COUNT(g.guia_id) AS noentregados
					FROM
						guia g
					WHERE
						g.estado_mensajeria_id=7 AND g.fecha_guia BETWEEN '$desde' AND '$hasta' $consulta_origen $consulta_destino $consulta_cliente $consulta_oficina
					GROUP BY ambito, tipo_envio, trimestre, anio)
					
					ORDER BY anio, trimestre, tipo_envio, ambito
				";

			// echo $select;
			$result = $this -> DbFetchAll($select,$Conex);
			return $result;
		}
	}
?>