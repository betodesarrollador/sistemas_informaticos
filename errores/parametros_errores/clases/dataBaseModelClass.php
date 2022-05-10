<?php

require_once "../../../framework/clases/DbClass.php";

require_once "../../../framework/clases/PermisosFormClass.php";

final class dataBaseModel extends Db
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

    public function actualizarLogo($Conex)
    {
        $contrasena = $this->requestData("contrasena");

        $usuario = $this->requestData("usuario");

        $bd = $this->requestData("db");

        mysqli_close($Conexion['conex']);

        $Conexion = mysqli_connect("localhost", "$usuario", "$contrasena", "$bd");

        $select_logo = "SELECT logo FROM " . $bd . "." . "empresa";

        ($result_usu = mysqli_query($Conexion, $select_logo)) or die("Error al seleccionar logo de la base de datos guradada: " . mysqli_error($Conexion));

        $num_rows_usu = mysqli_num_rows($result_usu);

        if ($num_rows_usu > 0) {
            $result_logo[0] = mysqli_fetch_assoc($result_usu);
        }

        $logo = $result_logo[0]['logo'];

        mysqli_close($Conexion);

        $Conex = mysqli_connect("localhost", "siandsi_siandsi1", "oYNazfVrqAl+", "siandsi_sistemas_informaticos");

        $update = "UPDATE clientes_db SET logo = '$logo' WHERE usuario = '$usuario'";

        mysqli_query($Conex, $update) or die("Error : " . mysqli_error($Conex));

        mysqli_close($Conexion);
    }

    public function Save($Campos, $Conex)
    {
        $this->DbInsertTable("clientes_db", $Campos, $Conex, true);

        if (!$this->GetNumError() > 0) {
            $this->actualizarLogo($Conex);
        }
    }

    public function Update($Campos, $Conex)
    {
        $this->actualizarLogo($Conex);

        $this->DbUpdateTable("clientes_db", $Campos, $Conex, true);
    }

    public function Delete($Campos, $Conex)
    {
        $this->DbDeleteTable("clientes_db", $Campos, $Conex, true);
    }

    public function selectdataBase($Conex)
    {
        $cliente_id = $this->requestDataForQuery('cliente_id', 'integer');

        $select = "SELECT cliente_id, ip, usuario, contrasena,db, estado FROM clientes_db WHERE cliente_id = $cliente_id";

        $result = $this->DbFetchAll($select, $Conex, $ErrDb = false);

        return $result;
    }

    public function getQuerydataBaseGrid()
    {
        $Query = "SELECT ip, usuario, IF(estado = 1,'ACTIVO','INACTIVO') AS estado,db FROM clientes_db";

        return $Query;
    }
}

?>
