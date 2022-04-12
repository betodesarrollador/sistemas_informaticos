<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class MySqlModel extends Db{

  private $usuario_id;
  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  		
  public function getDB($Conex){
 

     $select_logo  = "SELECT * FROM clientes_db WHERE estado = 1";
 
     $result_logo  = $this -> DbFetchAll($select_logo,$Conex);
   
    return $result_logo;
 
 }			 	

  public function ejecutarQuery($Conex,$usuario_id){

     $query         = $_REQUEST['query'];
     $base_de_datos = $_REQUEST['databases'];
     $resultado     = "";
     
     $databases     = explode(',',$base_de_datos);

     for ($i=0; $i < count($databases); $i++) { 

      $select     = "SELECT * FROM clientes_db WHERE db = '$databases[$i]'";
      
      $result     = $this -> DbFetchAll($select,$Conex,true);

      $contrasena = $result[0]["contrasena"];
      $usuario    = $result[0]["usuario"];
      $bd         = $result[0]["db"];

      
      $Conexion = mysqli_connect("localhost", "$usuario", "$contrasena", $bd);

      if(!$Conexion){
        
        $errores   .="<br><br> Error de conexion. Base de datos : $bd  -  Usuario : $usuario -  Contrasena : $contrasena - ".mysqli_error($Conexion);
        
        $resultado .= '"'.mysqli_error($Conexion).'"';
      }
      
      if (mysqli_multi_query($Conexion, $query)) {
        
        $success.="<br><br> Ejecutado con exito para base de datos '$bd'";
        
      } else {
          
        $errores   .="<br><br> Error al ejecutar en base de datos '$bd' - ".mysqli_error($Conexion);  
        
        $resultado .= '"'.mysqli_error($Conexion).'"';
          
      }

      mysqli_close($Conexion);

    }

    $Conex = mysql_connect(null,"siandsi_siandsi1","oYNazfVrqAl+");
    
    if(!$Conex){
      $errores .="<br><br> Error al reconectar con base de datos 'siandsi_sistemas_informaticos' - ".mysqli_error();
    }
    
    if(!mysql_select_db("siandsi_sistemas_informaticos")){
      $errores .="<br><br> Error al seleccionar base de datos 'siandsi_sistemas_informaticos' -  ".mysqli_error();
    }

    $fecha_actual = date('Y-m-d : H:i:s');
    
    $resultado = $resultado == "" ? "'success'" : $resultado;
    
    $query='"'.$query.'"';

    $insert = "INSERT INTO log_registros_sql(query,db,usuario_id,fecha,resultado) VALUES ($query,'$base_de_datos',$usuario_id,'$fecha_actual',$resultado)";
    
    if(!mysql_query($insert,$Conex)){
      $errores .="<br><br> Error al insertar registro en la tabla 'log_registros_sql'' - ".mysqli_error().'<br><br>'.$insert;
    }
    
    $respuesta = "<span style='font-weight: bold; color: red; text-align: center;'>".$errores."</span>"."<span style='font-weight: bold; color: green; text-align: center;'>".$success."</span>";
    
    return $respuesta;
 
 }			 	
   

}


?>