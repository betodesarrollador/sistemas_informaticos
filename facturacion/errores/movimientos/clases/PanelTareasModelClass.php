<?php

require_once "../../../framework/clases/DbClass.php";

require_once "../../../framework/clases/PermisosFormClass.php";



final class PanelTareasModel extends Db

{



    private $Permisos;



    public function selectTipos($Conex)

    {



        $select = "SELECT * FROM tipo_tarea WHERE estado = 'A'";



        $result = $this->DbFetchAll($select, $Conex, true);



        return $result;



    }





	#Tabla principal de tareas

    public function selectActividades($consul_tipo_tarea, $Conex)

    {



		$count_tareas = "(SELECT COUNT(*) FROM actividad_programada ca WHERE ca.responsable_id = a.responsable_id AND ca.tipo_tarea_id = t.tipo_tarea_id $consul_tipo_tarea AND ca.estado = 1)";



		$reponsable = "(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social,' [ ',$count_tareas,' ]') FROM tercero t WHERE t.tercero_id=a.responsable_id)";



		$all_clientes = "(SELECT COUNT(*) FROM actividad_programada_cliente ac WHERE ac.actividad_programada_id = a.actividad_programada_id)";



        $select = "SELECT a.actividad_programada_id,

				 IF(a.all_clientes = 'SI', 'TODOS',

				 IF($all_clientes>1,'VARIOS',(SELECT GROUP_CONCAT(

				CONCAT_WS( ' ', 

				t.razon_social, 

				t.primer_nombre, 

				t.segundo_nombre, 

				t.primer_apellido, 

				t.segundo_apellido ) SEPARATOR ' - ')

				FROM actividad_programada_cliente ac 

				INNER JOIN cliente c ON c.cliente_id = ac.cliente_id

				INNER JOIN tercero t ON t.tercero_id = c.tercero_id

				WHERE ac.actividad_programada_id = a.actividad_programada_id)))

				AS cliente,



				IF($reponsable IS NULL, 'POR ASIGNAR / EN ESPERA',$reponsable)AS responsable,

				 (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM tercero t WHERE t.tercero_id=a.creador_id)AS creador,

		         a.nombre,

		         (CASE a.estado WHEN 1 THEN 'ACTIVO' WHEN 0 THEN 'INACTIVO' WHEN 3 THEN 'PENDIENTE POR SOCIALIZAR' ELSE 'CERRADO' END) AS estado,

				 a.descripcion,

				 a.fecha_inicial,

				 a.fecha_final,

				 a.fecha_inicial_real,

				 a.fecha_final_real,

				 a.fecha_cierre_real,

				 a.cod_commit,

				 t.nombre AS tipo_tarea,

				 a.archivo,

				 a.prioridad,

				 a.justificacion_git,



				 IF($all_clientes > 1, '', (SELECT c.url_sistema FROM actividad_programada_cliente ac, cliente c WHERE ac.cliente_id = c.cliente_id AND ac.actividad_programada_id = a.actividad_programada_id)) AS url_sistema,



				 datediff(curdate(),a.fecha_final) AS dias_retraso



				 FROM actividad_programada a,tipo_tarea t

				 WHERE a.tipo_tarea_id = t.tipo_tarea_id $consul_tipo_tarea AND a.estado = 1 ORDER BY a.responsable_id,estado,prioridad ";



        $result = $this->DbFetchAll($select, $Conex, true);



        return $result;

    }



	#Tabla tareas de sin entregar / Para entregar hoy

    public function selectTareas($Conex, $consult, $consul_tipo_tarea)

