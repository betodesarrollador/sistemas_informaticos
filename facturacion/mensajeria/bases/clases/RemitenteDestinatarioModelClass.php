<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class RemitenteDestinatarioModel extends Db{

  private $usuario_id;
  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  		
  public function Save($Campos,$Conex){	
    $this -> DbInsertTable("remitente_destinatario",$Campos,$Conex,true,false);	
  }
	
  public function Update($Campos,$Conex){		
    $this -> DbUpdateTable("remitente_destinatario",$Campos,$Conex,true,false);	
  }
	
  public function Delete($Campos,$Conex){
  
  	$this -> DbDeleteTable("remitente_destinatario",$Campos,$Conex,true,false);
	
  }	
			 	
  public function GetTipoId($Conex){

    $select = "SELECT tipo_identificacion_id AS value,nombre AS text FROM tipo_identificacion ORDER BY nombre ASC";
	$result =  $this  -> DbFetchAll($select,$Conex,false);

    return $result;
	
  }
	 
  public function getClientes($Conex){
	  
	  $select = "SELECT cliente_id AS value,(SELECT CONCAT_WS(' ',razon_social,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido) FROM tercero WHERE tercero_id = c.tercero_id) AS text FROM cliente c WHERE estado = 'D' 
	             ORDER BY nombre_cliente ASC";
				 
	  $result = $this -> DbFetchAll($select,$Conex);
	  
	  return $result;	  
	  
  }	 
	 
   
   public function selectRemitenteDestinatario($Conex){
      
      $remitente_destinatario_id = $this -> requestDataForQuery('remitente_destinatario_id','integer');
      $numero_identificacion = $this -> requestDataForQuery('numero_identificacion','integer');
      
      if ($remitente_destinatario_id != 'NULL'){
	    $Query = "SELECT r.*,(SELECT nombre FROM ubicacion WHERE ubicacion_id = r.ubicacion_id) AS ubicacion FROM remitente_destinatario r WHERE remitente_destinatario_id=$remitente_destinatario_id";
      }
      elseif($numero_identificacion!='NULL'){
	      $Query = "SELECT (SELECT CONCAT_WS(' ',razon_social,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido) FROM 
	      tercero WHERE tercero_id = t.tercero_id) AS nombre,numero_identificacion,digito_verificacion,tipo_identificacion_id,direccion,telefono,ubicacion_id,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id = t.ubicacion_id) AS ubicacion,'D' AS tipo FROM tercero t WHERE 
	      numero_identificacion=$numero_identificacion";
      }
	 
      $result = $this -> DbFetchAll($Query,$Conex,$ErrDb = false);
   
      return $result;
      
   }
   
   public function destinatarioExists($valor,$cliente_id,$Conex){
   
     $select = "SELECT * FROM remitente_destinatario WHERE cliente_id = $cliente_id AND tipo = 'D' AND TRIM(nombre) LIKE TRIM('$valor')";
     $result = $this -> DbFetchAll($select,$Conex,true);
   
     if(count($result) > 0){
	   return true;
	 }else{
	      return false;
	   }
   
   }   
   
   public function getQueryRemitenteDestinatarioGrid(){
	   	   
     $Query = "SELECT (SELECT concat_ws(' ',razon_social,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido) FROM tercero WHERE tercero_id = (SELECT tercero_id FROM cliente WHERE cliente_id = T.cliente_id)) AS cliente,(SELECT nombre FROM tipo_identificacion WHERE tipo_identificacion_id = T.tipo_identificacion_id) 
				AS tipo_identificacion_id,numero_identificacion,digito_verificacion,nombre,direccion,telefono,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id = T.ubicacion_id) AS ubicacion,estado
			   FROM remitente_destinatario T  WHERE tipo = 'D' ORDER BY T.nombre ASC";
   
     return $Query;
   }
   

}


?>