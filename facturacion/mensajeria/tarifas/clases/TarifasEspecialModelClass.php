<?php

	require_once("../../../framework/clases/DbClass.php");
	require_once("../../../framework/clases/PermisosFormClass.php");

	final class TarifasEspecialModel extends Db{

		private $usuario_id;
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

		public function Save($usuario,$oficina,$Campos,$Conex){

			$tarifas_especiales_id			=	$this	->	DbgetMaxConsecutive("tarifas_especiales","tarifas_especiales_id",$Conex,true,1);
			$origen_id					  =	  $this	  ->  requestDataForQuery("origen_id");
			$destino_id         		  =   $this   ->  requestDataForQuery("destino_id");
			$valor_primerKg     		  =   $this   ->  requestDataForQuery("valor_primerKg");
			$valor_adicionalkg  		  =   $this   ->  requestDataForQuery("valor_adicionalkg");
			$tipo_envio_id      		  =   $this   ->  requestDataForQuery("tipo_envio_id");
			$tipo_servicio_mensajeria_id  =   $this   ->  requestDataForQuery("tipo_servicio_mensajeria_id");

			$select="SELECT
						tarifas_especiales_id
					FROM
						tarifas_especiales
					WHERE
						tarifas_especiales_id = $tarifas_especiales_id AND tipo_envio_id=$tipo_envio_id AND origen_id=$origen_id
						AND destino_id=$destino_id";
					//echo "$select";
			$result = $this -> DbFetchAll($select,$Conex);
			if (count($result)>0){
				exit('Esta tarifa ya esta parametrizada.');
			}else{
				$query ="INSERT INTO tarifas_especiales(
							tarifas_especiales_id,
							origen_id,			
			                destino_id,  
			                valor_primerKg,        
			                valor_adicionalkg,
			                tipo_servicio_mensajeria_id,
			                tipo_envio_id
						)
						VALUES(
							$tarifas_especiales_id,
							$origen_id,			
			                $destino_id,  
			                $valor_primerKg,        
			                $valor_adicionalkg,
			                $tipo_servicio_mensajeria_id,
			                $tipo_envio_id
						)";
					
				$reult = $this -> query($query,$Conex,true);
				if ($this -> GetNumError()>0) {
					exit('Error al añadir la tarifa.');
				}else{
					exit('La tarifa ha sido añadida.');
				}
			}
		}

		public function Update($Campos,$Conex){

			$tarifas_especiales_id 	      =   $this -> requestDataForQuery('tarifas_especiales_id');
			$origen_id 					  =   $this -> requestDataForQuery('origen_id');
			$destino_id 				  =   $this -> requestDataForQuery('destino_id');
			$valor_primerKg 			  =   $this -> requestDataForQuery('valor_primerKg');
			$valor_adicionalkg 			  =   $this -> requestDataForQuery('valor_adicionalkg');
			$tipo_envio_id                =   $this ->  requestDataForQuery("tipo_envio_id");
			$tipo_servicio_mensajeria_id  =   $this ->  requestDataForQuery("tipo_servicio_mensajeria_id");
			

			$query="UPDATE tarifas_especiales SET  origen_id = $origen_id,
													destino_id = $destino_id,
													valor_primerKg = $valor_primerKg,
													valor_adicionalkg = $valor_adicionalkg,
													tipo_envio_id = $tipo_envio_id,
													tipo_servicio_mensajeria_id = $tipo_servicio_mensajeria_id
				WHERE
					tarifas_especiales_id = $tarifas_especiales_id
				";
			
				$result = $this -> query($query,$Conex,true);
				if ($this -> GetNumError()>0) {
					exit('Error al actualizar la tarifa.');
				}else{
					exit('Tarifa actualizada correctamente.');
				}
		}
		
		public function GetTipoServicio($Conex){
			$result = $this -> DbFetchAll("SELECT tipo_servicio_mensajeria_id AS value,nombre AS text FROM tipo_servicio_mensajeria ORDER BY nombre ASC",$Conex,false);
			return $result;
		  }  

		public function Delete($Campos,$Conex){
			$this -> DbDeleteTable("tarifas_especiales",$Campos,$Conex,true,false);
			exit('Tarifa especial eliminada correctamente');
		}	

		public function selectTarifasEspeciales($tarifas_especiales_id,$Conex){

			$select         = "SELECT te.*,
			                  (SELECT u.nombre FROM ubicacion u WHERE te.origen_id=u.ubicacion_id)AS origen,
					          (SELECT u.nombre FROM ubicacion u WHERE te.destino_id=u.ubicacion_id)AS destino,
                              (SELECT en.nombre FROM tipo_envio en WHERE te.tipo_envio_id=en.tipo_envio_id)AS tipo_envio
			                   FROM tarifas_especiales te
							   WHERE tarifas_especiales_id = $tarifas_especiales_id";
			$result         = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
			
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
		$result =  $this  -> DbFetchAll("SELECT tipo_envio_id AS value,nombre AS text FROM tipo_envio WHERE tipo_envio_id=1 OR tipo_envio_id=3 ORDER BY nombre ASC",$Conex,false);
		return $result;
	}


		public function getQueryTarifasEspecialesGrid(){
			$Query = "SELECT
					te.tarifas_especiales_id,
					(SELECT u.nombre FROM ubicacion u WHERE te.origen_id=u.ubicacion_id)AS origen,
					(SELECT u.nombre FROM ubicacion u WHERE te.destino_id=u.ubicacion_id)AS destino,
					te.valor_primerKg,
					te.valor_adicionalKg,
					(SELECT en.nombre FROM tipo_envio en WHERE te.tipo_envio_id=en.tipo_envio_id)AS tipo_envio
				FROM 
					tarifas_especiales te
				";
			return $Query;
		}
	}
?>