    {

		$reponsable = "(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM tercero t WHERE t.tercero_id=a.responsable_id)";



        $select = "SELECT a.actividad_programada_id AS codigo,

				IF(a.all_clientes = 'SI', 'TODOS', (SELECT GROUP_CONCAT(

				CONCAT_WS( ' ', 

				t.razon_social, 

				t.primer_nombre, 

				t.segundo_nombre, 

				t.primer_apellido, 

				t.segundo_apellido ) SEPARATOR ',<br>')

				FROM actividad_programada_cliente ac 

				INNER JOIN cliente c ON c.cliente_id = ac.cliente_id

				INNER JOIN tercero t ON t.tercero_id = c.tercero_id

				WHERE ac.actividad_programada_id = a.actividad_programada_id)) as cliente,

				IF($reponsable IS NULL, 'POR ASIGNAR / EN ESPERA',$reponsable)AS responsable,

				 (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM tercero t WHERE t.tercero_id=a.creador_id)AS creador,

		         a.nombre,

				 a.descripcion,

				 a.fecha_inicial,

				 a.fecha_final,

				 a.fecha_inicial_real,

				 a.fecha_final_real,

				 a.prioridad,

				 t.nombre AS tipo_tarea,

				 (CASE

					WHEN  a.prioridad='1' THEN 'PRIORIDAD'

					WHEN  a.prioridad='2' THEN 'MEDIA'

					ELSE 'BAJA'

					END) AS nombre_prioridad,



				(CASE a.estado WHEN 1 THEN 'ACTIVO' WHEN 0 THEN 'INACTIVO' WHEN 3 THEN 'PENDIENTE POR SOCIALIZAR' ELSE 'CERRADO' END) AS estado,

				 datediff(curdate(),a.fecha_final) AS dias_retraso,

				 a.fecha_cierre_real



				 FROM actividad_programada a,tipo_tarea t WHERE a.tipo_tarea_id = t.tipo_tarea_id $consult $consul_tipo_tarea";



        $result = $this->DbFetchAll($select, $Conex, true);



        return $result;

    }



    public function selectAvances($consul_tipo_tarea, $Conex)

    {



		$reponsable = "(CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social))";



        $select = "SELECT a.responsable_id,

		         IF($reponsable IS NULL, 'POR ASIGNAR / EN ESPERA',$reponsable)AS responsable,

				(SELECT COUNT(actividad_programada_id) FROM actividad_programada WHERE estado = 1 AND responsable_id=a.responsable_id)AS numero_tareas_activas

		         FROM actividad_programada a, tercero t WHERE t.tercero_id=a.responsable_id AND t.estado = 'D' $consul_tipo_tarea GROUP BY responsable_id ORDER BY numero_tareas_activas DESC";



        $result = $this->DbFetchAll($select, $Conex, true);



        for ($i = 0; $i < count($result); $i++) {



            $responsable_id = $result[$i]['responsable_id'];



			$reponsable = " (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM tercero t WHERE t.tercero_id=a.responsable_id AND t.estado = 'D')";



            $select = "SELECT

		         IF($reponsable IS NULL, 'POR ASIGNAR / EN ESPERA',$reponsable)AS responsable,

				 ((SELECT COUNT(*) FROM actividad_programada WHERE estado = 2 AND responsable_id=$responsable_id)/(COUNT(*))*100)AS promedio,

				 (SELECT COUNT(actividad_programada_id) FROM actividad_programada WHERE responsable_id=$responsable_id)AS numero_tareas,

				 (SELECT COUNT(actividad_programada_id) FROM actividad_programada WHERE estado = 1 AND responsable_id=$responsable_id)AS numero_tareas_activas,

				 (SELECT COUNT(actividad_programada_id) FROM actividad_programada WHERE estado = 2 AND responsable_id=$responsable_id)AS numero_tareas_cerradas

		         FROM actividad_programada a WHERE a.responsable_id=$responsable_id $consul_tipo_tarea";



            $results = $this->DbFetchAll($select, $Conex, true);



            $resultados[$i] = $results;

        }



        return $resultados;

    }



    public function saveObservacion($actividad_id, $observacion, $Conex)

    {



        $observacion_id = $this->DbgetMaxConsecutive("actividad_programada_observacion", "observacion_id", $Conex, true, 1);



        $insert = "INSERT INTO actividad_programada_observacion (observacion_id,actividad_programada_id,observacion)

		         VALUES ($observacion_id,$actividad_id,'$observacion')";

        $this->query($insert, $Conex, true);



        return $observacion_id;



    }



    public function saveCierre($usuario_id, $Conex)

