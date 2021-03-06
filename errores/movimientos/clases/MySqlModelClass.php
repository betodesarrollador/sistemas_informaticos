<?php

require_once "../../../framework/clases/DbClass.php";

require_once "../../../framework/clases/PermisosFormClass.php";

final class MySqlModel extends Db
{
    private $usuario_id;

    private $Permisos;

    public function SetUsuarioId($usuario_id, $oficina_id)
    {
        $this->Permisos = new PermisosForm();

        $this->Permisos->SetUsuarioId($usuario_id, $oficina_id);
    }

    public function getPermiso($ActividadId, $Permiso, $Conex)
    {
        return $this->Permisos->getPermiso($ActividadId, $Permiso, $Conex);
    }

    public function getDB($Conex)
    {
        $select = "SELECT * FROM clientes_db WHERE estado = 1 AND db != 'siandsi_sistemas_informaticos'";

        $result = $this->DbFetchAll($select, $Conex);

        for ($i=0; $i < count($result); $i++) { 
            $contrasena = $result[$i]["contrasena"];

            $usuario = $result[$i]["usuario"];

            $bd = $result[$i]["db"];

            switch ($bd) {

                case 'siandsi5_talpa':
                    $Conexion = mysqli_connect("162.214.79.143", "$usuario", "", $bd);
                    break;

                case 'siandsi3_vercourrier':
                    $Conexion = mysqli_connect("162.214.78.255", "$usuario", "", $bd);
                    break;

                case 'siandsi3_roa':
                    $Conexion = mysqli_connect("162.214.78.255", "$usuario", "$contrasena", $bd);
                    break;

                case 'wwsyst_transNorteN':
                    $Conexion = mysqli_connect("162.214.164.7", "$usuario", "$contrasena", $bd);
                    break;
                
                default:
                    $Conexion = mysqli_connect("localhost", "$usuario", "$contrasena", $bd);
                    break;
            }
            

            if (!$Conexion || is_null($Conexion)) {
                $errores .= "<br><br> Error de conexion. Base de datos : $bd  -  Usuario : $usuario -  Contrasena : $contrasena  " . mysqli_error($Conexion);

                $resultado .= '"' . mysqli_error($Conexion) . '"';
            }

            // Para verificar errores de conexion
            // if(!is_null(mysqli_connect_error())) {
            //     $errors[$i][$bd] = mysqli_connect_error();
            //     $errors[$i]["pass"] = $contrasena;
            // }

            $sql = "SELECT estado FROM $bd.empresa";
     
            $result_estado = mysqli_query($Conexion, $sql);

            $data = mysqli_fetch_assoc($result_estado);

            $estado = $data['estado'];

            $result[$i]["estado_empresa"] = $estado;
        }

        return $result;
    }

