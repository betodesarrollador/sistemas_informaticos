<?php

	require_once("../../../framework/clases/DbClass.php");
	require_once("../../../framework/clases/PermisosFormClass.php");

	final class ReporteGuiasModel extends Db{

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

		/*public function SetCliente($usuario_id,$Conex){

		  $select1 = "SELECT u.cliente_id, 
		  (SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM cliente c, tercero t WHERE c.cliente_id=u.cliente_id AND t.tercero_id=c.tercero_id) AS cliente 
		  FROM usuario u WHERE u.usuario_id = $usuario_id";
		  $result1 = $this -> DbFetchAll($select1,$Conex);
		  return $result1;
		}*/
		
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