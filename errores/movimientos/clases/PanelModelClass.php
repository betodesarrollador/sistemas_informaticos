<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class PanelModel extends Db{

  private $Permisos;  

	public function selectValores($Conex){

		$select="SELECT 
		         (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido, t.razon_social) FROM tercero t, cliente c WHERE t.tercero_id=c.tercero_id AND c.cliente_id=p.cliente_id)AS cliente,
				 p.cliente_id,
				 p.nombre,
				 (SELECT GROUP_CONCAT(DISTINCT f.nombre SEPARATOR ',<br><br> ') FROM fase f, actividad_fase a WHERE f.proyecto_id=p.proyecto_id AND f.fase_id=a.fase_id)AS fase,
				 (SELECT GROUP_CONCAT(DISTINCT a.nombre SEPARATOR ',<br><br> ') FROM actividad_fase a, fase f WHERE a.fase_id = f.fase_id AND f.proyecto_id=p.proyecto_id)AS actividad,
				 ((SELECT count(a.actividad_id) FROM actividad_fase a, fase f WHERE a.estado = 2 AND a.fase_id = f.fase_id AND f.proyecto_id=p.proyecto_id)*100/(SELECT count(a.actividad_id) FROM actividad_fase a, fase f WHERE a.fase_id = f.fase_id AND f.proyecto_id=p.proyecto_id))AS avance,
				  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido, t.razon_social) FROM tercero t, usuario u WHERE t.tercero_id=u.tercero_id AND u.usuario_id=p.usuario_id)AS usuario

		       FROM proyecto p";
		$result  = $this -> DbFetchAll($select,$Conex,true);

		return $result;
	 }

	 public function selectActividades($cliente_id,$Conex){

		$select="SELECT a.actividad_id,
		         a.nombre,
				 (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM tercero t WHERE t.tercero_id=a.responsable_id)AS responsable,
		         (CASE a.estado WHEN 1 THEN 'ACTIVO' WHEN 0 THEN 'INACTIVO' ELSE 'CERRADO' END)AS estado,
                 (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido, t.razon_social) FROM tercero t, usuario u WHERE t.tercero_id=u.tercero_id AND u.usuario_id=p.usuario_id)AS encargado,
				 a.descripcion,
				 a.fecha_inicial,
				 a.fecha_final,
				 a.fecha_inicial_real,
				 a.fecha_final_real,
				 f.nombre AS fase,
				 (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido, t.razon_social) FROM tercero t, cliente c WHERE t.tercero_id=c.tercero_id AND c.cliente_id=p.cliente_id)AS cliente,
				 p.nombre AS proyecto

				 FROM actividad_fase a, fase f, proyecto p WHERE a.fase_id=f.fase_id AND f.proyecto_id=p.proyecto_id AND p.cliente_id=$cliente_id";
				
		$result  = $this -> DbFetchAll($select,$Conex,true);

		return $result;
	 }

	 public function saveObservacion($actividad_id,$observacion,$Conex){
		  
		$observacion_id = $this -> DbgetMaxConsecutive("observacion_actividad_fase","observacion_id",$Conex,true,1);

		$insert="INSERT INTO observacion_actividad_fase (observacion_id,actividad_id,observacion) 
		         VALUES ($observacion_id,$actividad_id,'$observacion')";
		$this -> query($insert,$Conex,true);

		return $observacion_id;

	 }

	 public function saveCierre($actividad_id,$observacion_cierre,$fecha_cierre_real,$fecha_cierre,$usuario_id,$Conex){

      $select = "SELECT estado FROM actividad_fase WHERE actividad_id = $actividad_id";
      $result = $this->DbFetchAll($select,$Conex,true);

      $estado = $result[0]['estado'];

      if($estado == 2){
          return 0;
      }else{

        $update="UPDATE actividad_fase SET estado = 2, fecha_cierre='$fecha_cierre', fecha_cierre_real='$fecha_cierre_real', observacion_cierre='$observacion_cierre',usuario_cierre_id=$usuario_id WHERE actividad_id=$actividad_id";
        $result  = $this -> query($update,$Conex,true);
   
        return $actividad_id;	
        
      }

	 }

	 public function selectObservaciones($actividad_id,$Conex){

		$select="SELECT observacion FROM observacion_actividad_fase WHERE actividad_id = $actividad_id"; 
		$result  = $this -> DbFetchAll($select,$Conex,true);

		return $result;
	 }


   
      
}

?>