    public function ejecutarQuery($Conex, $usuario_id)
    {
        $query = trim($_REQUEST['query']);

        $base_de_datos = $_REQUEST['databases'];

        $resultado = "";

        $databases = explode(',', $base_de_datos);

        for ($i = 0; $i < count($databases); $i++) {
            $select = "SELECT * FROM clientes_db WHERE db = '$databases[$i]'";

            $result = $this->DbFetchAll($select, $Conex, true);

            $contrasena = $result[0]["contrasena"];

            $usuario = $result[0]["usuario"];

            $bd = $result[0]["db"];

            
            switch ($bd) {

                case 'siandsi5_talpa':
                    $Conexion = mysqli_connect("162.214.79.143", "$usuario", "", $bd);
                    break;

                case 'siandsi3_vercourrier':
                    $Conexion = mysqli_connect("162.214.78.255", "$usuario", "", $bd);
                    break;

                case 'siandsi3_roa':
                    $Conexion = mysqli_connect("162.214.78.255", "$usuario", "$contrasena", $bd);
                    break;

                case 'wwsyst_transNorteN':
                    $Conexion = mysqli_connect("162.214.164.7", "$usuario", "$contrasena", $bd);
                    break;
                
                default:
                    $Conexion = mysqli_connect("localhost", "$usuario", "$contrasena", $bd);
                    break;
            }
            

            if (!$Conexion) {
                $errores .= "<br><br> Error de conexion. Base de datos : $bd  -  Usuario : $usuario -  Contrasena : $contrasena  " . mysqli_error($Conexion);

                $resultado .= '"' . mysqli_error($Conexion) . '"';
            }


            if (mysqli_multi_query($Conexion, $query)) {
                $success .= "<br><br> Ejecutado con exito para base de datos '$bd'";
            
            } else {
                $errores .= "<br><br> Error al ejecutar en base de datos '$bd' - " . mysqli_error($Conexion);

                $resultado .= '"' . mysqli_error($Conexion) . '"';
            
            }


            mysqli_close($Conexion);
        }

        $Conex = mysqli_connect("localhost", "siandsi_siandsi1", "oYNazfVrqAl+", "siandsi_sistemas_informaticos");

        if (!$Conex) {
            $errores .= "<br><br> Error al reconectar con base de datos 'siandsi_sistemas_informaticos' - " . mysqli_error($Conex);
        }

        $resultado = $resultado == "" ? "'success'" : $resultado;

        $query = '"' . $query . '"';

        $insert = "INSERT INTO log_registros_sql(query,db,usuario_id,fecha,resultado) VALUES ($query,'$base_de_datos',$usuario_id,NOW(),$resultado)";

        if (!mysqli_query($Conex, $insert)) {
            $errores .= "<br><br> Error al insertar registro en la tabla 'log_registros_sql'' - " . mysqli_error($Conex) . '<br><br>' . $insert;
        }

        $respuesta = "<span style='font-weight: bold; color: red; text-align: center;'>" . $errores . "</span>" . "<span style='font-weight: bold; color: green; text-align: center;'>" . $success . "</span>";

        return $respuesta;
    }

    public function manejoEmpresa($Conex, $cliente_id, $estado_empresa) {
        $cambio_estado = $estado_empresa == 'A' ? 'I' : 'A';
        $msj = $estado_empresa == 'A' ? 'Se ha Suspendido la empresa exitosamente !' : 'Se ha Habilitado la empresa exitosamente !';
        $msjError = $estado_empresa == 'A' ? 'Ha habido un error al suspender la empresa: ' : 'Ha habido un error al habilitar la empresa: ';

        $data = $this->getDB($Conex);        

        for ($i=0; $i < count($data); $i++) { 
            if($data[$i]["cliente_id"] == $cliente_id) {
                $data_empresa = $data[$i];
                break;
            }
        }

        $usuario_empresa = $data_empresa['usuario'];
        $contra_empresa = $data_empresa['contrasena'];
        $db_empresa = $data_empresa['db'];

        switch ($db_empresa) {

            case 'siandsi5_talpa':
                $Conexion = mysqli_connect("162.214.79.143", "$usuario_empresa", "", $db_empresa);
                break;

            case 'siandsi3_vercourrier':
                $Conexion = mysqli_connect("162.214.78.255", "$usuario_empresa", "", $db_empresa);
                break;

            case 'siandsi3_roa':
                $Conexion = mysqli_connect("162.214.78.255", "$usuario_empresa", "$contra_empresa", $db_empresa);
                break;

            case 'wwsyst_transNorteN':
                $Conexion = mysqli_connect("162.214.164.7", "$usuario_empresa", "$contra_empresa", $db_empresa);
                break;
            
            default:
                $Conexion = mysqli_connect("localhost", "$usuario_empresa", "$contra_empresa", $db_empresa);
                break;
        }

        if (!$Conexion) {
            exit("Error al conectar con la base de datos " . $data_empresa["db"] . ": " . mysqli_error($Conexion));
        }

        $sql = "UPDATE empresa SET estado = '$cambio_estado'";

        if(mysqli_query($Conexion,$sql)) {
            mysqli_close($Conexion);
            return $msj;
        } else {
            mysqli_close($Conexion);
            return $msjError . mysqli_error($Conexion);            
        }
    }
}

?>
