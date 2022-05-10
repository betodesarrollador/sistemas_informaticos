<?php

	require_once("../../../framework/clases/DbClass.php");
	require_once("../../../framework/clases/PermisosFormClass.php");

	final class ReporteGuiasEncomiendaModel extends Db{

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
		
		public function GetEstado($Conex){

			$select = "SELECT estado_mensajeria_id AS value, nombre_estado AS text FROM estado_mensajeria";
			$result = $this -> DbFetchAll($select,$Conex);
			return $result;
		}
		
		public function GetServicio($Conex){

			$select = "SELECT tipo_servicio_mensajeria_id AS value, nombre AS text FROM tipo_servicio_mensajeria";
			$result = $this -> DbFetchAll($select,$Conex);
			return $result;
		}
		
		public function GetFormaPago($Conex){

			$select = "SELECT forma_pago_mensajeria_id AS value, nombre AS text FROM forma_pago_mensajeria WHERE forma_pago_mensajeria_id != 2";
			
			$result = $this -> DbFetchAll($select,$Conex);
			
			return $result;
		}

		public function GetSi_Rem($Conex){

			$opciones=array(0=>array('value'=>'1','text'=>'UNO'),1=>array('value'=>'ALL','text'=>'TODOS'));
			return $opciones;
		}
		
		public function GetSi_Des($Conex){

			$opciones=array(0=>array('value'=>'1','text'=>'UNO'),1=>array('value'=>'ALL','text'=>'TODOS'));
			return $opciones;
		}
		
		public function GetSi_Usu($Conex){
			$opciones=array(0=>array('value'=>'1','text'=>'UNO'),1=>array('value'=>'ALL','text'=>'TODOS'));
			return $opciones;
		}
	}
?>