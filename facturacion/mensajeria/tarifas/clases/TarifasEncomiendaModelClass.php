<?php

	require_once("../../../framework/clases/DbClass.php");
	require_once("../../../framework/clases/PermisosFormClass.php");

	final class TarifasEncomiendaModel extends Db{

		private $usuario_id;
		private $Permisos;

		public function SetUsuarioId($usuario_id,$oficina_id){
			$this -> Permisos = new PermisosForm();
			$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
		}
		
		public function GetPeriodo($Conex){
			$result =  $this  -> DbFetchAll("SELECT periodo_contable_id AS value, anio AS text FROM periodo_contable WHERE estado=1 ORDER BY anio ASC",$Conex,false);
			return $result;
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
			
			$tarifas_encomienda_id	= $this	->	DbgetMaxConsecutive("tarifas_encomienda","tarifas_encomienda_id",$Conex,true,1);
			
			$_REQUEST['tarifas_encomienda_id'] = $tarifas_encomienda_id;
			$_REQUEST['oficina'] 			   = $oficina;
			$_REQUEST['usuario'] 			   = $usuario;
			
			$select = "SELECT * FROM tarifas_encomienda WHERE tipo_servicio_mensajeria_id = ".$_REQUEST['tipo_servicio_mensajeria_id']." AND tipo_envio_id = ".$_REQUEST['tipo_envio_id']." AND periodo = ".$_REQUEST['periodo'];
			
			$result = $this -> DbFetchAll($select,$Conex,true);	
			
			if(count($result) > 0){
				exit("Ya existe un registro con el mismo <b>tipo de servicio</b>, <b>tipo de envio</b> y <b>periodo</b>, por favor verifique");
			}
			
			$this -> DbInsertTable("tarifas_encomienda",$Campos,$Conex,true,false);	

		}

		public function Update($Campos,$Conex){
			
			$select = "SELECT * FROM tarifas_encomienda WHERE tipo_servicio_mensajeria_id = ".$_REQUEST['tipo_servicio_mensajeria_id']." AND tipo_envio_id = ".$_REQUEST['tipo_envio_id']." AND periodo = ".$_REQUEST['periodo']." AND  tarifas_encomienda_id != ".$_REQUEST['tarifas_encomienda_id'];
			
			$result = $this -> DbFetchAll($select,$Conex,true);	
			
			if(count($result) > 0){
				exit("Ya existe un registro con el mismo <b>tipo de servicio</b>, <b>tipo de envio</b> y <b>periodo</b>, por favor verifique");
			}
			
			unset($Campos['oficina']);
			unset($Campos['usuario']);
			
			$this -> DbUpdateTable("tarifas_encomienda",$Campos,$Conex,true,false);	
			
		}
		
		public function GetTipoServicio($Conex){
			$result = $this -> DbFetchAll("SELECT tipo_servicio_mensajeria_id AS value,nombre AS text FROM tipo_servicio_mensajeria ORDER BY nombre ASC",$Conex,false);
			return $result;
		  }  

		public function Delete($Campos,$Conex){
			$this -> DbDeleteTable("tarifas_encomienda",$Campos,$Conex,true,false);
		}	

		public function selectTarifasEncomiendaes($tarifas_encomienda_id,$Conex){

			$select = "SELECT * FROM tarifas_encomienda WHERE tarifas_encomienda_id = $tarifas_encomienda_id";
							   
			$result = $this -> DbFetchAll($select,$Conex,true);
			
			return $result;
		}

		  

	public function GetTipoEnvio($Conex){
		$result =  $this  -> DbFetchAll("SELECT tipo_envio_id AS value,nombre AS text FROM tipo_envio WHERE tipo_envio_id=1 OR tipo_envio_id=3 ORDER BY nombre ASC",$Conex,false);
		return $result;
	}


		public function getQueryTarifasEncomiendaesGrid(){
			
			$Query = "  SELECT 
						(e.nombre) AS tipo_envio, vr_min_declarado,vr_min_declarado_paq, vr_max_declarado, vr_max_declarado_paq, 		vr_kg_inicial_min, vr_kg_inicial_max, vr_kg_adicional_min, vr_kg_adicional_max, (p.anio) AS periodo, 		porcentaje_seguro
			
						FROM tarifas_encomienda t, tipo_envio e, periodo_contable p, tipo_servicio_mensajeria ts
			
						WHERE  
						t.tipo_envio_id = e.tipo_envio_id AND t.periodo = p.periodo_contable_id
						AND  t.tipo_servicio_mensajeria_id = ts.tipo_servicio_mensajeria_id";
						
			return $Query;
		}
	}
?>