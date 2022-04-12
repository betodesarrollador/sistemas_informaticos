<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class PanelSoporteModel extends Db{

  private $Permisos;  

	public function selectValores($Conex){

		$select="SELECT 
		         (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido, t.razon_social) FROM tercero t, cliente c WHERE t.tercero_id=c.tercero_id AND c.cliente_id=p.cliente_id)AS cliente,
				 p.cliente_id,
				 p.nombre,
				 (SELECT GROUP_CONCAT(DISTINCT f.nombre SEPARATOR ',<br><br> ') FROM fase f, actividad_fase a WHERE f.proyecto_id=p.proyecto_id AND f.fase_id=a.fase_id)AS fase,
				 (SELECT GROUP_CONCAT(DISTINCT a.nombre SEPARATOR ',<br><br> ') FROM actividad_fase a, fase f WHERE a.fase_id = f.fase_id AND f.proyecto_id=p.proyecto_id)AS actividad,
				 ((SELECT count(a.soporte_id) FROM actividad_fase a, fase f WHERE a.estado = 2 AND a.fase_id = f.fase_id AND f.proyecto_id=p.proyecto_id)*100/(SELECT count(a.soporte_id) FROM actividad_fase a, fase f WHERE a.fase_id = f.fase_id AND f.proyecto_id=p.proyecto_id))AS avance,
				  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido, t.razon_social) FROM tercero t, usuario u WHERE t.tercero_id=u.tercero_id AND u.usuario_id=p.usuario_id)AS usuario

		       FROM proyecto p";
		$result  = $this -> DbFetchAll($select,$Conex,true);

		return $result;
	 }

	 public function selectActividades($Conex){

		$select="SELECT a.soporte_id,
				 (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM tercero t, cliente c WHERE t.tercero_id=c.tercero_id AND c.cliente_id=a.cliente_id)AS cliente,
				 (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM tercero t WHERE t.tercero_id=(SELECT tercero_id FROm usuario WHERE usuario_id = a.usuario_id))AS responsable,
		         a.nombre,
		         (CASE a.estado WHEN 1 THEN 'ACTIVO' WHEN 0 THEN 'INACTIVO' ELSE 'CERRADO' END)AS estado,
				 a.descripcion,
				 a.fecha_inicial,
				 a.fecha_final,
				 a.fecha_registro

				 FROM soporte a ORDER BY a.soporte_id DESC";
				 
		$result  = $this -> DbFetchAll($select,$Conex,true);

		return $result;
	 }

	  public function selectAvances($Conex){

		$select="SELECT (SELECT tercero_id FROm usuario WHERE usuario_id = a.usuario_id)AS responsable_id,
		        (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM tercero t WHERE t.tercero_id=(SELECT tercero_id FROm usuario WHERE usuario_id = a.usuario_id))AS responsable
		         FROM soporte a GROUP BY responsable_id ORDER BY responsable_id DESC";
				 
		$result  = $this -> DbFetchAll($select,$Conex,true);

		for($i=0;$i<count($result); $i++){

			$responsable_id = $result[$i]['responsable_id'];

			$select="SELECT 
		         (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM tercero t WHERE t.tercero_id=(SELECT tercero_id FROm usuario WHERE usuario_id = a.usuario_id))AS responsable,
				 ((SELECT COUNT(*) FROM soporte WHERE estado = 2 AND (SELECT tercero_id FROm usuario WHERE usuario_id = a.usuario_id)=$responsable_id)/(COUNT(*))*100)AS promedio,
				 (SELECT COUNT(soporte_id) FROM soporte WHERE (SELECT tercero_id FROm usuario WHERE usuario_id = a.usuario_id)=$responsable_id)AS numero_tareas,
				 (SELECT COUNT(soporte_id) FROM soporte WHERE estado = 1 AND (SELECT tercero_id FROm usuario WHERE usuario_id = a.usuario_id)=$responsable_id)AS numero_tareas_activas,
				 (SELECT COUNT(soporte_id) FROM soporte WHERE estado = 2 AND (SELECT tercero_id FROm usuario WHERE usuario_id = a.usuario_id)=$responsable_id)AS numero_tareas_cerradas
		         FROM soporte a WHERE (SELECT tercero_id FROm usuario WHERE usuario_id = a.usuario_id)=$responsable_id";
				 
			$results  = $this -> DbFetchAll($select,$Conex,true);
			
			$resultados[$i] = $results;
		}
    
		return $resultados;
	 }

	 public function saveObservacion($soporte_id,$observacion,$Conex){
		  
		$observacion_id = $this -> DbgetMaxConsecutive("soporte_observacion","observacion_id",$Conex,true,1);

		$insert="INSERT INTO soporte_observacion (observacion_id,soporte_id,observacion) 
		         VALUES ($observacion_id,$soporte_id,'$observacion')";
		$this -> query($insert,$Conex,true);

		return $observacion_id;

	 }

	 public function saveCierre($soporte_id,$observacion_cierre,$fecha_cierre_real,$fecha_cierre,$usuario_id,$Conex){

      $select = "SELECT estado FROM soporte WHERE soporte_id = $soporte_id";
      $result = $this->DbFetchAll($select,$Conex,true);

      $estado = $result[0]['estado'];

      if($estado == 2){
          return 0;
      }else{

        $update="UPDATE soporte SET estado = 2, usuario_actualizo_id=$usuario_id WHERE soporte_id=$soporte_id";
        $result  = $this -> query($update,$Conex,true);
   
        return $soporte_id;	
        
      }

	 }

	 public function selectObservaciones($soporte_id,$Conex){

		$select="SELECT observacion FROM soporte_observacion WHERE soporte_id = $soporte_id"; 
		$result  = $this -> DbFetchAll($select,$Conex,true);

		return $result;
	 }


   
      
}

?>