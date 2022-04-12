<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class UnidadesVolumenModel extends Db{

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
   
     $select         = "SELECT COUNT(*) AS num_campos FROM medida_cliente WHERE cliente_id = $cliente_id";
     $medida_cliente = $this -> DbFetchAll($select,$Conex);
     $medida_cliente = 	$medida_cliente[0]['num_campos'];
     
     if($medida_cliente > 0){
     
       $delete = "DELETE FROM medida_cliente WHERE cliente_id = $cliente_id";
       $this -> query($delete,$Conex,true);

       if($this -> GetNumError() > 0){
         return false;
       }

     }
  
     $medida_cliente_id = $this -> DbgetMaxConsecutive("medida_cliente","medida_cliente_id",$Conex,false,1);
         
     foreach($camposArchivo[0] as $llave => $valor){
           
       $insert = "INSERT INTO medida_cliente (medida_cliente_id,cliente_id,medida) VALUES ($medida_cliente_id,$cliente_id,'$valor');";
       
       $this -> query($insert,$Conex,true);

       if($this -> GetNumError() > 0){
         return false;
       }
       
       $medida_cliente_id++;
            
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
  
  public function saveDetalleUnidadesVolumen($cliente_id,$camposArchivo,$Conex){
  
     $this -> Begin($Conex);
     
          
       for($i = 1; $i <= count($camposArchivo); $i++){
       
         $medida_cliente_id           = $camposArchivo[$i]['medida_cliente_id'];
         $medidas_id                 .= "$medida_cliente_id,";         
         $medida                      = $camposArchivo[$i]['medida'];
         $medida_id                   = $camposArchivo[$i]['medida_id'];
         
         $update = "UPDATE medida_cliente SET medida = '$medida',medida_id = $medida_id WHERE medida_cliente_id = $medida_cliente_id";

         $this -> query($update,$Conex,true);

         if($this -> GetNumError() > 0){
           return false;
         }     
       
       }
       
       $medidas_id = substr($medidas_id,0,strlen($medidas_id) - 1);
       
       $delete = "DELETE FROM medida_cliente WHERE cliente_id = $cliente_id AND medida_cliente_id NOT IN ($medidas_id)";
       
       $this -> query($delete,$Conex,true);

       if($this -> GetNumError() > 0){
         return false;
       }     
     
     
     $this -> Commit($Conex);
  
  
  }

   
}



?>