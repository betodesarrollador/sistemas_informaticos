<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class CamposArchivoClienteModel extends Db{

  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  
  public function setCamposArchivo($camposArchivo,$cliente_id,$Conex){
  
   $this -> Begin($Conex);
   
     $select                 = "SELECT COUNT(*) AS num_campos FROM campos_archivo_cliente WHERE cliente_id = $cliente_id";
     $campos_archivo_cliente = $this -> DbFetchAll($select,$Conex);
     $campos_archivo_cliente = 	$campos_archivo_cliente[0]['num_campos'];
     
     if($campos_archivo_cliente > 0){
     
       $delete = "DELETE FROM campos_archivo_cliente WHERE cliente_id = $cliente_id";
       $this -> query($delete,$Conex,true);

       if($this -> GetNumError() > 0){
         return false;
       }

     }
  
     $campos_archivo_cliente_id = $this -> DbgetMaxConsecutive("campos_archivo_cliente","campos_archivo_cliente_id",$Conex,false,1);
         
     foreach($camposArchivo[0] as $llave => $valor){
           
       $insert = "INSERT INTO campos_archivo_cliente (campos_archivo_cliente_id,cliente_id,nombre_campo) 
	   VALUES ($campos_archivo_cliente_id,$cliente_id,TRIM('$valor'));";
       
       $this -> query($insert,$Conex,true);

       if($this -> GetNumError() > 0){
         return false;
       }
       
       $campos_archivo_cliente_id++;
            
     }
     
   
   $this -> Commit($Conex);
  
  }


//LISTA MENU

  public function getClientes($Conex){
	  
	  $select = "SELECT cliente_id AS value,(SELECT CONCAT_WS(' ',razon_social,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido) FROM tercero WHERE tercero_id = c.tercero_id) AS text FROM cliente c WHERE estado = 'D'  
	             ORDER BY nombre_cliente ASC";
				 
	  $result = $this -> DbFetchAll($select,$Conex);
	  
	  return $result;	  
	  
  }
  
  public function saveDetalleCamposArchivoCliente($cliente_id,$camposArchivo,$Conex){
  
     $this -> Begin($Conex);
                            
       $camposArchivo = array_values($camposArchivo);       
                     
       for($i = 0; $i < count($camposArchivo); $i++){
       
         $campos_archivo_cliente_id   = $camposArchivo[$i]['campos_archivo_cliente_id'];
         $campos_id                  .= "$campos_archivo_cliente_id,";         
         $nombre_campo                = $camposArchivo[$i]['nombre_campo'];
         $campos_archivo_solicitud_id = $camposArchivo[$i]['campos_archivo_solicitud_id'];
         
         $update = "UPDATE campos_archivo_cliente SET nombre_campo = '$nombre_campo',campos_archivo_solicitud_id = $campos_archivo_solicitud_id WHERE campos_archivo_cliente_id = $campos_archivo_cliente_id";

         $this -> query($update,$Conex,true);

         if($this -> GetNumError() > 0){
           return false;
         }     
       
       }
       
       $campos_id = substr($campos_id,0,strlen($campos_id) - 1);
       
       $delete = "DELETE FROM campos_archivo_cliente WHERE cliente_id = $cliente_id AND campos_archivo_cliente_id NOT IN ($campos_id)";
       
       $this -> query($delete,$Conex,true);

       if($this -> GetNumError() > 0){
         return false;
       }     
     
     
     $this -> Commit($Conex);
  
     return true;
     
  }

   
}



?>