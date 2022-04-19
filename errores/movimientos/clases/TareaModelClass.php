<?php



require_once "../../../framework/clases/DbClass.php";

require_once "../../../framework/clases/PermisosFormClass.php";



final class TareaModel extends Db

{



    private $usuario_id;

    private $Permisos;



    public function SetUsuarioId($usuario_id, $oficina_id)

    {

        $this->Permisos = new PermisosForm();

        $this->Permisos->SetUsuarioId($usuario_id, $oficina_id);

    }



    public function getPermiso($TareaId, $Permiso, $Conex)

    {

        return $this->Permisos->getPermiso($TareaId, $Permiso, $Conex);

    }



    public function GetCliente($Conex)

    {



        $select = "SELECT CONCAT_WS( ' ',

              t.razon_social,

              t.primer_nombre,

              t.segundo_nombre,

              t.primer_apellido,

              t.segundo_apellido ) AS text,

              c.cliente_id AS value

              FROM tercero t

              INNER JOIN cliente c ON c.tercero_id = t.tercero_id

              WHERE c.estado = 'D'";

        $result = $this->DbFetchAll($select, $Conex, true);



        return $result;



    }



    public function getCorreosCliente($Conex)

    {



        $cliente_id = $_REQUEST['cliente_id'];



        $select = "SELECT IFNULL(c.email_cliente,t.email) AS email

              FROM tercero t

              INNER JOIN cliente c ON c.tercero_id = t.tercero_id

              WHERE c.cliente_id IN ($cliente_id)";



        $result = $this->DbFetchAll($select, $Conex, true);



        return $result;



    }



    public function getClientes($actividad_programada_id, $Conex)

    {

        $select = "SELECT ac.cliente_id,

              CONCAT_WS( ' ',

              t.razon_social,

              t.primer_nombre,

              t.segundo_nombre,

              t.primer_apellido,

              t.segundo_apellido ) AS cliente

              FROM actividad_programada a

              INNER JOIN actividad_programada_cliente ac ON ac.actividad_programada_id = a.actividad_programada_id

              INNER JOIN cliente c ON c.cliente_id = ac.cliente_id

              INNER JOIN tercero t ON t.tercero_id = c.tercero_id

              WHERE a.actividad_programada_id = $actividad_programada_id";

        $result = $this->DbFetchAll($select, $Conex, true);

        return $result;

    }



    public function GetTipo($Conex)

    {  
 


        $select = "SELECT tipo_tarea_id AS value, nombre AS text FROM tipo_tarea";

        $result = $this->DbFetchAll($select, $Conex, true);



        return $result;



    }



    public function setAdjunto($actividad_programada_id, $dir_file, $Conex)

    {

        $update = "UPDATE actividad_programada SET archivo='$dir_file' WHERE actividad_programada_id= $actividad_programada_id";

        $result = $this->query($update, $Conex, true);

        return $result;



    }



    public function Save($Campos, $UsuarioId, $Conex)

    {



        $clientes = $_REQUEST['cliente_id'];

        $this->assignValRequest('all_clientes', $_REQUEST['all_clientes']);

        $this->assignValRequest('usuario_id', $UsuarioId);

        $this->assignValRequest('usuario_cierre_id', $UsuarioId);

        $this->assignValRequest('fecha_registro', date('Y-m-d g-i-s'));



        $this->Begin($Conex);



        $this->DbInsertTable("actividad_programada", $Campos, $Conex, true, false);

        $actividad_programada_id = $this->DbgetMaxConsecutive("actividad_programada", "actividad_programada_id", $Conex, true, 0);



        foreach ($clientes as $cliente) {

            $insert = "INSERT INTO actividad_programada_cliente (actividad_programada_id, cliente_id)

                VALUES ($actividad_programada_id, $cliente)";

            $this->query($insert, $Conex, true);

        }



        $this->Commit($Conex);



        $tipo_tarea_id = $_REQUEST['tipo_tarea_id'];

        $responsable_id = $_REQUEST['responsable_id'];



        switch ($tipo_tarea_id) {

            case '1': //Desarrollo

                $tercero_id = 209;

                break;

            case '2': //Soporte

                $tercero_id = 91;

                break;

            case '3': //Administrativa

                $tercero_id = 5;

                break;

            case '4': //Marketing

                $tercero_id = 57;

                break;



            default:

                $tercero_id = 209;

                break;

        }



        /*

        2: Soporte

        4: Ernesto

        91: Oscar

        5: Marcela

        10: Jonathan

        57: Juan

        209: Johan

         */



        $select = "SELECT email, $actividad_programada_id AS codigo FROM tercero WHERE tercero_id IN ($tercero_id,$responsable_id,4)";



        $result = $this->DbFetchAll($select, $Conex, true);



        return $result;



    }



    public function Update($actividad_programada_id, $Campos, $UsuarioId, $Conex)

    {



        switch ($_REQUEST['tipo_tarea_id']) {

            case '1': //Desarrollo

                $tercero_id = 209;

                break;

            case '2': //Soporte

                $tercero_id = 91;

                break;

            case '3': //Administrativa

                $tercero_id = 5;

                break;

            case '4': //Marketing

                $tercero_id = 57;

                break;



            default:

                $tercero_id = 209;

                break;

        }



        $select = "SELECT *,(SELECT email FROM tercero WHERE tercero_id = $tercero_id) AS email_lider FROM actividad_programada WHERE actividad_programada_id = $actividad_programada_id";



        $resul = $this->DbFetchAll($select, $Conex, true);



        $clientes = $_REQUEST['cliente_id'];

        $all_clientes = $_REQUEST['all_clientes'];

        if ($all_clientes != 'SI') {

            $this->assignValRequest('all_clientes', '');

        }

        $this->assignValRequest('usuario_actualiza_id', $UsuarioId);

        $this->assignValRequest('fecha_actualiza', "'" . date('Y-m-d H:i:s') . "'");

        $usuario_id = $resul[0]['usuario_id'];

        $fecha_registro = $resul[0]['fecha_registro'];

        $this->assignValRequest('usuario_id', $usuario_id);

        $this->assignValRequest('fecha_registro', "'" . $fecha_registro . "'");



        $this->Begin($Conex);



        $this->DbUpdateTable("actividad_programada", $Campos, $Conex, true, false);



        $delete = "DELETE FROM actividad_programada_cliente WHERE actividad_programada_id = $actividad_programada_id";

        $this->query($delete, $Conex);



        foreach ($clientes as $cliente) {

            $insert = "INSERT INTO actividad_programada_cliente (actividad_programada_id, cliente_id)

                VALUES ($actividad_programada_id, $cliente)";

            $this->query($insert, $Conex, true);

        }



        $this->Commit($Conex);



        return $resul;



    }



    public function Delete($Campos, $Conex)

    {



        $actividad_programada_id = $_REQUEST['actividad_programada_id'];

        $this->Begin($Conex);

        $delete = "DELETE FROM actividad_programada_cliente WHERE actividad_programada_id = $actividad_programada_id";

        $this->query($delete, $Conex);

        $this->DbDeleteTable("actividad_programada", $Campos, $Conex, true, false);

        $this->Commit($Conex);



    }



    public function SaveCierre($actividad_programada_id, $fecha_cierre, $fecha_cierre_real, $observacion_cierre, $usuario_cierre_id, $Conex)

    {

        $update = "UPDATE actividad_programada SET estado = 2, fecha_cierre='$fecha_cierre', fecha_cierre_real='$fecha_cierre_real', observacion_cierre='$observacion_cierre',usuario_cierre_id=$usuario_cierre_id WHERE actividad_programada_id=$actividad_programada_id";

        $result = $this->query($update, $Conex, true);



        return $result;

    }



    public function save_envio_correo_cliente($correo, $Conex)

    {



        $actividad_programada_id = $_REQUEST['actividad_programada_id'];

        $acta_id = $_REQUEST['acta_id'];

        $tipo = $_REQUEST['tipo'];



        $insert = "INSERT INTO envio_correo_cliente(actividad_programada_id, acta_id, correo,tipo) VALUES ($actividad_programada_id, $acta_id, '$correo','$tipo')";



        $this->query($insert, $Conex, true);



    }



    public function selectTarea($Conex)

    {



        $actividad_programada_id = $this->requestDataForQuery('actividad_programada_id', 'integer');



        $select = "SELECT m.actividad_programada_id,

                                m.nombre,

                                m.fecha_inicial,

                                m.fecha_final,

                                m.fecha_inicial_real,

                                m.fecha_final_real,

                                m.fecha_cierre,

                                m.prioridad,

                                m.tipo_tarea_id,

                                m.descripcion,

                                m.archivo,

                                m.acta_id,

                                (SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t WHERE t.tercero_id=m.responsable_id)AS responsable,

                                m.responsable_id,

                                (SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t WHERE t.tercero_id=m.creador_id)AS creador,

                                m.creador_id,

                                m.estado,

                                m.all_clientes,

                                m.observacion_cierre

                          FROM actividad_programada m WHERE m.actividad_programada_id = $actividad_programada_id";



        $result = $this->DbFetchAll($select, $Conex, $ErrDb = false);



        return $result;



    }



    public function getQueryTareaGrid()

    {



        $Query = "SELECT

                    CONCAT_WS('','<a href=\"TareaClass.php?actividad_programada_id=',m.actividad_programada_id,'\">',m.actividad_programada_id,'</a>') AS actividad_programada_id,

                      t.nombre AS tipo_tarea,

                      m.nombre,

                      IF(m.all_clientes = 'SI', 'TODOS', (SELECT GROUP_CONCAT(

                      CONCAT_WS( ' ',

                      t.razon_social,

                      t.primer_nombre,

                      t.segundo_nombre,

                      t.primer_apellido,

                      t.segundo_apellido ) SEPARATOR ',<br>')

                      FROM actividad_programada_cliente ac

                      INNER JOIN cliente c ON c.cliente_id = ac.cliente_id

                      INNER JOIN tercero t ON t.tercero_id = c.tercero_id

                      WHERE ac.actividad_programada_id = m.actividad_programada_id)) as cliente,

                      m.fecha_inicial,

                      m.fecha_final,

                      m.fecha_inicial_real,

                      m.fecha_final_real,

                      m.fecha_cierre,

                      (CASE m.estado WHEN 0 THEN 'INACTIVO' WHEN 1 THEN 'ACTIVO' ELSE 'CERRADO' END)AS estado



              FROM actividad_programada m, tipo_tarea t WHERE t.tipo_tarea_id = m.tipo_tarea_id ORDER BY m.actividad_programada_id DESC";



        return $Query;



    }



}