    {



        $actividad_id = $_REQUEST['actividad_id'];

        $observacion_cierre = $_REQUEST['observacion_cierre'];

        $fecha_cierre_real = $_REQUEST['fecha_cierre_real'];

        $cod_commit = $_REQUEST['commit'];

        $justificacion_git = $_REQUEST['justificacion_git'];

        $fecha_cierre = date("Y-m-d H:i:s");



        $update = "UPDATE actividad_programada SET estado = 2, fecha_cierre='$fecha_cierre', fecha_cierre_real='$fecha_cierre_real', observacion_cierre='$observacion_cierre',usuario_cierre_id=$usuario_id,justificacion_git='$justificacion_git',cod_commit='$cod_commit' WHERE actividad_programada_id=$actividad_id";

        $result = $this->query($update, $Conex, true);

       return $this->getCorreos($Conex,$actividad_id);



    }



	public function getCorreos($Conex,$actividad_id){



		$tipo_tarea_id = "(SELECT tipo_tarea_id FROM actividad_programada WHERE actividad_programada_id = $actividad_id)";

        $tercero_correo = "

		(CASE

			WHEN   $tipo_tarea_id='1' THEN '209'

			WHEN   $tipo_tarea_id='2' THEN '91'

			WHEN   $tipo_tarea_id='3' THEN '5'

			WHEN   $tipo_tarea_id='4' THEN '57'

			ELSE '209'

			END)";



		$reponsable = "(CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social))";



        $select = "	SELECT t.email,a.actividad_programada_id AS codigo,

		 IF($reponsable IS NULL, 'POR ASIGNAR / EN ESPERA',$reponsable)AS responsable,

		a.nombre,

		a.descripcion,

		a.fecha_inicial,

		a.fecha_final,

		ti.nombre AS tipo_tarea,

		IF(a.all_clientes = 'SI', 'TODOS', (SELECT GROUP_CONCAT(

		CONCAT_WS( ' ', 

		t.razon_social, 

		t.primer_nombre, 

		t.segundo_nombre, 

		t.primer_apellido, 

		t.segundo_apellido ) SEPARATOR ',<br>')

		FROM actividad_programada_cliente ac 

		INNER JOIN cliente c ON c.cliente_id = ac.cliente_id

		INNER JOIN tercero t ON t.tercero_id = c.tercero_id

		WHERE ac.actividad_programada_id = a.actividad_programada_id)) as cliente,

		CURRENT_DATE() AS fecha_cierre_real

		FROM actividad_programada a, tercero t, tipo_tarea ti WHERE t.tercero_id=a.responsable_id AND a.actividad_programada_id = $actividad_id AND a.tipo_tarea_id = ti.tipo_tarea_id



		UNION



		SELECT email,

		'',

		'',

		'',

		'',

		'',

		'',

		'',

		'',

		''

		FROM tercero WHERE tercero_id IN ($tercero_correo,4)";



        /*

        2: Soporte

        4: Ernesto

        5: Marcela

        57: Juan

        91: Oscar

        10: Jonathan

        209: Johan

         */



        $result = $this->DbFetchAll($select, $Conex, true);



        return $result;



	}



    public function pendienteSocializar($usuario_id, $Conex)

    {



        $actividad_id = $_REQUEST['actividad_id'];

        $observacion_cierre = $_REQUEST['observacion_cierre'];

        $observacion_cierre = addslashes($observacion_cierre);

        $fecha_cierre_real = $_REQUEST['fecha_cierre_real'];

        $cod_commit = $_REQUEST['commit'];

        $justificacion_git = $_REQUEST['justificacion_git'];

        $fecha_cierre = date("Y-m-d H:i:s");



        $update = "UPDATE actividad_programada SET estado = 3, fecha_cierre='$fecha_cierre', fecha_cierre_real='$fecha_cierre_real', observacion_cierre='$observacion_cierre',usuario_cierre_id=$usuario_id,justificacion_git='$justificacion_git',cod_commit='$cod_commit' WHERE actividad_programada_id=$actividad_id";

        $result = $this->query($update, $Conex, true);



    }



    public function finalizar($Conex)

    {



        $actividad_id = $_REQUEST['actividad_id'];

       

        $update = "UPDATE actividad_programada SET estado = 2 WHERE actividad_programada_id = $actividad_id";



        $result = $this->query($update, $Conex, true);



		return $this->getCorreos($Conex,$actividad_id);



    }



    public function selectObservaciones($actividad_id, $Conex)

    {



        $select = "SELECT observacion FROM actividad_programada_observacion WHERE actividad_programada_id = $actividad_id";

        $result = $this->DbFetchAll($select, $Conex, true);



        return $result;

    }



}

