<?php

	require_once("../../../framework/clases/DbClass.php");
	require_once("../../../framework/clases/PermisosFormClass.php");

	final class TarifasMensajeriaModel extends Db{

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

			$tarifas_mensajeria_id			=	$this	->	DbgetMaxConsecutive("tarifas_mensajeria","tarifas_mensajeria_id",$Conex,true,1);
			$tipo_servicio_mensajeria_id	=	$this	->	requestDataForQuery("tipo_servicio_mensajeria_id");
			$tipo_envio_id					=	$this	->	requestDataForQuery("tipo_envio_id");
			$vr_min_declarado				=	$this	->	requestDataForQuery("vr_min_declarado");
			$vr_min_declarado_paq			=	$this	->	requestDataForQuery("vr_min_declarado_paq");
			$vr_max_declarado				=	$this	->	requestDataForQuery("vr_max_declarado");
			$vr_max_declarado_paq			=	$this	->	requestDataForQuery("vr_max_declarado_paq");

			$vr_kg_inicial_min				=	$this	->	requestDataForQuery("vr_kg_inicial_min");
			$vr_kg_inicial_max				=	$this	->	requestDataForQuery("vr_kg_inicial_max");
			$vr_kg_adicional_min			=	$this	->	requestDataForQuery("vr_kg_adicional_min");
			$vr_kg_adicional_max			=	$this	->	requestDataForQuery("tipo_envio_id");
			$periodo						=	$this	->	requestDataForQuery("periodo");
			$porcentaje_seguro				=	$this	->	requestDataForQuery("porcentaje_seguro");

			$select="SELECT
						tarifas_mensajeria_id
					FROM
						tarifas_mensajeria 
					WHERE
						tipo_servicio_mensajeria_id = $tipo_servicio_mensajeria_id AND
						tipo_envio_id = $tipo_envio_id AND
						periodo = $periodo
					";
					// echo "$select";
			$result = $this -> DbFetchAll($select,$Conex);
			if (count($result)>0){
				exit('Esta tarifa ya esta parametrizada.');
			}else{
				$query ="INSERT INTO tarifas_mensajeria(
							tarifas_mensajeria_id,
							tipo_servicio_mensajeria_id,
							tipo_envio_id,
							vr_min_declarado,
							vr_min_declarado_paq,
							vr_max_declarado,
							vr_max_declarado_paq,
							vr_kg_inicial_min,
							vr_kg_inicial_max,
							vr_kg_adicional_min,
							vr_kg_adicional_max,
							periodo,
							porcentaje_seguro,
							usuario,
							oficina
						)
						VALUES(
							$tarifas_mensajeria_id,
							$tipo_servicio_mensajeria_id,
							$tipo_envio_id,
							$vr_min_declarado,
							$vr_min_declarado_paq,
							$vr_max_declarado,
							$vr_max_declarado_paq,
							$vr_kg_inicial_min,
							$vr_kg_inicial_max,
							$vr_kg_adicional_min,
							$vr_kg_adicional_max,
							$periodo,
							$porcentaje_seguro,
							$usuario,
							$oficina
						)";
					// echo "$query";
				$result = $this -> query($query,$Conex);
				if ($this -> GetNumError()>0) {
					exit('Error al añadir la tarifa.');
				}else{
					exit('La tarifa ha sido añadida.');
				}
			}
		}

		public function Update($usuario,$oficina,$Campos,$Conex){

			$vr_min_declarado				= $this -> requestDataForQuery('vr_min_declarado');
			$vr_min_declarado_paq			= $this	->	requestDataForQuery("vr_min_declarado_paq");
			$vr_max_declarado				= $this	->	requestDataForQuery("vr_max_declarado");
			$vr_max_declarado_paq			= $this	->	requestDataForQuery("vr_max_declarado_paq");
			
			$vr_kg_inicial_min				= $this -> requestDataForQuery('vr_kg_inicial_min');
			$vr_kg_inicial_max				= $this -> requestDataForQuery('vr_kg_inicial_max');
			$vr_kg_adicional_min			= $this -> requestDataForQuery('vr_kg_adicional_min');
			$vr_kg_adicional_max			= $this -> requestDataForQuery('vr_kg_adicional_max');
			$porcentaje_seguro				= $this -> requestDataForQuery('porcentaje_seguro');
			$tarifas_mensajeria_id			= $this -> requestDataForQuery('tarifas_mensajeria_id');
			$tipo_servicio_mensajeria_id	= $this -> requestDataForQuery('tipo_servicio_mensajeria_id');
			$tipo_envio_id					= $this -> requestDataForQuery('tipo_envio_id');
			$periodo						= $this -> requestDataForQuery('periodo');

			$query="UPDATE tarifas_mensajeria SET 
					vr_min_declarado = $vr_min_declarado,
					vr_min_declarado_paq = $vr_min_declarado_paq,
					vr_max_declarado = $vr_max_declarado,
					vr_max_declarado_paq = $vr_max_declarado_paq,
					vr_kg_inicial_min = $vr_kg_inicial_min,
					vr_kg_inicial_max = $vr_kg_inicial_max,
					vr_kg_adicional_min = $vr_kg_adicional_min,
					vr_kg_adicional_max = $vr_kg_adicional_max,
					porcentaje_seguro = $porcentaje_seguro,
					usuario = $usuario,
					oficina = $oficina
				WHERE
					tarifas_mensajeria_id = $tarifas_mensajeria_id AND
					tipo_servicio_mensajeria_id = $tipo_servicio_mensajeria_id AND
					tipo_envio_id = $tipo_envio_id AND
					periodo = $periodo
				";
				$result = $this -> query($query,$Conex);
				if ($this -> GetNumError()>0) {
					exit('Error al actualizar la tarifa.');
				}else{
					exit('Tarifa actualizada correctamente.');
				}
		}

		public function Delete($Campos,$Conex){
			$this -> DbDeleteTable("tarifas_mensajeria",$Campos,$Conex,true,false);
			exit('Tarifa eliminada correctamente');
		}	

		public function selectTarifasMensajeria($tarifas_mensajeria_id,$Conex){

			$select         = "SELECT * FROM tarifas_mensajeria WHERE tarifas_mensajeria_id = $tarifas_mensajeria_id";
			$result         = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
			// echo "$result";
			return $result;
		}

		  public function duplicar($Conex){
			 
		
			$this -> Begin($Conex);
		
			  $tipo_servicio_mensajeria_id 	= $this -> requestDataForQuery('tipo_servicio_mensajeria_id','integer');
			  $periodo  					= $this -> requestDataForQuery('periodo','integer');
			  $periodo_final    			= $this -> requestDataForQuery('periodo_final','integer');
			  
			  $select = "SELECT * FROM tarifas_mensajeria WHERE tipo_servicio_mensajeria_id=$tipo_servicio_mensajeria_id AND periodo=$periodo";
			  $result	=	$this -> DbFetchAll($select,$Conex,true);		  

			  if (count($result)==0) {
					exit('No Existen Tarifas Creadas con Este Tipo de Servicio en el Periodo Base Seleccionado. <br> Por favor Verifique.');
			  }

			  $select2 = "SELECT tarifas_mensajeria_id FROM tarifas_mensajeria WHERE tipo_servicio_mensajeria_id=$tipo_servicio_mensajeria_id AND
			  			  periodo=$periodo_final";
			  $result2	=	$this -> DbFetchAll($select2,$Conex,true);
			  if (count($result2)>0) {
					exit('Ya se Crearon Tarifas de Mensajeria en el Periodo Final con el Mismo Tipo de Servicio.');
				}else{
					
					for($i=0;$i<count($result);$i++){
				  		
					  $tipo_servicio_mensajeria_id 	= $result[$i]['tipo_servicio_mensajeria_id'];
					  $tipo_envio_id 				= $result[$i]['tipo_envio_id'];
					  $vr_min_declarado 			= $result[$i]['vr_min_declarado'];
					  $vr_min_declarado_paq			= $result[$i]['vr_min_declarado_paq'];
					  $vr_max_declarado				= $result[$i]['vr_max_declarado']; 
					  $vr_max_declarado_paq			= $result[$i]['vr_max_declarado_paq'];  


					  $vr_kg_inicial_min 			= $result[$i]['vr_kg_inicial_min'];
					  $vr_kg_inicial_max 			= $result[$i]['vr_kg_inicial_max'];
					  $vr_kg_adicional_min 			= $result[$i]['vr_kg_adicional_min'];
					  $vr_kg_adicional_max 			= $result[$i]['vr_kg_adicional_max'];
					  $periodo 						= $result[$i]['periodo'];
					  $porcentaje_seguro 			= $result[$i]['porcentaje_seguro'];
					  $usuario 						= $result[$i]['usuario'];	
					  $oficina 						= $result[$i]['oficina'];				  
					  $tarifas_mensajeria_id		= $this	->	DbgetMaxConsecutive("tarifas_mensajeria","tarifas_mensajeria_id",$Conex,true,1);
					  
					  $insert 	= "INSERT INTO tarifas_mensajeria (tarifas_mensajeria_id,tipo_servicio_mensajeria_id,tipo_envio_id,vr_min_declarado,vr_min_declarado_paq, vr_max_declarado,	vr_max_declarado_paq,
								vr_kg_inicial_min, vr_kg_inicial_max, vr_kg_adicional_min, vr_kg_adicional_max, periodo, porcentaje_seguro, usuario, oficina) 
								VALUES ($tarifas_mensajeria_id,$tipo_servicio_mensajeria_id,$tipo_envio_id,$vr_min_declarado,$vr_min_declarado_paq, $vr_max_declarado,	$vr_max_declarado_paq, $vr_kg_inicial_min, $vr_kg_inicial_max,
								$vr_kg_adicional_min, $vr_kg_adicional_max, $periodo_final, $porcentaje_seguro, $usuario, $oficina)";	
					  //$result1	=	$this -> DbFetchAll($insert,$Conex,true);
					  //echo $insert;
					  $this -> query($insert,$Conex,true);
				  	}
				}
			$this -> Commit($Conex);	  
			
		  }


		public function GetTipoEnvio($Conex){
			$result =  $this  -> DbFetchAll("SELECT tipo_envio_id AS value,nombre AS text FROM tipo_envio ORDER BY nombre ASC",$Conex,false);
			return $result;
		}

		public function GetTipoMensajeria($Conex){
			$result =  $this  -> DbFetchAll("SELECT tipo_servicio_mensajeria_id AS value,nombre_corto AS text FROM tipo_servicio_mensajeria WHERE nombre_corto NOT LIKE 'MASIVO' ORDER BY nombre_corto ASC",$Conex,false);
			return $result;
		}

		public function GetPeriodo($Conex){
			$result =  $this  -> DbFetchAll("SELECT periodo_contable_id AS value, anio AS text FROM periodo_contable WHERE estado=1 ORDER BY anio ASC",$Conex,false);
			return $result;
		}

		public function getQueryTarifasMensajeriaGrid(){
			$Query = "SELECT
					(SELECT nombre FROM tipo_servicio_mensajeria WHERE tipo_servicio_mensajeria_id = tm.tipo_servicio_mensajeria_id) AS tipo_servicio_mensajeria_id,
					(SELECT nombre FROM tipo_envio WHERE tipo_envio_id = tm.tipo_envio_id) AS tipo_envio_id,
					vr_min_declarado,
					vr_min_declarado_paq,
					vr_max_declarado,
					vr_max_declarado_paq,
					vr_kg_inicial_min,
					vr_kg_adicional_min,
					(SELECT anio FROM periodo_contable WHERE periodo_contable_id=periodo) AS periodo,
					porcentaje_seguro
				FROM 
					tarifas_mensajeria tm
				";
			return $Query;
		}
	}
?>