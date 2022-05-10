<?php

	require_once("../../../framework/clases/DbClass.php");
	require_once("../../../framework/clases/PermisosFormClass.php");

	final class RetencionModel extends Db{

		private $UserId;
		private $Permisos;

		public function SetUsuarioId($UserId,$CodCId){
			$this -> Permisos = new PermisosForm();
			$this -> Permisos -> SetUsuarioId($UserId,$CodCId);
		}

		public function getPermiso($ActividadId,$Permiso,$Conex){
			return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
		}

		public function selectDatosRetencionId($retencion_salarial_id,$Conex){
			$select ="SELECT
				retencion_salarial_id,
				porcentaje,
				rango_ini,
				rango_fin,
				rango_ini_pesos,
				rango_fin_pesos,
				periodo_contable_id,
				concepto
			FROM
				retencion_salarial 
			WHERE
				retencion_salarial_id = $retencion_salarial_id
			"; 
			$result    = $this -> DbFetchAll($select,$Conex,true);
			return $result;
		}

		public function calculauvt($periodo_contable_id,$Conex){
			$select ="SELECT
				t.uvt_nominal FROM uvt t WHERE	t.periodo_contable_id = $periodo_contable_id";
			$result    = $this -> DbFetchAll($select,$Conex);
			return $result;
		}

		public function Save($Campos,$Conex){
			$this -> Begin($Conex);
				$retencion_salarial_id    = $this -> DbgetMaxConsecutive("retencion_salarial","retencion_salarial_id",$Conex,true,1);
				$this -> assignValRequest('retencion_salarial_id',$retencion_salarial_id);
				$this -> DbInsertTable("retencion_salarial",$Campos,$Conex,true,false);
			$this -> Commit($Conex);
		}

		public function Update($Campos,$Conex){
			$this -> Begin($Conex);
				if($_REQUEST['retencion_salarial_id'] == 'NULL'){
					$this -> DbInsertTable("retencion_salarial",$Campos,$Conex,true,false);
				}else{
					$this -> DbUpdateTable("retencion_salarial",$Campos,$Conex,true,false);
				}
			$this -> Commit($Conex);
		}

		public function Delete($Campos,$Conex){
			$this -> DbDeleteTable("retencion_salarial",$Campos,$Conex,true,false);
		}

		public function ValidateRow($Conex,$Campos){
			require_once("../../../framework/clases/ValidateRowClass.php");
			$Data = new ValidateRow($Conex,"retencion_salarial",$Campos);
			return $Data -> GetData();
		}

		public function GetPeriodo($Conex){
			return $this -> DbFetchAll("SELECT periodo_contable_id  AS value,anio AS text FROM periodo_contable WHERE estado = '1'",$Conex,
			$ErrDb = false);
		}

		public function GetQueryRetencionGrid(){

			$Query = "SELECT
				retencion_salarial_id,
				porcentaje,
				rango_ini,
				rango_fin,
				(SELECT anio FROM periodo_contable WHERE periodo_contable_id=t.periodo_contable_id) AS periodo_contable_id
			FROM
				retencion_salarial t
			";
			return $Query;
		}
	}
?>