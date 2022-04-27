<?php
require_once "../../../framework/clases/ControlerClass.php";

final class tablaPanelTareas extends Controler
{

    public function __construct()
    {
        parent::__construct(3);
    }

    #Table principal
    public function getDetallesPanel($consul_tipo_tarea)
    {

        require_once "PanelTareasModelClass.php";

        $Model = new PanelTareasModel();

        $Data = $Model->selectActividades($consul_tipo_tarea,$this->getConex());

        if (count($Data) == 0) {

            return '{"data": []}';

        }

        $datosJson = '{
        "data": [';

        $search  = array("\\", "/", "\"", "\n", "\r", "\t", "\x08", "\x0c");
        $replace = array("\\\\", "\\/", "\\\"", "\\n", "\\r", "\\t", "\\f", "\\b");

        for ($i = 0; $i < count($Data); $i++) {

            if ($Data[$i]["estado"] == 'ACTIVO') {

                $button_cierre = "<button type='button' class='btn btn-danger' id='cerrar' data-toggle='modal' onclick='openModalCierre(this)'><i class='fa fa-check-square'></i></button>";

                $estado = "<div class='alert alert-success'>" . $Data[$i]["estado"] . "</div>";

            } else if ($Data[$i]["estado"] == 'INACTIVO') {

                $estado = "<div class='alert alert-warning'>" . $Data[$i]["estado"] . "</div>";
                $button_cierre = '';

            }else if ($Data[$i]["estado"] == 'PENDIENTE POR SOCIALIZAR') {

                $estado = "<div class='alert alert-secondary'>" . $Data[$i]["estado"] . "</div>";
                

            } else {

                $estado = "<div class='alert alert-danger'>" . $Data[$i]["estado"] . "</div>";
                $button_cierre = '';

            }

            if ($Data[$i]["prioridad"] == '1') {

                $prioridad = "<div class='alert alert-danger'>ALTA</div>";

            } else if ($Data[$i]["prioridad"] == '2') {

                $prioridad = "<div class='alert alert-warning'>MEDIA</div>";

            } else {

                $prioridad = "<div class='alert alert-secondary'>BAJA</div>";

            }

            if ($Data[$i]["archivo"] != '') {

                $archivo = "<a class='badge badge-info' href=" . $Data[$i]["archivo"] . " target='_blank'>Ver Adjunto</a>";

            } else {

                $archivo = "";

            }

            $actividad_programada_id = "<a href='TareaClass.php?actividad_programada_id=".$Data[$i]["actividad_programada_id"]."' target='_blank'>".$Data[$i]["actividad_programada_id"]." </a><input type='hidden' id='actividad_id' value=" . $Data[$i]["actividad_programada_id"] . ">";

            $button_observacion = "<button type='button' class='btn btn-info' id='add_observacion' data-target='#exampleModal' data-toggle='modal'><i class='fa fa-commenting'></i></button>";

            $descripcion = "<div style='height: 100px; overflow-y:scroll;'>" .$Data[$i]['descripcion'] . "</div><br><button type='button' class='btn btn-primary' id='ver_observacion' data-toggle='modal' data-target='#exampleModalObservacion'><i class='fa fa-eye'></i></button>";

            $url_sistema = $Data[$i]["url_sistema"]!='' ? "<a href='".$Data[$i]["url_sistema"]."' target='_blank'>Link sistema</a>" : "";

            $fecha_actual = date('Y-m-d');

            if($fecha_actual == $Data[$i]['fecha_final']){

                $clase = "class='alert alert-warning'";
                
            }else if ($fecha_actual > $Data[$i]['fecha_final']){

                $clase = "class='alert alert-danger'";
            }else{

                $clase = "class='alert alert-primary'";
            }

            
            $datosJson .= '[
                "<div '.$clase.'>' . $actividad_programada_id . '</div>",
                "' . $button_observacion . '",
                "' . $button_cierre . '",
                "' . $Data[$i]['tipo_tarea'] . '",
                "' . str_replace($search, $replace, $Data[$i]['cliente']."<br> $url_sistema") . '",
                "' . $prioridad . '",
                "' . str_replace($search, $replace, $Data[$i]['nombre']) . '",   
                "' . str_replace($search, $replace, $Data[$i]['creador']) . '", 
                "' . str_replace($search, $replace, $Data[$i]['responsable']) . '", 
                
                "' . str_replace($search, $replace, $descripcion) . '", 
                "' . $Data[$i]['fecha_inicial'] . '",
                "' . $Data[$i]['fecha_final'] . '",
                "' . $archivo . '"
              ],';

        }

        $datosJson = substr($datosJson, 0, -1);

        $datosJson .= ']

        }';

