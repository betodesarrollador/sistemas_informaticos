<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class faseModel extends Db{

	private $usuario_id;
	private $Permisos;

	public function SetUsuarioId($usuario_id,$oficina_id){	  
		$this -> Permisos = new PermisosForm();
		$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
	}

	public function getPermiso($ActividadId,$Permiso,$Conex){
		return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
	}

	public function GetProyecto($Conex){
		return $this  -> DbFetchAll("SELECT proyecto_id AS value, nombre AS text FROM  proyecto ORDER BY  nombre",$Conex,$ErrDb = false);  

	}

	public function GetUsuario($usuario_id,$Conex){
		//$select ="SELECT usuario  FROM usuario WHERE usuario_id=$usuario_id";  
		$select ="SELECT CONCAT(primer_nombre,' ',primer_apellido,' - ',numero_identificacion) AS usuario FROM tercero 
		WHERE tercero_id = (SELECT tercero_id FROM usuario WHERE usuario_id = $usuario_id)";  

		$result = $this -> DbFetchAll($select,$Conex,true);

		return $result[0]['usuario'];	

	}

	public function Save($Campos,$usuario_id,$Conex){	
		$this -> assignValRequest('usuario_id',$usuario_id);
		$fecha_inicio_programada = $this -> requestData('fecha_inicio_programada');
		$fecha_fin_programada = $this -> requestData('fecha_fin_programada');   

		$fecha_inicio_real = $this -> requestData('fecha_inicio_real');
		$fecha_fin_real = $this -> requestData('fecha_fin_real');   

		if($fecha_inicio_programada > $fecha_fin_programada){
			exit("La fecha fin programada debe ser mayor a la fecha inicio programada!!!!!");
		}

		if($fecha_inicio_real > $fecha_fin_real){
			exit("La fecha fin real debe ser mayor a la fecha inicio real !!!!!");
		}

		$this -> DbInsertTable("fase",$Campos,$Conex,true,false);	
	}

	public function Update($fase_id,$Campos,$usuario_id,$Conex){	
		date_default_timezone_set('America/Bogota');
		$select = "SELECT usuario_id FROM fase WHERE fase_id=$fase_id";
		$resul = $this->DbFetchAll($select,$Conex,true); 
		$usuario_id = $resul[0]['usuario_id'];
		$this -> assignValRequest('usuario_id',$usuario_id);
		$this -> assignValRequest('fecha_registro',$fecha_registro);
		$this -> assignValRequest('fecha_actualiza', date("Y-m-d H:i:s"));	
		$this -> assignValRequest('usuario_actualiza_id',$usuario_id);
		$this -> DbUpdateTable("fase",$Campos,$Conex,true,false);	
	}

	public function Delete($Campos,$Conex){

		$this -> DbDeleteTable("fase",$Campos,$Conex,true,false);

	}	

	public function cerrarFase($fase_id,$usuario_id,$Conex){

		$query = "UPDATE fase SET usuario_cierre_id=$usuario_id,estado=0 WHERE fase_id = $fase_id AND estado=1";
		$this -> query($query,$Conex,true);

	}				 	

	public function selectfase($Conex){

		$fase_id = $this -> requestDataForQuery('fase_id','integer');
		/*$select         = "SELECT f.fase_id, f.proyecto_id, f.nombre, f.fecha_inicio_programada, f.fecha_fin_programada, f.fecha_inicio_real, f.fecha_fin_real, f.estado, f.fecha_registro, f.usuario_id, f.fecha_actualiza, f.usuario_actualiza_id, f.usuario_cierre_id, (u.usuario)AS usuario,(u1.usuario) AS usuario_actualiza,(u2.usuario) AS usuario_cierre FROM fase f INNER JOIN usuario u ON u.usuario_id=f.usuario_id INNER JOIN usuario u1 ON u1.usuario_id=f.usuario_actualiza_id INNER JOIN usuario u2 ON u2.usuario_id=f.usuario_cierre_id WHERE fase_id =  $fase_id";*/

		$select ="SELECT f.fase_id, f.proyecto_id, f.nombre, f.fecha_inicio_programada, f.fecha_fin_programada, f.fecha_inicio_real, f.fecha_fin_real, f.estado, f.fecha_registro, f.usuario_id, f.fecha_actualiza, f.usuario_actualiza_id, f.usuario_cierre_id, CONCAT(t.primer_nombre,' ',t.primer_apellido,' - ',t.numero_identificacion)AS usuario,CONCAT(t.primer_nombre,' ',t.primer_apellido,' - ',t.numero_identificacion) AS usuario_actualiza,CONCAT(t.primer_nombre,' ',t.primer_apellido,' - ',t.numero_identificacion) AS usuario_cierre FROM fase f  INNER JOIN tercero t ON t.tercero_id=(SELECT tercero_id FROM usuario WHERE usuario_id = f.usuario_id) WHERE fase_id =  $fase_id";

		$result         = $this -> DbFetchAll($select,$Conex,$ErrDb = false);

		return $result;

	}

	public function getQueryfaseGrid(){

		$Query = "SELECT f.fase_id,f.nombre,IF(f.estado = 1,'ABIERTA','CERRADA') AS estado,(p.nombre) AS proyecto,f.fecha_inicio_programada,f.fecha_fin_programada,f.fecha_inicio_real,f.fecha_fin_real,f.fecha_registro,f.fecha_actualiza,

		(SELECT CONCAT(t.primer_nombre,' ',t.primer_apellido,' - ',t.numero_identificacion) FROM tercero t where t.tercero_id = (SELECT tercero_id FROM usuario WHERE usuario_id = f.usuario_id)) AS usuario,

		(SELECT CONCAT(t.primer_nombre,' ',t.primer_apellido,' - ',t.numero_identificacion) FROM tercero t where t.tercero_id = (SELECT tercero_id FROM usuario WHERE usuario_id = f.usuario_actualiza_id)) AS usuario_actualiza,

		(SELECT CONCAT(t.primer_nombre,' ',t.primer_apellido,' - ',t.numero_identificacion) FROM tercero t where t.tercero_id = (SELECT tercero_id FROM usuario WHERE usuario_id = f.usuario_cierre_id)) AS usuario_cierre

		

		FROM fase f INNER JOIN proyecto p ON p.proyecto_id=f.proyecto_id ";

		return $Query;

	}


}


?>