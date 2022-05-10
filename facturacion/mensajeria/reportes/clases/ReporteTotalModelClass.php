<?php

	require_once("../../../framework/clases/DbClass.php");
	require_once("../../../framework/clases/PermisosFormClass.php");

	final class ReporteTotalModel extends Db{

		private $Permisos;

		public function SetUsuarioId($usuario_id,$oficina_id){
			
			$this -> Permisos = new PermisosForm();
			$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
		}

		public function GetPermiso($ActividadId,$Permiso,$Conex){

			return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
		}

		public function SetCliente($usuario_id,$Conex){

		  $select1 = "SELECT u.cliente_id, 
		  (SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM cliente c, tercero t WHERE c.cliente_id=u.cliente_id AND t.tercero_id=c.tercero_id) AS cliente 
		  FROM usuario u WHERE u.usuario_id = $usuario_id";
		  $result1 = $this -> DbFetchAll($select1,$Conex);
		  return $result1;
		}

		
		public function GetSi_Cli($Conex){

			$opciones=array(0=>array('value'=>'1','text'=>'UNO'),1=>array('value'=>'ALL','text'=>'TODOS'));
			return $opciones;
		}
	}
?>