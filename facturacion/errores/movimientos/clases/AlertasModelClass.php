<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class AlertasModel extends Db{

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
 

     $select  = "SELECT cliente_id, ip, usuario, contrasena, db,

                      UPPER(IF(db LIKE '%siandsi4_%',(REPLACE(db,'siandsi4_','')),
                      
                      (IF(db LIKE '%siandsi2_%',(REPLACE(db,'siandsi2_','')),
                          
                      (REPLACE(db,'siandsi_','')))))) AS empresa, 
                      
                      estado, logo FROM clientes_db WHERE estado = 1 ";
 
     $result  = $this -> DbFetchAll($select,$Conex);
   
    return $result;
 
 }	
 
 public function GetModulos($Conex){
   
   $select = "SELECT descripcion AS value, descripcion AS text FROM actividad WHERE modulo = 1 AND display = 1 AND estado = 1 AND consecutivo != 1";
   
	return $this -> DbFetchAll( $select,$Conex,true);
 }
 
 
 public function Save($usuario_id,$dir_file,$Campos,$Conex){	
                                                            
  $this->Begin($Conex);
  
  $this -> replicarMensajeActualizacion($Conex,$usuario_id,$dir_file);
  
  $this->Commit($Conex);

}
 

  public function replicarMensajeActualizacion($Conex,$usuario_id,$dir_file){
    
    $mensaje               = $this -> requestData('mensaje');
    $empresas              = $this -> requestData('empresas');
    $modulos               = $this -> requestData('modulos');
    $fecha_registro        = date('Y-d-m : H:i:s');
    $fecha_inicio          = $this -> requestData('fecha_inicio');
    $fecha_fin             = $this -> requestData('fecha_fin');
    $archivo               = str_replace('../../../','https://www.siandsi1.co/sistemas_informaticos/',$dir_file);
    $link_video             = $this -> requestData('link_video');

    $insert                = "INSERT INTO alertas_desarrollo(mensaje, empresas, modulos, usuario_id, fecha_registro, fecha_inicio, fecha_fin, archivo,link_video) 
    VALUES 
    ('$mensaje','$empresas','$modulos',$usuario_id,'$fecha_registro','$fecha_inicio','$fecha_fin','$archivo','$link_video')";
    
    $databases     = explode(',',$empresas);

    for ($i=0; $i < count($databases); $i++) { 

     $select     = "SELECT * FROM clientes_db WHERE db = '$databases[$i]'";
     
     $result     = $this -> DbFetchAll($select,$Conex,true);

     $contrasena = $result[0]["contrasena"];
     $usuario    = $result[0]["usuario"];
     $bd         = $result[0]["db"];

     $Conexion = mysqli_connect("localhost", "$usuario", "$contrasena", $bd);

     if(!$Conexion){
       
       $errores   .="<br> Error de conexion. Base de datos : $bd  -  Usuario : $usuario -  Contrasena : $contrasena - ".mysqli_error($Conexion);
      
     }
     
     
     if (mysqli_query($Conexion, $insert)) {
       
       $success.="<br> Ejecutado con exito para base de datos '$bd'";
       
     } else {
         
       $errores   .="<br> Error al ejecutar en base de datos '$bd' - ".mysqli_error($Conexion);
         
     }

     mysqli_close();

   }

   $Conex = mysql_connect(null,"siandsi_applisi","w**i5hM+(1r)");
   
   if(!$Conex){
     $errores .="<br> Error al reconectar con base de datos 'siandsi_application_si' - ".mysqli_error();
   }
   
   if(!mysql_select_db("siandsi_application_si")){
     $errores .="<br> Error al seleccionar base de datos 'siandsi_application_si' -  ".mysqli_error();
   }
   
   $respuesta = "<span style='font-weight: bold; color: red; text-align: center;'>".$errores."</span>"."<span style='font-weight: bold; color: green; text-align: center;'>".$success."</span>";
   
   print $respuesta;

}			 	
   

}


?>