        return $datosJson;

    }

    public function getDetallesAvances($consul_tipo_tarea)
    {

        require_once "PanelTareasModelClass.php";

        $Model = new PanelTareasModel();

        $Data = $Model->selectAvances($consul_tipo_tarea,$this->getConex());

        if (count($Data) == 0) {

            return '{"data": []}';

        }

        $datosJson = '{
        "data": [';

        for ($i = 0; $i < count($Data); $i++) {

           $responsable = $Data[$i][0]['responsable'];
           $promedio    = $Data[$i][0]['promedio'];
           $barra_progresiva = "<div class='progress'><div class='progress-bar' role='progressbar' style='width:$promedio%;'aria-valuenow='40' aria-valuemin='0' aria-valuemax='100'><b>".round($promedio)." %</b></div></div>";
           
           $numero_tareas    = "<button class='btn btn-primary'>".$Data[$i][0]['numero_tareas']."</button>";
           $numero_tareas_activas    = "<button class='btn btn-success'>".$Data[$i][0]['numero_tareas_activas']."</button>";
           $numero_tareas_cerradas    = "<button class='btn btn-danger'>".$Data[$i][0]['numero_tareas_cerradas']."</button>";

            $datosJson .= '[
                "<b>' . $responsable . '<b>",
                "' . $barra_progresiva . '",
                "' . $numero_tareas . '",
                "' . $numero_tareas_activas . '",
                "' . $numero_tareas_cerradas . '"
              ],';

        }

        $datosJson = substr($datosJson, 0, -1);

        $datosJson .= ']

        }';

        return $datosJson;

    }

    public function getDetallesVencidas($consul_tipo_tarea)
    {

        require_once "PanelTareasModelClass.php";

        $Model = new PanelTareasModel();

        $consul = " AND a.fecha_final < CURRENT_DATE() AND  a.estado = 1";
        
        $Data = $Model -> selectTareas($this -> getConex(),$consul,$consul_tipo_tarea);

        if (count($Data) == 0) {

            return '{"data": []}';

        }

        $datosJson = '{
        "data": [';

        for ($i = 0; $i < count($Data); $i++) {

            if ($Data[$i]["prioridad"] == '1') {

                $prioridad = "<div class='alert alert-danger'>ALTA</div>";

            } else if ($Data[$i]["prioridad"] == '2') {

                $prioridad = "<div class='alert alert-warning'>MEDIA</div>";

            } else {

                $prioridad = "<div class='alert alert-secondary'>BAJA</div>";

            }


            $actividad_programada_id = "<a href='TareaClass.php?actividad_programada_id=".$Data[$i]["codigo"]."' target='_blank'>".$Data[$i]["codigo"]." </a>";

            $datosJson .= '[
                "' . $Data[$i]['tipo_tarea'] . '",
                "' . $Data[$i]['responsable'] . '",
                "' . $prioridad . '",
                "<b>' . $actividad_programada_id . '<b>",
                "' . $Data[$i]['cliente'] . '",
                "' . $Data[$i]['fecha_inicial'] . '",
                "' . $Data[$i]['fecha_final'] . '",
                "<b>'. $Data[$i]['dias_retraso'] . '<b>"
              ],';

        }

        $datosJson = substr($datosJson, 0, -1);

        $datosJson .= ']

        }';

        return $datosJson;

    }

    public function getDetallesFinalizadas($consul_tipo_tarea)
    {

        require_once "PanelTareasModelClass.php";

        $Model = new PanelTareasModel();

        $consul = " AND a.estado = 2";
        
        $Data = $Model -> selectTareas($this -> getConex(),$consul,$consul_tipo_tarea);

        if (count($Data) == 0) {

            return '{"data": []}';

        }

        $datosJson = '{
        "data": [';

        for ($i = 0; $i < count($Data); $i++) {

            if ($Data[$i]["estado"] == 'ACTIVO') {

                $estado = "<div class='alert alert-success'>" . $Data[$i]["estado"] . "</div>";

            } else if ($Data[$i]["estado"] == 'INACTIVO') {

                $estado = "<div class='alert alert-warning'>" . $Data[$i]["estado"] . "</div>";
                

            } else if ($Data[$i]["estado"] == 'PENDIENTE POR SOCIALIZAR') {

                $estado = "<div class='alert alert-secondary'>" . $Data[$i]["estado"] . "</div>";
                

            }else {

                $estado = "<div class='alert alert-danger'>" . $Data[$i]["estado"] . "</div>";

            }


            $actividad_programada_id = "<a href='TareaClass.php?actividad_programada_id=".$Data[$i]["codigo"]."' target='_blank'>".$Data[$i]["codigo"]." </a>";

            $datosJson .= '[
                "' . $Data[$i]['tipo_tarea'] . '",
                "' . $Data[$i]['responsable'] . '",
                "' . $estado . '",
                "<b>' . $actividad_programada_id . '<b>",
                "' . $Data[$i]['cliente'] . '",
                "' . $Data[$i]['fecha_inicial'] . '",
                "' . $Data[$i]['fecha_final'] . '"
              ],';

        }

        $datosJson = substr($datosJson, 0, -1);

        $datosJson .= ']

        }';

        return $datosJson;

    }

    public function getDetallesPendientesSocializar($consul_tipo_tarea)
    {

        require_once "PanelTareasModelClass.php";

        $Model = new PanelTareasModel();

        $consul = " AND a.estado = 3";
        
        $Data = $Model -> selectTareas($this -> getConex(),$consul,$consul_tipo_tarea);

        if (count($Data) == 0) {

            return '{"data": []}';

        }

        $datosJson = '{
        "data": [';

        for ($i = 0; $i < count($Data); $i++) {

            if ($Data[$i]["estado"] == 'ACTIVO') {

                $estado = "<div class='alert alert-success'>" . $Data[$i]["estado"] . "</div>";

            } else if ($Data[$i]["estado"] == 'INACTIVO') {

                $estado = "<div class='alert alert-warning'>" . $Data[$i]["estado"] . "</div>";
                

            } else if ($Data[$i]["estado"] == 'PENDIENTE POR SOCIALIZAR') {

                $estado = "<div class='alert alert-secondary'>" . $Data[$i]["estado"] . "</div>";
                

            } else {

                $estado = "<div class='alert alert-danger'>" . $Data[$i]["estado"] . "</div>";

            }

            $button_cierre = "<button type='button' class='btn btn-success' id='cerrar' data-toggle='modal' onclick='Finalizar(".$Data[$i]["codigo"].")'><i class='fa fa-check-square'></i></button>";

            $actividad_programada_id = "<a href='TareaClass.php?actividad_programada_id=".$Data[$i]["codigo"]."' target='_blank'>".$Data[$i]["codigo"]." </a>";

            $datosJson .= '[
                "' . $Data[$i]['tipo_tarea'] . '",
                "' . $Data[$i]['responsable'] . '",
                "' . $estado . '",
                "<b>' . $actividad_programada_id . '<b>",
                "' . $Data[$i]['cliente'] . '",
                "' . $Data[$i]['fecha_inicial'] . '",
                "' . $Data[$i]['fecha_final'] . '",
                "' . $button_cierre . '"
              ],';

        }

        $datosJson = substr($datosJson, 0, -1);

        $datosJson .= ']

        }';

        return $datosJson;

    }

    public function getDetallesActuales($consul_tipo_tarea)
    {

        require_once "PanelTareasModelClass.php";

        $Model = new PanelTareasModel();

        $consul = " AND a.fecha_final = CURRENT_DATE() AND  a.estado = 1";

        $Data = $Model -> selectTareas($this -> getConex(),$consul,$consul_tipo_tarea);

        if (count($Data) == 0) {

            return '{"data": []}';

        }

        $datosJson = '{
        "data": [';

        for ($i = 0; $i < count($Data); $i++) {

            $actividad_programada_id = "<a href='TareaClass.php?actividad_programada_id=".$Data[$i]["codigo"]."' target='_blank'>".$Data[$i]["codigo"]." </a>";

            $datosJson .= '[
                "' . $Data[$i]['responsable'] . '",
                "<b>' . $actividad_programada_id . '<b>",
                "' . $Data[$i]['cliente'] . '",
                "' . $Data[$i]['fecha_inicial'] . '"
              ],';

        }

        $datosJson = substr($datosJson, 0, -1);

        $datosJson .= ']

        }';

        return $datosJson;

    }

    public function Main()
    {
        $tipo_tarea_id = $_REQUEST['tipo_tarea_id'];
        $usuario_id    = $this->getUsuarioId();
        
        $consul_tipo_tarea = " AND a.tipo_tarea_id = $tipo_tarea_id AND a.responsable_id = (SELECT u.tercero_id FROM usuario u WHERE u.usuario_id = $usuario_id)";

        if($usuario_id == 15 || $usuario_id == 4 || $usuario_id == 2){

            $consul_tipo_tarea = " AND a.tipo_tarea_id = $tipo_tarea_id";

        }

        #Table principal 
        if (isset($_REQUEST['detalles'])) {
            $data = $this->getDetallesPanel($consul_tipo_tarea);
        }

        #Avances 
        if (isset($_REQUEST['detalles_responsables'])) {
            $data = $this->getDetallesAvances($consul_tipo_tarea);
        }

        #Tareas sin entregar 
        if (isset($_REQUEST['tareas_vencidas'])) {

            $data = $this->getDetallesVencidas($consul_tipo_tarea);
        }

        #Tareas Finalizadas 
        if (isset($_REQUEST['tareas_finalizadas'])) {

            $data = $this->getDetallesFinalizadas($consul_tipo_tarea);
        }

        #Tareas pendientes por socializar 
        if (isset($_REQUEST['tareas_pendiente_socializar'])) {

            $data = $this->getDetallesPendientesSocializar($consul_tipo_tarea);
        }

        #Tareas para entregar hoy 
        if (isset($_REQUEST['tareas_actuales'])) {

            $data = $this->getDetallesActuales($consul_tipo_tarea);
        }

        echo $data;
    }

}

new tablaPanelTareas();
