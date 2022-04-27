<?php

	require_once("../../../framework/clases/DbClass.php");
	require_once("../../../framework/clases/PermisosFormClass.php");

	final class CorreoNormalClientesModel extends Db{

		public function GetPeriodo($Conex){

			$select="SELECT periodo_contable_id, anio FROM periodo_contable";
			$result  = $this -> DbFetchAll($select,$Conex);
			return $result;
		}

		public function GetTipoEnvio($cliente,$Conex){

			$select="SELECT
					te.tipo_envio_id,
					te.nombre,
					(SELECT tm.tarifas_mensajeria_cliente_id
					FROM tarifas_mensajeria_cliente tm 
					WHERE tm.tipo_envio_id=te.tipo_envio_id
						AND tm.cliente_id=$cliente
						AND tm.tipo_servicio_mensajeria_id=5 
						AND tm.periodo=(
							SELECT periodo_contable_id 
							FROM periodo_contable p 
							WHERE anio=YEAR(CURDATE())
						)
					) AS tarifas_mensajeria_cliente_id,
					IF( 
						(SELECT vr_kg_inicial_min 
						FROM tarifas_mensajeria_cliente tm 
						WHERE tm.tipo_envio_id=te.tipo_envio_id 
							AND tm.tipo_servicio_mensajeria_id=5 
							AND tm.cliente_id=$cliente
							AND tm.periodo=(
								SELECT periodo_contable_id 
								FROM periodo_contable p 
								WHERE anio=YEAR(CURDATE())
							)
						) IS NOT NULL,
						(SELECT vr_kg_inicial_min 
						FROM tarifas_mensajeria_cliente tm 
						WHERE tm.tipo_envio_id=te.tipo_envio_id 
							AND tm.tipo_servicio_mensajeria_id=5
							AND tm.cliente_id=$cliente
							AND tm.periodo=(
								SELECT periodo_contable_id 
								FROM periodo_contable p 
								WHERE anio=YEAR(CURDATE())
							)
						),
						(SELECT vr_kg_inicial_min 
						FROM tarifas_mensajeria tm 
						WHERE tm.tipo_envio_id=te.tipo_envio_id 
							AND tm.tipo_servicio_mensajeria_id=5 
							AND tm.periodo=(
								SELECT periodo_contable_id 
								FROM periodo_contable p 
								WHERE anio=YEAR(CURDATE())
							)
						)
					) AS min_base_ini, 


					IF( 
						(SELECT vr_kg_inicial_max 
						FROM tarifas_mensajeria_cliente tm 
						WHERE tm.tipo_envio_id=te.tipo_envio_id 
							AND tm.tipo_servicio_mensajeria_id=5
							AND tm.cliente_id=$cliente
							AND tm.periodo=(
								SELECT periodo_contable_id 
								FROM periodo_contable p 
								WHERE anio=YEAR(CURDATE())
							)
						) IS NOT NULL,
						(SELECT vr_kg_inicial_max 
						FROM tarifas_mensajeria_cliente tm 
						WHERE tm.tipo_envio_id=te.tipo_envio_id 
							AND tm.tipo_servicio_mensajeria_id=5
							AND tm.cliente_id=$cliente
							AND tm.periodo=(
								SELECT periodo_contable_id 
								FROM periodo_contable p 
								WHERE anio=YEAR(CURDATE())
							)
						),
						(SELECT vr_kg_inicial_max 
						FROM tarifas_mensajeria tm 
						WHERE tm.tipo_envio_id=te.tipo_envio_id 
							AND tm.tipo_servicio_mensajeria_id=5 
							AND tm.periodo=(
								SELECT periodo_contable_id 
								FROM periodo_contable p 
								WHERE anio=YEAR(CURDATE())
							)
						)
					) AS min_base_kg_ini, 

					IF(
						(SELECT vr_kg_adicional_min 
						FROM tarifas_mensajeria_cliente tm
						WHERE tm.tipo_envio_id=te.tipo_envio_id
							AND tm.tipo_servicio_mensajeria_id=5 
							AND tm.cliente_id=$cliente
							AND tm.periodo=(
								SELECT periodo_contable_id 
								FROM periodo_contable p 
								WHERE anio=YEAR(CURDATE())
							)
						) IS NOT NULL,
						(SELECT vr_kg_adicional_min
						FROM tarifas_mensajeria_cliente tm
						WHERE tm.tipo_envio_id=te.tipo_envio_id
							AND tm.tipo_servicio_mensajeria_id=5
							AND tm.cliente_id=$cliente
							AND tm.periodo=(
								SELECT periodo_contable_id
								FROM periodo_contable p
								WHERE anio=YEAR(CURDATE())
							)
						),
						(SELECT vr_kg_adicional_min
						FROM tarifas_mensajeria tm
						WHERE tm.tipo_envio_id=te.tipo_envio_id
							AND tm.tipo_servicio_mensajeria_id=5
							AND tm.periodo=(
								SELECT periodo_contable_id
								FROM periodo_contable p
								WHERE anio=YEAR(CURDATE())
							)
						)
					) AS min_kg_adicional,
					IF(
						(SELECT vr_min_declarado 
						FROM tarifas_mensajeria_cliente tm
						WHERE tm.tipo_envio_id=te.tipo_envio_id
							AND tm.tipo_servicio_mensajeria_id=5 
							AND tm.cliente_id=$cliente
							AND tm.periodo=(
								SELECT periodo_contable_id 
								FROM periodo_contable p 
								WHERE anio=YEAR(CURDATE())
							)
						) IS NOT NULL,
						(SELECT vr_min_declarado
						FROM tarifas_mensajeria_cliente tm
						WHERE tm.tipo_envio_id=te.tipo_envio_id
							AND tm.tipo_servicio_mensajeria_id=5
							AND tm.cliente_id=$cliente
							AND tm.periodo=(
								SELECT periodo_contable_id
								FROM periodo_contable p
								WHERE anio=YEAR(CURDATE())
							)
						),
						(SELECT vr_min_declarado
						FROM tarifas_mensajeria tm
						WHERE tm.tipo_envio_id=te.tipo_envio_id
							AND tm.tipo_servicio_mensajeria_id=5
							AND tm.periodo=(
								SELECT periodo_contable_id
								FROM periodo_contable p
								WHERE anio=YEAR(CURDATE())
							)
						)
					) AS vr_min_declarado,
					IF(
						(SELECT porcentaje_seguro 
						FROM tarifas_mensajeria_cliente tm
						WHERE tm.tipo_envio_id=te.tipo_envio_id
							AND tm.tipo_servicio_mensajeria_id=5 
							AND tm.cliente_id=$cliente
							AND tm.periodo=(
								SELECT periodo_contable_id 
								FROM periodo_contable p 
								WHERE anio=YEAR(CURDATE())
							)
						) IS NOT NULL,
						(SELECT porcentaje_seguro
						FROM tarifas_mensajeria_cliente tm
						WHERE tm.tipo_envio_id=te.tipo_envio_id
							AND tm.tipo_servicio_mensajeria_id=5
							AND tm.cliente_id=$cliente
							AND tm.periodo=(
								SELECT periodo_contable_id
								FROM periodo_contable p
								WHERE anio=YEAR(CURDATE())
							)
						),
						(SELECT porcentaje_seguro
						FROM tarifas_mensajeria tm
						WHERE tm.tipo_envio_id=te.tipo_envio_id
							AND tm.tipo_servicio_mensajeria_id=5
							AND tm.periodo=(
								SELECT periodo_contable_id
								FROM periodo_contable p
								WHERE anio=YEAR(CURDATE())
							)
						)
					) AS porcentaje_seguro
					FROM tipo_envio te
					";
				// echo "$select";
				$result= $this -> DbFetchAll($select,$Conex);
				$dataArray = $result;
			return $dataArray;
		}

		public function FindTarifa($tipo_envio_id,$cliente,$periodo_contable_id,$Conex){

			//$select="SELECT * FROM tipo_envio";
			//$result1 = $this -> DbFetchAll($select,$Conex);

			// $count = count($result1);
			$dataArray = array();
			//for ($i=0; $i < $count; $i++) { 
				// $tipo_envio = $result1[$i][tipo_envio_id];
				$select="SELECT
							te.tipo_envio_id,
							te.nombre,
							(SELECT tm.tarifas_mensajeria_cliente_id
							FROM tarifas_mensajeria_cliente tm 
							WHERE tm.tipo_envio_id=te.tipo_envio_id
								AND tm.cliente_id=$cliente
								AND tm.tipo_servicio_mensajeria_id=5 
								AND tm.periodo=(
									SELECT periodo_contable_id 
									FROM periodo_contable p 
									WHERE periodo_contable_id=$periodo_contable_id
								)
							) AS tarifas_mensajeria_cliente_id,
							IF( 
								(SELECT vr_kg_inicial_min 
								FROM tarifas_mensajeria_cliente tm 
								WHERE tm.tipo_envio_id=te.tipo_envio_id 
									AND tm.tipo_servicio_mensajeria_id=5 
									AND tm.cliente_id=$cliente
									AND tm.periodo=(
										SELECT periodo_contable_id 
										FROM periodo_contable p 
										WHERE periodo_contable_id=$periodo_contable_id
									)
								) IS NOT NULL,
								(SELECT vr_kg_inicial_min 
								FROM tarifas_mensajeria_cliente tm 
								WHERE tm.tipo_envio_id=te.tipo_envio_id 
									AND tm.tipo_servicio_mensajeria_id=5 
									AND tm.cliente_id=$cliente
									AND tm.periodo=(
										SELECT periodo_contable_id 
										FROM periodo_contable p 
										WHERE periodo_contable_id=$periodo_contable_id
									)
								),
								(SELECT vr_kg_inicial_min 
								FROM tarifas_mensajeria tm 
								WHERE tm.tipo_envio_id=te.tipo_envio_id 
									AND tm.tipo_servicio_mensajeria_id=5 
									AND tm.periodo=(
										SELECT periodo_contable_id 
										FROM periodo_contable p 
										WHERE periodo_contable_id=$periodo_contable_id
									)
								)
							) AS min_base_ini, 
							IF(
								(SELECT vr_kg_adicional_min 
								FROM tarifas_mensajeria_cliente tm
								WHERE tm.tipo_envio_id=te.tipo_envio_id
									AND tm.tipo_servicio_mensajeria_id=5 
									AND tm.cliente_id=$cliente
									AND tm.periodo=(
										SELECT periodo_contable_id 
										FROM periodo_contable p 
										WHERE periodo_contable_id=$periodo_contable_id
									)
								) IS NOT NULL,
								(SELECT vr_kg_adicional_min
								FROM tarifas_mensajeria_cliente tm
								WHERE tm.tipo_envio_id=te.tipo_envio_id
									AND tm.tipo_servicio_mensajeria_id=5
									AND tm.cliente_id=$cliente
									AND tm.periodo=(
										SELECT periodo_contable_id
										FROM periodo_contable p
										WHERE periodo_contable_id=$periodo_contable_id
									)
								),
								(SELECT vr_kg_adicional_min
								FROM tarifas_mensajeria tm
								WHERE tm.tipo_envio_id=te.tipo_envio_id
									AND tm.tipo_servicio_mensajeria_id=5
									AND tm.periodo=(
										SELECT periodo_contable_id
										FROM periodo_contable p
										WHERE periodo_contable_id=$periodo_contable_id
									)
								)
							) AS min_kg_adicional,
							IF(
								(SELECT vr_min_declarado 
								FROM tarifas_mensajeria_cliente tm
								WHERE tm.tipo_envio_id=te.tipo_envio_id
									AND tm.tipo_servicio_mensajeria_id=5 
									AND tm.cliente_id=$cliente
									AND tm.periodo=(
										SELECT periodo_contable_id 
										FROM periodo_contable p 
										WHERE periodo_contable_id=$periodo_contable_id
									)
								) IS NOT NULL,
								(SELECT vr_min_declarado
								FROM tarifas_mensajeria_cliente tm
								WHERE tm.tipo_envio_id=te.tipo_envio_id
									AND tm.tipo_servicio_mensajeria_id=5
									AND tm.cliente_id=$cliente
									AND tm.periodo=(
										SELECT periodo_contable_id
										FROM periodo_contable p
										WHERE periodo_contable_id=$periodo_contable_id
									)
								),
								(SELECT vr_min_declarado
								FROM tarifas_mensajeria tm
								WHERE tm.tipo_envio_id=te.tipo_envio_id
									AND tm.tipo_servicio_mensajeria_id=5
									AND tm.periodo=(
										SELECT periodo_contable_id
										FROM periodo_contable p
										WHERE periodo_contable_id=$periodo_contable_id
									)
								)
							) AS vr_min_declarado,
							IF(
								(SELECT porcentaje_seguro 
								FROM tarifas_mensajeria_cliente tm
								WHERE tm.tipo_envio_id=te.tipo_envio_id
									AND tm.tipo_servicio_mensajeria_id=5 
									AND tm.cliente_id=$cliente
									AND tm.periodo=(
										SELECT periodo_contable_id 
										FROM periodo_contable p 
										WHERE periodo_contable_id=$periodo_contable_id
									)
								) IS NOT NULL,
								(SELECT porcentaje_seguro
								FROM tarifas_mensajeria_cliente tm
								WHERE tm.tipo_envio_id=te.tipo_envio_id
									AND tm.tipo_servicio_mensajeria_id=5
									AND tm.cliente_id=$cliente
									AND tm.periodo=(
										SELECT periodo_contable_id
										FROM periodo_contable p
										WHERE periodo_contable_id=$periodo_contable_id
									)
								),
								(SELECT porcentaje_seguro
								FROM tarifas_mensajeria tm
								WHERE tm.tipo_envio_id=te.tipo_envio_id
									AND tm.tipo_servicio_mensajeria_id=5
									AND tm.periodo=(
										SELECT periodo_contable_id
										FROM periodo_contable p
										WHERE periodo_contable_id=$periodo_contable_id
									)
								)
							) AS porcentaje_seguro
						FROM tipo_envio te
						WHERE te.tipo_envio_id=$tipo_envio_id
						";
						// echo "$select";
					$result= $this -> DbFetchAll($select,$Conex);
					$dataArray = $result;
			//}
			/*foreach ($dataArray as $key) {
				foreach ($key as $value) {
					echo "<br>";
					print_r($key);
					echo "<br>";
				}
			}*/
			return $dataArray;
		}

		public function Save($OficinaId,$NombreUsuario,$IdUsuario,$Conex){

				$tarifas_mensajeria_cliente_id	=	$this -> DbgetMaxConsecutive("tarifas_mensajeria_cliente","tarifas_mensajeria_cliente_id",$Conex,true,1);
				$cliente_id						=	$this -> requestDataForQuery('cliente_id','integer');
				$tipo_servicio_mensajeria_id	=	$this -> requestDataForQuery('tipo_servicio_mensajeria_id','integer');
				$tipo_envio_id					=	$this -> requestDataForQuery('tipo_envio_id','integer');
				$vr_kg_inicial_min				=	$this -> requestDataForQuery('vr_kg_inicial_min','integer');
				$vr_kg_inicial_min				=	str_replace(',', '', $vr_kg_inicial_min);
				$vr_kg_inicial_min				=	str_replace('.', '', $vr_kg_inicial_min);

				$vr_kg_inicial_max				=	$this -> requestDataForQuery('vr_kg_inicial_max','integer');				
				$vr_kg_inicial_max				=	str_replace(',', '', $vr_kg_inicial_max);
				$vr_kg_inicial_max				=	str_replace('.', '', $vr_kg_inicial_max);

				$vr_kg_adicional_min			=	$this -> requestDataForQuery('vr_kg_adicional_min','integer');
				$vr_kg_adicional_min			=	str_replace(',', '', $vr_kg_adicional_min);
				$vr_kg_adicional_min			=	str_replace('.', '', $vr_kg_adicional_min);
				$porcentaje_seguro				=	$this -> requestDataForQuery('porcentaje_seguro','integer');
				$porcentaje_seguro				=	str_replace(',', '.', $porcentaje_seguro);
				$periodo_contable_id			=	$this -> requestDataForQuery('periodo_contable_id','integer');
				$vr_min_declarado				=	$this -> requestDataForQuery('vr_min_declarado','integer');
				$usuario						=	$IdUsuario;

				$insert = "INSERT INTO
								tarifas_mensajeria_cliente (
									tarifas_mensajeria_cliente_id,
									cliente_id,
									tipo_servicio_mensajeria_id,
									tipo_envio_id,
									vr_min_declarado,
									vr_kg_inicial_min,
									vr_kg_inicial_max,
									vr_kg_adicional_min,
									periodo,
									porcentaje_seguro,
									usuario,
									oficina
								) 
							VALUES(
								$tarifas_mensajeria_cliente_id,
								$cliente_id,
								$tipo_servicio_mensajeria_id,
								$tipo_envio_id,
								$vr_min_declarado,
								$vr_kg_inicial_min,
								$vr_kg_inicial_max,
								$vr_kg_adicional_min,
								$periodo_contable_id,
								'$porcentaje_seguro',
								'$usuario',
								$OficinaId
							)
							";
							// echo "$insert";
				$this -> query($insert,$Conex);
				// echo "$tarifas_mensajeria_cliente_id";
				return $tarifas_mensajeria_cliente_id;
		}

		public function Update($Capos,$OficinaId,$NombreUsuario,$IdUsuario,$Conex){

				$tarifas_mensajeria_cliente_id	=	$this -> requestDataForQuery("tarifas_mensajeria_cliente_id",'integer');
				$cliente_id						=	$this -> requestDataForQuery('cliente_id','integer');
				$tipo_servicio_mensajeria_id	=	$this -> requestDataForQuery('tipo_servicio_mensajeria_id','integer');
				$tipo_envio_id					=	$this -> requestDataForQuery('tipo_envio_id','integer');
				$vr_kg_inicial_min				=	$this -> requestDataForQuery('vr_kg_inicial_min','integer');
				$vr_kg_inicial_min				=	str_replace(',', '', $vr_kg_inicial_min);
				$vr_kg_inicial_min				=	str_replace('.', '', $vr_kg_inicial_min);
				$vr_kg_adicional_min			=	$this -> requestDataForQuery('vr_kg_adicional_min','integer');
				$vr_kg_adicional_min			=	str_replace(',', '', $vr_kg_adicional_min);
				$vr_kg_adicional_min			=	str_replace('.', '', $vr_kg_adicional_min);

				$vr_kg_inicial_max				=	$this -> requestDataForQuery('vr_kg_inicial_max','integer');				
				$vr_kg_inicial_max				=	str_replace(',', '', $vr_kg_inicial_max);
				$vr_kg_inicial_max				=	str_replace('.', '', $vr_kg_inicial_max);

				$porcentaje_seguro				=	$this -> requestDataForQuery('porcentaje_seguro','integer');
				$porcentaje_seguro				=	str_replace(',', '.', $porcentaje_seguro);
				$periodo_contable_id			=	$this -> requestDataForQuery('periodo_contable_id','integer');
				$vr_min_declarado				=	$this -> requestDataForQuery('vr_min_declarado','integer');
				$usuario						=	$IdUsuario;

				$update = "UPDATE tarifas_mensajeria_cliente 
							SET
								vr_kg_inicial_min	= $vr_kg_inicial_min,
								vr_kg_inicial_max	= $vr_kg_inicial_max,
								vr_kg_adicional_min	= $vr_kg_adicional_min,
								vr_min_declarado	= $vr_min_declarado,
								porcentaje_seguro	= '$porcentaje_seguro',
								usuario	= '$usuario',
								oficina	= $OficinaId
							WHERE 
								tarifas_mensajeria_cliente_id = $tarifas_mensajeria_cliente_id
								AND cliente_id = $cliente_id
								AND tipo_servicio_mensajeria_id = $tipo_servicio_mensajeria_id
								AND tipo_envio_id = $tipo_envio_id
								AND periodo	= $periodo_contable_id
							";
							// echo "$update";
				$this -> query($update,$Conex);
			exit('Tarifa actualizada correctamente.');
		}
	}
?>