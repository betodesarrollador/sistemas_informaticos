<?php

	require_once("../../../framework/clases/DbClass.php");
	require_once("../../../framework/clases/PermisosFormClass.php");

	final class TarifasModel extends Db{

		public function GetPeriodo($Conex){

			$result =  array(array(value => (date("Y")+1), text => (date("Y")+1), selected =>date("Y")),
					   array(value => date("Y"), text => date("Y"), selected => date("Y")),
					   array(value =>(date("Y")-1), text => (date("Y")-1), selected => date("Y")));
			return $result;
		}

		public function GetConvencion($tercero_id,$periodo,$Conex){

			$select="SELECT
					 	convencion_id,
						nombre,
						codigo,
						(SELECT minimo_despacho FROM tarifas_destino_cliente WHERE  periodo= $periodo AND convencion_id=c.convencion_id AND cliente_id=(SELECT cliente_id FROM cliente WHERE tercero_id=$tercero_id )) as minimo_despacho,						

						(SELECT tasa_seguro FROM tarifas_destino_cliente WHERE  periodo= $periodo AND convencion_id=c.convencion_id AND cliente_id=(SELECT cliente_id FROM cliente WHERE tercero_id=$tercero_id )) as tasa_seguro,						
						(SELECT minimo_declarado FROM tarifas_destino_cliente WHERE  periodo= $periodo AND convencion_id=c.convencion_id AND cliente_id=(SELECT cliente_id FROM cliente WHERE tercero_id=$tercero_id )) as minimo_declarado,

						(SELECT minimo_kilo FROM tarifas_destino_cliente WHERE  periodo= $periodo AND convencion_id=c.convencion_id AND cliente_id=(SELECT cliente_id FROM cliente WHERE tercero_id=$tercero_id )) as minimo_kilo,
						(SELECT minimo_kilo_unidad FROM tarifas_destino_cliente WHERE  periodo= $periodo AND convencion_id=c.convencion_id AND cliente_id=(SELECT cliente_id FROM cliente WHERE tercero_id=$tercero_id )) as minimo_kilo_unidad,
						(SELECT minimo_unidad FROM tarifas_destino_cliente WHERE  periodo= $periodo AND convencion_id=c.convencion_id AND cliente_id=(SELECT cliente_id FROM cliente WHERE tercero_id=$tercero_id )) as minimo_unidad,	
						
						(SELECT precio1 FROM tarifas_destino_cliente WHERE  periodo= $periodo AND convencion_id=c.convencion_id AND cliente_id=(SELECT cliente_id FROM cliente WHERE tercero_id=$tercero_id )) as precio1,
						(SELECT hasta FROM tarifas_destino_cliente WHERE  periodo= $periodo AND convencion_id=c.convencion_id AND cliente_id=(SELECT cliente_id FROM cliente WHERE tercero_id=$tercero_id )) as hasta,
						(SELECT precio2 FROM tarifas_destino_cliente WHERE  periodo= $periodo AND convencion_id=c.convencion_id AND cliente_id=(SELECT cliente_id FROM cliente WHERE tercero_id=$tercero_id )) as precio2,

						(SELECT tipo FROM tarifas_destino_cliente WHERE  periodo= $periodo AND convencion_id=c.convencion_id AND cliente_id=(SELECT cliente_id FROM cliente WHERE tercero_id=$tercero_id )) as tipo,
						(SELECT porcentaje FROM tarifas_destino_cliente WHERE  periodo= $periodo AND convencion_id=c.convencion_id AND cliente_id=(SELECT cliente_id FROM cliente WHERE tercero_id=$tercero_id )) as porcentaje,
						(SELECT tarifas_destino_cliente_id 	 
						 FROM tarifas_destino_cliente WHERE  periodo= $periodo AND convencion_id=c.convencion_id AND cliente_id=(SELECT cliente_id FROM cliente WHERE tercero_id=$tercero_id )) as tarifas_destino_cliente_id 							
					FROM convencion c";
				$result= $this -> DbFetchAll($select,$Conex);

			return $result;
		}
		public function GetCliente($tercero_id,$Conex){

			$select="SELECT
					 	cliente_id
					FROM cliente c WHERE tercero_id=$tercero_id";
				$result= $this -> DbFetchAll($select,$Conex);

			return $result[0]['cliente_id'];
		}


		public function Save($OficinaId,$NombreUsuario,$IdUsuario,$Conex){

				$tarifas_destino_cliente_id	=	$this -> DbgetMaxConsecutive("tarifas_destino_cliente","tarifas_destino_cliente_id",$Conex,true,1);
				$cliente_id				=	$this -> requestDataForQuery('cliente_id','integer');
				$convencion_id			=	$this -> requestDataForQuery('convencion_id','integer');
				$periodo				=	$this -> requestDataForQuery('periodo','integer');
				$porcentaje				=	$this -> requestDataForQuery('porcentaje','integer');
				$tipo					=	$this -> requestDataForQuery('tipo','text');

				$minimo_despacho		=	$this -> requestDataForQuery('minimo_despacho','integer');
				$tasa_seguro			=	$this -> requestDataForQuery('tasa_seguro','integer');
				$minimo_declarado		=	$this -> requestDataForQuery('minimo_declarado','integer');

				$minimo_kilo			=	$this -> requestDataForQuery('minimo_kilo','integer');
				$minimo_kilo_unidad		=	$this -> requestDataForQuery('minimo_kilo_unidad','integer');
				$minimo_unidad			=	$this -> requestDataForQuery('minimo_unidad','integer');
				
				$precio1				=	$this -> requestDataForQuery('precio1','integer');
				$hasta					=	$this -> requestDataForQuery('hasta','integer');
				$precio2				=	$this -> requestDataForQuery('precio2','integer');

				$insert = "INSERT INTO
								tarifas_destino_cliente (
									tarifas_destino_cliente_id,
									cliente_id,
									convencion_id,
									periodo,
									porcentaje,
									tipo,
									minimo_despacho,
									tasa_seguro,
									minimo_declarado,
									minimo_kilo,
									minimo_kilo_unidad,
									minimo_unidad,
									precio1,
									hasta,
									precio2
									
									
								) 
							VALUES(
								$tarifas_destino_cliente_id,
								$cliente_id,
								$convencion_id,
								$periodo,
								$porcentaje,
								$tipo,
								$minimo_despacho,
								$tasa_seguro,
								$minimo_declarado,
								$minimo_kilo,
								$minimo_kilo_unidad,
								$minimo_unidad,
								$precio1,
								$hasta,
								$precio2
							)	";
				$this -> query($insert,$Conex,true);
				return $tarifas_destino_cliente_id;
		}

		public function Update($Capos,$OficinaId,$NombreUsuario,$IdUsuario,$Conex){

				$tarifas_destino_cliente_id	=	$this -> requestDataForQuery("tarifas_destino_cliente_id",'integer');
				$cliente_id			=	$this -> requestDataForQuery('cliente_id','integer');
				$convencion_id		=	$this -> requestDataForQuery('convencion_id','integer');
				$periodo			=	$this -> requestDataForQuery('periodo','integer');
				$porcentaje			=	$this -> requestDataForQuery('porcentaje','integer');
				$tipo				=	$this -> requestDataForQuery('tipo','text');

				$minimo_despacho		=	$this -> requestDataForQuery('minimo_despacho','integer');
				$tasa_seguro			=	$this -> requestDataForQuery('tasa_seguro','integer');
				$minimo_declarado		=	$this -> requestDataForQuery('minimo_declarado','integer');

				$minimo_kilo			=	$this -> requestDataForQuery('minimo_kilo','integer');
				$minimo_kilo_unidad		=	$this -> requestDataForQuery('minimo_kilo_unidad','integer');
				$minimo_unidad			=	$this -> requestDataForQuery('minimo_unidad','integer');
				
				$precio1				=	$this -> requestDataForQuery('precio1','integer');
				$hasta					=	$this -> requestDataForQuery('hasta','integer');
				$precio2				=	$this -> requestDataForQuery('precio2','integer');


				$update = "UPDATE tarifas_destino_cliente 
							SET	porcentaje	= $porcentaje,	tipo= $tipo, minimo_despacho=$minimo_despacho,
							tasa_seguro=$tasa_seguro,minimo_declarado=$minimo_declarado,minimo_kilo=$minimo_kilo,
							minimo_kilo_unidad=$minimo_kilo_unidad,minimo_unidad=$minimo_unidad,
							precio1=$precio1,hasta=$hasta,precio2=$precio2
							WHERE tarifas_destino_cliente_id = $tarifas_destino_cliente_id
								AND cliente_id = $cliente_id	AND convencion_id = $convencion_id	AND periodo = $periodo";

				$this -> query($update,$Conex,true);
				exit('Tarifa actualizada correctamente.');
		}
	}
?>