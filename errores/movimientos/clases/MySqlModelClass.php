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
        $select_logo = "SELECT * FROM clientes_db WHERE estado = 1";

        $result_logo = $this->DbFetchAll($select_logo, $Conex);

        return $result_logo;
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

            $Conexion = mysqli_connect("localhost", "$usuario", "$contrasena", $bd);

            if (!$Conexion) {
                $errores .= "<br><br> Error de conexion. Base de datos : $bd  -  Usuario : $usuario -  Contrasena : $contrasena - " . mysqli_error($Conexion);

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
}

?>
