<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class TarifasMasivoModel extends Db{

	private $usuario_id;
	private $Permisos;

	public function SetUsuarioId($usuario_id,$oficina_id){
		$this -> Permisos = new PermisosForm();
		$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
	}

	public function getPermiso($ActividadId,$Permiso,$Conex){
		return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
	}

	public function Save($usuario,$oficina,$Campos,$Conex){

		$tarifas_masivo_id				= $this -> DbgetMaxConsecutive("tarifas_masivo","tarifas_masivo_id",$Conex,true,1);
		$tipo_servicio_mensajeria_id	= $this -> requestDataForQuery("tipo_servicio_mensajeria_id");
		$tipo_envio_id					= $this -> requestDataForQuery("tipo_envio_id");
		$rango_inicial					= $this -> requestDataForQuery("rango_inicial");
		$rango_final					= $this -> requestDataForQuery("rango_final");
		$vr_min_declarado				= $this -> requestDataForQuery("vr_min_declarado");
		$valor_min						= $this -> requestDataForQuery("valor_min");
		$valor_max						= $this -> requestDataForQuery("valor_max");
		$porcentaje_seguro				= $this -> requestDataForQuery("porcentaje_seguro");
		$periodo						= $this -> requestDataForQuery("periodo");

		// $select="SELECT
		// 			tarifas_masivo_id
		// 		FROM
		// 			tarifas_masivo
		// 		WHERE
		// 			tipo_servicio_mensajeria_id = $tipo_servicio_mensajeria_id AND
		// 			periodo = $periodo
		// 		";
		// $result = $this -> DbFetchAll($select,$Conex);
		// if (count($result)>0){
		// 	exit('Esta tarifa ya esta parametrizada.');
		// }else{
			$select="SELECT
						tarifas_masivo_id
					FROM
						tarifas_masivo
					WHERE tipo_envio_id=$tipo_envio_id AND tarifas_masivo_id=$tarifas_masivo_id AND 
						($rango_inicial BETWEEN rango_inicial AND rango_final OR $rango_final BETWEEN rango_inicial AND rango_final)
			";
			$result = $this -> DbFetchAll($select,$Conex);
			if (count($result)>0) {
				exit('El rango asignado a esta tarifa se cruza con el rago de una tarifa existente.');
			}else{
				$query = "INSERT INTO tarifas_masivo
							(
							tarifas_masivo_id,
							tipo_envio_id,
							rango_inicial,
							rango_final,
							vr_min_declarado,
							valor_min,
							valor_max,
							porcentaje_seguro,
							periodo,
							usuario,
							oficina)
						VALUES(
							$tarifas_masivo_id,
							$tipo_envio_id,
							$rango_inicial,
							$rango_final,
							$vr_min_declarado,
							$valor_min,
							$valor_max,
							$porcentaje_seguro,
							$periodo,
							$usuario,
							$oficina
							)";
				$this -> query($query,$Conex); 
				if ($this -> GetNumError()>0) {
					exit('Error al añadir la tarifa.');
				}else{
					exit('La tarifa ha sido añadida correctamente.');
				}
			}
		// }
	}

	public function Update($usuario,$oficina,$Campos,$Conex){

		$tarifas_masivo_id				= $this -> requestDataForQuery("tarifas_masivo_id");
		$tipo_servicio_mensajeria_id	= $this -> requestDataForQuery("tipo_servicio_mensajeria_id");
		$tipo_envio_id	= $this -> requestDataForQuery("tipo_envio_id");
		$rango_inicial					= $this -> requestDataForQuery("rango_inicial");
		$rango_final					= $this -> requestDataForQuery("rango_final");
		$vr_min_declarado				= $this -> requestDataForQuery("vr_min_declarado");
		$valor_min						= $this -> requestDataForQuery("valor_min");
		$valor_max						= $this -> requestDataForQuery("valor_max");
		$porcentaje_seguro				= $this -> requestDataForQuery("porcentaje_seguro");
		$periodo						= $this -> requestDataForQuery("periodo");

		// $select="SELECT
		// 			tarifas_masivo_id
		// 		FROM
		// 			tarifas_masivo
		// 		WHERE
		// 			($rango_inicial BETWEEN rango_inicial AND rango_final OR $rango_final BETWEEN rango_inicial AND rango_final)
		// ";
		// $result = $this -> DbFetchAll($select,$Conex);
		// if (count($result)>0) {
		// 	exit('El rango asignado a esta tarifa se cruza con el rago de una tarifa existente.');
		// }else{
			$query = "UPDATE tarifas_masivo
				SET
				vr_min_declarado	=	$vr_min_declarado,
				valor_min			=	$valor_min,
				valor_max			=	$valor_max,
				porcentaje_seguro	=	$porcentaje_seguro,
				usuario				=	$usuario,
				oficina				=	$oficina
			WHERE
				tarifas_masivo_id	=	$tarifas_masivo_id AND
				tipo_envio_id	=	$tipo_envio_id AND
				periodo				=	$periodo AND
				rango_inicial		=	$rango_inicial AND
				rango_final			=	$rango_final
			";
			$this -> query($query,$Conex);
			if ($this -> GetNumError()>0) {
				exit('Error al actualizar la tarifa.');
			}else{
				exit('La tarifa ha sido actualizada correctamente.');
			}
		// }
	}

  public function duplicar($Conex){
	 

	$this -> Begin($Conex);

	  $periodo  					= $this -> requestDataForQuery('periodo','integer');
	  $periodo_final    			= $this -> requestDataForQuery('periodo_final','integer');
	  
	  $select = "SELECT * FROM tarifas_masivo WHERE periodo=$periodo";
	  $result	=	$this -> DbFetchAll($select,$Conex,true);		  

	  if (count($result)==0) {
			exit('No Existen Tarifas Creadas con Este Tipo de Servicio en el Periodo Base Seleccionado. <br> Por favor Verifique.');
	  }

	  $select2 = "SELECT tarifas_masivo_id FROM tarifas_masivo WHERE periodo=$periodo_final";
	  $result2	=	$this -> DbFetchAll($select2,$Conex,true);
	  if (count($result2)>0) {
			exit('Ya se Crearon Tarifas de Mensajeria en el Periodo Final con el Mismo Tipo de Servicio.');
		}else{
			for($i=0;$i<count($result);$i++){
		  
			  $tipo_servicio_mensajeria_id 	= $result[$i]['tipo_servicio_mensajeria_id'];
			  $tipo_envio_id 				= $result[$i]['tipo_envio_id'];
			  $rango_inicial 				= $result[$i]['rango_inicial'];					  
			  $rango_final 					= $result[$i]['rango_final'];					  
			  $vr_min_declarado 			= $result[$i]['vr_min_declarado'];
			  $valor_min					= $result[$i]['valor_min'];
			  $valor_max					= $result[$i]['valor_max'];
			  $porcentaje_seguro 			= $result[$i]['porcentaje_seguro'];
			  $usuario 						= $result[$i]['usuario'];	
			  $oficina 						= $result[$i]['oficina'];				  
			  $tarifas_masivo_id			= $this	->	DbgetMaxConsecutive("tarifas_masivo","tarifas_masivo_id",$Conex,true,1);
			  
			  $insert 	= "INSERT INTO tarifas_masivo (tarifas_masivo_id,tipo_servicio_mensajeria_id,tipo_envio_id,rango_inicial, rango_final, 
						vr_min_declarado, valor_min, valor_max,  porcentaje_seguro,periodo, usuario, oficina) 
						VALUES ($tarifas_masivo_id,$tipo_servicio_mensajeria_id,$tipo_envio_id,$rango_inicial, $rango_final,$vr_min_declarado,  
						$valor_min, $valor_max, $porcentaje_seguro, $periodo_final, $usuario, $oficina)";	
			  //echo $result1;
			  $result1 = $this -> query($insert,$Conex,true);
			}
		}
		$this -> Commit($Conex);	  
  }

	public function Delete($Campos,$Conex){
		$this -> DbDeleteTable("tarifas_masivo",$Campos,$Conex,true,false);
		exit('Tarifa eliminada correctamente');
	}	

	public function selectTarifasMasivo($tarifas_masivo_id,$Conex){

		$select         = "SELECT * FROM tarifas_masivo WHERE tarifas_masivo_id = $tarifas_masivo_id";
		$result         = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
		// echo "$result";
		return $result;
	}

	public function GetTipoMensajeria($Conex){
		$result =  $this  -> DbFetchAll("SELECT tipo_servicio_mensajeria_id AS value,nombre_corto AS text FROM tipo_servicio_mensajeria WHERE nombre_corto LIKE 'MASIVO' ORDER BY nombre_corto ASC",$Conex,false);
		return $result;
	}

	public function GetTipoEnvio($Conex){
		$result =  $this  -> DbFetchAll("SELECT tipo_envio_id AS value,nombre AS text FROM tipo_envio ORDER BY nombre ASC",$Conex,false);
		return $result;
	}

	public function GetPeriodo($Conex){
		$result =  $this  -> DbFetchAll("SELECT periodo_contable_id AS value, anio AS text FROM periodo_contable WHERE estado=1 ORDER BY anio ASC",$Conex,false);
		return $result;
	}

	public function getQueryTarifasMasivoGrid(){
		$Query = "SELECT
				(SELECT nombre FROM tipo_servicio_mensajeria WHERE tipo_servicio_mensajeria_id = tm.tipo_servicio_mensajeria_id) AS tipo_servicio_mensajeria_id,
				(SELECT nombre FROM tipo_envio WHERE tipo_envio_id = tm.tipo_envio_id) AS tipo_envio_id,

				(SELECT CONCAT('Desde: ',tm.rango_inicial,' Hasta: ',tm.rango_final)) AS rango,
				valor_min,
				valor_max,
				vr_min_declarado,					
				porcentaje_seguro,
				(SELECT anio FROM periodo_contable WHERE periodo_contable_id=tm.periodo) AS periodo
			FROM
				tarifas_masivo tm
			";
		return $Query;
	}
}
?>