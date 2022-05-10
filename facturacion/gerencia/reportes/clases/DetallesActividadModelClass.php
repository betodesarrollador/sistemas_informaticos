<?php

require_once "../../../framework/clases/DbClass.php";
require_once "../../../framework/clases/PermisosFormClass.php";
require_once "../../../framework/clases/MailClass.php";

final class DetallesActividadModel extends Db
{

    private $Permisos;

    public function getReporte($consulta, $Conex)
    {

        $select = "SELECT * FROM clientes_db WHERE estado = 1";

        $result = $this->DbFetchAll($select, $Conex, true);

        $resultado = "";
		$data1 = array();
		$k  = 0;
		
        for ($i = 0; $i < count($result); $i++) {
			
            $contrasena = $result[$i]["contrasena"];
            $usuario = $result[$i]["usuario"];
			$bd = $result[$i]["db"];
			
			
            $Conexion = mysqli_connect("localhost", "$usuario", "$contrasena", $bd);
			
            if (!$Conexion) {
				
				$errores .= "<br> Error de conexion. Base de datos : $bd  -  Usuario : $usuario -  Contrasena : $contrasena - " . mysqli_error($Conexion);
                $resultado .= '"' . mysqli_error($Conexion) . '"';
			}
			
			$resultConsulta = mysqli_query($Conexion,$consulta) or die("Error ejecutando la consulta".mysqli_error($Conexion)."En la base de datos: ".$bd);
			
			for ($j = 0; $Row = mysqli_fetch_assoc($resultConsulta); $j++) {
				$data[$k] = $Row;
				$k++;
			}
			
			mysqli_close();
		
		}
		
		return $data;
    }

}
