<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class dataBaseModel extends Db{

  private $usuario_id;
  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  public function actualizarLogo($Conex){

    $contrasena = $this -> requestData("contrasena");
    $usuario    = $this -> requestData("usuario");
    $bd         = $this -> requestData("db");

    mysql_close();
    
    $Conexion = mysql_connect(null,"$usuario","$contrasena") or die ("Error de conexion con la base de datos guardada. usuario : $usuario --- pw : $contrasena --- base de datos :  $bd ".mysqli_error());
   
     mysql_select_db("$bd") or die("No se puede Conectar!!");
      
     $select_logo = "SELECT logo FROM ".$bd."."."empresa";

     $result_usu   = mysql_query($select_logo,$Conexion) or die ("Error al seleccionar logo de la base de datos guradada: ".mysqli_error());	 
     $num_rows_usu = mysqli_num_rows($result_usu); 	
   
   if($num_rows_usu > 0) $result_logo[0] = mysqli_fetch_assoc($result_usu);	

     $logo = $result_logo[0]['logo'];

     mysql_close();

     $Conex = mysql_connect(null,"siandsi_siandsi1","oYNazfVrqAl+") or die ("Error : ".mysqli_error());
   
     mysql_select_db("siandsi_sistemas_informaticos") or die("Error al reconectar la base de datos: ".mysqli_error());

     $update = "UPDATE clientes_db SET logo = '$logo' WHERE usuario = '$usuario'";
     
     mysql_query($update,$Conex)or die ("Error : ".mysqli_error());

     mysql_close(); 
    
  }
  		
  public function Save($Campos,$Conex){	

    $this -> DbInsertTable("clientes_db",$Campos,$Conex,true);	

    if(!$this -> GetNumError() > 0) $this -> actualizarLogo($Conex);

  }
	
  public function Update($Campos,$Conex){		
                                         
    $this -> actualizarLogo($Conex);
    
    $this -> DbUpdateTable("clientes_db",$Campos,$Conex,true);	
    
    
  }
	
  public function Delete($Campos,$Conex){
  
  	$this -> DbDeleteTable("clientes_db",$Campos,$Conex,true);
	
  }				 	
   
   public function selectdataBase($Conex){
      
      $cliente_id     = $this -> requestDataForQuery('cliente_id','integer');
      $select         = "SELECT cliente_id, ip, usuario, contrasena,db, estado FROM clientes_db WHERE cliente_id = $cliente_id";	 
      $result         = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
   
      return $result;
      
   }

   public function getQuerydataBaseGrid(){
         
     $Query = "SELECT ip, usuario, IF(estado = 1,'ACTIVO','INACTIVO') AS estado,db FROM clientes_db";
   
     return $Query;
   
   }
   

}


?>