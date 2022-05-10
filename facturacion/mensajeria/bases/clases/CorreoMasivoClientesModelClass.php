<?php

	require_once("../../../framework/clases/DbClass.php");
	require_once("../../../framework/clases/PermisosFormClass.php");

	final class CorreoMasivoClientesModel extends Db{

		public function GetPeriodo($Conex){

			$select="SELECT periodo_contable_id, anio FROM periodo_contable";
			$result  = $this -> DbFetchAll($select,$Conex);
			return $result;
		}

		public function GetTarifasCliente($Conex){

			$cliente	=	$this	->	requestDataForQuery('cliente_id', 'integer');

			$select="SELECT
					te.tipo_envio_id, te.nombre,
					(SELECT tm.tarifas_masivo_id FROM tarifas_masivo tm WHERE tm.tipo_envio_id=te.tipo_envio_id AND tm.tipo_servicio_mensajeria_id=2 
					 AND tm.periodo=(SELECT periodo_contable_id FROM periodo_contable p WHERE anio=YEAR(CURDATE()))) AS tarifas_masivo_id,
					
					(SELECT tm.tarifas_masivo_cliente_id FROM tarifas_masivo_cliente tm WHERE tm.tipo_envio_id=te.tipo_envio_id AND tm.cliente_id=$cliente
					AND tm.tipo_servicio_mensajeria_id=2 AND tm.periodo=(SELECT periodo_contable_id FROM periodo_contable p WHERE anio=YEAR(CURDATE()))) AS tarifas_masivo_cliente_id,

					IF((SELECT CONCAT_WS('-',tm.rango_inicial,tm.rango_final) FROM tarifas_masivo_cliente tm WHERE tm.tipo_envio_id=te.tipo_envio_id AND tm.tipo_servicio_mensajeria_id=2  AND tm.cliente_id=$cliente
					 AND tm.periodo=(SELECT periodo_contable_id FROM periodo_contable p WHERE anio=YEAR(CURDATE()))) IS NOT NULL,
					(SELECT CONCAT_WS('-',tm.rango_inicial,tm.rango_final) FROM tarifas_masivo_cliente tm WHERE tm.tipo_envio_id=te.tipo_envio_id AND tm.tipo_servicio_mensajeria_id=2 AND tm.cliente_id=$cliente
					 AND tm.periodo=(SELECT periodo_contable_id FROM periodo_contable p WHERE anio=YEAR(CURDATE()))),
					(SELECT CONCAT_WS('-',tm.rango_inicial,tm.rango_final) FROM tarifas_masivo tm WHERE tm.tipo_envio_id=te.tipo_envio_id AND tm.tipo_servicio_mensajeria_id=2 
					 AND tm.periodo=(SELECT periodo_contable_id FROM periodo_contable p WHERE anio=YEAR(CURDATE())))) AS rangos, 

					IF((SELECT tm.valor_min FROM tarifas_masivo_cliente tm WHERE tm.tipo_envio_id=te.tipo_envio_id AND tm.tipo_servicio_mensajeria_id=2  AND tm.cliente_id=$cliente
					 AND tm.periodo=(SELECT periodo_contable_id FROM periodo_contable p WHERE anio=YEAR(CURDATE()))) IS NOT NULL,
					(SELECT tm.valor_min FROM tarifas_masivo_cliente tm WHERE tm.tipo_envio_id=te.tipo_envio_id AND tm.tipo_servicio_mensajeria_id=2 AND tm.cliente_id=$cliente
					 AND tm.periodo=(SELECT periodo_contable_id FROM periodo_contable p WHERE anio=YEAR(CURDATE()))),
					(SELECT tm.valor_min FROM tarifas_masivo tm WHERE tm.tipo_envio_id=te.tipo_envio_id AND tm.tipo_servicio_mensajeria_id=2 
					 AND tm.periodo=(SELECT periodo_contable_id FROM periodo_contable p WHERE anio=YEAR(CURDATE())))) AS base_ini, 

					IF((SELECT tm.valor_max FROM tarifas_masivo_cliente tm WHERE tm.tipo_envio_id=te.tipo_envio_id AND tm.tipo_servicio_mensajeria_id=2  AND tm.cliente_id=$cliente
					 AND tm.periodo=(SELECT periodo_contable_id FROM periodo_contable p WHERE anio=YEAR(CURDATE()))) IS NOT NULL,
					(SELECT tm.valor_max FROM tarifas_masivo_cliente tm WHERE tm.tipo_envio_id=te.tipo_envio_id AND tm.tipo_servicio_mensajeria_id=2 AND tm.cliente_id=$cliente
					 AND tm.periodo=(SELECT periodo_contable_id FROM periodo_contable p WHERE anio=YEAR(CURDATE()))),
					(SELECT tm.valor_max FROM tarifas_masivo tm WHERE tm.tipo_envio_id=te.tipo_envio_id AND tm.tipo_servicio_mensajeria_id=2 
					 AND tm.periodo=(SELECT periodo_contable_id FROM periodo_contable p WHERE anio=YEAR(CURDATE())))) AS base_max, 


					IF((SELECT tm.vr_min_declarado FROM tarifas_masivo_cliente tm WHERE tm.tipo_envio_id=te.tipo_envio_id AND tm.tipo_servicio_mensajeria_id=2  AND tm.cliente_id=$cliente
					 AND tm.periodo=(SELECT periodo_contable_id FROM periodo_contable p WHERE anio=YEAR(CURDATE()))) IS NOT NULL,
					(SELECT tm.vr_min_declarado FROM tarifas_masivo_cliente tm WHERE tm.tipo_envio_id=te.tipo_envio_id AND tm.tipo_servicio_mensajeria_id=2 AND tm.cliente_id=$cliente
					 AND tm.periodo=(SELECT periodo_contable_id FROM periodo_contable p WHERE anio=YEAR(CURDATE()))),
					(SELECT tm.vr_min_declarado FROM tarifas_masivo tm WHERE tm.tipo_envio_id=te.tipo_envio_id AND tm.tipo_servicio_mensajeria_id=2 
					 AND tm.periodo=(SELECT periodo_contable_id FROM periodo_contable p WHERE anio=YEAR(CURDATE())))) AS vr_min_declarado, 

					IF((SELECT tm.porcentaje_seguro FROM tarifas_masivo_cliente tm WHERE tm.tipo_envio_id=te.tipo_envio_id AND tm.tipo_servicio_mensajeria_id=2  AND tm.cliente_id=$cliente
					 AND tm.periodo=(SELECT periodo_contable_id FROM periodo_contable p WHERE anio=YEAR(CURDATE()))) IS NOT NULL,
					(SELECT tm.porcentaje_seguro FROM tarifas_masivo_cliente tm WHERE tm.tipo_envio_id=te.tipo_envio_id AND tm.tipo_servicio_mensajeria_id=2 AND tm.cliente_id=$cliente
					 AND tm.periodo=(SELECT periodo_contable_id FROM periodo_contable p WHERE anio=YEAR(CURDATE()))),
					(SELECT tm.porcentaje_seguro FROM tarifas_masivo tm WHERE tm.tipo_envio_id=te.tipo_envio_id AND tm.tipo_servicio_mensajeria_id=2 
					 AND tm.periodo=(SELECT periodo_contable_id FROM periodo_contable p WHERE anio=YEAR(CURDATE())))) AS porcentaje_seguro 
					
					FROM tipo_envio te ";
				 //echo "$select";
				$result= $this -> DbFetchAll($select,$Conex,true);
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
					te.tipo_envio_id, te.nombre,
					(SELECT tm.tarifas_masivo_id FROM tarifas_masivo tm WHERE tm.tipo_envio_id=te.tipo_envio_id AND tm.tipo_servicio_mensajeria_id=2 
					 AND tm.periodo=(SELECT periodo_contable_id FROM periodo_contable p WHERE periodo_contable_id=$periodo_contable_id)) AS tarifas_masivo_id,
					
					(SELECT tm.tarifas_masivo_cliente_id FROM tarifas_masivo_cliente tm WHERE tm.tipo_envio_id=te.tipo_envio_id AND tm.cliente_id=$cliente
					AND tm.tipo_servicio_mensajeria_id=2 AND tm.periodo=(SELECT periodo_contable_id FROM periodo_contable p WHERE periodo_contable_id=$periodo_contable_id)) AS tarifas_masivo_cliente_id,
					
					IF((SELECT CONCAT_WS('-',tm.rango_inicial,tm.rango_final) FROM tarifas_masivo_cliente tm WHERE tm.tipo_envio_id=te.tipo_envio_id AND tm.tipo_servicio_mensajeria_id=2  AND tm.cliente_id=$cliente
					 AND tm.periodo=(SELECT periodo_contable_id FROM periodo_contable p WHERE periodo_contable_id=$periodo_contable_id)) IS NOT NULL,
					(SELECT CONCAT_WS('-',tm.rango_inicial,tm.rango_final) FROM tarifas_masivo_cliente tm WHERE tm.tipo_envio_id=te.tipo_envio_id AND tm.tipo_servicio_mensajeria_id=2 AND tm.cliente_id=$cliente
					 AND tm.periodo=(SELECT periodo_contable_id FROM periodo_contable p WHERE periodo_contable_id=$periodo_contable_id)),
					(SELECT CONCAT_WS('-',tm.rango_inicial,tm.rango_final) FROM tarifas_masivo tm WHERE tm.tipo_envio_id=te.tipo_envio_id AND tm.tipo_servicio_mensajeria_id=2 
					 AND tm.periodo=(SELECT periodo_contable_id FROM periodo_contable p WHERE periodo_contable_id=$periodo_contable_id))) AS rangos, 

					IF((SELECT tm.valor_min FROM tarifas_masivo_cliente tm WHERE tm.tipo_envio_id=te.tipo_envio_id AND tm.tipo_servicio_mensajeria_id=2  AND tm.cliente_id=$cliente
					 AND tm.periodo=(SELECT periodo_contable_id FROM periodo_contable p WHERE periodo_contable_id=$periodo_contable_id)) IS NOT NULL,
					(SELECT tm.valor_min FROM tarifas_masivo_cliente tm WHERE tm.tipo_envio_id=te.tipo_envio_id AND tm.tipo_servicio_mensajeria_id=2 AND tm.cliente_id=$cliente
					 AND tm.periodo=(SELECT periodo_contable_id FROM periodo_contable p WHERE periodo_contable_id=$periodo_contable_id)),
					(SELECT tm.valor_min FROM tarifas_masivo tm WHERE tm.tipo_envio_id=te.tipo_envio_id AND tm.tipo_servicio_mensajeria_id=2 
					 AND tm.periodo=(SELECT periodo_contable_id FROM periodo_contable p WHERE periodo_contable_id=$periodo_contable_id))) AS base_ini, 

					IF((SELECT tm.valor_max FROM tarifas_masivo_cliente tm WHERE tm.tipo_envio_id=te.tipo_envio_id AND tm.tipo_servicio_mensajeria_id=2  AND tm.cliente_id=$cliente
					 AND tm.periodo=(SELECT periodo_contable_id FROM periodo_contable p WHERE periodo_contable_id=$periodo_contable_id)) IS NOT NULL,
					(SELECT tm.valor_max FROM tarifas_masivo_cliente tm WHERE tm.tipo_envio_id=te.tipo_envio_id AND tm.tipo_servicio_mensajeria_id=2 AND tm.cliente_id=$cliente
					 AND tm.periodo=(SELECT periodo_contable_id FROM periodo_contable p WHERE periodo_contable_id=$periodo_contable_id)),
					(SELECT tm.valor_max FROM tarifas_masivo tm WHERE tm.tipo_envio_id=te.tipo_envio_id AND tm.tipo_servicio_mensajeria_id=2 
					 AND tm.periodo=(SELECT periodo_contable_id FROM periodo_contable p WHERE periodo_contable_id=$periodo_contable_id))) AS base_max, 


					IF((SELECT tm.vr_min_declarado FROM tarifas_masivo_cliente tm WHERE tm.tipo_envio_id=te.tipo_envio_id AND tm.tipo_servicio_mensajeria_id=2  AND tm.cliente_id=$cliente
					 AND tm.periodo=(SELECT periodo_contable_id FROM periodo_contable p WHERE periodo_contable_id=$periodo_contable_id)) IS NOT NULL,
					(SELECT tm.vr_min_declarado FROM tarifas_masivo_cliente tm WHERE tm.tipo_envio_id=te.tipo_envio_id AND tm.tipo_servicio_mensajeria_id=2 AND tm.cliente_id=$cliente
					 AND tm.periodo=(SELECT periodo_contable_id FROM periodo_contable p WHERE periodo_contable_id=$periodo_contable_id)),
					(SELECT tm.vr_min_declarado FROM tarifas_masivo tm WHERE tm.tipo_envio_id=te.tipo_envio_id AND tm.tipo_servicio_mensajeria_id=2 
					 AND tm.periodo=(SELECT periodo_contable_id FROM periodo_contable p WHERE periodo_contable_id=$periodo_contable_id))) AS vr_min_declarado, 


					IF((SELECT tm.porcentaje_seguro FROM tarifas_masivo_cliente tm WHERE tm.tipo_envio_id=te.tipo_envio_id AND tm.tipo_servicio_mensajeria_id=2  AND tm.cliente_id=$cliente
					 AND tm.periodo=(SELECT periodo_contable_id FROM periodo_contable p WHERE periodo_contable_id=$periodo_contable_id)) IS NOT NULL,
					(SELECT tm.porcentaje_seguro FROM tarifas_masivo_cliente tm WHERE tm.tipo_envio_id=te.tipo_envio_id AND tm.tipo_servicio_mensajeria_id=2 AND tm.cliente_id=$cliente
					 AND tm.periodo=(SELECT periodo_contable_id FROM periodo_contable p WHERE periodo_contable_id=$periodo_contable_id)),
					(SELECT tm.porcentaje_seguro FROM tarifas_masivo tm WHERE tm.tipo_envio_id=te.tipo_envio_id AND tm.tipo_servicio_mensajeria_id=2 
					 AND tm.periodo=(SELECT periodo_contable_id FROM periodo_contable p WHERE periodo_contable_id=$periodo_contable_id))) AS porcentaje_seguro 
					
					FROM tipo_envio te
					WHERE te.tipo_envio_id=$tipo_envio_id"; 
					// echo "$select";
					
					$result= $this -> DbFetchAll($select,$Conex,true);
					if ($this -> GetNumError() > 0) {
						exit ('Error al buscar las tarifas.');
					}else{
						return $result;
					}
		}

		public function Save($oficina,$usuario,$Conex){

				$tarifas_masivo_cliente_id		=	$this -> DbgetMaxConsecutive("tarifas_masivo_cliente","tarifas_masivo_cliente_id",$Conex,true,1);
				$tipo_servicio_mensajeria_id	=	$this -> requestDataForQuery('tipo_servicio_mensajeria_id');
				$cliente_id						=	$this -> requestDataForQuery('cliente_id');
				$rango_inicial					=	$this -> requestDataForQuery('rango_inicial');
				$rango_final					=	$this -> requestDataForQuery('rango_final');
				$valor_min						=	$this -> requestDataForQuery('valor_min');
				$valor_max						=	$this -> requestDataForQuery('valor_max');
				$periodo_contable				=	$this -> requestDataForQuery('periodo_contable_id');
				$vr_min_declarado				=	$this -> requestDataForQuery('vr_min_declarado');
				$porcentaje_seguro				=	$this -> requestDataForQuery('porcentaje_seguro');
				$tipo_envio_id				=	$this -> requestDataForQuery('tipo_envio_id','integer');

				$select="SELECT
						tarifas_masivo_cliente_id
					FROM
						tarifas_masivo_cliente
					WHERE
						($rango_inicial BETWEEN rango_inicial AND rango_final OR $rango_final BETWEEN rango_inicial AND rango_final) AND
						tipo_envio_id=$tipo_envio_id AND tipo_servicio_mensajeria_id=$tipo_servicio_mensajeria_id AND cliente_id=$cliente_id
						AND periodo_contable=$periodo_contable";
				$result = $this -> DbFetchAll($select,$Conex);
				if (count($result)>0) {
					exit('El rango asignado a esta tarifa se cruza con el rago de una tarifa existente.');
				}else{
					$insert = "INSERT INTO
						tarifas_masivo_cliente (
							tarifas_masivo_cliente_id,
							cliente_id,
							tipo_envio_id,
							tipo_servicio_mensajeria_id,
							valor_min,
							valor_max,
							rango_inicial,
							rango_final,
							periodo,
							vr_min_declarado,
							porcentaje_seguro,
							usuario,
							oficina
						) 
						VALUES(
							$tarifas_masivo_cliente_id,
							$cliente_id,
							$tipo_envio_id,
							$tipo_servicio_mensajeria_id,
							$valor_min,
							$valor_max,
							$rango_inicial,
							$rango_final,
							$periodo_contable,
							$vr_min_declarado,
							$porcentaje_seguro,
							$usuario,
							$oficina
						)";
					// echo "$insert";
					$this -> query($insert,$Conex);
					if ($this -> GetNumError()>0) {
						exit('Error al actualizar la tarifa.');
					}else{
						exit($tarifas_masivo_cliente_id);
					}
				}
			// }
		}

		public function Update($oficina,$usuario,$Conex){

				$tarifas_masivo_cliente_id		=	$this -> requestDataForQuery("tarifas_masivo_cliente_id",'integer');
				$cliente_id						=	$this -> requestDataForQuery('cliente_id','integer');
				$tipo_servicio_mensajeria_id	=	$this -> requestDataForQuery('tipo_servicio_mensajeria_id','integer');
				$rango_inicial					=	$this -> requestDataForQuery('rango_inicial','integer');
				$rango_final					=	$this -> requestDataForQuery('rango_final','integer');
				$valor_min						=	$this -> requestDataForQuery('valor_min','integer');
				$valor_max						=	$this -> requestDataForQuery('valor_max','integer');
				$porcentaje_seguro				=	$this -> requestDataForQuery('porcentaje_seguro','integer');
				$periodo_contable_id			=	$this -> requestDataForQuery('periodo_contable_id','integer');
				$tipo_envio_id				=	$this -> requestDataForQuery('tipo_envio_id','integer');

				$update = "UPDATE tarifas_masivo_cliente 
							SET
								valor_min			= $valor_min,
								valor_max			= $valor_max,
								porcentaje_seguro	= '$porcentaje_seguro',
								usuario				= $usuario,
								oficina				= $oficina
							WHERE
								tarifas_masivo_cliente_id = $tarifas_masivo_cliente_id
								
							";
							// echo "$update";
				$this -> query($update,$Conex);
			if ($this -> GetNumError() > 0) {
				exit('Error al actualizar la tarifa.');
			}else{
				exit('Tarifa actualizada correctamente.');
			}
		}
	}
?>